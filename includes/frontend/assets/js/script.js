jQuery( document ).ready( function( $ ){

	/*
	* Confirmation
	*/
	$( '#mx_customer_info_form' ).on( 'submit', function( e ) {

		e.preventDefault();

		console.log( 'Confirmation' );

	} );

} );