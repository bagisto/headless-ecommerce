<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Common;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Shop\Http\Controllers\Controller;

class NotificationMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected NotificationRepository $notificationRepository) {}

    /**
     * Send notificaiton to the app user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function send($rootValue, array $args, GraphQLContext $context)
    {
        $data = $args['input'];

        bagisto_graphql()->validate($data, [
            'id' => 'required|numeric',
        ]);

        try {
            $notification = $this->notificationRepository->findOrFail($data['id']);

            $result = $this->notificationRepository->prepareNotification($notification);

            if (isset($result->message_id)) {
                return [
                    'success'    => true,
                    'message'    => trans('bagisto_graphql::app.admin.alerts.notifications.sended-successfully'),
                    'message_id' => $result->message_id,
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

                return [
                    'success'    => false,
                    'message'    => $message,
                    'message_id' => null,
                ];
            }
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
