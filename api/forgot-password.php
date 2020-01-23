<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$email=isset($_POST['forgot_email']) ? trim($_POST['forgot_email']) : '';
$app_type=isset($_POST['app_type']) ? trim($_POST['app_type']) : '';
$apptype=strtolower($app_type);
if($apptype == "web" || $apptype == "ios" || $apptype == "android"){
	$apptype = 1;
}else{
	$apptype= 0;
}
if(empty($email)){
	$aVars=array("status"=>0,"msg"=>"Please enter the email");
}elseif(!empty($email) && $Global->EmailValidation($email)==false){
	$aVars=array("status"=>0,"msg"=>"Please enter the valid email");
}elseif(empty($app_type)){
			$aVars=array("status"=>0,"msg"=>"Please enter the app type");
}elseif(!empty($app_type) && $apptype == 0 ){
			$aVars=array("status"=>0,"msg"=>"Please enter the valid app type");
}elseif(!empty($email) && $Global->EmailValidation($email)==true){
	$datas=array(
		"email"=>$email,
		);
	//Email Exists check
	$check=$Global->db->prepare("SELECT id,name,user_type FROM users WHERE email :: text ILIKE :email AND status=1");
	$check->execute($datas);
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	if(!empty($rowchk)){
		
		
		$randomid="";
		if($app_type=="web"){
			$type='forgot-password';
		}else{
			$randomid = mt_rand(100000,999999); 
			$type='forgot-password-mobile';

			$code_update=array(
				"mobile_code"=>$randomid
			);
			$condition_code =array("id" =>$rowchk['id'],"status"=>1);
			$t=$Global->UpdateData("users",$code_update,$condition_code);
			

		}

		$emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
		FROM public.email_template WHERE type=:type");
		$emails->execute(array("type"=>$type));
		$email_template= $emails->fetch(PDO::FETCH_ASSOC);

		$link=SITEURL."app/reset-password?e=".urlencode($Global->encode($email));
		$year=date('Y');
		$subject=$email_template['subject'];

		$imglink=SITEURL."app/assets/brand/logo.png";

		$token = array(
		'LINK' => $link,
		'IMGLINK'  => $imglink,
		'SITEURL'=> SITEURL,
		'USER_NAME'=>ucfirst($rowchk['name']),
		'CODE'=>$randomid,
		'INFO'=>INFO_EMAIL,
		'INFO_PHONE'=>INFO_PHONES
		/*'SITE_YEAR' =>$year,
		'USER_TYPE'=> "Broker",*/

		);             
		$pattern = '[%s]';
		foreach($token as $key=>$val){
			$varMap[sprintf($pattern,$key)] = $val;
		}
		$content = strtr($email_template['content'],$varMap);
		$Global->SendEmail(FROM_EMAIL,$email,$subject,$content);


	    $aVars=array("status"=>1,"msg"=>"An Email is sent with a link to reset your Password.","email"=>$email); 
      }else{
           $aVars=array("status"=>0,"msg"=>array("forgot_email"=>"There is no registered User with the Email Address " . $email));
     }
}

echo json_encode($aVars);
exit;
?>
