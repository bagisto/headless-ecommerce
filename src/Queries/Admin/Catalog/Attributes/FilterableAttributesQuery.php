<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Catalog\Attributes;

use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterableAttributesQuery extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected AttributeRepository $attributeRepository) {}

    /**
     * Get the filterable attributes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilterableAttributes()
    {
        return $this->attributeRepository->findByField('is_filterable', 1);
    }
}
