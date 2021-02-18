<?php

namespace Webkul\GraphQLAPI\Queries\Catalog;

use Webkul\Category\Repositories\CategoryRepository;

class CategoryQuery
{
    /**
     * CategoryRepository object
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;

        $this->_config = request('_config');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function categoryTree()
    {
        return $this->categoryRepository->getVisibleCategoryTree();
    }
}
