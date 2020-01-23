<?php
//require_once("E:/xampp/htdocs/loadboard/elements/Global.php");
require_once(dirname(__FILE__)."../../../elements/Global.php");
class BrokerSignup extends LoadBoard
{
	public function Signup($arr=array()){

		$name=isset($arr['name']) ? trim($arr['name']) : '';
		$business_email=isset($arr['email']) ? trim($arr['email']) : '';
		$password=isset($arr['password']) ? trim($arr['password']) : '';
		$confirm_pass=isset($arr['confirm_pass']) ? trim($arr['confirm_pass']) : '';
		$app_type=isset($arr['app_type']) ? trim($arr['app_type']) : '';
		$business_fullname=isset($arr['business_name']) ? trim($arr['business_name']) : '';
		$ip_address=isset($arr['ip_address']) ? trim($arr['ip_address']) : '';
		$unit_test=isset($arr['unit_test']) ? $arr['unit_test'] : '';
		$usertype=isset($arr['usertype']) ? $arr['usertype'] : '';

		//Email Exists check
		$emailcheck=parent::EmailCheck($business_email);
		$name_valid=parent::CharacterCheck($name);
		$business_fullname_valid=parent::CharacterCheck($business_fullname);
		$apptype=strtolower($app_type);
		if($apptype == "web" || $apptype == "ios" || $apptype == "android"){
			$apptype = 1;
		}else{
			$apptype= 0;
		}

		if(empty($name)){
			$aVars=array("status"=>0,"msg"=>"Please enter the Name");
		}elseif(!empty($name) && is_numeric($name)){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Name");
		}elseif(!empty($name) && $name_valid==false){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Name");
		}elseif(empty($business_fullname)){
			$aVars=array("status"=>0,"msg"=>"Please enter the business name");
		}elseif(!empty($business_fullname) && is_numeric($business_fullname)){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
		}elseif(!empty($business_fullname) && $business_fullname_valid==false){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
		}elseif(empty($business_email)){
			$aVars=array("status"=>0,"msg"=>"Please enter the business email");
		}elseif(!empty($business_email) && parent::EmailValidation($business_email)==false){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Email");
		}elseif(!empty($business_email) && parent::EmailValidation($business_email)==true && $emailcheck==false){
			$aVars=array("status"=>0, "msg"=>array("email"=>"Email Id already exists"));
		}elseif(empty($password)){
			$aVars=array("status"=>0,"msg"=>"Please enter the password");
		}elseif(!empty($password) && strlen($password)<8){
			$aVars=array("status"=>0,"msg"=>"Password must be at least 8 characters");
		}elseif(!empty($password) && strlen($password)>15){
			$aVars=array("status"=>0,"msg"=>"Password cannot be greater than 15 characters");
		}elseif(empty($confirm_pass)){
			$aVars=array("status"=>0,"msg"=>"Please enter the confirm password");
		}elseif(!empty($confirm_pass) && strlen($confirm_pass)<8){
			$aVars=array("status"=>0,"msg"=>"Password and Confirm Password mismatch");
		}elseif(!empty($confirm_pass) && strlen($confirm_pass)>15){
			$aVars=array("status"=>0,"msg"=>"Password and Confirm Password mismatch");
		}elseif(!empty($password) && !empty($confirm_pass) && $password!=$confirm_pass){
			$aVars=array("status"=>0,"msg"=>"Password and confirm password mismatch");
		}elseif(empty($app_type)){
			$aVars=array("status"=>0,"msg"=>"Please enter the app type");
		}elseif(!empty($app_type) && $apptype == 0 ){
			$aVars=array("status"=>0,"msg"=>"Please enter the valid app type");
		}elseif(empty($usertype)){
			$aVars=array("status"=>0,"msg"=>"Please enter the usertype");
		}else{
			$hashpass=parent::PasswordHash($password);
			$verification_code=parent::EmailCode();
			//Insert Datas

			$datas=array(
				"name"=>$name,
				"business_name"=>$business_fullname,
				"email"=>strtolower($business_email),
				"password"=>$hashpass,
				"verification_code"=>$verification_code,
				"app_type"=>$app_type,
				"user_type"=>"broker",
				"ip_address"=>$ip_address,
				"verification_code"=>1,
				"status"=>1,
				);

			
			$t=parent::InsertData("users",$datas);

			$email = $this->db->prepare( "SELECT id, subject, content, email_notication FROM public.email_template WHERE type='broker-verification-email'");
			$email->execute();
			$email_template= $email->fetch(PDO::FETCH_ASSOC);

			//$link=SITEURL."app/verification?email=".urlencode($business_email)."&code=".$verification_code;
			$year=date('Y');
			$subject=$email_template['subject'];
			
			$imglink=SITEURL."app/assets/brand/logo.png";
			$imgicon=SITEURL."app/assets/brand/handshake.png";

			$token = array(
				/*'LINK' => $link,*/
			    'IMGLINK'  => $imglink,
			    'ICON'  => $imgicon,
			    'SITEURL'=> SITEURL,
			    'USER_NAME'=>ucfirst($name),
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
			parent::SendEmail(FROM_EMAIL,$business_email,$subject,$content);

			$aVars=array("status"=>1,"msg"=>"Registered Successfully","user_type"=>"broker"); 	

		}

		if($unit_test==1){
			return $aVars;
		}else{
			echo json_encode($aVars);
			exit;
		}

	}
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
if(!empty($input)){
	$signupcls=new BrokerSignup();
	$signupcls->Signup($input);
}
?>