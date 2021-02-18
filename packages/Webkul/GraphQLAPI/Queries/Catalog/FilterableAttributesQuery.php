<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterableAttributesQuery extends BaseFilter
{
    /**
     * AttributeRepository object
     *
     * @var \Webkul\Attribute\Repositories\AttributeRepository
     */
    protected $attributeRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Attribute\Repositories\AttributeRepository  $attributeRepository
     * @return void
     */
    public function __construct(
        AttributeRepository $attributeRepository
    )
    {
        $this->attributeRepository = $attributeRepository;

        $this->_config = request('_config');
    }

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

        return $query->where($arguments);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function getFilterableAttributes()
    {
        return $this->attributeRepository->findByField('is_filterable', 1);
    }
}
