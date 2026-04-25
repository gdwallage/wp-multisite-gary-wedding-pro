<?php
include '../../../wp-load.php';

header('Content-Type: text/plain');

$service_id = 23;
$service = \Bookly\Lib\Entities\Service::find( $service_id );

echo "Service ID: $service_id\n";
echo "Is Compound? " . ($service->isCompound() ? 'Yes' : 'No') . "\n";
echo "withSubServices? " . ($service->withSubServices() ? 'Yes' : 'No') . "\n";

$staff_ids = array();
if ( $service->withSubServices() ) {
    $sub_services = $service->getSubServices();
    echo "SubServices Count: " . count($sub_services) . "\n";
    $sub_service_ids = array();
    foreach ( $sub_services as $ss ) {
        echo "SubService: " . get_class($ss) . "\n";
        // Wait, $ss is actually an array or an entity?
        // Service::getSubServices returns Service[] (joined with SubService)
        // Let's dump $ss data
        print_r($ss->getFields());
        // $ss is a Service object returned from the query, BUT does it have getSubServiceId()?
        // Oh! In Service::getSubServices:
        // ->innerJoin( 'SubService', 'ss', 'ss.sub_service_id = s.id' )
        // ->where( 'ss.service_id', $this->getId() )
        // It returns Service entities! Not SubService entities!
        
        $sub_service_ids[] = $ss->getId();
    }
    
    if ( ! empty( $sub_service_ids ) ) {
        $staff_ids = \Bookly\Lib\Entities\StaffService::query()
            ->select('staff_id')
            ->whereIn('service_id', $sub_service_ids)
            ->fetchCol('staff_id');
    }
}

echo "Staff IDs: " . implode(',', $staff_ids) . "\n";

$date = '2026-05-09';
if (!empty($staff_ids)) {
    $appointments_count = \Bookly\Lib\Entities\Appointment::query()
        ->whereRaw( 'DATE(start_date) = %s', array( $date ) )
        ->whereIn( 'staff_id', $staff_ids )
        ->count();
    echo "Appointments on $date: $appointments_count\n";
} else {
    echo "NO STAFF IDS FOUND!\n";
}
