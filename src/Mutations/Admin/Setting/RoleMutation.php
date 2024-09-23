<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\User\Repositories\RoleRepository;

class RoleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected RoleRepository $roleRepository) {}

    /**
     * Get the acl permissions.
     *
     * @return array
     */
    public function getAclPermissions()
    {
        return config('acl');
    }

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
            'name'            => 'required',
            'permission_type' => 'required',
            'description'     => 'required',
        ]);

        try {
            Event::dispatch('user.role.create.before');

            $role = $this->roleRepository->create($args);

            Event::dispatch('user.role.create.after', $role);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.roles.create-success'),
                'role'    => $role,
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
            'name'            => 'required',
            'permission_type' => 'required',
            'description'     => 'required',
        ]);

        $role = $this->roleRepository->find($args['id']);

        if (! $role) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        try {
            Event::dispatch('user.role.update.before', $role->id);

            $role = $this->roleRepository->update($args, $role->id);

            Event::dispatch('user.role.update.after', $role);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.roles.update-success'),
                'role'    => $role,
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
        $role = $this->roleRepository->find($args['id']);

        if (! $role) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        if ($role->admins->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.last-delete-error'));
        }

        try {
            Event::dispatch('user.role.delete.before', $args['id']);

            $role->delete();

            Event::dispatch('user.role.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.roles.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
