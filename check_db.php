<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
global $wpdb;

$table = $wpdb->prefix . 'bookly_services';
$results = $wpdb->get_results("DESCRIBE $table");
foreach($results as $row) {
    echo $row->Field . " (" . $row->Type . ")\n";
}
?>
