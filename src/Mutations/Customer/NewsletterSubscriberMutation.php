<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Core\Repositories\SubscribersListRepository;

class NewsletterSubscriberMutation extends Controller
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
     * @param  \Webkul\Core\Repositories\SubscribersListRepository  $subscriptionRepository
     * @return void
     */
    public function __construct(protected SubscribersListRepository $subscriptionRepository)
    {
        $this->guard = 'admin-api';
    }

    /**
     * Subscribe a newly resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $unique = 0;

        $alreadySubscribed = $this->subscriptionRepository->findWhere(['email' => $data['email']]);

        $unique = function () use ($alreadySubscribed) {
            return $alreadySubscribed->count();
        };

        if ($unique) {
            $token = uniqid();

            try {
                Event::dispatch('customer.subscribe.before');

                $subscription = $this->subscriptionRepository->create([
                    'email'         => $data['email'],
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => $token,
                ]);

                if (isset($subscription->id)) {
                    Event::dispatch('customer.subscribe.after', $subscription);

                    return $subscription;
                }

                throw new Exception(trans('shop::app.subscription.not-subscribed'));
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    /**
     * unsubscribe the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($rootValue, array $args, GraphQLContext $context)
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $validator = Validator::make($args, [
            'token' => 'string|required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $subscriber = $this->subscriptionRepository->findOneByField('token', $args['token']);

            if (! $subscriber) {
                throw new Exception(trans('bagisto_graphql::app.admin.customer.no-subscriber-found'));
            }

            if ($subscriber->is_subscribed == 1) {
                throw new Exception(trans('shop::app.subscription.already-unsub'));
            }

            Event::dispatch('customer.subscribe.update.before');

            $subscriber->update(['is_subscribed' => 0]);

            Event::dispatch('customer.subscribe.update.after', $subscriber);

            $subscriber->success = trans('shop::app.subscription.unsubscribed');

            return $subscriber;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['email'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $subscriber = $this->subscriptionRepository->findOneByField('email', $args['email']);

        try {
            if ($subscriber) {
                Event::dispatch('customer.subscriber.delete.before', $subscriber->id);

                $this->subscriptionRepository->delete($subscriber->id);

                Event::dispatch('customer.customer.delete.after', $subscriber->id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Subscriber'])];

            }

            throw new Exception(trans('bagisto_graphql::app.admin.customer.no-subscriber-found'));
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Subscriber']));
        }
    }
}
