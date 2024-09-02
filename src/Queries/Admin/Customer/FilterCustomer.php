<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Customer;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCustomer extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array  $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function __invoke($query, $input)
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
