<?php

if(
    ! isset( $_POST['customer_email'] ) ||
    ! isset( $_POST['mx_bill_amount'] ) ||
    ! isset( $_POST['mx_currency'] )    ||
    ! isset( $_POST['invoice_number'] ) ||
    ! isset( $_POST['customer_name'] )  
    
) {
    echo 'Try one more time! ';
    echo '<a href="?">Back to donation page</a>';
    return;
} 

    // create info array
    $custom_info = array(
        'customer_name'         => $_POST['customer_name'],
        'offer'                 => 'Donate',
        'invoice_number'        => $_POST['invoice_number'],
        'customer_email'        => $_POST['customer_email'],
        'url_hash'              => 'hash',
        'amount'                => $_POST['mx_bill_amount'],
        'currency'              => $_POST['mx_currency']        
    );

// options
$options = array(

    'custom_info'       => $custom_info

); 

    

?>

<?php mxcpfc_include_component( 'create_payment/welcome-template', $options ); ?>