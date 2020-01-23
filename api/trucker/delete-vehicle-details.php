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
    $stmt = $Global->db->prepare("DELETE FROM vehicle_details WHERE id=:uniqueid ");
	$stmt->execute(array("uniqueid"=>$uniqueid));
	
	$aVars=array("status"=>1,"msg"=>"Vehicle details deleted successfully"); 
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>