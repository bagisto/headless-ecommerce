<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductRepository;
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
        protected ProductRepository $productRepository,
        protected ProductReviewRepository $productReviewRepository,
        protected ProductReviewAttachmentRepository $productReviewAttachmentRepository
    ) {
        Auth::setDefaultDriver('api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        if (
            ! core()->getConfigData('catalog.products.review.customer_review')
            || (
                ! core()->getConfigData('catalog.products.review.guest_review')
                && ! auth()->guard('api')->user()
            )
        ) {
            return [
                'success' => false,
                'message' => trans('bagisto_graphql::app.shop.customers.reviews.not-auth'),
            ];
        }

        bagisto_graphql()->validate($args, [
            'comment'       => 'required',
            'rating'        => 'required|numeric|min:1|max:5',
            'title'         => 'required',
            'product_id'    => 'required',
            'attachments'   => 'array',
            'attachments.*' => 'nullable|file|mimetypes:image/*,video/*',
        ]);

        try {
            if (auth()->check()) {
                $customer = auth()->user();

                $args = array_merge($args, [
                    'customer_id' => $customer->id,
                    'name'        => $customer->name,
                ]);
            }

            $product = $this->productRepository->find($args['product_id']);

            if (! $product) {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.reviews.product-not-found'));
            }

            $args['status'] = 'pending';

            Event::dispatch('customer.review.create.before', $args['product_id']);

            $review = $this->productReviewRepository->create($args);

            $this->productReviewAttachmentRepository->upload($args['attachments'] ?? [], $review);

            Event::dispatch('customer.review.create.after', $review);

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
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
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
     * @return array
     *
     * @throws CustomException
     */
    public function deleteAll(mixed $rootValue, array $args, GraphQLContext $context)
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
                'status'  => $customerReviews->count() ? true : false,
                'message' => $customerReviews->count()
                    ? trans('bagisto_graphql::app.shop.customers.reviews.mass-delete-success')
                    : trans('bagisto_graphql::app.shop.customers.reviews.not-found'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
