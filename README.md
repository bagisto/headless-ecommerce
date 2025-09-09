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

- **Bagisto**: ^2.3.0

---

### Installation:

To install the Bagisto GraphQL API, follow these steps:

1. **Install via Composer**

   Run the following command in your terminal to install the GraphQL API package:

   ```bash
   composer require bagisto/graphql-api:dev-main
   ```

2. **Run the following commands to complete the setup**

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

### 3. Authorization

To call certain APIs, you need to include `x-app-secret-key` in the request header.

1. **Set the Key**

   The `APP_SECRET_KEY` is generated automatically during installation and stored in your `.env` file:

   ```env
   APP_SECRET_KEY=generated-secret-key
   ```

2. **Share Securely**

   Provide this key to the frontend or mobile team as needed.

3. **Include in Requests**

   Add the header to your API calls:

   ```
   x-app-secret-key: generated-secret-key
   ```

---
      
4. **GraphQL Playground Endpoint Configuration**

   Ensure that the `GRAPHQL_ENDPOINT` in your `.env` file is set to your application's URL followed by `/graphiql`. For example:

   ```env
   GRAPHQL_ENDPOINT=https://your-domain.com/graphiql
   ```

5. **Cache Your GraphQL Schema for Better Performance**

   To avoid rebuilding the schema on every request, you can cache it. This improves performance significantly in production environments.

   Run the following Artisan command to cache the schema:

   ```bash
   php artisan lighthouse:cache
   ```

   If you make changes to your schema, remember to clear the cache:

   ```bash
   php artisan lighthouse:clear-cache
   ```
---

That's it! Your Bagisto GraphQL API is now ready. Execute the project on your specified domain and start building your headless eCommerce solution.
