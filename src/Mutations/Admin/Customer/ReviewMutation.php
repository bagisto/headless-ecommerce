<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Product\Repositories\ProductReviewRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class ReviewMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ProductReviewRepository $productReviewRepository)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (
            empty($args['id'])
            || empty($args['status'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $validator = Validator::make($args, [
            'status' => 'required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $review = $this->productReviewRepository->find($id);

        if (! $review) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.reviews.not-found'));
        }

        try {
            Event::dispatch('customer.customer.update.before');

            $review = $this->productReviewRepository->update([
                'status' => $args['status'],
            ], $id);

            Event::dispatch('customer.customer.update.after', $review);

            $review->success = trans('bagisto_graphql::app.admin.customers.reviews.update-success');

            return $review;
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
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $review = $this->productReviewRepository->find($id);

        if (! $review) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.reviews.not-found'));
        }

        try {
            Event::dispatch('customer.review.delete.before', $id);

            $this->productReviewRepository->delete($id);

            Event::dispatch('customer.review.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.reviews.delete-success')];
        } catch(\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
