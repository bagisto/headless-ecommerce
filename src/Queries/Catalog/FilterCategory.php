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

        $translation = "";

        // filter the relationship Translation
        if ( isset($arguments['name'])) {

            $translation = $input['name'];

            unset($arguments['name']);
        }
        
        return $query->whereHas('translation', function ($q) use ($translation) {
            $q->where('name', $translation);
        })->where($arguments);
    }
}
