<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use App\Http\Controllers\Controller;
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
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function unSubscribe(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $subscriber = $this->subscriptionRepository->find($args['id']);

        if (! $subscriber) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.not-found'));
        }

        try {
            $subscriber = $this->subscriptionRepository->update([
                'is_subscribed' => 0,
            ], $subscriber->id);

            return [
                'success'    => true,
                'message'    => trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.unsubscribe-success'),
                'subscriber' => $subscriber,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * unsubscribe the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $subscription = $this->subscriptionRepository->find($args['id']);

        if (! $subscription) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.not-found'));
        }

        try {
            $subscription->delete();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.subscriptions.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
