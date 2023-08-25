jQuery(document).ready(function ($) {

	/*
	* Confirmation
	*/
	$('#mx_customer_info_form').on('submit', function (e) {

		e.preventDefault();

		if ($('#customer_name').val() !== '' &&
			$('#customer_email').val() !== '' &&
			$('#customer_phone').val() !== '' &&
			$('#customer_address').val() !== '' &&
			$('#customer_city').val() !== '' &&
			$('#customer_country').val() !== '') {

			// show info
			$('#mx_show_customer_name').text($('#customer_name').val());
			$('#mx_show_customer_email').text($('#customer_email').val());
			$('#mx_show_customer_phone').text($('#customer_phone').val());
			$('#mx_show_customer_address').text($('#customer_address').val());
			$('#mx_show_customer_city').text($('#customer_city').val());
			$('#mx_show_customer_country').text($('#customer_country').val());
			$('#mx_show_customer_state').text($('#customer_state_province').val());

			// for IBAN
			$('#iban_customer_name').val($('#customer_name').val());
			$('#iban_customer_email').val($('#customer_email').val());

			$('.mx_stripe_wrap').show('slow');

		}

	});

	// Payments
	var stripe = Stripe(mxcpfc_js_obj.pk_stripe_key);

	// stripe card payment method
	if (document.getElementById('mx_card_button') !== null &&
		document.getElementById('card-element') !== null) {

		var elements = stripe.elements();

		var style = {
			base: {
				color: '#32325d',
				fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
				fontSmoothing: 'antialiased',
				fontSize: '16px',
				'::placeholder': {
					color: '#aab7c4'
				}
			},
			invalid: {
				color: '#fa755a',
				iconColor: '#fa755a'
			}
		};

		var cardElement = elements.create('card', { style: style });
		cardElement.mount('#card-element');

		// submit the payment
		// var cardholderName = document.getElementById('mx_cardholder_name');
		var cardButton = document.getElementById('mx_card_button');
		var clientSecret = cardButton.dataset.secret;

		// payment progress
		cardButton.addEventListener('click', function (ev) {

			// date
			var date_paid = $('#mx_date_paid').val();

			// currency
			var currency = $('#mx_currency').val();

			// offere			
			var offer_type = $('#mx_offer_type').val();

			// bill amount
			var bill_amount = $('#mx_bill_amount').val();

			// invoice
			var invoice_number = $('#invoice_number').val();

			// name
			var customer_name = $('#customer_name').val();

			// email
			var customer_email = $('#customer_email').val();

			// phone
			var customer_phone = $('#customer_phone').val();

			// address
			var customer_address = $('#customer_address').val();

			// city
			var customer_city = $('#customer_city').val();

			// country
			var customer_country = $('#customer_country').val();

			// 			
			stripe.handleCardPayment(
				clientSecret, cardElement, {
				payment_method_data: {
					billing_details: {
						name: customer_name,
						address: {
							city: customer_city
							// country: customer_country,

						},
						email: customer_email,
						phone: customer_phone
					}
				}
			}
			).then(function (result) {
				if (result.error) {
					// Display error.message in your UI.
					alert(result.error.message);
				} else {
					// The payment has succeeded. Display a success message.				
					$('.mx_stripe_wrap').hide();

					$('#mx_invoice_information').remove();

					$('#mx_payment_has_done').show('slow');

					// ajax
					var data = {

						'action': 'mxcpfc_set_meta_payment_confirm',
						'nonce': mxcpfc_js_obj.nonce,
						'customer_email': customer_email,
						'owner_email': mxcpfc_js_obj.owner_email,
						'customer_name': customer_name,
						'offer_type': offer_type,
						'bill_amount': bill_amount,
						'currency': currency,
						'date_paid': date_paid,
						'post_id': invoice_number,

					};

					jQuery.post(mxcpfc_js_obj.ajaxurl, data, function (response) {

						// console.log( response );

					});

				}

			});

		});

		// cancel
		$('#mx_change_information_button').on('click', function (e) {

			e.preventDefault();

			$('.mx_stripe_wrap').hide('slow');

		});

	} // endif

	// IBAN payment method	
	if (document.getElementById('iban-element') !== null) {

		// Create an instance of Elements.
		var elements2 = stripe.elements();

		// Custom styling can be passed to options when creating an Element.
		// (Note that this demo uses a wider set of styles than the guide below.)
		var style2 = {
			base: {
				color: '#32325d',
				fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
				fontSmoothing: 'antialiased',
				fontSize: '16px',
				'::placeholder': {
					color: '#aab7c4'
				},
				':-webkit-autofill': {
					color: '#32325d',
				},
			},
			invalid: {
				color: '#fa755a',
				iconColor: '#fa755a',
				':-webkit-autofill': {
					color: '#fa755a',
				},
			}
		};

		// Create an instance of the iban Element.
		var iban = elements2.create('iban', {
			style: style2,
			supportedCountries: ['SEPA']
		});

		// Add an instance of the iban Element into the `iban-element` <div>.
		iban.mount('#iban-element');

		var errorMessage = document.getElementById('error-message');
		var bankName = document.getElementById('bank-name');

		iban.on('change', function (event) {
			// Handle real-time validation errors from the iban Element.
			if (event.error) {
				errorMessage.textContent = event.error.message;
				errorMessage.classList.add('visible');
			} else {
				errorMessage.classList.remove('visible');
			}

			// Display bank name corresponding to IBAN, if available.
			if (event.bankName) {
				bankName.textContent = event.bankName;
				bankName.classList.add('visible');
			} else {
				bankName.classList.remove('visible');
			}
		});

		// Handle form submission.
		var form = document.getElementById('mx_payment_form');
		form.addEventListener('submit', function (event) {
			event.preventDefault();
			// showLoading();
			console.log('loading');

			var sourceData = {
				type: 'sepa_debit',
				currency: 'eur',
				owner: {
					name: document.querySelector('input[name="iban_customer_name"]').value,
					email: document.querySelector('input[name="iban_customer_email"]').value,
				},
				mandate: {
					// Automatically send a mandate notification email to your customer
					// once the source is charged.
					notification_method: 'email',
				}
			};

			// Call `stripe.createSource` with the iban Element and additional options.
			stripe.createSource(iban, sourceData).then(function (result) {
				if (result.error) {
					// Inform the customer that there was an error.
					errorMessage.textContent = result.error.message;
					errorMessage.classList.add('visible');
					// stopLoading();
					console.log(result.error);
				} else {
					// Send the Source to your server to create a charge.
					errorMessage.classList.remove('visible');
					// stripeSourceHandler(result.source);
					console.log('success - ' + result.error);
				}
			});

		});

	}

	// payment method switcher
	$('.mx_payment_method_switcher').find('div').each(function () {

		$(this).on('click', function () {

			$('.mx_payment_method_switcher').find('div').removeClass('mx_payment_method_active');

			$(this).addClass('mx_payment_method_active');

			// 
			if ($(this).hasClass('mx_payment_method_switch_card')) {

				$('.mx_card_payment_section').show();

				$('.mx_bank_transfer_section').hide();

			} else {

				$('.mx_bank_transfer_section').show();

				$('.mx_card_payment_section').hide();

			}

		});

	});

});