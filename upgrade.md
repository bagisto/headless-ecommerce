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

---

## 🛠️ Updated

### 6. Renamed `formatedPrice` to `formattedPrice` in `ConfigurableVariantPrices`

- **Reference:** [GitHub PR #428](https://github.com/bagisto/headless-ecommerce/pull/428/files#diff-751cf71213338a25269e065a9e0b9f2adf655f3c7b09c752775c6211f37f2c4fR30)

---