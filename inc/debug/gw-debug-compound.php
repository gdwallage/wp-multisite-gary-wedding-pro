<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

$service_id = 23;
$svc = \Bookly\Lib\Entities\Service::find($service_id);

if ($svc->getType() == \Bookly\Lib\Entities\Service::TYPE_COMPOUND) {
    echo "Service is COMPOUND.\n";
    $sub_services = \BooklyCompoundServices\Lib\Entities\SubService::query()
        ->where('service_id', $service_id)
        ->find();
    echo "Sub-services found: " . count($sub_services) . "\n";
    foreach ($sub_services as $ss) {
        $sub_svc = \Bookly\Lib\Entities\Service::find($ss->getSubServiceId());
        echo " - ID: " . $sub_svc->getId() . " | Title: " . $sub_svc->getTitle() . "\n";
        
        $sids = \Bookly\Lib\Entities\StaffService::query()
            ->select('staff_id')
            ->where('service_id', $sub_svc->getId())
            ->fetchCol('staff_id');
        echo "   -> Staff: " . implode(', ', $sids) . "\n";
    }
} else {
    echo "Service is NOT compound. Type: " . $svc->getType() . "\n";
}
