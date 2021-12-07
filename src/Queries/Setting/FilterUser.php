<?php

namespace Webkul\GraphQLAPI\Queries\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterUser extends BaseFilter
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

        $role = "";

        // filter the relationship Role
        if ( isset($arguments['role'])) {

            $role = $input['role'];

            unset($arguments['role']);

            return $query->whereHas('role', function ($q) use ($role) {
                $q->where('name', $role);
            })->where($arguments);
        }

        return $query->where($arguments);
    }
}
