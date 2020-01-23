<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

$userid=isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : 0;
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);

if($CheckvalidToken['status']==1){

		$check=$Global->db->prepare("SELECT id FROM trucker WHERE user_id=:user_id AND status=1");
		$check->execute(array("user_id"=>$userid));
		$rowchk=$check->fetch(PDO::FETCH_ASSOC);
		$trucker_id=$rowchk['id'];

		$ucheck=$Global->db->prepare("SELECT name,email FROM users WHERE id=:id AND status=1");
		$ucheck->execute(array("id"=>$userid));
		$urowchk=$ucheck->fetch(PDO::FETCH_ASSOC);

		//Awaiting Approval Count
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.trucker_status=1 AND loads.status=1 AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0");
		$sel->execute(array("trucker_id"=>$trucker_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$awating_count = $records['allcount'];

		//Awaiting Approval Records
		$await = $Global->db->prepare("SELECT  loads_trip.confirm_date,loads.load_id,loads.id,loads.origin,loads.destination,loads.price,loads_trip.broker_id,loads_trip.load_status,users.name FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id
			INNER JOIN users ON loads.user_id = users.id 
			WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.trucker_status=1 AND loads.status=1 AND loads_trip.is_delete=0  AND loads_trip.cancel_status=0 ORDER BY loads_trip.id DESC LIMIT 2");
		$await->execute(array("trucker_id"=>$trucker_id));
		$awaiting_records =$await->fetchAll(PDO::FETCH_ASSOC);


		//Upcoming Trips Count
		$upcome = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=2 AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0 ");
		$upcome->execute(array("trucker_id"=>$trucker_id));
		$upcomc =$upcome->fetch(PDO::FETCH_ASSOC);
		$upcom_count = $upcomc['allcount'];
		//Upcoming Trips Records
		$upcome_rec = $Global->db->prepare("SELECT loads_trip.approval_date, loads.load_id,loads.id,loads.origin,loads.destination,loads.price  FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=2 AND loads_trip.trucker_status=2  AND loads_trip.is_delete=0  ORDER BY loads_trip.id DESC LIMIT 2");
		$upcome_rec->execute(array("trucker_id"=>$trucker_id));
		$upcoming_records =$upcome_rec->fetchAll(PDO::FETCH_ASSOC);

		//In Progesss Count
		$inpro = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE  loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0 ");
		$inpro->execute(array("trucker_id"=>$trucker_id));
		$inpros =$inpro->fetch(PDO::FETCH_ASSOC);
		$inprogress_count = $inpros['allcount'];

		//In Progesss Records
		$inprose = $Global->db->prepare("SELECT loads_trip.picked_date,loads.load_id,loads.id,loads.origin,loads.destination,loads.price  FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0 ORDER BY loads_trip.id DESC LIMIT 2 ");
		$inprose->execute(array("trucker_id"=>$trucker_id));
		$inpros_records =$inprose->fetchAll(PDO::FETCH_ASSOC);

		//Past Loads Count
		$past = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0 ");
		$past->execute(array("trucker_id"=>$trucker_id));
		$pasts =$past->fetch(PDO::FETCH_ASSOC);
		$past_count = $pasts['allcount'];

		//Past Loads Records
		$past = $Global->db->prepare("SELECT loads_trip.delivered_date,loads.load_id,loads.id,loads.origin,loads.destination,loads.price FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0 ORDER BY loads_trip.id DESC LIMIT 2 ");
		$past->execute(array("trucker_id"=>$trucker_id));
		$past_records =$past->fetchAll(PDO::FETCH_ASSOC);


		//Cancel Loads
		$cancel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status=1 AND loads_trip.is_delete=0 ");
		$cancel->execute(array("trucker_id"=>$trucker_id));
		$cancels =$cancel->fetch(PDO::FETCH_ASSOC);
		$cancel_count = $cancels['allcount'];

		//Cancel Records
		$cancel_red= $Global->db->prepare("SELECT loads.load_id,loads.id,loads.origin,loads.destination,loads.price FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status=1 AND loads_trip.is_delete=0 ORDER BY loads_trip.id DESC LIMIT 5");
		$cancel_red->execute(array("trucker_id"=>$trucker_id));
		$cancel_records =$cancel_red->fetchAll(PDO::FETCH_ASSOC);

		  $count_state=$Global->db->prepare("SELECT COUNT(*)  as count_state FROM loads INNER JOIN loads_trip as trips ON loads.id=trips.load_id WHERE trips.trucker_id= :trucker_id AND trips.load_status =1 AND trips.trucker_status=1 AND  trips.cancel_status =0 AND trips.is_delete =0 AND  trips.denied_status = 0 ");
		  $count_state->execute(array("trucker_id"=>$trucker_id));
		  $confrm_count_state=$count_state->fetch(PDO::FETCH_ASSOC);
		  $confrm_state_count=$confrm_count_state['count_state'];

		


		// Total Records
		//echo "SELECT count(*) as totloads  FROM  loads WHERE user_id=".$userid;exit;
		//AND lt.trucker_notification_view=0
		
		$totloads = $Global->db->prepare("SELECT count(*) AS totloads FROM loads l 
			INNER JOIN loads_trip lt ON l.id=lt.load_id 
			WHERE l.status = 5 AND lt.trucker_id =:trucker_id AND lt.cancel_status=2  ");
		$totloads->execute(array("trucker_id"=>$trucker_id));
		$totrows = $totloads->fetch(PDO::FETCH_ASSOC);
	
		$vars['awaiting_count']=$awating_count;
		$vars['upcoming_count']=$upcom_count;
		$vars['inprogress_count']=$inprogress_count;
		$vars['past_count']=$past_count;
		$vars['cancelled_count']=$cancel_count;
		$vars['total_records_count']=$totrows['totloads'];

		$vars['name']=$urowchk['name'];
		$vars['email']=$urowchk['email'];

		
	
		$vars['awaiting_records']=$awaiting_records;
		$vars['cancelled_records']=$cancel_records;
		$vars['upcoming_records']=$upcoming_records;
		$vars['inprogress_records']=$inpros_records;
		$vars['past_records']=$past_records;
		$vars['confrm_state_count'] = $confrm_state_count;

		$five_total=$awating_count+$upcom_count+$inprogress_count+$past_count+$cancel_count;

		$vars['awaiting_percentage'] =($awating_count!=0) ?  ($awating_count/$five_total)*100 :0;
		$vars['cancelled_percentage'] =($cancel_count!=0) ?  ($cancel_count/$five_total)*100 :0;
		$vars['upcoming_percentage'] =($upcom_count!=0) ?  ($upcom_count/$five_total)*100 :0;
		$vars['inprogress_percentage'] =($inprogress_count!=0) ?  ($inprogress_count/$five_total)*100 :0;
		$vars['past_percentage'] =($past_count!=0) ?  ($past_count/$five_total)*100 :0;
		
	$aVars=array("status"=>1 , "data"=>$vars);
	


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);

exit;

?>