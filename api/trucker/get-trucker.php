<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);
$trucker_id = isset($_POST['trucker_id']) ? $_POST['trucker_id']: '';


if($CheckvalidToken['status']==1){
	if(empty($trucker_id)){
		$aVars=array("status"=>0,"msg"=>"Trucker id is empty");
	}elseif(!empty($trucker_id) && !is_numeric($trucker_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid trucker id");
	}else{
		$trukerdets = $Global->db->prepare("SELECT to_char(trucker.vehicle_expiry_date, 'MM-DD-YYYY') as vehicle_expiry_date,trucker.vehicle_licence_no, trucker.vehicle_issuing_state, trucker.vehicle_length,users.name,users.email,users.business_name,trucker.phone,trucker.vehicle_number as dot,vehicle_weight FROM trucker INNER JOIN users ON users.id=trucker.user_id WHERE users.status=1 AND trucker.status=1 AND trucker.id=:trucker_id ");
		$trukerdets->execute(array("trucker_id"=>$trucker_id));
		$trukerpop =$trukerdets->fetch(PDO::FETCH_ASSOC);
		$aVars=array("status"=>1 , "data"=>$trukerpop);
	}
	


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
exit;
?>