<?php
require_once("../../elements/Global.php");
require_once("../../config/vendor/autoload.php");

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\CreditCard;
use PayPal\Api\BaseAddress;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment; 
use PayPal\Api\ItemList;
use PayPal\Api\Item;

use PayPal\Api\Agreement;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Plan;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;


$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	$user_id=isset($_POST['user_id'])? $_POST['user_id'] :'';
	
	//Credit Card Details
	$card_number=isset($_POST['card_number'])?str_replace(" ", "", base64_decode(urldecode($_POST['card_number']))) :'';

	$card_holders_name=isset($_POST['card_holders_name'])? base64_decode(urldecode($_POST['card_holders_name'])) :'';
	$expiry_month=isset($_POST['expiry_month'])? base64_decode(urldecode($_POST['expiry_month'])) :'';
	$expiry_year=isset($_POST['expiry_year'])? base64_decode(urldecode($_POST['expiry_year'])) :'';
	$cvc=isset($_POST['cvc'])? base64_decode(urldecode($_POST['cvc'])) :'';
	$cardtype=isset($_POST['cardtype'])? base64_decode(urldecode($_POST['cardtype'])) :'';
	
	//Billing Details
	$billing_address=isset($_POST['pay_address'])? base64_decode(urldecode($_POST['pay_address'])) :'';
	$pay_phone=isset($_POST['pay_phone'])? base64_decode(urldecode($_POST['pay_phone'])) :'';
	$pay_country=isset($_POST['pay_country'])? base64_decode(urldecode($_POST['pay_country'])) :0;
	$pay_state=isset($_POST['pay_state'])? base64_decode(urldecode($_POST['pay_state'])) :0;
	$pay_city=isset($_POST['pay_city'])? base64_decode(urldecode($_POST['pay_city'])) :0;
	$pay_zipcode=isset($_POST['pay_zipcode'])? base64_decode(urldecode($_POST['pay_zipcode'])) :'';
	$firstname=isset($_POST['firstname'])? base64_decode(urldecode($_POST['firstname'])) :'';
	$lastname=isset($_POST['lastname'])? base64_decode(urldecode($_POST['lastname'])) :'';

	$city=isset($_POST['city'])? base64_decode(urldecode($_POST['city'])) :'';
	$state=isset($_POST['state'])? base64_decode(urldecode($_POST['state'])) :'';


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

	$zipcheck=$Global->ZipcodeCheck($pay_zipcode);
	$zipvalid=$Global->ZipValidatation($state,$city,$pay_zipcode);

	$phonecheck=$Global->PhoneNoCheck($pay_phone);

	$first_valid=$Global->CharacterCheck($firstname);
	$last_valid=$Global->CharacterCheck($lastname);

	if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}elseif(empty($firstname)){
		$aVars=array("status"=>0,"msg"=>"Please enter the first name");
	}elseif(empty($lastname)){
		$aVars=array("status"=>0,"msg"=>"Please enter the last name");
	}elseif(!empty($firstname) && $first_valid==false){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid first name");
	}elseif(empty(!$lastname) && $last_valid==false){
		$aVars=array("status"=>0,"msg"=>"Please enter the valid last name");
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
	}else if(empty($pay_phone)){
		$aVars=array("status"=>0,"msg"=>"Please enter a Phone Number");
	}elseif($phonecheck == false && !empty($pay_phone)){
		$aVars=array("status"=>0,"msg"=>"Enter a Valid Phone Number");
	}elseif(empty($pay_zipcode)){
		$aVars=array("status"=>0,"msg"=>"Please enter the Zip code");
	}elseif(!empty($pay_zipcode) && $zipvalid== false && $pay_country=="231"){
		$aVars=array("status"=>0,"msg"=>"Enter a valid zipcode");
	}else{

		$apiContext = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			CLIENTID,
			SECRET
		 )
		);

		//Create a Plan 
		$plan = new Plan();
		$plan->setName('Trial')->setDescription('Trail subscription')->setType('FIXED');
		
		// Set billing plan definitions
		$paymentDefinition = new PaymentDefinition();
		$paymentDefinition->setName('Regular Payments')
		    ->setType('REGULAR')
		    ->setFrequency('DAY')
		    ->setFrequencyInterval('1')
		    ->setCycles('3')
		    ->setAmount(new Currency(array(
		    'value' => 1,
		    'currency' => 'USD'
		)));

		// Set Merchant Preferences
		$merchantPreferences = new MerchantPreferences();
		$merchantPreferences->setReturnUrl(SITEURL.'?app/broker/broker-profile?status=success')
		->setCancelUrl(SITEURL.'?app/broker/broker-profile?status=cancel')
		->setAutoBillAmount('yes')
		->setInitialFailAmountAction('CONTINUE')
		->setMaxFailAttempts('0')
		->setSetupFee(new Currency(array(
			'value' => 1,
			'currency' => 'USD'
		)));

		$plan->setPaymentDefinitions(array($paymentDefinition));
		$plan->setMerchantPreferences($merchantPreferences);

		//Created a Subscription Plan
		try {
			$createdPlan = $plan->create($apiContext);

		try {
			$patch = new Patch();
			$value = new PayPalModel('{"state":"ACTIVE"}');
			$patch->setOp('replace')->setPath('/')->setValue($value);
			$patchRequest = new PatchRequest();
			$patchRequest->addPatch($patch);
			$createdPlan->update($patchRequest, $apiContext);
			$patchedPlan = Plan::get($createdPlan->getId(), $apiContext);
		
			//Subscription Agreement  Separate 
			
				// Create new agreement
				$startDate = date('c', time() + 3600);
				$agreement = new Agreement();
				$agreement->setName('PHP Tutorial Plan Subscription Agreement')
				->setDescription('PHP Tutorial Plan Subscription Billing Agreement')
				->setStartDate($startDate);

				// Set plan id
				$plan = new Plan();
				$plan->setId($patchedPlan->getId());
				$agreement->setPlan($plan);

				// Add payer type
				/*$payer = new Payer();
				$payer->setPaymentMethod('paypal');
				$agreement->setPayer($payer);*/
				//Add Credit Card Payment
				$sdkConfig = array( "mode" => "sandbox" , 'log.LogEnabled' => true,
				'log.FileName' => 'PayPal.log',
				'log.LogLevel' => 'DEBUG', );

				$cred = new OAuthTokenCredential(CLIENTID,SECRET,$sdkConfig);
				$apiContext = new ApiContext($cred, 'Request' . time());
				$apiContext->setConfig($sdkConfig);

				$addr = new BaseAddress();
				$addr->setLine1('7141 Bald Hill St.Sunnyvale, CA 94087');
				$addr->setCity('Los Angeles');
				$addr->setCountryCode('US');
				$addr->setPostalCode('90004');
				$addr->setState('CA');


				$card = new CreditCard();
				$card->setType("visa");
				$card->setNumber("4012888888881881");
				$card->setExpireMonth("11");
				$card->setExpireYear("2025");
				$card->setFirstName("Senthil");
				$card->setLastName("Kumar");
				$card->setBillingAddress($addr);



				$response = $card->create($apiContext);
				$response->id;
				$cred = new OAuthTokenCredential(CLIENTID,SECRET,$sdkConfig);
				$apiContext = new ApiContext($cred, 'Request' . time());

				$apiContext->setConfig($sdkConfig);

				$creditCardToken = new CreditCardToken();
				$creditCardToken->setCreditCardId($response->id);

				$fundingInstrument = new FundingInstrument();
				$fundingInstrument->setCreditCardToken($creditCardToken);

				$payer = new Payer();
				$payer->setPaymentMethod("credit_card");
				$payer->setFundingInstruments(array($fundingInstrument));

				$amount = new Amount();
				$amount->setCurrency('USD');
				$amount->setTotal(1);

				$transaction = new Transaction();
				$transaction->setAmount($amount);
				$transaction->setDescription("creating a payment with saved credit card");

				$payment = new Payment();
				$payment->setIntent("sale");
				$payment->setPayer($payer);
				$payment->setTransactions(array($transaction));






				// Adding shipping details
				$shippingAddress = new ShippingAddress();
				$shippingAddress->setLine1('111 First Street')
				->setCity('Saratoga')
				->setState('CA')
				->setPostalCode('95070')
				->setCountryCode('US');
				$agreement->setShippingAddress($shippingAddress);

				try {

					// Create agreement
					$agreement = $agreement->create($apiContext);
					// Extract approval URL to redirect user
					$approvalUrl = $agreement->getApprovalLink();
					header("Location: " . $approvalUrl);
					exit();
				} catch (PayPal\Exception\PayPalConnectionException $ex) {
					echo $ex->getCode();
					echo $ex->getData();
					die($ex);
				} catch (Exception $ex) {
					die($ex);
				}



		} catch (PayPal\Exception\PayPalConnectionException $ex) {
			echo $ex->getCode();
			echo $ex->getData();
			die($ex);
		} catch (Exception $ex) {
			die($ex);
		}
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
			echo $ex->getCode();
			echo $ex->getData();
			die($ex);
		} catch (Exception $ex) {
			die($ex);
		}

			/*$encrypted_card_numerber = $Global->encrypt($card_number,$Global->Getkey());
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
					"status"=>1
				);

		$Global->InsertData("creditcard",$datas);
		$aVars=array("status"=>1,"msg"=>"Credit card details added successfully"); 	*/
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