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
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :'';
$load_id=isset($_REQUEST['load_id'])? $_REQUEST['load_id'] :0;

if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}else{
		// Search 
		$searchQuery = "%";
		if($searchValue != ''){
		$searchQuery ="%".$searchValue."%";
		}
		$shipper_udet=$Global->ShipperDetails($user_id);
		$shipper_id=$shipper_udet['id'];
		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount  FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND loads_trip.load_status =1 AND loads_trip.is_delete=0 AND loads_trip.denied_status=0 AND loads_trip.history_status=1    ");

		$sel->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecords = $records['allcount'];

		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount  FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND loads_trip.load_status =1 AND loads_trip.is_delete=0 AND loads_trip.denied_status=0  AND loads_trip.history_status=1    AND   (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery OR trucker.vehicle_number ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery) ");

		$sel->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id ,"searchQuery" => $searchQuery));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecordwithFilter = $records['allcount'];
		// Fetch records
		$dataa=$Global->db->prepare("SELECT loads.origin_address,loads.destination_address,loads_trip.denied_status,loads.load_id,loads.price,loads.origin as origin,loads.destination,loads_trip.trucker_id,loads_trip.trucker_status,loads_trip.load_status,trucker.user_id,trucker.phone,trucker.vehicle_number as dot,users.name,users.email,loads_trip.id as tripid,loads.id as loadpid,trucker.user_id as trucker_user_id,users.id as users_id FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads_trip.shipper_id=:shipper_id AND loads.id=:loadid AND loads_trip.load_status =1  AND loads_trip.is_delete=0   AND loads_trip.denied_status=0 AND loads_trip.history_status=1  AND (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);

		//AND  loads_trip.trucker_id NOT IN(SELECT trucker_id FROM loads_trip WHERE  load_id =:loadid AND trucker_status=0  OR  trucker_status=2   ) 

		$dataa->execute(array(":shipper_id"=>$shipper_id,"loadid"=>$load_id ,"searchQuery" => $searchQuery));
		$dataa_lists = $dataa->fetchAll(PDO::FETCH_ASSOC);

		// To find already confirmed trucker
		$e=array();
		if(!empty($dataa_lists)){
		foreach ($dataa_lists as $key => $nvalue){
		$lp_trucker_id=$nvalue['trucker_id'];
		$be_sel = $Global->db->prepare("SELECT trucker_id AS old_trucker,cancel_status AS old_cancel_status,is_delete AS old_is_delete,denied_status AS old_denied_status FROM loads_trip WHERE load_id=:load_id AND trucker_id=:trucker_id AND ((cancel_status=1 AND is_delete=1) OR (cancel_status=2 AND is_delete=1) OR (denied_status=1 AND is_delete=1))");
		$be_sel->execute(array("load_id"=>$load_id,"trucker_id"=>$lp_trucker_id));
		//$beaf_all = array_values($be_sel->fetchAll(PDO::FETCH_ASSOC));
		$beaf_all =$be_sel->fetchAll(PDO::FETCH_ASSOC);
		foreach ($beaf_all as $key => $value) {
				$nvalue["old_trucker"]=$value['old_trucker'];
				$nvalue["old_cancel_status"]=$value['old_cancel_status'];
				$nvalue["old_is_delete"]=$value['old_is_delete'];
				$nvalue["old_denied_status"]=$value['old_denied_status'];
		    }
		    $e[]=$nvalue;
		}
		}
			// Response
		$aVars = array(
				"draw" => intval($draw),
				"iTotalRecords" => $totalRecords,
				"iTotalDisplayRecords" => $totalRecordwithFilter,
				"data" => $e
			);

		}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}


echo json_encode($aVars);
?>
