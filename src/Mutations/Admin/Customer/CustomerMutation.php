<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Checkout\Facades\Cart;
use Webkul\Core\Rules\PhoneNumber;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'email|required|unique:customers,email',
            'phone'             => ['unique:customers,phone', new PhoneNumber],
            'date_of_birth'     => 'string|before:today',
            'customer_group_id' => 'required|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
        ]);

        $args['password'] = bcrypt(rand(100000, 10000000));

        $args['is_verified'] = 1;

        $args['date_of_birth'] = ! empty($data['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $args['date_of_birth']).'00:00:01')->format('Y-m-d') : '';

        try {
            Event::dispatch('customer.registration.before');

            $customer = $this->customerRepository->create($args);

            Event::dispatch('customer.registration.after', $customer);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.customers.customers.create-success'),
                'customer' => $customer,
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
            'first_name'        => 'string|required',
            'last_name'         => 'string|required',
            'gender'            => 'required',
            'email'             => 'email|required|unique:customers,email,'.$args['id'],
            'phone'             => ['unique:customers,phone,'.$args['id'], new PhoneNumber],
            'date_of_birth'     => 'date|before:today',
            'customer_group_id' => 'required|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
        ]);

        $customer = $this->customerRepository->find($args['id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        $args['date_of_birth'] = ! empty($args['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $args['date_of_birth']).'00:00:01')->format('Y-m-d') : '';

        try {
            $args['status'] = $args['status'] ?? 0;

            $args['is_suspended'] = $args['is_suspended'] ?? 0;

            Event::dispatch('customer.customer.update.before');

            $customer = $this->customerRepository->update($args, $customer->id);

            Event::dispatch('customer.customer.update.after', $customer);

            return [
                'success'  => true,
                'message'  => trans('bagisto_graphql::app.admin.customers.customers.update-success'),
                'customer' => $customer,
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
        $customer = $this->customerRepository->find($args['id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            if ($this->customerRepository->haveActiveOrders($customer)) {
                throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.delete-order-pending'));
            }

            Event::dispatch('customer.customer.delete.before', $args['id']);

            $customer->delete();

            Event::dispatch('customer.customer.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.customers.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * To store customer notes
     *
     * @return array
     *
     * @throws CustomException
     */
    public function storeNotes(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'note' => 'string|required',
        ]);

        $customer = $this->customerRepository->find($args['id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            Event::dispatch('customer.note.create.before', $args['id']);

            $note = $this->customerNoteRepository->create([
                'customer_id'       => $args['id'],
                'note'              => $args['note'],
                'customer_notified' => $args['customer_notified'] ?? 0,
            ]);

            Event::dispatch('customer.note.create.after', $note);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.customers.note-created-success'),
                'note'    => $note,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Create order for the customer
     *
     * @return array
     *
     * @throws CustomException
     */
    public function createOrder(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = $this->customerRepository->find($args['customer_id']);

        if (! $customer) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.customers.not-found'));
        }

        try {
            $cart = Cart::createCart([
                'customer'  => $customer,
                'is_active' => false,
            ]);

            $cart->refresh();

            return [
                'success'            => true,
                'jump_to_section'    => 'create_order',
                'cart'               => $cart,
                'customer_addresses' => $customer->addresses,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
