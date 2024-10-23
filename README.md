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

**Read our full documentation: [Bagisto GraphQL API Docs](https://devdocs.bagisto.com/2.2/api/)**

This API was developed in collaboration with the <a href="https://www.ucraft.com/">Ucraft Team</a>.

---

### Requirements:

- **Bagisto**: v2.2.2 or higher

---

### Installation:

To install the Bagisto GraphQL API, follow these steps:

1. **Install via Composer**

   Run the following command in your terminal to install the GraphQL API package:

   ```bash
   composer require bagisto/graphql-api dev-main
   ```

2. **Update Middleware Configuration**

   In the `app/Http/Kernel.php` file, move the following middleware from the `web` section in the `middlewareGroups` array to the global `middleware` array:

   ```php
   \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
   \Illuminate\Session\Middleware\StartSession::class,
   ```

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

---

That's it! Your Bagisto GraphQL API is now ready. Execute the project on your specified domain and start building your headless eCommerce solution.
