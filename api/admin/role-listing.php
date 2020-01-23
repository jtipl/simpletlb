<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$check=$Global->db->prepare("SELECT * FROM users");
$check->execute();
$data=$check->fetchAll(PDO::FETCH_ASSOC);



/*
SELECT rl.role_name,map1.feature_id,map1.read,map1.creates,map1.edit FROM  roles_list rl
INNER JOIN mapping_role_feature map1 ON rl.id=map1.role_id
WHERE rl.id=77 

*/
$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';

if($action=="get-role"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$check=$Global->db->prepare("SELECT rl.role_name,map1.feature_id,map1.read,map1.creates,map1.edit 
			FROM  roles_list rl INNER JOIN mapping_role_feature map1 ON rl.id=map1.role_id
			WHERE rl.id=:id  ");
	$check->execute(array('id' => $id));
	$data=$check->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
} else if($action=="update-role"){
	$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';
	$edit_role_name = isset($_REQUEST['edit_role_name']) ? $_REQUEST['edit_role_name']: '';
	$ldatas = array("role_name"=>$edit_role_name,"updated_date"=>date("Y-m-d H:i:s"));
	$conditions =array("id"=>$id);
	$Global->UpdateData("roles_list",$ldatas,$conditions);
	$arr= array("status"=>1,"msg"=>"Role Name Updated Successfully");
	echo json_encode($arr);
}

?>