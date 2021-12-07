<?php

namespace Webkul\GraphQLAPI\Queries\Customer;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCustomer extends BaseFilter
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

        $group_name = "";

        // Get first_name and last_name
        if ( isset($arguments['name'])) {

            $nameChanger = $this->nameSplitter($arguments['name']);

            $arguments['first_name'] = $nameChanger['firstname'];

            $arguments['last_name'] = $nameChanger['lastname'];

            unset($arguments['name']);
        }

        // filter the relationship Customer Group
        if ( isset($arguments['group_name'])) {

            $group_name = $input['group_name'];

            unset($arguments['group_name']);

            return $query->whereHas('group', function ($q) use ($group_name) {
                $q->where('name', $group_name);
            })->where($arguments);
        }

        return $query->where($arguments);      
    }
}