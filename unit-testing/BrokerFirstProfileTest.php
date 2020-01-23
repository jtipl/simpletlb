<?php
session_start();
require_once(dirname(__FILE__)."./../api/broker/profile.php");
if ( !isset( $_SESSION ) ) $_SESSION = array(  );

class BrokerFirstProfileTest extends PHPUnit_Framework_TestCase 
{
    private $brokerfirsttime;
    public static $shared_session = array(); 

    protected function setUp()
    {
        $this->brokerfirsttime = new BrokerFirstProfile();
        $_SESSION = BrokerFirstProfileTest::$shared_session;
    }
 
    protected function tearDown()
    {
        $this->brokerfirsttime = NULL;
        BrokerFirstProfileTest::$shared_session = $_SESSION;
    }
 
    public function testFirstTimeProfile()
    {   
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI";


       $testdate= array(
                "user_id"=>250,
                "phone"=>"9003188365",
                "address"=>"42 22nd Street Reisterstown",
                "country"=>231,
                "state"=>3920,
                "city"=>42671,
                "zipcode"=>99723,
                "city_name"=>"Barrow",
                "state_name"=>"Alaska",
                "unit_test"=>1,
             );
        $this->CurlBrokerFirstProfile($token,$testdate);
        //$this->brokerfirsttime->CurlMethod($token,$testdate,$url);
    }
    

    public function CurlBrokerFirstProfile($token,$testdate)
    {
        $url=SITEURL.'api/broker/profile';
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
        return $result;
    }
}

  