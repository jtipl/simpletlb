<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$check=$Global->db->prepare("SELECT * FROM users");
$check->execute();
$data=$check->fetchAll(PDO::FETCH_ASSOC);
$data=$check->fetchAll(PDO::FETCH_ASSOC);
$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';
if($action=="feature_status"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';
		if($status==0){
		$sts = 1;
	} else if($status==1){
		$sts = 0;
	}
	$ldatas = array("status"=>$sts);
	$conditions =array("id"=>$id);
	$Global->UpdateData("feature_list",$ldatas,$conditions);
	$arr= array("status"=>1,"msg"=>"Feature Status Updated Successfully");
}

echo json_encode($arr);
?>