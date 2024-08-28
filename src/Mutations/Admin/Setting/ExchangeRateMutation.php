<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\CurrencyRepository;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class ExchangeRateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CurrencyRepository $currencyRepository,
        protected ExchangeRateRepository $exchangeRateRepository
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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency'],
            'rate'            => 'required|numeric',
        ]);

        $currency = $this->currencyRepository->find($args['target_currency']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.invalid-target-currency'));
        }

        try {
            Event::dispatch('core.exchange_rate.create.before');

            $exchangeRate = $this->exchangeRateRepository->create($args);

            Event::dispatch('core.exchange_rate.create.after', $exchangeRate);

            return [
                'success'       => true,
                'message'       => trans('bagisto_graphql::app.admin.settings.exchange-rates.create-success'),
                'exchange_rate' => $exchangeRate,
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
            'target_currency' => ['required', 'unique:currency_exchange_rates,target_currency,'.$args['id']],
            'rate'            => 'required|numeric',
        ]);

        $exchangeRate = $this->exchangeRateRepository->find($args['id']);

        if (! $exchangeRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.not-found'));
        }

        $currency = $this->currencyRepository->find($args['target_currency']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.invalid-target-currency'));
        }

        try {
            Event::dispatch('core.exchange_rate.update.before', $exchangeRate->id);

            $exchangeRate = $this->exchangeRateRepository->update($args, $exchangeRate->id);

            Event::dispatch('core.exchange_rate.update.after', $exchangeRate);

            return [
                'success'       => true,
                'message'       => trans('bagisto_graphql::app.admin.settings.exchange-rates.update-success'),
                'exchange_rate' => $exchangeRate,
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
        $exchangeRate = $this->exchangeRateRepository->find($args['id']);

        if (! $exchangeRate) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.exchange-rates.not-found'));
        }

        try {
            Event::dispatch('core.exchange_rate.delete.before', $args['id']);

            $exchangeRate->delete();

            Event::dispatch('core.exchange_rate.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.exchange-rates.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update exchange rates.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function updateExchangeRates(mixed $rootValue, array $args, GraphQLContext $context)
    {
        try {
            app(config('services.exchange_api.'.config('services.exchange_api.default').'.class'))->updateRates();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.exchange-rates.update-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
