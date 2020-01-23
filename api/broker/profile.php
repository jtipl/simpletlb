<?php
require_once(dirname(__FILE__)."../../../elements/Global.php");

class BrokerFirstProfile extends LoadBoard
{
	public function FirstTimeProfile($arr=array()){
		
		//$token=parent::getBearerToken();
		//$CheckvalidToken=parent::CheckValidToken($token);
		//$token=isset($arr['token']) ? trim($arr['token']) : '';
		
		$token=parent::getBearerToken();
		$CheckvalidToken=parent::CheckValidToken($token);
		//print_r($CheckvalidToken);exit;
		if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
		}elseif($CheckvalidToken['status']==1){
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
			
			if(empty($user_id)){
				$aVars=array("status"=>0,"msg"=>"User id is empty");
			}elseif(!empty($user_id) && !is_numeric($user_id)){
				$aVars=array("status"=>0,"msg"=>"Invalid user id");
			}elseif(empty($phone)){
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
				$broker_user = $this->db->prepare("SELECT count(*) as count FROM broker WHERE user_id=:user_id  ");
				$broker_user->execute(array("user_id"=>$user_id));
				$row_broker_user = $broker_user->fetch(PDO::FETCH_ASSOC);
				$total_broker_user = $row_broker_user["count"]; 

				//echo $total_broker_user;exit;
				if($total_broker_user==0){

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

					parent::InsertData("broker",$datas);

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
					parent::UpdateData("broker",$datas,$lconditions);	
				}
				//User table update
				$ldatas=array(
					"verified_status"=>2
				);
				$conditions =array("id"=>$user_id);
				parent::UpdateData("users",$ldatas,$conditions);

				$aVars=array("status"=>1,"msg"=>"Your profile updated successfully"); 	
		   	}
			
		} else {
			$aVars=array("status"=>2 , "msg"=>"Invalid Token");
		}
		echo json_encode($aVars);
	}

	/*public function CurlMethod($token,$testdate,$url){
		parent::CurlMethod($token,$testdate,$url);
	}*/
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if(!empty($input)){
    $brokerfirsttime=new BrokerFirstProfile();
    $brokerfirsttime->FirstTimeProfile($input);
}
?>