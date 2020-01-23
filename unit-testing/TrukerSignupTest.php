<?php
require_once(dirname(__FILE__)."./../api/trucker/signup.php");
class TruckerSignupTest extends PHPUnit_Framework_TestCase
{
    private $truckersignup;
    protected function setUp()
    {
        $this->truckersignup = new TruckerSignup();

    }
 
    protected function tearDown()
    {
        $this->truckersignup = NULL;
    }
 
    public function testSignup()
    {   
        $testdate= array(
                "name"=>"Trucker",
                "business_name"=>"FTC Private LTD",
                "email"=>"trucker201@gmail.com",
                "password"=>"12345678",
                "confirm_pass"=>"12345678",
                "app_type"=>"web",
                "usertype"=>"trucker",
                "ip_address"=>"192.168.1.132",
                "unit_test"=>1
                );

        $result = $this->truckersignup->Signup($testdate);
        $this->assertEquals(1, $result['status']);
    }
    
  }