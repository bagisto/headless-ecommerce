# Bagisto GraphQL API

Laravel eCommerce headless APIs allow you to experience seamless and easily scalable storefront performance. An open-source and GraphQL based Rest API Laravel platform delivering ultra-fast, dynamic, and personalized shopping experiences.

**Read our documentation: [Bagisto GraphQL API Docs](https://devdocs.bagisto.com/1.x/graphql-admin-api/)**


The Bagisto GraphQL API is made in collaboration with <a href="https://www.ucraft.com/">Ucraft Team</a>


### 1. Requirements:

* **Bagisto**: v1.3.3

### 2. Installation:

* Unzip the respective extension zip and then merge "packages" folder into project root directory.

#### Goto config/app.php file and add following line under 'providers'

~~~
    Webkul\GraphQLAPI\Providers\GraphQLAPIServiceProvider::class
~~~

#### Goto composer.json file and add following line under 'psr-4'

~~~
    "Webkul\\GraphQLAPI\\": "packages/Webkul/GraphQLAPI"
~~~

#### Run the below mentioned commands from the root directory in terminal:

~~~
    composer dump-autoload
~~~
~~~
    php artisan optimize
~~~
~~~
    php artisan bagisto_graphql:install
~~~

#### Find a file config/lighthouse.php from root and do the following changes:

* change the **guard** index value from **api** to **admin-api** like below mentioned:

~~~
    'guard' => 'admin-api',
~~~

* change the path from *'graphql/schema.graphql'* to **'packages/Webkul/GraphQLAPI/graphql/schema.graphql'** for the **register** index under **schema** array index like below mentioned:

~~~
    'schema' => [
        'register' => base_path('packages/Webkul/GraphQLAPI/graphql/schema.graphql'),
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

* Add the **JWT_TTL** (JWT time to live) entry in the **.env** file under the **JWT_SECRET** key:

~~~
    JWT_TTL=525600
~~~

#### Now to use the graphql-playground for testing the APIs:

~~~
    http://example.com/graphql-playground
~~~

#### To check the customer's API (front APIs), you have to put all the shop schemas at the end in the schema file (i.e. packages/Webkul/GraphQLAPI/graphql/schema.graphql).

~~~
    put all shop schemas #import /shop/*/*.graphql after #import /promotion/*.graphql this line.
~~~

#### Or you can also use the Postmen for testing the APIs:

~~~
    http://example.com/graphql
~~~
> That's it, now just execute the project on your specified domain.

#### Sponsors

Support this project by becoming a sponsor. Your logo will show up here with a link to your website.

<kbd>
    <a href="https://www.ucraft.com/" target="_blank">
        <img src="https://bagisto.com/wp-content/uploads/2021/03/ucraft-bagisto.png" height="75">
    </a>
</kbd>