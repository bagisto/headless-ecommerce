<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCart extends BaseFilter
{
    /**
     * Get the additional data for the cart.
     */
    public function additional(object $model)
    {
        $data = $model->additional ?? $model->conditions;

        if (
            ! isset($model->cart_id)
            || isset($model->address_type)
        ) {
            return json_encode($data);
        }

        $formattedData = [
            'is_buy_now' => $data['is_buy_now'] ?? false,
            'product_id' => $data['product_id'],
            'quantity'   => $data['quantity'] ?? 1,
        ];

        if ($model->type == 'configurable') {
            $formattedData['selected_configurable_option'] = $data['selected_configurable_option'];

            if (! empty($data['super_attribute'])) {
                foreach ($data['super_attribute'] as $attributeId => $optionId) {
                    $formattedData['super_attribute'][] = [
                        'attribute_id' => $attributeId,
                        'option_id'    => (int) $optionId,
                    ];
                }
            }

            if (! empty($data['attributes'])) {
                foreach ($data['attributes'] as $attributeCode => $option) {
                    $formattedData['attributes'][] = array_merge(['attribute_code' => $attributeCode], $option);
                }
            }
        }

        return $formattedData;
    }
}
