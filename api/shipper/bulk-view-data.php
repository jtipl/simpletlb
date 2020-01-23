<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//error_reporting(0);
//ini_set('max_execution_time', 300);
require_once("../../elements/Global.php");
$Global=new LoadBoard();
 $data=isset($_POST['data']) ? $_POST['data'] : ''; 
// print_r( $_POST['shipper_name']);exit();
   
 if(!empty($data)){
 	 foreach ($data as $key => $value){
 	 	    $user_id                  = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
        $shipper_check_id          = $Global->shipper_check($user_id);
        $orgin                    = isset($value['origin']) ? $value['origin'] : '';
        $origin_city              = isset($value['origin_city']) ? $value['origin_city'] : '';
        $origin_state             = isset($value['origin_state']) ? $value['origin_state'] : '';
        $destination              = isset($value['destination']) ? $value['destination'] : '';
        $destination_city         = isset($value['destination_city']) ? $value['destination_city'] : '';
        $destination_state        = isset($value['destination_state']) ? $value['destination_state'] : '';
        $pickup_date              = isset($value['pickup_date']) ? $value['pickup_date'] : '';
        $pickup_time              = isset($value['pickup_time']) ? $value['pickup_time'] : '';
        $delivery_date            = isset($value['delivery_date']) ? $value['delivery_date'] : '';
        $delivery_time            = isset($value['delivery_time']) ? $value['delivery_time'] : '';
        $truck_load_type          = isset($value['truck_load_type']) ? $value['truck_load_type'] : '';
        $weight                   = isset($value['weight']) ? $value['weight'] : 0;
        $length                   = isset($value['length']) ? $value['length'] : 0;
        $height                   = isset($value['height']) ? $value['height'] : 0;
        $equipment                = isset($value['truck_name']) ? $value['truck_name'] : 0;
        $price                    = isset($value['price']) ? $value['price'] : 0;
        $app_type                 = "web";
        $origin_country_code      = 'US';
        $destination_country_code = 'US';
        $origin_postal            = 0 ;

        $origin_bulk              = isset($value['origin_bulk']) ? $value['origin_bulk'] : '';
        $destination_bulk         = isset($value['destination_bulk']) ? $value['destination_bulk'] : '';
        $shipper_name = isset($_POST['shipper_name']) ? ($_POST['shipper_name']) : '';
        $shipper_email = isset($_POST['shipper_email']) ? ($_POST['shipper_email']) : '';
        $shipper_phone = isset($_POST['shipper_phone']) ? ($_POST['shipper_phone']) : '';
     
          //echo (  $shipper_name);exit();

       
        $or_lat='';
        $or_lan='';

        $de_lat='';
        $de_lan='';
     
        if(!empty($origin_bulk)){

          if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $origin_bulk))
          {
            $latlan=findlatlan($origin_bulk);
            $orgex=explode(",", $latlan);
            $or_lat=$orgex[0];
            $or_lan=$orgex[1];
        
          }else{
            $orgex=explode(",", $origin_bulk);
            $or_lat=$orgex[0];
            $or_lan=$orgex[1];
          }
         
        }
        


         if(!empty($destination_bulk)){
         
            if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $destination_bulk))
          {
            $latlan=findlatlan($destination_bulk);
            $desex=explode(",", $latlan);
            $de_lat=$desex[0];
            $de_lan=$desex[1];
        
          }else{
            $desex=explode(",", $destination_bulk);
            $de_lat=$desex[0];
            $de_lan=$desex[1];

          }
       


        }

        $origin_lat               = $or_lat ;
        $origin_lng               = $or_lan;
        $destination_postal       = 0 ;
        $destination_lat          = $de_lat;
        $destination_lng          = $de_lan;
		  	$org_t= '40.730610';
  			$des_t= '-73.935242';

        $pdate='';
        if($pickup_date){
          $pex=explode("-", $pickup_date);
          $pdate=$pex[2].'-'.$pex[0].'-'.$pex[1];
        }

        $ddate='';
        if($delivery_date){
          $dex=explode("-", $delivery_date);
          $ddate=$dex[2].'-'.$dex[0].'-'.$dex[1];
        }
      

  		
  /*			if(!empty($org_t)){
  				$origin_postal=$org_t['postal'];
  				//$origin_lat=$org_t['latitude'];
  				//$origin_lng=$org_t['longitude'];
                $origin_lat='40.730610';
                $origin_lng='-73.935242';
  			}
  			if(!empty($des_t)){
  				$destination_postal=$org_t['postal'];
  				//$destination_lat=$org_t['latitude'];
  				//$destination_lng=$org_t['longitude'];
               $destination_lat='38.906900';
               $destination_lng='-77.048900';
  			}*/

			if($origin_country_code=='US')
			 $or_ccode='USA';
			else
			 $or_ccode=$origin_country_code;

			if($destination_country_code=='US')
			 $des_ccode='USA';
			else
			 $des_ccode=$destination_country_code;

      
       $org_code = $Global->db->prepare("SELECT abbreviation FROM zipcode WHERE state =:state LIMIT 1");
        $org_code->execute(array("state"=>$origin_state));
        $org_code_row = $org_code->fetch(PDO::FETCH_ASSOC);

        $des_code = $Global->db->prepare("SELECT abbreviation FROM zipcode WHERE state =:state LIMIT 1");
        $des_code->execute(array("state"=>$destination_state));
        $des_code_row = $des_code->fetch(PDO::FETCH_ASSOC);

      


         $orgsplit= $origin_city.', '.$org_code_row['abbreviation'].', '.$or_ccode;
        $dessplit=$destination_city.', '.$des_code_row['abbreviation'].', '.$des_ccode;
      //  $orgsplit= $origin_city.', '.$origin_state.', '.$or_ccode;
        //$dessplit=$destination_city.', '.$destination_state.', '.$des_ccode;

        $equp = $Global->db->prepare("SELECT id FROM truck_type WHERE truck_name ILIKE :truck_name");
        $equp->execute(array("truck_name"=>$equipment));
        $eqrow = $equp->fetch(PDO::FETCH_ASSOC);    
         $data =  array(
            'user_id'=>$user_id, 
            'shipper_id'=>$shipper_check_id, 
            'origin'=>$orgsplit,
            'origin_address'=>$orgin ,
            'origin_city'=>$origin_city ,
            'origin_state'=>$origin_state ,
            'origin_zipcode'=>$origin_postal ,
            'origin_country'=>'United States',//$origin_country ,
            'destination'=>$dessplit,
            'destination_address'=>$destination ,
            'destination_city'=>$destination_city ,
            'destination_state'=>$destination_state ,
            'destination_zipcode'=>$destination_postal ,
            'destination_country'=>'United States',//$destination_country ,
            'pickup_date'=>$pdate,
            'delivery_date'=>$ddate,
            'truck_load_type'=>$truck_load_type ,
            'weight'=>$weight,
            'length'=>$length,
            'height'=>$height,
            'price'=>$price ,
            'description'=>'' ,
            'truck_id'=> $eqrow['id'] ,
            'origin_lat'=>$origin_lat ,
            'origin_lng'=>$origin_lng ,
			      'destination_lat'=>$destination_lat ,
          	'destination_lng'=>$destination_lng,
            'app_type'=>$app_type,
            'created_by'=>$user_id,
            'pickup_time'=>strtoupper($pickup_time),
            'delivery_time'=>strtoupper($delivery_time)
        );
				$last_id=$Global->InsertData("loads",$data);
				$lid='';

				$code_state = $Global->db->prepare("SELECT abbreviation FROM zipcode WHERE state = :state ");
				$code_state->execute(array("state"=>$origin_state));
				$rowp = $code_state->fetch(PDO::FETCH_ASSOC);


				$code_stateo = $Global->db->prepare("SELECT abbreviation FROM zipcode WHERE state = :state ");
				$code_stateo->execute(array("state"=>$destination_state));
				$rowo = $code_stateo->fetch(PDO::FETCH_ASSOC);


				$lid=$rowp['abbreviation'].'-'.$rowo['abbreviation'].'-000'.$last_id;

				$ldatas=array(
				"load_id"=>$lid
				);

				$conditions =array("id"=>$last_id);
				$Global->UpdateData("loads",$ldatas,$conditions);
				$istatus=array(
				"status"=>1
				);
         $cont_data =  array(
            'user_id'=>$user_id, 
            'load_id'=> $last_id, 
            'name'=>$shipper_name,
            'email'=>$shipper_email,
            'phone'=>$shipper_phone,
            'status'=>1 ,       
          );
        $Global->InsertData("load_contacts",$cont_data);
        
				$conditions =array("user_id"=>$user_id, "reload_status"=> 1);
				$Global->UpdateData("temp_loads",$istatus,$conditions);

				$conditions =array("user_id"=>$user_id,"reload_status"=> 2);
				$Global->DeleteData("temp_loads",$conditions);

        $datas=array(
        "id"=>$user_id,
        );
        $check=$Global->db->prepare("SELECT name,email FROM users WHERE id=:id AND status=1");
        $check->execute($datas);
        $rowchk=$check->fetch(PDO::FETCH_ASSOC);
        $email_id=$rowchk['email'];

        $emails = $Global->db->prepare( "SELECT id, subject, content, email_notication
                FROM public.email_template WHERE type='bulk-load-notication'");
        $emails->execute();
        $email_template= $emails->fetch(PDO::FETCH_ASSOC);

        $year=date('Y');
        $subject=$email_template['subject'];

        $imglink=SITEURL."app/assets/brand/logo.png";

        $token = array(
          'IMGLINK'  => $imglink,
          'SITEURL'=> SITEURL,
          'USER_NAME'=>ucfirst($rowchk['name']),
          'LOAD_ID' => $lid,
          'ORIGIN' => $orgsplit,
          'DESTINATION' => $dessplit,
          'PICKUP_DATE' => $pickup_date,
          'INFO'=>INFO_EMAIL,
          'INFO_PHONE'=>INFO_PHONES
          /*'SITE_YEAR' =>$year,
          'USER_TYPE'=> "Broker",*/
          );  
        $pattern = '[%s]';
        foreach($token as $key=>$val){
        $varMap[sprintf($pattern,$key)] = $val;
        }
        $content = strtr($email_template['content'],$varMap);
        $Global->SendEmail(FROM_EMAIL,$email_id,$subject,$content);

 		
 	 }
 	 $aVars=array("status"=>1,"msg"=>"Upload Successfully");
 }else{
 	 $aVars=array("status"=>0,"msg"=>"Invalid data");
 }

echo json_encode($aVars);

function findlatlan($address=""){
    $userAddress = urlencode ($address);
    $aAddressData = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=".GOOGLEAPI."&address=$userAddress&sensor=false");
    $aAddressDataDecode = json_decode($aAddressData);
    $userLatitude = $aAddressDataDecode->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $userLongitude =    $aAddressDataDecode->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $userLatitude.",".$userLongitude;
}

function getZipcode($address){
if(!empty($address)){
//Formatted address
$formattedAddr = str_replace(' ','+',$address);
//Send request and receive json data by address
$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true&key=AIzaSyCZ6GJJEYGAwZHI52rud9kmsWN8t6CdvtE'); 
$output1 = json_decode($geocodeFromAddr);
//Get latitude and longitute from json data
$latitude  = $output1->results[0]->geometry->location->lat; 
$longitude = $output1->results[0]->geometry->location->lng;
//Send request and receive json data by latitude longitute
$geocodeFromLatlon = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true&key=AIzaSyCZ6GJJEYGAwZHI52rud9kmsWN8t6CdvtE');
$output2 = json_decode($geocodeFromLatlon);
if(!empty($output2)){
$addressComponents = $output2->results[0]->address_components;
foreach($addressComponents as $addrComp){
if($addrComp->types[0] == 'postal_code'){
//Return the zipcode
return array(
"postal"=>$addrComp->long_name,
"latitude"=>$latitude,
"longitude"=>$longitude
);
}
}
return false;
}else{
return false;
}
}else{
return false;   
}
}


?>
