<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\CurrencyRepository;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ExchangeRateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\CurrencyRepository  $currencyRepository
     * @param  \Webkul\Core\Repositories\ExchangeRateRepository  $exchangeRateRepository
     * @return void
     */
    public function __construct(
        protected CurrencyRepository $currencyRepository,
        protected ExchangeRateRepository $exchangeRateRepository
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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency'],
            'rate'            => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $currency = $this->currencyRepository->findOrFail($data['target_currency']);

        if (!isset($currency->id)) {
            throw new Exception(trans('bagisto_graphql::app.admin.settings.exchange_rates.error-invalid-target-currency'));
        }

        try {
            Event::dispatch('core.exchange_rate.create.before');

            $exchangeRate = $this->exchangeRateRepository->create($data);

            Event::dispatch('core.exchange_rate.create.after', $exchangeRate);

            return $exchangeRate;
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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency,' . $id],
            'rate'            => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('core.exchange_rate.update.before', $id);

            $exchangeRate = $this->exchangeRateRepository->update($data, $id);

            Event::dispatch('core.exchange_rate.update.after', $exchangeRate);

            return $exchangeRate;
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

        $exchangeRate = $this->exchangeRateRepository->findOrFail($id);

        if ($this->exchangeRateRepository->count() == 1) {
            throw new Exception(trans('admin::app.settings.exchange_rates.last-delete-error'));
        } else {
            try {
                Event::dispatch('core.exchange_rate.delete.before', $id);

                $this->exchangeRateRepository->delete($id);

                session()->flash('success', trans('admin::app.settings.exchange_rates.delete-success'));

                Event::dispatch('core.exchange_rate.delete.after', $id);

                return ['success' => trans('bagisto_graphql::app.admin.settings.exchange_rates.delete-success')];
            } catch (\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-error', ['name' => 'Exchange rate']));
            }
        }
    }
}
