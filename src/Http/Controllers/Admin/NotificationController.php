<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\MassUpdateRequest;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\GraphQLAPI\DataGrids\PushNotificationDataGrid;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ChannelRepository $channelRepository,
        protected ProductRepository $productRepository,
        protected NotificationRepository $notificationRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(PushNotificationDataGrid::class)->toJson();
        }

        return view('bagisto_graphql::admin.settings.push_notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('bagisto_graphql::admin.settings.push_notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'title'      => 'string|required',
            'content'    => 'string|required',
            'image.*'    => 'mimes:jpeg,jpg,bmp,png',
            'type'       => 'required',
            'channels.*' => 'required',
            'status'     => 'required',

        ]);

        Event::dispatch('settings.notification.create.before');

        $notification = $this->notificationRepository->create([
            "locale"              => request('locale'),
            "title"               => request('title'),
            "content"             => request('content'),
            "status"              => request('status'),
            "channels"            => request('channels'),
            "type"                => request('type'),
            "image"               => request('image'),
            "product_category_id" => request('product_category_id'),
        ]);

        Event::dispatch('settings.notification.create.after', $notification);

        session()->flash('success', trans('bagisto_graphql::app.admin.settings.notification.create-success'));

        return redirect()->route('admin.settings.push_notification.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->findOrFail($id);

        return view('bagisto_graphql::admin.settings.push_notification.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'title'    => 'string|required',
            'content'  => 'string|required',
            'image.*'  => 'mimes:jpeg,jpg,bmp,png',
            'type'     => 'required',
            'channels' => 'required',
            'status'   => 'required',
        ]);

        Event::dispatch('settings.notification.update.befor', $id);

        $notification = $this->notificationRepository->update([
            "locale"              => request('locale'),
            "title"               => request('title'),
            "content"             => request('content'),
            "status"              => request('status'),
            "channels"            => request('channels'),
            "type"                => request('type'),
            "image"               => request('image'),
            "product_category_id" => request('product_category_id'),
        ], $id);

        Event::dispatch('settings.notification.update.after', $notification);

        session()->flash('success', trans('bagisto_graphql::app.admin.settings.notification.update-success'));

        return redirect()->route('admin.settings.push_notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $notification = $this->notificationRepository->findOrFail($id);

        try {
            Event::dispatch('settings.push-notification.delete.before', $id);

            $notification->delete();

            Event::dispatch('settings.push-notification.delete.after', $id);

            return new JsonResponse([
                'message' => trans('bagisto_graphql::app.admin.settings.notification.index.delete-success'),
            ]);
        } catch(\Exception $e) {
        }

        return new JsonResponse([
            'message' => trans('bagisto_graphql::app.admin.settings.notification.index.delete-failed'),
        ], 500);
    }

    /**
     * Remove the specified resources from database.
     *
     * @param MassDestroyRequest $massDestroyRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $notificationsIds = $massDestroyRequest->input('indices');

        foreach ($notificationsIds as $notificationsId) {
            Event::dispatch('settings.push-notification.delete.before', $notificationsId);

            $this->notificationRepository->delete($notificationsId);

            Event::dispatch('settings.push-notification.delete.after', $notificationsId);
        }

        return new JsonResponse([
            'message' => trans('bagisto_graphql::app.admin.settings.notification.mass-delete-success'),
        ]);
    }

    /**
     * Mass update the notifications.
     *
     * @param MassUpdateRequest $massUpdateRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function massUpdate(MassUpdateRequest $massUpdateRequest): JsonResponse
    {
        $notificationIds = $massUpdateRequest->input('indices');

        foreach ($notificationIds as $notificationId) {
            Event::dispatch('settings.notification.update.before', $notificationId);

            $notification = $this->notificationRepository->find($notificationId);

            $notification->status = $massUpdateRequest->input('value');

            $notification->save();

            Event::dispatch('settings.notification.update.after', $notification);
        }

        return new JsonResponse([
            'message' => trans('bagisto_graphql::app.admin.settings.notification.index.mass-update-success')
        ], 200);
    }

    /**
     * To sent the notification to the device.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotification($id)
    {
        $notification = $this->notificationRepository->findOrFail($id);

        $result = $this->notificationRepository->prepareNotification($notification);

        if (isset($result->message_id)) {
            session()->flash('success', trans('bagisto_graphql::app.admin.settings.notification.edit.notification-send-success'));
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

            session()->flash('error', $message);
        }

        return redirect()->back();
    }

    /**
     * To check resource exist in DB.
     *
     * @return \Illuminate\Http\Response
     */
    public function exist()
    {
        $data = request()->only([
            'givenValue',
            'selectedType',
        ]);

        //product case
        if ($data['selectedType'] == 'product') {
            if ($product = $this->productRepository->find($data['givenValue'])) {
                if (isset($product->url_key)) {
                    return response()->json([
                        'value' => true,
                    ], 200);
                }
            }

            return response()->json([
                'value'   => false,
                'message' => 'Product not exist',
                'type'    => 'product',
            ], 401);
        }

        //category case
        if ($data['selectedType'] == 'category') {
            if ($this->categoryRepository->find($data['givenValue'])) {
                return response()->json([
                    'value' => true,
                ] ,200);
            }

            return response()->json([
                'value'   => false,
                'message' => 'Category not exist',
                'type'    => 'category',
            ], 401);
        }
    }
}
