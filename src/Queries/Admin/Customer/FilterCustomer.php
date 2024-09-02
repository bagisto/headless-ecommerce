<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Customer;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCustomer extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (isset($arguments['name'])) {
            $nameChanger = $this->nameSplitter($input['name']);

            $input['first_name'] = $nameChanger['firstname'];

            $input['last_name'] = $nameChanger['lastname'];

            unset($input['name']);
        }

        if (isset($input['group_name'])) {
            $query = $query->whereHas('group', function ($q) use ($input) {
                $q->where('state', $input['group_name']);
            });

            unset($input['group_name']);
        }

        return $query->where($input);
    }
}
