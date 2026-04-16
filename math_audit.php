<?php
/**
 * Package Math Audit Script
 */
define('WP_USE_THEMES', false);
// Try to find wp-load.php by going up from theme
require_once('../../../wp-load.php');

global $wpdb;

$query = "
    SELECT 
        s.id as parent_id, 
        s.title as parent_title, 
        s.price as parent_price, 
        inc.id as inc_id, 
        inc.title as inc_title, 
        inc.price as inc_price
    FROM {$wpdb->prefix}bookly_services s
    JOIN {$wpdb->prefix}gw_bookly_service_inclusions i ON s.id = i.parent_id
    JOIN {$wpdb->prefix}bookly_services inc ON i.included_id = inc.id
    ORDER BY s.title ASC
";

$results = $wpdb->get_results($query);

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
