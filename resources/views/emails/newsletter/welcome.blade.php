<x-mail::message>
# Welcome to the Inner Circle! 🚀

Hello,

We're absolutely thrilled to have you join the **{{ config('app.name') }}** community. You are now part of a select group of digital pioneers who receive our most exclusive insights, early access to new projects, and strategic industry updates.

To celebrate your arrival, we've prepared a special gift for your first venture with us:

<x-mail::panel>
## YOUR WELCOME GIFT
Use the code below at checkout to receive **15% OFF** your first order.
# **WELCOME15**
</x-mail::panel>

<x-mail::button :url="config('app.url')">
Explore Our Latest Projects
</x-mail::button>

We believe in quality over quantity. You'll only hear from us when we have something truly valuable to share—whether it's a breakthrough feature, an industry deep-dive, or a curated opportunity just for our subscribers.

Thank you for trusting us with your inbox. We promise to make it worth your while.

Stay inspired,<br>
The {{ config('app.name') }} Team

<x-mail::subcopy>
If you didn't mean to sign up for this newsletter, you can safely ignore this email or unsubscribe at any time.
</x-mail::subcopy>
</x-mail::message>
