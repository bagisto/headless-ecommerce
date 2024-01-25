<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Configuration;

use Exception;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Repositories\CoreConfigRepository;
use Webkul\Core\Repositories\LocaleRepository;

class CustomScriptMutation extends Controller
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
     * @param  \Webkul\Core\Repositories\ChannelRepository  $channelRepository
     * @return void
     */
    public function __construct(
        protected ChannelRepository $channelRepository,
        protected CoreConfigRepository $coreConfigRepository,
        protected LocaleRepository $localeRepository
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
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if (! $channel) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.channel-failure'));
        }

        $validator = Validator::make($data, [
            'customCSS' => 'string',
            'customJS'  => 'string',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $customData = [
                'channel' => $channel->code,
                'locale'  => app()->getLocale(),
                'general' => [
                    'content' => [
                        'custom_scripts' => [

                        ],
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

            return ['success' => trans('admin::app.response.create-success', ['name' => 'Custom Script'])];
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
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if (! $channel) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.channel-failure'));
        }

        $validator = Validator::make($data, [
            'customCSS' => 'string',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (isset($data['customCSS'])) {
                $customData = [
                    'channel' => $channel->code,
                    'locale'  => app()->getLocale(),
                    'general' => [
                        'content' => [
                            'custom_scripts' => [
                                'custom_css' => $data['customCSS']
                            ],
                        ],
                    ],
                ];
            } else {
                $customData = [
                    'channel' => $channel->code,
                    'locale'  => app()->getLocale(),
                    'general' => [
                        'content' => [
                            'custom_scripts' => [
                                'custom_javascript' => $data['customJS']
                            ],
                        ],
                    ],
                ];
            }

            $this->coreConfigRepository->create($customData);

            return ['success' => trans('admin::app.response.update-success', ['name' => 'Custom Script'])];
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
        if (empty($args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $id = $args['id'];

        $this->coreConfigRepository->findOrFail($id);

        try {
            $this->coreConfigRepository->delete($id);

            return ['success' => trans('bagisto_graphql::app.admin.response.script-delete-success')];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Custom Scripts']));
        }
    }
}
