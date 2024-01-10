<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Rules\Code;

class ChannelMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\ChannelRepository  $channelRepository
     * @return void
     */
    public function __construct(protected ChannelRepository $channelRepository)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'              => ['required', 'unique:channels,code', new Code],
            'name'              => 'required',
            'locales'           => 'required|array|min:1',
            'default_locale_id' => 'required|numeric',
            'currencies'        => 'required|array|min:1',
            'base_currency_id'  => 'required|numeric',
            'root_category_id'  => 'required',
            'logo.*'            => 'mimes:jpeg,jpg,bmp,png',
            'favicon.*'         => 'mimes:jpeg,jpg,bmp,png',
            'seo_title'         => 'required|string',
            'seo_description'   => 'required|string',
            'seo_keywords'      => 'required|string',
            'hostname'          => 'unique:channels,hostname',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $logo = '';

            if (isset($data['logo'])) {
                $logo = $data['logo'];

                unset($data['logo']);
            }

            $favicon = '';

            if (isset($data['favicon'])) {
                $favicon = $data['favicon'];

                unset($data['favicon']);
            }

            $data['seo']['meta_title'] = $data['seo_title'];
            $data['seo']['meta_description'] = $data['seo_description'];
            $data['seo']['meta_keywords'] = $data['seo_keywords'];

            unset($data['seo_title']);
            unset($data['seo_description']);
            unset($data['seo_keywords']);

            $data['home_seo'] = $data['seo'];

            unset($data['seo']);

            Event::dispatch('core.channel.create.before');

            $channel = $this->channelRepository->create($data);

            Event::dispatch('core.channel.create.after', $channel);

            if ($channel) {
                bagisto_graphql()->uploadImage($channel, $logo, 'velocity/channel/', 'logo');

                bagisto_graphql()->uploadImage($channel, $favicon, 'velocity/channel/', 'favicon');

                return $channel;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'              => ['required', 'unique:channels,code,' . $id, new Code],
            'name'              => 'required',
            'locales'           => 'required|array|min:1',
            'inventory_sources' => 'required|array|min:1',
            'default_locale_id' => 'required|numeric',
            'currencies'        => 'required|array|min:1',
            'base_currency_id'  => 'required|numeric',
            'root_category_id'  => 'required',
            'logo.*'            => 'mimes:jpeg,jpg,bmp,png',
            'favicon.*'         => 'mimes:jpeg,jpg,bmp,png',
            'seo_title'         => 'required|string',
            'seo_description'   => 'required|string',
            'seo_keywords'      => 'required|string',
            'hostname'          => 'unique:channels,hostname,' . $id,
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $logo = '';

            if (isset($data['logo'])) {
                $logo = $data['logo'];

                unset($data['logo']);
            }

            $favicon = '';

            if (isset($data['favicon'])) {
                $favicon = $data['favicon'];

                unset($data['favicon']);
            }

            $data['seo']['meta_title'] = $data['seo_title'];
            $data['seo']['meta_description'] = $data['seo_description'];
            $data['seo']['meta_keywords'] = $data['seo_keywords'];

            unset($data['seo_title']);
            unset($data['seo_description']);
            unset($data['seo_keywords']);

            $data['home_seo'] = $data['seo'];

            Event::dispatch('core.channel.update.before', $id);

            $channel = $this->channelRepository->update($data, $id);

            Event::dispatch('core.channel.update.after', $channel);

            if ($channel) {
                bagisto_graphql()->uploadImage($channel, $logo, 'velocity/channel/', 'logo');

                bagisto_graphql()->uploadImage($channel, $favicon, 'velocity/channel/', 'favicon');

                return $channel;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $channel = $this->channelRepository->findOrFail($id);

        if ($channel->code == config('app.channel')) {
            throw new Exception(trans('admin::app.settings.channels.index.last-delete-error'));
        }

        try {
            Event::dispatch('core.channel.delete.before', $id);

            $this->channelRepository->delete($id);

            Event::dispatch('core.channel.delete.after', $id);

            return ['success' => trans('admin::app.settings.channels.index.delete-success')];
        } catch (\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Channel']));
        }
    }
}
