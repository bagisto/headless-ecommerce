<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\SEO;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\GraphQLAPI\Validators\CustomException;
use Webkul\Marketing\Repositories\SearchSynonymRepository;

class SearchSynonymMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected SearchSynonymRepository $searchSynonymRepository) {}

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
            'name'  => 'required',
            'terms' => 'required',
        ]);

        try {
            Event::dispatch('marketing.search_seo.search_synonyms.create.before');

            $searchSynonym = $this->searchSynonymRepository->create($args);

            Event::dispatch('marketing.search_seo.search_synonyms.create.after', $searchSynonym);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.marketing.seo.search-synonyms.create-success'),
                'search_synonym' => $searchSynonym,
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
            'name'  => 'required',
            'terms' => 'required',
        ]);

        $searchSynonym = $this->searchSynonymRepository->find($args['id']);

        if (! $searchSynonym) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.search-synonyms.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.search_synonyms.update.before', $searchSynonym->id);

            $searchSynonym = $this->searchSynonymRepository->update($args, $searchSynonym->id);

            Event::dispatch('marketing.search_seo.search_synonyms.update.after', $searchSynonym);

            return [
                'success'        => true,
                'message'        => trans('bagisto_graphql::app.admin.marketing.seo.search-synonyms.update-success'),
                'search_synonym' => $searchSynonym,
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
        $searchSynonym = $this->searchSynonymRepository->find($args['id']);

        if (! $searchSynonym) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.seo.search-synonyms.not-found'));
        }

        try {
            Event::dispatch('marketing.search_seo.search_synonyms.delete.before', $args['id']);

            $searchSynonym->delete();

            Event::dispatch('marketing.search_seo.search_synonyms.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.seo.search-synonyms.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
