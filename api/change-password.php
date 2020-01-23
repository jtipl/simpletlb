<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);
if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){
	$user_id = isset($_POST['user_id']) ? $_POST['user_id']: '';

	$old_pwd=isset($_POST['old_pwd']) ? trim($_POST['old_pwd']) : '';
	$new_pwd=isset($_POST['new_pwd']) ? trim($_POST['new_pwd']) : '';
	$confirm_pwd=isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd']) : '';

	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}if(empty($old_pwd)){
		$aVars=array("status"=>0,"msg"=>"Please enter the current password");
	}elseif(!empty($old_pwd) && strlen($old_pwd)<8){
		$aVars=array("status"=>0,"msg"=>"Password must be at least 8 characters");
	}elseif(!empty($old_pwd) && strlen($old_pwd)>15){
		$aVars=array("status"=>0,"msg"=>"Password cannot be greater than 15 characters");
	}elseif(empty($new_pwd)){
		$aVars=array("status"=>0,"msg"=>"Please enter the new password");
	}elseif(!empty($new_pwd) && strlen($new_pwd)<8){
		$aVars=array("status"=>0,"msg"=>"Password must be at least 8 characters");
	}elseif(!empty($new_pwd) && strlen($new_pwd)>15){
		$aVars=array("status"=>0,"msg"=>"Password cannot be greater than 15 characters");
	}elseif(empty($confirm_pwd)){
		$aVars=array("status"=>0,"msg"=>"Please enter the confirm new password");
	}elseif(!empty($confirm_pwd) && strlen($confirm_pwd)<8){
		$aVars=array("status"=>0,"msg"=>array("confirm_pwd"=>"Password and Confirm Password mismatch"));
	}elseif(!empty($confirm_pwd) && strlen($confirm_pwd)>15){
		$aVars=array("status"=>0,"msg"=>array("confirm_pwd"=>"Password and Confirm Password mismatch"));
	}elseif(!empty($new_pwd) && !empty($confirm_pwd) && $new_pwd!=$confirm_pwd){
		$aVars=array("status"=>0,"msg"=>array("confirm_pwd"=>"Password and Confirm Password mismatch"));
	}else{
	
	$check=$Global->db->prepare("SELECT id,email,user_type,name,password FROM users WHERE id=:user_id AND status=1");
	$check->execute(array("user_id"=>$user_id));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);
	if(password_verify($old_pwd,$rowchk['password'])){
		$hash_newpass=$Global->PasswordHash($new_pwd);
		$hash_confirpass=$Global->PasswordHash($confirm_pwd);
		if (strlen($new_pwd) >= 8 || strlen($confirm_pwd) >= 8) {
			if($new_pwd==$confirm_pwd){
				//echo $new_pwd."--".$confirm_pwd;
				$hashpass=$Global->PasswordHash($confirm_pwd);
				//echo $hashpass;
				
				$datas=array(
					"password"=>$hashpass,
					"updated_date"=>date("Y-m-d H:i:s")
				);
				$condition =array("id" => $rowchk['id'],"status"=>1);
				$Global->UpdateData("users",$datas,$condition);
				$aVars=array("status"=>1,"msg"=>" Password Changed Successfully");
			} else {
				$aVars=array("status"=>0,"msg"=>array("pwd_match"=>"New and Confirm Password not matched"));
			}
		} else {
			$aVars=array("status"=>0,"msg"=>array("confirm_pwd"=>"New and Confirm Password Minimum 8 Characters"));
		}

	} else {
		$aVars=array("status"=>0,"msg"=>array("old_pwd"=>"Current Password not matched"));
	}
  }	
} else {
	$aVars=array("status"=>0,"msg"=>"User not found");
}
echo json_encode($aVars);
exit;

?>