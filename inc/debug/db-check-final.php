<?php
define('WP_USE_THEMES', false);
require('../../../wp-load.php');
global $wpdb;

header('Content-Type: text/plain');

$date = '2026-05-10'; // A Sunday in the future
$apps = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_2_bookly_appointments WHERE DATE(start_date) = %s", $date));
echo "Appointments on $date:\n";
print_r($apps);

$staff = $wpdb->get_results("SELECT id, full_name FROM wp_2_bookly_staff");
echo "\nStaff on site 2:\n";
print_r($staff);
