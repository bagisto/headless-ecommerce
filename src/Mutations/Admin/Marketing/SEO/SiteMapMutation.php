<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\SEO;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Sitemap\Repositories\SitemapRepository;

class SiteMapMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected SitemapRepository $sitemapRepository) {}

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
            'file_name' => 'required',
            'path'      => 'required',
        ]);

        try {
            $sitemap = $this->sitemapRepository->create($args);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.sitemaps.create-success'),
                'sitemap' => $sitemap,
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
            'file_name' => 'required',
            'path'      => 'required',
        ]);

        $sitemap = $this->sitemapRepository->find($args['id']);

        if (! $sitemap) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.sitemaps.not-found'));
        }

        try {
            $sitemap = $this->sitemapRepository->update($args, $sitemap->id);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.sitemaps.update-success'),
                'sitemap' => $sitemap,
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
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        $sitemap = $this->sitemapRepository->find($args['id']);

        try {
            $sitemap->delete();

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.sitemaps.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
