<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Illuminate\Support\Facades\Event;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'name'                  => 'required',
            'subject'               => 'required',
            'status'                => 'required',
            'channel_id'            => 'required|exists:channels,id',
            'customer_group_id'     => 'required|exists:customer_groups,id',
            'marketing_template_id' => 'required|exists:marketing_templates,id',
            'marketing_event_id'    => 'required|exists:marketing_events,id',
        ]);

        try {
            Event::dispatch('marketing.campaigns.create.before');

            $campaign = $this->campaignRepository->create($args);

            Event::dispatch('marketing.campaigns.create.after', $campaign);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.marketing.communications.campaigns.create-success'),
                'campaign' => $campaign,
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
        bagisto_graphql()->validate($args, [
            'name'                  => 'required',
            'subject'               => 'required',
            'status'                => 'required',
            'channel_id'            => 'required|exists:channels,id',
            'customer_group_id'     => 'required|exists:customer_groups,id',
            'marketing_template_id' => 'required|exists:marketing_templates,id',
            'marketing_event_id'    => 'required|exists:marketing_events,id',
        ]);

        $campaign = $this->campaignRepository->find($args['id']);

        if (! $campaign) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.campaigns.not-found'));
        }

        try {
            Event::dispatch('marketing.campaigns.update.before', $campaign->id);

            $campaign = $this->campaignRepository->update($args, $campaign->id);

            Event::dispatch('marketing.campaigns.update.after', $campaign);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.marketing.communications.campaigns.update-success'),
                'campaign' => $campaign,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
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
        $campaign = $this->campaignRepository->find($args['id']);

        if (! $campaign) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.campaigns.not-found'));
        }

        try {
            Event::dispatch('marketing.campaigns.delete.before', $args['id']);

            $campaign->delete();

            Event::dispatch('marketing.campaigns.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.campaigns.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
