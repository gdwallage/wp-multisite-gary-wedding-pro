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

$working_schedule = \Bookly\Lib\Entities\StaffScheduleItem::query( 'ssi' )
    ->whereIn( 'ssi.staff_id', $staff_ids )
    ->fetchArray();

$output['working_schedule'] = $working_schedule;

$appointments = \Bookly\Lib\Entities\Appointment::query()
    ->whereRaw( 'start_date >= %s', array( '2026-05-01 00:00:00' ) )
    ->whereRaw( 'start_date <= %s', array( '2026-05-31 23:59:59' ) )
    ->fetchArray();
$output['appointments_may'] = $appointments;

file_put_contents(dirname(__FILE__) . '/gw-diagnose-schedule.log', json_encode($output, JSON_PRETTY_PRINT));
echo "Done.";
