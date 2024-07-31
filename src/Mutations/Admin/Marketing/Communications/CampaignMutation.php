<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\CampaignRepository;

class CampaignMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CampaignRepository $campaignRepository) {}

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

        $validator = Validator::make($args['input'], [
            'name'                  => 'required',
            'subject'               => 'required',
            'status'                => 'required',
            'channel_id'            => 'required',
            'customer_group_id'     => 'required',
            'marketing_template_id' => 'required',
            'marketing_event_id'    => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $campaign = $this->campaignRepository->create($args['input']);

            return $campaign;
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
        if (
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $validator = Validator::make($args['input'], [
            'name'                  => 'required',
            'subject'               => 'required',
            'status'                => 'required',
            'channel_id'            => 'required',
            'customer_group_id'     => 'required',
            'marketing_template_id' => 'required',
            'marketing_event_id'    => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $campaign = $this->campaignRepository->update($args['input'], $args['id']);

            return $campaign;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $campaign = $this->campaignRepository->find($id);

        try {
            if ($campaign) {
                $campaign->delete();

                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.admin.marketing.communications.campaigns.delete-success'),
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.campaigns.delete-failed'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
