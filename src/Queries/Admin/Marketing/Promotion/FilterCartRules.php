<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Marketing\Promotion;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCartRules extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($input['start'])) {
            $input['starts_from'] = $input['start'];

            unset($input['start']);
        }

        if (isset($input['end'])) {
            $input['ends_till'] = $input['end'];

            unset($input['end']);
        }

        if (isset($input['priority'])) {
            $input['sort_order'] = $input['priority'];

            unset($input['priority']);
        }

        if (isset($input['coupon_code'])) {
            $query = $query->whereHas('cart_rule_coupon', function ($q) use ($input) {
                $q->where([
                    'code'       => $input['coupon_code'],
                    'is_primary' => 1,
                ]);
            });

            unset($input['coupon_code']);
        }

        return $query->where($input);
    }
}
