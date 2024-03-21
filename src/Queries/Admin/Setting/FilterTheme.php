<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterTheme extends BaseFilter
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
        // filter the relationship Currency
        if (! empty($input['channel'])) {
            $query = $query->whereHas('channel', function ($q) use ($input) {
                $q->where('name', $input['channel']);
            });

            unset($input['channel']);
        }

        return $query->where($input);
    }
}
