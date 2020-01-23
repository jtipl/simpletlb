<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();


$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id=isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : '';
$uniqueid=isset($_REQUEST['uniqueid']) ? trim($_REQUEST['uniqueid']) : '';

if(empty($token)){
	$response=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	$TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];
	// Fetch records
	$loadslist = $Global->db->prepare("SELECT * FROM vehicle_details WHERE id =:uniqueid AND trucker_id=:trucker_id ");
	//AND loads.status=1
	$loadslist->execute(array("trucker_id"=>$trucker_id,"uniqueid"=>$uniqueid));
	
	$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);

	$aVars = array("status"=>1,"data" => $data);
	 
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>