<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
//print_r($inputJSON);exit;
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

	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}else{

		//Session set
	$check=$Global->db->prepare("SELECT id FROM trucker WHERE user_id=:user_id AND status=1");
	$check->execute(array("user_id"=>$user_id));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	$trucker_id=$rowchk['id'];
	// Search 
	$searchQuery = "%";
	if($searchValue != ''){
		$searchQuery ="%".$searchValue."%";
	}

	// Total number of records without filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id LEFT JOIN broker ON broker.id=loads_trip.broker_id INNER JOIN users ON users.id=loads.user_id LEFT JOIN shipper On shipper.user_id=users.id  WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0 AND loads_trip.is_delete=0");//AND loads.status=2
	$sel->execute(array("trucker_id"=>$trucker_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecords = $records['allcount'];

	// Total number of record with filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id LEFT JOIN broker ON broker.id=loads_trip.broker_id INNER JOIN users ON users.id=loads.user_id LEFT JOIN shipper On shipper.user_id=users.id  WHERE (loads.origin ::text ILIKE :searchQuery) AND loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4  AND loads_trip.is_delete=0");
	$sel->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecordwithFilter = $records['allcount'];

	// Fetch records
	$trucklists = $Global->db->prepare("SELECT concat(shipper.phone, broker.phone) AS phone,loads_trip.shipper_id,loads_trip.veh_id_no,loads_trip.trucker_id,loads_trip.broker_id,users.business_name,loads_trip.id as tripid,loads.price,loads.suggest_price,loads.weight,loads.length,loads.load_id,loads.origin as origin,loads.destination,loads.id,loads.status as loadstatus,loads_trip.load_status as tripstatus,to_char(loads.pickup_date,'MM-DD-YYYY') as pickup_date,to_char(loads.delivery_date,'MM-DD-YYYY') as delivery_date   FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id LEFT JOIN broker ON broker.id=loads_trip.broker_id INNER JOIN users ON users.id=loads.user_id LEFT JOIN shipper On shipper.user_id=users.id WHERE (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.load_id ::text ILIKE :searchQuery OR loads.weight ::text ILIKE :searchQuery OR loads.length ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery) AND loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4  AND loads_trip.is_delete=0  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
	//AND loads.status=1
	$trucklists->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$data = $trucklists->fetchAll(PDO::FETCH_ASSOC);
	$newarr=array();
	if(!empty($data)){
	foreach ($data as $key => $value) {

		if($value['broker_id'] != 0  && $value['broker_id'] != null && $value['broker_id'] != ''){

			$sel = $Global->db->prepare("SELECT status as favorite_status FROM favorite WHERE broker_id=:broker_id AND trucker_id=:trucker_id AND favorite_type='broker_favorite'  ");
			$sel->execute(array("trucker_id"=>$value['trucker_id'],"broker_id"=>$value['broker_id']));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$fav_status=$records['favorite_status'];
			if ($fav_status == '' && $fav_status ==null && $fav_status == 0) {

				$favorite_status=0;
			}else{
				$favorite_status=$fav_status;
			}
			$value['favorite_status']=$favorite_status;
			$newarr[]=$value;

		}else if($value['shipper_id'] != 0  && $value['shipper_id'] != null && $value['shipper_id'] != ''){

			$sel = $Global->db->prepare("SELECT status as favorite_status FROM favorite WHERE shipper_id=:shipper_id AND trucker_id=:trucker_id AND favorite_type='shipper_favorite'  ");
			$sel->execute(array("trucker_id"=>$value['trucker_id'],"shipper_id"=>$value['shipper_id']));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$fav_status=$records['favorite_status'];
			if ($fav_status == '' && $fav_status ==null && $fav_status == 0) {

				$favorite_status=0;
			}else{
				$favorite_status=$fav_status;
			}
			$value['favorite_status']=$favorite_status;
			$newarr[]=$value;

		}
	  }
	}

		// Response
		$aVars = array(
		  "draw" => intval($draw),
		  "iTotalRecords" => $totalRecords,
		  "iTotalDisplayRecords" => $totalRecordwithFilter,
		  "data" => $newarr,
		  "status"=>1
		);

	}
	
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}


echo json_encode($aVars);
?>


