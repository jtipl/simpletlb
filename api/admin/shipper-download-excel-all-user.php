<?php
require_once("../../elements/Global.php");

require_once DIRECTORY."config/excel-config/PHPExcel.php";

$Global=new LoadBoard();
//$db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST, USERNAME, PASSWORD); 
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';

$objPHPExcel = new PHPExcel();

// Set default font
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

$objPHPExcel ->getActiveSheet()->setTitle("Users Details");

//Set the first row as the header row

$objPHPExcel->getActiveSheet()->setCellValue('A1','S.NO');
$objPHPExcel->getActiveSheet()->setCellValue('B1','NAME');
$objPHPExcel->getActiveSheet()->setCellValue('C1','EMAIL');
$objPHPExcel->getActiveSheet()->setCellValue('D1','PHONE');
$objPHPExcel->getActiveSheet()->setCellValue('E1','STATUS');


//$CheckvalidToken=$Global->CheckValidToken($token);
//if($CheckvalidToken['status']==1){
if($rowperpage=="all"){
	$title="All_User";
} else {
	$title ="Current_user";
	$rowperpage = "10";
}
$row="0";
$i=2;
// DATABASE
if($operation=="shipper_all_excel"){
	$sql = "SELECT u.name , u.email , sh.phone ,u.status FROM users u INNER JOIN  shipper sh ON  
		u.id=sh.user_id  AND u.status= 1
		ORDER by u.id DESC LIMIT ".$rowperpage." OFFSET ".$row;
} 
//echo $sql;exit;
$query = $Global->db->prepare($sql);
$query->execute();
$data = array();
$loadfetch_results = $query->fetchAll();


foreach ($loadfetch_results as $key => $values) {
	$status = $values["status"];
	if($status==1){
		$val_status = 'Active';
	}

	$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), $i-1);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.($i), $values['name']);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.($i), $values["email"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.($i), $values["phone"]);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.($i), $val_status);

	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(
		PHPExcel_Style_Alignment::HORIZONTAL_LEFT
	);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(
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


$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true);

$filename=$title."_Report";
header("Content-Type:application/vnd.ms-excel");	
header("Content-Disposition:attachment; filename=".$filename.".xls");
header("Cache-Control:max-age=0");
header("Pragma: no-cache");

$objWriter=PHPExcel_IOFactory::createwriter($objPHPExcel,"Excel5");
$objWriter->save("php://output");
/*
} else {
	session_start();
	session_destroy();
	header("Location:".SITEURL);
}*/
?>