<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Tax\Http\Controllers\Controller;
use Webkul\Tax\Repositories\TaxRateRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class TaxRateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Tax\Repositories\TaxRateRepository  $taxRateRepository
     * @return void
     */
    public function __construct(
        protected  TaxRateRepository $taxRateRepository
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
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'identifier' => 'required|string|unique:tax_rates,identifier',
            'is_zip'     => 'sometimes',
            'zip_code'   => 'sometimes|required_without:is_zip',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|string',
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (isset($data['is_zip'])) {
                $data['is_zip'] = 1;

                unset($data['zip_code']);
            }

            Event::dispatch('tax.tax_rate.create.before');

            $taxRate = $this->taxRateRepository->create($data);

            Event::dispatch('tax.tax_rate.create.after', $taxRate);

            return $taxRate;
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
        if (!isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'identifier' => 'required|string|unique:tax_rates,identifier,' . $id,
            'is_zip'     => 'sometimes',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|string',
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('tax.tax_rate.update.before', $id);

            $taxRate = $this->taxRateRepository->update($data, $id);

            Event::dispatch('tax.tax_rate.update.after', $taxRate);

            return $taxRate;
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
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $taxRate = $this->taxRateRepository->findOrFail($id);

        try {
            Event::dispatch('tax.tax_rate.delete.before', $id);

            $this->taxRateRepository->delete($id);

            Event::dispatch('tax.tax_rate.delete.after', $id);

            return ['success' => trans('admin::app.response.delete-success', ['name' => 'Tax Rate'])];
        } catch (\Exception $e) {
            throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Tax Rate']));
        }
    }
}
