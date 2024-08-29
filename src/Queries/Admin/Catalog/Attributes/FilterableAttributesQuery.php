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
     * filter the data .
     *
     * @param  object  $query
     * @param  array  $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);

        return $query->where($arguments);
    }

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
