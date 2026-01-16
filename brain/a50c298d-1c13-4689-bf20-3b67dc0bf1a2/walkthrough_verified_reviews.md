# Verified Purchase Reviews Walkthrough

Product reviews are now more trustworthy as they are restricted to verified customers.

## Changes Implemented

### 1. Verification Logic
- **Purchase Check**: The `ReviewController@store` method now verifies if the logged-in user has an order containing the product they are trying to review.
- **Access Control**: Unauthorized attempts to review (guest users or logged-in users who haven't purchased) are blocked with a clear error message.

### 2. UI Enhancements
- **Dynamic Review Form**:
    - **Found Customers**: See the "Verified Purchase Review" form.
    - **Guests**: See a "Member Access Only" notice with a login link.
    - **Non-Purchasers**: See a "Verified Reviews Only" notice explaining they must buy the product first.
- **Trust Badges**:
    - Added a green **VERIFIED PURCHASE** badge next to all reviewer names on the product page and the general reviews list.
- **Reviewer Identity**: Reviewer names are now automatically pulled from their user account, ensuring authenticity.

## How to Test
1. **Logged Out**: Navigate to a product page. You should see a notice to log in.
2. **Logged In (No Purchase)**: Log in with an account that hasn't bought anything. You should see a notice that only purchasers can review.
3. **Purchased**: Place an order for a product. After ordering, return to that product's page. The review form will be unlocked.
