<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

$staff_id = 4;
$day_index = 6; // Saturday

global $wpdb;
$res = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}bookly_staff_schedule_items WHERE staff_id = $staff_id AND day_index = $day_index");

echo "GARY'S SATURDAY SCHEDULE:\n";
if ($res) {
    echo "Start: " . ($res->start_time ?: 'OFF') . " | End: " . ($res->end_time ?: 'OFF') . "\n";
    
    // Check breaks
    $breaks = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_staff_schedule_items WHERE staff_id = $staff_id AND day_index = $day_index AND start_time IS NOT NULL AND end_time IS NOT NULL");
    // Wait, breaks are usually in another table in some versions or same table with different type.
} else {
    echo "NO SCHEDULE FOUND for index 6.\n";
}

// Check Service 23 Total Duration
$service_id = 23;
$sub_services = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_sub_services WHERE service_id = $service_id");
$total_duration = 0;
foreach ($sub_services as $ss) {
    $sub_svc = \Bookly\Lib\Entities\Service::find($ss->sub_service_id);
    if ($sub_svc) {
        $total_duration += $sub_svc->getDuration();
        echo "Sub-service " . $sub_svc->getId() . ": " . $sub_svc->getDuration() . "s\n";
    }
}
// Add spare time
$spare = $wpdb->get_var("SELECT SUM(duration) FROM {$wpdb->prefix}bookly_sub_services WHERE service_id = $service_id AND type = 1"); // 1 = spare time usually
$total_duration += $spare;

echo "TOTAL COMPOUND DURATION: " . $total_duration . " seconds (" . ($total_duration/3600) . " hours)\n";
