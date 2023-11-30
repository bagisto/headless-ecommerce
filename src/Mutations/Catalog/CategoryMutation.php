<?php

namespace Webkul\GraphQLAPI\Mutations\Catalog;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Rules\Slug;

class CategoryMutation extends Controller
{
    /**
     * localeFields array
     *
     * @var Array
     */
    protected $localeFields = [
        'name',
        'description',
        'meta_title',
        'slug',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || 
            (isset($args['input']) && ! $args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'slug'        => ['required', 'unique:category_translations,slug', new Slug],
            'name'        => 'required',
            'image.*'     => 'mimes:jpeg,jpg,bmp,png',
            'description' => 'required_if:display_mode,==,description_only,products_and_description',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $image_url = '';
            if (isset($data['logo_path'])) {
                $image_url =  current($data['logo_path']);
                unset($data['logo_path']);
            }

            $banner_path = '';
            if (isset($data['banner_path'])) {
                $banner_path = current($data['banner_path']);
                unset($data['banner_path']);
            }

            $category = $this->categoryRepository->create($data);

            Event::dispatch('catalog.category.create.after', $category);

            if (isset($category->id)) {
                bagisto_graphql()->uploadImage($category, $image_url, 'category/', 'logo_path');

                bagisto_graphql()->uploadImage($category, $banner_path, 'category/', 'banner_path');

                return $category;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (
            ! isset($args['id']) || 
            ! isset($args['input']) || 
            (isset($args['input']) 
            && ! $args['input'])
            ) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];
        $locale = (isset($data['locale']) && $data['locale'] != 'all') ? $data['locale'] : app()->getLocale();
        $data[$locale] = [];

        foreach ($this->localeFields as $field) {
            if (isset($data[$field])) {
                $data[$locale][$field] = $data[$field];
                unset($data[$field]);
            }
        }

        $validator = Validator::make($data, [
            $locale . '.slug' => ['required', new Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->categoryRepository->isSlugUnique($id, $value)) {
                    $fail(trans('admin::app.response.already-taken', ['name' => 'Category']));
                }
            }],
            $locale . '.name' => 'required',
            'image.*'         => 'mimes:jpeg,jpg,bmp,png',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $image_url = '';
            if (isset($data['logo_path'])) {
                $image_url =  current($data['logo_path']);
                unset($data['logo_path']);
            }

            $banner_path = '';
            if (isset($data['banner_path'])) {
                $banner_path = current($data['banner_path']);
                unset($data['banner_path']);
            }

            $category = $this->categoryRepository->update($data, $id);

            Event::dispatch('catalog.category.update.after', $category);

            if (isset($category->id)) {
                bagisto_graphql()->uploadImage($category, $image_url, 'category/', 'logo_path');

                bagisto_graphql()->uploadImage($category, $banner_path, 'category/', 'banner_path');

                return $category;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || 
            (isset($args['id']) && ! $args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];
        $category = $this->categoryRepository->findOrFail($id);

        if (strtolower($category->name) == "root") {
            throw new Exception(trans('admin::app.response.delete-category-root', ['name' => 'Category']));
        } else {
            try {
                Event::dispatch('catalog.category.delete.before', $id);

                $this->categoryRepository->delete($id);

                Event::dispatch('catalog.category.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Category'])];
            } catch (\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Category']));
            }
        }
    }
}
