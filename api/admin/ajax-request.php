<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$check=$Global->db->prepare("SELECT * FROM users");
$check->execute();
$data=$check->fetchAll(PDO::FETCH_ASSOC);
$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';
if($action=="update_status"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';
	if($status==0){
		$sts = 1;
	} else if($status==1){
		$sts = 0;
	}
	$check=$Global->db->prepare("UPDATE truck_type SET status =:status WHERE id=:id ");
	$check->execute(array('id' => $id,"status"=>$sts));
	$data=$check->fetchAll(PDO::FETCH_ASSOC);
	$arr= array("status"=>1,"msg"=>"Equipment Status Changes Successfully");
} else if($action=="add_equipment"){
	$equipment = isset($_REQUEST['equipment']) ? $_REQUEST['equipment']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';

	if(!empty($equipment)){
		$data = array("truck_name"=>$equipment,"created_date"=>date("Y-m-d H:i:s"),"status"=>$status);
		$truck_type=$Global->InsertData("truck_type",$data);
		$arr= array("status"=>1,"msg"=>"Equipment Added Successfully");
	} else {
		$arr= array("status"=>0,"msg"=>"Please Enter the truck name");
	}
} else if($action=="update_equipment"){
	$equipment = isset($_REQUEST['equipment']) ? $_REQUEST['equipment']: '';
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	if(empty($equipment)){
		$arr= array("status"=>0,"msg"=>"Please Enter the truck name");
	} else {
		$ldatas = array("truck_name"=>$equipment,"updated_date"=>date("Y-m-d H:i:s"));
		$conditions =array("id"=>$id);
		$Global->UpdateData("truck_type",$ldatas,$conditions);
		$arr= array("status"=>1,"msg"=>"Equipment Updated Successfully");
	}
} else if($action=="get-equipment"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$check=$Global->db->prepare("SELECT * FROM  truck_type WHERE id=:id ");
	$check->execute(array('id' => $id));
	$data=$check->fetch(PDO::FETCH_ASSOC);
	$truck_name=$data["truck_name"];
	$arr= array("status"=>1,"msg"=>$truck_name);
} else if($action=="trucker_status"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';
	if($status==0){
		$sts = 1;
	} else if($status==1){
		$sts = 0;
	}
	$ldatas = array("status"=>$sts);
	$conditions =array("id"=>$id);
	$Global->UpdateData("users",$ldatas,$conditions);
	$arr= array("status"=>1,"msg"=>"Trucker User Status Updated Successfully");
} else if($action=="broker_status"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';
	if($status==0){
		$sts = 1;
	} else if($status==1){
		$sts = 0;
	}
	$ldatas = array("status"=>$sts);
	$conditions =array("id"=>$id);
	$Global->UpdateData("users",$ldatas,$conditions);
	$arr= array("status"=>1,"msg"=>"Trucker User Status Updated Successfully");
} else if($action=="shipper_status"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$status = isset($_REQUEST['status']) ? $_REQUEST['status']: '';
	if($status==0){
		$sts = 1;
	} else if($status==1){
		$sts = 0;
	}
	$ldatas = array("status"=>$sts);
	$conditions =array("id"=>$id);
	$Global->UpdateData("users",$ldatas,$conditions);
	$arr= array("status"=>1,"msg"=>"Trucker User Status Updated Successfully");
} 
echo json_encode($arr);
?>