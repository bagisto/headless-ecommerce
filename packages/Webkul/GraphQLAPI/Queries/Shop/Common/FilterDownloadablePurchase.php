<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterDownloadablePurchase extends BaseFilter
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
         
        // Convert the title parameter to product_name parameter
        if ( isset($arguments['title'])) {

            $arguments['product_name'] = $arguments['title'];

            unset($arguments['title']);
        }

        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['date'])) {

            $arguments['created_at'] = $arguments['date'];

            unset($arguments['date']);

        }

        // Convert the grand_total parameter to base_grand_total parameter
        if ( isset($arguments['remaining_download'])) {

            $remaining_download = $arguments['remaining_download'];

            unset($arguments['remaining_download']);

           return $query->whereRaw('download_bought - download_used = ?',[$remaining_download])
                  ->where($arguments);
            
        }

        return $query->where($arguments);
    }
}