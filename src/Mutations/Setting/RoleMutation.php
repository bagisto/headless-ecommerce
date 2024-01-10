<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\User\Repositories\RoleRepository;;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RoleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\User\Repositories\RoleRepository  $roleRepository
     * @return void
     */
    public function __construct(
       protected RoleRepository $roleRepository
    )
    {
        $this->middleware('auth:admin-api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'name'            => 'required',
            'permission_type' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('user.role.create.before');

            $role = $this->roleRepository->create($data);

            Event::dispatch('user.role.create.after', $role);

            return $role;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'name'            => 'required',
            'permission_type' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            Event::dispatch('user.role.update.before', $id);

            $role = $this->roleRepository->update($data, $id);

            Event::dispatch('user.role.update.after', $role);

            return $role;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
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
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $role = $this->roleRepository->findOrFail($id);

        if ($role->admins->count() == 1) {
            throw new Exception(trans('admin::app.response.last-delete-error', ['name' => 'Role']));
        }

        try {
            Event::dispatch('user.role.delete.before', $id);

            $this->roleRepository->delete($id);

            Event::dispatch('user.role.delete.after', $id);

            return ['success' => trans('admin::app.settings.roles.delete-success', ['name' => 'Role'])];
        } catch(\Exception $e) {
            throw new Exception(trans('admin::app.settings.roles.delete-failed', ['name' => 'Role']));
        }
    }
}
