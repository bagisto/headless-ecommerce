<?php

namespace Webkul\GraphQLAPI\Mutations\CMS;

use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\CMS\Repositories\CmsRepository;

class CmsPageMutation extends Controller
{
    /**
     * CmsRepository object
     *
     * @var \Webkul\CMS\Repositories\CmsRepository
     */
    protected $CmsRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Webkul\CMS\Repositories\CmsRepository  $CmsRepository
     * @return void
     */
    public function __construct(
        CmsRepository $cmsRepository
    )
    {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->middleware('auth:' . $this->guard);

        $this->cmsRepository = $cmsRepository;

        $this->_config = request('_config');
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

        if (! bagisto_graphql()->validateAPIUser($this->guard)) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.invalid-header'));
        }

        $data = $args['input'];

        $validator = \Validator::make($data, [
            'url_key'      => ['required', 'unique:cms_page_translations,url_key', new \Webkul\Core\Contracts\Validations\Slug],
            'page_title'   => 'required',
            'channels'     => 'required',
            'html_content' => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $page = $this->cmsRepository->create($data);

            return $page;
        } catch(\Exception $e) {
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


        $locale = $args['input']['locale'] ?: app()->getLocale();
        $data[$locale] = $args['input'];
        $data['channels'] =$args['input']['channels'];
        $data['locale'] =$args['input']['locale'];
        $id = $args['id'];

        unset($data[$locale]['channels']);
        unset($data[$locale]['locale']);

        $validator = \Validator::make($data, [
            $locale . '.url_key'      => ['required', new \Webkul\Core\Contracts\Validations\Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->cmsRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('admin::app.response.already-taken', ['name' => 'Page']));
                }
            }],
            $locale . '.page_title'   => 'required',
            $locale . '.html_content' => 'required',
            'channels'                => 'required',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        try {
            $page = $this->cmsRepository->update($data, $id);

            return $page;
        } catch(\Exception $e) {
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

        $page = $this->cmsRepository->find($id);

        try {

            if ($page != Null) {
                $page->delete();

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'CMS Page'])];
            } else {
                throw new Exception(trans('admin::app.cms.pages.delete-failure'));
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }
}
