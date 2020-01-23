<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

	$TruckerDetails = $Global->TruckerDetails($user_id);
	$trucker_id     = $TruckerDetails["id"];

	$loadslist = $Global->db->prepare("SELECT id, veh_id_no,veh_unit FROM vehicle_details WHERE trucker_id=:trucker_id");
	$loadslist->execute(array("trucker_id"=>$trucker_id));
    $vehidata = $loadslist->fetchAll(PDO::FETCH_ASSOC);

    $data=array();
    if(!empty($vehidata)){
    	foreach ($vehidata as $key => $value) {
    			if(!empty($value['veh_unit'])){
    				$value['veh_number']=$value['veh_id_no']."(Unit No - ".$value['veh_unit'].")";
    			}else{
    				$value['veh_number']=$value['veh_id_no'];
    			}
    			$data[]=$value;
    	}
    }

    $aVars=array("status"=>1 , "data"=>$data);

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>

