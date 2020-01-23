<?php
require_once(dirname(__FILE__)."../../../elements/Global.php");

class TruckerFirstProfile extends LoadBoard
{
	public function Ltruckerfirsttime($arr=array()){
		
		//$token=parent::getBearerToken();
		//$CheckvalidToken=parent::CheckValidToken($token);
		//$token=isset($arr['token']) ? trim($arr['token']) : '';
		
		$token=parent::getBearerToken();
		$CheckvalidToken=parent::CheckValidToken($token);
		//print_r($CheckvalidToken);exit;
		if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
		}elseif($CheckvalidToken['status']==1){
			$user_id=isset($arr['user_id']) ? trim($arr['user_id']) : '';
			$phone=isset($arr['phone']) ? trim($arr['phone']) : '';
			$us_dot=isset($arr['us_dot']) ? trim($arr['us_dot']) : '';
			$mc_number=isset($arr['mc_number']) ? trim($arr['mc_number']) : '';
			$max_weight=isset($arr['max_weight']) ? trim($arr['max_weight']) : '';
			$max_length=isset($arr['max_length']) ? trim($arr['max_length']) : '';
			$equipment=isset($arr['equipment']) ? $arr['equipment'] : '';


			$address=isset($arr['address']) ? trim($arr['address']) : '';
			$city=isset($arr['city']) ? trim($arr['city']) : '';
			$state=isset($arr['state']) ? trim($arr['state']) : '';
			$zipcode=isset($arr['zipcode']) ? trim($arr['zipcode']) : '';
			$country=isset($arr['country']) ? trim($arr['country']) : '';
			$city_name=isset($arr['city_name']) ? trim($arr['city_name']) : '';
			$state_name=isset($arr['state_name']) ? trim($arr['state_name']) : '';


			$vehicle_licence_no_str = isset($arr["vehicle_licence_no"]) ? $arr["vehicle_licence_no"] : '';
			$vehicle_issuing_state = isset($arr["vehicle_issuing_state"]) ? $arr["vehicle_issuing_state"] : '';
			$vehicle_expiry_date = isset($arr["vehicle_expiry_date"]) ? $arr["vehicle_expiry_date"] : '';
			$vehicle_licence_no_charactercheck = parent::alphaNumeric($vehicle_licence_no_str);

			//global validation 
			$phonecheck=parent::PhoneNoCheck($phone);
			$len_feet_check=parent::Lenthfeetset($max_length);


			$zipcheck=parent::ZipcodeCheck($zipcode);
			$zipvalid=parent::ZipValidatation($state_name,$city_name,$zipcode);

			if(empty($user_id)){
				$aVars=array("status"=>0,"msg"=>"User id is empty");
			}elseif(!empty($user_id) && !is_numeric($user_id)){
				$aVars=array("status"=>0,"msg"=>"Invalid user id");
			}elseif(empty($phone)){
				$aVars=array("status"=>0,"msg"=>"Phone Number cannot be empty");
			}elseif($phonecheck == false && !empty($phone)){
				$aVars=array("status"=>0,"msg"=>"Enter a Valid Phone Number");
			}elseif($phone=='(000)-000-0000'  && !empty($phone)){
				$aVars=array("status"=>0,"msg"=>"Phone number cannot accept all zero");
			}elseif(empty($us_dot)){
				$aVars=array("status"=>0,"msg"=>"US DOT cannot be empty");
			}elseif(!empty($us_dot) && !is_numeric($us_dot))  {
			    $aVars=array("status"=>0,"msg"=>"Enter a valid US DOT");
			}/*elseif(!empty($us_dot) && strlen($us_dot)<8){
				$aVars=array("status"=>0,"msg"=>"Enter a valid US DOT222");
			}elseif(!empty($us_dot) && strlen($us_dot)>8){
				$aVars=array("status"=>0,"msg"=>"Enter a valid US DOT");
			}elseif(!empty($vehicle_licence_no_str) && $vehicle_licence_no_charactercheck==false){
				$aVars=array("status"=>0,"msg"=>"Please Enter the Vehicle Licence Number ");
			}elseif(!empty($vehicle_licence_no_str) && empty($vehicle_issuing_state)){
				$aVars=array("status"=>0,"msg"=>"Please Select the Issuing State ");
			}elseif(!empty($vehicle_licence_no_str) && empty($vehicle_expiry_date_format)){
				$aVars=array("status"=>0,"msg"=>"Please Pick the Vehicle Expiry Date");
			}*/
			elseif(empty($address)){
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
				$aVars=array("status"=>0,"msg"=>array("zipcode"=>"Enter a valid zipcode"));
			}elseif(!empty($zipcode)  && $zipvalid == false && $country=="231"){
				$aVars=array("status"=>0,"msg"=>array("zipcode"=>"Enter a valid zipcode"));
			}


			else{
			     // $equipment_list=implode(",",$equipment);
				$phone_no = preg_replace("/[^0-9]/", "", $phone);
			     
				$vehicle_licence_no = strtoupper($vehicle_licence_no_str);

				$trucker_user = $this->db->prepare("SELECT count(*) as count FROM trucker WHERE user_id=:user_id  ");
				$trucker_user->execute(array("user_id"=>$user_id));
				$row_trucker_user = $trucker_user->fetch(PDO::FETCH_ASSOC);
				$total_trucker_user = $row_trucker_user["count"]; 

				

               	if($vehicle_licence_no=="" && $vehicle_issuing_state=="" && $vehicle_expiry_date==""){
               		$flag=1;
               	} else if($vehicle_licence_no!="" && $vehicle_issuing_state!="" && $vehicle_expiry_date!=""){
               		$flag=1;
               	}  else {
               		$flag=0;
               	}

               	//echo $flag; exit;
               	if($flag==1){
               		
               		if($vehicle_expiry_date==""){
               			$vehicle_expiry_date_format=NULL;
               		} else {
               			$vehicle_expiry_date_format=date("Y-m-d",strtotime($vehicle_expiry_date));
               		}
               		//echo $vehicle_expiry_date_format;exit;
					if($total_trucker_user==0){
						$datas=array(
							"user_id"			=>$user_id,
							"phone"				=>$phone_no,
							"vehicle_number"	=>$us_dot,
							"mc_number"			=>$mc_number,
							"status"			=>1,

							"address_line1"	=>$address,
							"country"		=>$country,
							"state"			=>$state,
							"city"			=>$city,
							"zipcode"		=>$zipcode,

							"vehicle_licence_no"=>$vehicle_licence_no,
							"vehicle_issuing_state"=>$vehicle_issuing_state,
							"vehicle_expiry_date"=>$vehicle_expiry_date_format,
						);
						parent::InsertData("trucker",$datas);
					} else {
						$datas=array(
							"user_id"			=>$user_id,
							"phone"				=>$phone_no,
							"vehicle_number"	=>$us_dot,
							"status"			=>1,

							"address_line1"	=>$address,
							"country"		=>$country,
							"state"			=>$state,
							"city"			=>$city,
							"zipcode"		=>$zipcode,
							
							"vehicle_licence_no"=>$vehicle_licence_no,
							"vehicle_issuing_state"=>$vehicle_issuing_state,
							"vehicle_expiry_date"=>$vehicle_expiry_date_format,
						);
						$llconditions =array("user_id"=>$user_id);
						parent::UpdateData("trucker",$datas,$llconditions);
					}
					//User table update
					$ldatas=array(
				        "verified_status"=>2
				    );
				    $conditions =array("id"=>$user_id);
				    parent::UpdateData("users",$ldatas,$conditions);

					$first_timepro= $this->db->prepare("SELECT id FROM trucker WHERE user_id =:user_id AND status=1");
					$first_timepro->execute(array("user_id"=>$user_id));
					$first_rowchk=$first_timepro->fetch(PDO::FETCH_ASSOC);
					if(!empty($first_rowchk)){
						$first_time=0;
					}else{
						$first_time=1;
					}
				

					$aVars=array("status"=>1,"msg"=>"Your profile updated successfully","first_profile"=>$first_time); 	
					
					//$aVars=array("status"=>1,"msg"=>"Your profile updated successfully"); 
				} else if($flag==0){
					if($vehicle_licence_no!="") {
	               		if($vehicle_issuing_state=="" || $vehicle_expiry_date == "") {
	               			$aVars=array("status"=>0,"msg"=>array("veh_issuing_state"=>"Please Select the Issuing State","veh_expiry_date"=>"Please Pick the Vehicle Expiry Date"));
	               		}
	               	}
	               	if($vehicle_issuing_state!="") {
	               		if($vehicle_licence_no=="" || $vehicle_expiry_date == "") {
	               			$aVars=array("status"=>0,"msg"=>array("veh_license_no"=>"Please Enter the Vehicle Licence Number","veh_expiry_date"=>"Please Pick the Vehicle Expiry Date"));
	               		}
	               	}
	               	if($vehicle_expiry_date!="") {
	               		if($vehicle_licence_no==""|| $vehicle_issuing_state == "") {
	               			$aVars=array("status"=>0,"msg"=>array("veh_license_no"=>"Please Enter the Vehicle Licence Number","veh_issuing_state"=>"Please Select the Issuing State"));
	               		}
	               	}
				}
			}
		} else {
			$aVars=array("status"=>2 , "msg"=>"Invalid Token");
		}
		echo json_encode($aVars);
	}
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if(!empty($input)){
    $truckerfirsttime=new TruckerFirstProfile();
    $truckerfirsttime->Ltruckerfirsttime($input);
}
?>