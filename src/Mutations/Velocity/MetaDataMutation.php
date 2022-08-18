<?php

namespace Webkul\GraphQLAPI\Mutations\Velocity;

use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\Velocity\Repositories\VelocityMetadataRepository;

class MetaDataMutation extends Controller
{
    /**
     * Locale
     */
    protected $locale;

    /**
     * Channel
     */
    protected $channel;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Velocity\Repositories\VelocityMetadataRepository  $velocityMetadataRepository
     * @return void
     */
    public function __construct(
        protected VelocityMetadataRepository $velocityMetadataRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
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

        $params = $args['input'];
        $id = $args['id'];

        $this->locale = $args['input']['locale'] ?: app()->getLocale();
        $this->channel = $args['input']['channel'] ?: 'default';

        $params['locale'] = $this->locale;
        $params['channel'] = $this->channel;

        $imageData = '';
        if (isset($params['images'])) {
            $imageData = $params['images'];
            unset($params['images']);
        } else {
            unset($params['images']);
        }

        try {
            $metaData = $this->velocityMetadataRepository->update($params, $id);

            if (isset($metaData->id)) {
                if ($imageData != Null) {

                    $jsonData = [];
                    foreach ($imageData as $key => $advertisement) {
                        if ($advertisement != Null) {
                            if ($key == 'advertisement_four') {
                                $key = 4;
                            } elseif ($key == 'advertisement_three') {
                                $key = 3;
                            } elseif ($key == 'advertisement_two') {
                                $key = 2;
                            } else {
                                throw new Exception(trans('Invelid column for advertisment image!'));
                            }

                            $url_path = [];
                            foreach ($advertisement as $url) {

                                $image_url = $url;
                                $url_path[] = $this->uploadImage($image_url, 'velocity/');
                            }

                            if ($url_path != Null) {
                                $jsonData['advertisement'][$key] = $url_path;
                            }
                        }
                    }
                }

                if ($jsonData['advertisement'] != Null) {

                    $metaData->advertisement = $jsonData['advertisement'];
                    $metaData->save();
                }

                return $metaData;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * To save image through url
     *
     * @param model $model
     * @param String|null $image_url
     * @param String $path
     * @return mixed
     */
    public function uploadImage($image_url, $path)
    {
        $model_path = $path . 'images/';
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

                return $url_path = $model_path . $img_name;
            }
        }
    }
}
