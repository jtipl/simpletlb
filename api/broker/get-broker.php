<?php
	require_once("../../elements/Global.php");
	$Global=new LoadBoard();
	$token=$Global->getBearerToken();
	$inputJSON = file_get_contents('php://input');
	$_POST = json_decode($inputJSON, TRUE);
	
	$CheckvalidToken=$Global->CheckValidToken($token);

	$broker_id = isset($_POST['broker_id']) ? $_POST['broker_id']: '';
	if(empty($token)){
		$aVars=array("status"=>0 , "msg"=>"Empty token");
	}elseif(empty($broker_id )){
		$aVars=array("status"=>0,"msg"=>"Broker id is empty");
	}elseif($CheckvalidToken['status']==1){
			
		$brokerdets = $Global->db->prepare("SELECT broker.zipcode,broker.country,broker.state,broker.city,broker.phone,broker.address_line1,broker.user_id,cities.name AS city_name,countries.name AS country_name,states.name AS state_name,users.name ,users.email,users.business_name FROM broker INNER JOIN users ON users.id=broker.user_id  INNER JOIN cities ON cities.id::varchar=broker.city INNER JOIN states ON states.id::varchar=broker.state INNER JOIN countries ON countries.id::varchar=broker.country WHERE users.status=1 AND broker.status=1 AND broker.id= :broker_id");	
		$brokerdets->execute(array("broker_id" =>  $broker_id));
		$brokerpop =$brokerdets->fetch(PDO::FETCH_ASSOC);
		$aVars=array("status"=>1 , "data"=>$brokerpop);

	}else{

		$aVars=array("status"=>2 , "msg"=>"Invalid Token");
	}
	echo json_encode($aVars);
	exit;
?>