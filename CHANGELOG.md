# CHANGELOG for v2.0.x

This changelog consists of the bug & security fixes and new features included in the releases listed below.

## **v2.0.0 (20th of Mar, 2024)** - *Release*

* [Fixed] - #94 Getting exception in Attribute API

* [Fixed] - #97 Unable to Install the Headless GraphQL API

* [Fixed] - #98 If we give an input value [which does not exist] then we get an internal server error but need to get the proper message data not found on the console

* [Fixed] - #99 Getting exception in Inventory Source API

* [Fixed] - #100 Getting exception in Tax Rate API

* [Fixed] - #101 Getting exception in TaxCategory API

* [Fixed] - #102 Getting exception in Channel API

* [Fixed] - #103 Getting exception in the Theme API

* [Fixed] - #104 Please change API method to GET

* [Fixed] - #105 Getting exception in Simple Product API

* [Fixed] - #106 Getting exception on Config Product API

* [Fixed] - #107 Getting exception in Update Group Product

* [Fixed] - #108 Getting exception in Downloadable Product API

* [Fixed] - #109 Getting exception in Categories API

* [Fixed] - #111 Getting issue in Get and Post CMS Page API

* [Fixed] - #112 In Email Template API Status is not updated

* [Fixed] - #113 Unable to remove the customer account.

* [Fixed] - #114 Getting issue while Hitting Apply Coupon and Shipping method API

* [Fixed] - #115 Getting issue on Compare Products API

* [Fixed] - #116 Getting issue in Shop -> Products API

* [Fixed] - #117 Getting an exception while opening the Channel

* [Fixed] - #119 Unable to add the video to the product

* [Fixed] - #120 Category is created but image not updated on category.

* [Fixed] - #136 Getting issue with getFilterAttribute API.

* [Fixed] - #138 Method 'getCategoriesTree' does not exist on class

* [Fixed] - #139 Getting issue after run composer command on terminal while installing the bagisto headless.

* [Fixed] - #140 Admin is not able to login with valid credentials.

* [Fixed] - #144 Customer is able to update account detail without email address.

* [Fixed] - #146 Able to update gender wrong text in update account detail.

* [Fixed] - #147 Able to update account detail without phone number.

* [Fixed] - #150 Improve success message when review is deleted.

* [Fixed] - #155 Customer Wishlists API's not working getting 500 error.

* [Fixed] - #156 Compare Products APIs not working getting 500 error.

* [Fixed] - #159 Getting error in result but show response 200 in the Cart Item Detail API.

* [Fixed] - #160 Payment should be required field.

* [Fixed] - #161 Getting "Internal Server Error" if enter unavailable categorySlug.

* [Fixed] - #162 Getting wrong max price filter value.

* [Fixed] - #163 Getting "internal Server Error" in Get Categories Tree API.

* [Fixed] - #176 Sitemap is not deleting.

* [Fixed] - #184 Direction parameter should be required to fill.

* [Fixed] - #186 Image is not uploaded while create new locale.

* [Fixed] - #187 Decimal parameter is not available in the API Request.

* [Fixed] - #189 Countries api response is not correct.

* [Fixed] - #195 Description parameter is not available for inventory source create and update APIs.

* [Fixed] - #201 Inventory sources should be required option.

* [Fixed] - #205 Email should be required field while creating user.

* [Fixed] - #207 Getting "Internal Server Error" in response if request for create or update user without  password and confirm password parameters.

* [Fixed] - #216 Getting error in response for the Order's Item api request.

* [Fixed] - #219 Getting "Internal Server Error" in response if request with refunds api.

* [Fixed] - #220 Getting error in response for the refund's item api.

* [Fixed] - #221 Getting "500 Internal Server Error" in response for the products api request.

* [Fixed] - #231 Getting error message in response for related products request.

* [Fixed] - #232 Able to create or update attributes with invalid "type" parameter.

* [Fixed] - #234 Not able to remove the attribute getting warning message.

* [Fixed] - #237 Show status "null" when request for create new attributeFamily.

* [Fixed] - #242 Able to create or update address phone number and postcode with alphabetic parameters.

## **v1.4.6 (29th of Jun, 2023)** - *Release*

* [Enhancement] - Need to implement a Product share option on the Product detail page.

* [Enhancement] - Need to add the wishlist share option on wishlist page.

* [Enhancement] - Need to implement Remove all item option from the cart.

* [Enhancement] - Support to upload the customer's avatar using image path.

* [Enhancement] - Need to Add a filter on the Order page.

* [Enhancement] - Need to delete all option on the review section.

* [Enhancement] - Configurable products configuration is not displayed on the cart.

* [Enhancement] - Implemented Order place push notification.

* [Fixed] - Billing & shipping address fields validation added at the checkout mutation in case of a guest.

* [Fixed] - socialSignUp mutation issue with spead directive.

## **v1.4.5 (2nd of May, 2023)** - *Release*

* [Enhancement] - Modified updateAccount mutation for customer's profile image.

* [Enhancement] - Added filter attributes API for catalog listing.

* [Enhancement] - Added avarageRating and percentageRating for the Product Query.

* [Enhancement] - Added slug support(redirection) in advertisement banners.

* [Enhancement] - Advertisement API modified, Now can also use for Bagisto default theme.

* [Enhancement] - Added removeCoupon Mutation and translations in coupon.graphql schema file.

* [Enhancement] - Improvement in query schema for @rename directive lighthouse and modified field data return type.

* [Fixed] - Changed translation for product's review create success message.

* [Fixed] - now getting only approved reviews for the product.

* [Fixed] - swatchValue and category filterableAttribute null issue.

* [Fixed] - Advertisement image's URL issue.

## **v1.4.4 (15th of December, 2022)** - *Release*

* [Enhancement] - Currency and Locale converter functionality should be work, (use x-currency and x-locale in request header).

* [Fixed] - Getting issue in notifications (https://prnt.sc/c2Oj8RZQktCR).

## **v1.4.3 (12th of December, 2022)** - *Release*

* [Enhancement] - Order Cancellation API query added for log-in customer.

* [Enhancement] - Social Login sign up created for the TrueCaller.

* [Enhancement] - Push Notification List and Send APIs added.

* [Enhancement] - Push Notification section added at the Bagisto admin.

* [Enhancement] - Added category filters and sorting.

* [compatible] - Compatible with v1.4.3.

* [Fixed] - Fixed type Hinting initial push for compatibility.

## **v1.3.3 (12th of August, 2022)** - *Release*

* [Enhancement] - APIs support for the [VueStoreFront](https://github.com/bagisto/vuestorefront).

* [Enhancement] - APIs support for the [Next.js Commerce](https://github.com/bagisto/nextjs-commerce).

* [Enhancement] - APIs created for the Shop content (i.e. product by slug, new and featured product, order authentication, etc..).

* [Enhancement] - APIs added for the PayPal Standard Payment gateway.

* [Enhancement] - CacheImage schema added.

* [Enhancement] - Sorting product list and filter options added for the category.

* [Enhancement] - Added category filters and sorting.

## **v1.3.3 (12th of August, 2022)** - *Release*

* [Enhancement] - APIs support for the [VueStoreFront](https://github.com/bagisto/vuestorefront).

* [Enhancement] - APIs support for the [Next.js Commerce](https://github.com/bagisto/nextjs-commerce).

* [Enhancement] - APIs created for the Shop content (i.e. product by slug, new and featured product, order authentication, etc..).

* [Enhancement] - APIs added for the PayPal Standard Payment gateway.

* [Enhancement] - CacheImage schema added.

* [Enhancement] - Sorting product list and filter options added for the category.

* [Enhancement] - Added category filters and sorting.

## **v1.1.0 (07th of December, 2021)** - *Release*

* [Enhancement] - Product Number Attribute added to Product Schema.

* [Enhancement] - Product Videos support added to Product Schema.

* [Enhancement] - Email and Gender fields support added to Customer's address Schema.

* [Enhancement] - Note field support added to Customer Schema.

* [Enhancement] - New Postman APIs sample added to the package.

* [Fixed] - #47 Issues with GraphQL API in a fresh bagisto installation.

* [Fixed] - #46 RegistrationEmail Missing second parameters.

* [Fixed] - #44 Error after updating Bagisto to 1.3.3 (from Product::getTypeInstance()).

* [Fixed] - #43 Link to download and install it, must availbale in bagisto doc.

* [Fixed] - #42 Replace images files hosted externally in README.md

* [Fixed] - #41 Product update mutation not working properly.

* [Fixed] - #40 No commands defined in the "bagisto_graphql" namespace.

* [Fixed] - #38 composer support.

* [Fixed] - #37 Implemented API for adding JS on storefront.

## **v1.0.0 (27th of April 2021)** - *First Release*

* [Feature] Bagisto GraphQL API provides a complete and understandable description of the data.

* [Feature] Authentication: Customer Authentication with Login Details.

* [Feature] Authentication: Admin Authentication with Login Details.

* [Feature] Provide access to performed CRUD operations on Products, Categories, Orders, Customers, Promotions Rule, etc.

* [Feature] Provide the option to filter the responses based on attribute fields.

* [Feature] The Framework supports the pagination which helps to increase the performance of application.

* [Feature] Get many resources in a single request.
