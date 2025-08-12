<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\OrderRepository;

class GdprQuary extends BaseFilter
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected CustomerAddressRepository $customerAddressRepository
    ) {}

    /**
     * Filter GDPR data requests for the authenticated customer.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

        $customer = bagisto_graphql()->authorize();

        $query->where('customer_id', $customer->id);

        $exactFilters = Arr::only($input, ['id', 'status', 'type', 'revoked_at']);

        $likeFilters = Arr::only($input, ['email', 'message']);

        $query = $this->applyLikeFilter($query, $likeFilters);

        return $query->where($exactFilters);
    }

    /**
     * Fetch a single GDPR request, ensuring it belongs to the customer.
     */
    public function getGdprRequest(Builder $query): Builder
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

        $customer = bagisto_graphql()->authorize();

        return $query->where('customer_id', $customer->id);
    }

    /**
     * Get the type of the query.
     */
    public function viewGdprData()
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

        $customer = bagisto_graphql()->authorize();

        try {
            $orders = $this->orderRepository->findWhere(['customer_id' => $customer->id])->toArray();

            $address = $this->customerAddressRepository->where('address_type', 'customer')->where('customer_id', $customer->id)->get();

            $param = [
                'customer' => $customer,
                'order'    => ! empty($orders) ? $orders : null,
                'address'  => ! empty($address) ? $address : null,
            ];

            if (is_null($param['order'])) {
                unset($param['order']);
            }

            if (is_null($param['address'])) {
                unset($param['address']);
            }

        } catch (\Exception $e) {
            $param = ['customer' => $customer];
        }

        return $param;
    }
}
