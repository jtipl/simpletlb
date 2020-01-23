<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$load_id = isset($_POST["load_id"]) ? $_POST["load_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}elseif(empty($load_id)){
		$aVars=array("status"=>0,"msg"=>"Load id is empty");
	}elseif(!empty($load_id) && !is_numeric($load_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid load id");
	}else{
		$viewcheck=$Global->db->prepare("SELECT load_id FROM viewlist WHERE load_id=:load_id AND user_id=:user_id");
		$viewcheck->execute(array("load_id"=>$load_id,"user_id"=>$user_id));
		$view_rowchk=$viewcheck->fetch(PDO::FETCH_ASSOC);	

		$check=$Global->db->prepare("SELECT id FROM trucker WHERE user_id=:user_id AND status=1");
		$check->execute(array("user_id"=>$user_id));
		$rowchk=$check->fetch(PDO::FETCH_ASSOC);

		if(empty($view_rowchk)){
		$view_data =  array(
			"load_id"=> $load_id,
			"created_by"=>$user_id,
			"user_id"=>$user_id,
			"trucker_id"=>$rowchk['id'],
			"status"=>1
		);
		$Global->InsertData("viewlist",$view_data);
			$aVars=array("status"=>1 , "msg"=>"Recently load added successfully");

		}else{
			$aVars=array("status"=>0 , "msg"=>"Already added recent loads for this user");
		}
	}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}

echo json_encode($aVars);
exit;