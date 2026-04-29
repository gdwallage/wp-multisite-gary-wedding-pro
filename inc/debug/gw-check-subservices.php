<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

$service_id = 23;
global $wpdb;

echo "CHECKING TABLE: {$wpdb->prefix}bookly_sub_services\n";
$res = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}bookly_sub_services WHERE service_id = $service_id");

if (empty($res)) {
    echo "NO SUB-SERVICES FOUND in {$wpdb->prefix}bookly_sub_services.\n";
} else {
    foreach ($res as $row) {
        $sub_svc_id = $row->sub_service_id;
        $sub_svc = \Bookly\Lib\Entities\Service::find($sub_svc_id);
        echo "Sub-service ID: $sub_svc_id | Title: " . ($sub_svc ? $sub_svc->getTitle() : 'NOT FOUND') . "\n";
        
        $sids = $wpdb->get_col($wpdb->prepare("SELECT staff_id FROM {$wpdb->prefix}bookly_staff_services WHERE service_id = %d", $sub_svc_id));
        echo "   -> Staff assigned: " . implode(', ', $sids) . "\n";
    }
}
