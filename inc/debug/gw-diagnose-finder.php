<?php
include '../../../wp-load.php';

$date = '2026-05-16'; // A Saturday
$service_id = 23;

$userData = new \Bookly\Lib\UserBookingData( null );
$userData->fillData( array( 'time_from' => '00:00', 'time_to' => '24:00' ) );
$userData->resetChain();
$userData->chain->getItem(0)->setServiceId( $service_id );
$userData->setDateFrom( $date );
$userData->setDays( array( date( 'w', strtotime( $date ) ) + 1 ) );

$finder = new \Bookly\Lib\Slots\Finder( $userData );
$finder->prepare()->load();
$slots = $finder->getSlots();

$output = array(
    'date' => $date,
    'slots_count' => count($slots),
    'slots' => array(),
    'start_dp' => $finder->start_dp ? $finder->start_dp->value() : null,
    'end_dp' => $finder->end_dp ? $finder->end_dp->value() : null,
);

foreach ($slots as $group => $day_slots) {
    foreach ($day_slots as $slot) {
        $output['slots'][] = $slot->start()->value();
    }
}

file_put_contents(dirname(__FILE__) . '/gw-diagnose-finder.log', json_encode($output, JSON_PRETTY_PRINT));
echo "Done.";
