<?php

namespace Webkul\GraphQLAPI\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Webkul\Core\Models\ChannelProxy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Core\Models\Slider as baseModel;

class Slider extends baseModel
{
    
    /**
     * Get the slider channel name associated with the channel.
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(ChannelProxy::modelClass());
    }
}