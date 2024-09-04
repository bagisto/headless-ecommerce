<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Configuration;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Repositories\CoreConfigRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CustomScriptMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CoreConfigRepository $coreConfigRepository) {}

    /**
     * Update the custom script.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function updateCustomScript(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'css'        => 'string',
            'javascript' => 'string',
        ]);

        $channelCode = core()->getRequestedChannel()->code;

        $data = [
            'channel' => $channelCode,
            'locale'  => core()->getRequestedLocaleCode(),
            'general' => [
                'content' => [
                    'custom_scripts' => [],
                ],
            ],
        ];

        try {
            $data['general']['content']['custom_scripts'] = [
                'custom_css'        => $args['css'] ?? '',
                'custom_javascript' => $args['javascript'] ?? '',
            ];

            $this->coreConfigRepository->create($data);

            $css = $this->coreConfigRepository->findOneWhere([
                'code'         => 'general.content.custom_scripts.custom_css',
                'channel_code' => $channelCode,
            ])?->value;

            $javascript = $this->coreConfigRepository->findOneWhere([
                'code'         => 'general.content.custom_scripts.custom_javascript',
                'channel_code' => $channelCode,
            ])->value;

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.configuration.index.general.content.custom-script.update-success'),
                'custom_scripts' => [
                    'css'        => $css,
                    'javascript' => $javascript,
                ],
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
