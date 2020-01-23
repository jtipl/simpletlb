<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
$req = isset($_REQUEST['req']) ? $_REQUEST['req']: '';
if($CheckvalidToken['status']==1){
	// BrokerDetails starts
	$ShipperDetails = $Global->ShipperDetails($user_id);
	$shipper_id = $ShipperDetails["id"];
	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);
	if($req=="expiring"){
		// Total Expired Start Here
		//User table update
		$loads_expired = $Global->db->prepare("UPDATE loads SET shipper_notification_view='1' WHERE user_id=:user_id AND  (pickup_date = '".$currDate['current_date']."' OR pickup_date = '".date("Y-m-d")."')
		 and status ='0' AND shipper_notification_view = '0' ");
		$loads_expired->execute(array("user_id"=>$user_id));
		// Total Expired Ends Here
		$aVars = array('status' =>1,'msg'=>'Expiring Viewed Successfully');
	}else if($req=="awaiting"){
		// Approving Starts Here 
		$loads_approve = $Global->db->prepare("UPDATE loads SET shipper_notification_view='2' WHERE user_id=:user_id 
		and status ='1' AND shipper_notification_view in (0,1)  ");
		$loads_approve->execute(array("user_id"=>$user_id));
		// Approving Ends Here
		$aVars = array('status' =>1,'msg'=>'Awaiting Approval Viewed Successfully');
	}else if($req=="picked"){
		// Approving Starts Here 
		$loads_picked = $Global->db->prepare("UPDATE loads_trip SET shipper_notification_view='3' WHERE shipper_id=:shipper_id and load_status =3  AND is_delete=0 ");
		$loads_picked->execute(array("shipper_id"=>$shipper_id));
		// Approving Ends Here
		$aVars = array('status' =>1,'msg'=>'Picked Loads Viewed Successfully');
	}else if($req=="delivered"){
		// Approving Starts Here 
		//echo "UPDATE loads SET notification_view='4' WHERE user_id='$user_id' and status =3";exit;
		$loads_deliver = $Global->db->prepare("UPDATE loads_trip SET shipper_notification_view='4' WHERE shipper_id=:shipper_id and load_status =4  AND is_delete=0  ");
		$loads_deliver->execute(array("shipper_id"=>$shipper_id));
		// Approving Ends Here
		$aVars = array('status' =>1,'msg'=>'Delivered Loads Viewed Successfully');
	}else if($req=="reopen"){
		// Approving Starts Here 
		//echo "UPDATE loads SET notification_view='4' WHERE user_id='$user_id' and status =3";exit;
		$loads_cancell = $Global->db->prepare("UPDATE loads SET shipper_notification_view='2' WHERE user_id=:user_id AND status= '5' ");
		$loads_cancell->execute(array("user_id"=>$user_id));
		// Approving Ends Here
		$aVars = array('status' =>1,'msg'=>'Cancelled Loads Viewed Successfully');
	}
	
} else {
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);

?>