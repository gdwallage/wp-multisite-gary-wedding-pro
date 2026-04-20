<?php
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');
global $wpdb;

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d', strtotime('next Saturday'));
$day_index_standard = date('w', strtotime($date)); 
$day_index_iso = ($day_index_standard == 0) ? 7 : $day_index_standard;

echo "Checking Date: $date (Std: $day_index_standard, ISO: $day_index_iso)\n";

$s_table = $wpdb->prefix . 'bookly_staff_schedule';
$staff_id = 4;
$results = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM $s_table WHERE staff_id = %d AND (day_index = %d OR day_index = %d)",
    $staff_id, $day_index_standard, $day_index_iso
));

echo "Schedule rows found: " . count($results) . "\n";
foreach($results as $r) {
    echo "- Day Index: {$r->day_index} | {$r->start_time} - {$r->end_time}\n";
}

$app_table = $wpdb->prefix . 'bookly_appointments';
$apps = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM $app_table WHERE staff_id = %d AND DATE(start_date) = %s",
    $staff_id, $date
));
echo "Appointments found: " . count($apps) . "\n";
foreach($apps as $a) {
    echo "- App: {$a->start_date} to {$a->end_date}\n";
}
