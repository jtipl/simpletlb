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

	$broker_id=isset($_POST['broker_id']) ? $_POST['broker_id'] : 0;
	$load_id=isset($_POST['load_id']) ? $_POST['load_id'] : '';
	$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
	$user_type=isset($_POST['user_type']) ? $_POST['user_type'] : '';
	$trucker_details=$Global->TruckerDetails($user_id);

	$check=$Global->db->prepare("SELECT user_id FROM loads WHERE id=:id");
	$check->execute(array("id"=>$load_id));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);


	$broker_udet=$Global->UserDetails($rowchk['user_id']);
	$broker_busi_name = $broker_udet['business_name'];

	$broship_user_type = $broker_udet['user_type'];

	$bro_id=0;
	$ship_id=0;
	if($broship_user_type == 'broker'){
		$bro_id=$broker_id;
	}else if($broship_user_type == 'shipper'){
		$ship_id=$broker_id;
	}

	    $TruckerUserDetails = $Global->TruckerUserDetails($user_id);
		$_SESSIONname= $TruckerUserDetails['name'];
		$_SESSIONemail= $TruckerUserDetails['email'];

	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}elseif(empty($broker_id)){
		$aVars=array("status"=>0,"msg"=>"Broker Id is empty");
	}elseif(empty($load_id)){
		$aVars=array("status"=>0,"msg"=>"Load Id is empty");
	}elseif(!empty($broker_id) && !is_numeric($broker_id)){
		$aVars=array("status"=>0,"msg"=>"Broker Id is Invalid");
	}elseif(!empty($load_id) && !is_numeric($load_id)){
		$aVars=array("status"=>0,"msg"=>"Load Id is Invalid");
	}else{

	//Cancel loads search list update is delete status for duplicate issue
	
	$alr_check = $Global->db->prepare("SELECT id,trucker_id FROM public.loads_trip WHERE trucker_id=:trucker_id AND load_id=:load_id AND (cancel_status=1 AND trucker_status=0 AND is_delete=0) OR (cancel_status=2 AND trucker_status=1 AND is_delete=0) OR (denied_status=1 AND trucker_status=1 AND is_delete=0)");
	$alr_check->execute(array("trucker_id"=>$trucker_details['id'],"load_id"=>$load_id));
	$is_del= $alr_check->fetch(PDO::FETCH_ASSOC);
	if(!empty($is_del)){
		//foreach ($is_del as $key => $isdel) {
			$deldata=array(
		        "is_delete"=>1	        
		    );
		    $del_conditions =array("id"=>$is_del['id']);
		    $Global->UpdateData("loads_trip",$deldata,$del_conditions);
	   // }
	}


	$datas=array(
		"load_id"		=>$load_id,
		"broker_id"		=>$bro_id,
		"shipper_id"    =>$ship_id,
		"trucker_id"	=>$trucker_details['id'],
		"load_status"	=>1,
		"trucker_status"=>1,
		"history_status"=>1,
		"user_id"		=>$user_id,
		"user_type"		=>$user_type,
		"confirm_date" =>date("Y-m-d H:i:s")
		);
	$Global->InsertData("loads_trip",$datas);

	//User table update
	/*$ldatas=array(
        "status"=>1,
        "approve_status"=>1
    );
    $conditions =array("id"=>$load_id);
    $Global->UpdateData("loads",$ldatas,$conditions);*/

     $confirm_truckers = $Global->db->prepare("UPDATE public.loads SET status=1,approve_status=1, confirm_truckers_id = array_append(confirm_truckers_id,:confirm_truckers) WHERE id=:id");
	 $confirm_truckers->execute(array("confirm_truckers"=>$trucker_details['id'],"id"=>$load_id));


//Email-Notification

    $imglink=SITEURL."app/assets/brand/logo.png";
	$imgicon=SITEURL."app/assets/brand/thumbs-up.png";
	$broker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='confirm'");
	$broker_emails->execute();
	$broker_email_template= $broker_emails->fetch(PDO::FETCH_ASSOC);
	$broker_subject=$broker_email_template['subject'];
	$GetLoad=$Global->GetLoad($load_id);

	$broker_token = array(
	    'IMGLINK'  			=> $imglink,
	    'SITEURL'			=> SITEURL,
		'ICON'				=> $imgicon,
		'BROKER-NAME'		=> ucfirst($broker_udet['name']),
		'TRUCKER-NAME'		=> ucfirst($_SESSIONname),
		'LOAD-ID'			=> $GetLoad['load_id'],
		'PICKUP-DATE'		=> $GetLoad['pickup_date'],
		'ORIGIN'			=> $GetLoad['origin'],
		'DESTINATION'		=> $GetLoad['destination'],
		'INFO'				=>INFO_EMAIL,
		'INFO_PHONE'		=>INFO_PHONES
	);
	$broker_pattern = '[%s]';
	foreach($broker_token as $key=>$val){
	$varMap[sprintf($broker_pattern,$key)] = $val;
	}
	$broker_content = strtr($broker_email_template['content'],$varMap);
	$Global->SendEmail($_SESSIONemail,$broker_udet['email'],$broker_subject,$broker_content);
	//truker notification

	$trucker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='thanks-truker-approved-load'");
	$trucker_emails->execute();
	$trucker_email_template= $trucker_emails->fetch(PDO::FETCH_ASSOC);
	$year=date('Y');
	$subject=$trucker_email_template['subject'];



	 $trucker_token = array(
	    'IMGLINK'  			=> $imglink,
	    'SITEURL'			=> SITEURL,
		'BUSINESS-NAME'		=> $broker_busi_name,
		'ICON'				=> $imgicon,
		'BROKER-NAME'		=> ucfirst($broker_udet['name']),
		'TRUCKER-NAME'		=> ucfirst($_SESSIONname),
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

		$aVars=array("status"=>1,"msg"=>"Confirmed Successfully"); 
	}

}else{
	$aVars=array("status"=>2,"msg"=>"Invalid Token");
}


echo json_encode($aVars);
exit;

?>

