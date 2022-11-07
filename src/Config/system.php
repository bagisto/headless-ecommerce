<?php

return [
    [
        'key'  => 'general.api',
        'name' => 'bagisto_graphql::app.admin.system.graphql-api',
        'sort' => 3,
    ],  [
        'key'   => 'general.api.pushnotification',
        'name'  => 'bagisto_graphql::app.admin.system.push-notification-configuration',
        'sort'  => 1,
        'fields'=> [
            [
                'name'          => 'server_key',
                'title'         => 'bagisto_graphql::app.admin.system.server-key',
                'type'          => 'text',
                'info'          => 'bagisto_graphql::app.admin.system.info-get-server-key',
                'channel_based' => true
            ], [
                'name'          => 'android_topic',
                'title'         => 'bagisto_graphql::app.admin.system.android-topic',
                'type'          => 'text',
                'channel_based' => true
            ], [
                'name'          => 'ios_topic',
                'title'         => 'bagisto_graphql::app.admin.system.ios-topic',
                'type'          => 'text',
                'channel_based' => true
            ],
        ]
    ]
];