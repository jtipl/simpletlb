<?php
require_once(dirname(__FILE__)."../../../elements/Global.php");
class ShipperFirstProfile extends LoadBoard
{
	public function FirstTimeProfile($arr=array()){
		
		//$token = isset($arr['token']) ? $arr['token']: '';
		
		$headers = apache_request_headers();
		$token="";
		if(isset($headers['Authorization'])){
			$token= trim(str_replace("Bearer","",$headers['Authorization']));
		} 

		$CheckvalidToken=parent::CheckValidToken($token);

	if($CheckvalidToken['status']==1){

		$user_id=isset($arr['user_id']) ? trim($arr['user_id']) : 0;
		$phone=isset($arr['phone']) ? trim($arr['phone']) : '';
		$address=isset($arr['address']) ? trim($arr['address']) : '';
		$city=isset($arr['city']) ? trim($arr['city']) : '';
		$state=isset($arr['state']) ? trim($arr['state']) : '';
		$zipcode=isset($arr['zipcode']) ? trim($arr['zipcode']) : '';
		$country=isset($arr['country']) ? trim($arr['country']) : '';
		$city_name=isset($arr['city_name']) ? trim($arr['city_name']) : '';
		$state_name=isset($arr['state_name']) ? trim($arr['state_name']) : '';
		$unit_test=isset($arr['unit_test']) ? $arr['unit_test'] : '';


		//global validation 
		$phonecheck=parent::PhoneNoCheck($phone);
		//$citycheck=parent::CharacterCheck($city);
		$zipcheck=parent::ZipcodeCheck($zipcode);
		$zipvalid=parent::ZipValidatation($state_name,$city_name,$zipcode);
			
		if(empty($phone)){
			$aVars=array("status"=>0,"msg"=>"Phone Number cannot be empty" );
		}elseif($phonecheck == false && !empty($phone)){
			$aVars=array("status"=>0,"msg"=>"Enter a Valid Phone Number");
		}elseif($phone=='(000)-000-0000'  && !empty($phone)){
			$aVars=array("status"=>0,"msg"=>"Phone number cannot accept all zero");
		}elseif(empty($address)){
			$aVars=array("status"=>0,"msg"=>"Address cannot be empty");
		}elseif(empty($country)){
			$aVars=array("status"=>0,"msg"=>"Country cannot be empty");
		}elseif(empty($state)){
			$aVars=array("status"=>0,"msg"=>"State should not be empty");
		}elseif(empty($city)){
			$aVars=array("status"=>0,"msg"=>"City cannot be empty");
		}elseif(empty($zipcode)){
			$aVars=array("status"=>0,"msg"=>"Zip code cannot be empty");
		}elseif(!empty($zipcode) && $zipcheck== false && $country=="231"){
			$aVars=array("status"=>0,"msg"=>"Enter a valid zipcode");
		}elseif(!empty($zipcode)  && $zipvalid == false && $country=="231"){
			$aVars=array("status"=>0,"msg"=>"Enter a valid zipcode");
		}else{
			$phone_no = preg_replace("/[^0-9]/", "", $phone);
			//echo "SELECT count(*) as count FROM broker WHERE user_id=".$user_id;
			$shipper_user = $this->db->prepare("SELECT count(*) as count FROM shipper WHERE user_id=:user_id  ");
			$shipper_user->execute(array("user_id"=>$user_id));
			$row_shipper_user = $shipper_user->fetch(PDO::FETCH_ASSOC);
			$total_shipper_user = $row_shipper_user["count"]; 

			//echo $total_shipper_user;exit;
			if($total_shipper_user==0){

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

				parent::InsertData("shipper",$datas);

			} else {
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
				$lconditions =array("user_id"=>$user_id);
				parent::UpdateData("shipper",$datas,$lconditions);	
			}
			//User table update
			$ldatas=array(
		        "verified_status"=>2
		    );
		    $conditions =array("id"=>$user_id);
		    parent::UpdateData("users",$ldatas,$conditions);

			$aVars=array("status"=>1,"msg"=>"Your profile updated successfully"); 	
		   
		   }

		  }else{

			$aVars=array("status"=>2 , "msg"=>"Invalid Token");
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
	$firstime=new ShipperFirstProfile();
	$firstime->FirstTimeProfile($input);
}
exit;

?>