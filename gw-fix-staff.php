<?php
include '../../../wp-load.php';
header('Content-Type: text/plain');

$staff_id = 4; // Gary Wallage
$target_services = array(18, 20, 21, 22, 23, 24);

echo "LINKING STAFF ID $staff_id TO SERVICES...\n";

foreach ( $target_services as $service_id ) {
    $ss = new \Bookly\Lib\Entities\StaffService();
    if ( !$ss->loadBy( array( 'staff_id' => $staff_id, 'service_id' => $service_id ) ) ) {
        $ss->setStaffId( $staff_id )
           ->setServiceId( $service_id )
           ->setPrice( 0 )
           ->setCapacityMin( 1 )
           ->setCapacityMax( 1 )
           ->save();
        echo "Successfully linked Service $service_id to Staff $staff_id\n";
    } else {
        echo "Service $service_id is already linked to Staff $staff_id\n";
    }
}

echo "DONE.\n";
