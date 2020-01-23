<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
//$token = isset($_POST['token']) ? $_POST['token']: '';
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST['user_id']) ? $_POST['user_id']: '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	
	$load_id = isset($_POST['load_id']) ? $_POST['load_id']: '';
	$veh_id_no = isset($_POST['veh_id_no']) ? $_POST['veh_id_no']: '';

	$load_strip_datas=array(
		"veh_id_no"=>$veh_id_no
	);
	$load_conditions =array("load_id"=>$load_id);
	$load_update = $Global->UpdateData("loads_trip",$load_strip_datas,$load_conditions);

		

	$aVars=array("status"=>1 , "msg"=>"Vehicle Updated successfully");


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>