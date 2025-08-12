<?php

namespace Webkul\GraphQLAPI\Repositories;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Eloquent\Repository;
use Webkul\GraphQLAPI\Contracts\PushNotification;
use Webkul\Product\Repositories\ProductRepository;

class NotificationRepository extends Repository
{
    /**
     * @var string
     */
    public const SCOPE_URL = 'https://www.googleapis.com/auth/firebase.messaging';

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository,
        protected NotificationTranslationRepository $notificationTranslationRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return PushNotification::class;
    }

    /**
     * Create notification.
     *
     * @return \Webkul\GraphQLAPI\Contracts\Notification
     */
    public function create(array $data)
    {
        $notification = $this->model->create($data);

        $translations = [];

        foreach (core()->getAllChannels() as $channel) {
            if (! in_array($channel->code, $data['channels'])) {
                continue;
            }

            foreach ($channel->locales as $locale) {
                $translations[] = [
                    'title'                => $data['title'],
                    'content'              => $data['content'],
                    'channel'              => $channel->code,
                    'locale'               => $locale->code,
                    'push_notification_id' => $notification->id,
                ];
            }
        }

        $this->notificationTranslationRepository->insert($translations);

        $this->uploadImages($data, $notification);

        return $notification;
    }

    /**
     * Update notification.
     *
     * @param  int  $id
     * @param  string  $attribute
     * @return \Webkul\GraphQLAPI\Contracts\Notification
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        $notification = $this->find($id);

        $notification->update($data);

        $this->notificationTranslationRepository->updateOrCreate([
            'channel'              => $data['channel'],
            'locale'               => $data['locale'],
            'push_notification_id' => $id,
        ], [
            'title'   => $data['title'],
            'content' => $data['content'],
        ]);

        $this->notificationTranslationRepository->whereNotIn('channel', $data['channels'])
            ->where('push_notification_id', $id)
            ->delete();

        $this->uploadImages($data, $notification);

        return $notification;
    }

    /**
     * Upload notification's images.
     *
     * @param  array  $data
     * @param  \Webkul\GraphQLAPI\Contracts\Notification  $notification
     * @param  string  $type
     * @return void
     */
    public function uploadImages($data, $notification, $type = 'image')
    {
        if (isset($data[$type])) {
            foreach ($data[$type] as $imageId => $image) {
                $file = "$type.$imageId";

                $dir = "notification/images/$notification->id";

                if (request()->hasFile($file)) {
                    if ($notification->{$type}) {
                        Storage::delete($notification->{$type});
                    }

                    $notification->{$type} = request()->file($file)->store($dir);

                    $notification->save();
                }
            }
        } else {
            if ($notification->{$type}) {
                Storage::delete($notification->{$type});
            }

            $notification->{$type} = null;

            $notification->save();
        }
    }

    /**
     * Prepare data for push notification in device.
     *
     * @param  \Webkul\GraphQLAPI\Contracts\Notification  $notification
     * @return Response
     */
    public function prepareNotification($notification)
    {
        $notificationTranslation = $notification->translations()->where([
            ['channel', '=', core()->getRequestedChannelCode()],
            ['locale', '=', core()->getRequestedLocaleCode()],
        ])->first();

        if ($notificationTranslation) {
            $notification->title = $notificationTranslation->title;
            $notification->content = $notificationTranslation->content;
        }

        $fieldData = [
            'banner_url'       => Storage::url($notification->image),
            'id'               => (string) $notification->id,
            'body'             => $notification->content,
            'sound'            => 'default',
            'title'            => $notification->title,
            'message'          => $notification->content,
            'notificationType' => $notification->type,
        ];

        switch ($notification->type) {
            case 'product':
                $product = $this->productRepository->findOrFail($notification->product_category_id);

                $extraData = [
                    'click_action' => route('shop.product_or_category.index', $product->url_key),
                    'productName'  => $product->name ?? '',
                    'productId'    => (string) $product->id ?? '',
                ];
                break;

            case 'category':
                $category = $this->categoryRepository->findOrFail($notification->product_category_id);

                $extraData = [
                    'click_action' => route('shop.product_or_category.index', $category->slug),
                    'categoryName' => $category->name ?? '',
                    'categoryId'   => (string) $category->id ?? '',
                ];
                break;

            case 'others':
                $extraData = [
                    'click_action' => route('shop.home.index'),
                ];
                break;
        }

        $fieldData = array_merge($fieldData, $extraData);

        return $this->sendNotification($fieldData, $notification->toArray());
    }

    /**
     * Send the notification to the device.
     *
     * @param  array  $fieldData
     * @param  array  $data
     * @return Response
     */
    public function sendNotification($fieldData, $data = [])
    {
        $projectId = json_decode(core()->getConfigData('general.api.pushnotification.private_key'))?->project_id;

        if (! $projectId) {
            return;
        }

        $fields['message'] = [
            'data'         => $fieldData,
            'notification' => [
                'body'  => $data['content'],
                'title' => $data['title'],
            ],
        ];

        if (
            isset($fieldData['type'])
            && $fieldData['type'] == 'order'
        ) {
            $fields['message']['token'] = bagisto_graphql()->authorize()?->device_token;
        } else {
            $fields['message']['topic'] = core()->getConfigData('general.api.pushnotification.notification_topic');
        }

        $headers = [
            'Content-Type:application/json',
            "Authorization: Bearer {$this->getAccessToken()}",
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            $result = curl_exec($ch);

            curl_close($ch);

            Log::info('sendNotification: ', [
                'response' => json_decode($result),
            ]);

            return json_decode($result);
        } catch (\Exception $e) {
            session()->flash('error', $e);

            Log::error('sendNotification Error: ', $e->getMessage());
        }
    }

    /**
     * To generate token
     *
     * @return Response
     */
    public function getAccessToken()
    {
        $privateKeyContent = json_decode(core()->getConfigData('general.api.pushnotification.private_key'));

        $privateKey = str_replace('\n', "\n", $privateKeyContent->private_key);

        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'RS256',
        ]);

        $payload = json_encode([
            'iss'   => $privateKeyContent->client_email,
            'scope' => self::SCOPE_URL,
            'aud'   => $privateKeyContent->token_uri,
            'exp'   => time() + 3600,
            'iat'   => time() - 60,
        ]);

        $base64UrlHeader = $this->base64UrlEncode($header);

        $base64UrlPayload = $this->base64UrlEncode($payload);

        openssl_sign("$base64UrlHeader.$base64UrlPayload", $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwt = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

        $client = new Client;

        try {
            $response = $client->post($privateKeyContent->token_uri, [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion'  => $jwt,
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            return json_decode($response->getBody(), true)['access_token'];
        } catch (\Exception $e) {
            session()->flash('error', $e);
        }
    }

    /**
     * Encode a string into a base64 URL-safe format.
     *
     * @param  string  $data
     * @return string
     */
    public function base64UrlEncode($data)
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($data)
        );
    }
}
