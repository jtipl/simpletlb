<?php
session_start();
require_once(dirname(__FILE__)."./../api/trucker/profile.php");

if(!isset($_SESSION)) $_SESSION = array(  );

class TruckerFirstProfileTest extends PHPUnit_Framework_TestCase
{
    private $truckerfirsttime;
    public static $shared_session = array(  ); 
    protected function setUp()
    {
        $this->truckerfirsttime = new TruckerFirstProfile();
        $_SESSION = TruckerFirstProfileTest::$shared_session;
    }
    protected function tearDown()
    {
        $this->truckerfirsttime = NULL;
        TruckerFirstProfileTest::$shared_session = $_SESSION;
    }
    public function testLtruckerfirsttime()
    {   

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI";

        $testdate= array(
            "confirm_pwd"=>"12345678",
            "new_pwd"=>"12345678",
            "old_pwd"=>"87654321",
            "user_id"=>250
        );
        $result=$this->initializeChangepassword($token,$testdate);
    }

    public function initializeChangepassword($token,$testdate){
        $url=SITEURL.'api/change-password';
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
        print_r($result);
    }
}



  
