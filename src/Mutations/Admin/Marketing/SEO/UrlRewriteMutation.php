<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\SEO;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\URLRewriteRepository;

class UrlRewriteMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected URLRewriteRepository $urlRewriteRepository) {}

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
            'entity_type'   => 'required:in:category,product,cms_page',
            'request_path'  => 'required',
            'target_path'   => 'required',
            'redirect_type' => 'required|in:301,302',
            'locale'        => 'required|exists:locales,code',
        ]);

        try {
            Event::dispatch('marketing.search_seo.url_rewrites.create.before');

            $urlRewrite = $this->urlRewriteRepository->create($args);

            Event::dispatch('marketing.search_seo.url_rewrites.create.after', $urlRewrite);

            return [
                'success'     => true,
                'message'     => trans('bagisto_graphql::app.admin.marketing.seo.url-rewrites.create-success'),
                'url_rewrite' => $urlRewrite,
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
            'entity_type'   => 'required:in:category,product,cms_page',
            'request_path'  => 'required',
            'target_path'   => 'required',
            'redirect_type' => 'required|in:301,302',
            'locale'        => 'required|exists:locales,code',
        ]);

        $urlRewrite = $this->urlRewriteRepository->find($args['id']);

        if (! $urlRewrite) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.url-rewrites.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.url_rewrites.update.before', $urlRewrite->id);

            $urlRewrite = $this->urlRewriteRepository->update($args, $urlRewrite->id);

            Event::dispatch('marketing.search_seo.url_rewrites.update.after', $urlRewrite);

            return [
                'success'     => true,
                'message'     => trans('bagisto_graphql::app.admin.marketing.seo.url-rewrites.update-success'),
                'url_rewrite' => $urlRewrite,
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
        $urlRewrite = $this->urlRewriteRepository->find($args['id']);

        if (! $urlRewrite) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.url-rewrites.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.url_rewrites.delete.before', $args['id']);

            $urlRewrite->delete();

            Event::dispatch('marketing.search_seo.url_rewrites.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.url-rewrites.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
