<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Tax\Repositories\TaxRateRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class TaxCategoryMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Tax\Repositories\TaxCategoryRepository  $taxCategoryRepository
     * @param  \Webkul\Tax\Repositories\TaxRateRepository  $taxRateRepository
     *
     * @return void
     */
    public function __construct(
        protected TaxCategoryRepository $taxCategoryRepository,
        protected TaxRateRepository $taxRateRepository
    ) {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'        => 'required|string|unique:tax_categories,code',
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'array|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $tacRateIdsCollection = collect($data['taxrates']);

        $diff = $tacRateIdsCollection->diff($this->taxRateRepository->whereIn('id', $data['taxrates'])->pluck('id'));

        if (count($diff->all())) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.tax-rate-not-found', ['ids' => implode(', ', $diff->all())]));
        }

        try {
            Event::dispatch('tax.tax_category.create.before');

            $taxCategory = $this->taxCategoryRepository->create($data);

            //attach the categories in the tax map table
            $taxCategory->tax_rates()->sync($data['taxrates']);

            Event::dispatch('tax.tax_category.create.after', $taxCategory);

            return $taxCategory;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'        => 'required|string|unique:tax_categories,code,'.$id,
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'array|required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $taxCategory = $this->taxCategoryRepository->find($id);

        if (! $taxCategory) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.not-found'));
        }

        $tacRateIdsCollection = collect($data['taxrates']);

        $diff = $tacRateIdsCollection->diff($this->taxRateRepository->whereIn('id', $data['taxrates'])->pluck('id'));

        if (count($diff->all())) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.tax-rate-not-found', ['ids' => implode(', ', $diff->all())]));
        }

        try {
            Event::dispatch('tax.tax_category.update.before', $id);

            $taxCategory = $this->taxCategoryRepository->update($data, $id);

            Event::dispatch('tax.tax_category.update.after', $taxCategory);

            if (! $taxCategory) {
                throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.update-error'));
            }

            //attach the categories in the tax map table
            $taxCategory->tax_rates()->sync($data['taxrates']);

            return $taxCategory;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $taxCategory = $this->taxCategoryRepository->find($id);

        if (! $taxCategory) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-category.not-found'));
        }

        try {
            Event::dispatch('tax.tax_category.delete.before', $id);

            $this->taxCategoryRepository->delete($id);

            Event::dispatch('tax.tax_category.delete.after', $id);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.tax-category.delete-success'),
            ];
        } catch(\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
