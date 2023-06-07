<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\User\Repositories\RoleRepository;;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RoleMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

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
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
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
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
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
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $role = $this->roleRepository->findOrFail($id);
        
        if ($role->admins->count() >= 1) {
            throw new Exception(trans('admin::app.response.last-delete-error', ['name' => 'Role']));
        } else {
            try {
                Event::dispatch('user.role.delete.before', $id);

                $this->roleRepository->delete($id);

                Event::dispatch('user.role.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Role'])];
            } catch(\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Role']));
            }
        }
    }
}
