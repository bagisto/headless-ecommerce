<?php

namespace Webkul\GraphQLAPI\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Illuminate\Container\Container as App;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Category\Repositories\CategoryRepository;

class NotificationRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @param  \Webkul\GraphQLAPI\Repositories\NotificationTranslationRepository  $notificationTranslationRepository
     * @param  \Illuminate\Container\Container  $app
     *
     * @return void
     */
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository,
        protected NotificationTranslationRepository $notificationTranslationRepository,
        App $app
    ) {
        parent::__construct($app);
    }

    /**
     * Specify model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return \Webkul\GraphQLAPI\Contracts\PushNotification::class;
    }

    /**
     * Create notification.
     *
     * @param  array  $data
     * @return \Webkul\GraphQLAPI\Contracts\Notification
     */
    public function create(array $data)
    {
        Event::dispatch('api.notification.create.before');

        $notification = $this->model->create($data);

        if (isset($data['channels'])) {
            $model = app()->make($this->model());

            foreach (core()->getAllChannels() as $channel) {
                if (in_array($channel->code, $data['channels'])) {
                    foreach ($channel->locales as $locale) {
                        $param = [];
                        foreach ($model->translatedAttributes as $attribute) {
                            if (isset($data[$attribute])) {
                                $param[$attribute] = $data[$attribute];
                            }
                        }
                        $param['channel'] = $channel->code;
                        $param['locale'] = $locale->code;
                        $param['push_notification_id'] = $notification->id;

                        $this->notificationTranslationRepository->create($param);
                    }
                }
            }
        }
        
        $this->uploadImages($data, $notification);

        Event::dispatch('api.notification.create.after', $notification);

        return $notification;
    }

    /**
     * Update notification.
     *
     * @param  array  $data
     * @param  int  $id
     * @param  string  $attribute
     * @return \Webkul\GraphQLAPI\Contracts\Notification
     */
    public function update(array $data, $id, $attribute = "id")
    {
        Event::dispatch('api.notification.update.before', $id);

        $notification = $this->find($id);
        
        $notification->update($data);

        if (isset($data['channel']) && isset($data['locale'])) {
            $model = app()->make($this->model());
            
            $notificationTranslation = $this->notificationTranslationRepository->findOneWhere([
                'channel'               => $data['channel'],
                'locale'                => $data['locale'],
                'push_notification_id'  => $data['notification_id'],
            ]);
            
            if ($notificationTranslation) {
                foreach ($model->translatedAttributes as $attribute) {
                    if (isset($data[$attribute])) {
                        $notificationTranslation->{$attribute} = $data[$attribute];
                    }
                }
                $notificationTranslation->save();
            }
        }
        
        $this->uploadImages($data, $notification);
        
        Event::dispatch('api.notification.update.after', $notification);

        return $notification;
    }

    /**
     * Upload notification's images.
     *
     * @param  array  $data
     * @param  \Webkul\GraphQLAPI\Contracts\Notification  $notification
     * @param  string $type
     * @return void
     */
    public function uploadImages($data, $notification, $type = "image")
    {
        if (isset($data[$type])) {
            $request = request();

            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;
                $dir = 'notification/images/' . $notification->id;

                if ($request->hasFile($file)) {
                    if ($notification->{$type}) {
                        Storage::delete($notification->{$type});
                    }

                    $notification->{$type} = $request->file($file)->store($dir);
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
     * send push notification in device
     *
     * @param  \Webkul\GraphQLAPI\Contracts\Notification  $notification
     * @return Response
     */
    public function sendGCM($notification)
    {
        $notificationTranslations = $notification->translations()->where([
            ['channel', '=', core()->getRequestedChannelCode()],
            ['locale', '=', core()->getRequestedLocaleCode()]
        ])->first();
        
        if ( $notificationTranslations ) {
            $notification->title = $notificationTranslations->title;
            $notification->content = $notificationTranslations->content;
        }

        // for android device
        $url        = "https://fcm.googleapis.com/fcm/send";
        $authKey    = core()->getConfigData('general.api.pushnotification.server_key');
        $androidTopic = core()->getConfigData('general.api.pushnotification.android_topic');
        $iosTopic   = core()->getConfigData('general.api.pushnotification.ios_topic');

        $fieldData = [
            'banner_url'        => asset('storage/'.$notification->image),
            'id'                => $notification->id,
            'body'              => $notification->content,
            'sound'             => 'default',
            'title'             => $notification->title,
            'message'           => $notification->content,
            'notificationType'  => $notification->type,
        ];

        switch ($notification->type) {
            case 'product' :
                $product = $this->productRepository->findorfail($notification->product_category_id);

                $fieldData = array_merge($fieldData, [
                    'click_action'      => route('shop.productOrCategory.index', $product->url_key),
                    'productName'       => $product->name ?? '',
                    'productId'         => $product->id ?? '',
                ]);
            break;

            case 'category':
                $category = $this->categoryRepository->findorfail($notification->product_category_id);
                
                $fieldData = array_merge($fieldData, [
                    'click_action'      => route('shop.productOrCategory.index', $category->slug),
                    'categoryName'      => $category->name ?? '',
                    'categoryId'        => $category->id ?? '',
                ]);
            break;

            case 'others':
                $fieldData = array_merge($fieldData, [
                    'click_action'      => route('shop.home.index'),
                ]);
            break;
        }

        $fields = array(
            'to'    => '/topics/' . $androidTopic,
            'data'  => $fieldData,
            'notification' =>  [
                'body'  => $notification->content,
                'title' => $notification->title,
            ],
        );

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $authKey,
        );

        try {
            // Open connection
            $ch = curl_init();

            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            // Disabling SSL Certificate support temporarly
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
            // Execute post
            $result = curl_exec( $ch );
            curl_close( $ch );

        } catch (\Exception $e) {
            session()->flash('error', $e);
        }
        
        return json_decode($result);
    }
}
