<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();


$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);
if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	$user_id=isset($_POST['user_id']) ? trim($_POST['user_id']) : '';

	$trucker_name=isset($_POST['trucker_name']) ? trim($_POST['trucker_name']) : '';
	$trucker_phone=isset($_POST['trucker_phone']) ? trim($_POST['trucker_phone']) : '';
	$us_dot=isset($_POST['us_dot']) ? trim($_POST['us_dot']) : '';
	$weight=isset($_POST['weight']) ? trim($_POST['weight']) : '';
	$length=isset($_POST['length']) ? trim($_POST['length']) : '';
	$equipment = isset($_POST["equipment"]) ? $_POST["equipment"] : '';


	$address=isset($_POST['address']) ? trim($_POST['address']) : '';
	$city=isset($_POST['city']) ? trim($_POST['city']) : '';
	$state=isset($_POST['state']) ? trim($_POST['state']) : '';
	$zipcode=isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';
	$country=isset($_POST['country']) ? trim($_POST['country']) : '';
	$city_name=isset($_POST['city_name']) ? trim($_POST['city_name']) : '';
	$state_name=isset($_POST['state_name']) ? trim($_POST['state_name']) : '';

	$crop_image=isset($_POST['crop_image']) ? trim($_POST['crop_image']) : '';
	$mc_number=isset($_POST['mc_number']) ? trim($_POST['mc_number']) : '';
	$success_data=isset($_POST['success_data']) ? trim($_POST['success_data']) : '';

	

	$vehicle_licence_no_str = isset($_POST["vehicle_licence_no"]) ? $_POST["vehicle_licence_no"] : '';
	$vehicle_issuing_state = isset($_POST["vehicle_issuing_state"]) ? $_POST["vehicle_issuing_state"] : '';
	$vehicle_expiry_date = isset($_POST["vehicle_expiry_date"]) ? $_POST["vehicle_expiry_date"] : '';

	//$vehicle_expiry_date_exp = explode("/",$vehicle_expiry_date_format);
	
    
   
	//global validation 
	$phonecheck=$Global->PhoneNoCheck($trucker_phone);
	$len_feet_check=$Global->Lenthfeetset($length);


	$zipcheck=$Global->ZipcodeCheck($zipcode);
	$zipvalid=$Global->ZipValidatation($state_name,$city_name,$zipcode);

	//echo $zipcheck;exit;

	$vehicle_licence_no_charactercheck = $Global->alphaNumeric($vehicle_licence_no_str);
	$trucker_business_fullname=isset($_POST['trucker_business_name']) ? trim($_POST['trucker_business_name']) : '';
	$trucker_business_fullname_valid=$Global->CharacterCheck($trucker_business_fullname);
	$popup=false;
	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User ID is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid User ID");
	}elseif(empty($trucker_name)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Name");
	}elseif(empty($trucker_business_fullname)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Business Name");
	}elseif(!empty($trucker_business_fullname) && is_numeric($trucker_business_fullname)){
		$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
	}elseif(!empty($trucker_business_fullname) && $trucker_business_fullname_valid==false){
		$aVars=array("status"=>0,"msg"=>"Please enter a valid Business Name");
	}else if(empty($trucker_phone)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Phone Number");
	}elseif($phonecheck == false && !empty($trucker_phone)){
		$aVars=array("status"=>0,"msg"=>array("trucker_phone"=>"Please enter a valid Phone Number"));
	}elseif(empty($us_dot)){
		$aVars=array("status"=>0,"msg"=>"Please enter the US DOT Number");
	}else if(!empty($us_dot) && !is_numeric($us_dot))  {
	    $aVars=array("status"=>0,"msg"=>"Please enter a valid US DOT Number");
	}elseif(!empty($us_dot) && strlen($us_dot)<8){
		$aVars=array("status"=>0,"msg"=>"Please enter a valid US DOT Number");
	}elseif(!empty($us_dot) && strlen($us_dot)>8){
		$aVars=array("status"=>0,"msg"=>"Please enter a valid US DOT Number");
	}
	elseif(empty($address)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Address");
	}elseif(empty($country)){
		$aVars=array("status"=>0,"msg"=>"Please select the Country");
	}elseif(empty($state)){
		$aVars=array("status"=>0,"msg"=>"Please select the State");
	}elseif(empty($city)){
		$aVars=array("status"=>0,"msg"=>"Please select the City");
	}elseif(empty($zipcode)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Zip Code");
	}elseif(!empty($zipcode) && $zipcheck== false && $country=="231"){
		$aVars=array("status"=>0,"msg"=>array("zipcode"=>"Enter a valid Zipcode"));
	}elseif(!empty($zipcode)  && $zipvalid == false && $country=="231"){
		$aVars=array("status"=>0,"msg"=>array("zipcode"=>"Enter a valid Zipcode"));
	}

	/*elseif(empty($weight)){
		$aVars=array("status"=>0,"msg"=>"Weight should not be empty");
	}else if(!empty($weight) && !is_numeric($weight)){
	    $aVars=array("status"=>0,"msg"=>"Please enter the weight only numberic");
	}elseif(empty($length)){
		$aVars=array("status"=>0,"msg"=>"Length cannot be empty");
	}else if(!empty($length) && !is_numeric($length)){
	    $aVars=array("status"=>0,"msg"=>"Please enter the length only numberic");
	}else if(!empty($length) && $len_feet_check  == false){
	    $aVars=array("status"=>0,"msg"=>"Please enter the length only numberic");
	}elseif(empty($equipment)){
		$aVars=array("status"=>0,"msg"=>"Equipment should not be empty");
	}
	else if(!empty($vehicle_licence_no_str) && $vehicle_licence_no_charactercheck==false){
		$aVars=array("status"=>0,"msg"=>"Please enter the Driver License Number");
	}else if(!empty($vehicle_licence_no_str) && empty($vehicle_issuing_state)){
		$aVars=array("status"=>0,"msg"=>"Please select the License Issuing State");
	}else if(!empty($vehicle_licence_no_str) && empty($vehicle_expiry_date_format)){
		$aVars=array("status"=>0,"msg"=>"Please pick the Vehicle Expiry Date");
	}*/else{

		$vehicle_licence_no = strtoupper($vehicle_licence_no_str);

		/*foreach($equipment as $name ) {
		 if (is_array($name)) {
            if (multiKeyExists($name, $key)) {
                 $equipment[] = $name;
	            }
	        }
		}*/
	   // $equipment_val = implode(',', $equipment);
		//$imageName="";

		if($vehicle_licence_no=="" && $vehicle_issuing_state=="" && $vehicle_expiry_date==""){
       		$flag=1;
       	} else if($vehicle_licence_no!="" && $vehicle_issuing_state!="" && $vehicle_expiry_date!=""){
       		$flag=1;
       	}  else {
       		$flag=0;
       	}
       	if($flag==1){ 
       		$aVars=array("status"=>3,"msg"=>"Data is valid");
       		if(!empty($success_data) && $success_data == 'valid'){
		       		if($vehicle_expiry_date==""){
		       			$vehicle_expiry_date_format=date("Y-m-d",strtotime($vehicle_expiry_date));
		       		} else {
		       			$vehicle_expiry_date_format=date("Y-m-d",strtotime($vehicle_expiry_date));
		       		}
					if(!empty($crop_image)){
						$image_array_1 = explode(";", $crop_image);
						$image_array_2 = explode(",", $image_array_1[1]);
						$data = base64_decode($image_array_2[1]);
						$imageName = time() . '.png';
						$imageName1=DIRECTORY."app/assets/uploads/original/".$imageName;
						$imgurl=SITEURL."app/assets/uploads/original/".$imageName;
						file_put_contents($imageName1, $data);

						$udata_img=array(
							"image"=>$imageName
						);
						$condition_img =array("id"=>$user_id);
						$Global->UpdateData("users",$udata_img,$condition_img);
					}

					$phone_no = preg_replace("/[^0-9]/", "", $trucker_phone);
					$datas=array(
						"user_id"		=>$user_id,
						"phone"			=>$phone_no,
						"vehicle_number"	=>$us_dot,

						"address_line1"	=>$address,
						"country"		=>$country,
						"state"			=>$state,
						"city"			=>$city,
						"zipcode"		=>$zipcode,
						"mc_number"		=>$mc_number,
						

						"vehicle_licence_no"=>$vehicle_licence_no,
						"vehicle_issuing_state"=>$vehicle_issuing_state,
						"vehicle_expiry_date"=>$vehicle_expiry_date_format,
						);
					$conditions_user_id =array("user_id"=>$user_id);
					$Global->UpdateData("trucker",$datas,$conditions_user_id);

						//User table update
					$udatas=array(
				        "name"=>$trucker_name,
				        "business_name"=>$trucker_business_fullname
				    );
				    $conditions =array("id"=>$user_id);
				    $Global->UpdateData("users",$udatas,$conditions);

					$TruckerUserDetails = $Global->TruckerUserDetails($user_id);
					$business_email= $TruckerUserDetails['email'];
					    
				    
				    $email = $Global->db->prepare( "SELECT id, subject, content, email_notication
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
					    'USER-NAME'=>ucfirst($trucker_name),
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
					$Global->SendEmail(FROM_EMAIL,$business_email,$subject,$content);

					$aVars=array("status"=>1,"msg"=>"Trucker profile updated successfully");
				} 	
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
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;


?>