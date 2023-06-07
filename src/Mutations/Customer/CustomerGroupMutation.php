<?php

namespace Webkul\GraphQLAPI\Mutations\Customer;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CustomerGroupMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @return void
     */
    public function __construct(
       protected CustomerGroupRepository $customerGroupRepository
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
            'code' => ['required', 'unique:customer_groups,code', new \Webkul\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $data['is_user_defined'] = (isset($data['is_user_defined']) && $data['is_user_defined']) ? $data['is_user_defined'] : 0;

            Event::dispatch('customer.customer_group.create.before');

            $customerGroup = $this->customerGroupRepository->create($data);

            Event::dispatch('customer.customer_group.create.after', $customerGroup);
            
            return $customerGroup;
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
            'code' => ['required', 'unique:customer_groups,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $data['is_user_defined'] = (isset($data['is_user_defined']) && $data['is_user_defined']) ? $data['is_user_defined'] : 0;

            Event::dispatch('customer.customer_group.update.before', $id);
    
            $customerGroup = $this->customerGroupRepository->update($data, $id);

            $customerGroup = $this->customerGroupRepository->find($id);
    
            Event::dispatch('customer.customer_group.update.after', $customerGroup);

            return $customerGroup;
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

        $customerGroup = $this->customerGroupRepository->findOrFail($id);

        if ($customerGroup->is_user_defined == 0) {
            throw new Exception(trans('admin::app.customers.customers.group-default'));
        } elseif ($customerGroup->customers && count($customerGroup->customers) > 0) {
            throw new Exception(trans('admin::app.response.customer-associate', ['name' => 'Customer Group']));
        } else {
            try {
                Event::dispatch('customer.customer_group.delete.before', $id);

                $this->customerGroupRepository->delete($id);

                Event::dispatch('customer.customer_group.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Customer Group'])];
            } catch(\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Customer Group']));
            }
        }
    }
}
