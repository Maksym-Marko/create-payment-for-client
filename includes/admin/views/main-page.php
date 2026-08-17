<?php if (!defined('ABSPATH')) exit; ?>
<div class="mx-main-page-text-wrap">

	<h1><?php echo esc_html__('Payment Settings', 'create-payment-stripe-gateway'); ?></h1>

	<form id="mxcpfc_update_payment_options">

		<input type="hidden" name="mxcpfc_nonce_request" id="mxcpfc_nonce_request" value="<?php echo esc_attr( wp_create_nonce('mxcpfc_nonce_request') ); ?>" />

		<!-- Publishable key -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Publishable key', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['publishable_key']); ?>" name="mxcpfc_publishable_key" id="mxcpfc_publishable_key" required />

			<p>
				<?php echo esc_html__('Stripe publishable key', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Secret key -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Secret key', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['secret_key']); ?>" name="mxcpfc_secret_key" id="mxcpfc_secret_key" required />

			<p>
				<?php echo esc_html__('Stripe Secret key', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Payment progress page -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Payment progress page on your website', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['process_page_url']); ?>" name="mxcpfc_process_page_url" id="mxcpfc_process_page_url" required />

			<p>
				<?php echo esc_html__('For example: "payment-confirmation" or "services/payment-process"', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Contact us page -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Contact us page', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr( isset($data['contact_us_page']) ? $data['contact_us_page'] : '' ); ?>" name="mxcpfc_contact_us_page" id="mxcpfc_contact_us_page" required />

			<p>
				<?php echo esc_html__('For example: "contacts" or "support/contact-us"', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Your company's email -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Your company\'s email', 'create-payment-stripe-gateway'); ?></h3>

			<input type="email" value="<?php echo esc_attr($data['company_email']); ?>" name="mxcpfc_company_email" id="mxcpfc_company_email" required />

			<p>
				<?php echo esc_html__('Enter a real email of your company', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Noreply email -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Noreply email', 'create-payment-stripe-gateway'); ?></h3>

			<input type="email" value="<?php echo esc_attr($data['noreply_email']); ?>" name="mxcpfc_noreply_email" placeholder="noreply@company.com" id="mxcpfc_noreply_email" required />

			<p>
				<?php echo esc_html__('This email name will appear when a user receives a report message.', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Department of company -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Department of company', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['department_company']); ?>" name="mxcpfc_department_company" id="mxcpfc_department_company" required />

			<p>
				<?php echo esc_html__('For example: "Trade department"', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Company Name -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Company Name', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['company_name']); ?>" name="mxcpfc_company_name" id="mxcpfc_company_name" required />

			<p>
				<?php echo esc_html__('For example: "Super Company"', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Company address -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Company address', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['company_address']); ?>" name="mxcpfc_company_address" id="mxcpfc_company_address" required />

			<p>
				<?php echo esc_html__('Type in your company\'s address.', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Company phone -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Company phone', 'create-payment-stripe-gateway'); ?></h3>

			<input type="text" value="<?php echo esc_attr($data['company_phone']); ?>" name="mxcpfc_company_phone" id="mxcpfc_company_phone" required />

			<p>
				<?php echo esc_html__('Type in your company\'s phone number.', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- message for a client -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Messages for the client', 'create-payment-stripe-gateway'); ?></h3>

			<textarea name="mxcpfc_message_for_client" id="mxcpfc_message_for_client">
<?php if ($data['message_for_client'] == '') : ?>
Your payment is successful.
Thank you a lot.
<?php else :
	echo esc_textarea($data['message_for_client']);
endif; ?>
			</textarea>
			<p>
				<?php echo esc_html__('Your customer will receive this message when he or she pays you', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- thank you message -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Thank you message', 'create-payment-stripe-gateway'); ?></h3>

			<textarea name="mxcpfc_thank_you_message" id="mxcpfc_thank_you_message">
<?php if ($data['thank_you_message'] == '') : ?>
Thank you!

You just provided payment for this invoice. We have emailed you a receipt with details.

Please feel free to contact us at any time for information on progress of your project.
<?php else :
	echo esc_textarea($data['thank_you_message']);
endif; ?>
			</textarea>
			<p>
				<?php echo esc_html__('This message your client will see when he of she pays you successful.', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Invalid request message -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Invalid request message', 'create-payment-stripe-gateway'); ?></h3>

			<textarea name="mxcpfc_invalid_request_message" id="mxcpfc_invalid_request_message">
<?php if ($data['invalid_request_message'] == '') : ?>
Invalid request
you don't have any payment requests currently

How to get a free quotation from us for approval?
With this website we try to make it a breeze to find a solution for your project.
Just get the best price, approve and pay, and put us to work for you swiftly.

We recommend you do this:

1) Go to the page Our Services and select according to your project needs.

2) Next, you can get an idea on the approximate cost on page Services Pricing.

3) Then you might send us a request for an individual quotation right from the form.

4) We will contact you quickly with detailed advice and our offer in order to discuss step by step your project and our potential cooperation.
<?php else :
	echo esc_textarea($data['invalid_request_message']);
endif; ?>
			</textarea>
			<p>
				<?php echo esc_html__('Your users will see this message when they enter via a broken link (URL) to the payment process page.', 'create-payment-stripe-gateway'); ?>
			</p>

		</div>

		<!-- Enable IBAN -->
		<div class="mx-block_wrap">

			<h3><?php echo esc_html__('Enable IBAN', 'create-payment-stripe-gateway'); ?></h3>

			<?php

			$mxcpfc_checked = '';

			if (isset($data['enable_iban']) && $data['enable_iban'] == 1) {

				$mxcpfc_checked = 'checked';
			}

			?>

			<input type="checkbox" name="mxcpfc_enable_iban" id="mxcpfc_enable_iban" <?php echo esc_attr($mxcpfc_checked); ?> />

			<label for="mxcpfc_enable_iban">Enable IBAN</label>

			<p>You have to enable SEPA Direct Debit payments in your Stripe account. <a href="https://stripe.com/docs/stripe-js/elements/iban" target="_blank">Learn more</a></p>

		</div>

		<!-- <div class="mx-clear-fix">
			<h3>Donation Settings</h3>
		</div> -->

		<!-- submit button -->
		<div class="mx-block_wrap" style="text-align: center;">

			<button type="submit" class="mx-save-payment-data" id="mx_save_payment_data">
				<?php echo esc_html__('Save Payment data', 'create-payment-stripe-gateway'); ?>
			</button>

		</div>

	</form>

	<div class="mx-shortcodes">
		<h3>Create a Payment for a Client</h3>
		<p>
			You should copy the shortcode below and paste this shortcode to a Payment progress page (that page slug you have entered above in special field).
		</p>
		<p style="font-weight: bold;">
			[mxcpfc_payment_confirm_page]
		</p>
	</div>

	<div class="mx-shortcodes">
		<h3>Donation page</h3>
		<p>
			Paste this shortcode to donation page.
		</p>
		<p style="font-weight: bold;">
			[mxcpfc_payment_donation_page]
		</p>
	</div>

</div>
