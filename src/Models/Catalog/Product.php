<?php

namespace Webkul\GraphQLAPI\Models\Catalog;

use Exception;
use Webkul\Product\Type\AbstractType;
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

        $this->typeInstance = app(config('product_types.' . $this->type . '.class'));
        
        if (! $this->typeInstance instanceof AbstractType) {
            throw new Exception(
                "Please ensure the product type '{$this->type}' is configured in your application."
            );
        }

        $this->typeInstance->setProduct($this);

        return $this->typeInstance;
    }
}
