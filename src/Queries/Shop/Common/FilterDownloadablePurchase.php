<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Illuminate\Database\Eloquent\Builder;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterDownloadablePurchase extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
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
