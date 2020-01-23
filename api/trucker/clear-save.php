<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$id = isset($_POST["id"]) ? $_POST["id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	$data = array("status"=>0);
	$conditions =array("user_id"=>$user_id,"id"=>$id);
	$Global->UpdateData("search_save",$data,$conditions);
	$aVars=array("status"=>1 , "msg"=>"Save search cleared successfully");

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}

echo json_encode($aVars);
exit;