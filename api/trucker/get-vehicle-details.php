<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id=isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : '';
if(empty($token)){
	$response=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	
	$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
	$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
	$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
	$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
	$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: '';
	$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
	$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
	


	//echo $user_id;exit;

	$uniqueid=isset($_REQUEST['uniqueid']) ? trim($_REQUEST['uniqueid']) : '';
	$veh_id_no=isset($_REQUEST['veh_id_no']) ? trim($_REQUEST['veh_id_no']) : '';
	$veh_make=isset($_REQUEST['veh_make']) ? trim($_REQUEST['veh_make']) : '';
	$veh_model=isset($_REQUEST['veh_model']) ? trim($_REQUEST['veh_model']) : '';
	$veh_type=isset($_REQUEST['veh_type']) ? trim($_REQUEST['veh_type']) : '';
	$veh_weight=isset($_REQUEST['veh_weight']) ? trim($_REQUEST['veh_weight']) : '';
	$veh_length=isset($_REQUEST['veh_length']) ? trim($_REQUEST['veh_length']) : '';
	$veh_height=isset($_REQUEST['veh_height']) ? trim($_REQUEST['veh_height']) : '';
	
	$TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];
    //echo $trucker_id;exit;

    $searchQuery = "%";
	if($searchValue != ''){
		$searchQuery ="%".$searchValue."%";
	}
	// Total number of records without filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM vehicle_details WHERE trucker_id=:trucker_id ");
	$sel->execute(array("trucker_id"=>$trucker_id));
	$totalRecords =$sel->fetch(PDO::FETCH_ASSOC);

	// Total number of record with filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM vehicle_details v WHERE (v.veh_id_no ::text ILIKE :searchQuery OR v.veh_make ::text ILIKE :searchQuery OR v.veh_model ::text ILIKE :searchQuery OR v.veh_make ::text ILIKE :searchQuery OR v.veh_type ::text ILIKE :searchQuery OR v.veh_weight ::text ILIKE :searchQuery OR v.veh_length ::text ILIKE :searchQuery OR v.veh_height ::text ILIKE :searchQuery) AND trucker_id=:trucker_id  ");
	$sel->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecordwithFilter = $records['allcount'];
   
	// Fetch records
	$loadslist = $Global->db->prepare("SELECT * FROM vehicle_details v WHERE (v.veh_id_no ::text ILIKE :searchQuery OR v.veh_make ::text ILIKE :searchQuery OR v.veh_model ::text ILIKE :searchQuery OR v.veh_make ::text ILIKE :searchQuery OR v.veh_type ::text ILIKE :searchQuery OR v.veh_weight ::text ILIKE :searchQuery OR v.veh_length ::text ILIKE :searchQuery OR v.veh_height ::text ILIKE :searchQuery) AND trucker_id=:trucker_id ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
	//AND loads.status=1
	$loadslist->execute(array("searchQuery" => $searchQuery,"trucker_id"=>$trucker_id));
	$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);

		// Response
	$response = array(
	  "draw" => intval($draw),
	  "iTotalRecords" => $totalRecords,
	  "iTotalDisplayRecords" => $totalRecordwithFilter,
	  "aaData" => $data
	);

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}



echo json_encode($response);
exit;
?>