<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Pagination\Paginator;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\Product\Repositories\ProductReviewRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;

class ReviewMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductReviewRepository  $productReviewRepository
     * @return void
     */
    public function __construct(
       protected ProductReviewRepository $productReviewRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Returns loggedin customer's reviews data.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews($rootValue, array $args , GraphQLContext $context)
    {
        $params = isset($args['input']) ? $args['input'] : (isset($args['id']) ? $args : []);

        if (bagisto_graphql()->guard($this->guard)->check()) {
            $params['customer_id'] = bagisto_graphql()->guard($this->guard)->user()->id;
        }

        $currentPage = isset($params['page']) ? $params['page'] : 1;
        
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $reviews = app(ProductReviewRepository::class)->scopeQuery(function ($query) use ($params) {
            $channel = isset($params['channel']) ?: (core()->getCurrentChannelCode() ?: core()->getDefaultChannelCode());

            $locale = isset($params['locale']) ?: app()->getLocale();
                
            $qb = $query->distinct()
                ->addSelect('product_reviews.*')
                ->addSelect('product_flat.name as product_name')
                ->leftJoin('product_flat', 'product_reviews.product_id', '=', 'product_flat.product_id')
                ->where('product_flat.channel', $channel)
                ->where('product_flat.locale', $locale);

            if (! empty($params['id'])) {
                $qb->where('product_reviews.id', $params['id']);
            }

            if (! empty($params['title'])) {
                $qb->where('product_reviews.title', 'like', '%' . urldecode($params['title']) . '%');
            }
            
            if (! empty($params['rating'])) {
                $qb->where('product_reviews.rating', $params['rating']);
            }
    
            if (! empty($params['customer_id'])) {
                $qb->where('product_reviews.customer_id', $params['customer_id']);
            }

            if (! empty($params['customer_name'])) {
                $qb->where('product_reviews.name', 'like', '%' . urldecode($params['customer_name']) . '%');
            }

            if (! empty($params['product_name'])) {
                $qb->where('product_flat.name', 'like', '%' . urldecode($params['product_name']) . '%');
            }
            
            if (! empty($params['product_id'])) {
                $qb->where('product_reviews.product_id', $params['product_id']);
            }

            if (! empty($params['status'])) {
                $qb->where('product_reviews.status', 'like', '%' . urldecode($params['status']) . '%');
            }

            return $qb;
        });

        if ( isset($args['id'])) {
            $reviews = $reviews->first();
        } else {
            $reviews = $reviews->paginate( isset($params['limit']) ? $params['limit'] : 10);
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
        $data = $args['input'];
        
        $validator = Validator::make($data, [
            'comment'       => 'required',
            'rating'        => 'required|numeric|min:1|max:5',
            'title'         => 'required',
            'product_id'    => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (bagisto_graphql()->guard($this->guard)->check()) {
                $customer = bagisto_graphql()->guard($this->guard)->user();
                $data['customer_id']    = $customer->id;
                $data['name']    = $customer->name;
            }
    
            $data['status'] = 'pending';
    
            $review = $this->productReviewRepository->create($data);

            return [
                'success'   => trans('bagisto_graphql::app.shop.response.review-create-success'),
                'review'    => $review
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }

        $id = $args['id'];
        
        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();

            $customerReview = $this->productReviewRepository->findOrFail($id);
            
            if ( isset($customerReview->customer_id) && $customerReview->customer_id !== $customer->id ) {
                throw new CustomException(
                    trans('bagisto_graphql::app.shop.customer.not-authorized'),
                    'You are not authorized to perform this action.'
                );
            }
        
            Event::dispatch('customer.review.delete.before', $id);

            $this->productReviewRepository->delete($id);

            Event::dispatch('customer.review.delete.after', $id);
            
            return [
                'status'    => (isset($customerReview->id)) ? true : false,
                'reviews'   => $customer->all_reviews,
                'message'   => ($customerReview->id) ? trans('admin::app.response.delete-success', ['name' => 'Customer\'s Review']) : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Review'])
            ];
        } catch (Exception $e) {
            throw new CustomException(
                $e->getMessage(),
                'Review remove Failed.'
            );
        }
    }

    /**
     * Remove all resource based on condition from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->guard($this->guard)->check() ) {
            throw new CustomException(
                trans('bagisto_graphql::app.shop.customer.no-login-customer'),
                'Customer Not Login.'
            );
        }
        
        try {
            $customer = bagisto_graphql()->guard($this->guard)->user();
            
            $customerReviews = $customer->all_reviews;

            foreach ($customerReviews as $review) {
                
                Event::dispatch('customer.review.delete.before', $review->id);
                
                $this->productReviewRepository->delete($review->id);

                Event::dispatch('customer.review.delete.after', $review->id);
            }
            
            return [
                'status'    => $customerReviews->count() ? true : false,
                'message'   => $customerReviews->count() ? trans('shop::app.reviews.delete-all') : trans('bagisto_graphql::app.shop.response.not-found', ['name'   => 'Review'])
            ];
        } catch (Exception $e) {
            throw new CustomException($e->getMessage(), 'All review remove Failed.');
        }
    }
}