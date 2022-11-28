# Bagisto GraphQL API

Laravel eCommerce headless APIs allow you to experience seamless and easily scalable storefront performance. The [open-source headless laravel](https://bagisto.com/en/headless-ecommerce/) platform built on GraphQL based Rest API delivers ultra-fast, dynamic, and personalized shopping experiences.

**Read our documentation: [Bagisto GraphQL API Docs](https://devdocs.bagisto.com/1.x/graphql-admin-api/)**


The Bagisto GraphQL API is made in collaboration with <a href="https://www.ucraft.com/">Ucraft Team</a>


### 1. Requirements:

* **Bagisto**: v1.4.3

### 2. Installation:

##### To install Bagisto GraphQL from your console:

~~~
composer require bagisto/graphql-api
~~~

~~~
php artisan bagisto_graphql:install
~~~

##### Find a file config/lighthouse.php from root and do the following changes:

* change the **guard** index value from **api** to **admin-api** like below mentioned:

~~~
    'guard' => 'admin-api',
~~~

* change the path from *'graphql/schema.graphql'* to **'packages/Webkul/GraphQLAPI/graphql/schema.graphql'** for the **register** index under **schema** array index like below mentioned:

~~~
    'schema' => [
        'register' => base_path('vendor/bagisto/graphql-api/src/graphql/schema.graphql'),
    ],
~~~

* change the *App\\GraphQL\\* path to **Webkul\\GraphQLAPI\\** in all the indexes of **namespace** index:

~~~
    'namespaces' => [
        'models' => ['App', 'Webkul\\GraphQLAPI\\Models'],
        'queries' => 'Webkul\\GraphQLAPI\\Queries',
        'mutations' => 'Webkul\\GraphQLAPI\\Mutations',
        'subscriptions' => 'Webkul\\GraphQLAPI\\Subscriptions',
        'interfaces' => 'Webkul\\GraphQLAPI\\Interfaces',
        'unions' => 'Webkul\\GraphQLAPI\\Unions',
        'scalars' => 'Webkul\\GraphQLAPI\\Scalars',
        'directives' => ['Webkul\\GraphQLAPI\\Directives'],
        'validators' => ['Webkul\\GraphQLAPI\\Validators'],
    ],
~~~

##### Add the JWT_TTL (JWT time to live) & JWT_SHOW_BLACKLIST_EXCEPTION entries in the .env file under the JWT_SECRET key:

~~~
    JWT_TTL=525600
    JWT_SHOW_BLACKLIST_EXCEPTION=true
~~~

##### Run the below mentioned commands from the root directory in terminal:

~~~
composer dump-autoload
~~~

~~~
php artisan optimize:clear
~~~

#### Now to use the graphql-playground for testing the APIs:

~~~
    http://example.com/graphql-playground
~~~

#### Or you can also use the Postmen for testing the APIs:

~~~
    http://example.com/graphql
~~~
> That's it, now just execute the project on your specified domain.
