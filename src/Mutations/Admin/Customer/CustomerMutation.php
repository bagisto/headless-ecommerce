<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Customer\Repositories\CustomerNoteRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CustomerMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected CustomerNoteRepository $customerNoteRepository,
        protected CustomerGroupRepository $customerGroupRepository
    ) {}

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
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'required|unique:customers,email',
            'phone'             => 'unique:customers,phone',
            'date_of_birth'     => 'string|before:today',
            'customer_group_id' => 'required|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $data['password'] = bcrypt(rand(100000, 10000000));

        $data['is_verified'] = 1;

        $data['date_of_birth'] = ! empty($data['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $data['date_of_birth']).'00:00:01')->format('Y-m-d') : '';

        try {
            Event::dispatch('customer.registration.before');

            $customer = $this->customerRepository->create($data);

            Event::dispatch('customer.registration.after', $customer);

            $customer->success = trans('bagisto_graphql::app.admin.customers.customers.create-success');

            return $customer;
        } catch (\Exception $e) {
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
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'required|unique:customers,email,'.$id,
            'phone'             => 'unique:customers,phone,'.$id,
            'date_of_birth'     => 'date|before:today',
            'customer_group_id' => 'required|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $customer = $this->customerRepository->find($id);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            $data['status'] = $data['status'] ?? 0;

            $data['is_suspended'] = $data['is_suspended'] ?? 0;

            Event::dispatch('customer.customer.update.before');

            $customer = $this->customerRepository->update($data, $id);

            Event::dispatch('customer.customer.update.after', $customer);

            $customer->success = trans('bagisto_graphql::app.admin.customers.customers.update-success');

            return $customer;
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

        $customer = $this->customerRepository->find($id);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            if ($this->customerRepository->haveActiveOrders($customer)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.delete-order-pending'));
            }

            Event::dispatch('customer.customer.delete.before', $id);

            $this->customerRepository->delete($id);

            Event::dispatch('customer.customer.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.customers.customers.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * To store the response of the note.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeNotes($rootValue, array $args, GraphQLContext $context)
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
            'note' => 'string|required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $customer = $this->customerRepository->find($id);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            Event::dispatch('customer.note.create.before', $id);

            $customerNote = $this->customerNoteRepository->create([
                'customer_id'       => $id,
                'note'              => $data['note'],
                'customer_notified' => $data['customer_notified'] ?? 0,
            ]);

            Event::dispatch('customer.note.create.after', $customerNote);

            $customerNote->success = trans('bagisto_graphql::app.admin.customers.customers.note-created-success');

            return $customerNote;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
