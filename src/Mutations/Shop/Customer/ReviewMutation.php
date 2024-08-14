<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductReviewAttachmentRepository;
use Webkul\Product\Repositories\ProductReviewRepository;

class ReviewMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductReviewRepository $productReviewRepository,
        protected ProductReviewAttachmentRepository $productReviewAttachmentRepository
    ) {
        Auth::setDefaultDriver('api');

        $this->middleware('auth:api');
    }

    /**
     * Returns loggedin customer's reviews data.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews($rootValue, array $args, GraphQLContext $context)
    {
        $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

        if (auth()->check()) {
            $params['customer_id'] = auth()->user()->id;
        }

        $currentPage = isset($params['page']) ? $params['page'] : 1;

        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $reviews = app(ProductReviewRepository::class)->scopeQuery(function ($query) use ($params) {
            $channel = isset($params['channel']) ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = isset($params['locale']) ?: app()->getLocale();

            return $query->distinct()
                ->addSelect('product_reviews.*')
                ->addSelect('product_flat.name as product_name')
                ->leftJoin('product_flat', 'product_reviews.product_id', '=', 'product_flat.product_id')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale)
                ->when(! empty($params['id']), function ($qb) use ($params) {
                    $qb->where('product_reviews.id', $params['id']);
                })
                ->when(! empty($params['title']), function ($qb) use ($params) {
                    $qb->where('product_reviews.title', 'like', '%'.urldecode($params['title']).'%');
                })
                ->when(! empty($params['rating']), function ($qb) use ($params) {
                    $qb->where('product_reviews.rating', $params['rating']);
                })
                ->when(! empty($params['customer_id']), function ($qb) use ($params) {
                    $qb->where('product_reviews.customer_id', $params['customer_id']);
                })
                ->when(! empty($params['customer_name']), function ($qb) use ($params) {
                    $qb->where('product_reviews.name', 'like', '%'.urldecode($params['customer_name']).'%');
                })
                ->when(! empty($params['product_name']), function ($qb) use ($params) {
                    $qb->where('product_flat.name', 'like', '%'.urldecode($params['product_name']).'%');
                })
                ->when(! empty($params['product_id']), function ($qb) use ($params) {
                    $qb->where('product_reviews.product_id', $params['product_id']);
                })
                ->when(! empty($params['status']), function ($qb) use ($params) {
                    $qb->where('product_reviews.status', 'like', '%'.urldecode($params['status']).'%');
                });
        });

        if (isset($args['id'])) {
            $reviews = $reviews->first();
        } else {
            $reviews = $reviews->paginate($params['limit'] ?? 10);
        }

        return $reviews;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'comment'     => 'required',
            'rating'      => 'required|numeric|min:1|max:5',
            'title'       => 'required',
            'product_id'  => 'required',
            'attachments' => 'array',
        ]);

        try {
            if (auth()->check()) {
                $customer = auth()->user();

                $args = array_merge($args, [
                    'customer_id' => $customer->id,
                    'name'        => $customer->name,
                ]);
            }

            $args['status'] = 'pending';

            $attachments = $args['attachments'];

            $review = $this->productReviewRepository->create($args);

            foreach ($attachments as $attachment) {
                if (! empty($attachment['upload_type'])) {
                    if ($attachment['upload_type'] == 'base64') {
                        $attachment['save_path'] = "review/{$review->id}";

                        $records = bagisto_graphql()->storeReviewAttachment($attachment);

                        $this->productReviewAttachmentRepository->create([
                            'path'      => $records['path'],
                            'review_id' => $review->id,
                            'type'      => $records['img_details'][0],
                            'mime_type' => $records['img_details'][1],
                        ]);
                    }
                }
            }

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.customers.reviews.create-success'),
                'review'  => $review,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        $review = $this->productReviewRepository->findOneWhere([
            'id'          => $args['id'],
            'customer_id' => $customer->id,
        ]);

        if (! $review) {
            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.customers.reviews.not-found'),
                'reviews' => $customer->reviews,
            ];
        }

        Event::dispatch('customer.review.delete.before', $args['id']);

        $isDeleted = $review->delete();

        Event::dispatch('customer.review.delete.after', $args['id']);

        return [
            'success' => $isDeleted,
            'message' => $isDeleted
                ? trans('bagisto_graphql::app.shop.customers.reviews.delete-success')
                : trans('bagisto_graphql::app.shop.customers.reviews.not-found'),
            'reviews' => $customer->reviews,
        ];
    }

    /**
     * Remove all resource based on condition from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        try {
            $customerReviews = $customer->reviews;

            foreach ($customerReviews as $review) {
                Event::dispatch('customer.review.delete.before', $review->id);

                $this->productReviewRepository->delete($review->id);

                Event::dispatch('customer.review.delete.after', $review->id);
            }

            return [
                'status'    => $customerReviews->count() ? true : false,
                'message'   => $customerReviews->count()
                    ? trans('bagisto_graphql::app.shop.customers.reviews.mass-delete-success')
                    : trans('bagisto_graphql::app.shop.customers.reviews.not-found'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
