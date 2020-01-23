<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){
	// BrokerDetails starts
	$BrokerDetails = $Global->BrokerDetails($user_id);
	$broker_id = $BrokerDetails["id"];
	
	$TruckerDetails = $Global->TruckerDetails($user_id);
	$trucker_id = $TruckerDetails["id"];

	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);

	// AND pickup_date >= CURRENT_DATE

	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);

	$awating_load_sel = $Global->db->prepare("SELECT count(*) as allcount 
		FROM loads_trip 
		INNER JOIN loads ON loads.id = loads_trip.load_id 
		WHERE loads_trip.trucker_id=:trucker_id 
		AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 AND loads_trip.denied_status!=1 AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0" );
	$awating_load_sel->execute(array("trucker_id"=>$trucker_id));
	$awating_load_records =$awating_load_sel->fetch(PDO::FETCH_ASSOC);
	$awaitingTotalrecords = $awating_load_records['allcount'];

	


	$aVars = array('status' => 1 , "awaitingTotalrecords" => $awaitingTotalrecords);
	
} else {
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
?>