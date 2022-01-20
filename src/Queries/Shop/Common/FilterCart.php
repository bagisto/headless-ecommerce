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
        
        return json_encode($data->{$param});
    }
}