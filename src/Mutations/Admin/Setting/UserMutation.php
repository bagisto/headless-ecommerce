<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\User\Repositories\AdminRepository;
use Webkul\User\Repositories\RoleRepository;

class UserMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected AdminRepository $adminRepository,
        protected RoleRepository $roleRepository
    ) {
        Auth::setDefaultDriver('admin-api');
    }

    /**
     * Login user resource in storage.
     *
     * @return array
     *
     * @throws CustomException
     */
    public function login(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (! $jwtToken = JWTAuth::attempt([
            'email'    => $args['email'],
            'password' => $args['password'],
        ], $args['remember'] ?? 0)) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.login-error'));
        }

        try {
            $admin = auth()->guard()->user();

            if (! $admin->status) {
                auth()->guard()->logout();

                throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.activate-warning'));
            }

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.admin.settings.users.success-login'),
                'access_token' => $jwtToken,
                'token_type'   => 'Bearer',
                'expires_in'   => Auth::factory()->getTTL() * 60,
                'user'         => $admin,
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
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
            'name'     => 'required',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'nullable|min:6|confirmed',
            'role_id'  => 'required',
            'status'   => 'sometimes',
            'image'    => 'sometimes',
        ]);

        if (! $this->roleRepository->find($args['role_id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        try {
            if (! empty($args['password'])) {
                $args['password'] = bcrypt($args['password']);

                $args['api_token'] = Str::random(80);
            }

            Event::dispatch('user.admin.create.before');

            $imageUrl = $args['image'] ?? '';

            if (! empty($args['image'])) {
                unset($args['image']);
            }

            $admin = $this->adminRepository->create($args);

            bagisto_graphql()->uploadImage($admin, $imageUrl, 'admins/', 'image');

            Event::dispatch('user.admin.create.after', $admin);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.users.create-success'),
                'user'    => $admin,
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
            'name'     => 'required',
            'email'    => 'required|email|unique:admins,email,'.$args['id'],
            'password' => 'nullable|min:6|confirmed',
            'status'   => 'sometimes',
            'role_id'  => 'required',
            'image'    => 'sometimes',
        ]);

        $admin = $this->adminRepository->find($args['id']);

        if (! $admin) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.not-found'));
        }

        if (! $this->roleRepository->find($args['role_id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        try {
            if (! empty($args['password'])) {
                $isPasswordChanged = true;

                $args['password'] = bcrypt($args['password']);
            }

            $args['status'] = $args['status'] ?? 0;

            Event::dispatch('user.admin.update.before', $admin->id);

            $imageUrl = $args['image'] ?? '';

            if (! empty($args['image'])) {
                unset($args['image']);
            }

            $admin = $this->adminRepository->update($args, $admin->id);

            bagisto_graphql()->uploadImage($admin, $imageUrl, 'admins/', 'image');

            if ($isPasswordChanged ?? false) {
                Event::dispatch('user.admin.update-password', $admin);
            }

            Event::dispatch('user.admin.update.after', $admin);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.users.update-success'),
                'user'    => $admin,
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
        $admin = $this->adminRepository->find($args['id']);

        if (! $admin) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.not-found'));
        }

        if ($this->adminRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.last-delete-error'));
        }

        try {
            Event::dispatch('user.admin.delete.before', $args['id']);

            $admin->delete();

            Event::dispatch('user.admin.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.users.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Logout user resource in storage.
     *
     * @return array
     */
    public function logout()
    {
        auth()->guard()->logout();

        return [
            'success' => true,
            'message' => trans('bagisto_graphql::app.admin.settings.users.success-logout'),
        ];
    }
}
