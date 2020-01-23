<?php
require_once(dirname(__FILE__)."./../api/broker/signup.php");
class BrokerSignupTest extends PHPUnit_Framework_TestCase
{
    private $brokersignup;
    protected function setUp()
    {
        $this->brokersignup = new BrokerSignup();

    }
 
    protected function tearDown()
    {
        $this->brokersignup = NULL;
    }
 
    public function testSignup()
    {   
        //echo $_SERVER["REMOTE_ADDR"];exit;
        //$testdate=$_SERVER["REMOTE_ADDR"];
        $testdate= array(
                "name"=>"James Pandiaan",
                "business_name"=>"HTC Private LTD",
                "email"=>"pandian2@gmail.com",
                "password"=>"12345678",
                "confirm_pass"=>"12345678",
                "app_type"=>"web",
                "usertype"=>"broker",
                "ip_address"=>"192.168.1.132",
                "unit_test"=>1
                );
        
        $result = $this->brokersignup->Signup($testdate);
        $this->assertEquals(1, $result['status']);
    }
  }
  