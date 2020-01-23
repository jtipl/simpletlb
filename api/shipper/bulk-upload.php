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
    //include 'E:/xampp/htdocs/loadboard/config/excel-config/PHPExcel.php';
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
    print_r( $headings);exit();
    

    for ($row = 2; $row <= $highestRow; $row++) {
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $rowData[0] = array_combine($headings[0], $rowData[0]);
       //if ($rowData[0] != '') {
            //print_r($rowData[0]);
            // $row = array();
             $data=$rowData[0];
             $user_id =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '';
        $shipper_check_id = $Global->shipper_check($user_id);
        $origin_state=$data['From_State'];
        $origin_state_name=$origin_state;
        $origin_country_code='US';
        $destination_country_code='US';
        $destination_city=$data['To_City'];
        $destination_state=$data['To_State'];
        $des_state_name=$destination_state;

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

        $equp = $Global->db->prepare("SELECT id FROM truck_type WHERE truck_name = :truck_name");
        $equp->execute(array("truck_name"=>$data['Equipment']));
        $eqrow = $equp->fetch(PDO::FETCH_ASSOC);

        $loaddata =  array(
            'user_id'=>$user_id, 
            'shipper_id'=>$shipper_check_id, 
            'origin'=>$orgsplit,
            'origin_address'=>$data['From_Address'],
            'origin_city'=>$data['From_City'] ,
            'origin_state'=>$origin_state_name ,
            'origin_zipcode'=>0 ,
            'origin_country'=>0 ,
            'destination'=>$dessplit,
            'destination_address'=>$data['To_Address'] ,
            'destination_city'=>$data['To_City'] ,
            'destination_state'=>$des_state_name ,
            'destination_zipcode'=>0 ,
            'destination_country'=>"" ,
            'pickup_date'=>date("Y-m-d",strtotime($data['Pickup_date'])),
            'delivery_date'=>date("Y-m-d",strtotime($data['Delivery_Date'])) ,
            'truck_load_type'=>$data['Truckload_Type'] ,
            'weight'=>$data['Weight'],
            'length'=>$data['Length'],
            'height'=>$data['Height'],
            'price'=>$data['Price'] ,
            'description'=>'' ,
            'truck_id'=>$eqrow['id'] ,
            'origin_lat'=>"" ,
            'origin_lng'=>"" ,
            'destination_lat'=>"" ,
            'destination_lng'=>"",
            'app_type'=>"web",
            'created_by'=>$user_id,
            'pickup_time'=> isset($data['Pickup_Time']) ? $data['Pickup_Time']: '',
            'delivery_time'=>isset($data['Delivery_Time']) ? $data['Delivery_Time']: '',
        );
       // print_r($loaddata);
        //echo '<pre>';
        $last_id=$Global->InsertData("loads",$loaddata);
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
           
        //} 
    }
    $aVars=array("status"=>1,"msg"=>"Upload Successfully");
  }else{ 
    $aVars=array("status"=>0,"msg"=>"Invalid File");
 }  
}
 echo json_encode($aVars);
?>
