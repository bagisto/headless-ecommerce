# graphql-api

Bagisto GraphQL APIs


### 1. Requirements:

* **Bagisto**: v1.2.0, v1.3.x


### 2. Installation:

* Unzip the respective extension zip and then merge "packages" folder into project root directory.

#### Goto config/app.php file and add following line under 'providers'

~~~
    Webkul\GraphQLAPI\Providers\GraphQLAPIServiceProvider::class
~~~

#### Find a file auth.php present inside config folder from root and do the following changes:

* change the *token* driver to *jwt* in **'guards'** array like below mentioned (for Bagisto v1.2.0):

~~~
    'admin-api' => [
        'driver'    => 'jwt',
        'provider'  => 'admins',
    ]
~~~

* replace the *admins* array index with the below-mentioned value in **'providers'** array:

~~~
    'admins' => [
        'driver'    => 'eloquent',
        'model'     => Webkul\GraphQLAPI\Models\User\Admin::class,
    ]
~~~

#### Goto composer.json file and add following line under 'psr-4'

~~~
    "Webkul\\GraphQLAPI\\": "packages/Webkul/GraphQLAPI"
~~~

#### Goto packages/Webkul/Checkout/src/Http/helpers.php file and replace the Cart::class to

* replace **Cart::class** to **'cart'** keyword.


#### Run the below mentioned commands from the root directory in terminal:

~~~
    composer dump-autoload
~~~
~~~
    php artisan bagisto_graphql:install
~~~

#### Find a file config/lighthouse.php from root and do the following changes:

* change the **guard** index value from **api** to **admin-api** like below mentioned:

~~~
    https://prnt.sc/y03ye5
~~~

* change the path from *'graphql/schema.graphql'* to **'packages/Webkul/GraphQLAPI/graphql/schema.graphql'** for the **register** index under **schema** array index like below mentioned:

~~~
    https://prnt.sc/y03vxl
~~~

* change the *App\\GraphQL\\* path to **Webkul\\GraphQLAPI\\** in all the indexes of **namespace** index:

~~~
    https://prnt.sc/y03tnh
~~~

* Add the **JWT_TTL** (JWT time to live) entry in the **.env** file under the **JWT_SECRET** key:

~~~
    JWT_TTL=525600
~~~

#### To check the customer's API (front APIs), you have to put all the shop schemas at the end in the schema file (i.e. packages/Webkul/GraphQLAPI/graphql/schema.graphql).

~~~
    put all shop schemas #import /shop/*/*.graphql after #import /promotion/*.graphql this line.
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
