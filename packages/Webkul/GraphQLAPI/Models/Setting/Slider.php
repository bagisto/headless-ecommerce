<?php

namespace Webkul\GraphQLAPI\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Webkul\Core\Models\ChannelProxy;
use Webkul\Core\Models\Slider as baseModel;

class Slider extends baseModel
{
  
     /**
     * Get the slider channel name associated with the channel.
     */
    public function channel()
    {
        return $this->belongsTo(ChannelProxy::modelClass());
    }
}