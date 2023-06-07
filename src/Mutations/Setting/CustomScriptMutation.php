<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Repositories\CoreConfigRepository;
use Webkul\Core\Repositories\LocaleRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CustomScriptMutation extends Controller
{
    /**
     * ChannelRepository object
     *
     * @var \Webkul\Core\Repositories\ChannelRepository
     */
    protected $channelRepository;

    /**
     * LocaleRepository instance
     */
    protected $localeRepository;

    /**
     * CoreConfigRepository instance
     */
    protected $coreConfigRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\ChannelRepository  $channelRepository
     * @return void
     */
    public function __construct(
        ChannelRepository $channelRepository,
        LocaleRepository $localeRepository,
        CoreConfigRepository $coreConfigRepository
    )
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:' . $this->guard);

        $this->channelRepository = $channelRepository;

        $this->localeRepository = $localeRepository;

        $this->coreConfigRepository = $coreConfigRepository;

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if ($channel == Null) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.channel-failure'));
        }

        $validator = Validator::make($data, [
            'customCSS' => 'string',
            'customJS'  => 'string'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $customData = [
                'channel'   => $channel->code,
                'locale'    => app()->getLocale(),
                'general' => [
                    'content' => [
                        'custom_scripts' => [

                        ]
                    ]
                ]
            ];

            if ( isset($data['customCSS'])) {
                $customData['general']['content']['custom_scripts']['custom_css'] = $data['customCSS'];
            }

            if ( isset($data['customJS'])) {
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
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $channel = $this->channelRepository->findOneByField('id', $data['channel']);

        if ($channel == Null) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.channel-failure'));
        }

        $validator = Validator::make($data, [
            'customCSS' => 'string',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {

            if ( isset($data['customCSS'])) {
                $customData = [
                    'channel'   => $channel->code,
                    'locale'    => app()->getLocale(),
                    'general' => [
                        'content' => [
                            'custom_scripts' => [
                                'custom_css' => $data['customCSS']
                            ]
                        ]
                    ]
                ];
            } else {
                $customData = [
                    'channel'   => $channel->code,
                    'locale'    => app()->getLocale(),
                    'general' => [
                        'content' => [
                            'custom_scripts' => [
                                'custom_javascript' => $data['customJS']
                            ]
                        ]
                    ]
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
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $id = $args['id'];

        $scripts = $this->coreConfigRepository->findOrFail($id);

        try {

            $this->coreConfigRepository->delete($id);


            return ['success' => trans('bagisto_graphql::app.admin.response.script-delete-success')];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Custom Scripts']));
        }

    }
}
