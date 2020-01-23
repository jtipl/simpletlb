<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$email=isset($_POST['email']) ? trim($Global->decode($_POST['email'])) : '';

$password=isset($_POST['password']) ? trim($_POST['password']) : '';
$confirm_password=isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

if(empty($password)){
	$aVars=array("status"=>0,"msg"=>"Please enter the password");
}elseif(!empty($password) && strlen($password)<8){
	$aVars=array("status"=>0,"msg"=>"Password must be at least 8 characters");
}elseif(!empty($password) && strlen($password)>15){
	$aVars=array("status"=>0,"msg"=>"Password cannot be greater than 15 characters");
}elseif(empty($confirm_password)){
	$aVars=array("status"=>0,"msg"=>"Please enter the confirm password");
}elseif(!empty($confirm_password) && strlen($confirm_password)<8){
	$aVars=array("status"=>0,"msg"=>"Confirm password must be at least 8 characters");
}elseif(!empty($confirm_password) && strlen($confirm_password)>15){
	$aVars=array("status"=>0,"msg"=>"Confirm password cannot be greater than 15 characters");
}elseif(!empty($password) && !empty($confirm_password) && $password!=$confirm_password){
	$aVars=array("status"=>0,"msg"=>array("confirm_password"=>"Password and confirm password should be mismatch"));
}else{
	$check=$Global->db->prepare("SELECT id,email,user_type,name FROM users WHERE email :: text ILIKE :email AND status=:status");
	$check->execute(array("email"=>$email,"status"=>1));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	if(!empty($rowchk)){
		$hashpass=$Global->PasswordHash($password);
		$datas=array(
			"password"=>$hashpass,
			"updated_date"=>date("Y-m-d H:i:s")
		);
		$condition =array("id" => $rowchk['id'],"status"=>1);
		$Global->UpdateData("users",$datas,$condition);


		$aVars=array("status"=>1,"msg"=>"Your password was successfully changed"); 	
	}else{
		$aVars=array("status"=>0,"msg"=>"User not found"); 	
	}
	
}
echo json_encode($aVars);
exit;

?>