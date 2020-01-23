<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :'';

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif(!empty($user_id) && !is_numeric($user_id)){
	$aVars=array("status"=>0,"msg"=>"Invalid user id");
}elseif($CheckvalidToken['status']==1){
	
	$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
	$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
	$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
	$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
	$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: '';
	$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
	$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
	
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
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM viewlist INNER JOIN loads ON loads.id = viewlist.load_id INNER JOIN truck_type as truck ON truck.id=loads.truck_id INNER JOIN users ON users.id=loads.user_id   LEFT JOIN wish_list ON wish_list.load_id =loads.id WHERE viewlist.user_id=:user_id AND viewlist.status=1");
	$sel->execute(array("user_id"=>$user_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecords = $records['allcount'];

	// Total number of record with filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM  viewlist INNER JOIN loads ON loads.id = viewlist.load_id INNER JOIN truck_type as truck ON truck.id=loads.truck_id INNER JOIN users ON users.id=loads.user_id    LEFT JOIN wish_list ON wish_list.load_id =loads.id WHERE (loads.load_id ::text ILIKE :searchQuery OR  loads.origin ::text ILIKE :searchQuery  OR loads.destination ::text ILIKE :searchQuery  OR loads.pickup_date ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery  OR loads.delivery_date ::text ILIKE :searchQuery OR truck.truck_name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery) AND viewlist.status=1 AND viewlist.user_id=:user_id AND viewlist.status=1 ");
	$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecordwithFilter = $records['allcount'];

	// Fetch records
	$trucklists = $Global->db->prepare("SELECT loads.approve_status, loads.status,wish_list.wish_list_status as wish_status,users.business_name as broker,loads.load_id,loads.origin,loads.id,loads.destination,to_char(loads.pickup_date,'MM-DD-YYYY') as pickup_date,to_char(loads.delivery_date,'MM-DD-YYYY') as delivery_date,loads.price,truck.truck_name FROM   viewlist INNER JOIN loads ON loads.id = viewlist.load_id INNER JOIN truck_type as truck ON truck.id=loads.truck_id INNER JOIN users ON users.id=loads.user_id LEFT JOIN wish_list ON wish_list.load_id =loads.id WHERE (loads.load_id ::text ILIKE :searchQuery OR  loads.origin ::text ILIKE :searchQuery  OR loads.destination ::text ILIKE :searchQuery  OR loads.pickup_date ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery  OR loads.delivery_date::text ILIKE :searchQuery OR truck.truck_name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery) AND viewlist.user_id=:user_id AND viewlist.status=1   ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);



	$trucklists->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
	$data = $trucklists->fetchAll(PDO::FETCH_ASSOC);

	// Response
	$response = array(
	  "draw" => intval($draw),
	  "iTotalRecords" => $totalRecords,
	  "iTotalDisplayRecords" => $totalRecordwithFilter,
	  "data" => $data,
	  "recent_loads" => 1,
	  "status"=>1
	);
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($response);
?>


