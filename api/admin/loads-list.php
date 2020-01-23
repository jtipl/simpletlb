<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$role_type=isset($_SESSION['user_type']) ? trim($_SESSION['user_type']) : '';
$feature_id_url=isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
$check_role = $Global->db->prepare("SELECT id FROM roles_list WHERE status=1 AND role_name ILIKE :role_name");
$check_role->execute(array("role_name"=>$role_type));
$data_role = $check_role->fetch(PDO::FETCH_ASSOC);
$role_id=$data_role['id'];

$check_feature = $Global->db->prepare("SELECT count(*) FROM mapping_role_feature WHERE status=1 AND role_id =:role_id AND edit=1 AND feature_id=:feature_id");
$check_feature->execute(array("role_id"=>$role_id, "feature_id"=>$feature_id_url));
$get_feature_id = $check_feature->fetch(PDO::FETCH_ASSOC);
$edit_check=$get_feature_id['count'];
if($edit_check == 1){
	$edit_per=1;
}else{
	$edit_per=0;
}

$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
$origin 				   =isset($_REQUEST['origin']) ? trim($_REQUEST['origin']): '';
$destination 				=isset($_REQUEST['destination']) ? trim($_REQUEST['destination']): '';
$pickup_date 				=isset($_REQUEST['pickup_date']) ? trim($_REQUEST['pickup_date']): '';
$delivery_date 				=isset($_REQUEST['delivery_date']) ? trim($_REQUEST['delivery_date']): '';
$loadid 					=isset($_REQUEST['loadid']) ? trim($_REQUEST['loadid']): '';
$price  					=isset($_REQUEST['price']) ? trim($_REQUEST['price']): '';
$status   					=isset($_REQUEST['status']) ? trim($_REQUEST['status']): '';
$weight  					=isset($_REQUEST['weight']) ? trim($_REQUEST['weight']): '';
$loadlength  				=isset($_REQUEST['loadlength']) ? trim($_REQUEST['loadlength']): '';
$height  					=isset($_REQUEST['height']) ? trim($_REQUEST['height']): '';


$lorigin="%";
$ldestination="%";
$lpickup_date="%";
$ldelivery_date="%";
$lloadid="%";
$lequipment="%";
$lprice="%";
$lstatus="%";
$lweight="%";
$lloadlength="%";
$lheight="%";

if ($origin!='') {
	$lorigin ="%".$origin."%";
}
if ($destination!='') {
	$ldestination ="%".$destination."%";
}
if ($pickup_date!='') {
	$lpickup_date ="%".date("Y-m-d", strtotime($pickup_date))."%";
}
if ($delivery_date!='') {
	$ldelivery_date ="%".date("Y-m-d", strtotime($delivery_date))."%";
}
if ($lloadid!='') {
	$loadid ="%".$lloadid."%";
}
if ($status!='') {
	$lstatus ="%".$status."%";
}
if ($weight!='') {
	$lweight ="%".$weight."%";
}
if ($loadlength!='') {
	$lloadlength ="%".$loadlength."%";
}
if ($height!='') {
	$lheight ="%".$height."%";
}
if ($price!='') {
	$lprice ="%".$price."%";
}
$elements=array();
$eqquery="";
if(!empty($_REQUEST['equipment'])){
	foreach($_REQUEST['equipment'] as $va) {
		$elements[] = $va;
	}
	$equipment_ids=implode(',', $elements);
	$eqquery="AND truck_id IN (".$equipment_ids.")";
} 

$loadarr=array();
$status_qry="";
if(!empty($_REQUEST['loadstatus'])){
	foreach($_REQUEST['loadstatus'] as $ar) {
		$loadarr[] = $ar;
	}
	$status_ids=implode(',', $loadarr);
	$status_qry="AND status IN (".$status_ids.")";
} 


// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads  WHERE  (load_id ::text ILIKE :searchQuery OR origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR pickup_date ::text ILIKE :searchQuery OR delivery_date ::text ILIKE :searchQuery) AND (origin ::text ILIKE :origin AND destination ::text ILIKE :destination AND pickup_date ::text ILIKE :pickup_date AND delivery_date ::text ILIKE :delivery_date AND load_id ::text ILIKE :loadid AND weight ::text ILIKE :weight AND height ::text ILIKE :height AND length ::text ILIKE :length AND price ::text ILIKE :price) $eqquery  $status_qry  ");


$sel->execute(array("searchQuery" => $searchQuery,"origin"=>$lorigin,"destination"=>$ldestination,"pickup_date"=>$lpickup_date,"delivery_date"=>$ldelivery_date,"loadid"=>$lloadid,"weight"=>$lweight,"height"=>$lheight,"length"=>$lloadlength,"price"=>$lprice));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records
$loadslist = $Global->db->prepare("SELECT id,enable,load_id,origin,destination,to_char(pickup_date, 'MM-DD-YYYY') as pickup_date
,to_char(delivery_date, 'MM-DD-YYYY') as delivery_date,status FROM loads WHERE   (load_id ::text ILIKE :searchQuery OR origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR pickup_date ::text ILIKE :searchQuery OR delivery_date ::text ILIKE :searchQuery) AND (origin ::text ILIKE :origin AND destination ::text ILIKE :destination AND pickup_date ::text ILIKE :pickup_date AND delivery_date ::text ILIKE :delivery_date AND load_id ::text ILIKE :loadid AND weight ::text ILIKE :weight AND height ::text ILIKE :height AND length ::text ILIKE :length AND price ::text ILIKE :price) $eqquery $status_qry  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$loadslist->execute(array("searchQuery" => $searchQuery,"origin"=>$lorigin,"destination"=>$ldestination,"pickup_date"=>$lpickup_date,"delivery_date"=>$ldelivery_date,"loadid"=>$lloadid,"weight"=>$lweight,"height"=>$lheight,"length"=>$lloadlength,"price"=>$lprice));
$rdatas = $loadslist->fetchAll(PDO::FETCH_ASSOC);


if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
		//$value["phone"]=$Global->formatPhoneNumber($value['phone']);
		//$value['last_login']=$Global->timeAgo($value['last_login']);
		$value['edit_per']=$edit_per;

		//$value["phone"]=$Global->formatPhoneNumber($value['phone']);
		$data[]=$value;
	}
}

// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" =>  $data
);
echo json_encode($response);
?>