<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\TemplateRepository;

class EmailTemplateMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected TemplateRepository $templateRepository) {}

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

        $params = $args['input'];

        bagisto_graphql()->validate($params, [
            'name'    => 'required',
            'content' => 'required',
            'status'  => 'required',
        ]);

        try {
            $template = $this->templateRepository->create($params);

            return $template;
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
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

        $params = $args['input'];

        $id = $args['id'];

        bagisto_graphql()->validate($params, [
            'name'    => 'required',
            'content' => 'required',
            'status'  => 'required',
        ]);

        try {
            $template = $this->templateRepository->findOrFail($id);
            $template = $this->templateRepository->update($params, $id);

            return $template;
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

        $template = $this->templateRepository->find($id);

        try {
            if ($template) {
                $template->delete();

                return [
                    'status'  => true,
                    'message' => trans('bagisto_graphql::app.admin.marketing.communications.templates.delete-success'),
                ];
            }

            return [
                'status'  => false,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.templates.delete-failed'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
