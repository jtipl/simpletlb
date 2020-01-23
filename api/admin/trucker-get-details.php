<?php

require_once("../../elements/Global.php");
$Global=new LoadBoard();

$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';

 if($action=="get_trucker_details"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';

	$check=$Global->db->prepare("SELECT *
			FROM 
			users u 
			INNER JOIN trucker t ON u.id = t.user_id 
			
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
} else if($action=="get_equipment_details"){
	$check=$Global->db->prepare("SELECT * FROM truck_type WHERE status=1 ");
	$check->execute();
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
} else if($action=="get_vehicle_details"){
	$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
	$TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];

	//echo "SELECT * FROM vehicle_details WHERE user_id=".$user_id;exit;
	$check=$Global->db->prepare("SELECT * FROM vehicle_details WHERE trucker_id=:user_id ");
	$check->execute(array("user_id"=>$user_id));
	$data=$check->fetchAll(PDO::FETCH_ASSOC);
	$arr=array("status"=>1 , "data"=>$data);
} 
echo json_encode($arr);