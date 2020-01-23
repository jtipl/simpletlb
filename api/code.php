<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$email=isset($_POST['email']) ? trim($_POST['email']) : '';
$code=isset($_POST['code']) ? trim($_POST['code']) : '';
if(empty($email)){
	$aVars=array("status"=>0,"msg"=>"Please enter the email");
}elseif(!empty($email) && $Global->EmailValidation($email)==false){
	$aVars=array("status"=>0,"msg"=>"Please enter a valid Email");
}elseif(empty($code)){
	$aVars=array("status"=>0,"msg"=>"Please enter the code");
}elseif(empty($code)){
	$aVars=array("status"=>0,"msg"=>"Please enter the code");
}elseif(!empty($code) && !is_numeric($code)){
	$aVars=array("status"=>0,"msg"=>"Invalid code");
}else{
	$check=$Global->db->prepare("SELECT id,email,user_type,name FROM users WHERE email=:email AND status=:status");
	$check->execute(array("email"=>$email,"status"=>1));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	if(!empty($rowchk)){
		$codecheck=$Global->db->prepare("SELECT id,email,user_type,name FROM users WHERE email=:email AND status=:status AND mobile_code=:mobile_code");
		$codecheck->execute(array("email"=>$email,"status"=>1,"mobile_code"=>$code));
		$coderowchk=$codecheck->fetch(PDO::FETCH_ASSOC);
		if(!empty($coderowchk)){

			$aVars=array("status"=>1,"msg"=>"Valid Code","email"=>urlencode($Global->encode($coderowchk['email']))); 	
		}else{
			$aVars=array("status"=>0,"msg"=>"Invalid Code"); 	
		}
	}else{
		$aVars=array("status"=>0,"msg"=>"User not found"); 	

	}
}


echo json_encode($aVars);
exit;
?>
