<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Catalog\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Rules\Slug;
use Webkul\GraphQLAPI\Validators\CustomException;

class CategoryMutation extends Controller
{
    /**
     * localeFields array
     *
     * @var array
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
     * @return void
     */
    public function __construct(protected CategoryRepository $categoryRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'slug'          => ['required', 'unique:category_translations,slug', new Slug],
            'name'          => 'required',
            'description'   => 'required_if:display_mode,==,description_only,products_and_description',
            'position'      => 'required',
            'logo_path'     => 'array',
            'banner_path'   => 'array',
            'attributes'    => 'required|array',
            'attributes.*'  => 'required',
        ]);

        try {
            $imageUrl = '';

            if (! empty($args['logo_path'])) {
                $imageUrl = current($args['logo_path']);

                unset($args['logo_path']);
            }

            $bannerPath = '';

            if (! empty($args['banner_path'])) {
                $bannerPath = current($args['banner_path']);

                unset($args['banner_path']);
            }

            Event::dispatch('catalog.category.create.before');

            $category = $this->categoryRepository->create($args);

            Event::dispatch('catalog.category.create.after', $category);

            bagisto_graphql()->uploadImage($category, $imageUrl, 'category/', 'logo_path');

            bagisto_graphql()->uploadImage($category, $bannerPath, 'category/', 'banner_path');

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.catalog.categories.create-success'),
                'category' => $category,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'position'      => 'required',
            'logo_path'     => 'array',
            'banner_path'   => 'array',
            'attributes'    => 'required|array',
            'attributes.*'  => 'required',
        ]);

        $category = $this->categoryRepository->find($args['id']);

        if (! $category) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.categories.not-found'));
        }

        $locale = $args['locale'] ?? app()->getLocale();

        $args[$locale] = [];

        foreach ($this->localeFields as $field) {
            if (isset($args[$field])) {
                $args[$locale][$field] = $args[$field];

                unset($args[$field]);
            }
        }

        bagisto_graphql()->validate($args, [
            $locale.'.slug' => ['required', new Slug, function ($value, $fail) use ($args) {
                if (! $this->categoryRepository->isSlugUnique($args['id'], $value)) {
                    $fail(trans('bagisto_graphql::app.admin.catalog.categories.already-taken'));
                }
            }],
            $locale.'.name'        => 'required',
            $locale.'.description' => 'required_if:display_mode,==,description_only,products_and_description',
            'image.*'              => 'mimes:jpeg,jpg,bmp,png',
            'parent_id'            => 'required|exists:categories,id',
        ]);

        try {
            $imageUrl = '';

            if (! empty($args['logo_path'])) {
                $imageUrl = current($args['logo_path']);

                unset($args['logo_path']);
            }

            $bannerPath = '';

            if (! empty($args['banner_path'])) {
                $bannerPath = current($args['banner_path']);

                unset($args['banner_path']);
            }

            $category = $this->categoryRepository->update($args, $category->id);

            Event::dispatch('catalog.category.update.after', $category);

            bagisto_graphql()->uploadImage($category, $imageUrl, 'category/', 'logo_path');

            bagisto_graphql()->uploadImage($category, $bannerPath, 'category/', 'banner_path');

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.catalog.categories.update-success'),
                'category' => $category,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function delete(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $category = $this->categoryRepository->find($args['id']);

        if (! $category) {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.categories.not-found'));
        }

        if (strtolower($category->name) == 'root') {
            throw new CustomException(trans('bagisto_graphql::app.admin.catalog.categories.root-delete'));
        }

        try {
            Event::dispatch('catalog.category.delete.before', $args['id']);

            $category->delete();

            Event::dispatch('catalog.category.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.catalog.categories.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
