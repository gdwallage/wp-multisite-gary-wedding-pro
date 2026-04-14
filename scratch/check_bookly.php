<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

global $wpdb;
$tables = $wpdb->get_results("SHOW TABLES LIKE '%bookly%'", ARRAY_N);

echo "BOOKLY TABLES FOUND:\n";
foreach($tables as $table) {
    echo "- " . $table[0] . "\n";
    // Check for "form" or "appearance"
    if (strpos($table[0], 'forms') !== false || strpos($table[0], 'appearances') !== false) {
        $cols = $wpdb->get_results("SHOW COLUMNS FROM " . $table[0]);
        echo "  Columns: ";
        foreach($cols as $c) echo $c->Field . ", ";
        echo "\n";
        
        $data = $wpdb->get_results("SELECT * FROM " . $table[0] . " LIMIT 5");
        echo "  Sample Data:\n";
        print_r($data);
    }
}
