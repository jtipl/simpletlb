<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: '';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
$user_id=isset($_SESSION['user_id'])? $_SESSION['user_id'] :'';
$load_id=isset($_REQUEST['load_id'])? $_REQUEST['load_id'] :0;
// Search 
$searchQuery = "%";
if($searchValue != ''){
    $searchQuery ="%".$searchValue."%";
}
$shipper_udet=$Global->ShipperDetails($user_id);
$shipper_id=$shipper_udet['id'];
// Total number of records without filtering

$sel = $Global->db->prepare("SELECT count(*) as allcount  FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND loads_trip.is_delete=0  AND loads_trip.cancel_status NOT IN(1,2) AND loads_trip.history_status=1   ");


$sel->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];

// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount  FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid  AND (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery OR trucker.vehicle_number ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery)  AND loads_trip.is_delete=0 AND loads_trip.history_status=1    AND loads_trip.cancel_status NOT IN(1,2) ");


$sel->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id ,"searchQuery" => $searchQuery));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records

$dataa=$Global->db->prepare("SELECT loads.origin_address,loads.destination_address,loads.price,loads_trip.denied_status,loads.origin as origin,loads.destination,loads_trip.trucker_id,loads_trip.trucker_status,loads_trip.load_status,trucker.user_id,trucker.phone,trucker.vehicle_number as dot,users.name,users.email,loads_trip.id as tripid,loads.id as loadpid,trucker.user_id as trucker_user_id,users.id as users_id FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND  (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery)  AND loads_trip.is_delete=0 AND loads_trip.history_status=1    AND loads_trip.cancel_status NOT IN(1,2) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);


$dataa->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id ,"searchQuery" => $searchQuery));
$dataa_lists = $dataa->fetchAll(PDO::FETCH_ASSOC);


// Response
$aVars = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "data" => $dataa_lists
);

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}


echo json_encode($aVars);
exit;
?>


