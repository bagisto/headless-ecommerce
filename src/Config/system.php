<?php

return [
    [
        'key'  => 'general.api',
        'name' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.title',
        'info' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info',
        'sort' => 3,
    ], [
        'key'  => 'general.api.pushnotification',
        'name' => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.push-notification-configuration',
        'sort' => 1,

        'fields' => [
            [
                'name'          => 'private_key',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.private-key',
                'type'          => 'textarea',
                'validation'    => 'required',
                'info'          => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.info-get-private-key',
                'channel_based' => true,
            ], [
                'name'          => 'notification_topic',
                'title'         => 'bagisto_graphql::app.admin.configuration.index.general.graphql-api.notification-topic',
                'validation'    => 'required',
                'type'          => 'text',
                'channel_based' => true,
            ],
        ],
    ],
];