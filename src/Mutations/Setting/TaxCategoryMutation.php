<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Tax\Http\Controllers\Controller;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TaxCategoryMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Tax\Repositories\TaxCategoryRepository  $taxCategoryRepository
     * @return void
     */
    public function __construct(
       protected TaxCategoryRepository $taxCategoryRepository
    )
    {
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
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'code'        => 'required|string|unique:tax_categories,code',
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'array|required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('tax.tax_category.create.before');
    
            $taxCategory = $this->taxCategoryRepository->create($data);
    
            //attach the categories in the tax map table
            $taxCategoryRepository = $this->taxCategoryRepository->attachOrDetach($taxCategory, $data['taxrates']);
    
            Event::dispatch('tax.tax_category.create.after', $taxCategory);
            
            return $taxCategory;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];
        
        $validator = Validator::make($data, [
            'code'        => 'required|string|unique:tax_categories,code,' . $id,
            'name'        => 'required|string',
            'description' => 'required|string',
            'taxrates'    => 'array|required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('tax.tax_category.update.before', $id);
    
            $taxCategory = $this->taxCategoryRepository->update($data, $id);
    
            Event::dispatch('tax.tax_category.update.after', $taxCategory);

            if (! $taxCategory) {
                throw new Exception(trans('admin::app.settings.tax-categories.update-error'));
            }
    
            $taxRates = $data['taxrates'];
    
            //attach the categories in the tax map table
            $this->taxCategoryRepository->attachOrDetach($taxCategory, $taxRates);

            return $taxCategory;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $taxCategory = $this->taxCategoryRepository->findOrFail($id);
    
        try {
            Event::dispatch('tax.tax_category.delete.before', $id);

            $this->taxCategoryRepository->delete($id);

            Event::dispatch('tax.tax_category.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Tax Category'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Tax Category']));
        }
    }
}
