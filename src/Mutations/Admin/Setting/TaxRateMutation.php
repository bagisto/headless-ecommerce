<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Tax\Repositories\TaxRateRepository;

class TaxRateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected TaxRateRepository $taxRateRepository) {}

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
            'identifier' => 'required|string|unique:tax_rates,identifier',
            'is_zip'     => 'nullable',
            'zip_code'   => 'nullable',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|in:'.implode(',', (core()->countries()->pluck('code')->toArray())),
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        if (isset($args['is_zip'])) {
            $args['is_zip'] = 1;

            unset($args['zip_code']);
        }

        try {
            Event::dispatch('tax.tax_rate.create.before');

            $taxRate = $this->taxRateRepository->create($args);

            Event::dispatch('tax.tax_rate.create.after', $taxRate);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.settings.tax-rates.create-success'),
                'tax_rate' => $taxRate,
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
            'identifier' => 'required|string|unique:tax_rates,identifier,'.$args['id'],
            'is_zip'     => 'sometimes',
            'zip_from'   => 'nullable|required_with:is_zip',
            'zip_to'     => 'nullable|required_with:is_zip,zip_from',
            'country'    => 'required|in:'.implode(',', (core()->countries()->pluck('code')->toArray())),
            'tax_rate'   => 'required|numeric|min:0.0001',
        ]);

        $taxRate = $this->taxRateRepository->find($args['id']);

        if (! $taxRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-rate.not-found'));
        }

        try {
            Event::dispatch('tax.tax_rate.update.before', $taxRate->id);

            $taxRate = $this->taxRateRepository->update($args, $taxRate->id);

            Event::dispatch('tax.tax_rate.update.after', $taxRate);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.settings.tax-rates.update-success'),
                'tax_rate' => $taxRate,
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
        $taxRate = $this->taxRateRepository->find($args['id']);

        if (! $taxRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.tax-rates.not-found'));
        }

        try {
            Event::dispatch('tax.tax_rate.delete.before', $args['id']);

            $taxRate->delete();

            Event::dispatch('tax.tax_rate.delete.after', $args['id']);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.settings.tax-rates.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
