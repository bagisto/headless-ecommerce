<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Core\Repositories\ChannelRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SliderMutation extends Controller
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
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @param  \Webkul\Core\Repositories\ChannelRepository $channelRepository
     * @return void
     */
    public function __construct(
        protected SliderRepository $sliderRepository,
        protected ChannelRepository $channelRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'title'      => 'required',
            'channel_id'    => 'required',
            'expired_at' => 'nullable|date',
            'image'   => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $image = $data['image'];

        unset($data['image']);

        $data['expired_at'] = \Carbon\Carbon::parse($data['expired_at'])->format('Y-m-d');

        try {

            $this->sliderRepository->save($data);

            $slider = $this->sliderRepository->where('title', $data['title'])->orderBy('id', 'DESC')->first();

            if (isset($slider)) {

                $channelName = $this->channelRepository->find($data['channel_id'])->name;

                $this->uploadImage($slider, $image, "slider_images/${channelName}", 'path');

                $slider->slider_path = $data['slider_path'];
                $slider->save();
            }

            return $slider;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'title'      => 'required',
            'channel_id'    => 'required',
            'expired_at' => 'nullable|date',
            'image'   => 'required',
        ]);


        $image = $data['image'];

        unset($data['image']);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {

            $slider = $this->sliderRepository->update($data, $id);

            if (isset($slider)) {
                if (isset($image)) {

                    $previousImage = $slider->path;

                    $channelName = $this->channelRepository->find($data['channel_id'])->name;

                    $this->uploadImage($slider, $image, "slider_images/${channelName}", 'path');

                    if (isset($data['slider_path'])) {
                        $slider->slider_path = $data['slider_path'];
                    }

                    $slider->save();

                    Storage::delete($previousImage);
                } else {

                    if (isset($data['slider_path'])) {

                        $slider->slider_path = $data['slider_path'];

                        $slider->save();
                    }
                }
            }

            return $slider;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $slider = $this->sliderRepository->findOrFail($id);

        try {

            $this->sliderRepository->delete($id);

            return [
                'status' => true,
                'message' => trans('admin::app.response.delete-success', ['name' => 'Slider'])
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => trans('admin::app.response.delete-failed', ['name' => 'Slider'])
            ];
        }
    }


    /**
     * To save image through url
     *
     * @param model $model
     * @param String|null $image_url
     * @param String $path
     * @param String $type
     * @return mixed
     */
    public function uploadImage($model, $image_url, $path, $type)
    {
        $model_path = $path . '/';
        $image_dir_path = storage_path('app/public/' . $model_path);
        if (!file_exists($image_dir_path)) {
            mkdir(storage_path('app/public/' . $model_path), 0777, true);
        }

        if (isset($image_url) && $image_url) {
            $valoidateImg = bagisto_graphql()->validatePath($image_url, 'image');

            if ($valoidateImg) {
                $img_name = basename($image_url);
                $savePath = $image_dir_path . $img_name;

                if (file_exists($savePath)) {
                    Storage::delete('/' . $model_path . $img_name);
                }

                file_put_contents($savePath, file_get_contents($image_url));

                $model->{$type} = $model_path . $img_name;

                $model->save();
            }
        }
    }
}
