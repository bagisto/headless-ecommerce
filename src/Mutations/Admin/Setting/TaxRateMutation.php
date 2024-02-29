<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Tax\Repositories\TaxRateRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class TaxRateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Tax\Repositories\TaxRateRepository  $taxRateRepository
     * @return void
     */
    public function __construct(protected TaxRateRepository $taxRateRepository)
    {
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
            'identifier' => 'required|string|unique:tax_rates,identifier',
            'is_zip'     => 'sometimes',
            'zip_code'   => 'nullable',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|string',
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        if (isset($data['is_zip'])) {
            $data['is_zip'] = 1;

            unset($data['zip_code']);
        }

        try {
            Event::dispatch('tax.tax_rate.create.before');

            $taxRate = $this->taxRateRepository->create($data);

            Event::dispatch('tax.tax_rate.create.after', $taxRate);

            return $taxRate;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (
            empty($args['id'])
            || empty($args['input'])
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'identifier' => 'required|string|unique:tax_rates,identifier,'.$id,
            'is_zip'     => 'sometimes',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|string',
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $taxRate = $this->taxRateRepository->find($id);

        if (! $taxRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-rate.not-found'));
        }

        try {
            Event::dispatch('tax.tax_rate.update.before', $id);

            $taxRate = $this->taxRateRepository->update($data, $id);

            Event::dispatch('tax.tax_rate.update.after', $taxRate);

            return $taxRate;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
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
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $taxRate = $this->taxRateRepository->find($id);

        if (! $taxRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-rate.not-found'));
        }

        try {
            Event::dispatch('tax.tax_rate.delete.before', $id);

            $this->taxRateRepository->delete($id);

            Event::dispatch('tax.tax_rate.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.settings.tax-rates.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
