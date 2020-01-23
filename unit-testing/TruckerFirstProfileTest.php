<?php
session_start();
require_once(dirname(__FILE__)."./../api/trucker/profile.php");
//header("Authorization : Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI");

   


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
            "user_id"=>249,
            "phone"=>"9003278538",
            "us_dot"=>77774442,
            "mc_number"=>122,

            "address"=>"43 SPP colony ",
            "country"=>231,
            "state"=>3920,
            "city"=>42671,
            "zipcode"=>99723,
            "city_name"=>"Barrow",
            "state_name"=>"Alaska",


            "vehicle_licence_no"=>"TN05 AR 7882",
            "vehicle_issuing_state"=>3920,
            "vehicle_expiry_date"=>"05/20/2022",

            "unit_test"=>1
        );
        $result=$this->initializeTruckerFirst($token,$testdate);
    }

    public function initializeTruckerFirst($token,$testdate){
        $url=SITEURL.'api/trucker/profile';
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
        return $result;
    }
}



  
