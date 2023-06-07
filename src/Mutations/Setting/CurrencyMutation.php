<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\CurrencyRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CurrencyMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\CurrencyRepository  $currencyRepository
     * @return void
     */
    public function __construct(
       protected CurrencyRepository $currencyRepository
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
            'code' => 'required|min:3|max:3|unique:currencies,code',
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('core.currency.create.before');
    
            $currency = $this->currencyRepository->create($data);
    
            Event::dispatch('core.currency.create.after', $currency);

            return $currency;

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
            'code' => ['required', 'unique:currencies,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('core.currency.update.before', $id);
    
            $currency = $this->currencyRepository->update($data, $id);
    
            Event::dispatch('core.currency.update.after', $currency);
            
            return $currency;
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

        $currency = $this->currencyRepository->findOrFail($id);

        if ($this->currencyRepository->count() == 1) {
            throw new Exception(trans('admin::app.settings.currencies.last-delete-error'));
        } else {
            try {
                Event::dispatch('core.currency.delete.before', $id);

                $this->currencyRepository->delete($id);

                Event::dispatch('core.currency.delete.after', $id);

                return ['success' => trans('admin::app.settings.currencies.delete-success')];
            } catch(\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Currency']));
            }
        }
    }
}
