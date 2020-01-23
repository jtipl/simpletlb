<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);
if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){
		$tripid = isset($_POST['tripid']) ? $_POST['tripid']: '';
		$reason = isset($_POST['reason']) ? $_POST['reason']: '';
		$cancel_user_id=$_POST['user_id'];


		$TruckerUserDetails = $Global->TruckerUserDetails($cancel_user_id);
		$_SESSIONname= $TruckerUserDetails['name'];
		$_SESSIONemail= $TruckerUserDetails['email'];


		if(empty($cancel_user_id)){
			$aVars=array("status"=>0,"msg"=>"User id is empty");
		}elseif(!empty($cancel_user_id) && !is_numeric($cancel_user_id)){
			$aVars=array("status"=>0,"msg"=>"Invalid user id");
		}elseif(empty($tripid)){
			$aVars=array("status"=>0,"msg"=>"Load trip id is empty");
		}elseif(!empty($tripid) && !is_numeric($tripid)){
			$aVars=array("status"=>0,"msg"=>"Load trip id Invalid");
		}elseif(empty($reason)){
			$aVars=array("status"=>0,"msg"=>"Please enter the cancel reason");
		}else{

		$trucker_details=$Global->TruckerDetails($cancel_user_id);
		$trucker_user_id=$trucker_details['id'];
		
		//Cancel Broker Email Notification
		$loadstrip = $Global->db->prepare("SELECT load_status, load_id,broker_id,shipper_id FROM loads_trip WHERE  id =:id ");
		$loadstrip->execute(array("id"=>$tripid));
		$trips = $loadstrip->fetch(PDO::FETCH_ASSOC);
		$load_id = $trips['load_id'];
		$cancel_check_status=$trips['load_status'];
	   if($cancel_check_status==2){
			$cancel_status=2;
			$trucker_status=1;

			$load_cancel_datas=array(
				"status"=>5,
				"broker_notification_view"=>0,
				"shipper_notification_view"=>0

			);
			$load_conditions =array("id"=>$load_id);
			$load_update = $Global->UpdateData("loads",$load_cancel_datas,$load_conditions);

		}else{
			$cancel_status=1;
			$trucker_status=0;
		    $cancel_truckers = $Global->db->prepare("UPDATE public.loads SET cancel_truckers = array_append(cancel_truckers,:cancel_truckers_id) WHERE id=:id");
			$cancel_truckers->execute(array("cancel_truckers_id"=>$trucker_user_id,"id"=>$load_id));
		}
		
		//Update Trip Tables load status
		$lcdatas=array(
		   // "load_status"=>5, //cancel
			"cancel_status"=>$cancel_status,
			"cancel_reason"=>$reason,
			"trucker_status"=>$trucker_status,
			"cancel_date"=>date('Y-m-d H:i:s')
		);
		$lconditions =array("id"=>$tripid);
		$Global->UpdateData("loads_trip",$lcdatas,$lconditions);

		//All denied truckers status updation
		$den_truckers = $Global->db->prepare("SELECT id FROM loads_trip WHERE  load_id =:load_id AND denied_status=1 OR cancel_status
		 IN(1,2)");
		$den_truckers->execute(array("load_id"=>$load_id));
		$den_tru_details = $den_truckers->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($den_tru_details)){
			foreach ($den_tru_details as $key => $den_tru) {
					//Denied and cancelled truckers status updation
					$dent=array(
						"history_status"=>2
						
					);
					$den_dconditions =array("id"=>$den_tru['id']);
					$Global->UpdateData("loads_trip",$dent,$den_dconditions);
			
			}
		}
		  
		 if($trips['broker_id'] !='' && $trips['broker_id'] !=0 && $trips['broker_id'] !=null){
		 	$brokerdetails = $Global->db->prepare("SELECT user_id FROM broker WHERE  id =:id ");
			$brokerdetails->execute(array("id"=>$trips['broker_id']));
			$brokdets = $brokerdetails->fetch(PDO::FETCH_ASSOC);
		 }else if($trips['shipper_id'] !='' && $trips['shipper_id'] !=0 && $trips['shipper_id'] !=null){
		 	$brokerdetails = $Global->db->prepare("SELECT user_id FROM shipper WHERE  id =:id ");
			$brokerdetails->execute(array("id"=>$trips['shipper_id']));
			$brokdets = $brokerdetails->fetch(PDO::FETCH_ASSOC);
		 }
		

		$brokfull=$Global->UserDetails($brokdets['user_id']);
		$brokername=ucfirst($brokfull['name']);
		$truckername=ucfirst($_SESSIONname);

		//Cancel Trip Broker Email Notification
		$imglink=SITEURL."app/assets/brand/logo.png";
		$imgicon=SITEURL."app/assets/brand/thumbs-up.png";
		$GetLoad=$Global->GetLoad($load_id);
		$broker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
					FROM public.email_template WHERE type='cancel-trip-broker-email'");
		$broker_emails->execute();
		$broker_email_template= $broker_emails->fetch(PDO::FETCH_ASSOC);
		$broker_subject=$broker_email_template['subject'];

		$broker_token = array(
		    'IMGLINK'  			=> $imglink,
		    'SITEURL'			=> SITEURL,
			'ICON'				=> $imgicon,
			'BROKER-NAME'		=> ucfirst($brokername),
			'TRUCKER-NAME'		=> ucfirst($truckername),
			'LOAD-ID'			=> $GetLoad['load_id'],
			'PICKUP-DATE'		=> $GetLoad['pickup_date'],
			'ORIGIN'			=> $GetLoad['origin'],
			'DESTINATION'		=> $GetLoad['destination'],
	        'INFO'				=> INFO_EMAIL,
			'INFO_PHONE'		=> INFO_PHONES
		);
		$broker_pattern = '[%s]';
		foreach($broker_token as $key=>$val){
		$varMap[sprintf($broker_pattern,$key)] = $val;
		}
		$broker_content = strtr($broker_email_template['content'],$varMap);
		$Global->SendEmail($_SESSIONemail,$brokfull['email'],$broker_subject,$broker_content);

		//Cancel Trip Trucker Email Notification
		$GetLoad=$Global->GetLoad($trips['load_id']);
		$trucker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
					FROM public.email_template WHERE type='cancel-trip-trucker-email'");
		$trucker_emails->execute();
		$trucker_email_template= $trucker_emails->fetch(PDO::FETCH_ASSOC);
		$subject=$trucker_email_template['subject'];
		 $trucker_token = array(
		    'IMGLINK'  			=> $imglink,
		    'SITEURL'			=> SITEURL,
			'ICON'				=> $imgicon,
			'BROKER-NAME'		=> ucfirst($brokername),
			'TRUCKER-NAME'		=> ucfirst($truckername),
			'LOAD-ID'			=> $GetLoad['load_id'],
			'PICKUP-DATE'		=> $GetLoad['pickup_date'],
			'ORIGIN'			=> $GetLoad['origin'],
			'DESTINATION'		=> $GetLoad['destination'],
			'INFO'				=>INFO_EMAIL,
			'INFO_PHONE'		=>INFO_PHONES
		 
		);	
		$pattern = '[%s]';
		foreach($trucker_token as $key=>$val){
		$varMap[sprintf($pattern,$key)] = $val;
		}
		$content = strtr($trucker_email_template['content'],$varMap);
		$Global->SendEmail(FROM_EMAIL,$_SESSIONemail,$subject,$content);

		//Unapproved Trucker Email Notification

		$unapprove = $Global->db->prepare("SELECT trucker_id,load_id,id FROM loads_trip WHERE  load_id =:load_id AND trucker_status=0 ");
		$unapprove->execute(array("load_id"=>$trips['load_id']));
		$unapptruckers = $unapprove->fetchAll(PDO::FETCH_ASSOC);

		if(!empty($unapptruckers)){
			foreach ($unapptruckers as $key => $tcs) {
				
				$trucker_can = $Global->db->prepare("SELECT user_id FROM trucker WHERE  id =:id ");
				$trucker_can->execute(array("id"=>$tcs['trucker_id']));
				$trucker_unapp = $trucker_can->fetch(PDO::FETCH_ASSOC);
				$unapp_truckers=$Global->TruckerUserDetails($trucker_unapp['user_id']);

				$lcdatass=array(
					"trucker_status"=>$trucker_status
				);
				$lconditionss =array("id"=>$tcs['id']);
				$Global->UpdateData("loads_trip",$lcdatass,$lconditionss);

				//Unapprove Truckers Email Notification
				$un_trucker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='cancel-trip-unapprove-trucker-email'");
				$un_trucker_emails->execute();
				$un_trucker_email_template= $un_trucker_emails->fetch(PDO::FETCH_ASSOC);
				$un_subject=$un_trucker_email_template['subject'];
				$un_trucker_token = array(
				'IMGLINK'  			=> $imglink,
				'SITEURL'			=> SITEURL,
				'ICON'				=> $imgicon,
				'BROKER-NAME'		=> ucfirst($brokername),
				'TRUCKER-NAME'		=> ucfirst($unapp_truckers['name']),
				'LOAD-ID'			=> $GetLoad['load_id'],
				'PICKUP-DATE'		=> $GetLoad['pickup_date'],
				'ORIGIN'			=> $GetLoad['origin'],
				'DESTINATION'		=> $GetLoad['destination'],
				'LOGIN-URL'			=> SITEURL,
				'INFO'				=>INFO_EMAIL,
			    'INFO_PHONE'	 	=>INFO_PHONES

				);	
				$un_pattern = '[%s]';
				foreach($un_trucker_token as $key=>$val){
				$un_varMap[sprintf($un_pattern,$key)] = $val;
				}
				$un_content = strtr($un_trucker_email_template['content'],$un_varMap);
				$Global->SendEmail(FROM_EMAIL,$unapp_truckers['email'],$un_subject,$un_content);		
			}
		}

			$aVars=array("status"=>1 , "msg"=>"Trip cancel successfully");
	}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>