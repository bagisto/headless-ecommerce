<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function get($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['email'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $subscriber = $this->subscriptionRepository->findOneByField('email', $args['email']);

        try {
            if ($subscriber) {
                return $subscriber;
            }

            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.no-subscriber-found'));
        } catch(Exception $e) {
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
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $alreadySubscribed = $this->subscriptionRepository->findOneByField('email', $data['email']);
        
        if (
            $alreadySubscribed
            && $alreadySubscribed->is_subscribed
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.already-subscriber'));
        }

        try {
            Event::dispatch('customer.subscribe.before');

            $subscription = $this->subscriptionRepository->create([
                'email'         => $data['email'],
                'channel_id'    => core()->getCurrentChannel()->id,
                'is_subscribed' => 1,
                'token'         => uniqid(),
                'customer_id'   => bagisto_graphql()->guard('api')->user()->id
            ]);

            if (isset($subscription->id)) {
                Event::dispatch('customer.subscribe.after', $subscription);
                
                $subscription->success = trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.subscribed-success');
                
                return $subscription;
            }

            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.not-subscribed'));
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (empty($args['token'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $validator = Validator::make($args, [
            'token' => 'string|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $subscriber = $this->subscriptionRepository->findOneByField('token', $args['token']);

            if (! $subscriber) {
                throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.no-subscriber-found'));
            }

            if (! $subscriber->is_subscribed) {
                throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.already-unsubscribed'));
            }

            Event::dispatch('customer.subscribe.update.before');

            $subscriber->update(['is_subscribed' => 0]);

            Event::dispatch('customer.subscribe.update.after', $subscriber);

            $subscriber->success = trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.unsubscribed');

            return $subscriber;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $subscriber = $this->subscriptionRepository->findOneByField('email', $args['email']);

        try {
            if (! $subscriber) {
                throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.no-subscriber-found'));
            }

            Event::dispatch('customer.subscriber.delete.before', $subscriber->id);

            $this->subscriptionRepository->delete($subscriber->id);

            Event::dispatch('customer.customer.delete.after', $subscriber->id);

            return ['success' => trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.delete-success')];
        } catch(Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
