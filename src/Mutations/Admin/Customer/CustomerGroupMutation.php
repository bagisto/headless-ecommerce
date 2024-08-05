<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Rules\Code;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CustomerGroupMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerGroupRepository $customerGroupRepository) {}

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

        bagisto_graphql()->validate($data, [
            'code' => ['required', 'unique:customer_groups,code', new Code],
            'name' => 'required',
        ]);

        try {
            $data['is_user_defined'] = $data['is_user_defined'] ?? 0;

            Event::dispatch('customer.customer_group.create.before');

            $customerGroup = $this->customerGroupRepository->create($data);

            Event::dispatch('customer.customer_group.create.after', $customerGroup);

            $customerGroup->success = trans('bagisto_graphql::app.admin.customers.groups.create-success');

            return $customerGroup;
        } catch (\Exception $e) {
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

        bagisto_graphql()->validate($data, [
            'code' => ['required', 'unique:customer_groups,code,'.$id, new Code],
            'name' => 'required',
        ]);

        $customerGroup = $this->customerGroupRepository->find($id);

        if (! $customerGroup) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.not-found'));
        }

        try {
            $data['is_user_defined'] = $data['is_user_defined'] ?? 0;

            Event::dispatch('customer.customer_group.update.before', $id);

            $customerGroup = $this->customerGroupRepository->update($data, $id);

            Event::dispatch('customer.customer_group.update.after', $customerGroup);

            $customerGroup->success = trans('bagisto_graphql::app.admin.customers.groups.update-success');

            return $customerGroup;
        } catch (\Exception $e) {
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

        $customerGroup = $this->customerGroupRepository->find($id);

        if (! $customerGroup) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.not-found'));
        }

        if (! $customerGroup->is_user_defined) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.user-define-error'));
        }

        if (count($customerGroup->customers)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.customer-associate'));
        }

        try {
            Event::dispatch('customer.customer_group.delete.before', $id);

            $this->customerGroupRepository->delete($id);

            Event::dispatch('customer.customer_group.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.groups.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
