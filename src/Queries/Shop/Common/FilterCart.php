<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Common;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCart extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);

        // Split the name into firstname and lastname
        if ( isset($arguments['customer_name'])) {

            $customer_name = $input['customer_name'];

            $customerName =$this->nameSplitter($customer_name);

            $arguments['customer_first_name'] =  $customerName['firstname']; 

            $arguments['customer_last_name'] =  $customerName['lastname'];

            unset($arguments['customer_name']);

        }

        return $query->where($arguments); 
    }

    public function additional($data, $type)
    {
        $param = (isset($type['directive']) && $type['directive'] == 'conditions') ? 'conditions' : 'additional';

        $addition = $data->{$param};

        if (
            ! isset($data->cart_id) 
            || isset($data->address_type)
        ) {
            return json_encode($addition);
        }

        $additionalDate = [
            'is_buy_now'    => $addition['is_buy_now'] ?? false,
            'product_id'    => $addition['product_id'],
            'quantity'      => $addition['quantity'],
        ];

        if ($data->type == 'configurable') {
            $additionalDate['selected_configurable_option'] = $addition['selected_configurable_option'];
            
            if (! empty($addition['super_attribute'])) {
                foreach ($addition['super_attribute'] as $attributeId => $optionId) {
                    $additionalDate['super_attribute'][] = [
                        'attribute_id' => $attributeId,
                        'option_id' => (int) $optionId,
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