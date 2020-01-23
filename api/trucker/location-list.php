<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if($CheckvalidToken['status']==1){

	$operation=isset($input['operation']) ? trim($input['operation']) : '';
	$country_id=isset($input['country_id']) ? trim($input['country_id']) : '';
	$user_id=isset($input['user_id']) ? trim($input['user_id']) : '';
	$state_id=isset($input['state_id']) ? trim($input['state_id']) : '';
	//$zipcode=isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';

if(!empty($operation)){
	if($operation=='country_list'){
		$country_smt = $Global->db->prepare("SELECT * FROM countries WHERE id IN(231,38)  ORDER BY id DESC");
		$country_smt->execute();
		$country_res = $country_smt->fetchAll(PDO::FETCH_ASSOC);
		$aVars=array("status"=>1 , "data" =>$country_res);
	}elseif($operation === "state_list"){
		if(empty($user_id)){
			$aVars=array("status"=>0 , "msg" =>"User id is empty");
		}elseif(empty($country_id)){
			$aVars=array("status"=>0 , "msg" =>"Please enter country id");
		}elseif(!empty($country_id) && !is_numeric($country_id)){
			$aVars=array("status"=>0 , "msg" =>"Country id format invalid");
		}else{
			$state_stmt = $Global->db->prepare( "SELECT * FROM states WHERE country_id = :cid ORDER BY name");
			$state_stmt->bindValue(":cid", trim($country_id));
			$state_stmt->execute();
			$state_results = $state_stmt->fetchAll();
			$aVars=array("status"=>1 , "data" =>$state_results);
		}
		
	}elseif($operation === "city_list"){
		if(empty($user_id)){
			$aVars=array("status"=>0 , "msg" =>"User id is empty");
		}elseif(empty($state_id)){
			$aVars=array("status"=>0 , "msg" =>"Please enter state id");
		}elseif(!empty($state_id) && !is_numeric($state_id)){
			$aVars=array("status"=>0 , "msg" =>"State id format invalid");
		}else{
			$city_stmt = $Global->db->prepare("SELECT * FROM cities WHERE state_id = :sid ORDER BY name");
			$city_stmt->bindValue(":sid", trim($state_id));
			$city_stmt->execute();
			$city_results = $city_stmt->fetchAll();
			$aVars=array("status"=>1 , "data" =>$city_results);
		}

	}
}else{
	$aVars=array("status"=>0 , "msg" =>"Invalid operation");

}
}else{
	$aVars=array("status"=>2,"msg"=>"Invalid Token");

}

echo json_encode($aVars);
exit;
?>