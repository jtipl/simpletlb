<?php
require_once("../../elements/Global.php");
require_once DIRECTORY."config/excel-config/PHPExcel.php";

$Global=new LoadBoard();
$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';

		$operation=isset($_REQUEST['operation'])? $_REQUEST['operation'] :'';
		//if($operation=="trucker_current_excel"){
			// Total number of records without filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM truck_type ");
			$sel->execute();
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$total_count = $records['allcount'];

			// Total number of record with filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM truck_type ");
			$sel->execute();
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			$loadslist = $Global->db->prepare("SELECT * FROM truck_type 
		ORDER by truck_name DESC LIMIT ".$rowperpage." OFFSET ".$row);
			$loadslist->execute();
		//}					
		

		$objPHPExcel = new PHPExcel();

		// Set default font
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

		$objPHPExcel ->getActiveSheet()->setTitle("Equipment Details");

		$objPHPExcel->getActiveSheet()->setCellValue('A1','S.NO');
		$objPHPExcel->getActiveSheet()->setCellValue('B1','TRUCK NAME');
		$objPHPExcel->getActiveSheet()->setCellValue('C1','CREATED DATE');
		$objPHPExcel->getActiveSheet()->setCellValue('D1','STATUS');

		$i=2;
		$loadfetch_results = $loadslist->fetchAll();
		foreach ($loadfetch_results as $key => $values) {
			$status = $values["status"];
			if($status==1){
				$val_status = 'Active';
			} else {
				$val_status = 'In Active';
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), $i-1);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($i), $values['truck_name']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.($i), $values["created_date"]);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.($i), $val_status);

			
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

	$filename="Current_Page_Report";
	header("Content-Type:application/vnd.ms-excel");	
	header("Content-Disposition:attachment; filename=".$filename.".xls");
	header("Cache-Control:max-age=0");
	header("Pragma: no-cache");

	$objWriter=PHPExcel_IOFactory::createwriter($objPHPExcel,"Excel5");
	$objWriter->save("php://output");


?>