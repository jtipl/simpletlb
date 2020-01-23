<?php
require_once(dirname(__FILE__)."./../api/signin.php");
class SignInTest extends PHPUnit_Framework_TestCase
{
    private $signin;
    protected function setUp()
    {
        $this->signin = new SignIn();

    }
 
    protected function tearDown()
    {
        $this->signin = NULL;
    }
 
    public function testSignIn()
    {   

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMjE1OjgxXC9sb2FkYm9hcmRcLyIsImlhdCI6MTU2ODAyODI2OSwianRpIjoiZW9aUWE2c2ZpVnA4Ums4NjlKeVJJYTNXbWs3VWNDNHQwXC8zdmt3Y0U1ams9IiwiZGF0YSI6eyJpZCI6ODMsImVtYWlsIjoic2VudGVzdEBnbWFpbC5jb20iLCJuYW1lIjoic2VudGgifX0.40jSiu4j_MEu7L3RwX3an5gL0jtQ4Xv3HtD_qiTLAfI";
        $testdate= array(
                "email"=>"ssai@gmail.com",
                "password"=>"12345678",
                "unit_test"=>1
                );

        //$result = $this->signin->LSignIn($testdate);
        //$this->assertEquals(1, $result['status']);
        $this->initializeSignin($token,$testdate);
    }
    

     public function initializeSignin($token,$testdate){
        $url=SITEURL.'api/signin';
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
        print_r($postdata);
        print_r($result);
    }

  }