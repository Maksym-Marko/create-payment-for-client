<?php
if (!defined('ABSPATH')) exit;

// Verify nonce from the donation form before processing any submitted data.
if (
    !isset($_POST['mxcpfc_donation_nonce']) ||
    !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mxcpfc_donation_nonce'] ) ), 'mxcpfc_donation' )
) {
    echo 'Try one more time! ';
    echo '<a href="?">Back to donation page</a>';
    return;
}

if (
    !isset($_POST['customer_email']) ||
    !isset($_POST['mx_bill_amount']) ||
    !isset($_POST['mx_currency'])    ||
    !isset($_POST['invoice_number']) ||
    !isset($_POST['customer_name'])

) {
    echo 'Try one more time! ';
    echo '<a href="?">Back to donation page</a>';
    return;
}

// create info array
$mxcpfc_custom_info = array(
    'customer_name'         => sanitize_text_field( wp_unslash( $_POST['customer_name'] ) ),
    'offer'                 => 'Donate',
    'invoice_number'        => sanitize_text_field( wp_unslash( $_POST['invoice_number'] ) ),
    'customer_email'        => sanitize_email( wp_unslash( $_POST['customer_email'] ) ),
    'url_hash'              => 'hash',
    'amount'                => sanitize_text_field( wp_unslash( $_POST['mx_bill_amount'] ) ),
    'currency'              => sanitize_text_field( wp_unslash( $_POST['mx_currency'] ) )
);

// options
$mxcpfc_options = array(

    'custom_info'       => $mxcpfc_custom_info

);



?>

<?php mxcpfc_include_component('create_payment/welcome-template', $mxcpfc_options); ?>
