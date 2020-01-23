<?php

require_once(dirname(__FILE__)."../../../elements/Global.php");

class BrokerAddLoad extends LoadBoard
{
    public function AddLoad($arr=array()){
        
       
        
        $token=parent::getBearerToken();
        $CheckvalidToken=parent::CheckValidToken($token);
        if(empty($token)){
            $aVars=array("status"=>0 , "msg"=>"Empty token");
        }elseif($CheckvalidToken['status']==1){
            $user_id=isset($arr['user_id']) ? trim($arr['user_id']) : '';
            $orgin = isset($arr['origin']) ? trim($arr['origin']) : '';
            $destination  = isset($arr['destination']) ? trim($arr['destination']) : '';
            $pickup_date  = isset($arr["pickup_date"]) ? $arr['pickup_date'] : '';
            $delivery_date = isset($arr['delivery_date']) ? $arr['delivery_date'] : '';
            $truck_load_type = isset($arr['truck_load_type']) ? trim($arr['truck_load_type']) : '';;
            $weight = isset($arr['weight']) ? trim($arr['weight']) : 0;
            $length = isset($arr['length']) ? trim($arr['length']) : 0;
            $height = isset($arr['height']) ? trim($arr['height']) : 0;
            $price = isset($arr['price']) ? trim($arr['price']) : '';
            $equipment = isset($arr['equipment']) ? $arr['equipment'] : '';
            $description = isset($arr['description']) ? trim($arr['description']) : '';
            $app_type = isset($arr['app_type']) ? trim($arr['app_type']) : '';
            $pickup_time = isset($arr['pickup_time']) ? trim($arr['pickup_time']) : '';
            $delivery_time = isset($arr['delivery_time']) ? trim($arr['delivery_time']) : '';


            $origin_lat = isset($arr['origin_lat']) ? trim($arr['origin_lat']) : '';
            $origin_lng = isset($arr['origin_lng']) ? trim($arr['origin_lng']) : '';
            $destination_lat = isset($arr['destination_lat']) ? trim($arr['destination_lat']) : '';
            $destination_lng = isset($arr['destination_lng']) ? trim($arr['destination_lng']) : '';
             

            $origin_city = isset($arr['origin_city']) ? trim($arr['origin_city']) : '';
            $origin_state = isset($arr['origin_state']) ? trim($arr['origin_state']) : '';
            $origin_country = isset($arr['origin_country']) ? trim($arr['origin_country']) : '';
            $origin_country_code = isset($arr['origin_country_code']) ? trim($arr['origin_country_code']) : '';
            $origin_postal = isset($arr['origin_postal']) ? trim($arr['origin_postal']) : 0;
            if(empty($origin_postal))
                $origin_postal=0;


            $destination_city = isset($arr['destination_city']) ? trim($arr['destination_city']) : '';
            $destination_state = isset($arr['destination_state']) ? trim($arr['destination_state']) : '';
            $destination_country = isset($arr['destination_country']) ? trim($arr['destination_country']) : '';
            $destination_country_code = isset($arr['destination_country_code']) ? trim($arr['destination_country_code']) : '';
            $destination_postal = isset($arr['destination_postal']) ? trim($arr['destination_postal']) : 0;

            $broker_name = isset($arr['broker_name']) ? trim($arr['broker_name']) : '';
            $broker_email = isset($arr['broker_email']) ? trim($arr['broker_email']) : '';
            $broker_phone = isset($arr['broker_phone']) ? trim($arr['broker_phone']) : '';
             if(empty($destination_postal))
                $destination_postal=0;
            $pickup_date_exp = explode("-",$pickup_date);
            $delivery_date_exp = explode("-",$delivery_date);

            // Date formate to insert the values 
            if(isset($pickup_date_format)!="")
                $pickup_date_format = $pickup_date_exp[2]."-".$pickup_date_exp[1]."-".$pickup_date_exp[0];
            else
                $pickup_date_format = "";

            if(isset($delivery_date_format)!="")
                $delivery_date_format = $delivery_date_exp[2]."-".$delivery_date_exp[1]."-".$delivery_date_exp[0];
            else
                $delivery_date_format = "";

          
            $len_feet_check=parent::Lenthfeetset($length);
            $height_feet_check=parent::Lenthfeetset($length);


            $pickup_hour = $arr['pickup_hour'];
            $pickup_minute = $arr['pickup_minute'];
            $pickup_second = $arr['pickup_second'];

            $delivery_hour = $arr['delivery_hour'];
            $delivery_minute = $arr['delivery_minute'];
            $delivery_second = $arr['delivery_second'];


            $phonecheck=parent::PhoneNoCheck($broker_phone);
            $name_valid=parent::CharacterCheck($broker_name);

            if(empty($user_id)){
                $aVars=array("status"=>0,"msg"=>"User id is empty");
            }elseif(!empty($user_id) && !is_numeric($user_id)){
                $aVars=array("status"=>0,"msg"=>"Invalid user id");
            }elseif(empty($orgin)){
                 $aVars=array("status"=>0,"msg"=>"Please enter the origin");
            }else if(empty($destination)){
                $aVars=array("status"=>0,"msg"=>"Please enter the destination");
            }else if(empty($pickup_date)){
                $aVars=array("status"=>0,"msg"=>"Please enter the pickup date");
            }else if(empty($delivery_date)){
                $aVars=array("status"=>0,"msg"=>"Please enter the delivery date");
            }else if((strtotime($pickup_date)) > (strtotime($delivery_date))){
                $aVars=array("status"=>0,"msg"=>"Delivery date should not be lesser than Pickup date");
            }else if(empty($truck_load_type)){
                $aVars=array("status"=>0,"msg"=>"Please select any one Truck Load Type");
            }else if(empty($weight) || !is_numeric($weight)){
                $aVars=array("status"=>0,"msg"=>"Please enter Weight in numbers");
            }else if(empty($length) || !is_numeric($length)){
                $aVars=array("status"=>0,"msg"=>"Please enter Length in numbers");
            }else if(empty($height) || !is_numeric($height)){
                $aVars=array("status"=>0,"msg"=>"Please enter Height in numbers");
            }else if(empty($equipment)){
                $aVars=array("status"=>0,"msg"=>"Please select any one Equipment");
            }else if(empty($price) || !is_numeric($price)){
                $aVars=array("status"=>0,"msg"=>"Please enter Price in numbers");
            }else if(empty($origin_lat)){
                $aVars=array("status"=>0,"msg"=>"Please enter the Origin Latitude");
            }else if(empty($origin_lng)){
                $aVars=array("status"=>0,"msg"=>"Please enter the Origin Longtitude");
            }else if(empty($destination_lat)){
                $aVars=array("status"=>0,"msg"=>"Please enter the Destination Latitude");
            }else if(empty($destination_lng)){
                $aVars=array("status"=>0,"msg"=>"Please enter the Destination Longitude");
            }else if(empty($app_type)){
                $aVars=array("status"=>0,"msg"=>"Please enter the app type");    
            }else if(empty($origin_city)){
                $aVars=array("status"=>0,"msg"=>"Invalid address, please provide a valid origin city");    
            }else if(empty($destination_city)){
                $aVars=array("status"=>0,"msg"=>"Invalid address, please provide a valid destination city");    
            }else if(empty($broker_name)){
                $aVars=array("status"=>0,"msg"=>"Name cannot be empty");
            }elseif(!empty($broker_name) && is_numeric($broker_name)){
                $aVars=array("status"=>0,"msg"=>"Please enter the valid name");
            }elseif(!empty($broker_name) && $name_valid==false){
                $aVars=array("status"=>0,"msg"=>"Please enter the valid name");
            }else if(empty($broker_email)){
                    $aVars=array("status"=>0,"msg"=>"Please enter the email");
            }else if(empty($broker_phone)){
                   $aVars=array("status"=>0,"msg"=>"Phone Number cannot be empty");
            }elseif($phonecheck == false && !empty($broker_phone)){
                $aVars=array("status"=>0,"msg"=>"Enter a Valid Phone Number");
            }else if(!empty($app_type) && parent::CheckApptype($app_type)==false){
                $aVars=array("status"=>0,"msg"=>"Please enter the valid app type");    
            }
            else{
                if($pickup_hour=="0" && $pickup_minute=="00" && ($pickup_second=="AM" || $pickup_second=="PM")){
                    $pickuptimeval = '';
                } else {
                    $pickuptimeval = $pickup_hour.":".$pickup_minute." ".$pickup_second;    
                }

                if($delivery_hour=="0" && $delivery_minute=="00" && ($delivery_second=="AM" || $delivery_second=="PM")){
                    $deliverytimeval = '';
                } else {
                    $deliverytimeval = $delivery_hour.":".$delivery_minute." ".$delivery_second;
                }


                $broker_check_id = parent::broker_check($user_id);
                
                $origin_state_name=parent::GetStateName($origin_state);
                $des_state_name=parent::GetStateName($destination_state);
               
                if($origin_country_code=='US')
                    $or_ccode='USA';
                elseif($origin_country_code=='CA')
                    $or_ccode='Canada';
                else
                    $or_ccode=$origin_country_code;


                 if($destination_country_code=='US')
                    $des_ccode='USA';
                 elseif($destination_country_code=='CA')
                    $des_ccode='Canada';
                else
                    $des_ccode=$destination_country_code;


                $orgsplit=$origin_city.', '.$origin_state.', '.$or_ccode;
                $dessplit=$destination_city.', '.$destination_state.', '.$des_ccode;


                $data =  array(
                    'user_id'=>$user_id, 
                    'broker_id'=>$broker_check_id, 
                    'origin'=>$orgsplit,
                    'origin_address'=>$orgin ,
                    'origin_city'=>$origin_city ,
                    'origin_state'=>$origin_state_name ,
                    'origin_zipcode'=>$origin_postal ,
                    'origin_country'=>$origin_country ,
                    'destination'=>$dessplit,
                    'destination_address'=>$destination ,
                    'destination_city'=>$destination_city ,
                    'destination_state'=>$des_state_name ,
                    'destination_zipcode'=>$destination_postal ,
                    'destination_country'=>$destination_country ,
                    'pickup_date'=>date("Y-m-d",strtotime($pickup_date)),
                    'delivery_date'=>date("Y-m-d",strtotime($delivery_date)) ,
                    'truck_load_type'=>$truck_load_type ,
                    'weight'=>$weight,
                    'length'=>$length,
                    'height'=>$height,
                    'price'=>$price ,
                    'description'=>'' ,
                    'truck_id'=>$equipment ,
                    'origin_lat'=>$origin_lat ,
                    'origin_lng'=>$origin_lng ,
                    'destination_lat'=>$destination_lat ,
                    'destination_lng'=>$destination_lng,
                    'app_type'=>$app_type,
                    'created_by'=>$user_id,
                    'pickup_time'=>$pickuptimeval,
                    'delivery_time'=>$deliverytimeval
                );

               // print_r($data);exit;
                $last_id=parent::InsertData("loads",$data);
                $lid='';
                if(!empty($orgin) && !empty($destination)){
                    
                    
                    if($last_id<9){
                        $last_id_val="00000".$last_id;
                    }
                    else if($last_id==9){
                        $last_id_val="0000".$last_id;
                    }
                    else if($last_id<99){
                        $last_id_val="0000".$last_id;
                    }
                    else if($last_id==99){
                        $last_id_val="000".$last_id;
                    }
                    else if($last_id<999){
                        $last_id_val="000".$last_id;
                    }
                    else if($last_id==999){
                        $last_id_val="00".$last_id;
                    }
                    else if($last_id>999){
                        $last_id_val="00".$last_id;
                    }
                    else if($last_id==9999){
                        $last_id_val="0".$last_id;
                    }
                    else if($last_id>9999){
                        $last_id_val="0".$last_id;
                    }
                    $lid=$origin_state.'-'.$destination_state.'-'.$last_id_val;
                }
                $ldatas=array(
                    "load_id"=>$lid
                );
                $conditions =array("id"=>$last_id);
                parent::UpdateData("loads",$ldatas,$conditions);


                $cont_data =  array(
                    'user_id'=>$user_id, 
                    'load_id'=> $last_id, 
                    'name'=>$broker_name,
                    'email'=>$broker_email,
                    'phone'=>$broker_phone,
                    'status'=>1 ,       
                  );
                parent::InsertData("load_contacts",$cont_data);

                $datas=array(
                    "id"=>$user_id,
                );
                $check=$this->db->prepare("SELECT name,email FROM users WHERE id=:id AND status=1");
                $check->execute($datas);
                $rowchk=$check->fetch(PDO::FETCH_ASSOC);
                $email_id=$rowchk['email'];

                $emails = $this->db->prepare( "SELECT id, subject, content, email_notication
                        FROM public.email_template WHERE type='new-load-notication'");
                $emails->execute();
                $email_template= $emails->fetch(PDO::FETCH_ASSOC);

                // $link=SITEURL."app/reset-password?e=".urlencode($Global->encode($email));
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
                );  
                $pattern = '[%s]';
                foreach($token as $key=>$val){
                $varMap[sprintf($pattern,$key)] = $val;
                }
                $content = strtr($email_template['content'],$varMap);
                parent::SendEmail(FROM_EMAIL,$email_id,$subject,$content);
                        
                $aVars = array('status' =>1 ,"msg" =>"Load added successfully " );
            }
                
        } else {
            $aVars=array("status"=>2 , "msg"=>"Invalid Token");
        }
        echo json_encode($aVars);
    }

    
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

if(!empty($input)){
    $firsttime=new BrokerAddLoad();
    $firsttime->AddLoad($input);
}



function CharacterCheck($string=""){
if (preg_match('/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/', $string))
    return false;
else
    return true;
}
















































?>


