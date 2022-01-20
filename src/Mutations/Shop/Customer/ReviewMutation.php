<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Exception;
use Webkul\Customer\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\Customer\CustomException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Webkul\Product\Repositories\ProductReviewRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ReviewMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * ProductReviewRepository object
     *
     * @var \Webkul\Product\Repositories\ProductReviewRepository
     */
    protected $productReviewRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Product\Repositories\ProductReviewRepository  $productReviewRepository
     * @return void
     */
    public function __construct(
        ProductReviewRepository $productReviewRepository
    )
    {
        $this->guard = 'api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
        
        $this->productReviewRepository = $productReviewRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        
        $validator = \Validator::make($data, [
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
                $data['name']    = $customer->first_name . ' ' . $customer->last_name;;
            }
    
            $data['status'] = 'pending';
    
            $review = $this->productReviewRepository->create($data);

            return [
                'success'   => trans('shop::app.response.submit-success', ['name' => 'Product Review']),
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
        Log::error('Remove Review: ' . json_encode($args));
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request parameter.'
            );
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new CustomException(
                trans('bagisto_graphql::app.admin.response.error-invalid-parameter'),
                'Invalid request header parameter.'
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
}