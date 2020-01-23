<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$email=isset($_POST['forgot_email']) ? trim($_POST['forgot_email']) : '';

if(empty($email)){
	$aVars=array("status"=>0,"msg"=>"Please enter the email");
}elseif(!empty($email) && $Global->EmailValidation($email)==false){
	$aVars=array("status"=>0,"msg"=>"Please enter the valid email");
}elseif(!empty($email) && $Global->EmailValidation($email)==true){
	$datas=array(
		"email"=>$email,
		);
	//Email Exists check
	$check=$Global->db->prepare("SELECT id,name,user_type FROM users WHERE email=:email AND status=1");
	$check->execute($datas);
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	if(!empty($rowchk)){
		

		$emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
		FROM public.email_template WHERE type='forgot-password'");
		$emails->execute();
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
		'INFO'				=>INFO_EMAIL,
		'INFO_PHONE'		=>INFO_PHONES
		/*'SITE_YEAR' =>$year,
		'USER_TYPE'=> "Broker",*/

		);             
		$pattern = '[%s]';
		foreach($token as $key=>$val){
			$varMap[sprintf($pattern,$key)] = $val;
		}
		$content = strtr($email_template['content'],$varMap);
		$Global->SendEmail(FROM_EMAIL,$email,$subject,$content);




	      	$aVars=array("status"=>1,"msg"=>"An email is sent with a link to reset your password.","email"=>$email); 
      }else{
            $aVars=array("status"=>0,"msg"=>"There is no registered user with the email address " . $email);
     }
}

echo json_encode($aVars);
exit;
?>
