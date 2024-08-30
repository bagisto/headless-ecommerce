<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\EventRepository;

class EventMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected EventRepository $eventRepository) {}

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
            'name'        => 'required',
            'description' => 'required',
            'date'        => 'required',
        ]);

        try {
            $args['date'] = Carbon::parse($args['date'])->format('Y-m-d');

            Event::dispatch('marketing.events.create.before');

            $event = $this->eventRepository->create($args);

            Event::dispatch('marketing.events.create.after', $event);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.events.create-success'),
                'event'   => $event,
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
            'name'        => 'required',
            'description' => 'required',
            'date'        => 'required',
        ]);

        $event = $this->eventRepository->find($args['id']);

        if (! $event) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.events.not-found'));
        }

        try {
            $args['date'] = Carbon::parse($args['date'])->format('Y-m-d');

            Event::dispatch('marketing.events.update.before', $event->id);

            $event = $this->eventRepository->update($args, $event->id);

            Event::dispatch('marketing.events.update.after', $event);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.events.update-success'),
                'event'   => $event,
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
        $event = $this->eventRepository->find($args['id']);

        if (! $event) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.events.not-found'));
        }

        try {
            Event::dispatch('marketing.events.delete.before', $args['id']);

            $event->delete();

            Event::dispatch('marketing.events.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.events.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
