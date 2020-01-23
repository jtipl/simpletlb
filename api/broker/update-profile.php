<?php
//require_once("../../elements/Global.php");
require_once(dirname(__FILE__)."../../../elements/Global.php");
class BrokerUpdateProfile extends LoadBoard{

//$headers = apache_request_headers();
public function BrokerUpdateTimeProfile($arr=array()){

	$token=parent::getBearerToken();
	$CheckvalidToken=parent::CheckValidToken($token);

	if(empty($token)){
		$aVars=array("status"=>0 , "msg"=>"Empty token");
	}elseif($CheckvalidToken['status']==1){
			$user_id=isset($arr['user_id']) ? trim($arr['user_id']) : '';
			$broker_name=isset($arr['broker_name']) ? trim($arr['broker_name']) : '';
			$business=isset($arr['business_name']) ? trim($arr['business_name']) : '';
			$phone=isset($arr['broker_phone']) ? trim($arr['broker_phone']) : '';
			$address=isset($arr['broker_addr']) ? trim($arr['broker_addr']) : '';
			$city=isset($arr['city']) ? trim($arr['city']) : '';
			$state=isset($arr['state']) ? trim($arr['state']) : '';
			$zipcode=isset($arr['zipcode']) ? trim($arr['zipcode']) : '';
			$country=isset($arr['country']) ? trim($arr['country']) : '';
			$city_name=isset($arr['city_name']) ? trim($arr['city_name']) : '';
			$state_name=isset($arr['state_name']) ? trim($arr['state_name']) : '';
			$success_data=isset($arr['success_data']) ? trim($arr['success_data']) : '';
			//echo $country;exit;
			//global validation 
			$phonecheck=parent::PhoneNoCheck($phone);
			//$citycheck=$Global->CharacterCheck($city);
			$zipcheck=parent::ZipcodeCheck($zipcode);
			$zipvalid=parent::ZipValidatation($state_name,$city_name,$zipcode);
			$name_valid=parent::CharacterCheck($broker_name);
			$business_valid=parent::CharacterCheck($business);

			if(empty($user_id)){
				$aVars=array("status"=>0,"msg"=>"User id is empty");
			}elseif(!empty($user_id) && !is_numeric($user_id)){
				$aVars=array("status"=>0,"msg"=>"Invalid user id");
			}elseif(empty($broker_name)){
				$aVars=array("status"=>0,"msg"=>"Please enter the name");
			}elseif(!empty($broker_name) && is_numeric($broker_name)){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid Name");
			}elseif(!empty($broker_name) && $name_valid==false){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid Name");
			}elseif(empty($business)){
				$aVars=array("status"=>0,"msg"=>"Please enter the business name");
			}elseif(!empty($business) && is_numeric($business)){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
			}elseif(!empty($business) && $business_valid == false){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
			}else if(empty($phone)){
				$aVars=array("status"=>0,"msg"=>"Please enter a Phone Number");
			}elseif($phonecheck == false && !empty($phone)){
				$aVars=array("status"=>0,"msg"=>"Enter a Valid Phone Number");
			}elseif(empty($address)){
				$aVars=array("status"=>0,"msg"=>"Please enter the Address");
			}elseif(empty($country)){
				$aVars=array("status"=>0,"msg"=>"Please select the Country");
			}elseif(empty($state)){
				$aVars=array("status"=>0,"msg"=>"Please select the State");
			}elseif(empty($city)){
				$aVars=array("status"=>0,"msg"=>"Please select the City");
			}elseif(empty($zipcode)){
				$aVars=array("status"=>0,"msg"=>"Please enter the Zip code");
			}elseif(!empty($zipcode) && $zipvalid== false && $country=="231"){
				$aVars=array("status"=>0,"msg"=>"Enter a valid zipcode");
			}else{
				$aVars=array("status"=>3,"msg"=>"Data is valid");
		     if(!empty($success_data) && $success_data == 'valid' ){
							 $phone_no = preg_replace("/[^0-9]/", "", $phone);
							 $datas=array(
								"user_id"		=>$user_id,
								"phone"			=>$phone_no,
								"address_line1"	=>$address,
								"country"		=>$country,
								"state"			=>$state,
								"city"			=>$city,
								"zipcode"		=>$zipcode,
								"status"		=>1,
								);
							$conditions_user_id =array("user_id"=>$user_id);
							parent::UpdateData("broker",$datas,$conditions_user_id);

							//User table update
							$udatas=array(
						        "name"=>$broker_name,
						        "business_name"=>$business
						    );
						    $conditions =array("id"=>$user_id);
						    parent::UpdateData("users",$udatas,$conditions);

						    $business_email=isset($_SESSION['email']) ? trim($_SESSION['email']) : '';
						    $email = $this->db->prepare( "SELECT id, subject, content, email_notication
							FROM public.email_template WHERE type='profile-update-email'");
							$email->execute();
							$email_template= $email->fetch(PDO::FETCH_ASSOC);
							$subject=$email_template['subject'];
							$imglink=SITEURL."app/assets/brand/logo.png";
							$imgicon=SITEURL."app/assets/brand/handshake.png";

							$token = array(
								/*'LINK' => $link,*/
							    'IMGLINK'  => $imglink,
							    'ICON'  => $imgicon,
							    'SITEURL'=> SITEURL,
							    'USER-NAME'=>ucfirst($broker_name),
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

							$aVars=array("status"=>1,"msg"=>"Your profile updated successfully"); 	
		   		}
			   }

	  }else{
		$aVars=array("status"=>2 , "msg"=>"Invalid Token");
	  }

		echo json_encode($aVars);
		exit;
	}
}
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
if(!empty($input)){
	$brokerupdatetime=new BrokerUpdateProfile();
	$brokerupdatetime->BrokerUpdateTimeProfile($input);
}

?>