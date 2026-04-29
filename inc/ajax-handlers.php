<?php
/**
 * AJAX Handlers: Background theme logic for forms and availability.
 */

/**
 * Inquiry Form Submission
 */
function gw_handle_enquiry() {
    $name    = sanitize_text_field( $_POST['user_name'] );
    $email   = sanitize_email( $_POST['user_email'] );
    $note    = sanitize_textarea_field( $_POST['user_note'] );
    $target  = sanitize_email( $_POST['target_email'] );
    $service = sanitize_text_field( $_POST['service_name'] );
    
    if ( ! $target ) $target = get_option( 'admin_email' );
    
    $subject = "Enquiry: $service - From $name";
    $body    = "Name: $name\nEmail: $email\nService: $service\n\nNote:\n$note";
    $headers = array( 'Content-Type: text/plain; charset=UTF-8', "From: Gary Wallage Wedding <$target>" );
    
    $sent = wp_mail( $target, $subject, $body, $headers );
    
    if ( $sent ) wp_send_json_success();
    else wp_send_json_error( 'Email failed to send.' );
}
add_action( 'wp_ajax_gw_submit_request', 'gw_handle_enquiry' );
add_action( 'wp_ajax_nopriv_gw_submit_request', 'gw_handle_enquiry' );

/**
 * NOTE: The gary_check_availability logic has been moved to the GW Bookly Addons plugin 
 * to ensure database consistency across multisite nodes.
 */
