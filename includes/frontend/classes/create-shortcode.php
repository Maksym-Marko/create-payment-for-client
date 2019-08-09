<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXCPFC_Create_Shortcode
{

	/*
	* MXCPFC_Create_Shortcode
	*/
	public function __construct()
	{

	}

	/*
	* Registration of shortcodes
	*/
	public static function mxcpfc_register_shortcodes()
	{

		global $wpdb;

		$valid_request = false;

		$current_url = home_url( add_query_arg( null, null ));

		$payment_request = $_GET['payment_request'];

		// if valid request
		if( $payment_request !== NULL ) {

			$valid_request = true;

		}

		$valid_meta = false;

		// get meta data
		$row_meta = $wpdb->get_row( "SELECT * FROM $wpdb->postmeta WHERE meta_value = '" . $payment_request . "'" );

		// if valid valid meta
		if( $row_meta !== NULL ) {

			$valid_meta = true;

		}

		// customer information
		$_get_customer_info = get_post( $row_meta->post_id );

			// create info array
			$custom_info = array(
				'customer_name' => $_get_customer_info->post_title,
				'offer' 		=> get_post_meta( $row_meta->post_id, '_meta_offer_data', true ),
				'invoice_number' 		=> get_post_meta( $row_meta->post_id, '_meta_invoice_number_data', true ),
				'customer_email' 		=> get_post_meta( $row_meta->post_id, '_meta_customer_email_data', true ),
				'url_hash' 		=> get_post_meta( $row_meta->post_id, '_meta_url_hash_data', true ),
				'url_to_client' 		=> get_post_meta( $row_meta->post_id, '_meta_url_to_client_data', true ),
				'amount' 		=> get_post_meta( $row_meta->post_id, '_meta_of_amount_data', true ),
				'count_of_words' 		=> get_post_meta( $row_meta->post_id, '_meta_count_of_words_data', true ),
				'currency' 		=> get_post_meta( $row_meta->post_id, '_meta_currency_data', true ),
				'price_per_word' 		=> get_post_meta( $row_meta->post_id, '_meta_price_per_word_data', true ),
				
			);

		// options
		$options = array(

			// 'current_url' 		=> $current_url,
			'payment_request' 	=> $payment_request,
			'row_meta'			=> $row_meta,
			'valid_meta' 		=> $valid_meta,
			'valid_request' 	=> $valid_request,
			'custom_info' 		=> $custom_info,

		);

		add_shortcode( 'mxcpfc_payment_confirm_page', function() use ( $options ) {

			ob_start(); ?>

			<?php if( $options['valid_meta'] && $options['valid_request'] ) : ?>

				<!-- <h1>Valid request and meta</h1> -->

				<?php self::payment_window_template( $options ); ?>

			<?php else : ?>

				<h1>Invalid request</h1>

			<?php endif; ?>

			<?php return ob_get_clean();

		} );

	}

	public static function payment_window_template( $options ){ ?>

		<div class="mx-payment-window-wrap">

			<div class="mx-payment-box-wrap">
				
				<h3 class="mx-payment-customer-name">Welcome, <?php echo $options['custom_info']['customer_name']; ?>!</h3>

				<!--  -->
				<div class="mx-invoice-description">

					<p>We have sent you invoice <b>#<?php echo $options['custom_info']['invoice_number']; ?></b> with a balance of <b><?php echo $options['custom_info']['amount']; ?> <?php echo $options['custom_info']['currency']; ?></b>.</p>
        
        			<p>Due Date: <?php echo get_the_date('d F Y', $options['custom_info']['invoice_number']); ?></p>
					
				</div>

				<!--  -->
				 <table>
			        <thead>
			          <tr>
			            <th class="title_column">Offer</th>
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
			    	
					<p><b>Bill From:</b></p>

					<p>AVALON Linguistic</p>

					<p>Kemp House 160 City Road London EC1V 2NX United Kingdom</p>

					<p>44 203 195 3900</p>

			    </div>

			    <!-- Customer -->
			    <div class="mx-customer-info">
			    	
					<form action="" id="mx_customer_info_form">
						
						<ul>
							<li>
			                    <div>
			                    	<label for="customer_name">Full Name</label>
			                    	<div>
			                    		<input type="text" name="customer_name" value="<?php echo $options['custom_info']['customer_name']; ?>" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_email">Email Address</label>
			                    	<div>
			                    		<input type="email" name="customer_email" value="<?php echo $options['custom_info']['customer_email']; ?>" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_phone">Phone</label>
			                    	<div>
			                    		<input type="phone" name="customer_phone" value="" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_address">Address</label>
			                    	<div>
			                    		<input type="text" name="customer_address" value="" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_city">City</label>
			                    	<div>
			                    		<input type="text" name="customer_city" value="" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_country">Country</label>
			                    	<div>
			                    		<input type="text" name="customer_country" value="" required />
			                    	</div>
			                    </div>
		                	</li>
		                	<li>
			                    <div>
			                    	<label for="customer_state_province">State/Province</label>
			                    	<div>
			                    		<input type="text" name="customer_state_province" value="" required />
			                    	</div>
			                    </div>
		                	</li>

						</ul>

						<div class="mx-payment-button-wrap">
							<button type="submit">Process Payment of <span id="mx_pay_button_value"><?php echo $options['custom_info']['amount']; ?></span> <?php echo $options['custom_info']['currency']; ?></button>
						</div>

					</form>

			    </div>

			</div>
			
		</div>

	<?php }

		

}