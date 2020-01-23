<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id = isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	// BrokerDetails starts
	$TruckerDetails = $Global->TruckerDetails($user_id);
	$trucker_id = $TruckerDetails["id"];
	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);
	$current_date = date('Y-m-d');
	$tomarrowDate = $currDate['current_date'];
	$req = isset($_REQUEST['req']) ? $_REQUEST['req']: '';
	
	if($req=="newload"){
/*		$data=array(
			"type"=>"newload",
			"viewed_date" => $current_date,
			"trucker_id"=>$trucker_id
		);
		 $loads_newloads=$Global->InsertData("notification_control",$data);
		$aVars=array("status"=>1, "msg"=>"New Load Viewed Successfully");*/
		$loads_newloads = $Global->db->prepare("UPDATE loads SET notification_view_trucker_ids  = array_append(notification_view_trucker_ids,:trucker_id) WHERE status IN(0,1) AND created_date BETWEEN NOW() - INTERVAL '24 HOURS' AND NOW() AND NOT (:trucker_id = ANY (notification_view_trucker_ids))");
		$loads_newloads->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"New Load Viewed Successfully");
	} else if($req=="denied"){
		$loads_deniedloads = $Global->db->prepare("UPDATE loads_trip SET trucker_notification_view =1
			WHERE trucker_id=:trucker_id AND trucker_status =1 AND denied_status=1  AND trucker_notification_view=0");
		$loads_deniedloads->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"denied Load Viewed Successfully");
	} else if($req=="cancelload"){
		$loads_cancel_loads = $Global->db->prepare("UPDATE loads_trip SET trucker_notification_view =2
			WHERE trucker_id=:trucker_id AND cancel_status =2  AND trucker_notification_view in (0,1)");
		$loads_cancel_loads->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"Cancelled Load Viewed Successfully");
	} else if($req=="pi"){
		$loads_cancel_loads = $Global->db->prepare("UPDATE loads_trip SET trucker_notification_view =1
			WHERE trucker_id=:trucker_id AND load_status =2  AND trucker_notification_view=0");
		$loads_cancel_loads->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"Upcoming Trips Load Viewed Successfully");
	} else if($req=="re_open"){
			$loads_reopen_loads = $Global->db->prepare("UPDATE loads_trip SET trucker_notification_view =2
			WHERE trucker_id=:trucker_id  AND cancel_status=0 AND trucker_status =1 AND  denied_status=1 AND trucker_notification_view=1");
		$loads_reopen_loads->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"Reopened Load Viewed Successfully");
	} else if($req=="upcommingall"){
		
		$upcommingall=$Global->db->prepare("UPDATE loads_trip SET trucker_notification_view=1 WHERE trucker_id=:trucker_id");
		$upcommingall->execute(array("trucker_id"=>$trucker_id));
		$aVars=array("status"=>1, "msg"=>"All Upcoming  Viewed Successfully");
	}

} else {
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);

?>