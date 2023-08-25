<?php

$options = $variable;

$data_payment_confirm = get_post_meta($options['custom_info']['invoice_number'], '_meta_bill_confirm', true);

?>

<div class="mx-payment-window-wrap">

	<div class="mx-payment-box-wrap">

		<div id="mx_payment_has_done" <?php echo $data_payment_confirm !== 'confirm' ? 'style="display: none;"' : ''; ?>>

			<?php

			$text = mxcpfc_get_payment_options()['thank_you_message'];

			$thanks_text = str_replace(array("\n", "\n\r"), '<br />', $text);

			echo $thanks_text;

			?>

		</div>

		<?php if ($data_payment_confirm !== 'confirm') : ?>

			<div id="mx_invoice_information">

				<h3 class="mx-payment-customer-name">Welcome, <?php echo $options['custom_info']['customer_name']; ?>!</h3>

				<!--  -->
				<div class="mx-invoice-description">

					<p>Invoice <b>#<?php echo $options['custom_info']['invoice_number']; ?></b></b>.</p>

					<p>Due Date: <?php echo get_the_date('d F Y', $options['custom_info']['invoice_number']); ?></p>

				</div>

				<!--  -->
				<table>
					<thead>
						<tr>
							<th class="title_column">Service</th>
							<th class="cost_column">Cost</th>
						</tr>
					</thead>

					<tbody>
						<th class="title_column"><?php echo $options['custom_info']['offer']; ?></th>
						<th class="cost_column"><?php echo $options['custom_info']['amount']; ?> <?php echo $options['custom_info']['currency']; ?></th>
					</tbody>

				</table>

				<!-- From -->
				<div class="mx-bill-from">

					<br><br>

					<p><b>Bill From:</b></p>

					<p><?php echo mxcpfc_get_payment_options()['company_name']; ?></p>

					<p><?php echo mxcpfc_get_payment_options()['company_address']; ?></p>

					<p><?php echo mxcpfc_get_payment_options()['company_phone']; ?></p>

				</div>

				<!-- Customer -->
				<div class="mx-customer-info">

					<form action="" id="mx_customer_info_form">

						<br>

						<p><b>Personal information:</b></p>

						<input type="hidden" id="invoice_number" name="invoice_number" value="<?php echo $options['custom_info']['invoice_number']; ?>" required />

						<input type="hidden" id="mx_offer_type" name="mx_offer_type" value="<?php echo $options['custom_info']['offer']; ?>" required />

						<input type="hidden" id="mx_bill_amount" name="mx_bill_amount" value="<?php echo $options['custom_info']['amount']; ?>" required />

						<input type="hidden" id="mx_currency" name="mx_currency" value="<?php echo $options['custom_info']['currency']; ?>" required />
						<input type="hidden" id="mx_date_paid" name="mx_date_paid" value="<?php echo get_the_date('d F Y', $options['custom_info']['invoice_number']); ?>" required />

						<ul>
							<li>
								<div>
									<label for="customer_name">Full Name</label>
									<div>
										<input type="text" id="customer_name" name="customer_name" value="<?php echo $options['custom_info']['customer_name']; ?>" readonly required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_email">Email Address</label>
									<div>
										<input type="email" id="customer_email" name="customer_email" value="<?php echo $options['custom_info']['customer_email']; ?>" readonly required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_phone">Phone</label>
									<div>
										<input type="text" id="customer_phone" name="customer_phone" value="" required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_address">Street Address</label>
									<div>
										<input type="text" id="customer_address" name="customer_address" value="" required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_city">City with ZIP / Postal code</label>
									<div>
										<input type="text" id="customer_city" name="customer_city" value="" required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_country">Country</label>
									<div>
										<input type="text" id="customer_country" name="customer_country" value="" required />
									</div>
								</div>
							</li>
							<li>
								<div>
									<label for="customer_state_province">State/Province</label>
									<div>
										<input type="text" id="customer_state_province" name="customer_state_province" value="" required />
									</div>
								</div>
							</li>

						</ul>

						<div class="mx-payment-button-wrap">

							<button type="submit">Confirm information<span id="mx_pay_button_value"></button>
						</div>

						<?php if (isset($_GET['donation'])) : ?>

							<a href="?">Change information</a><br><br>

						<?php endif; ?>

						<div class="mx-payment-contact-us-wrap">
							<a href="/<?php echo mxcpfc_get_payment_options()['contact_us_page'] ?>">Contact us</a>
						</div>

					</form>

				</div>

			</div>

		<?php endif; ?>

	</div>

	<!-- Stripe window -->
	<?php

	require_once MXCPFC_PLUGIN_ABS_PATH . 'includes/frontend/classes/stripe-php/init.php';

	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here: https://dashboard.stripe.com/account/apikeys
	\Stripe\Stripe::setApiKey(mxcpfc_get_payment_options()['secret_key']);

	$amount_for_stripe = intval($options['custom_info']['amount']) * 100;

	$intent = \Stripe\PaymentIntent::create([
		'amount' 		=> $amount_for_stripe,
		'currency' 		=> $options['custom_info']['currency'],
		'description' 	=> $options['custom_info']['offer'],
		'receipt_email' => $options['custom_info']['customer_email'],
	]); ?>


	<style>
		/**
			 * The CSS shown here will not be introduced in the Quickstart guide, but shows
			 * how you can use CSS to style your Element's container.
			 */
		.StripeElement {
			box-sizing: border-box;

			height: 40px;

			padding: 10px 12px;

			border: 1px solid transparent;
			border-radius: 4px;
			background-color: white;

			box-shadow: 0 1px 3px 0 #e6ebf1;
			-webkit-transition: box-shadow 150ms ease;
			transition: box-shadow 150ms ease;
		}

		.StripeElement--focus {
			box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
			border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
			background-color: #fefde5 !important;
		}
	</style>

	<div class="mx_stripe_wrap">

		<div class="mx_stripe_window">

			<h5>Please kindly, check your personal information and submit the payment.</h5>
			<ul>
				<li>Name: <span id="mx_show_customer_name"></span></li>
				<li>Email: <span id="mx_show_customer_email"></span></li>
				<li>Phone: <span id="mx_show_customer_phone"></span></li>
				<li>Street Address: <span id="mx_show_customer_address"></span></li>
				<li>Country: <span id="mx_show_customer_country"></span></li>
				<li>City: <span id="mx_show_customer_city"></span></li>
				<li>State/Province: <span id="mx_show_customer_state"></span></li>
			</ul>

			<!-- payment method switcher -->
			<h5 class="mx_pay_with_h">Pay with</h5>

			<div class="mx_payment_method_switcher">

				<div class="mx_payment_method_switch_card mx_payment_method_active">
					<svg class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--card-svg SVG--color-svg SVG--color--gray600-svg" style="width: 30px;height: 18px;" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
						<path d="M16 4H0v-.75C0 2.56.448 2 1 2h14c.552 0 1 .56 1 1.25zm0 2.5V13a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V6.5zM4 10a1 1 0 0 0 0 2h1a1 1 0 0 0 0-2z" fill-rule="evenodd"></path>
					</svg>

					<span>Card</span>
				</div>

				<?php if (mxcpfc_get_payment_options()['enable_iban'] == 1) : ?>

					<div class="mx_payment_method_switch_iban">
						<svg class="SVGInline-svg SVGInline--cleaned-svg SVG-svg Icon-svg Icon--bank-svg SVG--color-svg SVG--color--gray600-svg" style="width: 30px;height: 18px;" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.02 6A1 1 0 0 1 .5 4.134C.82 3.95 3.32 2.572 8 0c4.681 2.572 7.181 3.95 7.5 4.134A1 1 0 0 1 14.98 6zM11 14V7.5h3V14h1a1 1 0 0 1 1 1v1H0v-1a1 1 0 0 1 1-1h1V7.5h3V14h1.5V7.5h3V14z" fill-rule="evenodd"></path>
						</svg>

						<span>Bank Transfer</span>
					</div>

				<?php endif; ?>

			</div>


			<!-- Bank transfer... -->
			<div class="mx_bank_transfer_section">

				<form action="/" method="post" id="mx_payment_form">

					<input id="iban_customer_name" name="iban_customer_name" type="hidden" required />

					<input id="iban_customer_email" name="iban_customer_email" type="hidden" required />

					<div class="form-row">
						<label for="iban-element">
							IBAN
						</label>
						<div id="iban-element">
							<!-- A Stripe Element will be inserted here. -->
						</div>
					</div>
					<div id="bank-name"></div>

					<button id="mx_iban_button" data-secret="<?= $intent->client_secret ?>">Submit Payment</button>

					<!-- Used to display form errors. -->
					<div id="error-message" role="alert"></div>

					<!-- Display mandate acceptance text. -->
					<div id="mandate-acceptance">
						By providing your IBAN and confirming this payment, you are
						authorizing Rocketship Inc. and Stripe, our payment service
						provider, to send instructions to your bank to debit your account and
						your bank to debit your account in accordance with those instructions.
						You are entitled to a refund from your bank under the terms and
						conditions of your agreement with your bank. A refund must be claimed
						within 8 weeks starting from the date on which your account was debited.
					</div>

				</form>

			</div>
			<!-- ...Bank transfer -->

			<!-- card payment... -->
			<div class="mx_card_payment_section">

				<div class="form-row">
					<label for="card-element">
						Credit or debit card
					</label>

					<div id="card-element"></div>

					<!-- Used to display form errors. -->
					<div id="card-errors" role="alert"></div>
				</div>

				<button id="mx_card_button" data-secret="<?= $intent->client_secret ?>">
					Submit Payment for <?php echo $options['custom_info']['amount'] . ' ' . $options['custom_info']['currency']; ?>
				</button>

			</div>
			<!-- ...card payment -->
			<div class="mx_cancel">

				<?php if (isset($_GET['donation'])) : ?>

					<a href="?">Change information</a>

				<?php else : ?>

					<a href="#" id="mx_change_information_button">Change information</a>

				<?php endif; ?>

			</div>

		</div>

	</div>

</div>