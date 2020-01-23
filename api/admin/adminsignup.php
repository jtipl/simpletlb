<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
//print_r($_POST);
$user_name=isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
$password=isset($_POST['password']) ? trim($_POST['password']) : '';
$role_list=isset($_POST['role_list']) ? trim($_POST['role_list']) : '';

$check=$Global->db->prepare("SELECT count(*) FROM admin_users WHERE user_name ILIKE :user_name AND status=1");
$check->execute(array("user_name"=>$user_name));
$rowchk=$check->fetch(PDO::FETCH_ASSOC);
$check_it=$rowchk['count'];
	if(empty($user_name)){
			$aVars=array("status"=>0,"msg"=>"Please enter the User Name");
	}elseif($check_it != 0){
			 $aVars=array("status"=>0,"msg"=>"Exiting User");
	}else{

		$hashpass=$Global->PasswordHash($password);
		$role_name = $Global->db->prepare("SELECT role_name FROM roles_list WHERE status=1 and id = :role_list");
		$role_name->execute(array("role_list"=>$role_list));
		$get_names = $role_name->fetch(PDO::FETCH_ASSOC);
		$get_name= $get_names['role_name'];

		$data =  array(
			"user_type"=> $get_name,
			"user_name"=>$user_name,
			"password"=> $hashpass,
			"status"=>1
		);
		$last_id=$Global->InsertData("admin_users",$data);
		$aVars=array("status"=>1,"msg"=>"Registered Successfully");
	}
	echo json_encode($aVars);
	exit;



?>
