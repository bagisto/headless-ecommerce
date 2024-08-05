<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Promotion;

use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CartRule\Repositories\CartRuleCouponRepository;
use Webkul\CartRule\Repositories\CartRuleRepository;
use Webkul\CatalogRule\Helpers\CatalogRuleIndex;
use Webkul\CatalogRule\Repositories\CatalogRuleRepository;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\GraphQLAPI\Validators\CustomException;

class CatalogRuleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected CatalogRuleRepository $catalogRuleRepository,
        protected CatalogRuleIndex $catalogRuleIndexHelper,
        protected CartRuleCouponRepository $cartRuleCouponRepository,
        protected CartRuleRepository $cartRuleRepository,
        protected ChannelRepository $channelRepository,
        protected CustomerGroupRepository $customerGroupRepository
    ) {}

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
            'name'            => 'required',
            'channels'        => 'required|array|min:1|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'customer_groups' => 'required|array|min:1|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if (
            $params['action_type']
            && $params['action_type'] == 'by_percent'
        ) {
            bagisto_graphql()->validate($params, [
                'discount_amount' => 'required|numeric|min:0|max:100',
            ]);
        }

        try {
            Event::dispatch('promotions.catalog_rule.create.before');

            $catalogRule = $this->catalogRuleRepository->create($params);

            Event::dispatch('promotions.catalog_rule.create.after', $catalogRule);

            $catalogRule->success = trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.create-success');

            return $catalogRule;
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

        $params = $args['input'];

        $id = $args['id'];

        bagisto_graphql()->validate($params, [
            'name'            => 'required',
            'channels'        => 'required|array|min:1|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'customer_groups' => 'required|array|min:1|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if (
            $params['action_type']
            && $params['action_type'] == 'by_percent'
        ) {
            bagisto_graphql()->validate($params, [
                'discount_amount' => 'required|numeric|min:0|max:100',
            ]);
        }

        $catalogRule = $this->catalogRuleRepository->find($id);

        if (! $catalogRule) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.not-found'));
        }

        try {
            Event::dispatch('promotions.catalog_rule.update.before', $id);

            $catalogRule = $this->catalogRuleRepository->update($params, $id);

            Event::dispatch('promotions.catalog_rule.update.after', $catalogRule);

            $catalogRule->success = trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.create-success');

            return $catalogRule;
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

        $catalogRule = $this->catalogRuleRepository->find($id);

        if (! $catalogRule) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.not-found'));
        }

        try {
            Event::dispatch('promotions.catalog_rule.delete.before', $id);

            $this->catalogRuleRepository->delete($id);

            Event::dispatch('promotions.catalog_rule.delete.after', $id);

            return ['success' => trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.delete-success')];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
