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
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function get($rootValue, array $args, GraphQLContext $context)
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'email' => 'email|required',
        ]);

        $email = $args['email'];

        $subscription = $this->subscriptionRepository->findOneByField(['email' => $email]);

        if ($subscription?->is_subscribed) {
            throw new CustomException(trans('bagisto_graphql::app.shop.subscription.already'));
        }

        try {
            Event::dispatch('customer.subscribe.before');

            $customer = $this->customerRepository->findOneByField('email', $email);

            $subscription = $this->subscriptionRepository->updateOrCreate(
                ['email' => $email],
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

            $subscription->success = trans('bagisto_graphql::app.shop.subscription.subscribe-success');

            return $subscription;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * unsubscribe the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
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
