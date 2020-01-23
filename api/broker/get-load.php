<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	$id = isset($_REQUEST['load_id']) ? $_REQUEST['load_id']: '';
	$user_type = isset($_REQUEST['user_type']) ? $_REQUEST['user_type']: '';
	$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
	$viewlist=isset($_REQUEST['viewlist']) ? $_REQUEST['viewlist']: '';
	
	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}elseif(empty($id)){
		$aVars=array("status"=>0,"msg"=>"Load id is empty");
	}elseif(!empty($id) && !is_numeric($id)){
		$aVars=array("status"=>0,"msg"=>"Invalid load id");
	}elseif(empty($user_type)){
		$aVars=array("status"=>0,"msg"=>"Empty user type");
	}else{

		$loads = $Global->db->prepare("SELECT loads.approve_status,loads.status,loads.height,DATE(loads.created_date) as created_date ,loads.suggest_comments,users.business_name,truck_type.truck_name,loads.id,loads.user_id,loads.broker_id AS bro_id,loads.shipper_id AS ship_id,loads.origin as origin,loads.destination,loads.origin_lat as origin_lat,loads.origin_lng as origin_lng,loads.destination_lat,loads.destination_lng,loads.pickup_date,loads.delivery_date,loads.truck_load_type,loads.weight,loads.length,loads.truck_id,loads.price,loads.app_type,loads.load_id,loads.pickup_time,loads.delivery_time,loads.suggest_price,loads.origin_address,loads.destination_address   FROM loads INNER JOIN truck_type ON truck_type.id=loads.truck_id  INNER JOIN users ON users.id=loads.user_id where loads.id=:id");

		$loads->execute(array("id"=>$id));
		$lresults = $loads->fetch(PDO::FETCH_ASSOC);


		$orgaddrs="";
		$desaddrs="";
		$broker_phone="";

		if($user_type=='trucker'){
			$check=$Global->db->prepare("SELECT id,phone FROM trucker WHERE user_id=:user_id AND status=1");
			$check->execute(array("user_id"=>$user_id));
			$rowchk=$check->fetch(PDO::FETCH_ASSOC);

			$upacoming=$Global->db->prepare("SELECT con.name, con.phone AS con_phone, con.email,loads_trip.load_status,loads.origin_address,loads.destination_address FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN load_contacts AS con ON con.load_id=loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_id=:load_id AND loads_trip.load_status=2 AND loads_trip.is_delete=0");
			$upacoming->execute(array("trucker_id"=>$rowchk['id'],"load_id"=>$id));
			$uprowchk=$upacoming->fetch(PDO::FETCH_ASSOC);

			$inprogress=$Global->db->prepare("SELECT con.name, con.phone AS con_phone, con.email, loads_trip.load_status,loads.origin_address,loads.destination_address FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN load_contacts AS con ON con.load_id=loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_id=:load_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0");
			$inprogress->execute(array("trucker_id"=>$rowchk['id'],"load_id"=>$id));
			$inprocheck=$inprogress->fetch(PDO::FETCH_ASSOC);

			//con.name, con.phone, con.email,
	// INNER JOIN load_contacts AS con ON con.load_id=loads_trip.load_id

			$pastloads=$Global->db->prepare("SELECT con.name, con.phone AS con_phone, con.email,loads_trip.load_status,loads.origin_address,loads.destination_address FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN load_contacts AS con ON con.load_id=loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_id=:load_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0");
			$pastloads->execute(array("trucker_id"=>$rowchk['id'],"load_id"=>$id));
			$pastlcheck=$pastloads->fetch(PDO::FETCH_ASSOC);

				
			$showingcontent=false;
			if(!empty($uprowchk)){
				$orgaddrs=$uprowchk['origin_address'];
				$desaddrs=$uprowchk['destination_address'];
				//$broker_phone=$rowchk['phone'];
				$contact_name=$uprowchk['name'];
				$contact_email=$uprowchk['email'];
				$contact_phone=$uprowchk['con_phone'];
				$showingcontent=true;
			}elseif(!empty($inprocheck)){
				$orgaddrs=$inprocheck['origin_address'];
				$desaddrs=$inprocheck['destination_address'];
				//$broker_phone=$rowchk['phone'];
				$contact_name=$inprocheck['name'];
				$contact_email=$inprocheck['email'];
				$contact_phone=$inprocheck['con_phone'];
				$showingcontent=true;
			}elseif(!empty($pastlcheck)){
				$orgaddrs=$pastlcheck['origin_address'];
				$desaddrs=$pastlcheck['destination_address'];
				$broker_phone=$rowchk['phone'];
				$contact_name=$pastlcheck['name'];
				$contact_email=$pastlcheck['email'];
				$contact_phone=$pastlcheck['con_phone'];
				$showingcontent=true;
			}
			if ($lresults['bro_id'] != '' && $lresults['bro_id'] != null && $lresults['bro_id'] != 0) {
			$lresults['broker_id']=$lresults['bro_id'];
			}else if($lresults['ship_id'] != '' && $lresults['ship_id'] != null && $lresults['ship_id'] != 0){
			$lresults['broker_id']=$lresults['ship_id'];
			}
			$lresults['origin_address']=$orgaddrs;
			$lresults['destination_address']=$desaddrs;
			//$lresults['phone']=$broker_phone;
			$lresults['content']=$showingcontent;
			$lresults['name']=isset($contact_name) ? $contact_name: '';
			$lresults['email']=isset($contact_email) ? $contact_email: '';
			$lresults['con_phone']=isset($contact_phone) ? $contact_phone: '';
			$lresults['created_date']=$lresults['created_date'];
			$lresults['suggest_comments']='';

			//Recently viewes list insert data
			if($viewlist==true){
				$viewcheck=$Global->db->prepare("SELECT load_id FROM viewlist WHERE load_id=:load_id AND user_id=:user_id AND status=1");
				$viewcheck->execute(array("load_id"=>$id,"user_id"=>$user_id));
				$view_rowchk=$viewcheck->fetch(PDO::FETCH_ASSOC);	
				if(empty($view_rowchk)){
					$view_data =  array(
						"load_id"=> $id,
						"created_by"=>$user_id,
						"user_id"=>$user_id,
						"trucker_id"=>$rowchk['id'],
						"status"=>1
					);
					$Global->InsertData("viewlist",$view_data);
				}
			}

			

		}else if($user_type=='broker'){	

				$orgaddrs=$lresults['origin_address'];
				$desaddrs=$lresults['destination_address'];
				$brokcheck=$Global->db->prepare("SELECT  con.name, con.phone AS con_phone, con.email,phone FROM load_contacts AS con  WHERE load_id=:load_id AND status=1");

				$brokcheck->execute(array("load_id"=>$id));
				$brokchk=$brokcheck->fetch(PDO::FETCH_ASSOC);
				//$broker_phone=$brokchk['phone'];
				$contact_name=$brokchk['name'];
				$contact_email=$brokchk['email'];
				$contact_phone=$brokchk['con_phone'];
				//$lresults['phone']=$broker_phone;
				$lresults['name']=isset($contact_name) ? $contact_name: '';
				$lresults['email']=isset($contact_email) ? $contact_email: '';
			    $lresults['con_phone']=isset($contact_phone) ? $contact_phone: '';
				//$lresults['comments']=$broker_phone;
				$lresults['created_date']=$lresults['created_date'];

		}
			if ($lresults['bro_id'] != '' && $lresults['bro_id'] != null && $lresults['bro_id'] != 0) {
			$lresults['broker_id']=$lresults['bro_id'];
			}else if($lresults['ship_id'] != '' && $lresults['ship_id'] != null && $lresults['ship_id'] != 0){
			$lresults['broker_id']=$lresults['ship_id'];
			}

			if($lresults['suggest_price']==0){
				$lresults['price']=$lresults['price'];
			}else{
				$lresults['price']=$lresults['suggest_price'];
			}

			$lresults['origin_address']=$orgaddrs;
			$lresults['destination_address']=$desaddrs;
		//$getdistance=$Global->GetDistance($lresults['origin'],$lresults['destination']);
		//$lresults['distance']=$getdistance;
			$aVars=array("status"=>1 , "data"=>$lresults,"msg"=>"Load details listed successfully");

	}

}else{
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
exit;
?>