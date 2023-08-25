=== Create a payment request. Donation form (Stripe) ===
Contributors: markomaksym
Tags: stripe, payment gateway, payment, 3d secure, 3ds, Stripe SCA, donation
Requires at least: 4.9
Tested up to: 6.3
Stable tag: 4.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stripe payment gateway. You can create a payment request for your client. There is functionality to create a Donation page.

== Description ==

<p>
	You can create a payment request for your client. This plugin will create special link for the client.
</p>
<p>
	Your customer will receive an email with the details of the upcoming payment and will be able to pay you via an invoice on your website.
</p>

<h3><b>Donation page</b></h3>
<p>
	You can create a donation page to allow your users to make donations. You just should fill in the information on the Settings page and place the shortcode to the particular page.
</p>

<h3><b>Shortcodes:</b></h3>
<p>
	<b>Create a payment request</b> - [mxcpfc_payment_confirm_page] <br>
	<b>Donation page</b> - [mxcpfc_payment_donation_page]
</p>

<p>
	Testing data: https://stripe.com/docs/payments/3d-secure#regulatory-cards
</p>
<p>
	Stripe dashboard: https://dashboard.stripe.com/test/payments?status%5B%5D=successful
</p>

<p>
	<b>How does it work?</b>
</p>

<iframe width="600" height="320" src="https://www.youtube.com/embed/vAzz4AWMM50" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Create Payment (Stripe Gateway)'
3. Activate the plugin from your Plugins page.

= From WordPress.org =

1. Download 'Create Payment (Stripe Gateway)'.
2. Upload the 'Create Payment (Stripe Gateway)' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate 'Create Payment (Stripe Gateway)' from your Plugins page.

== Screenshots ==

1. Create Payment Dashboard
2. Payment confirmation page
3. Stripe Card element
4. Admin dashboard

== Changelog ==

= 4.1 =
* Tested up to WP 6.3. Fixed bugs. Changed stripe-php package.

= 4.0 =
* You can create a donation page to allow your users to make donations.

= 3.0 =
* IBAN payment method

= 2.0 =
* Admin panel for payment settings

= 1.0 =
* Create Payment. Stripe Card