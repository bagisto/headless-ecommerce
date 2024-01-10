<?php

namespace Webkul\GraphQLAPI\Mutations\Marketing;

use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Marketing\Repositories\CampaignRepository;

class CampaignMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Marketing\Repositories\CampaignRepository $campaignRepository
     * @return void
     */
    public function __construct(protected CampaignRepository $campaignRepository)
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
            throw new Exception($validator->messages());
        }

        try {
            $campaign = $this->campaignRepository->create($args['input']);

            return $campaign;
        } catch (\Exception $e) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
            throw new Exception($validator->messages());
        }

        try {
            $campaign = $this->campaignRepository->update($args['input'], $args['id']);

            return $campaign;
        } catch (\Exception $e) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
        $campaign = $this->campaignRepository->find($id);

        try {
            if ($campaign) {
                $campaign->delete();

                return [
                    'status' => true,
                    'message' => trans('admin::app.marketing.communications.campaigns.delete-success', ['name' => 'Campaign'])
                ];
            }

            return [
                'status' => false,
                'message' => trans('admin::app.marketing.communications.campaigns.delete-failed', ['name' => 'Campaign'])
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
