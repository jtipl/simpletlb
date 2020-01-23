<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
//if($user_id!="" || $user_id!=0){
		// BrokerDetails starts

$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
$curr->execute();
$currDate = $curr->fetch(PDO::FETCH_ASSOC);
	

$country = isset($_REQUEST['country']) ? $_REQUEST['country']: '';
$state_id = isset($_REQUEST['state_id']) ? $_REQUEST['state_id']: '';
$state_name = isset($_REQUEST['state_name']) ? $_REQUEST['state_name']: '';
$monthwise = isset($_REQUEST['monthwise']) ? $_REQUEST['monthwise']: '';
$year = isset($_REQUEST['yearwise']) ? $_REQUEST['yearwise']: '';
$month = date("m",strtotime($monthwise));
$monthwise_date = $year."-".$month; 

$country_sql = $Global->db->prepare("SELECT * FROM countries WHERE id=:country");
$country_sql->execute(array("country"=>$country));
$country_row=$country_sql->fetch(PDO::FETCH_ASSOC);
$country_name=$country_row["name"];




$broker="";
$trucker="";
$loads="";
$confirm_date="";
$upcoming="";
$picked_date="";
$delivered_date="";
$cancel_date="";
$mobile_users="";
$broker_mobile="";
$broker_web="";
$trucker_confirm_withoutuser="";
$broker_without_addload="";

if($country!=""){
	$broker.=" AND broker.country='".$country."'";
	$trucker.=" AND trucker.country='".$country."' ";
	$loads.=" loads.origin_country='".$country_name."'";
	$confirm_date.=" AND loads.origin_country='".$country_name."' ";

	$upcoming.=" AND loads.origin_country='".$country_name."' ";
	$picked_date.=" AND loads.origin_country='".$country_name."' ";
	$delivered_date.="AND loads.origin_country='".$country_name."' ";
	$cancel_date.="AND  loads.origin_country='".$country_name."' ";

	$broker_mobile.= " AND broker.country='".$country."'";
	$broker_web.=" AND broker.country='".$country."' ";
	$trucker_confirm_withoutuser.=" AND loads.origin_country='".$country_name."'";
	$broker_without_addload.=" AND broker.country='".$country."'";
}
if($state_name!=""){
	if($state_id!=""){
		$broker.=" AND broker.state='".$state_id."'";
		$trucker.=" AND trucker.state='".$state_id."' ";
		$broker_mobile.= " AND broker.state='".$state_id."'";
		$broker_web.=" AND broker.state='".$state_id."' ";
	}
	$trucker.="";
	if($state_name!="undefined"){
		$loads.=" AND loads.origin_state='".$state_name."'";
		$trucker_confirm_withoutuser.=" AND loads.origin_state='".$state_name."'";
		$broker_without_addload.=" AND broker.state='".$state_id."' ";
	}
	$confirm_date.=" AND EXTRACT(YEAR FROM loads_trip.confirm_date) = '".$year."' ";
	$upcoming.=" AND EXTRACT(YEAR FROM loads_trip.approval_date) = '".$year."' ";
	$picked_date.=" AND EXTRACT(YEAR FROM loads_trip.picked_date) = '".$year."' ";
	$delivered_date.=" AND EXTRACT(YEAR FROM loads_trip.delivered_date) = '".$year."' ";
	
}
if($year!=""){
	if($year!="undefined"){
		$broker.=" AND EXTRACT(YEAR FROM broker.created_date) = '".$year."'";
		$trucker.="AND EXTRACT(YEAR FROM trucker.created_date) = '".$year."' ";
		$loads.=" AND EXTRACT(YEAR FROM loads.created_date) = '".$year."' ";

		$broker_mobile.=" AND EXTRACT(YEAR FROM broker.created_date) = '".$year."' ";
		$broker_web.=" AND EXTRACT(YEAR FROM broker.created_date) = '".$year."' ";
		$trucker_confirm_withoutuser.=" AND EXTRACT(YEAR FROM loads.created_date) = '".$year."'";
		$broker_without_addload.=" AND EXTRACT(YEAR FROM broker.created_date) = '".$year."' ";

		$confirm_date.=" AND EXTRACT(YEAR FROM loads_trip.confirm_date) = '".$year."' ";
		$upcoming.=" AND EXTRACT(YEAR FROM loads_trip.approval_date) = '".$year."' ";
		$picked_date.=" AND EXTRACT(YEAR FROM loads_trip.picked_date) = '".$year."' ";
		$delivered_date.=" AND EXTRACT(YEAR FROM loads_trip.delivered_date) = '".$year."' ";
		$cancel_date.=" AND EXTRACT(YEAR FROM loads_trip.cancel_date) = '".$year."' ";
	} 
}
if($month!=""){
	if($month!="undefined"){
		$broker.=" AND EXTRACT(MONTH FROM broker.created_date) = '".$month."'";
		$trucker.="AND EXTRACT(MONTH FROM trucker.created_date) = '".$month."' ";
		
		$loads.=" AND EXTRACT(MONTH FROM loads.created_date) = '".$month."'";
		$broker_mobile.=" AND EXTRACT(MONTH FROM broker.created_date) = '".$month."' ";
		$broker_web.=" AND EXTRACT(MONTH FROM broker.created_date) = '".$month."' ";
		$trucker_confirm_withoutuser.=" AND EXTRACT(MONTH FROM loads.created_date) = '".$month."'";
		$broker_without_addload.=" AND EXTRACT(MONTH FROM broker.created_date) = '".$month."' ";

		$confirm_date.=" AND EXTRACT(MONTH FROM loads_trip.confirm_date) = '".$month."' ";
		$upcoming.=" AND EXTRACT(MONTH FROM loads_trip.approval_date) = '".$month."' ";
		$picked_date.=" AND EXTRACT(MONTH FROM loads_trip.picked_date) = '".$month."' ";
		$delivered_date.=" AND EXTRACT(MONTH FROM loads_trip.delivered_date) = '".$month."' ";
		$cancel_date.=" AND EXTRACT(MONTH FROM loads_trip.cancel_date) = '".$month."' ";
	} 
}



$total_broker = $Global->db->prepare("SELECT count(*) as count FROM users 
			INNER JOIN broker  ON users.id = broker.user_id 
			WHERE users.user_type='broker' AND users.status=1 $broker  ");
$total_broker->execute();
$total_broker_row=$total_broker->fetch(PDO::FETCH_ASSOC);
$broker_count=$total_broker_row["count"];

	
$total_trucker = $Global->db->prepare("SELECT count(*) as count FROM users 
			INNER JOIN trucker  ON users.id = trucker.user_id 
			WHERE users.user_type='trucker' $trucker ");
$total_trucker->execute();
$total_trucker_row=$total_trucker->fetch(PDO::FETCH_ASSOC);
$trucker_count=$total_trucker_row["count"];
	
	//echo "SELECT count(*) as count FROM loads WHERE $loads ";exit;
$total_loads = $Global->db->prepare("SELECT count(*) as count FROM loads WHERE $loads ");
$total_loads->execute();
$total_loads_row=$total_loads->fetch(PDO::FETCH_ASSOC);
$loads_count=$total_loads_row["count"];

//echo "SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_status=1 AND loads_trip.load_status=1  $confirm_date ";
$confirm_loadssel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.trucker_status=1 AND loads_trip.load_status=1 $confirm_date " );
$confirm_loadssel->execute();
$confirm_loads_records =$confirm_loadssel->fetch(PDO::FETCH_ASSOC);
$confirm_Totalloadssel = $confirm_loads_records['allcount'];

$upcoming_sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id INNER JOIN users ON users.id = loads.user_id INNER JOIN broker ON broker.user_id=users.id WHERE loads_trip.load_status=2 AND loads_trip.trucker_status=2 AND loads_trip.is_delete=0 $upcoming ");//AND loads.status=2
$upcoming_sel->execute();
$upcoming_records =$upcoming_sel->fetch(PDO::FETCH_ASSOC);
$upcoming_Total_records = $upcoming_records['allcount'];

$picked_loads = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id INNER JOIN users ON users.id = loads.user_id INNER JOIN broker ON broker.user_id=users.id WHERE  loads_trip.load_status=3 AND loads_trip.is_delete=0 $picked_date");//AND loads.status=2
$picked_loads->execute();
$picked_records =$picked_loads->fetch(PDO::FETCH_ASSOC);
$picked_total_recoreds = $picked_records['allcount'];


$delivered_loads = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.load_status=4 $delivered_date ");//AND loads.status=2
$delivered_loads->execute();
$delivered_records =$delivered_loads->fetch(PDO::FETCH_ASSOC);
$delivered_total_records = $delivered_records['allcount'];


$cancel_loads = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip 
					INNER JOIN loads ON loads.id = loads_trip.load_id 
					WHERE loads.cancel_status = 2 
					 $cancel_date ");
$cancel_loads->execute();
$cancel_loads_row = $cancel_loads->fetch(PDO::FETCH_ASSOC);
$cancel_total_records = $cancel_loads_row['allcount'];

$mobile_users = $Global->db->prepare("SELECT count(*) as allcount FROM users INNER JOIN broker  ON users.id = broker.user_id 
			WHERE users.user_type='broker' AND users.status=1 AND app_type IN ('android','ios') $broker_mobile ");
$mobile_users->execute();
$mobile_users_row = $mobile_users->fetch(PDO::FETCH_ASSOC);
$mobile_totat_records = $mobile_users_row['allcount'];

$web_users = $Global->db->prepare("SELECT count(*) as allcount FROM users INNER JOIN broker  ON users.id = broker.user_id WHERE users.user_type='broker' AND users.status=1 AND app_type IN ('web') $broker_web");
$web_users->execute();
$web_users_row = $web_users->fetch(PDO::FETCH_ASSOC);
$web_total_records = $web_users_row['allcount'];


$trucker_confirm_user = $Global->db->prepare("SELECT count(*) as allcount from users 
	INNER JOIN  loads_trip ON loads_trip.user_id!=users.id 
	INNER JOIN loads ON loads_trip.load_id!=loads.id 

	WHERE users.user_type='trucker' and users.status=1 $trucker_confirm_withoutuser ");
$trucker_confirm_user->execute();
$trucker_confirm_row=$trucker_confirm_user->fetch(PDO::FETCH_ASSOC);
$trucker_without_confirm_records=$trucker_confirm_row['allcount'];

//$broker_without_val=0;

/*
echo "SELECT loads.user_id  from users INNER JOIN  
	loads ON loads.user_id=users.id 
	WHERE users.user_type='broker' and users.status=1 
	group by loads.user_id $broker_without_addload";exit;
$broker_withoutaddnewoad = $Global->db->prepare("
	SELECT loads.user_id  from users INNER JOIN  
	loads ON loads.user_id=users.id 
	WHERE users.user_type='broker' and users.status=1 
	group by loads.user_id $broker_without_addload
");
$broker_withoutaddnewoad->execute();
$broker_withoutadd_row=$broker_withoutaddnewoad->fetchAll(PDO::FETCH_ASSOC);
$broker_without_val= ($broker_count - count($broker_withoutadd_row));
*/
$aVars=array("status"=>2 ,"broker_count"=>$broker_count, "trucker_count"=>$trucker_count,"loads_count"=>$loads_count,"confirm_Totalloadssel"=>$confirm_Totalloadssel,"upcoming_Total_records"=>$upcoming_Total_records,"picked_total_recoreds"=>$picked_total_recoreds,"delivered_total_records"=>$delivered_total_records,"cancel_total_records"=>$cancel_total_records,"mobile_totat_records"=>$mobile_totat_records,"web_total_records"=>$web_total_records,"trucker_without_confirm_records"=>$trucker_without_confirm_records);

echo json_encode($aVars);

?>