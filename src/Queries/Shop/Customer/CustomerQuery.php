<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Webkul\Core\Repositories\CountryStateRepository;
use Webkul\GraphQLAPI\Queries\BaseFilter;
use Webkul\Sales\Repositories\InvoiceRepository;

class CustomerQuery extends BaseFilter
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected InvoiceRepository $invoiceRepository,
        protected CountryStateRepository $countryStateRepository
    ) {}

    /**
     * Returns a current customer data.
     *
     * @return \Webkul\Customer\Contracts\Customer
     */
    public function get()
    {
        return bagisto_graphql()->authorize();
    }

    /**
     * Filter the query by the given input.
     */
    public function getTransactions(mixed $rootValue, array $args)
    {
        return $this->invoiceRepository->whereHas('order', function ($q) use ($args) {
            $q->where('customer_id', $args['customer_id']);
        })->get();
    }

    /**
     * Return the country name for the address
     */
    public function getCountryName(object $address): string
    {
        return core()->country_name($address->country);
    }

    /**
     * Return the state name for the address
     */
    public function getStateName(object $address): ?string
    {
        return $this->countryStateRepository->findOneWhere([
            'country_code' => $address->country,
            'code'         => $address->state,
        ])?->default_name;
    }
}
