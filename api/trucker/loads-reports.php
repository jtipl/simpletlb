<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :'';

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

$draw 			= isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row 			=  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage 	= isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex 	=isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName		=   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue 	 = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';

$origin 		 =isset($_REQUEST['origin']) ? trim($_REQUEST['origin']): '';
$destination 	 =isset($_REQUEST['destination']) ? trim($_REQUEST['destination']): '';
$from_date 		 =isset($_REQUEST['from_date']) ? trim($_REQUEST['from_date']): '';
$to_date 	 	=isset($_REQUEST['to_date']) ? trim($_REQUEST['to_date']): '';
$loadid 		 =isset($_REQUEST['loadid']) ? trim($_REQUEST['loadid']): '';
$price  		 =isset($_REQUEST['price']) ? trim($_REQUEST['price']): '';
$loadweight  	 =isset($_REQUEST['loadweight']) ? trim($_REQUEST['loadweight']): '';
$loadlength  	 =isset($_REQUEST['loadlength']) ? trim($_REQUEST['loadlength']): '';
$loadheight  	 =isset($_REQUEST['loadheight']) ? trim($_REQUEST['loadheight']): '';
$datetype  		 =isset($_REQUEST['datetype']) ? trim($_REQUEST['datetype']): '';


$sloadid="%";
$sorigin="%";
$sdestination="%";
$sprice="%";
$sloadweight="%";
$sloadlength="%";
$sloadheight="%";
$eqquery="";
$status_qry="";


if ($loadid!='') {
	$sloadid ="%".$loadid."%";
}
if ($origin!='') {
	$sorigin ="%".$origin."%";
}
if ($destination!='') {
	$sdestination ="%".$destination."%";
}

$loadarr=array();
$status_qry="AND (loads_trip.load_status IN (1,2,3,4) OR loads_trip.denied_status=1 OR loads_trip.cancel_status IN (1,2))";
$status_qry1="";
if(!empty($_REQUEST['loadstatus'])){
	foreach($_REQUEST['loadstatus'] as $ar) {

		$loadarr[] = $ar;
	}
		$status_ids=implode(',', $loadarr);

	if (in_array("6", $loadarr)){
		$status_qry1 .="OR loads_trip.denied_status=1";	
	}if(in_array("5", $loadarr)){
		$status_qry1 .="OR loads_trip.cancel_status IN (1,2)";	
	}

	if(in_array("1", $loadarr) || in_array("2", $loadarr) || in_array("3", $loadarr) || in_array("4", $loadarr)){
		$status_qry=" AND (loads_trip.cancel_status=0 AND loads_trip.denied_status=0 AND loads_trip.load_status IN (".$status_ids.") $status_qry1)";
	}
	else{
		$status_qry=" AND (loads_trip.load_status IN (".$status_ids.") $status_qry1)";
	}
	
	/*}elseif(in_array("1", $loadarr)){
		$status_qry="AND loads_trip.load_status IN (".$status_ids.") AND loads_trip.cancel_status=0 AND loads_trip.denied_status=0";	
	}else{*/
		//$status_qry="loads_trip.load_status IN (".$status_ids.")";
	//}*/


	/*$status_qry="AND (loads_trip.load_status IN (".$status_ids.") OR loads_trip.denied_status=1 OR loads_trip.cancel_status IN (1,2))";*/
} 

$datequery="";
if($datetype!=''){

	if($datetype=='created_date'){
		if($from_date!=''){
			$datequery ="AND loads.created_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND loads.created_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$t=$to_date." +1 days";

			$datequery ="AND loads.created_date >= '".date("Y-m-d", strtotime($from_date))."' AND loads.created_date <=  '".date("Y-m-d", strtotime($t))."' ";
		}
	}elseif($datetype=='pickup_date'){
		if($from_date!=''){
			$datequery ="AND loads.pickup_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND loads.pickup_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$datequery ="AND loads.pickup_date >= '".date("Y-m-d", strtotime($from_date))."' AND loads.pickup_date <=  '".date("Y-m-d", strtotime($to_date))."' ";
		}
	}elseif($datetype=='delivery_date'){
		if($from_date!=''){
			$datequery ="AND loads.delivery_date ::text ILIKE '%".date("Y-m-d", strtotime($from_date))."%' ";
		}if($to_date!=''){
			$datequery ="AND loads.delivery_date ::text ILIKE '%".date("Y-m-d", strtotime($to_date))."%' ";
		}if($from_date!='' && $to_date!=''){
			$datequery ="AND loads.delivery_date >= '".date("Y-m-d", strtotime($from_date))."' AND loads.delivery_date <=  '".date("Y-m-d", strtotime($to_date))."' ";
		}
	}

}


$elements=array();
if(!empty($_REQUEST['equipment'])){
	foreach($_REQUEST['equipment'] as $va) {
		$elements[] = $va;
	}
	$equipment_ids=implode(',', $elements);
	$eqquery ="AND loads.truck_id IN (".$equipment_ids.")";
} 
if ($price!='') {
	$sprice ="%".$price."%";
}
if ($loadweight!='') {
	$sloadweight ="%".$loadweight."%";
}
if ($loadlength!='') {
	$sloadlength ="%".$loadlength."%";
}
if ($loadheight!='') {
	$sloadheight ="%".$loadheight."%";
}



// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id =loads.id INNER JOIN users ON users.id = loads.user_id ");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering

$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id =loads.id  WHERE loads_trip.user_id=:user_id AND  (loads.load_id ::text ILIKE :searchQuery OR loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.pickup_date ::text ILIKE :searchQuery OR loads.delivery_date ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery) AND (loads.origin ::text ILIKE :origin AND loads.destination ::text ILIKE :destination  AND loads.load_id ::text ILIKE :loadid AND loads.weight ::text ILIKE :weight AND loads.height ::text ILIKE :height AND loads.length ::text ILIKE :length AND loads.price ::text ILIKE :price $datequery) $eqquery $status_qry    ");


$sel->execute(array("searchQuery" => $searchQuery,"origin"=>$sorigin,"destination"=>$sdestination,"loadid"=>$sloadid,"weight"=>$sloadweight,"height"=>$sloadheight,"length"=>$sloadlength,"price"=>$sprice,"user_id"=>$user_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];


// Fetch records
$loadslist = $Global->db->prepare("SELECT  users.business_name,loads_trip.history_status,loads_trip.cancel_status,loads_trip.load_status,loads_trip.denied_status,loads.truck_id,loads.weight,loads.length,loads.height,to_char(loads.created_date, 'MM/DD/YYYY') as created_date ,loads.status,loads.price,loads.id,loads.load_id,loads.origin,loads.destination,to_char(loads.pickup_date, 'MM/DD/YYYY') as pickup_date,to_char(loads.delivery_date, 'MM/DD/YYYY') as delivery_date FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN users ON users.id = loads.user_id  WHERE  loads_trip.user_id=:user_id AND  (loads.load_id ::text ILIKE :searchQuery OR loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.pickup_date ::text ILIKE :searchQuery OR loads.delivery_date ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery) AND (loads.origin ::text ILIKE :origin AND loads.destination ::text ILIKE :destination  AND loads.load_id ::text ILIKE :loadid AND loads.weight ::text ILIKE :weight AND loads.height ::text ILIKE :height AND loads.length ::text ILIKE :length AND loads.price ::text ILIKE :price $datequery) $eqquery  $status_qry  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);


$loadslist->execute(array("searchQuery" => $searchQuery,"origin"=>$sorigin,"destination"=>$sdestination,"loadid"=>$sloadid,"weight"=>$sloadweight,"height"=>$sloadheight,"length"=>$sloadlength,"price"=>$sprice,"user_id"=>$user_id));
$rdatas = $loadslist->fetchAll(PDO::FETCH_ASSOC);
$newarr=array();
if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
			$trucks = $Global->db->prepare("SELECT truck_name  FROM truck_type WHERE id=:id");
			$trucks->execute(array("id"=>$value['truck_id']));
			$truck_name =$trucks->fetch(PDO::FETCH_ASSOC);
			$value['truck_name']=$truck_name['truck_name'];
			$newarr[]=$value;
	}
}

// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "status"=>1,
  "data" => $newarr

);

}else{
	$response=array("status"=>2,"msg"=>"Invalid Token");

}

echo json_encode($response);
?>