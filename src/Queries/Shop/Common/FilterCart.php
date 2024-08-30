<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCart extends BaseFilter
{
    public function additional($data, $type)
    {
        $param = (isset($type['directive']) && $type['directive'] == 'conditions') ? 'conditions' : 'conditions';

        $addition = $data->{$param};

        if (
            ! isset($data->cart_id)
            || isset($data->address_type)
        ) {
            return json_encode($addition);
        }

        $additionalDate = [
            'is_buy_now' => $addition['is_buy_now'] ?? false,
            'product_id' => $addition['product_id'],
            'quantity'   => $addition['quantity'],
        ];

        if ($data->type == 'configurable') {
            $additionalDate['selected_configurable_option'] = $addition['selected_configurable_option'];

            if (! empty($addition['super_attribute'])) {
                foreach ($addition['super_attribute'] as $attributeId => $optionId) {
                    $additionalDate['super_attribute'][] = [
                        'attribute_id' => $attributeId,
                        'option_id'    => (int) $optionId,
                    ];
                }
            }

            if (! empty($addition['attributes'])) {
                foreach ($addition['attributes'] as $attributeCode => $option) {
                    $additionalDate['attributes'][] = array_merge(['attribute_code' => $attributeCode], $option);
                }
            }
        }

        return $additionalDate;
    }
}
