<?php

namespace Webkul\GraphQLAPI\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Webkul\DataGrid\DataGrid;

class PushNotificationDataGrid extends DataGrid
{
    /**
     * Primary column.
     *
     * @var string
     */
    protected $primaryColumn = 'notification_id';

    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('push_notifications as pn')
            ->select(
                'pn.id as notification_id',
                'pn.image',
                'pn.type',
                'pn.product_category_id',
                'pn.status',
                'pn.created_at',
                'pn.updated_at',
                'pn_trans.title',
                'pn_trans.content',
                'pn_trans.channel',
                'pn_trans.locale',
            )
            ->leftJoin('push_notification_translations as pn_trans', 'pn.id', '=', 'pn_trans.push_notification_id')
            ->where('pn_trans.locale', app()->getLocale())
            ->groupBy('pn.id');

        $this->addFilter('notification_id', 'pn.id');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'notification_id',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.id'),
            'type'       => 'integer',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'image',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.image'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => false,
            'sortable'   => false,
            'closure'    => function ($row) {
                if ($row->image) {
                    return '<img src='.Storage::url($row->image).' class="max-h-[65px] min-h-[65px] min-w-[65px] max-w-[65px] rounded" width="65px" height="65px" />';
                }

                return '<img src='.bagisto_asset('images/product-placeholders/front.svg', 'admin').' class="max-h-[65px] min-h-[65px] min-w-[65px] max-w-[65px] rounded" width="65px" height="65px" />';
            },
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.text-title'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'content',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.notification-content'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'              => 'type',
            'label'              => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.notification-type'),
            'type'               => 'string',
            'filterable'         => true,
            'filterable_type'    => 'dropdown',
            'filterable_options' => [
                [
                    'label' => trans('bagisto_graphql::app.admin.settings.notification.create.option-type.others'),
                    'value' => 'others',
                ],
                [
                    'label' => trans('bagisto_graphql::app.admin.settings.notification.create.option-type.product'),
                    'value' => 'product',
                ],
                [
                    'label' => trans('bagisto_graphql::app.admin.settings.notification.create.option-type.category'),
                    'value' => 'category',
                ],
            ],
            'sortable'           => true,
            'closure'            => function ($value) {
                switch ($value->type) {
                    case 'others':
                        return trans('bagisto_graphql::app.admin.settings.notification.create.option-type.others');

                    case 'product':
                        return trans('bagisto_graphql::app.admin.settings.notification.create.option-type.product');

                    case 'category':
                        return trans('bagisto_graphql::app.admin.settings.notification.create.option-type.category');
                }
            },
        ]);

        $channels = core()->getAllChannels();

        if ($channels->count() > 1) {
            $this->addColumn([
                'index'              => 'channel',
                'label'              => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.channel-name'),
                'type'               => 'string',
                'filterable'         => true,
                'filterable_type'    => 'dropdown',
                'filterable_options' => $channels
                    ->map(function ($channel) {
                        return [
                            'label' => $channel->name,
                            'value' => $channel->code,
                        ];
                    })
                    ->values()
                    ->toArray(),
                'sortable'           => true,
                'visibility'         => false,
            ]);
        }

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.notification-status'),
            'type'       => 'boolean',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                if ($row->status) {
                    return '<p class="label-active">'.trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.enabled').'</p>';
                }

                return '<p class="label-info">'.trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.disabled').'</p>';
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.created-at'),
            'type'       => 'date',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.updated-at'),
            'type'       => 'date',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     */
    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('settings.push_notification.edit')) {
            $this->addAction([
                'icon'   => 'icon-edit',
                'title'  => trans('admin::app.datagrid.edit'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.settings.push_notification.edit', $row->notification_id);
                },
            ]);
        }

        if (bouncer()->hasPermission('settings.push_notification.delete')) {
            $this->addAction([
                'icon'   => 'icon-delete',
                'title'  => trans('admin::app.datagrid.delete'),
                'method' => 'POST',
                'url'    => function ($row) {
                    return route('admin.settings.push_notification.delete', $row->notification_id);
                },
            ]);
        }
    }

    /**
     * Prepare mass actions.
     */
    public function prepareMassActions(): void
    {
        if (bouncer()->hasPermission('settings.push_notification.massdelete')) {
            $this->addMassAction([
                'title'  => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.delete'),
                'url'    => route('admin.settings.push_notification.mass_delete'),
                'method' => 'POST',
            ]);
        }

        if (bouncer()->hasPermission('settings.push_notification.massupdate')) {
            $this->addMassAction([
                'title'   => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.update'),
                'url'     => route('admin.settings.push_notification.mass_update'),
                'method'  => 'POST',
                'options' => [
                    [
                        'label' => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.enabled'),
                        'value' => 1,
                    ],
                    [
                        'label' => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.disabled'),
                        'value' => 0,
                    ],
                ],
            ]);
        }
    }
}
