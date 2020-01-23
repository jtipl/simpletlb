<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$user_id         = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){
	$TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];
    //echo $trucker_id;exit;

	$trukerdets = $Global->db->prepare("SELECT veh_id_no FROM vehicle_details WHERE trucker_id=:trucker_id ");
	$trukerdets->execute(array("trucker_id"=>$trucker_id));
	$trukerpop =$trukerdets->fetch(PDO::FETCH_ASSOC);
	$aVars=array("status"=>1 , "data"=>$trukerpop);


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
exit;
?>