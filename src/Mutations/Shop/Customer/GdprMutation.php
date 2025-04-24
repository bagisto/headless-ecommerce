<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GDPR\Repositories\GDPRDataRequestRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use App\Http\Controllers\Controller;

class GdprMutation extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected GDPRDataRequestRepository $gdprDataRequestRepository) {}

    /**
     * Store a GDPR data request.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        $customer = bagisto_graphql()->authorize();

        bagisto_graphql()->validate($args, [
            'type'    => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        try {
            Event::dispatch('customer.account.gdpr-request.create.before');

            $params = array_merge($args, [
                'status'        => 'pending',
                'customer_id'   => $customer->id,
                'customer_name' => $customer->first_name . ' ' . $customer->last_name,
                'email'         => $customer->email,
            ]);

            $gdprRequest = $this->gdprDataRequestRepository->create($params);

            Event::dispatch('customer.account.gdpr-request.create.after', $gdprRequest);
            Event::dispatch('customer.gdpr-request.create.after', $gdprRequest);

            return [
                'status'       => true,
                'message'      => trans('bagisto_graphql::app.admin.customers.gdpr.create-success'),
                'gdprRequest'  => $gdprRequest,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
