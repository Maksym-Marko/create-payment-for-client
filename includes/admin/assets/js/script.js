jQuery( document ).ready( function( $ ) {

	// payment invoice
	var invoice_number = $( '#meta_of_invoice_number_field' ).attr( 'data-invoice-number' );

	// invoice number
	if( $( '#meta_of_invoice_number_field' ).val() === '' ) {

		$( '#meta_of_invoice_number_field' ).val( invoice_number );

	} 

	// create URL
	if( $( '#meta_of_url_to_client_field' ).val() === '' ) {

		$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

	}

	/*
	* check input changes
	*/		
		// Price per word:  
		$( '#meta_price_per_word_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );

		// Price per word:  
		$( '#meta_count_of_words_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );

		// Price amount:  
		$( '#meta_of_amount_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );

		// Currency: 
		$( '#meta_currency_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );

		// Offer:  
		$( '#meta_of_offer_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );

		// email:  
		$( '#meta_of_customer_email_field' ).on( 'change', function() {

			$( '#meta_of_url_to_client_field' ).val( mx_create_url() );

			// cancel email sending
			$( '#mx_send_payment_to_client_text' ).text( 'If you want to send this payment request to current client, you have to save information. Press "Publish" or "Update" button.' );
			$( '#mx_send_payment_to_client' ).remove();

		} );		

	/*
	* send payment
	*/
	$( '#mx_send_payment_to_client' ).on( 'click', function( e ) {

		e.preventDefault();

		var nonce = $( '#meta_sent_to_client_nonce' ).val();

		var email = $( '#meta_of_customer_email_field' ).val();

		var message = mx_create_message();

		var post_id = $( '#mx_send_payment_to_client' ).attr( 'data-post-id' );

		var data = {

			'action': 'mxcpfc_send_payment_to_client',
			'nonce': nonce,
			'message': message,
			'email': email,
			'post_id': post_id

		};

		jQuery.post( ajaxurl, data, function( response ){

			if( response === 'sent' ) {

				$( '#mx_send_payment_to_client' ).text( 'Send Payment Again' );

				$( '#mx_send_payment_to_client_text' ).text( 'You have sent payment to the client. Do you want do it one more time?' );				

				alert( 'Payment Request has sent.' );

			}

		} );

	} );

	/**
	* payment method option update
	*/
	$( '#mxcpfc_update_payment_options' ).on( 'submit', function( e ) {

		e.preventDefault();

		var _serialize = $( this ).serializeArray();

		var _ajax = true;

		$.each( _serialize, function( key, value ) {

			var _value = value.value;

			if( _value === '' ) {

				_ajax = false;

				alert( 'You have to fill out all fields!' );

				return false;

			}

		} );

		var nonce = $( '#mxcpfc_nonce_request' ).val();

		var data = {
			action: 		'mxcpfc_options_update',
			nonce: 			nonce
		};

		$.each( _serialize, function( key, value ) {

			var _name = value.name;
			var _value = value.value;

			data[_name] = _value

			if( value.name === 'mxcpfc_enable_iban' ) {

				data['mxcpfc_enable_iban'] = 1;

			} else {

				data['mxcpfc_enable_iban'] = 0;

			}		

		} );

		console.log( data );

		if( _ajax ) {

			jQuery.post( ajaxurl, data, function( response ) {

				console.log( response );

				if( response === 'success' ) {

					alert( 'Options is updated!' );

					window.location.href = '#mxcpfc_update_payment_options';

				} else {

					alert( 'Something went wrong. Try to change some option.' );

				}

			} );

		}		

	} );
		
	/*
	* funcs
	*/
	// replace [url_to_client]
	function mx_create_message() {

		var editor_content = $( '#content' ).html();

		// replace [url_to_client]
		var _get_url = $( '#meta_of_url_to_client_field' ).val();

		var message =  editor_content.replace( /\[url_to_client\]/, _get_url );

		return message;

	}
	

	// create url
	function mx_create_url() {

		var url_hash = mx_create_url_hash();

		var payment_request = '?payment_request=' + invoice_number + url_hash;

		var _payment_url = $( '#meta_of_url_to_client_field' ).attr( 'data-url-path' );

		$( '#meta_of_url_hash_field' ).val( invoice_number + url_hash );

		return _payment_url + payment_request;

	}

	// create hash
	function mx_create_url_hash() {

		var _hash = Math.random().toString(36).slice(-8);

		return _hash;

	}

} );