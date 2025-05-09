<?php

namespace Webkul\GraphQLAPI\Listeners;

use Illuminate\Support\Facades\Request;
use Nuwave\Lighthouse\Events\EndExecution;

class InjectGdprData
{
    /**
     * Handle the event.
     */
    public function handle(EndExecution $event): void
    {
        if (
            ! auth()->guard('admin-api')->check()
            && core()->getConfigData('general.gdpr.settings.enabled')
            && core()->getConfigData('general.gdpr.cookie.enabled')
        ) {
            $headers = Request::header();
            
            if (empty($headers['is-cookie-exist'][0]) || $headers['is-cookie-exist'][0] === 'false') {
                $result = $event->result;
        
                // Make sure it's an array and contains data
                if (isset($result->data) && is_array($result->data)) {
                    // Add GDPR info
                    $result->data['gdpr'] = [
                        'cookieTitle'           => core()->getConfigData('general.gdpr.cookie.static_block_identifier'),
                        'cookieDescription'     => core()->getConfigData('general.gdpr.cookie.description'),
                        'privacyPolicyUrlKey'   => "page/privacy-policy",
                        'privacyPolicyText'     => trans('shop::app.components.layouts.cookie.index.privacy-policy'),
                        'cookieAccept'          => trans('shop::app.components.layouts.cookie.index.accept'),
                        'cookieReject'          => trans('shop::app.components.layouts.cookie.index.reject'),
                        'learnMoreAndCustomize' => "learnMoreAndCustomize",
                    ];
        
                    // Re-assign the modified result back to the event
                    $event->result = $result;
                }
            }
        }
    }
}
