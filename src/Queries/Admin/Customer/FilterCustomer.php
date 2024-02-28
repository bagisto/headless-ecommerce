<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Customer;

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

        $groupName = "";

        // Get first_name and last_name
        if (isset($arguments['name'])) {

            $nameChanger = $this->nameSplitter($arguments['name']);

            $arguments['first_name'] = $nameChanger['firstname'];

            $arguments['last_name'] = $nameChanger['lastname'];

            unset($arguments['name']);
        }

        // filter the relationship Customer Group
        if (isset($arguments['group_name'])) {

            $groupName = $input['group_name'];

            unset($arguments['group_name']);

            return $query->whereHas('group', function ($q) use ($groupName) {
                $q->where('name', $groupName);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
