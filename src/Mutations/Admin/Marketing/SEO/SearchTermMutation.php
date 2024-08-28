<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\SEO;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\SearchTermRepository;

class SearchTermMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected SearchTermRepository $searchTermRepository) {}

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
            'term'         => 'required',
            'redirect_url' => 'url:http,https',
            'channel_id'   => 'required|exists:channels,id',
            'locale'       => 'required|exists:locales,code',
        ]);

        try {
            Event::dispatch('marketing.search_seo.search_terms.create.before');

            $searchTerm = $this->searchTermRepository->create($args);

            Event::dispatch('marketing.search_seo.search_terms.create.after', $searchTerm);

            return [
                'success'     => true,
                'message'     => trans('bagisto_graphql::app.admin.marketing.seo.search-terms.create-success'),
                'search_term' => $searchTerm,
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
            'term'         => 'required',
            'redirect_url' => 'url:http,https',
            'channel_id'   => 'required|exists:channels,id',
            'locale'       => 'required|exists:locales,code',
        ]);

        $searchTerm = $this->searchTermRepository->find($args['id']);

        if (! $searchTerm) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.search-terms.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.search_terms.update.before', $searchTerm->id);

            $searchTerm = $this->searchTermRepository->update($args, $searchTerm->id);

            Event::dispatch('marketing.search_seo.search_terms.update.after', $searchTerm);

            return [
                'success'     => true,
                'message'     => trans('bagisto_graphql::app.admin.marketing.seo.search-terms.update-success'),
                'search_term' => $searchTerm,
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
        $searchTerm = $this->searchTermRepository->find($args['id']);

        if (! $searchTerm) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.search-terms.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.search_terms.delete.before', $args['id']);

            $searchTerm->delete();

            Event::dispatch('marketing.search_seo.search_terms.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.search-terms.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
