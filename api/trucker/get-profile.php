<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
//$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	
$TruckerUserDetails = $Global->TruckerUserDetails($user_id);
$TruckerDetails = $Global->TruckerDetails($user_id);
			$country_smt = $Global->db->prepare("SELECT name FROM countries WHERE id =:con  ORDER BY id DESC");
			$country_smt->execute(array(":con" =>$TruckerDetails['country'] ));
			$country_results = $country_smt->fetch(PDO::FETCH_ASSOC);

			$state_stmt = $Global->db->prepare( "SELECT name FROM states WHERE id = :cid ORDER BY name");
			$state_stmt->execute(array(":cid"=>$TruckerDetails['state']));
			$state_results = $state_stmt->fetch(PDO::FETCH_ASSOC);

			if(!empty($TruckerDetails['vehicle_issuing_state'])){
			$veh_state_stmt = $Global->db->prepare( "SELECT name FROM states WHERE id = :cid ORDER BY name");
			$veh_state_stmt->execute(array(":cid"=>$TruckerDetails['vehicle_issuing_state']));
			$veh_state_results = $veh_state_stmt->fetch(PDO::FETCH_ASSOC);
			$veh_state_name=$veh_state_results['name'];
			}else{
				$veh_state_name='';
			}

			$city_stmt = $Global->db->prepare("SELECT name FROM cities WHERE id = :sid ORDER BY name");
			$city_stmt->execute(array(":sid"=> $TruckerDetails['city']));
			$city_results = $city_stmt->fetch(PDO::FETCH_ASSOC);


			
$aVars = array();
if($TruckerUserDetails['id']!=""){
	if($TruckerUserDetails['image']==null){
		$img="";
		$image_url="";
	}else{
		$img=$TruckerUserDetails['image'];
		$image_url=SITEURL."app/assets/uploads/original/".$img;
	}
		if($TruckerDetails['vehicle_expiry_date']==NULL || $TruckerDetails['vehicle_expiry_date']=="1969-12-31"){
			$exp_date = '';
		} else {
			$exp_date = date('m/d/Y',strtotime($TruckerDetails['vehicle_expiry_date']));
		}

		$datas = array(
				"name" => $TruckerUserDetails['name'],
				"business_name"=>$TruckerUserDetails['business_name'],
				"name" => $TruckerUserDetails['name'],
				"email" => $TruckerUserDetails['email'],
				"image" => $img ,
				"image_url" => $image_url ,
				"phone" => $TruckerDetails['phone'],
				"vehicle_num_type" => $TruckerDetails['vehicle_num_type'],
				"weight" => $TruckerDetails['vehicle_weight'],
				"length" => $TruckerDetails['vehicle_length'],
				"truck_id" => $TruckerDetails['truck_id'],
				"address_line1" => $TruckerDetails['address_line1'],
				"country" => $TruckerDetails['country'],
				"country_name" =>$country_results['name'],
				"state" => $TruckerDetails['state'],
				"state_name"=>$state_results['name'],
				"city" => $TruckerDetails['city'],
				"city_name"=>$city_results['name'],
				"zipcode" => $TruckerDetails['zipcode'],
				"vehicle_number" => $TruckerDetails['vehicle_number'],
				"account_number" => $TruckerDetails['account_number'],
				"bank_name" => $TruckerDetails['bank_name'],
				"bank_acc_holder_name" => $TruckerDetails['acc_holder_name'],
				"routing_number" => $TruckerDetails['routing_number'],
				"vehicle_licence_no" => strtoupper($TruckerDetails['vehicle_licence_no']),
				"vehicle_issuing_state" => $TruckerDetails['vehicle_issuing_state'],
				"vehicle_issuing_state_name" =>$veh_state_name,
				"vehicle_expiry_date" => $exp_date,
				 "mc_number" => $TruckerDetails['mc_number'],
                 "bank_phone_no" => $TruckerDetails["bank_phone_no"]

				);
		$aVars=$datas;
		$aVars=array("status"=>1 , "data"=>$datas);

	} else {
		$aVars=array("status"=>0 , "msg"=>"Invalid data");
	}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>