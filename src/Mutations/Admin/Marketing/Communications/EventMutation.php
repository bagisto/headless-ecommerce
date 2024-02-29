<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Marketing\Repositories\EventRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class EventMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Webkul\Marketing\Repositories\EventRepository $eventRepository
     * @return void
     */
    public function __construct(protected EventRepository $eventRepository)
    {
    }

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

        $params = $args['input'];

        $validator = Validator::make($params, [
            'name'        => 'required',
            'description' => 'required',
            'date'        => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $params['date'] = \Carbon\Carbon::parse($params['date'])->format('Y-m-d');

            $event = $this->eventRepository->create($params);

            return $event;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
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

        $params = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($params, [
            'name'        => 'required',
            'description' => 'required',
            'date'        => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $event = $this->eventRepository->findOrFail($id);

            $params['date'] = \Carbon\Carbon::parse($params['date'])->format('Y-m-d');

            $event = $this->eventRepository->update($params, $id);

            return $event;
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

        $event = $this->eventRepository->find($id);

        try {
            if ($event) {
                $event->delete();

                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.admin.marketing.communications.events.delete-success'),
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.events.delete-failed'),
            ];
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
