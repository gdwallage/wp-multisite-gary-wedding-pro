<?php
include '../../../wp-load.php';

header('Content-Type: text/plain');

$appointments = \Bookly\Lib\Entities\Appointment::query()
    ->whereRaw( 'start_date >= %s', array( '2026-05-01 00:00:00' ) )
    ->whereRaw( 'start_date <= %s', array( '2026-05-31 23:59:59' ) )
    ->fetchArray();

echo "Appointments in May 2026: " . count($appointments) . "\n";
foreach ($appointments as $a) {
    echo "ID: " . $a['id'] . " | Staff: " . $a['staff_id'] . " | Service: " . $a['service_id'] . " | Start: " . $a['start_date'] . "\n";
}

$holidays = \Bookly\Lib\Entities\Holiday::query()
    ->whereRaw( 'date >= %s', array( '2026-05-01' ) )
    ->whereRaw( 'date <= %s', array( '2026-05-31' ) )
    ->fetchArray();

echo "\nHolidays in May 2026: " . count($holidays) . "\n";
foreach ($holidays as $h) {
    echo "ID: " . $h['id'] . " | Staff: " . $h['staff_id'] . " | Date: " . $h['date'] . " | Repeat: " . $h['repeat_event'] . "\n";
}
