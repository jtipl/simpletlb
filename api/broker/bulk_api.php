<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../elements/Global.php");
$Global=new LoadBoard();
if (!empty($_FILES['file']['name'])) {
 $pathinfo = pathinfo($_FILES["file"]["name"]);
if (($pathinfo['extension'] == 'xlsx' || $pathinfo['extension'] == 'xls' || $pathinfo['extension'] == 'csv') && $_FILES['file']['size'] > 0) {
    $inputFileName = $_FILES['file']['tmp_name']; 
    $inputFileType = 'xlsx';
    include DIRECTORY.'config/excel-config/PHPExcel.php';
    
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader     = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel   = $objReader->load($inputFileName);
    }
    catch (Exception $e) {
        die('Error loading file"' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
    }
    $sheet         = $objPHPExcel->getSheet(0);
    $highestRow    = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $headings      = $sheet->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE);
      function Charac_NumCheck($string=""){
                 if (preg_match('/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/', $string))
                        return false;
                    else
                     
                        return true;
                }
               function zeroCheck($string=""){
                 if (preg_match('/^[-+]?[0][0-6]+$/', $string))
                        return false;
                    else
                        return true;
                }
                function CharacString_Check($string=""){
                 if (preg_match('/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/', $string))
                        return false;
                    else
                        return true;
                }
                $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
                $istatus=array(
                "reload_status"=>2
                );
                $conditions =array("user_id"=>$user_id);
                $Global->UpdateData("temp_loads",$istatus,$conditions);
    $heading=['From_Address','From_City','From_State','To_Address','To_City','To_State','Pickup_date','Pickup_Time','Delivery_Date','Delivery_Time','Truckload_Type','Weight','Height','Equipment','Price'];       
    foreach($heading as $k => $val ){
        if(!in_array($val,$headings[0])){
            echo json_encode(array("status"=>0,"msg"=>"Invalid file Upload"));
            die();
        }
    }     
    for ($row = 2; $row <= $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $rowData[0] = array_combine($headings[0], $rowData[0]);
         $data=$rowData[0];
            $user_id                  = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;
            $orgin                    = isset($data['From_Address']) ? $data['From_Address'] : '';
            $origin_city              = isset($data['From_City']) ? $data['From_City'] : '';
            $origin_state             = isset($data['From_State']) ? $data['From_State'] : '';
            $destination              = isset($data['To_Address']) ? $data['To_Address'] : '';
            $destination_city         = isset($data['To_City']) ? $data['To_City'] : '';
            $destination_state        = isset($data['To_State']) ? $data['To_State'] : '';
            $pickup_date              = isset($data['Pickup_date']) ? $data['Pickup_date'] : '';
            $pickup_time              = isset($data['Pickup_Time']) ? $data['Pickup_Time'] : '';
            $delivery_date            = isset($data['Delivery_Date']) ? $data['Delivery_Date'] : '';
            $delivery_time            = isset($data['Delivery_Time']) ? $data['Delivery_Time'] : '';
            $truck_load_type          = isset($data['Truckload_Type']) ? $data['Truckload_Type'] : '';
            $weight                   = isset($data['Weight']) ? $data['Weight'] : 0;
            $length                   = isset($data['Length']) ? $data['Length'] : 0;
            $height                   = isset($data['Height']) ? $data['Height'] : 0;
            $equipment                = isset($data['Equipment']) ? $data['Equipment'] : 0;
            $price                    = isset($data['Price']) ? $data['Price'] : 0;
            $app_type                 = "web";
            $origin_country_code      ='US';
            $destination_country_code ='US';

            if($origin_country_code=='US')
                 $or_ccode='USA';
            else
                 $or_ccode=$origin_country_code;

            if($destination_country_code=='US')
                 $des_ccode='USA';
            else
                 $des_ccode=$destination_country_code;


        $orgsplit=$data['From_City'].', '.$origin_state.', '.$or_ccode;
        $dessplit=$destination_city.', '.$destination_state.', '.$des_ccode;

        $equp = $Global->db->prepare("SELECT truck_name FROM truck_type WHERE truck_name ILIKE :truck_name");
        $equp->execute(array("truck_name"=>$data['Equipment']));
        $eqrow = $equp->fetch(PDO::FETCH_ASSOC);
         $truck_name=($eqrow['truck_name']==null) ? '' :  $eqrow['truck_name'];
            $valid_origin_state = $Global->state_checking($origin_state);
            $valid_destin_state = $Global->state_checking($destination_state);
            $valid_origin_city = $Global->city_checking($origin_city);
            $valid_destin_city = $Global->city_checking($destination_city);
            $valid_field_status = 1;
            $aVarss=array();
            $current_date=date("m-d-Y");
            $pick_newDate = date("m-d-Y", strtotime($pickup_date));
            $deli_newDate = date("m-d-Y", strtotime($delivery_date));
       
            if(empty($orgin)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the origin");
                $valid_field_status = 0;
            }if(empty($origin_city)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the origin city");
                $valid_field_status = 0;
            }if(!empty($origin_city) && ($valid_origin_city == false || $valid_origin_city == 0 || $valid_origin_city == '' || $valid_origin_city == null)){
                $aVarss[]=array("status"=>0,"msg"=>"Invalid address please provide valid origin city");
                $valid_field_status = 0;
            }if(empty($origin_state)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the destination");
                $valid_field_status = 0;
            }if(!empty($origin_state) && ($valid_origin_state == false || $valid_origin_state == 0 || $valid_origin_state == '' || $valid_origin_state == null)){
                 $aVarss[]=array("status"=>0,"msg"=>"Invalid address please provide valid origin state");
                 $valid_field_status = 0;
            }if(empty($destination)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the destination");
                $valid_field_status = 0;
            }if(empty($destination_city)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the destination city");
                $valid_field_status = 0;
            }if(!empty($destination_city) && ($valid_destin_city == false || $valid_destin_city == 0 || $valid_destin_city == '0' || $valid_destin_city == null || $valid_destin_city == '' )){
                $aVarss[]=array("status"=>0,"msg"=>"Invalid address please provide valid destination city");
                $valid_field_status = 0;
            }if(empty($destination_state)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the destination");
                $valid_field_status = 0;
            }if(!empty($destination_state) && ($valid_destin_state == false || $valid_destin_state == '' || $valid_destin_state == null || $valid_destin_state == 0 || $valid_destin_state == '0')){
                 $aVarss[]=array("status"=>0,"msg"=>"Invalid address please provide valid destination state");
                $valid_field_status = 0;
            }if(empty($pickup_date)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the pickup date");
                $valid_field_status = 0;
            }if($current_date >= $pick_newDate){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the valid pickup date");
                $valid_field_status = 0;
            }if(empty($delivery_date)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the delivery date");
                $valid_field_status = 0;
            }if($current_date >= $deli_newDate){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the valid pickup date");
                $valid_field_status = 0;
            }if( $deli_newDate < $pick_newDate){
                 $aVarss[]=array("status"=>0,"msg"=>"Delivery date is jkhjkhjkhjhjnot less than pickup date");
                 $valid_field_status = 0;
            }if((strtotime($pickup_date)) > (strtotime($delivery_date))){
                $aVarss[]=array("status"=>0,"msg"=>"Delivery date is not less than pickup date");
                $valid_field_status = 0;
            }if(empty($truck_load_type)){
                $aVarss[]=array("status"=>0,"msg"=>"Please select any one Truck Load Type");
                $valid_field_status = 0;
            }if(empty($weight)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the weight");
                $valid_field_status = 0;
            }if(!empty($weight) && zeroCheck($weight) == false && CharacString_Check($weight) == false ){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the weight only numberic");
                $valid_field_status = 0;
            }if(empty($length)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the length");
                $valid_field_status = 0;
            }if(!empty($length) && zeroCheck($length) == false && CharacString_Check($length) == false ){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the length only numberic");
                $valid_field_status = 0;
            }if(empty($height)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the height");
                $valid_field_status = 0;
            }if(!empty($height) && zeroCheck($height) == false && CharacString_Check($height) == false ){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the height only numberic");
                $valid_field_status = 0;
            }if(empty($equipment)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the equipment");
                $valid_field_status = 0;
            }if(!empty($equipment && Charac_NumCheck($equipment) == false)){
                $aVarss[]=array("status"=>0,"msg"=>"Please select any one equipment");
                 $valid_field_status = 0;
            }if(empty($price)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the price");
                $valid_field_status = 0;
            }if(!empty($price) && zeroCheck($price) == false && CharacString_Check($price) == false ){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the price only numberic");
                $valid_field_status = 0;
            }if(empty($app_type)){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the app type");
                $valid_field_status = 0;
            }if(!empty($app_type) && $Global->CheckApptype($app_type)==false){
                $aVarss[]=array("status"=>0,"msg"=>"Please enter the valid app type");
                $valid_field_status = 0;
            }if(count($aVarss)==0){
                $aVarss[]=array("status"=>1,"msg"=>"Successfully");
            }
            
                    // print_r($aVarss);exit
            //else{
              /*  $status=array(
                    "origin"=>$origin
                );*/
                       // $pickup_time= '2:00:00 am';
                       // $delivery_time= ' 5:00:00 pm';
                        $data =  array(
                                'user_id'=>$user_id, 
                                'origin'=>$orgsplit,
                                'destination'=>$dessplit,
                                'origin_address'=>$orgin ,
                                'origin_bulk'=>$orgin ,
                                'origin_city'=>$origin_city ,
                                'origin_state'=>$origin_state ,
                                'origin_country'=>"USA" ,
                                'destination_address'=>$destination ,
                                'destination_bulk'=>$destination,
                                'destination_city'=>$destination_city ,
                                'destination_state'=>$destination_state ,
                                'destination_country'=>"USA" ,
                                'pickup_date'=>date("Y-m-d",strtotime($pickup_date)),
                                'delivery_date'=>date("Y-m-d",strtotime($delivery_date)) ,
                                'pickup_time'=> $pickup_time ,
                                'delivery_time'=>$delivery_time,
                                'truck_load_type'=>$truck_load_type ,
                                'weight'=>$weight,
                                'length'=>$length,
                                'height'=>$height,
                                 'truck_name'=>$truck_name ,
                                'price'=>$price ,
                                'created_by'=>$user_id,
                                'app_type'=>$app_type,
                                'data_validate_reason' =>json_encode($aVarss),//json_encode($aVars),
                                'data_validate_status' => $valid_field_status,
                                'reload_status'  => 1,
                                'status' => 0
                            );
                            $last_id=$Global->InsertData("temp_loads",$data);
                        
          //  }
            

    }
    $aVars=array("status"=>1,"msg"=>"Upload Successfully");
  }else{ 
    $aVars=array("status"=>0,"msg"=>"Invalid File Format Upload");
 }  
}


/*function findlatlan($address=""){
    $userAddress = urlencode ($address);
    $aAddressData = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=".GOOGLEAPI."&address=$userAddress&sensor=false");
    $aAddressDataDecode = json_decode($aAddressData);
    $userLatitude = $aAddressDataDecode->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $userLongitude =    $aAddressDataDecode->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $userLatitude.",".$userLongitude;
}*/


 echo json_encode($aVars);
?>
