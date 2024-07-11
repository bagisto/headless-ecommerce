<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class ChannelMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ChannelRepository $channelRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'                  => ['required', 'unique:channels,code', new \Webkul\Core\Rules\Code],
            'name'                  => 'required',
            'description'           => 'nullable',
            'inventory_sources'     => 'required|array|min:1',
            'root_category_id'      => 'required',
            'hostname'              => 'unique:channels,hostname',
            'locales'               => 'required|array|min:1',
            'default_locale_id'     => 'required|in_array:locales.*',
            'currencies'            => 'required|array|min:1',
            'base_currency_id'      => 'required|in_array:currencies.*',
            'theme'                 => 'nullable',
            'logo.*'                => 'nullable|mimes:bmp,jpeg,jpg,png,webp',
            'favicon.*'             => 'nullable|mimes:bmp,jpeg,jpg,png,webp,ico',
            'seo_title'             => 'required|string',
            'seo_description'       => 'required|string',
            'seo_keywords'          => 'required|string',
            'is_maintenance_on'     => 'boolean',
            'maintenance_mode_text' => 'nullable',
            'allowed_ips'           => 'nullable',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            $data = $this->setSEOContent($data);

            $logo = $data['logo'] ?? '';

            $favicon = $data['favicon'] ?? '';

            unset($data['logo'], $data['favicon']);

            Event::dispatch('core.channel.create.before');

            $channel = $this->channelRepository->create($data);

            Event::dispatch('core.channel.create.after', $channel);

            bagisto_graphql()->uploadImage($channel, $logo, 'channel/', 'logo');

            bagisto_graphql()->uploadImage($channel, $favicon, 'channel/', 'favicon');

            $channel->success = trans('bagisto_graphql::app.admin.settings.channels.create-success');

            return $channel;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'                  => ['required', 'unique:channels,code', new \Webkul\Core\Rules\Code],
            'name'                  => 'required',
            'description'           => 'nullable',
            'inventory_sources'     => 'required|array|min:1',
            'root_category_id'      => 'required',
            'hostname'              => 'unique:channels,hostname,'.$id,
            'locales'               => 'required|array|min:1',
            'default_locale_id'     => 'required|in_array:locales.*',
            'currencies'            => 'required|array|min:1',
            'base_currency_id'      => 'required|in_array:currencies.*',
            'theme'                 => 'nullable',
            'logo.*'                => 'nullable|mimes:bmp,jpeg,jpg,png,webp',
            'favicon.*'             => 'nullable|mimes:bmp,jpeg,jpg,png,webp,ico',
            'seo_title'             => 'required|string',
            'seo_description'       => 'required|string',
            'seo_keywords'          => 'required|string',
            'is_maintenance_on'     => 'boolean',
            'maintenance_mode_text' => 'nullable',
            'allowed_ips'           => 'nullable',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $channel = $this->channelRepository->find($id);

        if (! $channel) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.not-found'));
        }

        try {
            $data = $this->setSEOContent($data);

            $logo = $data['logo'] ?? '';

            $favicon = $data['favicon'] ?? '';

            unset($data['logo'], $data['favicon']);

            Event::dispatch('core.channel.update.before', $id);

            $channel = $this->channelRepository->update($data, $id);

            Event::dispatch('core.channel.update.after', $channel);

            bagisto_graphql()->uploadImage($channel, $logo, 'channel/', 'logo');

            bagisto_graphql()->uploadImage($channel, $favicon, 'channel/', 'favicon');

            $channel->success = trans('bagisto_graphql::app.admin.settings.channels.update-success');

            return $channel;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Set the seo content and return back the updated array.
     *
     * @param  string  $locale
     * @return array
     */
    private function setSEOContent(array $data, $locale = null)
    {
        $editedData = $data;

        if ($locale) {
            $editedData = $data[$locale];
        }

        $editedData['home_seo']['meta_title'] = $editedData['seo_title'];
        $editedData['home_seo']['meta_description'] = $editedData['seo_description'];
        $editedData['home_seo']['meta_keywords'] = $editedData['seo_keywords'];

        $editedData = $this->unsetKeys($editedData, ['seo_title', 'seo_description', 'seo_keywords']);

        if ($locale) {
            $data[$locale] = $editedData;
            $editedData = $data;
        }

        return $editedData;
    }

    /**
     * Unset keys.
     *
     * @param  array  $keys
     * @return array
     */
    private function unsetKeys($data, $keys)
    {
        foreach ($keys as $key) {
            unset($data[$key]);
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $channel = $this->channelRepository->find($id);

        if (! $channel) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.not-found'));
        }

        if ($this->channelRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.last-delete-error'));
        }

        if ($channel->code == config('app.channel')) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.default-delete-error'));
        }

        try {
            Event::dispatch('core.channel.delete.before', $id);

            $this->channelRepository->delete($id);

            Event::dispatch('core.channel.delete.after', $id);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.channels.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.delete-failed'));
        }
    }
}
