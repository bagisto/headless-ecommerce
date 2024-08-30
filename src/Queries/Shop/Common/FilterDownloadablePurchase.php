<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterDownloadablePurchase extends BaseFilter
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
        if (isset($input['title'])) {
            $input['product_name'] = $input['title'];
            unset($input['title']);
        }

        if (isset($input['date'])) {
            $input['created_at'] = $input['date'];
            unset($input['date']);
        }

        if (isset($input['remaining_download'])) {
            $remainingDownload = $input['remaining_download'];
            unset($input['remaining_download']);

            return $query->whereRaw('download_bought - download_used = ?', [$remainingDownload])
                ->where($input);

        }

        return $query->where($input);
    }
}
