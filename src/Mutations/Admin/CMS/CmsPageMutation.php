<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\CMS;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CMS\Repositories\PageRepository;
use Webkul\Core\Rules\Slug;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CmsPageMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected PageRepository $pageRepository,
        protected ChannelRepository $channelRepository
    ) {
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
            'channels'     => 'required|array|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'html_content' => 'required',
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            Event::dispatch('cms.page.create.before');

            $page = $this->pageRepository->create($data);

            Event::dispatch('cms.page.create.after', $page);

            $page->success = trans('bagisto_graphql::app.admin.cms.create-success');

            return $page;
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

        $locale = core()->getRequestedLocaleCode();

        $data[$locale] = $args['input'];

        $data['channels'] = $args['input']['channels'];

        $data['locale'] = $locale;

        $id = $args['id'];

        unset($data[$locale]['channels'], $data[$locale]['locale']);

        $validator = Validator::make($data, [
            $locale.'.url_key'      => ['required', new Slug, function ($attribute, $value, $fail) use ($id) {
                if (!$this->pageRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('bagisto_graphql::app.admin.cms.already-taken'));
                }
            }],
            $locale.'.page_title'   => 'required',
            $locale.'.html_content' => 'required',
            'channels'              => 'required|array|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
        ]);

        bagisto_graphql()->checkValidatorFails($validator);

        try {
            Event::dispatch('cms.page.create.before', $id);

            $page = $this->pageRepository->update($data, $id);

            Event::dispatch('cms.page.create.after', $page);

            $page->success = trans('bagisto_graphql::app.admin.cms.update-success');

            return $page;
        } catch (\Exception $e) {
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

        $id = $args['id'];

        $page = $this->pageRepository->find($id);

        if (! $page) {
            throw new CustomException(trans('bagisto_graphql::app.admin.cms.not-found'));
        }

        try {
            Event::dispatch('cms.page.delete.before', $id);

            $this->pageRepository->delete($id);

            return ['success' => trans('bagisto_graphql::app.admin.cms.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
