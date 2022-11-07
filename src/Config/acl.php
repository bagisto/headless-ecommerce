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
        'route' => 'admin.push_notification.index',
        'sort'  => 9,
    ], [
        'key'   => 'settings.push_notification.create',
        'name'  => 'admin::app.acl.create',
        'route' => 'admin.push_notification.create',
        'sort'  => 1,
    ], [
        'key'   => 'settings.push_notification.edit',
        'name'  => 'admin::app.acl.edit',
        'route' => 'admin.push_notification.edit',
        'sort'  => 2,
    ], [
        'key'   => 'settings.push_notification.delete',
        'name'  => 'admin::app.acl.delete',
        'route' => 'admin.push_notification.delete',
        'sort'  => 3,
    ], [
        'key'   => 'settings.push_notification.massdelete',
        'name'  => 'admin::app.acl.mass-delete',
        'route' => 'admin.push_notification.mass-delete',
        'sort'  => 4,
    ], [
        'key'   => 'settings.push_notification.massupdate',
        'name'  => 'admin::app.acl.mass-update',
        'route' => 'admin.push_notification.mass-update',
        'sort'  => 5,
    ], [
        'key'   => 'settings.push_notification.send',
        'name'  => 'bagisto_graphql::app.admin.acl.send',
        'route' => 'admin.push_notification.send-notification',
        'sort'  => 6,
    ], 
];
