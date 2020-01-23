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
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :0;
$token=isset($_REQUEST['token'])? $_REQUEST['token'] :'';
$CheckvalidToken=$Global->CheckValidToken($token);
$operation=isset($_REQUEST['operation'])? $_REQUEST['operation'] :'';
$token = isset($_REQUEST['token']) ? $_REQUEST['token']: '';
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){

		$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
		$curr->execute();
		$currDate = $curr->fetch(PDO::FETCH_ASSOC);

		$TruckerDetails = $Global->TruckerDetails($user_id);
		$trucker_id = $TruckerDetails["id"];


		if($operation=="awaiting" || $operation==""){
			$title="Awaiting_loads";
			$sel = $Global->db->prepare("SELECT count(*) as allcount 
			FROM loads_trip 
			INNER JOIN loads ON loads.id = loads_trip.load_id 
			WHERE loads_trip.trucker_id=:trucker_id 
			AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 AND loads_trip.denied_status!=1 AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
			FROM loads_trip 
			INNER JOIN loads ON loads.id = loads_trip.load_id 
			WHERE loads_trip.trucker_id=:trucker_id 
			AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 AND loads_trip.denied_status!=1 AND loads_trip.is_delete=0 AND loads_trip.cancel_status=0" );
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			// Fetch records
			$loadslist = $Global->db->prepare("SELECT 
				l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
				l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
				l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
				l.truck_load_type , l.weight , l.length , l.price,l.height , l.status ,l.truck_id , tt.truck_name
				FROM loads_trip 
				INNER JOIN loads l ON l.id = loads_trip.load_id 
				INNER JOIN  truck_type tt ON l.truck_id = tt.id
				INNER JOIN users ON users.id = l.user_id 
				WHERE  
				loads_trip.trucker_id=:trucker_id 
				AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 
				AND loads_trip.cancel_status=0 AND loads_trip.is_delete=0 AND loads_trip.denied_status!=1  
				LIMIT ".$rowperpage." OFFSET ".$row);
			//AND loads.status=1
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		} 
		else if($operation=="upcoming-trips"){
			$title="Upcoming_trips";
			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id 
				AND loads_trip.load_status=2 AND loads_trip.trucker_status=2 AND loads_trip.is_delete=0 ");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id 
				AND loads_trip.load_status=2 AND loads_trip.trucker_status=2 AND loads_trip.is_delete=0 ");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			// Fetch records
			$loadslist = $Global->db->prepare("SELECT 
				l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
				l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
				l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
				l.truck_load_type , l.weight , l.length , l.price ,l.height, l.status ,l.truck_id , tt.truck_name
			 FROM loads_trip 
			 INNER JOIN loads l ON l.id = loads_trip.load_id 
			 INNER JOIN users ON users.id = l.user_id 
			 INNER JOIN  truck_type tt ON l.truck_id = tt.id
			 WHERE 
			 loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=2 AND loads_trip.trucker_status=2 AND loads_trip.is_delete=0   
			 LIMIT ".$rowperpage." OFFSET ".$row);
			//AND loads.status=1
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		} 
		else if($operation=="picked-loads"){

			$title="Picked_Loads";

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
			FROM loads_trip 
			INNER JOIN loads ON loads.id = loads_trip.load_id 
			WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0 ");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
			FROM loads_trip 
			INNER JOIN loads ON loads.id = loads_trip.load_id 
			WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0  ");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			// Fetch records
			$loadslist = $Global->db->prepare("SELECT 
				l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
				l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
				l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
				l.truck_load_type , l.weight , l.length , l.price ,l.height, l.status ,l.truck_id , tt.truck_name
			FROM loads_trip 
			INNER JOIN loads l ON l.id = loads_trip.load_id 
			INNER JOIN users ON users.id = l.user_id 
			INNER JOIN  truck_type tt ON l.truck_id = tt.id
			 WHERE
			loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=3 AND loads_trip.is_delete=0 
			LIMIT ".$rowperpage." OFFSET ".$row);
			//AND loads.status=1
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		} 
		else if($operation=="denied-loads"){

			$title="Denied_Loads";

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id 
				AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 AND loads_trip.denied_status=1");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id 
				AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 AND loads_trip.denied_status=1 ");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			// Fetch records
			$loadslist = $Global->db->prepare("SELECT 
				l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
				l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
				l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
				l.truck_load_type , l.weight , l.length , l.price,l.height , l.status ,l.truck_id , tt.truck_name
			FROM loads_trip 
			INNER JOIN loads l ON l.id = loads_trip.load_id 
			INNER JOIN users ON users.id = l.user_id 
			INNER JOIN  truck_type tt ON l.truck_id = tt.id
			WHERE 
				loads_trip.trucker_id=:trucker_id AND loads_trip.trucker_status=1 AND loads_trip.load_status=1 
				AND loads_trip.denied_status=1 
			LIMIT ".$rowperpage." OFFSET ".$row);
			//AND loads.status=1
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		} 

		else if($operation=="cancel-loads"){

			$title="Cancel_Loads";

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status IN (1,2)");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE  loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status IN(1,2)");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			// Fetch records
			$loadslist = $Global->db->prepare("SELECT 
				l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
			l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
			l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
			l.truck_load_type , l.weight , l.length , l.price ,l.height, l.status ,l.truck_id , tt.truck_name	
			 FROM loads_trip INNER JOIN loads l ON l.id = loads_trip.load_id 
			 INNER JOIN  truck_type tt ON l.truck_id = tt.id
			 WHERE  loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status IN (1,2)  
			 LIMIT ".$rowperpage." OFFSET ".$row);
			//AND loads.status=1
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		}
		else if($operation=='delivered'){

			$title="Delivered_Loads";

			// Total number of records without filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];
			// Total number of record with filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount 
				FROM loads_trip 
				INNER JOIN loads ON loads.id = loads_trip.load_id 
				WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4 AND loads_trip.is_delete=0");
			$sel->execute(array("trucker_id"=>$trucker_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			$loadslist = $Global->db->prepare("SELECT 
			l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
			l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
			l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
			l.truck_load_type , l.weight , l.length , l.price ,l.height, l.status ,l.truck_id , tt.truck_name
			,broker.phone,users.name,users.email,users.business_name
			FROM loads_trip 
			INNER JOIN loads l ON l.id = loads_trip.load_id 
			INNER JOIN  truck_type tt ON l.truck_id = tt.id
			INNER JOIN broker ON loads_trip.broker_id=broker.id
			INNER JOIN users ON broker.user_id=users.id
			WHERE 
			loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=4  AND loads_trip.is_delete=0   
			LIMIT ".$rowperpage." OFFSET ".$row);
			$loadslist->execute(array("trucker_id"=>$trucker_id));
		} 
		else if($operation=="recent_viewloads"){
			$title="Recent_current_viewloads";

			$loadslist = $Global->db->prepare("
				SELECT l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
				l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
				l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
				l.truck_load_type , l.weight , l.length , l.price,l.height , l.status , l.truck_id , tt.truck_name,
				users.name,users.email,users.business_name
				FROM loads l 
				INNER JOIN truck_type tt ON l.truck_id = tt.id
				INNER JOIN users ON l.user_id=users.id 
				INNER JOIN  viewlist ON l.id = viewlist.load_id WHERE
			viewlist.user_id=:user_id AND viewlist.status=1   
			LIMIT ".$rowperpage." OFFSET ".$row);
			$loadslist->execute(array("user_id"=>$user_id));
		}

		$objPHPExcel = new PHPExcel();

		// Set default font
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(11);

		$objPHPExcel ->getActiveSheet()->setTitle("OPEN LOADS");

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
		$objPHPExcel->getActiveSheet()->setCellValue('L1','EQUIPMENT');
		$objPHPExcel->getActiveSheet()->setCellValue('M1','WEIGHT');
		$objPHPExcel->getActiveSheet()->setCellValue('N1','LENGTH');
		$objPHPExcel->getActiveSheet()->setCellValue('O1','HEIGHT');
		$objPHPExcel->getActiveSheet()->setCellValue('P1','PRICE');
		if($operation=='delivered'){
			$objPHPExcel->getActiveSheet()->setCellValue('Q1','BUSINESS NAME');
			$objPHPExcel->getActiveSheet()->setCellValue('R1','NAME');
			$objPHPExcel->getActiveSheet()->setCellValue('S1','EMAIL');
			$objPHPExcel->getActiveSheet()->setCellValue('T1','PHONE');
		}
		$i=2;
		$loadfetch_results = $loadslist->fetchAll();
		foreach ($loadfetch_results as $key => $values) {

			$status = $values["status"];
			if($status==0){
				$val_status = 'Open for Trucker';
			}
			$load_id_exp = explode("-",$values["load_id"]);

			$objPHPExcel->getActiveSheet()->setCellValue('A'.($i), $i-1);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.($i), $values["load_id"]);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.($i), $values["origin"]);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.($i), $values["destination"]);


			$objPHPExcel->getActiveSheet()->setCellValue('E'.($i), $values["origin_address"]." - ".$load_id_exp[0]." - ".$values["origin_city"]." - ".$values["origin_zipcode"]);
			
			$objPHPExcel->getActiveSheet()->setCellValue('F'.($i), $values["destination_address"]." - ".$load_id_exp[1]." - ".$values["destination_city"]." - ".$values["destination_zipcode"]);
			

			$objPHPExcel->getActiveSheet()->setCellValue('G'.($i), date("m/d/y",strtotime($values["pickup_date"])));
			$objPHPExcel->getActiveSheet()->setCellValue('H'.($i), date("m/d/y",strtotime($values["delivery_date"])));

			$objPHPExcel->getActiveSheet()->setCellValue('I'.($i), $values["pickup_time"]);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.($i), $values["delivery_time"]);


			$objPHPExcel->getActiveSheet()->setCellValue('K'.($i), $values["truck_load_type"]);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.($i), $values["truck_name"]);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.($i), $values["weight"]);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.($i), $values["length"]);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.($i), $values["height"]);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.($i), "$ ".$values["price"]);
			
			if($operation=='delivered'){
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.($i),$values["business_name"]);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.($i),$values["name"]);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.($i),$values["email"]);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.($i),$values["phone"]);
			}

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
echo json_encode($response);
?>