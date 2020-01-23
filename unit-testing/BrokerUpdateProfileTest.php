<?php
session_start();
require_once(dirname(__FILE__)."./../api/broker/update-profile.php");
if(!isset( $_SESSION ) ) $_SESSION = array();

class BrokerUpdateProfileTest extends PHPUnit_Framework_TestCase
{
    private $brokerupdatetime;
    public static $shared_session = array(  ); 

    protected function setUp()
    {
        $this->brokerupdatetime = new BrokerUpdateProfile();
        $_SESSION = BrokerUpdateProfileTest::$shared_session;
    }
 
    protected function tearDown()
    {
        $this->brokerupdatetime = NULL;
        BrokerUpdateProfileTest::$shared_session = $_SESSION;
    }
 
    public function testUpdateTimeProfile()
    {   

        $token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI";



       $testdate= array(
            "broker_addr"=>"42 22nd Street Reisterstown",
            "broker_email"=>"pandian@gmail.com",
            "broker_name"=>"James Pandiaan",
            "broker_phone"=>"9003188365",
            "business_name"=>"HTD Private LTD",
            "city"=>42671,
            "city_name"=>"Barrow",
            "country"=>231,
            "state"=>3920,
            "state_name"=>"Alaska",
            "user_id"=>250,
            "zipcode"=>99723,
            "unit_test"=>1,
        );
        //$result = $this->brokerupdatetime->BrokerUpdateTimeProfile($testdate);
        //$this->assertEquals(1, $result['status']);
       $this->CurlBrokerUpdateProfile($token,$testdate);
    }

    public function CurlBrokerUpdateProfile($token,$testdate)
    {
        $url=SITEURL.'api/broker/update-profile';
        //echo $url;exit;
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',$authorization)); 
        $result = curl_exec($ch);
        curl_close($ch);
        //print_r($postdata);
        print_r($result);
    }
}

  