<?php
session_start();
require_once(dirname(__FILE__)."./../api/broker/add-load.php");
if ( !isset( $_SESSION ) ) $_SESSION = array(  );

class BrokerAddLoadTest extends PHPUnit_Framework_TestCase
{
    private $AddLoad;
    public static $shared_session = array(  ); 

    protected function setUp()
    {
        $this->AddLoad = new BrokerAddLoad();
       $_SESSION = BrokerAddLoadTest::$shared_session;
    }
 
    protected function tearDown()
    {
        $this->AddLoad = NULL;
        BrokerAddLoadTest::$shared_session = $_SESSION;
    }
 
    public function testAddLoad()
    {   
      
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI";
/*
app_type    web
broker_email    pandian@gmail.com
broker_name James Pandiaan
broker_phone    (900) 318 - 8365
delivery_date   12/30/2019
delivery_hour   2
delivery_minute 00
delivery_second PM
destination Dallas, TX, USA
destination_city    Dallas
destination_country United States
destination_country_code    US
destination_lat 32.7766642
destination_lng -96.79698789999998
destination_postal  
destination_state   TX
destination_valid   
equipment   3
height  12
length  23
origin  Baltimore, MD, USA
origin_city Baltimore
origin_country  United States
origin_country_code US
origin_lat  39.2903848
origin_lng  -76.61218930000001
origin_postal   
origin_state    MD
origin_valid    
pickup_date 12/30/2019
pickup_hour 2
pickup_minute   00
pickup_second   PM
price   3000
truck_load_type FTL
user_id 250
weight  23

*/

          $testdate= array( 
"app_type"=>"web",
"broker_email"=>"pandian@gmail.com",
"broker_name"=>"James Pandiaan",
"broker_phone"=>"(900) 318 - 8365",
"delivery_date"=>"12/30/2019",
"delivery_hour"=>"2",
"delivery_minute"=>"00",
"delivery_second"=>"PM",
"destination"=>"Dallas, TX, USA",
"destination_city"=>"Dallas",
"destination_country"=>"United States",
"destination_country_code"=>"US",
"destination_lat"=>"32.7766642",
"destination_lng"=>"-96.79698789999998",
"destination_postal"=>""  ,
"destination_state"=>"TX",
"destination_valid"=>""   ,
"equipment"=>3,
"height"=>12,
"length"=>23,
"origin"=>"Baltimore, MD, USA",
"origin_city"=>"Baltimore",
"origin_country"=>"United States",
"origin_country_code"=>"US",
"origin_lat"=>"39.2903848",
"origin_lng"=>"-76.61218930000001",
"origin_postal"=>"",
"origin_state"=>"MD",
"origin_valid"=>""   ,
"pickup_date"=>"12/30/2019",
"pickup_hour"=>"2",
"pickup_minute"=>"00",
"pickup_second"=>"PM",
"price"=>3000,
"truck_load_type"=>"FTL",
"user_id"=>250,
"weight"=>23,
"unit_test"=>1
        );
        //$result = $this->AddLoad->AddLoad($testdate);
        //$this->assertEquals(1, $result['status']);
        $this->initializeAddnewload($token,$testdate);
    }


    public function initializeAddnewload($token,$testdate){
        $url=SITEURL.'api/broker/add-load';
        $data=$testdate;
        $postdata = json_encode($data);
        $authorization = "Authorization: Bearer ".$token;
        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));  
        $result = curl_exec($ch);
        curl_close($ch);
        //int_r($postdata);
        print_r($result);
    }
}

  /*
            "user_id"=>"250",
            "origin"=>"San Antonio, TX, USA",
            "destination"=>"32 Old Slip, New York, NY, USA",
            "pickup_date"=>"12/27/2019",
            "delivery_date"=>"12/27/2019",
            "weight"=>"23",
            "length"=>"23",
            "height"=>"23",
            "equipment"=>"1",
            "price"=>"2000",
            "origin_lat"=>"29.4241219",
            "origin_lng"=>"-98.49362819999999",
            "destination_lat"=>"40.7038029",
            "destination_lng"=>"-74.00803289999999",
            "pickup_hour"=>"5",
            "delivery_hour"=>"05",
            "pickup_minute"=>"00",
            "delivery_minute"=>"00",
            "pickup_second"=>"PM",
            "delivery_second"=>"AM",
            "origin_city"=>"San Antonio",
            "origin_state"=>"TX",
            "origin_country"=>"United States",
            "origin_country_code"=>"US",
            "origin_postal"=>"",
            "destination_city"=>"New York",
            "destination_state"=>"NY",
            "destination_country"=>"United States",
            "destination_country_code"=>"US",
            "destination_postal"=>"10005",
            "origin_valid"=>"",
            "destination_valid"=>"",
            "broker_name"=>"James Pandiaan",
            "broker_email"=>"pandian@gmail.com",
            "broker_phone"=>"(900) 318 - 8365",
            "app_type"=>"web",
            "truck_load_type"=>"FTL",
            */






