# CHANGELOG for v2.x

This changelog consists of the bug & security fixes and new features included in the releases listed below.

v2.3.2 (07th of August, 2025) - Release

* Fixed graphiql endpoint issue

v2.3.1 (17th of July, 2025) - Release

# Enhancements

* [Enhancement] - Remove CA locale and update readme #534

* [Enhancement] - add CA locale #535

# Bug Fixes

* Fixed issues #521, #523, #526, #530 #532

v2.3.0 (16th of May, 2025) - Release

#  Enhancements

* [Enhancement] - Compatibility with v2.3.0

* [Enhancement] - Compatibility with Laravel 11

* [Enhancement] - Booking product feature added

* [Enhancement] - Customizable Options feature added

* [Enhancement] - GDPR feature added

#  Bug Fixes

* #363 [Fixed] - Email validation not working in create customer.

* #364 [Fixed] - Phone no. validation is not working in Customer create in admin side.

* #366 [Fixed] - wrong message when customer sign up in Shop End.

* #368 [Fixed] - Phone no. validation is not working in customer update(Shop End).

* #369 [Fixed] - Image updation is not working properly in Customer update.

* #370 [Fixed] - Email Validation is not working in create Address in Shop End.

* #371 [Fixed] - SQL Error show when enter wrong input product id in Review(Shop End).

* #376 [Fixed] - Should not create guest review by hit Review API when allow guest review Option is Disable.

* #379 [Fixed] - Booking Product API is missing in AdminEnd.

* #385 [Fixed] - Should show proper message when hit Place order API.

* #386 [Fixed] - Should show proper message when hit Remove Coupon API.

* #387 [Fixed] - E-mail validation is not working in checkout save address API.

* #388 [Fixed] - Should show correct message in Review create API.

* #391 [Fixed] - Show proper Aprropriate or meaingful error message in campaign Create Api.

* #392 [Fixed] - Show proper Aprropriate or meaingful error message in campaign Delete Api.

* #393 [Fixed] - Wrong Message show When Updating Locale with Existing Code and Wrong ID.

* #394 [Fixed] - Wrong Message show When Updating channel with Existing Code and Wrong ID.

* #400 [Fixed] - Products & product API is not working properly.

* #405 [Fixed] - Apply quantities validation in Create Invoice GraphQl API.

* #408 [Fixed] - Show wrong message in Download Sample API in Common Shop END.

* #411 [Fixed] - Should be show a proper understanding error message in remove coupon API in Shop End.

* #412 [Fixed] - API Returns Cookies Despite Is-Cookie-Exist: true or 1 in All Shop APi.

* #414 [Fixed] - Guest Can Submit Review Even When Guest Review Configuration Is Disabled.

* #418 [Fixed] - Able to Add Disabled Product to Cart.

* #419 [Fixed] - Show warning Message when wishlist is vacant.

* #420 [Fixed] - GDPR Request Created Even When GDPR Configuration is Disabled from Admin Panel.

* #421 [Fixed] - GDPR configuration is disabled but customer are able to fetch GDPR data

* #422 [Fixed] - GDPR revoke Request hit whereas GDPR configuration is DIsabled.

* #423 [Fixed] - GDPR Download PDF API Fails with GraphQL Error: Missing query or queryId.

* #429 [Fixed] - GraphQL Error: Cannot query field "name" on type "DownloadSampleResponse".

* #430 [Fixed] - GDPR Create API accepts numeric value for type and allows incorrect spellings for "update" / "delete".

* #435 [Fixed] - show warning message when Compare product is vacant/empty.

* #437 [Fixed] - Google Login via API works even when Google Login is disabled in Admin Configuration.


v2.2.2 (23rd of October, 2024) - Release

#  Enhancements

* [Enhancement] - Compatibility with v2.2.2

#  Bug Fixes

* [Fixed] - Create and Update API ||Need to pass the validation message as per the required field for the customer create address api.

* [Fixed] - Create and Update API ||Need to improve the validation message for the phone number and postcode field if enter invalid data while create new address.

* [Fixed] - Need to improve the validation message if enter invalid id for the update cms api.

* [Fixed] - Need to improve the validation message if enter already used url key for the update cms api.

* [Fixed] - Need to improve the validation message if create campaign without enter name and subject.

* [Fixed] - Campaign section api's not working.

* [Fixed] - Need to improve the validation message if create or update locales without enter name and code.

* [Fixed] - Need to improve the validation message if create or update currencies without enter name and code.

* [Fixed] - Group and decimal separator, currency position data is not available in the currency create or update api body.

* [Fixed] - Getting validation message when create or update the currency.

* [Fixed] - Need to improve the validation message if create or update users without enter name and email.

* [Fixed] - Validations are not working for the password field while create or update users at admin end.

* [Fixed] - Need to improve the validation message if create or update roles without enter name and description.

* [Fixed] - Need to improve the validation message if create or update tax category without enter code, name, description and tax rates.

* [Fixed] - Need to improve the validation message if create or update inventory source without enter code, name, contactName, contactNumber, contactEmail, street, country, city and postcode.

* [Fixed] - Need to improve the validation message if create or update theme without enter name.

* [Fixed] - Push Notification content is not updating on the push notification page at admin end.

* [Fixed] - Admin is not able to create the invoice

* [Fixed] - Able to create cart with invalid customer id.

* [Fixed] - Need to change the "isSaved" parameter to "SaveAddress" for billing and shipping address parameter while save address.

* [Fixed] - Need to improve the validation message if user enter invalid password while login.

* [Fixed] - Need to improve the error message if user trying to social sign up with unfilled data.

* [Fixed] - Need to improve the response message for the forget password api if smtp is not configured.

* [Fixed] - Customer address delete api is not working.

* [Fixed] - Need to improve the success message when add product to cart from the wishlist.

* [Fixed] - Customer not able to create the review.

* [Fixed] - Customer is not able to delete the review.

* [Fixed] - "Save Payment Method" api is working after enter invalid payment method.

* [Fixed] - Not able to create the the Simple, grouped, downloadable, bundle and virtual product from the admin end.

* [Fixed] - Getting "Internal Server Error" after hit update Attributes Details Api with invalid id.

* [Fixed] - Getting "Int cannot represent non-integer value" error message when update the category details.

## **v2.0.2 (31st of July, 2024)** - *Release*

* [Fixed] - TokenInvalidException class updated for JWTAuth.

* [Fixed] - Customer validation message issue fixed.

* [Fixed] - Notification Private Key check added for order.

* [Fixed] - Customer newsletter schema updated.

* [Fixed] - Countries API modified from admin end.

* [Fixed] - Newsletter subscription issue for customer.

* [Fixed] - Newsletter subscription issue for customer.

* [Fixed] - Multi-locale issues for the ThemeContent.

* [Fixed] - Return type added for Models\CatalogRule\CatalogRule.php PR:#249

* [Enhancement] - #252 Update firebase notification feature.

* [Enhancement] - getFilterAttributes method for default value.

* [Enhancement] - ServiceProvider and Console/Install files.

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
