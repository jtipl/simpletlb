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

		if($_REQUEST["operation"] == "equipment"){
			$equipment_stmt = $Global->db->prepare( "SELECT * FROM truck_type WHERE status = '1' ORDER BY truck_name");
			$equipment_stmt->execute();
			$equipment_stmt_results = $equipment_stmt->fetchAll(PDO::FETCH_ASSOC);
			$aVars=array("status"=>1 , "data" =>$equipment_stmt_results);
		}else if($_REQUEST["operation"] == "equipment-list"){
			$equipment =  isset($_REQUEST['equipment']) ? $_REQUEST['equipment']: '';
			$equipment_stmt = $Global->db->prepare( "SELECT truck_name FROM truck_type WHERE id=:equipment AND status = '1' ORDER BY truck_name");
			$equipment_stmt->execute(array("equipment"=>$equipment));
			$equipment_stmt_results = $equipment_stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($equipment_stmt_results);
			$truck_name=$equipment_stmt_results["truck_name"];
			$aVars=array("status"=>1 , "truck_name" =>$truck_name);
		}

		else{
			$aVars=array("status"=>0 , "msg" =>"operation error");
		}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>