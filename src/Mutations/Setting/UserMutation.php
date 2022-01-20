<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use JWTAuth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\User\Repositories\RoleRepository;
use Webkul\User\Repositories\AdminRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UserMutation extends Controller
{
    /**
     * Contains current guard
     *
     * @var array
     */
    protected $guard;

    /**
     * AdminRepository object
     *
     * @var \Webkul\User\Repositories\AdminRepository
     */
    protected $adminRepository;

    /**
     * RoleRepository object
     *
     * @var \Webkul\User\Repositories\RoleRepository
     */
    protected $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\User\Repositories\AdminRepository  $adminRepository
     * @param  \Webkul\User\Repositories\RoleRepository  $roleRepository
     * @return void
     */
    public function __construct(
        AdminRepository $adminRepository,
        RoleRepository $roleRepository
    )
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);
        
        $this->middleware('auth:' . $this->guard, ['except' => ['login']]);
        
        $this->adminRepository = $adminRepository;

        $this->roleRepository = $roleRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if ( ! isset($args['input']) || (isset($args['input']) && !$args['input']) ) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $validator = \Validator::make($data, [
            'name'     => 'required',
            'email'    => 'email|unique:admins,email',
            'password' => 'nullable',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'status'   => 'sometimes',
            'role_id'  => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }
        
        try {
            if (isset($data['password']) && $data['password']) {
                $data['password'] = bcrypt($data['password']);
                $data['api_token'] = Str::random(80);
            }
    
            Event::dispatch('user.admin.create.before');
    
            $admin = $this->adminRepository->create($data);
    
            Event::dispatch('user.admin.create.after', $admin);

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
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];
        $id = $args['id'];
        
        $validator = \Validator::make($data, [
            'name'     => 'required',
            'email'    => 'email|unique:admins,email,' . $id,
            'password' => 'nullable',
            'password_confirmation' => 'nullable|required_with:password|same:password',
            'status'   => 'sometimes',
            'role_id'  => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            if (! $data['password']) {
                unset($data['password']);
            } else {
                $isPasswordChanged = true;
                $data['password'] = bcrypt($data['password']);
            }
    
            if (isset($data['status'])) {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
    
            Event::dispatch('user.admin.update.before', $id);
    
            $admin = $this->adminRepository->update($data, $id);
    
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
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $id = $args['id'];

        $user = $this->adminRepository->findOrFail($id);

        if ($this->adminRepository->count() == 1) {
            throw new Exception(trans('admin::app.response.last-delete-error', ['name' => 'Admin']));
        } else {
            try {
                Event::dispatch('user.admin.delete.before', $id);

                $this->adminRepository->delete($id);

                Event::dispatch('user.admin.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Admin'])];
            } catch(\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Admin']));
            }
        }
    }

    /**
     * Login user resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = \Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $remember = isset($data['remember']) ? $data['remember'] : 0;
        
        if (! $jwtToken = JWTAuth::attempt([
            'email'     => $data['email'],
            'password'  => $data['password'],
        ], $remember)) {
            throw new Exception(trans('admin::app.users.users.login-error'));
        }
        
        try {
            if (bagisto_graphql()->guard($this->guard)->user()->status == 0) {
                bagisto_graphql()->guard($this->guard)->logout();

                return [
                        'status'    => false,
                        'success'   => trans('admin::app.users.users.activate-warning'),
                    ];
            }
            
            return [
                'status'        => true,
                'success'       => trans('bagisto_graphql::app.admin.response.success-login'),
                'access_token'  => 'Bearer ' . $jwtToken,
                'token_type'    => 'Bearer',
                'expires_in'    => bagisto_graphql()->guard($this->guard)->factory()->getTTL() * 60,
                'user'          => bagisto_graphql()->guard($this->guard)->user()
            ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        if ( auth()->guard($this->guard)->check() ) {
            auth()->guard($this->guard)->logout();
            
            return [
                'status'    => true,
                'success'   => trans('bagisto_graphql::app.admin.response.success-logout'),
            ]; 
        }
            
        return [
            'status'    => false,
            'success'   => trans('bagisto_graphql::app.admin.response.no-login-user'),
        ];
    }
}
