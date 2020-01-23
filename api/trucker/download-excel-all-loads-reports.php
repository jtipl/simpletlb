<?php
require_once("../../elements/Global.php");

require_once DIRECTORY."config/excel-config/PHPExcel.php";

$Global=new LoadBoard();
//$db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST, USERNAME, PASSWORD); 


$objPHPExcel = new PHPExcel();

// Set default font
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

$objPHPExcel ->getActiveSheet()->setTitle("LOAD DETAILS");

//Set the first row as the header row

$objPHPExcel->getActiveSheet()->setCellValue('A1','S.NO');
$objPHPExcel->getActiveSheet()->setCellValue('B1','LOAD ID');
$objPHPExcel->getActiveSheet()->setCellValue('C1','ORIGIN');
$objPHPExcel->getActiveSheet()->setCellValue('D1','DESTINATION');


$objPHPExcel->getActiveSheet()->setCellValue('E1','ORIGIN ADDRESS , STATE , CITY ,ZIPCODE ');


$objPHPExcel->getActiveSheet()->setCellValue('F1','DESTINATION ADDRESS , STATE , CITY , ZIPCODE');


$objPHPExcel->getActiveSheet()->setCellValue('G1','PICKUP DATE');
$objPHPExcel->getActiveSheet()->setCellValue('H1','DELIVERY DATE');

$objPHPExcel->getActiveSheet()->setCellValue('I1','PICKUP TIME');
$objPHPExcel->getActiveSheet()->setCellValue('J1','DELIVERY TIME');
$objPHPExcel->getActiveSheet()->setCellValue('K1','LOAD TYPE');
//$objPHPExcel->getActiveSheet()->setCellValue('L1','EQUIPMENT');
$objPHPExcel->getActiveSheet()->setCellValue('L1','WEIGHT');
$objPHPExcel->getActiveSheet()->setCellValue('M1','LENGTH');
$objPHPExcel->getActiveSheet()->setCellValue('N1','HEIGHT');
$objPHPExcel->getActiveSheet()->setCellValue('O1','PRICE');

$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){

$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$title="Loads";
$row="0";
$i=2;

$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
$curr->execute();
$currDate = $curr->fetch(PDO::FETCH_ASSOC);

$TruckerDetails = $Global->TruckerDetails($user_id);
$trucker_id = $TruckerDetails["id"];

// DATABASE
/*
AND loads_trip.load_status=4  
AND loads_trip.is_delete=0 
*/
//loadid
$loadid = isset($_REQUEST['loadid']) ? $_REQUEST['loadid']: '';
$origin = isset($_REQUEST['origin']) ? $_REQUEST['origin']: '';
$destination = isset($_REQUEST['destination']) ? $_REQUEST['destination']: '';

$price  		 =isset($_REQUEST['price']) ? trim($_REQUEST['price']): '';
$loadweight  	 =isset($_REQUEST['weight']) ? trim($_REQUEST['weight']): '';
$loadlength  	 =isset($_REQUEST['length1']) ? trim($_REQUEST['length1']): '';
$loadheight  	 =isset($_REQUEST['height']) ? trim($_REQUEST['height']): '';

$datetype  		 =isset($_REQUEST['datetype']) ? trim($_REQUEST['datetype']): '';
$from_date 		 =isset($_REQUEST['from_date']) ? trim($_REQUEST['from_date']): '';
$to_date 	 	=isset($_REQUEST['to_date']) ? trim($_REQUEST['to_date']): '';

$user_id  		 =isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']): 0;

$sloadid="%";
$sorigin="%";
$sdestination="%";
$sprice="%";
$sloadweight="%";
$sloadlength="%";
$sloadheight="%";

if($loadid!='') {
	if($loadid=="undefined"){
		$sloadid ="%";
	} else {
		$sloadid ="%".$loadid."%";
	}
} 
if ($origin!='') {
	if($origin=="undefined"){
		$sorigin ="%";
	} else {
		$sorigin ="%".$origin."%";
	}
}
if ($destination!='') {
	if($destination=="undefined"){
		$sdestination ="%";
	} else {
		$sdestination ="%".$destination."%";
	}
}
if ($price!='') {
	if($price=="undefined"){
		$sprice ="%";
	} else {
		$sprice ="%".$price."%";
	}
}
if ($loadweight!='') {
	if($loadweight=="undefined"){
		$sloadweight="%";
	} else {
		$sloadweight ="%".$loadweight."%";
	}
}
if ($loadlength!='') {
	if($loadlength=="undefined"){
		$sloadlength ="%";
	} else {
		$sloadlength ="%".$loadlength."%";
	}
}
if ($loadheight!='') {
	if($loadheight=="undefined"){
		$sloadheight ="%";
	} else {
		$sloadheight ="%".$loadheight."%";
	}
}
//echo $so;exit; 
//AND (loads.load_id ::text ILIKE :loadid)
//loads_trip.trucker_id=:trucker_id 


$datequery="";
if($datetype!=''){
	if($datetype=='created_date'){
		if($from_date!=''){
			$datequery ="AND l.created_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND l.created_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$datequery ="AND l.created_date >= '".date("Y-m-d", strtotime($from_date))."' AND l.created_date <=  '".date("Y-m-d", strtotime($to_date))."' ";
		}
	}elseif($datetype=='pickup_date'){
		if($from_date!=''){
			$datequery ="AND l.pickup_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND l.pickup_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$datequery ="AND l.pickup_date >= '".date("Y-m-d", strtotime($from_date))."' AND l.pickup_date <=  '".date("Y-m-d", strtotime($to_date))."' ";
		}
	}elseif($datetype=='delivery_date'){
		if($from_date!=''){
			$datequery ="AND l.delivery_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND l.delivery_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$datequery ="AND l.delivery_date >= '".date("Y-m-d", strtotime($from_date))."' AND l.delivery_date <=  '".date("Y-m-d", strtotime($to_date))."' ";
		}
	}
}
//echo $datequery;exit;
//print_r($_REQUEST['equipment']);

if($_REQUEST['equipment']!=""){
	$equipment=$_REQUEST['equipment'];
	if($equipment=="undefined"){
		$eqquery= "";
	} else {
		$eqquery= " AND l.truck_id IN (".$equipment.")";;
	}
} else {
	$eqquery = "";	
}

//print_r($_REQUEST["load_status"]);

if($_REQUEST['load_status']!=""){
	$load_status=$_REQUEST['load_status'];
	if($load_status=="undefined"){
		$status_qry= "";
	} else {
		$status_qry="AND (loads_trip.load_status IN (1,2,3,4) OR loads_trip.denied_status=1 OR loads_trip.cancel_status IN (1,2))";
		if($load_status==6){
			$status_qry="AND loads_trip.denied_status=1";
		} else if($load_status==5){
			$status_qry="AND loads_trip.cancel_status IN (1,2)";
		} else if($load_status==1){
			$status_qry="AND loads_trip.load_status IN (".$load_status.") AND loads_trip.cancel_status=0 AND loads_trip.denied_status=0";	
		}else{
			$status_qry="AND loads_trip.load_status IN (".$load_status.")";
		}
	}
} else {
	$status_qry = "";	
}
//echo $status_qry;exit;
/*
$status_qry="AND (loads_trip.load_status IN (1,2,3,4) OR loads_trip.denied_status=1 OR loads_trip.cancel_status IN (1,2))";
if(!empty($_REQUEST['loadstatus'])){
	foreach($_REQUEST['loadstatus'] as $ar) {

		$loadarr[] = $ar;
	}
		$status_ids=implode(',', $loadarr);

	if (in_array("6", $loadarr)){
		$status_qry="AND loads_trip.denied_status=1";	
	}elseif(in_array("5", $loadarr)){
		$status_qry="AND loads_trip.cancel_status IN (1,2)";	
	}elseif(in_array("1", $loadarr)){
		$status_qry="AND loads_trip.load_status IN (".$status_ids.") AND loads_trip.cancel_status=0 AND loads_trip.denied_status=0";	
	}else{
		$status_qry="AND loads_trip.load_status IN (".$status_ids.")";
	}
} 
$elements=array();
if(!empty($_REQUEST['equipment'])){
	foreach($_REQUEST['equipment'] as $va) {
		$elements[] = $va;
	}
	$equipment_ids=implode(',', $elements);
	$eqquery =" AND loads.truck_id IN (".$equipment_ids.")";
} */
//echo $eqquery;exit;

/*
$sql = "SELECT 
l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
l.truck_load_type , l.weight , l.length , l.price ,l.height , l.status , l.truck_id , tt.truck_name
FROM loads_trip 
INNER JOIN loads l ON l.id = loads_trip.load_id 
INNER JOIN  truck_type tt ON l.truck_id = tt.id
WHERE 
loads_trip.user_id=:user_id
AND (
l.load_id ::text ILIKE :loadid 
AND l.origin ::text ILIKE :origin 
AND l.destination ::text ILIKE :destination
AND l.price ::text ILIKE :price
AND l.weight ::text ILIKE :weight
AND l.height ::text ILIKE :height
AND l.length ::text ILIKE :length
 ) $datequery $eqquery $status_qry
";*/

$sql="SELECT  l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
l.truck_load_type , l.weight , l.length , l.price ,l.height, l.status , l.truck_id 

FROM loads l
INNER JOIN loads_trip ON loads_trip.load_id=l.id 
INNER JOIN users ON users.id = l.user_id  
WHERE  loads_trip.user_id=:user_id AND  
 (l.origin ::text ILIKE :origin AND l.destination ::text ILIKE :destination  AND l.load_id ::text ILIKE :loadid AND l.weight ::text ILIKE :weight AND l.height ::text ILIKE :height AND l.length ::text ILIKE :length AND l.price ::text ILIKE :price $datequery) $eqquery  $status_qry ORDER BY l.id DESC LIMIT ".$rowperpage." OFFSET ".$row;
//echo $sql;exit;
$query = $Global->db->prepare($sql);
$query->execute(array("user_id"=>$user_id,"loadid"=>$sloadid,"origin"=>$sorigin,"destination"=>$sdestination,"price"=>$sprice,"weight"=>$sloadweight,"height"=>$sloadheight,"length"=>$sloadlength));

//echo $sql;exit;

$data = array();
$loadfetch_results = $query->fetchAll();


foreach ($loadfetch_results as $key => $values) {
	//print_r($values);exit;
	$status = $values["status"];
	if($status==0){
		$val_status = 'Open for Trucker';
	}
	$load_id_exp = explode("-",$values["load_id"]);

	

	$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), $i-1);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.($i), $values['load_id']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.($i), $values["origin"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.($i), $values["destination"]);


	$objPHPExcel->getActiveSheet()->setCellValue('E'.($i), $values["origin_address"]." - ".$load_id_exp[0]." - ".$values["origin_city"]." - ".$values["origin_zipcode"]);
	
	$objPHPExcel->getActiveSheet()->setCellValue('F'.($i), $values["destination_address"]." - ".$load_id_exp[1]." - ".$values["destination_city"]." - ".$values["destination_zipcode"]);
	

	$objPHPExcel->getActiveSheet()->setCellValue('G'.($i), date("m/d/y",strtotime($values["pickup_date"])));
	$objPHPExcel->getActiveSheet()->setCellValue('H'.($i), date("m/d/y",strtotime($values["delivery_date"])));

	$objPHPExcel->getActiveSheet()->setCellValue('I'.($i), $values["pickup_time"]);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.($i), $values["delivery_time"]);


	$objPHPExcel->getActiveSheet()->setCellValue('K'.($i), $values["truck_load_type"]);
	//$objPHPExcel->getActiveSheet()->setCellValue('L'.($i), $values["truck_name"]);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.($i), $values["weight"]);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.($i), $values["length"]);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.($i), $values["height"]);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.($i), "$ ".$values["price"]);

	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('Q'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('R'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('S'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('T'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('U'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$i++;
}


//$objPHPExcel->getActiveSheet()->getRowDimension(count($data))->setCollapsed(true);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('M2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('P2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('Q2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('R2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('S1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('S2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('T1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('T2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
$objPHPExcel->getActiveSheet()->getStyle('U1')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);
$objPHPExcel->getActiveSheet()->getStyle('U2')->getAlignment()->setHorizontal(
    PHPExcel_Style_Alignment::HORIZONTAL_LEFT
);

$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("F1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("G1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("H1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("I1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("J1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("K1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("L1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("M1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("N1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("O1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("P1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("Q1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("R1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("S1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("T1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("U1")->getFont()->setBold(true);
$filename=$title."_Report";
header("Content-Type:application/vnd.ms-excel");	
header("Content-Disposition:attachment; filename=".$filename.".xls");
header("Cache-Control:max-age=0");
header("Pragma: no-cache");

$objWriter=PHPExcel_IOFactory::createwriter($objPHPExcel,"Excel5");
$objWriter->save("php://output");
} else {
	session_start();
	session_destroy();
	header("Location:".SITEURL);
}
?>