<?php
include '../../../wp-load.php';

if ( !current_user_can('manage_options') ) {
    // Basic protection but maybe skip if we need to run it anonymously
}

header('Content-Type: text/plain');

$service_id = 23;
$date = '2026-05-16'; // A Saturday Gary picked

echo "ANALYZING SERVICE ID: $service_id FOR DATE: $date\n";
echo "----------------------------------------------\n";

$svc = \Bookly\Lib\Entities\Service::find($service_id);
if (!$svc) {
    die("Service 23 not found.");
}

echo "Service Title: " . $svc->getTitle() . "\n";
echo "Service Duration: " . $svc->getDuration() . " seconds (" . ($svc->getDuration()/3600) . " hours)\n";

$staff_ids = \Bookly\Lib\Entities\StaffService::query()
    ->select('staff_id')
    ->where('service_id', $service_id)
    ->fetchCol('staff_id');

echo "Staff providing this service: " . count($staff_ids) . "\n";
foreach($staff_ids as $sid) {
    $st = \Bookly\Lib\Entities\Staff::find($sid);
    echo " - Staff $sid: " . $st->getFullName() . "\n";
}

$userData = new \Bookly\Lib\UserBookingData( 'debug' );
$userData->resetChain();
$userData->chain->getItem(0)->setServiceId($service_id);
$userData->setDateFrom($date);

$finder = new \Bookly\Lib\Slots\Finder($userData);
$finder->prepare()->load();

$slots = $finder->getSlots();
echo "Slots found: " . count($slots) . "\n";

if (empty($slots)) {
    echo "NO SLOTS. Investigating reasons...\n";
    
    // Check holiday
    $holiday = \Bookly\Lib\Entities\Holiday::query()
        ->where('DATE(date)', $date)
        ->whereRaw('staff_id IS NULL OR staff_id IN (' . implode(',', $staff_ids) . ')', array())
        ->find();
    if ($holiday) echo "FOUND HOLIDAY on this date!\n";
    
    // Check schedule
    $day_index = (date('w', strtotime($date)) == 0) ? 7 : date('w', strtotime($date));
    foreach($staff_ids as $sid) {
        $item = \Bookly\Lib\Entities\StaffScheduleItem::query()
            ->where('staff_id', $sid)
            ->where('day_index', $day_index)
            ->findOne();
        if ($item) {
            echo "Staff $sid Schedule Index $day_index: " . ($item->getStartTime() ?: 'OFF') . " - " . ($item->getEndTime() ?: 'OFF') . "\n";
        } else {
            echo "Staff $sid has NO schedule item for index $day_index!\n";
        }
    }
} else {
    echo "Slots exist! Why did the Ajax return false?\n";
}
