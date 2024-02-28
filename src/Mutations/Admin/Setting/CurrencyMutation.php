<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use Webkul\Core\Rules\Code;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Webkul\Core\Repositories\CurrencyRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class CurrencyMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\CurrencyRepository  $currencyRepository
     * @return void
     */
    public function __construct(protected CurrencyRepository $currencyRepository)
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
            'code' => 'required|min:3|max:3|unique:currencies,code',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            Event::dispatch('core.currency.create.before');

            $currency = $this->currencyRepository->create($data);

            Event::dispatch('core.currency.create.after', $currency);

            return $currency;
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
            'code' => ['required', 'unique:currencies,code,'.$id, new Code],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $currency = $this->currencyRepository->find($id);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.not-found'));
        }

        try {
            Event::dispatch('core.currency.update.before', $id);

            $currency = $this->currencyRepository->update($data, $id);

            Event::dispatch('core.currency.update.after', $currency);

            return $currency;
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

        $currency = $this->currencyRepository->find($id);

        if (! $currency) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.not-found'));
        }

        if ($this->currencyRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.last-delete-error'));
        }

        try {
            Event::dispatch('core.currency.delete.before', $id);

            $this->currencyRepository->delete($id);

            Event::dispatch('core.currency.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.settings.currencies.delete-success')];
        } catch(\Exception $e) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.currencies.delete-error'));
        }
    }
}
