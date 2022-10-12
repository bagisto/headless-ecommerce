<?php

namespace Webkul\GraphQLAPI\Models\Catalog;

use Illuminate\Support\Facades\Storage;
use Webkul\Product\Models\ProductDownloadableSample as BaseModel;

class ProductDownloadableSample extends BaseModel
{
    /**
     * Get image url for the file.
     */
    public function file_url()
    {
        return Storage::url($this->file);
    }
}