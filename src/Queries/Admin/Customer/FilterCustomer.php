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
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        // Get first_name and last_name
        if (isset($arguments['name'])) {
            $nameChanger = $this->nameSplitter($input['name']);

            $input['first_name'] = $nameChanger['firstname'];

            $input['last_name'] = $nameChanger['lastname'];

            unset($input['name']);
        }

        // filter the relationship Customer Group
        if (isset($input['group_name'])) {
            $query = $query->whereHas('group', function ($q) use ($input) {
                $q->where('state', $input['group_name']);
            });

            unset($input['group_name']);
        }

        return $query->where($input);
    }
}
