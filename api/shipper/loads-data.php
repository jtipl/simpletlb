<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$searchval = isset($_REQUEST['q']) ? $_REQUEST['q']: '';

$searchQuery = "%";
if($searchval != ''){
	$searchQuery ="%".$searchval."%";
}
$check=$Global->db->prepare("SELECT loads.load_id,loads.id FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id WHERE loads.user_id=:user_id AND loads.load_id ::text ILIKE '%$searchval%' AND loads_trip.load_status IN (1,2,3,4) AND loads_trip.history_status=1 AND loads_trip.is_delete=0");
$check->execute(array("user_id"=>$user_id));
$rowchk=$check->fetchAll(PDO::FETCH_ASSOC);
$arr=array();
if(!empty($rowchk)){
	foreach ($rowchk as $key => $value) {
		
		$newone['id']=$value['id'];
		$newone['text']=$value['load_id'];
		$arr[]=$newone;
	}

	$arr=array("status"=>1,"items"=>$arr);
}else{
	$arr=array("status"=>0,"items"=>array());
}
echo json_encode($arr);
exit;
?>