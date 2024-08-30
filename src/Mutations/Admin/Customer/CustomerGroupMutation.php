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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'code' => ['required', 'unique:customer_groups,code', new Code],
            'name' => 'required',
        ]);

        try {
            $args['is_user_defined'] = 1;

            Event::dispatch('customer.customer_group.create.before');

            $customerGroup = $this->customerGroupRepository->create($args);

            Event::dispatch('customer.customer_group.create.after', $customerGroup);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.customers.groups.create-success'),
                'customer_group' => $customerGroup,
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
            'code' => ['required', 'unique:customer_groups,code,'.$args['id'], new Code],
            'name' => 'required',
        ]);

        $customerGroup = $this->customerGroupRepository->find($args['id']);

        if (! $customerGroup) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.groups.not-found'));
        }

        try {
            Event::dispatch('customer.customer_group.update.before', $customerGroup->id);

            $customerGroup = $this->customerGroupRepository->update($args, $customerGroup->id);

            Event::dispatch('customer.customer_group.update.after', $customerGroup);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.customers.groups.update-success'),
                'customer_group' => $customerGroup,
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
        $customerGroup = $this->customerGroupRepository->find($args['id']);

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
            Event::dispatch('customer.customer_group.delete.before', $args['id']);

            $customerGroup->delete();

            Event::dispatch('customer.customer_group.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.groups.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
