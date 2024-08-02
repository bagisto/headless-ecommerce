<?php

namespace Webkul\GraphQLAPI\Queries\Shop\Customer;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\CountryStateRepository;
use Webkul\Customer\Repositories\CustomerRepository;
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
        protected CustomerRepository $customerRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CountryStateRepository $countryStateRepository
    ) {}

    public function getTransactions($rootValue, array $args, GraphQLContext $context)
    {
        return $this->invoiceRepository->whereHas('order', function ($q) use ($args) {
            $q->where('customer_id', $args['customer_id']);
        })->get();
    }

    /**
     * Return the country name for the address
     */
    public function getCountryName($rootValue, array $args, GraphQLContext $context): string
    {
        return core()->country_name($rootValue->country);
    }

    /**
     * Return the state name for the address
     */
    public function getStateName($rootValue, array $args, GraphQLContext $context): ?string
    {
        return $this->countryStateRepository->findOneWhere([
            'code' => $rootValue->state,
        ])?->default_name;
    }
}
