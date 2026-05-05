<?php
include '../../../wp-load.php';

$output = array();
$staff_ids = \Bookly\Lib\Entities\StaffService::query()
    ->select('staff_id')
    ->whereIn('service_id', array(23, 24, 25)) // compound and sub services roughly
    ->fetchCol('staff_id');

if (empty($staff_ids)) {
    $staff_ids = array(1); // fallback
}

$appointments = \Bookly\Lib\Entities\Appointment::query()
    ->whereRaw( 'start_date >= %s', array( '2026-05-01 00:00:00' ) )
    ->whereRaw( 'start_date <= %s', array( '2026-05-31 23:59:59' ) )
    ->fetchArray();

$output['appointments_may_2026'] = count($appointments);
$output['appointment_dates'] = array();
foreach($appointments as $a) {
    $output['appointment_dates'][] = $a['start_date'];
}

$holidays = \Bookly\Lib\Entities\Holiday::query()
    ->whereRaw( 'DATE_FORMAT(date, "%Y-%m") = "2026-05" OR repeat_event = 1' )
    ->fetchArray();

$output['holidays_may_2026'] = count($holidays);
$output['holiday_dates'] = array();
foreach($holidays as $h) {
    if (strpos($h['date'], '2026-05') !== false || $h['repeat_event'] == 1) {
        $output['holiday_dates'][] = $h['date'];
    }
}

file_put_contents(dirname(__FILE__) . '/gw-diagnose.log', json_encode($output, JSON_PRETTY_PRINT));
echo "Done.";
