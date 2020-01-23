<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){


	$user_id=isset($_POST['user_id'])? $_POST['user_id'] :'';
	$card_number=isset($_POST['card_number'])?str_replace(" ", "", base64_decode(urldecode($_POST['card_number']))) :'';

	$card_holders_name=isset($_POST['card_holders_name'])? base64_decode(urldecode($_POST['card_holders_name'])) :'';
	$expiry_month=isset($_POST['expiry_month'])? base64_decode(urldecode($_POST['expiry_month'])) :'';
	$expiry_year=isset($_POST['expiry_year'])? base64_decode(urldecode($_POST['expiry_year'])) :'';
	$cvc=isset($_POST['cvc'])? base64_decode(urldecode($_POST['cvc'])) :'';
	$cardtype=isset($_POST['cardtype'])? base64_decode(urldecode($_POST['cardtype'])) :'';
	$billing_address=isset($_POST['billing_address'])? base64_decode(urldecode($_POST['billing_address'])) :'';


	$expires = \DateTime::createFromFormat('my', $expiry_month.$expiry_year);
	$now     = new \DateTime();
	$expire=false;

	if ($expires < $now) 
		$expire=false;
	else	
		$expire=true;

	
	$getcheck=$Global->db->prepare("SELECT cardnumber FROM creditcard WHERE user_id=:user_id ORDER BY id DESC");
	$getcheck->execute(array("user_id"=>$user_id ));
	$getrowchk=$getcheck->fetch(PDO::FETCH_ASSOC);
	$decardnumber=$Global->decrypt($getrowchk['cardnumber'],$Global->Getkey());

	$cardvalidate=true;
	if($decardnumber==$card_number){
		$cardvalidate=false;
	}
	/*$check=$Global->db->prepare("SELECT id FROM creditcard WHERE user_id=:user_id AND cardnumber=:cardnumber");
	$check->execute(array("user_id"=>$user_id,"cardnumber"=>$card_number));
	$rowchk=$check->fetch(PDO::FETCH_ASSOC);*/

	


	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}elseif(empty($card_number)){
		$aVars=array("status"=>0,"msg"=>"Please enter the credit card number");
	}elseif(!empty($card_number) &&  !is_numeric($card_number) ){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid credit card number");
	}elseif(!empty($card_number) &&  !is_numeric($card_number) && luhn_check($card_number)==false){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid credit card number");
	}elseif(!empty($card_number) && $cardvalidate==false  ){
		$aVars=array("status"=>0,"msg"=>"Credit card number already exists");
	}elseif(empty($card_holders_name)){
		$aVars=array("status"=>0,"msg"=>"Please enter the card holder name");
	}elseif(empty($expiry_month)){
		$aVars=array("status"=>0,"msg"=>"Please enter the expire month");
	}elseif(!empty($expiry_month) && !is_numeric($expiry_month)){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid expire month");
	}elseif(empty($expiry_year)){
		$aVars=array("status"=>0,"msg"=>"Please enter the expire year");
	}elseif(!empty($expiry_year) && !is_numeric($expiry_year)){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid expire year");
	}elseif(!empty($expiry_year) && is_numeric($expiry_year) && $expire==false){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid expire year");
	}elseif(empty($cvc)){
		$aVars=array("status"=>0,"msg"=>"Please enter the cvv number");
	}elseif(!empty($cvc) && !is_numeric($cvc)){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid cvv number");
	}elseif(empty($billing_address)){
		$aVars=array("status"=>0,"msg"=>"Please enter the billing address");
	}else{
			$encrypted_card_numerber = $Global->encrypt($card_number,$Global->Getkey());
			$encrypted_cvv = $Global->encrypt($cvc,$Global->Getkey());
			$datas=array(
					"cardnumber"=>$encrypted_card_numerber,
					"cardtype"=>$cardtype,
					"cardname"=>$card_holders_name,
					"expire_month"=>$expiry_month,
					"expire_year"=>$expiry_year,
					"cvv"=>$encrypted_cvv,
					"created_by"=>$user_id,
					"user_id"=>$user_id,
					"billing_address"=>$billing_address,
					"status"=>1
				);

		$Global->InsertData("creditcard",$datas);
		$aVars=array("status"=>1,"msg"=>"Credit card details added successfully"); 	
	}
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}

function luhn_check($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number=preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length=strlen($number);
  $parity=$number_length % 2;

  // Loop through each digit and do the maths
  $total=0;
  for ($i=0; $i<$number_length; $i++) {
    $digit=$number[$i];
    // Multiply alternate digits by two
    if ($i % 2 == $parity) {
      $digit*=2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit-=9;
      }
    }
    // Total up the digits
    $total+=$digit;
  }

  // If the total mod 10 equals 0, the number is valid
  return ($total % 10 == 0) ? TRUE : FALSE;

}

echo json_encode($aVars);
exit;