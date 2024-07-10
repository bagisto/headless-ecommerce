<?php

namespace Webkul\GraphQLAPI\DataGrids;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Webkul\Core\Models\Channel;
use Webkul\Core\Models\Locale;
use Webkul\DataGrid\DataGrid;

class PushNotificationDataGrid extends DataGrid
{
    /**
     * Set index columns, ex: id.
     *
     * @var string
     */
    protected $primaryColumn = 'notification_id';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {

        $whereInLocales = (core()->getRequestedLocaleCode() === 'all')
            ? Locale::query()->pluck('code')->toArray()
            : [core()->getRequestedLocaleCode()];

        $whereInChannels = (core()->getRequestedChannelCode() === 'all')
            ? Channel::query()->pluck('code')->toArray()
            : [core()->getRequestedChannelCode()];

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
            ->leftJoin('push_notification_translations as pn_trans', function ($leftJoin) use ($whereInLocales, $whereInChannels) {
                $leftJoin->on('pn.id', '=', 'pn_trans.push_notification_id')
                    ->whereIn('pn_trans.locale', $whereInLocales)
                    ->whereIn('pn_trans.channel', $whereInChannels);
            })
            ->groupBy(
                'pn_trans.push_notification_id',
                'pn_trans.channel',
                'pn_trans.locale'
            );

        $this->addFilter('notification_id', 'pn.id');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'notification_id',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.id'),
            'type'       => 'number',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'image',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.image'),
            'type'       => 'html',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($value) {
                return '<img src='.Storage::url($value->image).' class="img-thumbnail" width="100px" height="70px" />';
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
            'index'      => 'type',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.notification-type'),
            'type'       => 'price',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.notification-status'),
            'type'       => 'boolean',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                if ($row->status) {
                    return '<span class="badge badge-md badge-success">'.trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.enabled').'</span>';
                }

                return '<span class="badge badge-md badge-danger">'.trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.status.disabled').'</span>';
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.created-at'),
            'type'       => 'datetime',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('bagisto_graphql::app.admin.settings.notification.index.datagrid.updated-at'),
            'type'       => 'datetime',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('settings.push_notification.edit')) {
            $this->addAction([
                'icon'   => 'icon-edit',
                'title'  => trans('admin::app.datagrid.edit'),
                'method' => 'GET',
                'url'    => function ($row) {
                    return route('admin.settings.push_notification.edit', $row->notification_id);
                },
                'condition' => function () {
                    return true;
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
                'condition' => function () {
                    return true;
                },
            ]);
        }
    }

    /**
     * Prepare mass actions.
     *
     * @return void
     */
    public function prepareMassActions()
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
