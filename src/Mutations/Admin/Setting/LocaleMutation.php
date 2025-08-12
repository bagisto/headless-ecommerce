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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
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

            $locale = $this->localeRepository->create($args);

            Event::dispatch('core.locale.create.after', $locale);

            bagisto_graphql()->uploadImage($locale, $imageUrl, 'locale/', 'logo_path');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.locales.create-success'),
                'locale'  => $locale,
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
        $locale = $this->localeRepository->find($args['id']);

        if (! $locale) {
            throw new CustomException(trans('bagisto_graphql::app.admin.settings.locales.not-found'));
        }

        bagisto_graphql()->validate($args, [
            'code'      => ['required', 'unique:locales,code,'.$args['id'], new Code],
            'name'      => 'required',
            'direction' => 'in:ltr,rtl,LTR,RTL',
        ]);

        try {
            $imageUrl = '';

            if (isset($args['image'])) {
                $imageUrl = $args['image'];

                unset($args['image']);
            }

            unset($args['code']);

            Event::dispatch('core.locale.update.before', $locale->id);

            $locale = $this->localeRepository->update($args, $locale->id);

            Event::dispatch('core.locale.update.after', $locale);

            bagisto_graphql()->uploadImage($locale, $imageUrl, 'locale/', 'logo_path');

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.locales.update-success'),
                'locale'  => $locale,
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
        $locale = $this->localeRepository->find($args['id']);

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
            Event::dispatch('core.locale.delete.before', $args['id']);

            $locale->delete();

            Event::dispatch('core.locale.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.settings.locales.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
