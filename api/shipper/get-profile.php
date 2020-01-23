<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
//$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';


if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){


$ShipperUserDetails = $Global->ShipperUserDetails($user_id);
$ShipperDetails = $Global->ShipperDetails($user_id);


            $country_smt = $Global->db->prepare("SELECT name FROM countries WHERE id =:con  ORDER BY id DESC");
			$country_smt->execute(array(":con" =>$ShipperDetails['country'] ));
			$country_results = $country_smt->fetch(PDO::FETCH_ASSOC);

			$state_stmt = $Global->db->prepare( "SELECT name FROM states WHERE id = :cid ORDER BY name");
			$state_stmt->execute(array(":cid"=>$ShipperDetails['state']));
			$state_results = $state_stmt->fetch(PDO::FETCH_ASSOC);
			

			$city_stmt = $Global->db->prepare("SELECT name FROM cities WHERE id = :sid ORDER BY name");
			$city_stmt->execute(array(":sid"=> $ShipperDetails['city']));
			$city_results = $city_stmt->fetch(PDO::FETCH_ASSOC);

$aVars = array();
if($ShipperUserDetails['id']!=""){
	$datas = array(
			"name" => $ShipperUserDetails['name'],
			"email" => $ShipperUserDetails['email'],
			"business_name"=>$ShipperUserDetails['business_name'],
			"phone" => $ShipperDetails['phone'],
			"user_id" => $ShipperDetails['user_id'],
			"address_line1" => $ShipperDetails['address_line1'],
			"address_line2" => $ShipperDetails['address_line2'],
			"country" => $ShipperDetails['country'],
			"city" => $ShipperDetails['city'],
			"state" => $ShipperDetails['state'],
			"country_name" =>$country_results['name'],
			"state_name"=>$state_results['name'],
			"city_name"=>$city_results['name'],
			"zipcode" => $ShipperDetails['zipcode'],			
			);
	$aVars=$datas;
	$aVars=array("status"=>1 , "data"=>$datas);

} else {
	$aVars=array("status"=>0 , "msg"=>"Invalid Data");
}



}else{
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;

?>