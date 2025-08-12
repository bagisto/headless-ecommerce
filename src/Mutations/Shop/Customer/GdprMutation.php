<?php

namespace Webkul\GraphQLAPI\Mutations\Shop\Customer;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\GDPR\Repositories\GDPRDataRequestRepository;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sales\Repositories\OrderRepository;

class GdprMutation extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected GDPRDataRequestRepository $gdprDataRequestRepository,
        protected OrderRepository $orderRepository,
        protected CustomerAddressRepository $customerAddressRepository
    ) {}

    /**
     * Store a GDPR data request.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

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
                'customer_name' => $customer->first_name.' '.$customer->last_name,
                'email'         => $customer->email,
            ]);

            $gdprRequest = $this->gdprDataRequestRepository->create($params);

            Event::dispatch('customer.account.gdpr-request.create.after', $gdprRequest);
            Event::dispatch('customer.gdpr-request.create.after', $gdprRequest);

            return [
                'status'       => true,
                'message'      => trans('bagisto_graphql::app.shop.customers.account.gdpr.create-success'),
                'gdprRequest'  => $gdprRequest,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Revoke GDPR request.
     */
    public function revoke($rootValue, array $args, GraphQLContext $context)
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

        $customer = bagisto_graphql()->authorize();

        $data = $this->gdprDataRequestRepository->findWhere([
            'id'          => $args['id'],
            'customer_id' => $customer->id,
            'status'      => 'pending',
        ])->first();

        if (! $data) {
            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.shop.customers.account.gdpr.revoke-failed'),
            ];
        }

        Event::dispatch('customer.account.gdpr-request.update.before');

        $gdprRequest = $this->gdprDataRequestRepository->update([
            'status'     => 'revoked',
            'revoked_at' => Carbon::now(),
        ], $args['id']);

        Event::dispatch('customer.account.gdpr-request.update.after', $gdprRequest);

        Event::dispatch('customer.gdpr-request.update.after', $gdprRequest);

        return [
            'status'       => true,
            'message'      => trans('bagisto_graphql::app.shop.customers.account.gdpr.revoked-successfully'),
            'gdprRequest'  => $gdprRequest,
        ];
    }

    /**
     * Download the GDPR data for the authenticated customer.
     *
     * @return array
     */
    public function downloadGdprData(mixed $rootValue, array $args, GraphQLContext $context)
    {
        if (core()->getConfigData('general.gdpr.settings.enabled') != '1') {
            throw new CustomException(trans('bagisto_graphql::app.shop.customers.account.gdpr.not-enabled'));
        }

        $customer = bagisto_graphql()->authorize();

        try {
            $orders = $this->orderRepository->findWhere(['customer_id' => $customer->id])->toArray();

            $address = $this->customerAddressRepository->where('address_type', 'customer')
                ->where('customer_id', $customer->id)
                ->get()
                ->toArray();

            $param = [
                'customerInformation' => $customer,
                'order'               => ! empty($orders) ? $orders : null,
                'address'             => ! empty($address) ? $address : null,
            ];

            if (is_null($param['order'])) {
                unset($param['order']);
            }

            if (is_null($param['address'])) {
                unset($param['address']);
            }
        } catch (\Exception $e) {
            $param = ['customerInformation' => $customer];
        }

        $pdf = Pdf::loadView('shop::customers.account.gdpr.pdf', compact('param'));

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'customer-info-'.now()->format('Y-m-d-His').'.pdf';

        $path = "gdpr/{$customer->id}/{$fileName}";

        Storage::put($path, $pdf->output(), 'public');

        $base64 = base64_encode(file_get_contents(Storage::url($path)));

        Storage::delete($path);

        return [
            'success'  => true,
            'string'   => $base64,
            'download' => [
                'file_name' => $fileName,
                'extension' => 'pdf',
            ],
        ];
    }
}
