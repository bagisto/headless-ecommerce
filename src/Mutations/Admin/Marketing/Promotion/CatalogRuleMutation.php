<?php

namespace Webkul\GraphQLAPI\Mutations\Admin\Marketing\Promotion;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Exception;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CatalogRule\Repositories\CatalogRuleRepository;
use Webkul\CatalogRule\Helpers\CatalogRuleIndex;
use Webkul\CartRule\Repositories\CartRuleCouponRepository;
use Webkul\GraphQLAPI\Validators\Admin\CustomException;

class CatalogRuleMutation extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\CatalogRule\Repositories\CatalogRuleRepository  $catalogRuleRepository
     * @param  \Webkul\CatalogRule\Helpers\CatalogRuleIndex  $catalogRuleIndexHelper
     * @param  \Webkul\CatalogRule\Helpers\CartRuleCouponRepository  $cartRuleCouponRepository
     * @return void
     */
    public function __construct(
        protected CatalogRuleRepository $catalogRuleRepository,
        protected CatalogRuleIndex $catalogRuleIndexHelper,
        protected CartRuleCouponRepository $cartRuleCouponRepository
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

        $params = $args['input'];

        $validator = Validator::make($params, [
            'name'            => 'required',
            'channels'        => 'required|array|min:1',
            'customer_groups' => 'required|array|min:1',
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            Event::dispatch('promotions.catalog_rule.create.before');

            $catalogRule = $this->catalogRuleRepository->create($params);

            Event::dispatch('promotions.catalog_rule.create.after', $catalogRule);

            $this->catalogRuleIndexHelper->reindexComplete();

            return $catalogRule;
        } catch(\Exception $e) {
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

        $validator = Validator::make($params, [
            'name'            => 'required',
            'channels'        => 'required|array|min:1',
            'customer_groups' => 'required|array|min:1',
            'starts_from'     => 'nullable|date',
            'ends_till'       => 'nullable|date|after_or_equal:starts_from',
            'action_type'     => 'required',
            'discount_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            throw new CustomException($validator->messages());
        }

        try {
            $catalogRule = $this->catalogRuleRepository->findOrFail($id);

            Event::dispatch('promotions.catalog_rule.update.before', $catalogRule);

            $catalogRule = $this->catalogRuleRepository->update($params, $id);

            Event::dispatch('promotions.catalog_rule.update.after', $catalogRule);

            $this->catalogRuleIndexHelper->reindexComplete();

            return $catalogRule;
        } catch(\Exception $e) {
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

        try {
            if ($catalogRule) {
                Event::dispatch('promotions.catalog_rule.delete.before', $id);

                $catalogRule->delete($id);

                Event::dispatch('promotions.catalog_rule.delete.after', $id);

                return ['success' => trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.delete-success')];
            }

            throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.catalog-rules.delete-failed'));
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    /**
     * Generate coupon code for cart rule
     *
     * @return Response
     */
    public function generateCoupons($params, $id)
    {
        Validator::make($params, [
            'coupon_qty'  => 'required|integer|min:1',
            'code_length' => 'required|integer|min:10',
            'code_format' => 'required',
        ]);

        try {
            if (! $id) {
                throw new CustomException(trans('bagisto_graphql::app.admin.marketing.promotions.cart-rules.cart-rule-not-defind'));
            }

            $coupon = $this->cartRuleCouponRepository->generateCoupons($params, $id);

            return $coupon;
        } catch(Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }
}

