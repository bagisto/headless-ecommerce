<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use Exception;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\User\Repositories\AdminRepository;
use Webkul\User\Repositories\RoleRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class UserMutation extends Controller
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
     * @param  \Webkul\User\Repositories\AdminRepository  $adminRepository
     * @param  \Webkul\User\Repositories\RoleRepository  $roleRepository
     * @return void
     */
    public function __construct(
       protected AdminRepository $adminRepository,
       protected RoleRepository $roleRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:'.$this->guard, ['except' => ['login']]);
    }

    /**
     * Login user resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['input'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $remember = $data['remember'] ?? 0;

        if (! $jwtToken = JWTAuth::attempt([
                'email'    => $data['email'],
                'password' => $data['password'],
            ], $remember)
        ) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.login-error'));
        }

        try {
            $admin = bagisto_graphql()->guard($this->guard)->user();

            if (! $admin->status) {
                bagisto_graphql()->guard($this->guard)->logout();

                throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.activate-warning'));
            }

            return [
                'status'       => true,
                'success'      => trans('bagisto_graphql::app.admin.settings.users.success-login'),
                'access_token' => 'Bearer '.$jwtToken,
                'token_type'   => 'Bearer',
                'expires_in'   => bagisto_graphql()->guard($this->guard)->factory()->getTTL() * 60,
                'user'         => $admin,
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
            'name'                  => 'required',
            'email'                 => 'email|unique:admins,email',
            'password'              => 'nullable',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'role_id'               => 'required',
            'status'                => 'sometimes',
            'image'                 => 'sometimes',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        if (! $this->roleRepository->find($data['role_id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.roles.not-found'));
        }

        try {
            if (! empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);

                $data['api_token'] = Str::random(80);
            }

            Event::dispatch('user.admin.create.before');

            $imageUrl = $data['image'][0] ?? '';

            if (isset($data['image'])) {
                unset($data['image']);
            }

            $admin = $this->adminRepository->create($data);

            if (isset($admin->id)) {
                bagisto_graphql()->uploadImage($admin, $imageUrl, 'admins/', 'image');

                return $admin;
            }

            Event::dispatch('user.admin.create.after', $admin);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.users.create-success'),
                'user'    => $admin,
            ];
            return $admin;
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $data = $args['input'];

        $id = $args['id'];

        $validator = Validator::make($data, [
            'name'                  => 'required',
            'email'                 => 'email|unique:admins,email,'.$id,
            'password'              => 'nullable',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'status'                => 'sometimes',
            'role_id'               => 'required',
            'image'                 => 'sometimes',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        $admin = $this->adminRepository->find($id);

        if (! $admin) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.not-found'));
        }

        try {
            if (! $data['password']) {
                unset($data['password']);
            } else {
                $isPasswordChanged = true;

                $data['password'] = bcrypt($data['password']);
            }

            $data['status'] = ! empty($data['status']) ? $data['status'] : 0;

            Event::dispatch('user.admin.update.before', $id);

            $admin = $this->adminRepository->update($data, $id);

            $imageUrl = $data['image'][0] ?? '';

            if (isset($data['image'])) {
                unset($data['image']);
            }

            if (isset($admin->id)) {
                bagisto_graphql()->uploadImage($admin, $imageUrl, 'admins/', 'image');

                return $admin;
            }

            if ($isPasswordChanged) {
                Event::dispatch('user.admin.update-password', $admin);
            }

            Event::dispatch('user.admin.update.after', $admin);

            return $admin;
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
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $id = $args['id'];

        $admin = $this->adminRepository->find($id);

        if (! $admin) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.not-found'));
        }

        if ($this->adminRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.users.last-delete-error'));
        }

        try {
            Event::dispatch('user.admin.delete.before', $id);

            $this->adminRepository->delete($id);

            Event::dispatch('user.admin.delete.after', $id);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.users.delete-success'),
            ];
        } catch (Exception $e) {
            throw new Exception(trans('bagisto_graphql::app.admin.settings.users.delete-error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        if (auth()->guard($this->guard)->check()) {
            auth()->guard($this->guard)->logout();

            return [
                'status'  => true,
                'success' => trans('bagisto_graphql::app.admin.settings.users.success-logout'),
            ];
        }

        return [
            'status'  => false,
            'success' => trans('bagisto_graphql::app.admin.response.error.no-login-user'),
        ];
    }
}
