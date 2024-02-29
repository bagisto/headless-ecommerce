<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\User\Repositories\RoleRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class RoleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\User\Repositories\RoleRepository  $roleRepository
     * @return void
     */
    public function __construct(protected RoleRepository $roleRepository)
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

        $data = $args['input'];

        $validator = Validator::make($data, [
            'name'            => 'required',
            'permission_type' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            Event::dispatch('user.role.create.before');

            $role = $this->roleRepository->create($data);

            Event::dispatch('user.role.create.after', $role);

            return $role;
        } catch (Exception $e) {
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

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'name'            => 'required',
            'permission_type' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $role = $this->roleRepository->find($id);

        if (! $role) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        try {
            Event::dispatch('user.role.update.before', $id);

            $role = $this->roleRepository->update($data, $id);

            Event::dispatch('user.role.update.after', $role);

            return $role;
        } catch (Exception $e) {
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

        $role = $this->roleRepository->find($id);

        if (! $role) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        if ($role->admins->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.last-delete-error'));
        }

        try {
            Event::dispatch('user.role.delete.before', $id);

            $this->roleRepository->delete($id);

            Event::dispatch('user.role.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.settings.roles.delete-success')];
        } catch(Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
