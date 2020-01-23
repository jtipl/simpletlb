<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

$user_id=isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
$bank_name=isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
$bank_acc_holder_name =isset($_POST['bank_acc_holder_name']) ? trim($_POST['bank_acc_holder_name']) : '';
$accno=isset($_POST['accno']) ? trim($_POST['accno']) : '';
$routing_number=isset($_POST['routing_number']) ? trim($_POST['routing_number']) : '';
$bank_phone_no=isset($_POST['bank_phone_no']) ? trim($_POST['bank_phone_no']) : '';

//print_r($_POST);exit;
// Validate to Bank Routing Numbers
function checkRoutingNumber($routingNumber = 0) {
    $routingNumber = preg_replace('[D]', '', $routingNumber); 
    if(strlen($routingNumber) != 9) {
        return false;   
    }             
    $checkSum = 0;
    for ($i = 0, $j = strlen($routingNumber); $i < $j; $i+= 3 ) {
        $checkSum += ($routingNumber[$i] * 3);
        $checkSum += ($routingNumber[$i+1] * 7);
        $checkSum += ($routingNumber[$i+2]);
    }          
    if($checkSum != 0 and ($checkSum % 10) == 0) {
        return true;
    } else { 
        return false;
    }
}
function accNoCheck($string=""){
	 if (preg_match('/^[0-9]{7,17}$/', $string))
	        return true;
	    else
	        return false;
	}

$phonecheck=$Global->PhoneNoCheck($bank_phone_no);
$validbank_name=$Global->CharacterCheck($bank_name);
$valid_account_no=accNoCheck($accno);
$valid_rout_no=checkRoutingNumber($routing_number);
$bank_acc_holder_name_valid=$Global->CharacterCheck($bank_acc_holder_name);
if(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User ID is empty");
}elseif(!empty($user_id) && !is_numeric($user_id)){
	$aVars=array("status"=>0,"msg"=>"Invalid User ID");
}elseif(empty($bank_name)){
	$aVars=array("status"=>0,"msg"=>"Please enter the Bank Name");
}elseif(!empty($bank_name) && $validbank_name == false){
		$aVars=array("status"=>0,"msg"=>array("bank_name"=>"Enter a valid Bank Name"));
}else if(empty($bank_acc_holder_name)){
	$aVars=array("status"=>0,"msg"=>"Please enter the Bank Account Holder Name");
}else if(!empty($bank_acc_holder_name) && $bank_acc_holder_name_valid==false){
	$aVars=array("status"=>0,"msg"=>array("bank_acc_holder_name"=>"Please enter a valid  Account Holder Name"));
}elseif(empty($accno)){
	$aVars=array("status"=>0,"msg"=>"Please enter the Bank Account Number");
}elseif(!empty($accno) && $valid_account_no == false){
		$aVars=array("status"=>0,"msg"=>array("accno"=>"Enter a valid Bank Account Number"));
}elseif(empty($routing_number)){
	$aVars=array("status"=>0,"msg"=>"Please enter the Routing Transit Number");
}elseif(!empty($routing_number) && $valid_rout_no == false){
		$aVars=array("status"=>0,"msg"=>array("routing_number"=>"Please enter a valid Routing Transit Number"));
}

else if(empty($bank_phone_no)){
	$aVars=array("status"=>0,"msg"=>"Please enter the Account Holder Phone Number");
}elseif($phonecheck == false && !empty($bank_phone_no)){
	$aVars=array("status"=>0,"msg"=>"Please enter a valid Account Holder Phone Number");
}

else{
		$phone_no = preg_replace("/[^0-9]/", "", $bank_phone_no);
		$datas=array(
			"user_id"			=>$user_id,
			"bank_name"			=>$bank_name,
			"acc_holder_name"	=>strtoupper($bank_acc_holder_name),
			"account_number"	=>$accno,
			"routing_number"	=>$routing_number,
			"bank_phone_no"		=>$phone_no
			
			);
		$conditions_user_id =array("user_id"=>$user_id);
		$Global->UpdateData("trucker",$datas,$conditions_user_id);
		$aVars=array("status"=>1,"msg"=>"Trucker Bank Details Updated Successfully");
   }
}else{

	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
exit;

?>