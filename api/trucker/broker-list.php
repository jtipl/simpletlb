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
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM favorite LEFT JOIN broker ON broker.id = favorite.broker_id LEFT JOIN shipper ON shipper.id = favorite.shipper_id INNER JOIN users ON users.id=broker.user_id OR users.id=shipper.user_id WHERE favorite.status=1 AND favorite.trucker_id=:trucker_id AND (favorite.favorite_type='broker_favorite' OR favorite.favorite_type='shipper_favorite')" );
	$sel->execute(array("trucker_id"=>$trucker_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecords = $records['allcount'];

	// Total number of record with filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM  favorite  LEFT JOIN broker ON broker.id = favorite.broker_id LEFT JOIN shipper ON shipper.id = favorite.shipper_id INNER JOIN users ON users.id=broker.user_id OR users.id=shipper.user_id WHERE (users.business_name ::text ILIKE :searchQuery OR  users.email ::text ILIKE :searchQuery  OR users.name ::text ILIKE :searchQuery  OR broker.phone ::text ILIKE :searchQuery) AND (favorite.favorite_type='broker_favorite' OR favorite.favorite_type='shipper_favorite') AND favorite.status=1 AND favorite.trucker_id=:trucker_id ");
	$sel->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecordwithFilter = $records['allcount'];

	// Fetch records
	$trucklists = $Global->db->prepare("SELECT users.business_name,users.email ,favorite.shipper_id,favorite.broker_id,favorite.trucker_id,favorite.id,favorite.favorite_type,favorite.status,users.name FROM  favorite LEFT JOIN broker ON broker.id = favorite.broker_id LEFT JOIN shipper ON shipper.id = favorite.shipper_id INNER JOIN users ON users.id=broker.user_id OR users.id=shipper.user_id  WHERE (users.business_name ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery OR broker.phone ::text ILIKE :searchQuery) AND  favorite.status=1 AND (favorite.favorite_type='broker_favorite' OR favorite.favorite_type='shipper_favorite') AND favorite.trucker_id=:trucker_id   ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);

	$trucklists->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$data = $trucklists->fetchAll(PDO::FETCH_ASSOC);

	// Response
	$response = array(
	  "draw" => intval($draw),
	  "iTotalRecords" => $totalRecords,
	  "iTotalDisplayRecords" => $totalRecordwithFilter,
	  "data" => $data,
	  "status"=>1
	);
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($response);
?>


