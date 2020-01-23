<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';


if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
		$card_details = $Global->db->prepare("SELECT cardnumber,id,cardtype FROM creditcard WHERE user_id =:user_id  ORDER BY id DESC");
		$card_details->execute(array(":user_id" =>$user_id ));
		$results = $card_details->fetchAll(PDO::FETCH_ASSOC);
		$data=array();
		if(!empty($results)){
			foreach ($results as $key => $value) {
				
				$cardnumber=$Global->decrypt($value['cardnumber'],$Global->Getkey());
				//$cvv=$Global->decrypt($value['cvv'],$Global->Getkey());
				$cardnumber=join(" ", str_split($cardnumber, 4));
				//$value['cvv']=$cvv;
				$value['cardnumber']= formatCreditCard(maskCreditCard($cardnumber));

				$data[]=$value;
			}
		}
	 	$aVars=array("status"=>1 , "data"=>$data);

}else{
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");

}

echo json_encode($aVars);
exit;

/**
 * Replaces all but the last for digits with x's in the given credit card number
 * @param int|string $cc The credit card number to mask
 * @return string The masked credit card number
 */
function MaskCreditCard($cc){
	// Get the cc Length
	$cc_length = strlen($cc);
	// Replace all characters of credit card except the last four and dashes
	for($i=0; $i<$cc_length-4; $i++){
		if($cc[$i] == '-'){continue;}
		$cc[$i] = 'x';
	}
	// Return the masked Credit Card #
	return $cc;
}
/**
 * Add dashes to a credit card number.
 * @param int|string $cc The credit card number to format with dashes.
 * @return string The credit card with dashes.
 */
function FormatCreditCard($cc)
{
	// Clean out extra data that might be in the cc
	$cc = str_replace(array('-',' '),'',$cc);
	// Get the CC Length
	$cc_length = strlen($cc);
	// Initialize the new credit card to contian the last four digits
	$newCreditCard = substr($cc,-4);
	// Walk backwards through the credit card number and add a dash after every fourth digit
	for($i=$cc_length-5;$i>=0;$i--){
		// If on the fourth character add a dash
		if((($i+1)-$cc_length)%4 == 0){
			$newCreditCard = '-'.$newCreditCard;
		}
		// Add the current character to the new credit card
		$newCreditCard = $cc[$i].$newCreditCard;
	}
	// Return the formatted credit card number
	return $newCreditCard;
}
?>