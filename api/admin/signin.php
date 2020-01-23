<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$user_name=isset($_POST['email']) ? trim($_POST['email']) : '';
$password=isset($_POST['password']) ? trim($_POST['password']) : '';

$check=$Global->db->prepare("SELECT id,password,user_type,user_name FROM admin_users WHERE user_name ::text ILIKE :user_name AND status=1");
$check->execute(array("user_name"=>$user_name));
$rowchk=$check->fetch(PDO::FETCH_ASSOC);
$check_user=$rowchk['user_name'];
if(empty($user_name)){
	$aVars=array("status"=>0,"msg"=>"Please enter the User Name");
}elseif(!empty($user_name) && $check_user != $user_name){
	$aVars=array("status"=>0,"msg"=>"Please enter the valid User Name");
}elseif(empty($password)){
	$aVars=array("status"=>0,"msg"=>"Please enter the password");	
}else if(!empty($user_name) && !empty($rowchk)){
	if(password_verify($password,$rowchk['password'])){
		
		$data=array(
            "id" => $rowchk['id'],
          //  "email" => $rowchk['email'],
            "user_name" => $rowchk['user_name']
          );
		session_regenerate_id();
		$token=$Global->GenerateToken($data);
		$_SESSION['user_id']=$rowchk['id'];
		$_SESSION['admin_loggedin'] = true;
	//	$_SESSION['email']=$rowchk['email'];
		$_SESSION['user_type']=$rowchk['user_type'];
		$_SESSION['admin_name']=$rowchk['user_name'];
		$_SESSION['admintoken']=$token;

		$aVars=array("status"=>1,"msg"=>"Login successfully","token"=>$token);	
	}else{
		$aVars=array("status"=>0,"msg"=>"Please enter correct password");	
	}
}else{
	$aVars=array("status"=>0,"msg"=>"User not found");	
}
echo json_encode($aVars);
exit;
?>