<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Communications;

use Illuminate\Support\Facades\Event;
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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'name'    => 'required',
            'content' => 'required',
            'status'  => 'required',
        ]);

        try {
            Event::dispatch('marketing.templates.create.before');

            $template = $this->templateRepository->create($args);

            Event::dispatch('marketing.templates.create.after', $template);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.marketing.communications.email-templates.create-success'),
                'email_template' => $template,
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
        bagisto_graphql()->validate($args, [
            'name'    => 'required',
            'content' => 'required',
            'status'  => 'required',
        ]);

        $template = $this->templateRepository->find($args['id']);

        if (! $template) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.email-templates.not-found'));
        }

        try {
            Event::dispatch('marketing.templates.update.before', $template->id);

            $template = $this->templateRepository->update($args, $template->id);

            Event::dispatch('marketing.templates.update.after', $template);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.marketing.communications.email-templates.update-success'),
                'email_template' => $template,
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
        $template = $this->templateRepository->find($args['id']);

        if (! $template) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.communications.email-templates.not-found'));
        }

        try {
            Event::dispatch('marketing.templates.delete.before', $args['id']);

            $template->delete();

            Event::dispatch('marketing.templates.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.communications.email-templates.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
