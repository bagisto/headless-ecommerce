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
     * @return array
     *
     * @throws CustomException
     */
    public function store(mixed $rootValue, array $args, GraphQLContext $context)
    {
        bagisto_graphql()->validate($args, [
            'name'            => 'required',
            'channels'        => 'required|array|min:1|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'customer_groups' => 'required|array|min:1|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if (
            $args['action_type']
            && $args['action_type'] == 'by_percent'
        ) {
            bagisto_graphql()->validate($args, [
                'discount_amount' => 'required|numeric|min:0|max:100',
            ]);
        }

        try {
            Event::dispatch('promotions.catalog_rule.create.before');

            $catalogRule = $this->catalogRuleRepository->create($args);

            Event::dispatch('promotions.catalog_rule.create.after', $catalogRule);

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.create-success'),
                'catalog_rule' => $catalogRule,
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
            'name'            => 'required',
            'channels'        => 'required|array|min:1|in:'.implode(',', $this->channelRepository->pluck('id')->toArray()),
            'customer_groups' => 'required|array|min:1|in:'.implode(',', $this->customerGroupRepository->pluck('id')->toArray()),
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if (
            $args['action_type']
            && $args['action_type'] == 'by_percent'
        ) {
            bagisto_graphql()->validate($args, [
                'discount_amount' => 'required|numeric|min:0|max:100',
            ]);
        }

        $catalogRule = $this->catalogRuleRepository->find($args['id']);

        if (! $catalogRule) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.not-found'));
        }

        try {
            Event::dispatch('promotions.catalog_rule.update.before', $catalogRule->id);

            $catalogRule = $this->catalogRuleRepository->update($args, $catalogRule->id);

            Event::dispatch('promotions.catalog_rule.update.after', $catalogRule);

            return [
                'success'      => true,
                'message'      => trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.update-success'),
                'catalog_rule' => $catalogRule,
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
        $catalogRule = $this->catalogRuleRepository->find($args['id']);

        if (! $catalogRule) {
            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.not-found'));
        }

        try {
            Event::dispatch('promotions.catalog_rule.delete.before', $args['id']);

            $catalogRule->delete();

            Event::dispatch('promotions.catalog_rule.delete.after', $args['id']);

            return [
                'success' => true,
                'message' => trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.delete-success'),
            ];
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}
