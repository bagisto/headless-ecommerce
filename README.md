# Bagisto GraphQL API

<p align="center">
   <a href="https://packagist.org/packages/bagisto/graphql-api">
      <img
         src="https://poser.pugx.org/bagisto/graphql-api/d/total.svg"
         alt="Total Downloads"
      >
   </a>

   <a href="https://packagist.org/packages/bagisto/graphql-api">
      <img
         src="https://poser.pugx.org/bagisto/graphql-api/v/stable.svg"
         alt="Latest Stable Version"
      >
   </a>

   <a href="https://packagist.org/packages/bagisto/graphql-api">
      <img
         src="https://poser.pugx.org/bagisto/graphql-api/license.svg"
         alt="License"
      >
   </a>
</p>

Bagisto's GraphQL API enables a seamless, headless eCommerce experience built on Laravel. This API delivers ultra-fast, dynamic, and personalized shopping experiences through a scalable, open-source platform.

**Read our full documentation: [Bagisto GraphQL API Docs](https://devdocs.bagisto.com/2.3/api/graphql-api.html)**

This API was developed in collaboration with the <a href="https://www.ucraft.com/">Ucraft Team</a>.

---

### Requirements:

- **Bagisto**: v2.3.0

---

### Installation:

To install the Bagisto GraphQL API, follow these steps:

1. **Install via Composer**

   Run the following command in your terminal to install the GraphQL API package:

   ```bash
   composer require bagisto/graphql-api dev-main
   ```

2. **Update Middleware Configuration**

   In your `bootstrap/app.php` file, add the following session middleware changes:

   ```php
   use Illuminate\Session\Middleware\StartSession;
   use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

   return Application::configure(basePath: dirname(__DIR__))
      ->withMiddleware(function (Middleware $middleware) {
         // ... rest of middleware setup

         /**
          * Remove session and cookie middleware from the 'web' middleware group.
          */
         $middleware->removeFromGroup('web', [StartSession::class, AddQueuedCookiesToResponse::class]);

         /**
          * Adding session and cookie middleware globally to apply across non-web routes (e.g. GraphQL)
          */
         $middleware->append([StartSession::class, AddQueuedCookiesToResponse::class]);
      })
      // ... rest of configuration
   ```

   This ensures that session and cookie middleware are applied globally across all routes, including API and GraphQL endpoints.

3. **Update Environment Settings**

   Add the following entries to your `.env` file to configure JWT settings:

   ```env
   JWT_TTL=525600
   JWT_SHOW_BLACKLIST_EXCEPTION=true
   ```

4. **Publish Assets and Configurations**

   Run the command below to publish assets and configurations for Bagisto GraphQL:

   ```bash
   php artisan bagisto-graphql:install
   ```

---

### Usage:

1. **GraphQL Playground**

   After installation, you can test your API through the GraphQL Playground. Visit:

   ```
   http://your-domain.com/graphiql
   ```

2. **Postman Integration**

   Alternatively, you can test the API using Postman by accessing:

   ```
   http://your-domain.com/graphql
   ```
3. **Authorization**

   To authorize requests for certain APIs, you may need to provide the `MOBIKUL_API_KEY`. 

   1. **Locate the API Key**

      Find the `MOBIKUL_API_KEY` in your `.env` file:

      ```env
      MOBIKUL_API_KEY=your-mobikul-api-key
      ```

   2. **Share with App Development Team**

      Copy this key and securely share it with the Development team as required for API authorization.

   3. **Using the API Key**

      When making requests to protected admin endpoints, include the API key in the request headers:

      ```
      MOBIKUL_API_KEY: your-mobikul-api-key
      ```

      Replace `your-mobikul-api-key` with the actual value from your `.env` file.

---

That's it! Your Bagisto GraphQL API is now ready. Execute the project on your specified domain and start building your headless eCommerce solution.
