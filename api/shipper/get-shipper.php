<?php
	require_once("../../elements/Global.php");
	$Global=new LoadBoard();
	$token=$Global->getBearerToken();
	$inputJSON = file_get_contents('php://input');
	$_POST = json_decode($inputJSON, TRUE);
	
	$CheckvalidToken=$Global->CheckValidToken($token);

	$shipper_id = isset($_POST['shipper_id']) ? $_POST['shipper_id']: '';
	if(empty($token)){
		$aVars=array("status"=>0 , "msg"=>"Empty token");
	}elseif(empty($shipper_id )){
		$aVars=array("status"=>0,"msg"=>"Broker id is empty");
	}elseif($CheckvalidToken['status']==1){
			
		$shipperdets = $Global->db->prepare("SELECT shipper.zipcode,shipper.country,shipper.state,shipper.city,shipper.phone,shipper.address_line1,shipper.user_id,cities.name AS city_name,countries.name AS country_name,states.name AS state_name,users.name ,users.email,users.business_name FROM shipper INNER JOIN users ON users.id=shipper.user_id  INNER JOIN cities ON cities.id::varchar=shipper.city INNER JOIN states ON states.id::varchar=shipper.state INNER JOIN countries ON countries.id::varchar=shipper.country WHERE users.status=1 AND shipper.status=1 AND shipper.id= :shipper_id");	
		$shipperdets->execute(array("shipper_id" =>  $shipper_id));
		$shipperpop =$shipperdets->fetch(PDO::FETCH_ASSOC);
		$aVars=array("status"=>1 , "data"=>$shipperpop);

	}else{

		$aVars=array("status"=>2 , "msg"=>"Invalid Token");
	}
	echo json_encode($aVars);
	exit;
?>