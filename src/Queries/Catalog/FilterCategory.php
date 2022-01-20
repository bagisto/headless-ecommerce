<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCategory extends BaseFilter
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

        $qb_conditions = [];
        foreach ($arguments as $key => $argument) {
            if (! $argument ) {
                unset($arguments[$key]);
            }
            
            if ( in_array($key, ['name', 'slug']) && $argument) {
                $qb_conditions[$key] = $argument;

                unset($arguments[$key]);
            }
        }
        
        return $query->whereHas('translation', function ($q) use ($qb_conditions) {
            foreach ($qb_conditions as $column => $condition) {
                $q->where($column, 'like', '%' . urldecode($condition) . '%');
            }
        })->where($arguments);
    }
}
