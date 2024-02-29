<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\CurrencyRepository;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency'],
            'rate'            => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $currency = $this->currencyRepository->find($data['target_currency']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.invalid-target-currency'));
        }

        try {
            Event::dispatch('core.exchange_rate.create.before');

            $exchangeRate = $this->exchangeRateRepository->create($data);

            Event::dispatch('core.exchange_rate.create.after', $exchangeRate);

            return $exchangeRate;
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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency,'.$id],
            'rate'            => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $currency = $this->currencyRepository->find($data['target_currency']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.invalid-target-currency'));
        }

        try {
            Event::dispatch('core.exchange_rate.update.before', $id);

            $exchangeRate = $this->exchangeRateRepository->update($data, $id);

            Event::dispatch('core.exchange_rate.update.after', $exchangeRate);

            return $exchangeRate;
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

        $exchangeRate = $this->exchangeRateRepository->find($id);

        if (! $exchangeRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.not-found'));
        }

        if ($this->exchangeRateRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.last-delete-error'));
        }

        try {
            Event::dispatch('core.exchange_rate.delete.before', $id);

            $this->exchangeRateRepository->delete($id);

            Event::dispatch('core.exchange_rate.delete.after', $id);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.exchange-rates.delete-success'),
            ];
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
