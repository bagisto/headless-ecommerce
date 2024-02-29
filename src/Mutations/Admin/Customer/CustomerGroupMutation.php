<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class CustomerGroupMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Customer\Repositories\CustomerGroupRepository  $customerGroupRepository
     * @return void
     */
    public function __construct(protected CustomerGroupRepository $customerGroupRepository)
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
            'code' => ['required', 'unique:customer_groups,code', new Code],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $data['is_user_defined'] = ! empty($data['is_user_defined']) ? $data['is_user_defined'] : 0;

            Event::dispatch('customer.customer_group.create.before');

            $customerGroup = $this->customerGroupRepository->create($data);

            Event::dispatch('customer.customer_group.create.after', $customerGroup);

            return $customerGroup;
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
            'code' => ['required', 'unique:customer_groups,code,'.$id, new Code],
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $data['is_user_defined'] = ! empty($data['is_user_defined']) ? $data['is_user_defined'] : 0;

            Event::dispatch('customer.customer_group.update.before', $id);

            $customerGroup = $this->customerGroupRepository->update($data, $id);

            $customerGroup = $this->customerGroupRepository->find($id);

            Event::dispatch('customer.customer_group.update.after', $customerGroup);

            return $customerGroup;
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

        $customerGroup = $this->customerGroupRepository->findOrFail($id);

        if ($customerGroup->is_user_defined == 0) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.user-define-error'));
        }

        if (
            $customerGroup->customers
            && count($customerGroup->customers)
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.customer-associate'));
        }

        try {
            Event::dispatch('customer.customer_group.delete.before', $id);

            $this->customerGroupRepository->delete($id);

            Event::dispatch('customer.customer_group.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.customers.groups.delete-success')];
        } catch(Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
