<?php
define('WP_USE_THEMES', false);
require('../../../wp-load.php');
global $wpdb;

header('Content-Type: text/plain');

echo "--- GARY'S SERVICES (Staff ID 4) ---\n";
$query = "
    SELECT svc.id, svc.title, svc.category_id, c.name as cat_name
    FROM {$wpdb->prefix}bookly_services svc
    JOIN {$wpdb->prefix}bookly_staff_services ss ON svc.id = ss.service_id
    LEFT JOIN {$wpdb->prefix}bookly_categories c ON svc.category_id = c.id
    WHERE ss.staff_id = 4
";
$services = $wpdb->get_results($query, ARRAY_A);
print_r($services);
