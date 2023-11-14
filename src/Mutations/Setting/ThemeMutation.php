<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use App\Http\Controllers\Controller;
use Exception;
use JWTAuth;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ThemeMutation extends Controller
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
      
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (!isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];

        $validator = Validator::make($data, [
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

        if (request()->has('id')) {
            $theme = $this->themeCustomizationRepository->find(request()->input('id'));

            return $this->themeCustomizationRepository->uploadImage(request()->all(), $theme);
        }

        $validator = Validator::make($data, [
            'name'       => 'required',
            'sort_order' => 'required|numeric',
            'type'       => 'in:product_carousel,category_carousel,static_content,image_carousel,footer_links',
            'channel_id' => 'required|in:'.implode(',', (core()->getAllChannels()->pluck("id")->toArray())),
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        Event::dispatch('theme_customization.create.before');

        $theme = $this->themeCustomizationRepository->create([
            'name'       => request()->input('name'),
            'sort_order' => request()->input('sort_order'),
            'type'       => request()->input('type'),
            'channel_id' => request()->input('channel_id'),
        ]);

        Event::dispatch('theme_customization.create.after', $theme);

        return new JsonResponse([
            'redirect_url' => route('admin.settings.themes.edit', $theme->id),
        ]);

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
}
