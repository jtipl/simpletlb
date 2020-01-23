<?php
require_once("../../elements/Global.php");

require_once DIRECTORY."config/excel-config/PHPExcel.php";

$Global=new LoadBoard();
//$db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST, USERNAME, PASSWORD); 


$objPHPExcel = new PHPExcel();

// Set default font
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

$objPHPExcel ->getActiveSheet()->setTitle("TRUCKER FAVOURITE LIST");

//Set the first row as the header row
$objPHPExcel->getActiveSheet()->setCellValue('A1','SNO');
$objPHPExcel->getActiveSheet()->setCellValue('B1','TRUCKER NAME');
$objPHPExcel->getActiveSheet()->setCellValue('C1','BUSINESS NAME');
$objPHPExcel->getActiveSheet()->setCellValue('D1','EMAIL');
$objPHPExcel->getActiveSheet()->setCellValue('E1','PHONE');
$objPHPExcel->getActiveSheet()->setCellValue('F1','USDOT');
$objPHPExcel->getActiveSheet()->setCellValue('G1','WEIGHT');
$objPHPExcel->getActiveSheet()->setCellValue('H1','LENGTH');

$objPHPExcel->getActiveSheet()->setCellValue('I1','DRIVING LICENSE NUMBER');
$objPHPExcel->getActiveSheet()->setCellValue('J1','LICENSE ISSUING STATE');
$objPHPExcel->getActiveSheet()->setCellValue('K1','LICENSE EXPIRY DATE');

$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){

$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$title="Favourite_Loads";
$row="0";
$i=2;

$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
$curr->execute();
$currDate = $curr->fetch(PDO::FETCH_ASSOC);

$check=$Global->db->prepare("SELECT id FROM broker WHERE user_id=:user_id AND status=1");
$check->execute(array("user_id"=>$user_id));
$rowchk=$check->fetch(PDO::FETCH_ASSOC);
$broker_id=$rowchk['id'];

// DATABASE

if($operation=="favorite"){
	$sql = "
	SELECT 
		users.name,users.business_name,users.email,
		trucker.phone,
		trucker.vehicle_number as usdot,
		trucker.vehicle_weight,
		trucker.vehicle_length,
		trucker.vehicle_licence_no,
		trucker.vehicle_issuing_state,
		to_char(trucker.vehicle_expiry_date, 'MM/DD/YYYY') as vehicle_expiry_date
		FROM  favorite
		INNER JOIN trucker ON trucker.id = favorite.trucker_id 
		INNER JOIN users ON users.id=trucker.user_id  
		WHERE 
		favorite_type='trucker_favorite' 
		AND favorite.status=1  AND favorite.broker_id=:broker_id
		LIMIT ".$rowperpage." OFFSET ".$row;
		//echo $sql;exit;
		$query = $Global->db->prepare($sql);
		$query->execute(array("broker_id"=>$broker_id));
} 

//echo $sql;exit;

$data = array();
$loadfetch_results = $query->fetchAll();


foreach ($loadfetch_results as $key => $values) {

	if($values["vehicle_issuing_state"]!=""){
		$check=$Global->db->prepare("SELECT name FROM states WHERE id=:state_id");
		$check->execute(array("state_id"=>$values["vehicle_issuing_state"]));
		$rowchk=$check->fetch(PDO::FETCH_ASSOC);
		$state_name=$rowchk['name'];
	//echo $state_name;exit;
	} else {
		$state_name="";
	}



	$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), $i-1);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.($i), $values['name']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.($i), $values["business_name"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.($i), $values["email"]);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.($i), $values["phone"]);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.($i), $values["usdot"]);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.($i), $values["vehicle_weight"]);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.($i), $values["vehicle_length"]);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.($i), $values["vehicle_licence_no"]);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.($i), $state_name);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.($i), $values["vehicle_expiry_date"]);

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