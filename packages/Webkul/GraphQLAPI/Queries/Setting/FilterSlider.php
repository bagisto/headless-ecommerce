<?php

namespace Webkul\GraphQLAPI\Queries\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterSlider extends BaseFilter
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

        // filter the relationship Currency
        if ( isset($arguments['channel'])) {

            $channel = $input['channel'];

            unset($arguments['channel']);

            return $query->whereHas('channel', function ($q) use ($channel) {
                $q->where('name', $channel);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
