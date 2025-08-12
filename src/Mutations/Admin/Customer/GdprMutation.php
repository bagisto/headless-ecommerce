<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Customer;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GDPR\Repositories\GDPRDataRequestRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class GdprMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected GDPRDataRequestRepository $gdprDataRequestRepository) {}

    /**
     * Update the specified GDPR request.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function update(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'id'      => 'required|integer',
            'status'  => 'required|string',
            'message' => 'required|string',
            'type'    => 'required|string',
        ]);

        $gdprRequest = $this->gdprDataRequestRepository->find($args['id']);

        if (! $gdprRequest) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.gdpr.not-found'));
        }

        try {
            Event::dispatch('customer.gdpr-request.update.before', $gdprRequest->id);

            $gdprRequest = $this->gdprDataRequestRepository->update([
                'status'  => $args['status'],
                'message' => $args['message'],
                'type'    => $args['type'],
            ], $gdprRequest->id);

            Event::dispatch('customer.gdpr-request.update.after', $gdprRequest);

            return [
                'success' => true,
                'status'  => $gdprRequest->status,
                'message' => $gdprRequest->message,
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
        $gdpr = $this->gdprDataRequestRepository->find($args['id']);

        if (! $gdpr) {
            throw new CustomException(trans('bagisto_graphql::app.admin.customers.gdpr.not-found'));
        }

        try {
            $gdpr->delete();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.customers.gdpr.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
