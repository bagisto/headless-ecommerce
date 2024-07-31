<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\SubscribersListRepository;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Models\Order;

class AccountMutation extends Controller
{
    /**
     * allowedImageMimeTypes array
     */
    protected $allowedImageMimeTypes = [
        'bmp'  => 'image/bmp',
        'jpe'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg'  => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected SubscribersListRepository $subscriptionRepository
    ) {}

    /**
     * Returns a current customer data.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($rootValue, array $args, GraphQLContext $context)
    {
        if (auth()->check()) {
            $customer = $this->customerRepository->find(auth()->user()->id);
        }

        $isCustomer = ! empty($customer);

        return [
            'status'   => $isCustomer,
            'customer' => $customer ?? null,
            'message'  => $isCustomer
                            ? trans('bagisto_graphql::app.shop.customers.account.profile.customer-details')
                            : trans('bagisto_graphql::app.shop.customers.no-login-customer'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $validator = Validator::make($args, [
            'first_name'                => 'required|string',
            'last_name'                 => 'required|string',
            'gender'                    => 'required|in:Other,Male,Female',
            'date_of_birth'             => 'date|before:today',
            'email'                     => 'required|email|unique:customers,email,'.$customer->id,
            'new_password'              => 'confirmed|min:6|required_with:current_password',
            'new_password_confirmation' => 'required_with:new_password',
            'current_password'          => 'required_with:new_password',
            'image.*'                   => 'mimes:bmp,jpeg,jpg,png,webp',
            'upload_type'               => 'nullable|in:path,base64,file',
            'phone'                     => 'required|unique:customers,phone,'.$customer->id,
            'subscribed_to_news_letter' => 'nullable',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        $args['subscribed_to_news_letter'] = $args['subscribed_to_news_letter'] ?? 0;

        $isPasswordChanged = false;

        try {
            $args['date_of_birth'] = ! empty($args['date_of_birth']) ? Carbon::createFromTimeString(str_replace('/', '-', $args['date_of_birth']).'00:00:01')->format('Y-m-d') : '';

            if (! empty($args['current_password'])) {
                if (Hash::check($args['current_password'], $customer->password)) {
                    $isPasswordChanged = true;

                    $args['password'] = bcrypt($args['new_password']);
                } else {
                    throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.profile.password-unmatch'));
                }
            } else {
                unset($args['new_password']);
            }

            Event::dispatch('customer.update.before');

            if ($customer = $this->customerRepository->update($args, $customer->id)) {
                if ($isPasswordChanged) {
                    Event::dispatch('user.admin.update-password', $customer);
                }

                Event::dispatch('customer.update.after', $customer);

                $this->subscriptionRepository->updateOrCreate(
                    ['email' => $args['email']],
                    [
                        'customer_id'   => $customer->id,
                        'channel_id'    => core()->getCurrentChannel()->id,
                        'is_subscribed' => $args['subscribed_to_news_letter'],
                        'token'         => uniqid(),
                    ]
                );

                if (
                    ! empty($args['upload_type'])
                    && $args['upload_type'] == 'file'
                ) {
                    if (! empty($args['image'])) {
                        $customer->image = $args['image']->storePublicly('customer/'.$customer->id);

                        $customer->save();
                    } else {
                        if ($customer->image) {
                            Storage::delete($customer->image);
                        }

                        $customer->image = null;

                        $customer->save();
                    }
                }

                if (
                    ! empty($args['upload_type'])
                    && in_array($args['upload_type'], ['path', 'base64'])
                    && ! empty($args['image_url'])
                ) {
                    $args['save_path'] = 'customer/'.$customer->id;

                    bagisto_graphql()->saveImageByURL($customer, $args, 'image_url');
                }

                return [
                    'status'   => ! empty($customer),
                    'customer' => $customer,
                    'message'  => trans('bagisto_graphql::app.shop.customers.account.profile.update-success'),
                ];
            } else {
                throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.profile.update-fail'));
            }
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
        if (! $customer = auth()->user()) {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.no-login-customer'));
        }

        $validator = Validator::make($args, [
            'password' => 'required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            if (Hash::check($args['password'], $customer->password)) {
                if ($customer->orders->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_PROCESSING])->first()) {
                    return [
                        'status'  => false,
                        'message' => trans('bagisto_graphql::app.shop.customers.account.profile.order-pending'),
                    ];
                } else {
                    $this->customerRepository->delete($customer->id);

                    return [
                        'status'  => true,
                        'message' => trans('bagisto_graphql::app.shop.customers.account.profile.delete-success'),
                    ];
                }
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.shop.customers.account.profile.wrong-password'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
