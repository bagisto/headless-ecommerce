# Summary of Changes for Version 2.3.0

This document summarizes the changes made in the Headless GraphQL API upgrade.

---

## ✅ Removed

### 1. `filterData` key removed from `getFilterAttribute`

- **Reference:** [GitHub PR #383](https://github.com/bagisto/headless-ecommerce/pull/383/files#diff-b53a804ac65a01cfc9e2538ca178c754606b1d95f7866647c82439ec8e4b636eL30)

### 2. `uploadType` support removed for `PATH`, `BASE64`

- **Supported Type Now:** Only `FILE`
- **Change:** You no longer need to specify `uploadType`. The default behavior now assumes type `FILE`.
- **Impact:** Cleaner input structure for file uploads, and deprecation of alternate types.

---

## ➕ Added

### 2. `customizableOptions` key added to `AddItemToCartInput`

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/Anmol-Chauhan/headless-ecommerce/blob/8f602cf2779c16bd79d07869f919e13e9839515e/src/graphql/shop/cart/cart.graphql#L34)

### 3. `customizableOptions` added in `Product` type

- **Reference:** [GitHub PR #406](https://github.com/bagisto/headless-ecommerce/pull/406/files#diff-4008715936679298000421a7ff9c1cb16ff258d318a2b3978d160864a9663c6fR178)

### 4. `GDPRRequest` mutation added

- **Reference:** [GitHub PR #380](https://github.com/bagisto/headless-ecommerce/pull/380/files#diff-6aac7235ac90a8a1cbf8365cb47f65143e5b968b4f8ae2bc5a5d0efd8e248ccdR40)

### 5. `agreement` key added to `CustomerSignUpInput`

- **Reference:** [GitHub PR #397](https://github.com/bagisto/headless-ecommerce/pull/397/files#diff-dbafbad932d1a11b9f18292270feecb0f996e13f485821fd323fceef890d467cR19)

### 6. `services` key added to `Options -> themeCustomization`

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/456/files#diff-6c6a44775cb7ca44bdf94f4ae93db32860b12bbdcbd738d9e16436e275ca04f2R104)

### 7. `links` key added to `Options -> themeCustomization`

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/456/files#diff-6c6a44775cb7ca44bdf94f4ae93db32860b12bbdcbd738d9e16436e275ca04f2R98)

### 8. `dateFrom, dateTo` key added to `booking -> AddItemToCartInput`

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/456/files#diff-aeeb99e17e824717b6e45db2f06908c3ee0559b79a230fad7b3f7afe8050407eR78)

### 9. `statusLabel` key added to `orders`

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/453/files#diff-e8cd8441459d8eb2d12401516b78ae688b8df8867e15c21e603d30a906b6df31R100)


### 10. `isPaymentRequired` key added to `placeOrder` mutation as input field, default value is false and this is boolean type

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/476/files#diff-76e858e4fb54c649c61fd09d1943d2e790e9be48f6b5ff8c16ab109b3d38fd7eR4)

### 10. `viewGdprData` API is Created

- **Reference:** [GitHub (Anmol-Chauhan)](https://github.com/bagisto/headless-ecommerce/pull/483/files#diff-6aac7235ac90a8a1cbf8365cb47f65143e5b968b4f8ae2bc5a5d0efd8e248ccdR19)

---

## 🛠️ Updated

### 6. Renamed `formatedPrice` to `formattedPrice` in `ConfigurableVariantPrices`

- **Reference:** [GitHub PR #428](https://github.com/bagisto/headless-ecommerce/pull/428/files#diff-751cf71213338a25269e065a9e0b9f2adf655f3c7b09c752775c6211f37f2c4fR30)

---