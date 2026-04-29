<?php
/**
 * Meta Boxes: Editorial controls and Bookly mappings.
 */

function gary_add_meta_boxes() {
    add_meta_box( 'gary_editorial_mb', 'Editorial Options', 'gary_editorial_mb_html', 'page', 'side' );
}
add_action( 'add_meta_boxes', 'gary_add_meta_boxes' );

function gary_editorial_mb_html( $post ) {
    $sub = get_post_meta( $post->ID, '_gary_service_subtitle', true );
    $high = get_post_meta( $post->ID, '_gary_service_highlights', true );

    echo '<div style="margin-bottom:20px; border-bottom:1px solid #eee; padding-bottom:15px;">';
    echo '<p><strong>Subtitle:</strong><br /><input type="text" name="gary_service_subtitle" value="' . esc_attr( $sub ) . '" style="width:100%;" /></p>';
    echo '<p><strong>Highlights (One per line):</strong><br /><textarea name="gary_service_highlights" style="width:100%; height:80px;">' . esc_textarea( $high ) . '</textarea></p>';
    echo '</div>';

    $retail_override = get_post_meta( $post->ID, '_gary_retail_value_override', true );
    echo '<p><strong>Bundle Marketing Overrides:</strong></p>';
    echo '<div style="margin-bottom:15px;">';
    echo '<label style="font-size:11px; color:#666;">Manual Retail Value (£):</label><br />';
    echo '<input type="text" name="gary_retail_value_override" value="' . esc_attr( $retail_override ) . '" style="width:100%;" />';
    echo '</div>';

    $booking_sc = get_post_meta( $post->ID, '_gary_booking_shortcode', true );
    echo '<p><strong>Custom Booking Code:</strong></p>';
    echo '<textarea name="gary_booking_shortcode" style="width:100%; height:60px;">' . esc_textarea( $booking_sc ) . '</textarea>';
}

function gary_save_meta_boxes( $post_id ) {
    $fields = array(
        '_gary_bookly_id',
        '_gary_service_subtitle',
        '_gary_service_highlights',
        '_gary_retail_value_override',
        '_gary_booking_shortcode'
    );
    foreach ( $fields as $f ) {
        $key = ltrim( $f, '_' );
        if ( isset( $_POST[$key] ) ) {
            update_post_meta( $post_id, $f, $_POST[$key] );
        }
    }
}
add_action( 'save_post', 'gary_save_meta_boxes' );
