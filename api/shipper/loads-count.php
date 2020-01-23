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

	// AND pickup_date >= CURRENT_DATE
	//echo "SELECT count(*) as allcount FROM loads WHERE user_id='$user_id'  AND status IN(0,5)";
	// Pending Loads
	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);


	//echo "SELECT count(*) as allcount FROM loads WHERE user_id='$user_id'  AND status IN(0,5) AND pickup_date >= CURRENT_DATE";
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id  AND status IN(0,5) AND pickup_date >= CURRENT_DATE");
	$sel->execute(array("user_id"=>$user_id));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$openloadscount = $records['allcount'];


	// Expiring Count
	$exp_sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND status = 0 AND (pickup_date = :tomarrow_date OR pickup_date = current_date) ");
	$exp_sel->execute(array("user_id"=>$user_id,"tomarrow_date"=>$currDate['current_date']));
	$exp_selrecords =$exp_sel->fetch(PDO::FETCH_ASSOC);
	$exp_selrecords = $exp_selrecords['allcount'];
	//echo $exp_selrecords;

	// Awaiting count
	$awaitingsel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND status IN(1,5) AND  approve_status=1 AND cancel_truckers <> confirm_truckers_id");
	$awaitingsel->execute(array("user_id"=>$user_id));
	$awaitingrecords =$awaitingsel->fetch(PDO::FETCH_ASSOC);
	$awaitingTotalrecords = $awaitingrecords['allcount'];

	// Ready For pick count
	$ready_for_pickup_sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN users ON users.id=loads_trip.user_id WHERE loads.user_id=:user_id AND loads.status=2 AND loads_trip.is_delete=0 AND  loads_trip.load_status=2 AND loads_trip.trucker_status=2 ");
	$ready_for_pickup_sel->execute(array("user_id"=>$user_id));
	$ready_for_pickup_records =$ready_for_pickup_sel->fetch(PDO::FETCH_ASSOC);
	$ready_for_pickupTotalrecords = $ready_for_pickup_records['allcount'];


	$picked_sel = $Global->db->prepare("SELECT count(*) as allcount 
	FROM loads WHERE user_id=:user_id  AND status=3");
	$picked_sel->execute(array("user_id"=>$_SESSION["user_id"]));
	$picked_records =$picked_sel->fetch(PDO::FETCH_ASSOC);
	$pickedloadscount = $picked_records['allcount'];

	$deliveersel = $Global->db->prepare("SELECT count(*) as allcount 
	FROM loads WHERE user_id=:user_id AND status=4");
	$deliveersel->execute(array("user_id"=>$user_id));
	$deliveredrecords =$deliveersel->fetch(PDO::FETCH_ASSOC);
	$deliveredloadscount = $deliveredrecords['allcount'];



	$cancel_sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads_trip INNER JOIN loads ON loads.id = loads_trip.load_id WHERE loads_trip.shipper_id=:shipper_id AND loads_trip.cancel_status=2 ");//AND loads.status=2
	$cancel_sel->execute(array("shipper_id"=>$shipper_id));
	$cancel_records =$cancel_sel->fetch(PDO::FETCH_ASSOC);
	$canceltotalRecords = $cancel_records['allcount'];


	$expired_sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND pickup_date < CURRENT_DATE AND status =0 AND pickup_date < CURRENT_DATE   ");
	$expired_sel->execute(array("user_id"=>$user_id));
	$expiredrecords =$expired_sel->fetch(PDO::FETCH_ASSOC);
	$expiredtotalRecords = $expiredrecords['allcount'];


	// Total number of records without filtering
	$favouritesel = $Global->db->prepare("SELECT count(*) as allcount FROM favorite INNER JOIN trucker ON trucker.id = favorite.trucker_id INNER JOIN users ON users.id=trucker.user_id WHERE favorite.favorite_type='trucker_favorite' AND favorite.status=1 AND favorite.shipper_id=:shipper_id");
	$favouritesel->execute(array("shipper_id"=>$shipper_id));
	$favouriterecords =$favouritesel->fetch(PDO::FETCH_ASSOC);
	$favouriteTotalrecords = $favouriterecords['allcount'];

        //$total_count = ($msg_count_1+$msg_count_2+$msg_count_3+$msg_count_4+$msg_count_5);
	$aVars = array('status' =>1,"openloadscount" =>$openloadscount,"exp_selrecords" =>$exp_selrecords,"awaitingTotalrecords"=>$awaitingTotalrecords,"ready_for_pickupTotalrecords"=>$ready_for_pickupTotalrecords,"pickedloadscount"=>$pickedloadscount,"deliveredloadscount"=>$deliveredloadscount,"canceltotalRecords"=>$canceltotalRecords,"expiredtotalRecords"=>$expiredtotalRecords,"favouriteTotalrecords"=>$favouriteTotalrecords);
	
} else {
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);

?>