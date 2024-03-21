<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Webkul\Core\Repositories\ChannelRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class ThemeMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ThemeCustomizationRepository $themeCustomizationRepository,
        protected ChannelRepository $channelRepository
    ) {
    }

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
            'name'       => 'required',
            'sort_order' => 'required|numeric',
            'type'       => 'in:product_carousel,category_carousel,static_content,image_carousel,footer_links,services_content',
            'channel_id' => 'required|in:'.implode(',', (core()->getAllChannels()->pluck("id")->toArray())),
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        Event::dispatch('theme_customization.create.before');

        $theme = $this->themeCustomizationRepository->create([
            'name'       => $data['name'],
            'sort_order' => $data['sort_order'],
            'type'       => $data['type'],
            'channel_id' => $data['channel_id'],
        ]);

        Event::dispatch('theme_customization.create.after');

        $theme->success = trans('bagisto_graphql::app.admin.settings.themes.create-success');

        return $theme;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
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
            'name'       => 'required',
            'sort_order' => 'required|numeric',
            'type'       => 'in:product_carousel,category_carousel,static_content,image_carousel,footer_links',
            'channel_id' => 'required|in:'.implode(',', (core()->getAllChannels()->pluck("id")->toArray())),
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $data['locale'] = $locale = core()->getRequestedLocaleCode();

        $themeData = $this->themeCustomizationRepository->find($id);

        if (! $themeData) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.themes.not-found'));
        }

        $data['type'] = $themeData->type;

        if ($data['type'] == 'product_carousel') {
            $data[$locale]['options']['title'] = $data['options']['title'];

            $data[$locale]['options']['filters'] = [];

            foreach ($data['options']['filtersInput'] as $filtersInput) {
                $data[$locale]['options']['filters'][$filtersInput['key']] = $filtersInput['value'];
            }

            unset($data['options']);
        }

        if ($data['type'] == 'static_content') {
            $data[$locale]['options']['html'] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $data[$locale]['options']['html']);
            $data[$locale]['options']['css'] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $data[$locale]['options']['css']);
        }

        if ($data['type'] == 'image_carousel') {
            unset($data['options']);
        }

        Event::dispatch('theme_customization.update.before', $id);

        $theme = $this->themeCustomizationRepository->update($data, $id);

        if ($data['type'] == 'image_carousel') {
            $this->themeCustomizationRepository->uploadImage(
                request()->all('options'),
                $theme,
                request()->input('deleted_sliders', [])
            );
        }

        Event::dispatch('theme_customization.update.after', $theme);

        $theme->success = trans('bagisto_graphql::app.admin.settings.themes.update-success');

        return $theme;
    }

    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        Event::dispatch('theme_customization.delete.before', $id);

        $theme = $this->themeCustomizationRepository->find($id);

        if (! $theme) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.themes.not-found'));
        }

        $theme?->delete();

        Storage::deleteDirectory('theme/'.$theme->id);

        Event::dispatch('theme_customization.delete.after', $id);

        return [
            'success' => trans('bagisto_graphql::app.admin.settings.themes.delete-success'),
        ];
    }
}
