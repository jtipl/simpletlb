<?php
require_once("../../elements/Global.php");
require_once("../../config/vendor/autoload.php");

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\CreditCard;
use PayPal\Api\Address;
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

$clientId = CLIENTID;
$secredId = SECRET;
$sdkConfig = array( "mode" => "sandbox" , 'log.LogEnabled' => true,
        'log.FileName' => 'PayPal.log',
        'log.LogLevel' => 'DEBUG', );

$cred = new OAuthTokenCredential($clientId, $secredId, $sdkConfig);

$apiContext = new ApiContext($cred, 'Request' . time());

$apiContext->setConfig($sdkConfig);



$plan = new Plan();
$plan->setName('Trail package')
    ->setDescription('trai descripyiom')
    ->setType('FIXED');

// Set billing plan definitions
$paymentDefinition = new PaymentDefinition();
$paymentDefinition->setName('Regular Payments')
    ->setType('REGULAR')
    ->setFrequency('DAY')
    ->setFrequencyInterval('1')
    ->setCycles('3')
    ->setAmount(new Currency(array(
    'value' => 3,
    'currency' => 'USD'
)));

// Set charge models
$chargeModel = new ChargeModel();
$chargeModel->setType('SHIPPING')->setAmount(new Currency(array(
    'value' => 1,
    'currency' => 'USD'
)));
$paymentDefinition->setChargeModels(array(
    $chargeModel
));

// Set merchant preferences
$merchantPreferences = new MerchantPreferences();
$merchantPreferences->setReturnUrl('http://192.168.1.215:81/loadboard/api/broker/payment-check?status=success')
    ->setCancelUrl('http://192.168.1.215:81/loadboard/api/broker/payment-check?status=cancel')
    ->setAutoBillAmount('yes')
    ->setInitialFailAmountAction('CONTINUE')
    ->setMaxFailAttempts('0')
    ->setSetupFee(new Currency(array(
    'value' => 1,
    'currency' => 'USD'
)));

$plan->setPaymentDefinitions(array(
    $paymentDefinition
));
$plan->setMerchantPreferences($merchantPreferences);

try {
    $createdPlan = $plan->create($apiContext);
    
    try {
        $patch = new Patch();
        $value = new PayPalModel('{"state":"ACTIVE"}');
        $patch->setOp('replace')
            ->setPath('/')
            ->setValue($value);
        $patchRequest = new PatchRequest();
        $patchRequest->addPatch($patch);
        $createdPlan->update($patchRequest, $apiContext);
        $patchedPlan = Plan::get($createdPlan->getId(), $apiContext);
      //  print_r($patchedPlan);exit;
       		

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
$address = new Address();
$address->setLine1("3909 Witmer Road");
$address->setCity("Niagara Falls");
$address->setCountryCode("US");
$address->setPostalCode("14305");
$address->setState("NY");
$address->setPhone("716-298-1822");



$card = new CreditCard();
$card->setType("visa");
$card->setNumber("4012888888881881");
$card->setExpireMonth("11");
$card->setExpireYear("2022");
$card->setFirstName("senthil");
$card->setLastName("kumar");
$card->setCvv2("321");
$card->setBillingAddress($address);


/*$response = $card->create($apiContext);
$response->id;
$cred = new OAuthTokenCredential($clientId, $secredId, $sdkConfig);
$apiContext = new ApiContext($cred, 'Request' . time());

$apiContext->setConfig($sdkConfig);

$creditCardToken = new CreditCardToken();
$creditCardToken->setCreditCardId($response->id);

$fundingInstrument = new FundingInstrument();
$fundingInstrument->setCreditCardToken($creditCardToken);*/

$fi = new FundingInstrument();
$fi->setCreditCard($card);

$payer = new Payer();
$payer->setPaymentMethod("credit_card");
$payer->setFundingInstruments(array($fi));
$agreement->setPayer($payer);

// Adding shipping details
$shippingAddress = new ShippingAddress();
$shippingAddress->setLine1('111 First Street')
    ->setCity('Saratoga')
    ->setState('CA')
    ->setPostalCode('95070')
    ->setCountryCode('US');
$agreement->setShippingAddress($shippingAddress);
$agreement = $agreement->create($apiContext);
print_r($agreement); exit();

try {
    // Create agreement
    $agreement = $agreement->create($apiContext);
    var_dump($agreement);exit;
    
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








/*
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

//$finalPayment = $payment->create($apiContext);

try {
    $payment->create($apiContext);
    echo '<pre>';
    print_r($payment);
    echo '<pre>';
    
    exit;
    if ($payment->getState() == 'approved') {
            if ($paymentType == 'fullPayment') {
                $dataPayment = array(
                    'transactionNo' => $payment->transactions[0]->related_resources[0]->sale->id,
                    'paypalTransactionDate' => $createdDate,
                    'paypalStatus' => 'completed'
                );
            }
        } else {
            $dataPayment = array(
                'transactionNo' => $payment->transactions[0]->related_resources[0]->sale->id,
                'paypalTransactionDate' => $createdDate,
                'paypalStatus' => $payment->getState()
            );
        }
        print_r($dataPayment);
        echo '<pre>';
        $id = Payments::UpdatePaymentPaypal($dataPayment);
        return true;


  
} catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode(); 
    echo $ex->getData(); 
    die($ex);
} catch (Exception $ex) {
    die($ex);
}*/
