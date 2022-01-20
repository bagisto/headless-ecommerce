<?php

namespace Webkul\GraphQLAPI\Models\Catalog;

use Exception;
use Webkul\Product\Type\AbstractType;
use Webkul\BookingProduct\Models\BookingProductProxy;
use Webkul\Product\Models\Product as BaseModel;

class Product extends BaseModel
{
    protected $typeInstance;

    /**
     * Retrieve type instance
     *
     * @return AbstractType
	 * @throws \Exception
     */
    public function getTypeInstance(): AbstractType
    {
        if ($this->typeInstance) {
            return $this->typeInstance;
        }
        if ( $this->type !== 'booking') {
            $this->typeInstance = app(config('product_types.' . $this->type . '.class'));
        } else {
            $this->typeInstance = app('Webkul\GraphQLAPI\Type\Booking');
        }

        if (! $this->typeInstance instanceof AbstractType) {
            throw new Exception(
                "Please ensure the product type '{$this->type}' is configured in your application."
            );
        }

        $this->typeInstance->setProduct($this);

        return $this->typeInstance;
    }

    /**
     * Get the booking that owns the product.
     */
    public function booking_product()
    {
        return $this->hasOne(BookingProductProxy::modelClass());
    }
}