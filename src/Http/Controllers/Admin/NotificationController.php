<?php

namespace Webkul\GraphQLAPI\Http\Controllers\Admin;

use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\GraphQLAPI\DataGrids\PushNotificationDataGrid;
use Webkul\GraphQLAPI\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * Contains route related configuration.
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @param \Webkul\Core\Repositories\ChannelRepository  $channelRepository
     * @param \Webkul\Product\Repositories\ProductRepository  $productRepository
     * @param \Webkul\GraphQLAPI\Repositories\NotificationRepository  $notificationRepository
     */
    public function __construct(
        protected CategoryRepository $categoryRepository,
        protected ChannelRepository $channelRepository,
        protected ProductRepository $productRepository,
        protected NotificationRepository $notificationRepository,
    ) {
        $this->_config = request('_config');

        $this->middleware('admin');
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
        $channels = $this->channelRepository->get();

        return view('bagisto_graphql::admin.settings.push_notification.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'title'    => 'string|required',
            'content'  => 'string|required',
            'image.*'  => 'mimes:jpeg,jpg,bmp,png',
            'type'     => 'required',
            'channels' => 'required',
            'status'   => 'required'
        ]);

        $data = collect(request()->all())->except('_token')->toArray();

        Event::dispatch('admin.settings.notification.create.before');

        $notification = $this->notificationRepository->create($data);

        Event::dispatch('admin.settings.notification.create.after', $notification);

        session()->flash('success', trans('bagisto_graphql::app.admin.settings.notification.create.success'));

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

        $channels = $this->channelRepository->get();

        return view('bagisto_graphql::admin.settings.push_notification.edit', compact('notification', 'channels'));
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
            'status'   => 'required'
        ]);

        $data = collect(request()->all())->except('_token')->toArray();

        Event::dispatch('admin.settings.notification.update.befor', $id);

        $notification = $this->notificationRepository->update($data, $id);

        Event::dispatch('admin.settings.notification.update.after', $notification);

        session()->flash('success', trans('bagisto_graphql::app.admin.alert.update-success', ['name' => 'Notification']));

        return redirect()->route('admin.settings.push_notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $this->notificationRepository->delete($id);

            return response()->json(['message' => trans('bagisto_graphql::app.admin.alert.delete-success', ['name' => 'Notification'])], 200);
        } catch(\Exception $e) {
            session()->flash('success', trans('bagisto_graphql::app.admin.alert.delete-failed', ['name' => 'Notification']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * To mass delete the notificaton.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $notificationIds = explode(',', request()->input('indexes'));

        foreach ($notificationIds as $notificationId) {
            $this->notificationRepository->deleteWhere([
                'id' => $notificationId
            ]);
        }

        session()->flash('success', trans('bagisto_graphql::app.admin.alert.delete-success', ['name' => 'Notification']));

        return redirect()->back();
    }

    /**
     * To mass update the notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function massUpdate()
    {
        $notificationIds = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        foreach ($notificationIds as $notificationId) {
            $notification = $this->notificationRepository->find($notificationId);

            $notification->update([
                'status' => $updateOption
            ]);
        }

        session()->flash('success', trans('bagisto_graphql::app.admin.alert.update-success', ['name' => 'Notification']));

        return redirect()->back();
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

            session()->flash('success', trans('bagisto_graphql::app.admin.alert.sended-successfully', ['name' => 'Notification']));
        } else {

            $message = $result;

            if (gettype($result) == 'array' && !empty($result['error']))
                $message = $result['error'];
            elseif (isset($result->error))
                $message = $result->error;

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
        $data = request()->all();

        if ( substr_count($data['givenValue'], ' ') > 0) {
            return response()->json(['value' => false, 'message' => 'Product not exist', 'type' => $data['selectedType']],200);
        }

        //product case
        if ($data['selectedType'] == 'product') {
            if ($product = $this->productRepository->find($data['givenValue'])) {

                if (
                    ! isset($product->id) ||
                    ! isset($product->url_key) ||
                    (
                        isset($product->parent_id)
                        && $product->parent_id
                    )
                ) {
                    return response()->json(['value' => false, 'message' => 'Product not exist', 'type' => 'product'], 200);
                } else {
                    return response()->json(['value' => true], 200);
                }
            } else {
                return response()->json(['value' => false, 'message' => 'Product not exist', 'type' => 'product'], 200);
            }
        }

        //category case
        if ($data['selectedType'] == 'category') {
            if ($this->categoryRepository->find($data['givenValue'])) {
                return response()->json(['value' => true] ,200);
            } else {
                return response()->json(['value' => false, 'message' => 'Category not exist', 'type' => 'category'] ,200);
            }
        }
    }
}
