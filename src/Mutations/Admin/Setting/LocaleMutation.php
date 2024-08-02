<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Core\Repositories\LocaleRepository;
use Webkul\Core\Rules\Code;
use Webkul\GraphQLAPI\Validators\CustomException;

class LocaleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected LocaleRepository $localeRepository) {}

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

        bagisto_graphql()->validate($data, [
            'code'      => ['required', 'unique:locales,code', new Code],
            'name'      => 'required',
            'direction' => 'required|in:ltr,rtl,LTR,RTL',
        ]);

        try {
            $imageUrl = $data['image'] ?? '';

            if (isset($data['image'])) {
                unset($data['image']);
            }

            Event::dispatch('core.locale.create.before');

            $locale = $this->localeRepository->create($data);

            Event::dispatch('core.locale.create.after', $locale);

            bagisto_graphql()->uploadImage($locale, $imageUrl, 'locale/', 'logo_path');

            $locale->success = trans('bagisto_graphql::app.admin.settings.locales.create-success');

            return $locale;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
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

        bagisto_graphql()->validate($data, [
            'code'      => ['required', 'unique:locales,code,'.$id, new Code],
            'name'      => 'required',
            'direction' => 'in:ltr,rtl,LTR,RTL',
        ]);

        $locale = $this->localeRepository->find($id);

        if (! $locale) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.locales.not-found'));
        }

        try {
            $imageUrl = '';

            if (isset($data['image'])) {
                $imageUrl = $data['image'];

                unset($data['image']);
            }

            Event::dispatch('core.locale.update.before', $id);

            $locale = $this->localeRepository->update($data, $id);

            Event::dispatch('core.locale.update.after', $locale);

            bagisto_graphql()->uploadImage($locale, $imageUrl, 'locale/', 'logo_path');

            $locale->success = trans('bagisto_graphql::app.admin.settings.locales.update-success');

            return $locale;
        } catch (\Exception $e) {
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

        $locale = $this->localeRepository->find($id);

        if (! $locale) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.locales.not-found'));
        }

        if (core()->getCurrentLocale()->code == $locale->code) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.locales.default-delete-error'));
        }

        if ($this->localeRepository->count() == 1) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.locales.last-delete-error'));
        }

        try {
            Event::dispatch('core.locale.delete.before', $id);

            $this->localeRepository->delete($id);

            Event::dispatch('core.locale.delete.after', $id);

            return [
                'success' => trans('bagisto_graphql::app.admin.settings.locales.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
