<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Rules\Code;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code'                  => ['required', 'unique:channels,code', new Code],
            'name'                  => 'required',
            'description'           => 'nullable',
            'inventory_sources'     => 'required|array|min:1|exists:inventory_sources,id',
            'root_category_id'      => 'required|exists:categories,id',
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

        try {
            $args = $this->setSEOContent($args);

            $logo = $args['logo'] ?? '';

            $favicon = $args['favicon'] ?? '';

            unset($args['logo'], $args['favicon']);

            Event::dispatch('core.channel.create.before');

            $channel = $this->channelRepository->create($args);

            Event::dispatch('core.channel.create.after', $channel);

            bagisto_graphql()->uploadImage($channel, $logo, 'channel/', 'logo');

            bagisto_graphql()->uploadImage($channel, $favicon, 'channel/', 'favicon');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.channels.create-success'),
                'channel' => $channel,
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
        $channel = $this->channelRepository->find($args['id']);

        if (! $channel) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.not-found'));
        }

        bagisto_graphql()->validate($args, [
            'code'                  => ['required', 'unique:channels,code,'.$args['id'], new Code],
            'name'                  => 'required',
            'description'           => 'nullable',
            'inventory_sources'     => 'required|array|min:1|exists:inventory_sources,id',
            'root_category_id'      => 'required|exists:categories,id',
            'hostname'              => 'unique:channels,hostname,'.$args['id'],
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

        try {
            $args = $this->setSEOContent($args);

            $logo = $args['logo'] ?? '';

            $favicon = $args['favicon'] ?? '';

            unset($args['logo'], $args['favicon'], $args['code']);

            Event::dispatch('core.channel.update.before', $channel->id);

            $channel = $this->channelRepository->update($args, $channel->id);

            Event::dispatch('core.channel.update.after', $channel);

            bagisto_graphql()->uploadImage($channel, $logo, 'channel/', 'logo');

            bagisto_graphql()->uploadImage($channel, $favicon, 'channel/', 'favicon');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.channels.update-success'),
                'channel' => $channel,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Set the SEO content and return the updated array.
     *
     * @return array
     */
    private function setSEOContent(array $data, ?string $locale = null)
    {
        $targetData = $locale ? $data[$locale] : $data;

        $targetData['home_seo'] = [
            'meta_title'       => $targetData['seo_title'],
            'meta_description' => $targetData['seo_description'],
            'meta_keywords'    => $targetData['seo_keywords'],
        ];

        unset($targetData['seo_title'], $targetData['seo_description'], $targetData['seo_keywords']);

        if ($locale) {
            $data[$locale] = $targetData;
        } else {
            $data = $targetData;
        }

        return $data;
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
        $channel = $this->channelRepository->find($args['id']);

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
            Event::dispatch('core.channel.delete.before', $args['id']);

            $channel->delete();

            Event::dispatch('core.channel.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.channels.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.channels.delete-failed'));
        }
    }
}
