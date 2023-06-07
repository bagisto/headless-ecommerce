<?php

namespace Webkul\GraphQLAPI\Mutations\Velocity;

use Exception;
use Illuminate\Support\Facades\Validator;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Velocity\Repositories\ContentRepository;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class HeaderContentMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Velocity\Repositories\ContentRepository  $contentRepository
     * @return void
     */
    public function __construct(protected ContentRepository $contentRepository)
    {
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

        $params = $args['input'];

        $validator = Validator::make($params, [
            'title'        => 'required',
            'position'     => 'required',
            'status'       => 'required',
            'content_type' => 'required',
            'page_link'    => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        $params['locale'] = 'all';

        $locale = app()->getLocale();

        if (isset($params['locale'])) {
            $locale = $params['locale'];
        } else {
            $locale = app()->getLocale();
        }

        $params[$locale] = [
            'page_link' => $params['page_link'],
            'link_target' => $params['link_target']
        ];

        unset($params['page_link']);
        unset($params['link_target']);

        if (isset($params['products'])) {
            $params['products'] = json_encode($params['products']);
        }

        try {
            $content = $this->contentRepository->create($params);

            return $content;
        } catch (\Exception $e) {
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

        $params = $args['input'];
        $id = $args['id'];

        $validator = Validator::make($params, [
            'title'        => 'required',
            'position'     => 'required',
            'status'       => 'required',
            'content_type' => 'required',
            'page_link'    => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->messages());
        }

        if (isset($params['locale'])) {
            $locale = $params['locale'];
        } else {
            $locale = app()->getLocale();
        }

        $params['locale'] = $locale;

        $params[$locale] = [
            'title'       => $params['title'],
            'page_link'   => $params['page_link'],
            'link_target' => $params['link_target']
        ];

        unset($params['page_link']);
        unset($params['link_target']);
        unset($params['title']);

        if (isset($params['locale']) && isset($params[$params['locale']]['products'])) {
            $params[$params['locale']]['products'] = json_encode($params[$params['locale']]['products']);
        }

        try {
            $content = $this->contentRepository->update($params, $id);

            return $content;
        } catch (\Exception $e) {
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

        $page = $this->contentRepository->find($id);

        try {

            if ($page != Null) {
                $page->delete();

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Header Content'])];
            } else {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Content']));
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }
}
