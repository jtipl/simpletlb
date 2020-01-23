<?php

require_once("../../elements/Global.php");
$Global=new LoadBoard();

$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';

 if($action=="get_broker_details"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';

	$check=$Global->db->prepare("SELECT *
			FROM 
			users u 
			INNER JOIN broker t ON u.id = t.user_id 
			
			WHERE u.id = :id ");
	$check->execute(array('id' => $id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);

} else if($action=="get_state_details"){
	$id = isset($_REQUEST['state_id']) ? $_REQUEST['state_id']: '';
	$check=$Global->db->prepare("SELECT * FROM states WHERE id=:id ");
	$check->execute(array('id' => $id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
} 
else if($action=="get_country_details"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$check=$Global->db->prepare("SELECT * FROM countries WHERE id=:id ");
	$check->execute(array('id' => $id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
}
else if($action=="get_state_details"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$check=$Global->db->prepare("SELECT * FROM states WHERE id=:id ");
	$check->execute(array('id' => $id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
}
else if($action=="get_city_details"){
	$city_id = isset($_REQUEST['city_id']) ? $_REQUEST['city_id']: '';
	$check=$Global->db->prepare("SELECT * FROM cities WHERE id=:city_id ");
	$check->execute(array('city_id' => $city_id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
}

echo json_encode($arr);