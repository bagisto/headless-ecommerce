<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\CurrencyRepository;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\CustomException;

class CurrencyMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CurrencyRepository $currencyRepository) {}

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
            'code' => ['required', 'min:3', 'max:3', 'unique:currencies,code', new Code],
            'name' => ['required'],
        ]);

        try {
            Event::dispatch('core.currency.create.before');

            $currency = $this->currencyRepository->create($args);

            Event::dispatch('core.currency.create.after', $currency);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.settings.currencies.create-success'),
                'currency' => $currency,
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
            'code' => ['required', 'min:3', 'max:3', 'unique:currencies,code,'.$args['id'], new Code],
            'name' => 'required',
        ]);

        $currency = $this->currencyRepository->find($args['id']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.not-found'));
        }

        unset($args['code']);

        try {
            Event::dispatch('core.currency.update.before', $currency->id);

            $currency = $this->currencyRepository->update($args, $currency->id);

            Event::dispatch('core.currency.update.after', $currency);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.settings.currencies.update-success'),
                'currency' => $currency,
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
        $currency = $this->currencyRepository->find($args['id']);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.not-found'));
        }

        if ($this->currencyRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.last-delete-error'));
        }

        if (core()->getBaseCurrencyCode() == $currency->code) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.default-delete-error'));
        }

        if ($this->currencyRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.last-delete-error'));
        }

        try {
            Event::dispatch('core.currency.delete.before', $args['id']);

            $currency->delete();

            Event::dispatch('core.currency.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.currencies.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.delete-error'));
        }
    }
}
