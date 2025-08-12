<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Tax\Repositories\TaxRateRepository;

class TaxCategoryMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected TaxCategoryRepository $taxCategoryRepository,
        protected TaxRateRepository $taxRateRepository
    ) {}

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
            'code'        => 'required|string|unique:tax_categories,code',
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'required|array|in:'.implode(',', $this->taxRateRepository->pluck('id')->toArray()),
        ]);

        try {
            Event::dispatch('tax.tax_category.create.before');

            $taxCategory = $this->taxCategoryRepository->create($args);

            // attach the categories in the tax map table
            $taxCategory->tax_rates()->sync($args['taxrates']);

            Event::dispatch('tax.tax_category.create.after', $taxCategory);

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.admin.settings.tax-category.create-success'),
                'tax_category' => $taxCategory,
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
            'code'        => 'required|string|unique:tax_categories,code,'.$args['id'],
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'required|array|in:'.implode(',', $this->taxRateRepository->pluck('id')->toArray()),
        ]);

        $taxCategory = $this->taxCategoryRepository->find($args['id']);

        if (! $taxCategory) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.not-found'));
        }

        try {
            Event::dispatch('tax.tax_category.update.before', $taxCategory->id);

            $taxCategory = $this->taxCategoryRepository->update($args, $taxCategory->id);

            // attach the categories in the tax map table
            $taxCategory->tax_rates()->sync($args['taxrates']);

            Event::dispatch('tax.tax_category.update.after', $taxCategory);

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.admin.settings.tax-category.update-success'),
                'tax_category' => $taxCategory,
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
        $taxCategory = $this->taxCategoryRepository->find($args['id']);

        if (! $taxCategory) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.not-found'));
        }

        try {
            Event::dispatch('tax.tax_category.delete.before', $args['id']);

            $taxCategory->delete();

            Event::dispatch('tax.tax_category.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.tax-category.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
