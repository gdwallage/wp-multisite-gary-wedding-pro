<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

$services = \Bookly\Lib\Entities\Service::query()->find();
echo "ALL SERVICES:\n";
foreach($services as $s) {
    echo "ID: " . $s->getId() . " | Title: " . $s->getTitle() . " | Duration: " . $s->getDuration() . "\n";
    
    $sids = \Bookly\Lib\Entities\StaffService::query()
        ->select('staff_id')
        ->where('service_id', $s->getId())
        ->fetchCol('staff_id');
    echo "  -> Linked Staff IDs: " . implode(', ', $sids) . "\n";
}

echo "\nALL STAFF:\n";
$staff = \Bookly\Lib\Entities\Staff::query()->find();
foreach($staff as $st) {
    echo "ID: " . $st->getId() . " | Name: " . $st->getFullName() . " | Visibility: " . $st->getVisibility() . "\n";
}
