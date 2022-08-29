<?php

namespace Webkul\GraphQLAPI\Queries\Marketing;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterEmailTemplate extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);

        if ( isset($arguments['event'])) {

            $event = $input['event'];

            unset($arguments['event']);

            $query->whereHas('event', function ($q) use ($event) {
                $q->where(['name' => $event]);
            });
        }

        if ( isset($arguments['email_template'])) {

            $emailTemplate = $input['email_template'];

            unset($arguments['email_template']);

            $query->whereHas('email_template', function ($q) use ($emailTemplate) {
                $q->where(['name' => $emailTemplate]);
            });
        }

        if ( isset($arguments['channel_id'])) {

            $channelId = $input['channel_id'];

            unset($arguments['channel']);

            $query->whereHas('channel', function ($q) use ($channelId) {
                $q->where(['id' => $channelId]);
            });
        }

        if ( isset($arguments['customer_group_id'])) {

            $customerGroupId = $input['customer_group_id'];

            unset($arguments['event']);

            $query->whereHas('customer_group', function ($q) use ($customerGroupId) {
                $q->where(['id' => $customerGroupId]);
            });
        }

        return $query->where($arguments);
    }
}
