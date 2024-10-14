<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\CartRule\Models\CartRule;
use Webkul\CatalogRule\Models\CatalogRule;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterItem extends BaseFilter
{
    /**
     * Get the additional data for the cart item.
     */
    public function additional(object $model)
    {
        if (
            $model instanceof CartRule
            || $model instanceof CatalogRule
        ) {
            return json_encode($model->conditions);
        }

        $data = $model->additional;

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
