<?php

namespace Webkul\GraphQLAPI\Queries\Velocity;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterContent extends BaseFilter
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

       // filter the relationship translation
       if ( isset($arguments['title'])) {

            $title = $input['title'];
            
            unset($arguments['title']);

            return $query->whereHas('translations',function ($q) use ($title) {
                $q->where("title", $title);
            })->where($arguments);
        }

        return $query->where($arguments);       
    } 
}  
