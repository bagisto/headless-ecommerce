<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class PushNotificationMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected NotificationRepository $notificationRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $channels = core()->getAllChannels()->pluck('code')->toArray();

        bagisto_graphql()->validate($args, [
            'title'               => ['required'],
            'content'             => ['required'],
            'type'                => ['required'],
            'channels'            => ['required', 'array', 'min:1', 'in:'.implode(',', $channels)],
            'product_category_id' => ['required_if:type,product,category', 'integer'],
            'status'              => ['boolean'],
        ]);

        try {
            $imageUrl = $args['image'] ?? '';

            if (isset($args['image'])) {
                unset($args['image']);
            }

            Event::dispatch('settings.notification.create.before');

            $notification = $this->notificationRepository->create($args);

            Event::dispatch('settings.notification.create.after', $notification);

            bagisto_graphql()->uploadImage($notification, $imageUrl, 'notification/', 'image');

            return [
                'success'           => true,
                'message'           => trans('bagisto_graphql::app.admin.settings.notification.create-success'),
                'push_notification' => $notification,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $channels = core()->getAllChannels()->pluck('code')->toArray();

        bagisto_graphql()->validate($args, [
            'title'               => ['required'],
            'content'             => ['required'],
            'type'                => ['required'],
            'channels'            => ['required', 'array', 'min:1', 'in:'.implode(',', $channels)],
            'product_category_id' => ['required_if:type,product,category', 'integer'],
            'status'              => ['boolean'],
            'channel'             => ['required', 'in:'.implode(',', $channels)],
            'locale'              => ['required'],
        ]);

        $notification = $this->notificationRepository->find($args['id']);

        if (! $notification) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.notification.not-found'));
        }

        try {
            $imageUrl = '';

            if (isset($args['image'])) {
                $imageUrl = $args['image'];

                unset($args['image']);
            }

            Event::dispatch('settings.notification.update.before', $notification->id);

            $notification = $this->notificationRepository->update($args, $notification->id);

            Event::dispatch('settings.notification.update.after', $notification);

            bagisto_graphql()->uploadImage($notification, $imageUrl, 'notification/', 'image');

            return [
                'success'           => true,
                'message'           => trans('bagisto_graphql::app.admin.settings.notification.update-success'),
                'push_notification' => $notification,
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
        $notification = $this->notificationRepository->find($args['id']);

        if (! $notification) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.notification.not-found'));
        }

        try {
            Event::dispatch('settings.notification.delete.before', $args['id']);

            $notification->delete();

            Event::dispatch('settings.notification.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.notification.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Send notification.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function sendNotification(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $notification = $this->notificationRepository->find($args['id']);

        if (! $notification) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.notification.not-found'));
        }

        if (is_null(core()->getConfigData('general.api.pushnotification.private_key'))) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.notification.configuration-error'));
        }

        $result = $this->notificationRepository->prepareNotification($notification);

        if (isset($result->message_id)) {
            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.notification.edit.notification-send-success'),
            ];
        } else {
            $message = $result;

            if (
                gettype($result) == 'array'
                && ! empty($result['error'])
            ) {
                $message = $result['error'];
            } elseif (isset($result->error)) {
                $message = $result->error;
            }
        }

        return [
            'success' => false,
            'message' => $message,
        ];
    }
}
