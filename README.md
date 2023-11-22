# Bagisto GraphQL API

Laravel eCommerce headless APIs allow you to experience seamless and easily scalable storefront performance. The [open-source headless laravel](https://bagisto.com/en/headless-ecommerce/) platform built on GraphQL based Rest API delivers ultra-fast, dynamic, and personalized shopping experiences.

**Read our documentation: [Bagisto GraphQL API Docs](https://devdocs.bagisto.com/1.x/graphql-admin-api/)**


The Bagisto GraphQL API is made in collaboration with <a href="https://www.ucraft.com/">Ucraft Team</a>


### 1. Requirements:

* **Bagisto**: v2.0.0

### 2. Installation:

#### To clone Bagisto GraphQL run the below command from terminal:

~~~
composer require bagisto/graphql-api dev-main
~~~

* Add the below-line inside the **modules** index in **config/concord.php** file:

~~~
\Webkul\GraphQLAPI\Providers\ModuleServiceProvider::class,
~~~

* Find a file **app/Http/Kernel.php** from root and add these two **middlewares** inside the **$middleware** array:

~~~
\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
\Illuminate\Session\Middleware\StartSession::class,
~~~

* Find a file **config/auth.php** from root and bellow code inside **guard**:

~~~
 'api' => [
            'driver'   => 'jwt',
            'provider' => 'customer',
        ],

   'admin-api' => [
            'driver'   => 'jwt',
            'provider' => 'admin',
        ],

~~~

* Find a file **config/auth.php** from root and bellow code inside **providers**:

~~~
  'customer' => [
            'driver' => 'eloquent',
            'model'  => Webkul\GraphQLAPI\Models\Customer\Customer::class,
        ],

    'admin' => [
            'driver' => 'eloquent',
            'model'  =>  Webkul\GraphQLAPI\Models\Admin\Admin::class,
        ],

~~~

* Install **composer require php-open-source-saver/jwt-auth**

* Install **composer require nuwave/lighthouse**

* Install **composer require mll-lab/laravel-graphiql**

* Install **composer require mll-lab/laravel-graphql-playground**

* Run command **php artisan vendor:publish**

* Press number of the **Nuwave\Lighthouse\LighthouseServiceProvider** class and then press enter to publish all assets and configurations.

* Press number of the **MLL\GraphQLPlayground\GraphQLPlaygroundServiceProvider** class and then press enter to publish all assets and configurations.

* Press number of the **MLL\GraphiQL\GraphiQLServiceProvider** class and then press enter to publish all assets and configurations.

* Press number of the **PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider** class and then press enter to publish all assets and configurations.

* Find a file **config/lighthouse.php** from root and add bellow line of code:
    ~~~
    'schema_path' => base_path('packages/Webkul/GraphQLAPI/src/graphql/schema.graphql'),
    ~~~

* Find a file **config/lighthouse.php** from root and add comment bellow line of code inside **route/middleware**:
    ~~~
         \Nuwave\Lighthouse\Support\Http\Middleware\AcceptJson::class,

         \Nuwave\Lighthouse\Support\Http\Middleware\AttemptAuthentication::class,
        
        \Nuwave\Lighthouse\Support\Http\Middleware\LogGraphQLQueries::class,
    ~~~

* Add the **JWT_TTL (JWT time to live)** & **JWT_SHOW_BLACKLIST_EXCEPTION** entries in the **.env** file:

~~~
JWT_TTL=525600
JWT_SHOW_BLACKLIST_EXCEPTION=true
~~~

#### To install and publish the assests and configurations, run below command from the root in terminal:

~~~
php artisan bagisto-graphql:install
~~~

* Now to use the **graphql-playground** for testing the APIs:

~~~
http://your-domain.com/graphql-playground
~~~

* You can also use the **Postmen** for testing the APIs:

~~~
http://your-domain.com/graphql
~~~

> That's it, now just execute the project on your specified domain.
