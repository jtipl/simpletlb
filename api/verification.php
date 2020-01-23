<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();
$email=isset($_POST['email']) ? trim($_POST['email']) : '';
$code=isset($_POST['code']) ? trim($_POST['code']) : '';
$check=$Global->db->prepare("SELECT id FROM users WHERE email=:email  AND verification_code=:verification_code AND status=:status");
$check->execute(array(":email"=>$email,":verification_code"=>$code,":status"=>0));
$rowchk=$check->fetch(PDO::FETCH_ASSOC);
if(!empty($rowchk)){
	$conditions=array("id"=>$rowchk['id']);
	$data=array("status"=>1,"updated_date"=>date("Y-m-d H:i:s"),"verified_status"=>1);
	$Global->UpdateData("users",$data,$conditions);
	$aVars=array("status"=>1,"msg"=>"Email verification successfully done");	
}else{
	$aVars=array("status"=>0,"msg"=>"Invalid");
}
echo json_encode($aVars);
exit;

?>