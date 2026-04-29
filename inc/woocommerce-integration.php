<?php
/**
 * WooCommerce Integration: Account portals and entitlement logic.
 */

// Add "My Bookings" to account menu
add_filter( 'woocommerce_account_menu_items', function( $items ) {
    $new_items = array();
    foreach ( $items as $key => $value ) {
        $new_items[$key] = $value;
        if ( 'dashboard' === $key ) {
            $new_items['my-bookings'] = 'My Bookings';
        }
    }
    return $new_items;
} );

// Render "My Bookings" content
add_action( 'woocommerce_account_my-bookings_endpoint', function() {
    global $wpdb;
    $user_id = get_current_user_id();

    echo '<h3>Your Entitlements & Credits</h3>';
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';
    $credits = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_credits WHERE customer_id = %d AND balance > 0", $user_id ) );

    if ( $credits ) {
        echo '<div class="gw-credits-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px; margin-bottom:40px;">';
        foreach ( $credits as $c ) {
            $s_data = gary_get_bookly_service_data( $c->service_id );
            if ( ! $s_data ) continue;
            ?>
            <div class="gw-credit-card" style="border: 2px solid var(--brand-gold-light); padding: 20px; background: #fff; position:relative;">
                <span style="font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; opacity:0.6;">Included Session</span>
                <h4 style="margin: 5px 0 15px;"><?php echo esc_html( gary_clean_service_name( $s_data['title'] ) ); ?></h4>
                <div style="font-size:1.2rem; font-weight:700; margin-bottom:15px;"><?php echo (int) $c->balance; ?> Remaining</div>
                <a href="/booking/?redeem=<?php echo $c->id; ?>" class="btn-black" style="display:block; background:#000; color:#fff; text-decoration:none; text-align:center; padding:10px; font-size:0.7rem; text-transform:uppercase; letter-spacing:1px; font-weight:700;">Book Using Credit</a>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p style="opacity:0.6; margin-bottom:40px;">You currently have no outstanding session credits to redeem.</p>';
    }

    echo '<h3>Upcoming Appointments</h3>';
    echo do_shortcode( '[bookly-appointments-list columns="date,time,service,staff,price,status,cancel"]' );
} );

/**
 * Entitlement Granting Logic
 */
add_action( 'woocommerce_order_status_completed', function( $order_id ) {
    global $wpdb;
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();
    if ( ! $user_id ) return;

    $table_inc = $wpdb->prefix . 'gw_bookly_service_inclusions';
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';

    foreach ( $order->get_items() as $item ) {
        $bookly_id = $item->get_meta( 'Service ID' ); 
        if ( ! $bookly_id ) continue;

        $inclusions = $wpdb->get_results( $wpdb->prepare( "SELECT included_id FROM $table_inc WHERE parent_id = %d", $bookly_id ) );
        foreach ( $inclusions as $inc ) {
            $wpdb->insert( $table_credits, array(
                'customer_id' => $user_id,
                'service_id'  => $inc->included_id,
                'balance'     => 1
            ) );
        }
    }
} );

/**
 * Price Interceptor (Zero out redemptions)
 */
add_filter( 'bookly_cart_info_prepare', function( $cart_info, $item ) {
    global $wpdb;
    $user_id = get_current_user_id();
    if ( ! $user_id ) return $cart_info;

    $service_id = $item->getServiceId();
    $table_credits = $wpdb->prefix . 'gw_bookly_customer_credits';
    $credit_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table_credits WHERE customer_id = %d AND service_id = %d AND balance > 0 LIMIT 1", $user_id, $service_id ) );

    if ( $credit_id ) {
        $cart_info->setPayNow( 0 );
        $cart_info->setTotal( 0 );
    }
    return $cart_info;
}, 10, 2 );
