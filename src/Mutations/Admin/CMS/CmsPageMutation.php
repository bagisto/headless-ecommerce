<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\CMS;

use Exception;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CMS\Repositories\CmsRepository;
use Webkul\Core\Rules\Slug;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class CmsPageMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \Webkul\CMS\Repositories\CmsRepository  $CmsRepository
     * @return void
     */
    public function __construct(protected CmsRepository $cmsRepository)
    {
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
            'url_key'      => ['required', 'unique:cms_page_translations,url_key', new Slug],
            'page_title'   => 'required',
            'channels'     => 'required',
            'html_content' => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            return $this->cmsRepository->create($data);
        } catch (Exception $e) {
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

        $locale = $args['input']['locale'] ?: app()->getLocale();

        $data[$locale] = $args['input'];

        $data['channels'] = $args['input']['channels'];

        $data['locale'] = $args['input']['locale'];

        $id = $args['id'];

        unset($data[$locale]['channels']);

        unset($data[$locale]['locale']);

        $validator = Validator::make($data, [
            $locale.'.url_key'      => ['required', new Slug, function ($attribute, $value, $fail) use ($id) {
                if (!$this->cmsRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('bagisto_graphql::app.admin.cms.already-taken'));
                }
            }],
            $locale.'.page_title'   => 'required',
            $locale.'.html_content' => 'required',
            'channels'              => 'required',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $page = $this->cmsRepository->update($data, $id);

            return $page;
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (empty($args['id'])) {
            throw new CustomException(trans('bagisto_graphql::app.admin.response.error.invalid-parameter'));
        }

        $page = $this->cmsRepository->find($args['id']);

        try {
            if ($page) {
                $page->delete();

                return ['success' => trans('bagisto_graphql::app.admin.cms.delete-success')];
            } else {
                throw new CustomException(trans('bagisto_graphql::app.admin.cms.delete-failed'));
            }
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
