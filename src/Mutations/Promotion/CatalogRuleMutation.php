<?php

namespace Webkul\GraphQLAPI\Mutations\Promotion;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\CatalogRule\Repositories\CatalogRuleRepository;
use Webkul\CatalogRule\Helpers\CatalogRuleIndex;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CatalogRuleMutation extends Controller
{
    /**
     * Initialize _config, a default request parameter with route
     *
     * @param array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\CatalogRule\Repositories\CatalogRuleRepository  $catalogRuleRepository
     * @param  \Webkul\CatalogRule\Helpers\CatalogRuleIndex  $catalogRuleIndexHelper
     * @return void
     */
    public function __construct(
        protected CatalogRuleRepository $catalogRuleRepository,
        protected CatalogRuleIndex $catalogRuleIndexHelper
    ) {
        $this->guard = 'admin-api';

        auth()->setDefaultDriver($this->guard);

        $this->_config = request('_config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
            throw new Exception($validator->messages());
        }

        try {

            Event::dispatch('promotions.catalog_rule.create.before');

            $catalogRule = $this->catalogRuleRepository->create($params);

            Event::dispatch('promotions.catalog_rule.create.after', $catalogRule);

            $this->catalogRuleIndexHelper->reindexComplete();

            return $catalogRule;

        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || !isset($args['input']) || (isset($args['input']) && !$args['input'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
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
            throw new Exception($validator->messages());
        }

        try {

            $catalogRule = $this->catalogRuleRepository->findOrFail($id);

            Event::dispatch('promotions.catalog_rule.update.before', $catalogRule);

            $catalogRule = $this->catalogRuleRepository->update($params, $id);

            Event::dispatch('promotions.catalog_rule.update.after', $catalogRule);

            $this->catalogRuleIndexHelper->reindexComplete();

            return $catalogRule;

        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        if (! isset($args['id']) || (isset($args['id']) && !$args['id'])) {
            throw new Exception(trans('bagisto_graphql::app.admin.response.error-invalid-parameter'));
        }

        $id = $args['id'];

        $catalogRule = $this->catalogRuleRepository->find($id);

        try {
            if ($catalogRule != Null) {

                Event::dispatch('promotions.catalog_rule.delete.before', $id);

                $catalogRule->delete($id);

                Event::dispatch('promotions.catalog_rule.delete.after', $id);

                return ['success' => trans('admin::app.response.delete-success', ['name' => 'Catalog Rule'])];
            } else {
                throw new Exception(trans('admin::app.response.delete-failed', ['name' => 'Catalog Rule']));
            }
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }
    }

    /**
     * Generate coupon code for cart rule
     *
     * @return Response
     */
    public function generateCoupons($params, $id)
    {
        $validator = Validator::make($params, [
            'coupon_qty'  => 'required|integer|min:1',
            'code_length' => 'required|integer|min:10',
            'code_format' => 'required',
        ]);

        try {

            if (! $id) {
                throw new Exception(trans('admin::app.promotions.cart-rules.cart-rule-not-defind-error'));
            }

            $coupon = $this->cartRuleCouponRepository->generateCoupons($params, $id);

            return $coupon;
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

