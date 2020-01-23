<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){


		$tripid = isset($_POST['tripid']) ? $_POST['tripid']: '';
		$user_id = isset($_POST['user_id']) ? $_POST['user_id']: '';
		
		if(empty($user_id)){
			$aVars=array("status"=>0,"msg"=>"User id is empty");
		}elseif(!empty($user_id) && !is_numeric($user_id)){
			$aVars=array("status"=>0,"msg"=>"Invalid user id");
		}elseif(empty($tripid)){
			$aVars=array("status"=>0,"msg"=>"Trip id is empty");
		}elseif(!empty($tripid) && !is_numeric($tripid)){
			 $aVars=array("status"=>0,"msg"=>"Invalid trip id");
		}else{

			//Delivered load status
			$getloadid = $Global->db->prepare("SELECT load_id,broker_id,shipper_id FROM loads_trip WHERE  id =:id ");
			$getloadid->execute(array("id"=>$tripid));
			$getrow = $getloadid->fetch(PDO::FETCH_ASSOC);

			$loaddata=array(
			"status"=>4
			);
			$loadcon =array("id"=>$getrow['load_id']);
			$Global->UpdateData("loads",$loaddata,$loadcon);

			$lcdatas=array(
			"load_status"=>4,	
			"delivered_date" =>date("Y-m-d H:i:s")

			);
			$lconditions =array("id"=>$tripid);
			$Global->UpdateData("loads_trip",$lcdatas,$lconditions);

			$TruckerUserDetails = $Global->TruckerUserDetails($user_id);
			$_SESSIONname= $TruckerUserDetails['name'];
			$_SESSIONemail= $TruckerUserDetails['email'];

			if($getrow['broker_id'] != 0  && $getrow['broker_id'] != null && $getrow['broker_id'] != ''){
				$brokerdets = $Global->db->prepare("SELECT name as brokername,email FROM broker INNER JOIN  users ON users.id=broker.user_id WHERE broker.id=:id  ");
				$brokerdets->execute(array("id"=>$getrow['broker_id']));
	     		$brorow = $brokerdets->fetch(PDO::FETCH_ASSOC);

			}else if ($getrow['shipper_id'] != 0  && $getrow['shipper_id'] != null && $getrow['shipper_id'] != ''){
				$brokerdets = $Global->db->prepare("SELECT name as brokername,email FROM shipper INNER JOIN  users ON users.id=shipper.user_id WHERE shipper.id=:id  ");
				$brokerdets->execute(array("id"=>$getrow['shipper_id']));
				$brorow = $brokerdets->fetch(PDO::FETCH_ASSOC);
			}

			$truckerdets = $Global->db->prepare("SELECT name as truckername FROM trucker INNER JOIN  users ON users.id=trucker.user_id WHERE trucker.user_id=:user_id  ");
			$truckerdets->execute(array("user_id"=>$user_id));
			$trucrow = $truckerdets->fetch(PDO::FETCH_ASSOC);

			$loaddets = $Global->db->prepare("SELECT origin as origin,destination,load_id,pickup_date FROM loads WHERE id=:id  ");
			$loaddets->execute(array("id"=>$getrow['load_id']));
			$loadsrow = $loaddets->fetch(PDO::FETCH_ASSOC);


			$imglink=SITEURL."app/assets/brand/logo.png";
			$imgicon=SITEURL."app/assets/brand/thumbs-up.png";
			$broker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
			FROM public.email_template WHERE type='delivered-notification-to-broker'");
			$broker_emails->execute();
			$broker_email_template= $broker_emails->fetch(PDO::FETCH_ASSOC);
			$broker_subject=$broker_email_template['subject'];

			$broker_token = array(
			'IMGLINK'  			=> $imglink,
			'SITEURL'			=> SITEURL,
			'ICON'				=> $imgicon,
			'BROKER-NAME'		=> ucfirst($brorow['brokername']),
			'TRUCKER-NAME'		=> ucfirst($trucrow['truckername']),
			'LOAD-ID'			=> $loadsrow['load_id'],
			'PICKUP-DATE'		=> $loadsrow['pickup_date'],
			'ORIGIN'			=> $loadsrow['origin'],
			'DESTINATION'		=> $loadsrow['destination'],
			'INFO'				=>INFO_EMAIL,
			'INFO_PHONE'		=>INFO_PHONES
			);
			$broker_pattern = '[%s]';
			foreach($broker_token as $key=>$val){
			$varMap[sprintf($broker_pattern,$key)] = $val;
			}
			$broker_content = strtr($broker_email_template['content'],$varMap);
			$Global->SendEmail($_SESSIONemail,$brorow['email'],$broker_subject,$broker_content);
			//truker notification

			$trucker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
			FROM public.email_template WHERE type='delivered-notification-to-trucker'");
			$trucker_emails->execute();
			$trucker_email_template= $trucker_emails->fetch(PDO::FETCH_ASSOC);
			$subject=$trucker_email_template['subject'];
			$trucker_token = array(
			'IMGLINK'  			=> $imglink,
			'SITEURL'			=> SITEURL,
			'ICON'				=> $imgicon,
			'BROKER-NAME'		=> ucfirst($brorow['brokername']),
			'TRUCKER-NAME'		=> ucfirst($trucrow['truckername']),
			'LOAD-ID'			=> $loadsrow['load_id'],
			'PICKUP-DATE'		=> $loadsrow['pickup_date'],
			'ORIGIN'			=> $loadsrow['origin'],
			'DESTINATION'		=> $loadsrow['destination'],
			'INFO'				=> INFO_EMAIL,
			'INFO_PHONE'		=> INFO_PHONES

			);	
			$pattern = '[%s]';
			foreach($trucker_token as $key=>$val){
			$varMap[sprintf($pattern,$key)] = $val;
			}
			$content = strtr($trucker_email_template['content'],$varMap);
			$Global->SendEmail(FROM_EMAIL,$_SESSIONemail,$subject,$content);
			$aVars=array("status"=>1 , "msg"=>"Status updated successfully");
		}
	}else{
		$aVars=array("status"=>2 , "msg"=>"Invalid Token");

	}

	echo json_encode($aVars);
	exit;
	?>