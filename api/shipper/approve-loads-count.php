<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :'';
$load_id=isset($_REQUEST['load_id'])? $_REQUEST['load_id'] : 0;

$shipper_udet=$Global->ShipperDetails($user_id);
$shipper_id=$shipper_udet['id'];
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount  FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND loads_trip.load_status =1 AND loads_trip.is_delete=0 AND loads_trip.denied_status=0 AND loads_trip.history_status=1    ");

$sel->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
//echo $totalRecords;exit;
if($totalRecords>10)
	$flagDataTable=true;
else
	$flagDataTable=false;

// Response
$response = array(
  "flagDataTable"=>$flagDataTable
);
echo json_encode($response);
?>
