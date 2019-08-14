=== Create Payment (Stripe Gateway) ===
Contributors: markomaksym
Tags: stripe, payment gateway, payment
Requires at least: 4.9
Tested up to: 5.2
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Stripe payment gateway. You can create a payment request for your client.

== Description ==

<p>
	You can create a payment request for your client. This plugin will create special link for.
</p>
<p>
	Your client will receive email with details of future payment and can pay for you by bill on your website.
</p>
<p>
	Note. You must have basic web development skills to use this plugin.
</p>
<p>
	Set up process:
	<ul>
		<li>
			Replace "sk_test_stripe_key" to your stripe secret key ( create-payment-for-client\includes\frontend\classes\create-shortcode.php )
		</li>
		<li>
			Replace "pk_test_stripe_key" to your stripe public key ( create-payment-for-client\includes\frontend\assets\js\script.js )
		</li>
		<li>
			Replace "company@gmail.com" to your company email ( create-payment-for-client\includes\frontend\assets\js\script.js )
		</li>
		<li>
			Replace "From: Company team <noreply@company.com>" to your company information ( create-payment-for-client\includes\admin\classes\send-payment-to-client.php )
		</li>		
		<li>
			Replace "From: Company team <noreply@company.com>" to your company information ( create-payment-for-client\includes\frontend\classes\ajax.php )
		</li>
		<li>
			Replace "Company Name" to your company name ( create-payment-for-client\includes\frontend\classes\ajax.php )
		</li>
		<li>
			Replace "hello@company.com" to your company email ( create-payment-for-client\includes\frontend\classes\ajax.php )
		</li>
		<li>
			Replace "+44 00 0000 0000" to your company phone ( create-payment-for-client\includes\frontend\classes\ajax.php )
		</li>
		<li>
			Replace "https://company.com" to your company website ( create-payment-for-client\includes\frontend\classes\ajax.php )
		</li>

		<li>
			Replace "Kemp House 111 City Road London United Kingdom" to your company address ( create-payment-for-client\includes\frontend\classes\create-shortcode.php )
		</li>
		<li>
			Replace "+44 00 0000 0000" to your company phone ( create-payment-for-client\includes\frontend\classes\create-shortcode.php )
		</li>
		<li>
			Replace "/wordpress/payment-confirmation/" to payment confirmation url on your website ( create-payment-for-client\includes\admin\classes\metaboxes.php )
		</li>
		<li>
			Plase "[mxcpfc_payment_confirm_page]" shortcode to your payment confirmation page
		</li>
		
	</ul>
</p>

<p>
	Testing data: https://stripe.com/docs/testing#regulatory-cards
</p>
<p>
	Stripe dashboard: https://dashboard.stripe.com/test/payments?status%5B%5D=successful
</p>

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

== Changelog ==

= 1.0 =
* Create Payment. Stripe Card