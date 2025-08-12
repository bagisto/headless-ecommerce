<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterItem extends BaseFilter
{
    /**
     * Get the additional data for the cart item.
     */
    public function additional(object $model)
    {
        $additional = $model->additional;

        $additional['attributes'] = collect($additional['attributes'] ?? [])
            ->values()
            ->all();

        return $additional;
    }
}
