<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\CMS;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CMS\Repositories\PageRepository;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Rules\Slug;
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
    ) {}

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
            'url_key'      => ['required', 'unique:cms_page_translations,url_key', new Slug],
            'page_title'   => 'required',
            'channels'     => 'required|array|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'html_content' => 'required',
        ]);

        try {
            Event::dispatch('cms.page.create.before');

            $page = $this->pageRepository->create($args);

            Event::dispatch('cms.page.create.after', $page);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.cms.create-success'),
                'page'    => $page,
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
        $locale = core()->getRequestedLocaleCode();

        $data[$locale] = $args;

        $data['channels'] = $args['channels'];

        $data['locale'] = $locale;

        $id = $args['id'];

        $page = $this->pageRepository->find($id);

        if (! $page) {
            throw new CustomException(trans('bagisto_graphql::app.admin.cms.not-found'));
        }

        unset($data[$locale]['channels'], $data[$locale]['locale']);

        bagisto_graphql()->validate($data, [
            $locale.'.url_key'      => ['required', new Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->pageRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('bagisto_graphql::app.admin.cms.already-taken'));
                }
            }],
            $locale.'.page_title'   => 'required',
            $locale.'.html_content' => 'required',
            'channels'              => 'required|array|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
        ]);

        try {
            Event::dispatch('cms.page.create.before', $id);

            $page = $this->pageRepository->update($data, $id);

            Event::dispatch('cms.page.create.after', $page);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.cms.update-success'),
                'page'    => $page,
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
        $page = $this->pageRepository->find($args['id']);

        if (! $page) {
            throw new CustomException(trans('bagisto_graphql::app.admin.cms.not-found'));
        }

        try {
            Event::dispatch('cms.page.delete.before', $args['id']);

            $page->delete();

            Event::dispatch('cms.page.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.cms.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
