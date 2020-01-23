<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

$userid=isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : 0;
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);


if($CheckvalidToken['status']==1){

	$check=$Global->db->prepare("SELECT id FROM broker WHERE user_id=:user_id AND status=1");
	$check->execute(array("user_id"=>$userid));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	$broker_id=$rowchk['id'];

		$ucheck=$Global->db->prepare("SELECT name,email FROM users WHERE id=:id AND status=1");
		$ucheck->execute(array("id"=>$userid));
		$urowchk=$ucheck->fetch(PDO::FETCH_ASSOC);

	//Pending Loads Count	
	$pending = $Global->db->prepare("SELECT count(*) as pending  FROM  loads  WHERE user_id=:user_id AND status=:status");
	$pending->execute(array("status"=>0,"user_id"=>$userid));
	$plrows = $pending->fetch(PDO::FETCH_ASSOC);
	//Approval Loads Count	
	$approval = $Global->db->prepare("SELECT count(*) as approval  FROM  loads  WHERE user_id=:user_id  AND status=:status");
	$approval->execute(array("status"=>1,"user_id"=>$userid));
	$arows = $approval->fetch(PDO::FETCH_ASSOC);

	//Approval for Pickup Loads Count	
	$approveforpick = $Global->db->prepare("SELECT count(*) as approveforpick  FROM  loads  WHERE user_id=:user_id  AND status=:status");
	$approveforpick->execute(array("status"=>2,"user_id"=>$userid));
	$aprows = $approveforpick->fetch(PDO::FETCH_ASSOC);

	//Picked Loads Count
	$picked = $Global->db->prepare("SELECT count(*) as picked  FROM  loads  WHERE user_id=:user_id  AND status=:status");
	$picked->execute(array("status"=>3,"user_id"=>$userid));
	$prows = $picked->fetch(PDO::FETCH_ASSOC);

	//Delivered Loads Count	
	$delivered = $Global->db->prepare("SELECT count(*) as delivered  FROM  loads   WHERE user_id=:user_id  AND status=:status");
	$delivered->execute(array("status"=>4,"user_id"=>$userid));
	$drows = $delivered->fetch(PDO::FETCH_ASSOC);

	//Tpoday Loads Count
	$todayloads = $Global->db->prepare("SELECT count(*) as todayloads  FROM  loads WHERE user_id=:user_id AND DATE(created_date) = CURRENT_DATE ");
	$todayloads->execute(array("user_id"=>$userid));
	$torows = $todayloads->fetch(PDO::FETCH_ASSOC);
	//Total Loads Count
	$totloads = $Global->db->prepare("SELECT count(*) as totloads  FROM  loads WHERE user_id=:user_id");
	$totloads->execute(array("user_id"=>$userid));
	$totrows = $totloads->fetch(PDO::FETCH_ASSOC);

	//Cancel Loads Count	
	$cancel_loads = $Global->db->prepare("SELECT count(*) as cancel_loads  FROM  loads_trip WHERE broker_id=:broker_id AND cancel_status=2 ");
	$cancel_loads->execute(array("broker_id"=>$broker_id));
	$cancel_count = $cancel_loads->fetch(PDO::FETCH_ASSOC);
	
	$cancel_records = $Global->db->prepare("SELECT loads.load_id,loads.id,loads.origin,loads.destination,loads.price  FROM  loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id WHERE loads_trip.broker_id=:broker_id AND loads_trip.cancel_status=1 ORDER BY loads_trip.id DESC LIMIT 5");
	$cancel_records->execute(array("broker_id"=>$broker_id));
	$cancel_records = $cancel_records->fetchAll(PDO::FETCH_ASSOC);

	//Expire  loads counts 
	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);
	
	$loads_expired = $Global->db->prepare("SELECT count(*) as count FROM loads WHERE user_id=:user_id AND  pickup_date < CURRENT_DATE and status =0  ");
	$loads_expired->execute(array("user_id"=>$userid));
	$rowloads_expired = $loads_expired->fetch(PDO::FETCH_ASSOC);
	
	$broker_details=$Global->db->prepare("SELECT name,business_name FROM users WHERE id=:id");
	$broker_details->execute(array("id"=>$userid));
	$broker_row=$broker_details->fetch(PDO::FETCH_ASSOC);
	
	
	$loads_expirerec = $Global->db->prepare("SELECT load_id,id,origin,destination,price FROM loads WHERE user_id=:user_id AND  pickup_date < CURRENT_DATE AND status =0  ");
	$loads_expirerec->execute(array("user_id"=>$userid));
	$expired_rec = $loads_expirerec->fetchAll(PDO::FETCH_ASSOC);
	



	//Today loads records 
	$todayloadsrec = $Global->db->prepare("SELECT load_id,id,origin,destination,price FROM  loads WHERE user_id=:user_id AND DATE(created_date) = CURRENT_DATE LIMIT 5 ");
	$todayloadsrec->execute(array("user_id"=>$userid));
	$today_records = $todayloadsrec->fetchAll(PDO::FETCH_ASSOC);

	//Recent loads records
	$recentloads = $Global->db->prepare("SELECT load_id,id,origin,destination,price FROM  loads WHERE user_id=:user_id ORDER BY id DESC LIMIT 5 ");
	$recentloads->execute(array("user_id"=>$userid));
	$recent_records = $recentloads->fetchAll(PDO::FETCH_ASSOC);

	//inprogress loads records	
	$inprogress_rec = $Global->db->prepare("SELECT loads_trip.id as tripid,loads.price,loads.weight,loads.length,loads.load_id,loads.origin as origin,loads.destination,loads.id,loads.status as loadstatus,loads_trip.load_status as tripstatus,trucker.phone,trucker.vehicle_number as dot ,users.name  FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id INNER JOIN trucker ON trucker.id=loads_trip.trucker_id INNER JOIN users ON users.id=loads_trip.user_id WHERE  loads_trip.broker_id=:broker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0    ORDER BY loads_trip.id DESC LIMIT 5 ");
	$inprogress_rec->execute(array("broker_id"=>$broker_id));
	$inpro_data = $inprogress_rec->fetchAll(PDO::FETCH_ASSOC);

	//Pastloads records
	$pastloads = $Global->db->prepare("SELECT loads_trip.id as tripid,loads.price,loads.weight,loads.length,loads.load_id,loads.origin as origin,loads.destination,loads.id,loads.status as loadstatus,loads_trip.load_status as tripstatus FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE  loads_trip.broker_id=:broker_id AND loads_trip.load_status=4  AND loads_trip.is_delete=0     ORDER BY loads_trip.id DESC LIMIT 5");
	$pastloads->execute(array("broker_id"=>$broker_id));
	$pastloads_data = $pastloads->fetchAll(PDO::FETCH_ASSOC);

	//Awating Records
	$awaiting = $Global->db->prepare("SELECT load_id,id,origin,destination,price FROM loads WHERE user_id=:user_id  AND status =1 ORDER BY id DESC LIMIT 2");
	$awaiting->execute(array("user_id"=>$userid));
	$await_records = $awaiting->fetchAll(PDO::FETCH_ASSOC);
	
	//Open Records
	$openloads = $Global->db->prepare("SELECT array_sort(cancel_truckers) = array_sort(confirm_truckers_id) as condition,approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND  pickup_date >= CURRENT_DATE ORDER BY id DESC LIMIT 2	 ");
	$openloads->execute(array("user_id"=>$userid));
	$open_records =$openloads->fetchAll(PDO::FETCH_ASSOC);
	$arrd=array();
		if(!empty($open_records)){
			foreach ($open_records as $key => $value) {
				 if($value['approve_status']==1 && $value['condition']==''){
				 	continue;
				 }
				$arrd[]=$value;
			}
		}

	//Ready for pickup records
	$readyforpick = $Global->db->prepare("SELECT loads_trip.id,loads_trip.trucker_id,loads.approve_status,loads.id,loads.origin as origin,loads.destination,loads.pickup_date,loads.price,loads.status,loads.load_id,users.name FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN users ON users.id=loads_trip.user_id WHERE loads.user_id=:user_id  and loads.status =2  AND loads_trip.is_delete=0 AND loads_trip.load_status=2  AND loads_trip.trucker_status=2 ORDER BY loads_trip.id DESC LIMIT 2");

	$readyforpick->execute(array("user_id"=>$userid));
	$readydata = $readyforpick->fetchAll(PDO::FETCH_ASSOC);

	//Delivered Loads 
	$dsel = $Global->db->prepare("SELECT loads.load_id,loads_trip.id FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.broker_id=:broker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0 ORDER BY loads_trip.id DESC LIMIT 2 ");
	$dsel->execute(array("broker_id"=>$broker_id));
	$drecords =$dsel->fetchAll(PDO::FETCH_ASSOC);

	$arr=array();
	$daily_rep=$Global->db->prepare("SELECT count(*),date_part('day', created_date) as days FROM loads 			WHERE user_id=:user_id  AND created_date >= date_trunc('month', current_date - interval '1' month)  AND created_date < date_trunc('month', current_date) GROUP BY date_part('day', created_date) 
		ORDER BY days ");
	$daily_rep->execute(array("user_id"=>$userid));
	$daily_report=$daily_rep->fetchAll(PDO::FETCH_ASSOC);
	if(!empty($daily_report)){
		foreach ($daily_report as $key => $value) {
			$report['period']=$value['days'];
			$report['loads']=$value['count'];
			$arr[]=$report;
		}
	}


    

	$my_fav=$Global->db->prepare("SELECT count(*) as my_fav FROM favorite WHERE broker_id=:broker_id AND favorite_type='trucker_favorite' AND status=1");
	$my_fav->execute(array("broker_id"=>$broker_id));
	$my_fav_trucker=$my_fav->fetch(PDO::FETCH_ASSOC);

	$vars['recent_awaiting']=$await_records;
	$vars['recent_open']=$arrd;
	$vars['recent_pickup']=$readydata;
	$vars['recent_delivered']=$drecords;

	$vars['broker_name']=$broker_row['name'];
	$vars['business_name']=$broker_row['business_name'];
	$vars['pending_loads']=$plrows['pending'];
	$vars['approval_loads']=$arows['approval'];
	$vars['approve_pickup']=$aprows['approveforpick'];
	$vars['picked_loads']=$prows['picked'];
	$vars['delivered_loads']=$drows['delivered'];
	$vars['today_loads']=$torows['todayloads'];
	$vars['total_loads']=$totrows['totloads'];
	$vars['cancel_count']=$cancel_count['cancel_loads'];
  	$vars['expired_count']=$rowloads_expired["count"];
	$vars['my_favorite']=$my_fav_trucker['my_fav'];
	$vars['expired_records']=$expired_rec;
	$vars['cancel_records']=$cancel_records;
	$vars['today_records']=$today_records;
	$vars['inprogress_records']=$inpro_data;
	$vars['past_records']=$pastloads_data;
	$vars['recent_records']=$recent_records;
	$vars['awaiting_records']=$await_records;

	$vars['name']=$urowchk['name'];
	$vars['email']=$urowchk['email'];


	$four_total=$plrows['pending']+$arows['approval']+$prows['picked']+$drows['delivered'];

	$pending_per =($plrows['pending']!=0) ?  ($plrows['pending']/$four_total)*100 :0;
	$approval_per = ($arows['approval']!=0) ?   ($arows['approval']/$four_total)*100: 0; 
	$pickup_per = ($prows['picked']!=0) ?  ($prows['picked']/$four_total)*100: 0; 
	$delivery_per = ($drows['delivered']!=0) ?   ($drows['delivered']/$four_total)*100: 0; 
	$sec_total=$rowloads_expired['count']+$cancel_count['cancel_loads'];
	$expired_per=($rowloads_expired['count']!=0) ?  ($rowloads_expired['count']/$sec_total)*100: 0; 
	$cancel_per = ($cancel_count['cancel_loads']!=0) ?  ($cancel_count['cancel_loads']/$sec_total)*100: 0; 

	



	$vars['pending_percentage']=$pending_per;
	$vars['approval_percentage']=$approval_per;
	$vars['picked_percentage']=$pickup_per;
	$vars['delivery_percentage']=$delivery_per;
	$vars['cancel_percentage']=$cancel_per;
	$vars['expired_percentage']=$expired_per;
	$vars['daily_reports']=$arr;



	$aVars=array("status"=>1 , "data"=>$vars);
	


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);

exit;

?>