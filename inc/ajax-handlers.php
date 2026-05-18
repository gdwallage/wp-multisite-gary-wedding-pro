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

/**
 * REST API Bridge for public availability check to bypass Authentik SSO admin-ajax proxy blocks.
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'gw/v1', '/check-availability', array(
        'methods'             => 'GET',
        'callback'            => 'gw_rest_check_availability',
        'permission_callback' => '__return_true',
    ) );
} );

function gw_rest_check_availability( WP_REST_Request $request ) {
    if ( class_exists( 'GW_BooklyAddons\Lib\Ajax' ) ) {
        $_GET['service_id'] = $request->get_param( 'service_id' );
        $_GET['duration'] = $request->get_param( 'duration' );
        $_GET['check_date'] = $request->get_param( 'check_date' );
        
        GW_BooklyAddons\Lib\Ajax::checkAvailability();
        exit;
    }
    
    wp_send_json_error( array( 'message' => 'Availability service unavailable.' ) );
}
