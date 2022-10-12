<?php

namespace Webkul\GraphQLAPI\Models\Catalog;

use Illuminate\Support\Facades\Storage;
use Webkul\Product\Models\ProductDownloadableLink as BaseModel;

class ProductDownloadableLink extends BaseModel
{
    /**
     * Get image url for the file.
     */
    public function file_url(): string
    {
        return Storage::url($this->file);
    }

    /**
     * Get image url for the file.
     */
    public function getFileUrlAttribute(): string
    {
        return $this->file_url();
    }

    /**
     * Get image url for the sample file.
     */
    public function sample_file_url(): string
    {
        return Storage::url($this->sample_file);
    }

    /**
     * Get image url for the sample file.
     */
    public function getSampleFileUrlAttribute(): string
    {
        return $this->sample_file_url();
    }
}