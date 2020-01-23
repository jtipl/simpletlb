<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);

if($CheckvalidToken['status']==1){
$load_id=isset($_POST['load_id']) ? trim($_POST['load_id']) : '';
$trucker_id=isset($_POST['trucker_id']) ? trim($_POST['trucker_id']) : '';
$tripid=isset($_POST['tripid']) ? trim($_POST['tripid']) : '';
$email=isset($_POST['email']) ? trim($_POST['email']) : '';
$suggest_price=isset($_POST['suggest_price']) ? trim($_POST['suggest_price']) : 0;
$suggest_comments=isset($_POST['suggest_comments']) ? trim($_POST['suggest_comments']) : '';

$trucker_email=$email;
$broker_email=isset($_SESSION['email']) ? trim($_SESSION['email']) : '';

//Load Update
$ldatas=array(
    "status"=>2,
    "approve_status"=>2,
    "suggest_price"=>$suggest_price,
    "suggest_comments"=>$suggest_comments,
   // "cancel_truckers"=>'{}'::text[],
    //"confirm_truckers_id"=> '{}'::text[]
);
$conditions =array("id"=>$load_id);
$Global->UpdateData("loads",$ldatas,$conditions);

    $empty_array_truckr_id = $Global->db->prepare("UPDATE public.loads SET  cancel_truckers='{}'::text[], 											confirm_truckers_id='{}'::text[] WHERE  id =:id ");
	$empty_array_truckr_id->execute(array("id"=>$load_id));
//Trip Update
$datas=array(
    "load_status"=>2,
    "trucker_status"=>2,
	"approval_date" =>date("Y-m-d H:i:s")
    
);
$conditions =array("id"=>$tripid);
$Global->UpdateData("loads_trip",$datas,$conditions);

	$trucker_det = $Global->db->prepare("SELECT user_id FROM trucker WHERE status = :status AND id =:id ");
	$trucker_det->execute(array("status"=>1,"id"=>$trucker_id));
	$rowtruk = $trucker_det->fetch(PDO::FETCH_ASSOC);
	$truckuserdets=$Global->TruckerUserDetails($rowtruk['user_id']);

	$broker_id= isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
	$broker_det = $Global->db->prepare("SELECT users.business_name, broker.phone FROM users LEFT JOIN broker ON users.id = broker.user_id WHERE users.status = :status AND users.id =:id AND broker.user_id = :id");
	$broker_det->execute(array("status"=>1,"id"=>$broker_id));
	$broker_dets = $broker_det->fetch(PDO::FETCH_ASSOC);
	$broker_busi_name = $broker_dets['business_name'];
	$broker_phone = $broker_dets['phone'];
	$GetLoad=$Global->GetLoad($load_id);
	$imglink=SITEURL."app/assets/brand/logo.png";
	$imgicon=SITEURL."app/assets/brand/thumbs-up.png";

//broker notication

	$broker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='thanks-confrim-mail-broker'");
	$broker_emails->execute();
	$broker_email_template= $broker_emails->fetch(PDO::FETCH_ASSOC);
	$broker_subject=$broker_email_template['subject'];
	$token = array(
	    'IMGLINK'  			=> $imglink,
	    'SITEURL'			=> SITEURL,
		'ICON'				=> $imgicon,
		'BROKER-NAME'		=> ucfirst($_SESSION['name']),
		'TRUCKER-NAME'		=> ucfirst($truckuserdets['name']),
		'LOAD-ID'			=> $GetLoad['load_id'],
		'PICKUP-DATE'		=> $GetLoad['pickup_date'],
		'ORIGIN'			=> $GetLoad['origin'],
		'DESTINATION'		=> $GetLoad['destination'],
		'INFO'				=>INFO_EMAIL,
		'INFO_PHONE'		=>INFO_PHONES
	);
	$broker_pattern = '[%s]';
	foreach($token as $key=>$val){
	$varMap[sprintf($broker_pattern,$key)] = $val;
	}
	$broker_content = strtr($broker_email_template['content'],$varMap);
	$Global->SendEmail(FROM_EMAIL,$broker_email,$broker_subject,$broker_content);

//truker notification

	$trucker_emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='approved'");
	$trucker_emails->execute();
	$trucker_email_template= $trucker_emails->fetch(PDO::FETCH_ASSOC);
	$year=date('Y');
	$subject=$trucker_email_template['subject'];



 $trucker_token = array(
    'IMGLINK'  			=> $imglink,
    'SITEURL'			=> SITEURL,
	//'BUSINESS-NAME'		=> $broker_busi_name,
	'ICON'				=> $imgicon,
	'BROKER-NAME'		=> ucfirst($_SESSION['name']),
	'TRUCKER-NAME'		=> ucfirst($truckuserdets['name']),
	'LOAD-ID'			=> $GetLoad['load_id'],
	'PICKUP-DATE'		=> $GetLoad['pickup_date'],
	'ORIGIN'			=> $GetLoad['origin'],
	'DESTINATION'		=> $GetLoad['destination'],
	'PHONE-NUMBER'		=> $broker_phone,
	'INFO'				=> INFO_EMAIL,
    'INFO_PHONE'		=> INFO_PHONES

 
);	
$pattern = '[%s]';
foreach($trucker_token as $key=>$val){
$varMap[sprintf($pattern,$key)] = $val;
}
$content = strtr($trucker_email_template['content'],$varMap);
$Global->SendEmail($broker_email,$trucker_email,$subject,$content);
//denied email
$sel = $Global->db->prepare("SELECT users.email,loads_trip.id,loads_trip.load_id,loads_trip.trucker_id FROM loads_trip INNER JOIN loads ON loads.id=loads_trip.load_id INNER JOIN  trucker ON trucker.id=loads_trip.trucker_id INNER JOIN  users ON users.id=trucker.user_id WHERE loads.id=:loadid AND loads_trip.trucker_id !=:trucker_id  AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0" );
$sel->execute(array("loadid"=>$load_id ,":trucker_id"=>$trucker_id));
$records =$sel->fetchAll(PDO::FETCH_ASSOC);

foreach ($records as $key => $value) {
	$user_tripid=$value['id'];

	//Denied status updation for unapprovred truckers
	$datas=array(
			"denied_status"=>1,
	);
	$conditions =array("id"=>$value['id']);
	$Global->UpdateData("loads_trip",$datas,$conditions);

	$trucker_det = $Global->db->prepare("SELECT user_id FROM trucker WHERE status = :status AND id =:id ");
	$trucker_det->execute(array("status"=>1,"id"=>$value['trucker_id']));
	$rowtruk = $trucker_det->fetch(PDO::FETCH_ASSOC);
	$truckuserdets=$Global->TruckerUserDetails($rowtruk['user_id']);


	$user_email=$value['email'];
	$year=date('Y');

	$emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
				FROM public.email_template WHERE type='denied'");
	$emails->execute();
	$email_template= $emails->fetch(PDO::FETCH_ASSOC);
	$subject=$email_template['subject'];

	$imglink=SITEURL."app/assets/brand/logo.png";
	$imgicon=SITEURL."app/assets/brand/alert.png";

$token = array(
    'IMGLINK'  			=> $imglink,
    'SITEURL'			=> SITEURL,
	//'BUSINESS-NAME'		=> $broker_busi_name,
	'ICON'				=> $imgicon,
	'BROKER-NAME'		=> ucfirst($_SESSION['name']),
	'TRUCKER-NAME'		=> ucfirst($truckuserdets['name']),
	'LOAD-ID'			=> $GetLoad['load_id'],
	'PICKUP-DATE'		=> $GetLoad['pickup_date'],
	'ORIGIN'			=> $GetLoad['origin'],
	'DESTINATION'		=> $GetLoad['destination'],
	'INFO'           	=>INFO_EMAIL,
	'INFO_PHONE'		=>INFO_PHONES
);	

$pattern = '[%s]';
foreach($token as $key=>$val){
$varMap[sprintf($pattern,$key)] = $val;
}
$content = strtr($email_template['content'],$varMap);
$Global->SendEmail(FROM_EMAIL,$user_email,$subject,$content);
}
$aVars=array("status"=>1,"msg"=>"Success"); 	
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
	
}


echo json_encode($aVars);
exit;

?>