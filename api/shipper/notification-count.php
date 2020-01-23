<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){
	// BrokerDetails starts
	$ShipperDetails = $Global->ShipperDetails($user_id);
	$shipper_id = $ShipperDetails["id"];

	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);

	// Total Expired Start Here
	
	$loads_expired = $Global->db->prepare("SELECT count(*) as count FROM loads WHERE user_id=:user_id AND  (pickup_date = '".$currDate['current_date']."' OR pickup_date = '".date("Y-m-d")."')
	 and status ='0' AND shipper_notification_view='0'  ");
	$loads_expired->execute(array("user_id"=>$user_id));
	$rowloads_expired = array();
	$rowloads_expired = $loads_expired->fetch(PDO::FETCH_ASSOC);
	$total_expired_loads = $rowloads_expired["count"];  
	// Total Expired Ends Here


	// Approving Starts Here 
	$loads_approve = $Global->db->prepare("SELECT count(*) as count FROM loads WHERE user_id=:user_id 
	and status ='1' AND shipper_notification_view in (0,1)   ");
	$loads_approve->execute(array("user_id"=>$user_id));
	$rowloads_approve = array();
	$rowloads_approve2 = $loads_approve->fetch(PDO::FETCH_ASSOC);
	$total_approve_loads = $rowloads_approve2["count"];  
	// Approving Ends Here

	// Cancel Trip Starts Here 
	/*
	$loads_canceltrip = $Global->db->prepare("SELECT count(*) as count FROM loads l join loads_trip lt 
												on l.id=lt.load_id 
												and lt.shipper_id=:shipper_id and lt.cancel_status =1 AND l.shipper_notification_view !='5'");
	*/
	//$loads_canceltrip = $Global->db->prepare("SELECT count(*) as count FROM loads l WHERE 
	

	$loads_canceltrip = $Global->db->prepare("SELECT count(*) as count FROM loads l WHERE 
												user_id=:user_id  AND status= '5' AND shipper_notification_view IN(0,5)");
	$loads_canceltrip->execute(array("user_id"=>$user_id));
	$rowloads_canceltrip = array();
	$rowloads_canceltrip = $loads_canceltrip->fetch(PDO::FETCH_ASSOC);
	$total_canceltrip = $rowloads_canceltrip["count"];  
	// Cancel Trip Ends Here


	// Upcoming loads picked by trucker starts here 
	
	$loads_picked = $Global->db->prepare("SELECT count(*) as count FROM loads l join loads_trip lt 
							on l.id=lt.load_id and lt.shipper_id=:shipper_id and lt.load_status in (3) AND lt.shipper_notification_view != '3'  AND lt.is_delete=0 ");
	$loads_picked->execute(array("shipper_id"=>$shipper_id));
	$rowloads_picked = $loads_picked->fetch(PDO::FETCH_ASSOC);
	$total_picked = $rowloads_picked["count"]; 
	// Upcoming loads picked by trucker ends here 

	// Upcoming loads  delivered starts here
	
	$loads_delivered = $Global->db->prepare("SELECT count(*) as count FROM loads l join loads_trip lt 
												on l.id=lt.load_id 
												and lt.shipper_id=:shipper_id and lt.load_status =4 AND lt.is_delete=0  AND  lt.shipper_notification_view != '4'
												");
	$loads_delivered->execute(array("shipper_id"=>$shipper_id));
	$rowloads_deliver = $loads_delivered->fetch(PDO::FETCH_ASSOC);
	$total_delivered = $rowloads_deliver["count"]; 
	// Upcoming loads delivered  ends here 

	if($total_expired_loads==0 && $total_approve_loads==0 && $total_canceltrip==0 && $total_picked==0 && $total_delivered==0){
		$aVars = array('status' =>0 ,"no_count" =>0);
	} else {
		if($total_expired_loads!=0){
            $msg_count_1 = 1;
        }  else {
            $msg_count_1 = 0;
        }
		if($total_approve_loads!=0){
			$msg_count_2 = 1;
		}
		else{
			$msg_count_2 = 0;
		}
        if($total_canceltrip!=0){
           $msg_count_3 = 1;
        }
        else{
          $msg_count_3 = 0;
        }

        if($total_picked!=0){
        	$msg_count_4 =1;
        } else {
        	$msg_count_4 =0;
        }

        if($total_delivered!=0){
        	$msg_count_5 =1;
        } else {
        	$msg_count_5 =0;
        }

        $total_count = ($msg_count_1+$msg_count_2+$msg_count_3+$msg_count_4+$msg_count_5);
		$aVars = array('status' =>1,"total_count"=>$total_count ,"total_expired_loads" =>$total_expired_loads,"total_approve_loads" =>$total_approve_loads,"total_canceltrip"=>$total_canceltrip,"total_picked"=>$total_picked,"total_delivered"=>$total_delivered);
	}
} else {
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);

?>