<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$check=$Global->db->prepare("SELECT origin,origin_lat,origin_lng,origin_state FROM loads WHERE user_id=:user_id");
$check->execute(array("user_id"=>$user_id));
$rowchk=$check->fetchAll(PDO::FETCH_ASSOC);
$arr=array();
if(!empty($rowchk)){
	foreach ($rowchk as $key => $value) {
		$sel = $Global->db->prepare("SELECT count(*)  FROM loads WHERE origin_state=:origin_state");
		$sel->execute(array("origin_state"=>$value['origin_state']));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$var['title']=$value['origin'];
		$var['description']=$value['origin'];
		$var['lat']=$value['origin_lat'];
		$var['lng']=$value['origin_lng'];
		$var['load_count']=$records['count'];
		$arr[]=$var;
	}

	$arr=array("status"=>1,"data"=>$arr);
}else{
	$arr=array("status"=>0,"data"=>array());
}
echo json_encode($arr);
exit;
?>