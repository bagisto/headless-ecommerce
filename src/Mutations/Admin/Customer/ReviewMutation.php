<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Product\Repositories\ProductReviewRepository;

class ReviewMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ProductReviewRepository $productReviewRepository) {}

    /**
     * Update the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'status' => 'required',
        ]);

        $review = $this->productReviewRepository->find($args['id']);

        if (! $review) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.reviews.not-found'));
        }

        try {
            Event::dispatch('customer.review.update.before', $review->id);

            $review = $this->productReviewRepository->update([
                'status' => $args['status'],
            ], $review->id);

            Event::dispatch('customer.review.update.after', $review);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.reviews.update-success'),
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
        $review = $this->productReviewRepository->find($args['id']);

        if (! $review) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.reviews.not-found'));
        }

        try {
            Event::dispatch('customer.review.delete.before', $args['id']);

            $review->delete();

            Event::dispatch('customer.review.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.reviews.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
