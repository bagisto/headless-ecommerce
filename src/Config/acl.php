<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings\PushNotification
    |--------------------------------------------------------------------------
    |
    | All ACLs related to settings\pushnotification will be placed here.
    |
    */
    [
        'key'   => 'settings.push_notification',
        'name'  => 'bagisto_graphql::app.admin.acl.push-notification',
        'route' => 'admin.settings.push_notification.index',
        'sort'  => 9,
    ], [
        'key'   => 'settings.push_notification.create',
        'name'  => 'bagisto_graphql::app.admin.acl.create',
        'route' => 'admin.settings.push_notification.create',
        'sort'  => 1,
    ], [
        'key'   => 'settings.push_notification.edit',
        'name'  => 'bagisto_graphql::app.admin.acl.edit',
        'route' => 'admin.settings.push_notification.edit',
        'sort'  => 2,
    ], [
        'key'   => 'settings.push_notification.delete',
        'name'  => 'bagisto_graphql::app.admin.acl.delete',
        'route' => 'admin.settings.push_notification.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.push_notification.massdelete',
        'name'  => 'bagisto_graphql::app.admin.acl.mass-delete',
        'route' => 'admin.settings.push_notification.mass_delete',
        'sort'  => 4,
    ], [
        'key'   => 'settings.push_notification.massupdate',
        'name'  => 'bagisto_graphql::app.admin.acl.mass-update',
        'route' => 'admin.settings.push_notification.mass_update',
        'sort'  => 5,
    ], [
        'key'   => 'settings.push_notification.send',
        'name'  => 'bagisto_graphql::app.admin.acl.send',
        'route' => 'admin.settings.push_notification.send_notification',
        'sort'  => 6,
    ],
];
