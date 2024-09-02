<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class NewsletterSubscriberMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected SubscribersListRepository $subscriptionRepository,
        protected CustomerRepository $customerRepository
    ) {}

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function get(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'email' => 'email|required',
        ]);

        try {
            $subscriber = $this->subscriptionRepository->findOneByField('email', $args['email']);

            if (! $subscriber) {
                throw new CustomException(trans('bagisto_graphql::app.shop.subscription.not-found'));
            }

            if (
                $subscriber->customer?->id != auth()->user()?->id
            ) {
                throw new CustomException(trans('bagisto_graphql::app.shop.subscription.not-authorized'));
            }

            return $subscriber;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Subscribe a newly resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function subscribe(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'email' => 'email|required',
        ]);

        $subscription = $this->subscriptionRepository->findOneByField('email', $args['email']);

        if ($subscription?->is_subscribed) {
            throw new CustomException(trans('bagisto_graphql::app.shop.subscription.already'));
        }

        try {
            Event::dispatch('customer.subscribe.before');

            $customer = $this->customerRepository->findOneByField('email', $args['email']);

            $subscription = $this->subscriptionRepository->updateOrCreate(
                ['email' => $args['email']],
                [
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => uniqid(),
                    'customer_id'   => $customer?->id,
                ]
            );

            if ($customer) {
                $customer->subscribed_to_news_letter = 1;

                $customer->save();
            }

            Event::dispatch('customer.subscribe.after', $subscription);

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.shop.subscription.subscribe-success'),
                'subscription' => $subscription,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Unsubscribe the specified resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'token' => 'string|required',
        ]);

        try {
            $subscriber = $this->subscriptionRepository->findOneByField('token', $args['token']);

            if (! $subscriber) {
                throw new CustomException(trans('bagisto_graphql::app.shop.subscription.not-found'));
            }

            $this->subscriptionRepository->deleteWhere(['token' => $args['token']]);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.shop.subscription.unsubscribe-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
