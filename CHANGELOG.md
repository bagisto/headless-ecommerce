# CHANGELOG for v1.x.x

This changelog consists of the bug & security fixes and new features included in the releases listed below.

* [fixed] - Billing & shipping address fields validation added at the checkout mutation in case of a guest.

* [enhancement] - Need to Add a filter on the Order page.

* [enhancement] - Need to delete all option on the review section.

* [enhancement] - Configurable products configuration is not displayed on the cart.

* [enhancement] - Implemented Order place push notification.

## **v1.4.5 (2nd of May, 2023)** - *Release*

* [enhancement] - Modified updateAccount mutation for customer's profile image.

* [enhancement] - Added filter attributes API for catalog listing.

* [enhancement] - Added avarageRating and percentageRating for the Product Query.

* [enhancement] - Added slug support(redirection) in advertisement banners.

* [enhancement] - Advertisement API modified, Now can also use for Bagisto default theme.

* [enhancement] - Added removeCoupon Mutation and translations in coupon.graphql schema file.

* [enhancement] - Improvement in query schema for @rename directive lighthouse and modified field data return type.

* [fixed] - Changed translation for product's review create success message.

* [fixed] - now getting only approved reviews for the product.

* [fixed] - swatchValue and category filterableAttribute null issue.

* [fixed] - Advertisement image's URL issue.

## **v1.4.4 (15th of December, 2022)** - *Release*

* [enhancement] - Currency and Locale converter functionality should be work, (use x-currency and x-locale in request header).

* [fixed] - Getting issue in notifications (https://prnt.sc/c2Oj8RZQktCR).

## **v1.4.3 (12th of December, 2022)** - *Release*

* [enhancement] - Order Cancellation API query added for log-in customer.

* [enhancement] - Social Login sign up created for the TrueCaller.

* [enhancement] - Push Notification List and Send APIs added.

* [enhancement] - Push Notification section added at the Bagisto admin.

* [enhancement] - Added category filters and sorting.

* [compatible] - Compatible with v1.4.3.

* [fixed] - Fixed type Hinting initial push for compatibility.

## **v1.3.3 (12th of August, 2022)** - *Release*

* [enhancement] - APIs support for the [VueStoreFront](https://github.com/bagisto/vuestorefront).

* [enhancement] - APIs support for the [Next.js Commerce](https://github.com/bagisto/nextjs-commerce).

* [enhancement] - APIs created for the Shop content (i.e. product by slug, new and featured product, order authentication, etc..).

* [enhancement] - APIs added for the PayPal Standard Payment gateway.

* [enhancement] - CacheImage schema added.

* [enhancement] - Sorting product list and filter options added for the category.

* [enhancement] - Added category filters and sorting.

## **v1.3.3 (12th of August, 2022)** - *Release*

* [enhancement] - APIs support for the [VueStoreFront](https://github.com/bagisto/vuestorefront).

* [enhancement] - APIs support for the [Next.js Commerce](https://github.com/bagisto/nextjs-commerce).

* [enhancement] - APIs created for the Shop content (i.e. product by slug, new and featured product, order authentication, etc..).

* [enhancement] - APIs added for the PayPal Standard Payment gateway.

* [enhancement] - CacheImage schema added.

* [enhancement] - Sorting product list and filter options added for the category.

* [enhancement] - Added category filters and sorting.

## **v1.1.0 (07th of December, 2021)** - *Release*

* [enhancement] - Product Number Attribute added to Product Schema.

* [enhancement] - Product Videos support added to Product Schema.

* [enhancement] - Email and Gender fields support added to Customer's address Schema.

* [enhancement] - Note field support added to Customer Schema.

* [enhancement] - New Postman APIs sample added to the package.

* #47 [fixed] - Issues with GraphQL API in a fresh bagisto installation.

* #46 [fixed] - RegistrationEmail Missing second parameters.

* #44 [fixed] - Error after updating Bagisto to 1.3.3 (from Product::getTypeInstance()).

* #43 [fixed] - Link to download and install it, must availbale in bagisto doc.

* #42 [fixed] - Replace images files hosted externally in README.md

* #41 [fixed] - Product update mutation not working properly.

* #40 [fixed] - No commands defined in the "bagisto_graphql" namespace.

* #38 [fixed] - composer support.

* #37 [fixed] - Implemented API for adding JS on storefront.

## **v1.0.0 (27th of April 2021)** - *First Release*

* [feature] Bagisto GraphQL API provides a complete and understandable description of the data.

* [feature] Authentication: Customer Authentication with Login Details.

* [feature] Authentication: Admin Authentication with Login Details.

* [feature] Provide access to performed CRUD operations on Products, Categories, Orders, Customers, Promotions Rule, etc.

* [feature] Provide the option to filter the responses based on attribute fields.

* [feature] The Framework supports the pagination which helps to increase the performance of application.

* [feature] Get many resources in a single request.
