<?php

return [
    [
        'key'  => 'general.api',
        'name' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.title',
        'info' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info',
        'icon' => 'settings/settings.svg',
        'sort' => 3,
    ], [
        'key'  => 'general.api.pushnotification',
        'name' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.push-notification-configuration',
        'info' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info',
        'sort' => 1,

        'fields' => [
            [
                'name'          => 'server_key',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.server-key',
                'type'          => 'text',
                'info'          => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info-get-server-key',
                'channel_based' => true,
            ], [
                'name'          => 'android_topic',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.android-topic',
                'type'          => 'text',
                'channel_based' => true,
            ], [
                'name'          => 'ios_topic',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.ios-topic',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ],
];
