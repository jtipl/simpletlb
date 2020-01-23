<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$draw 			= isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row 			=  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage 	= isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex 	=isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName		=   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue 	 = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';

$origin 		 =isset($_REQUEST['origin']) ? trim($_REQUEST['origin']): '';
$destination 	 =isset($_REQUEST['destination']) ? trim($_REQUEST['destination']): '';
$from_date 		 =isset($_REQUEST['trucker_from_date']) ? trim($_REQUEST['trucker_from_date']): '';
$to_date 	 	=isset($_REQUEST['trucker_to_date']) ? trim($_REQUEST['trucker_to_date']): '';
$loadid 		 =isset($_REQUEST['trucker_loadid']) ? trim($_REQUEST['trucker_loadid']): '';
$price  		 =isset($_REQUEST['price']) ? trim($_REQUEST['price']): '';
$loadweight  	 =isset($_REQUEST['loadweight']) ? trim($_REQUEST['loadweight']): '';
$loadlength  	 =isset($_REQUEST['loadlength']) ? trim($_REQUEST['loadlength']): '';
$loadheight  	 =isset($_REQUEST['loadheight']) ? trim($_REQUEST['loadheight']): '';
$datetype  		 =isset($_REQUEST['trucker_datetype']) ? trim($_REQUEST['trucker_datetype']): '';
$user_id  		 =isset($_SESSION['user_id']) ? trim($_SESSION['user_id']): 0;

$trucker_name  	 =isset($_REQUEST['trucker_name']) ? trim($_REQUEST['trucker_name']): '';
$business_name   =isset($_REQUEST['business_name']) ? trim($_REQUEST['business_name']): '';
$usdot  		 =isset($_REQUEST['usdot']) ? trim($_REQUEST['usdot']): '';



$sloadid="%";
$sorigin="%";
$sdestination="%";
$sprice="%";
$sloadweight="%";
$sloadlength="%";
$sloadheight="%";
$eqquery="";
$status_qry="AND loads_trip.load_status IN (1,2,3,4)";
$sbusiness_name="%";
$strucker_name="%";
$susdot="%";


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
if(!empty($_REQUEST['trucker_loadstatus'])){
	foreach($_REQUEST['trucker_loadstatus'] as $ar) {
		$loadarr[] = $ar;
	}
	$status_ids=implode(',', $loadarr);
	$status_qry="AND loads_trip.load_status IN (".$status_ids.")";
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

if ($business_name!='') {
	$sbusiness_name ="%".$business_name."%";
}

if ($trucker_name!='') {
	$strucker_name ="%".$trucker_name."%";
}

if ($usdot!='') {
	$susdot ="%".$usdot."%";
}




// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN trucker ON trucker.id=loads_trip.trucker_id INNER JOIN users ON users.id=trucker.user_id WHERE loads_trip.history_status=1 AND loads_trip.cancel_status=0 AND loads_trip.is_delete=0");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering

$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id  INNER JOIN trucker ON trucker.id=loads_trip.trucker_id INNER JOIN users ON users.id=trucker.user_id WHERE loads.user_id=:user_id AND  (loads.load_id ::text ILIKE :searchQuery OR loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.pickup_date ::text ILIKE :searchQuery OR loads.delivery_date ::text ILIKE :searchQuery OR loads.price ::text ILIKE :searchQuery) AND (loads.origin ::text ILIKE :origin AND loads.destination ::text ILIKE :destination  AND loads.load_id ::text ILIKE :loadid AND loads.weight ::text ILIKE :weight AND loads.height ::text ILIKE :height AND loads.length ::text ILIKE :length AND loads.price ::text ILIKE :price AND users.name ::text ILIKE :trucker_name AND users.business_name ::text ILIKE :business_name AND trucker.vehicle_number ::text ILIKE :vehicle_number $datequery) $eqquery  $status_qry  AND loads_trip.history_status=1 AND loads_trip.cancel_status=0  AND loads_trip.is_delete=0 ");


$sel->execute(array("searchQuery" => $searchQuery,"origin"=>$sorigin,"destination"=>$sdestination,"loadid"=>$sloadid,"weight"=>$sloadweight,"height"=>$sloadheight,"length"=>$sloadlength,"price"=>$sprice,"user_id"=>$user_id,"trucker_name"=>$strucker_name,"business_name"=>$sbusiness_name,"vehicle_number"=>$susdot));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];



// Fetch records
$loadslist = $Global->db->prepare("SELECT loads_trip.load_status,trucker.vehicle_number ,users.name as trucker_name,users.business_name,loads_trip.trucker_id,loads.truck_id,loads.weight,loads.length,loads.height,to_char(loads.created_date, 'MM/DD/YYYY') as created_date ,loads.status,loads.price,loads.id,loads.load_id,loads.origin,loads.destination,to_char(loads.pickup_date, 'MM/DD/YYYY') as pickup_date,to_char(loads.delivery_date, 'MM/DD/YYYY') as delivery_date FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN trucker ON trucker.id=loads_trip.trucker_id INNER JOIN users ON users.id=trucker.user_id   WHERE  loads.user_id=:user_id AND  (loads.load_id ::text ILIKE :searchQuery OR loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.pickup_date ::text ILIKE :searchQuery OR loads.delivery_date ::text ILIKE :searchQuery OR price ::text ILIKE :searchQuery OR users.name ::text ILIKE :searchQuery) AND (origin ::text ILIKE :origin AND destination ::text ILIKE :destination  AND loads.load_id ::text ILIKE :loadid AND loads.weight ::text ILIKE :weight AND loads.height ::text ILIKE :height AND loads.length ::text ILIKE :length AND loads.price ::text ILIKE :price AND users.name ::text ILIKE :trucker_name AND users.business_name ::text ILIKE :business_name AND trucker.vehicle_number ::text ILIKE :vehicle_number  $datequery) $eqquery $status_qry AND loads_trip.history_status=1 AND loads_trip.cancel_status=0 AND loads_trip.is_delete=0  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$loadslist->execute(array("searchQuery" => $searchQuery,"origin"=>$sorigin,"destination"=>$sdestination,"loadid"=>$sloadid,"weight"=>$sloadweight,"height"=>$sloadheight,"length"=>$sloadlength,"price"=>$sprice,"user_id"=>$user_id,"trucker_name"=>$strucker_name,"business_name"=>$sbusiness_name,"vehicle_number"=>$susdot));
$rdatas = $loadslist->fetchAll(PDO::FETCH_ASSOC);
$newarr=array();
if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
			$trucks = $Global->db->prepare("SELECT truck_name  FROM truck_type WHERE id=:id");
			$trucks->execute(array("id"=>$value['truck_id']));
			$truck_name =$trucks->fetch(PDO::FETCH_ASSOC);

			/*$trucksnames = $Global->db->prepare("SELECT users.name  FROM trucker INNER JOIN users ON users.id=trucker.user_id WHERE trucker.id=:id");
			$trucksnames->execute(array("id"=>$value['trucker_id']));
			$trucker_name =$trucksnames->fetch(PDO::FETCH_ASSOC);*/


			$value['truck_name']=$truck_name['truck_name'];
			$value['searchtype']='trucker';
			//$value['trucker_name']=$trucker_name['name'];
			$newarr[]=$value;
	}
}

// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $newarr
);
echo json_encode($response);
?>