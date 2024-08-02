<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Configuration;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Repositories\CoreConfigRepository;
use Webkul\Core\Repositories\LocaleRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CustomScriptMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ChannelRepository $channelRepository,
        protected CoreConfigRepository $coreConfigRepository,
        protected LocaleRepository $localeRepository
    ) {}

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

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if (! $channel) {
            throw new CustomException(trans('bagisto_graphql::app.admin.configuration.custom-scripts.channel-not-found'));
        }

        bagisto_graphql()->validate($data, [
            'customCSS' => 'string',
            'customJS'  => 'string',
        ]);

        try {
            $customData = [
                'channel' => $channel->code,
                'locale'  => app()->getLocale(),
                'general' => [
                    'content' => [
                        'custom_scripts' => [],
                    ],
                ],
            ];

            if (isset($data['customCSS'])) {
                $customData['general']['content']['custom_scripts']['custom_css'] = $data['customCSS'];
            }

            if (isset($data['customJS'])) {
                $customData['general']['content']['custom_scripts']['custom_javascript'] = $data['customJS'];
            }

            $this->coreConfigRepository->create($customData);

            return ['success' => trans('bagisto_graphql::app.admin.configuration.custom-scripts.create-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if (! $channel) {
            throw new CustomException(trans('bagisto_graphql::app.admin.configuration.custom-scripts.channel-not-found'));
        }

        bagisto_graphql()->validate($data, [
            'customCSS' => 'string',
            'customJS'  => 'string',
        ]);

        try {
            $customData = [
                'channel' => $channel->code,
                'locale'  => app()->getLocale(),
                'general' => [
                    'content' => [
                        'custom_scripts' => [],
                    ],
                ],
            ];

            if (isset($data['customCSS'])) {
                $customData['general']['content']['custom_scripts']['custom_css'] = $data['customCSS'];
            }

            if (isset($data['customJS'])) {
                $customData['general']['content']['custom_scripts']['custom_javascript'] = $data['customJS'];
            }

            $this->coreConfigRepository->create($customData);

            return ['success' => trans('bagisto_graphql::app.admin.configuration.custom-scripts.update-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $this->coreConfigRepository->findOrFail($id);

        try {
            $this->coreConfigRepository->delete($id);

            return ['success' => trans('bagisto_graphql::app.admin.configuration.custom-scripts.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
