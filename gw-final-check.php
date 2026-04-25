<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

global $wpdb;

echo "SITE ID: " . get_current_blog_id() . "\n";
echo "TABLE PREFIX: " . $wpdb->prefix . "\n";

$staff = $wpdb->get_results("SELECT id, full_name FROM {$wpdb->prefix}bookly_staff WHERE visibility != 'archive'");
echo "\nSTAFF LIST:\n";
foreach ($staff as $s) {
    echo "ID: {$s->id} | Name: {$s->full_name}\n";
    $sched = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_staff_schedule_items WHERE staff_id = {$s->id} AND day_index = 6");
    foreach ($sched as $item) {
        echo "  - Sat: " . ($item->start_time ?: 'OFF') . " to " . ($item->end_time ?: 'OFF') . "\n";
    }
}

$service_id = 23;
$svc = \Bookly\Lib\Entities\Service::find($service_id);
echo "\nSERVICE 23:\n";
echo "Title: " . $svc->getTitle() . "\n";
echo "Type: " . $svc->getType() . "\n";

if ($svc->getType() == \Bookly\Lib\Entities\Service::TYPE_COMPOUND) {
    $sub_services = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_sub_services WHERE service_id = $service_id");
    foreach($sub_services as $row) {
        $ss_id = $row->sub_service_id;
        $ss = \Bookly\Lib\Entities\Service::find($ss_id);
        $linked_staff = $wpdb->get_col("SELECT staff_id FROM {$wpdb->prefix}bookly_staff_services WHERE service_id = $ss_id");
        echo "  - Sub-service $ss_id (" . ($ss ? $ss->getTitle() : '??') . "): Linked Staff: " . implode(', ', $linked_staff) . "\n";
    }
}
