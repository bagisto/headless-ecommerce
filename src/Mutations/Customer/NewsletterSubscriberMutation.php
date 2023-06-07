<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Shop\Mail\SubscriptionEmail;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class NewsletterSubscriberMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\SubscribersListRepository  $subscriptionRepository
     * @return void
     */
    public function __construct(protected SubscribersListRepository $subscriptionRepository)
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Subscribe a newly resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
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
            return $alreadySubscribed->count() > 0 ? 0 : 1;
        };

        if ( $unique() ) {
            $token = uniqid();

            $subscriptionData = [
                'email' => $data['email'],
                'token' => $token,
            ];

            try {
                Mail::queue(new SubscriptionEmail($subscriptionData));
                
                Event::dispatch('customer.subscribe.before');
                
                $subscription = $this->subscriptionRepository->create([
                    'email'         => $data['email'],
                    'channel_id'    => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token'         => $token,
                ]);

                if ( isset($subscription->id)) {
                    Event::dispatch('customer.subscribe.after', $subscription);
                    
                    return $subscription;
                
                } else {
                    throw new Exception(trans('shop::app.subscription.not-subscribed'));
                }
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

            if ( isset($subscriber->id) && isset($subscriber->is_subscribed)) {
                
                Event::dispatch('customer.subscribe.update.before');
                
                if ( $subscriber->is_subscribed == 1 && $subscriber->update(['is_subscribed' => 0])) {

                    Event::dispatch('customer.subscribe.update.after', $subscriber);
                    $subscriber->success = trans('shop::app.subscription.unsubscribed');
                    
                    return $subscriber;
                } else {
                    throw new Exception(trans('shop::app.subscription.already-unsub'));
                }
            } else {
                throw new Exception(trans('bagisto_graphql::app.admin.customer.no-subscriber-found'));
            }
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
        if (! isset($args['email']) || (isset($args['email']) && !$args['email'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $subscriber = $this->subscriptionRepository->findOneByField('email', $args['email']);

        try {

            if ( isset($subscriber->id)) {
                Event::dispatch('customer.subscriber.delete.before', $subscriber->id);

                $this->subscriptionRepository->delete($subscriber->id);

                Event::dispatch('customer.customer.delete.after', $subscriber->id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Subscriber'])];
            
            } else {
                throw new Exception(trans('admin::app.response.order-pending', ['name' => 'Subscriber']));
            }
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Subscriber']));
        }
    }
}
