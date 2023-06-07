<?php

namespace Webkul\GraphQLAPI\Mutations\Setting;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Http\Controllers\Controller;
use Webkul\Core\Repositories\LocaleRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LocaleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\LocaleRepository  $localeRepository
     * @return void
     */
    public function __construct(
        protected LocaleRepository $localeRepository
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
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
            'code'      => ['required', 'unique:locales,code', new \Webkul\Core\Contracts\Validations\Code],
            'name'      => 'required',
            'direction' => 'in:ltr,rtl,LTR,RTL',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $image_url = '';
            if (isset($data['image'])) {
                $image_url = $data['image'];
                unset($data['image']);
            }

            Event::dispatch('core.locale.create.before');

            $locale = $this->localeRepository->create($data);

            Event::dispatch('core.locale.create.after', $locale);

            if (isset($locale->id)) {
                bagisto_graphql()->uploadImage($locale, $image_url, 'velocity/locale/', 'locale_image');

                return $locale;
            }
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
        if (!isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $data = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($data, [
            'code'      => ['required', 'unique:locales,code,' . $id, new \Webkul\Core\Contracts\Validations\Code],
            'name'      => 'required',
            'direction' => 'in:ltr,rtl,LTR,RTL',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $image_url = '';
            if (isset($data['image'])) {
                $image_url = $data['image'];
                unset($data['image']);
            }

            Event::dispatch('core.locale.update.before', $id);

            $locale = $this->localeRepository->update($data, $id);

            Event::dispatch('core.locale.update.after', $locale);

            if (isset($locale->id)) {
                bagisto_graphql()->uploadImage($locale, $image_url, 'velocity/locale/', 'locale_image');

                return $locale;
            }
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
        if (!isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $locale = $this->localeRepository->findOrFail($id);

        if ($this->localeRepository->count() == 1) {
            throw new Exception(trans('admin::app.settings.locales.last-delete-error'));
        } else {
            try {
                Event::dispatch('core.locale.delete.before', $id);

                $this->localeRepository->delete($id);

                Event::dispatch('core.locale.delete.after', $id);

                return ['success' => trans('admin::app.settings.locales.delete-success')];
            } catch (\Exception $e) {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Locale']));
            }
        }
    }
}
