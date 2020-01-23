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

$draw 				=isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row 				=isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage 		=isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex 		=isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName 		=isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder 	=isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue 		=isset($_REQUEST['search']['value']) ? trim($_REQUEST['search']['value']): '';
$name 				=isset($_REQUEST['name']) ? trim($_REQUEST['name']): '';
$business_name 		=isset($_REQUEST['business_name']) ? trim($_REQUEST['business_name']): '';
$email 				=isset($_REQUEST['email']) ? trim($_REQUEST['email']): '';
$phone 				=isset($_REQUEST['phone']) ? trim($_REQUEST['phone']): '';
$dot 				=isset($_REQUEST['dot']) ? trim($_REQUEST['dot']): '';

// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}

$nameb="%";
$business_nameb="%";
$emailb="%";
$phoneb="%";
$dotb="%";


if ($name!='') {
	$nameb ="%".$name."%";
}
if ($business_name!='') {
	$business_nameb ="%".$business_name."%";
}
if ($email!='') {
	$emailb ="%".$email."%";
}
if ($phone!='') {
	$phoneb ="%".$phone."%";
}
if ($dot!='') {
	$dotb ="%".$dot."%";
}

// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users  INNER JOIN trucker  ON users.id = trucker.user_id WHERE users.user_type='trucker'");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users  INNER JOIN trucker  ON users.id = trucker.user_id WHERE  (users.name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery OR users.created_date ::text ILIKE :searchQuery OR users.last_login ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery) AND users.user_type='trucker' AND ((users.name ::text ILIKE :name) AND (users.business_name ::text ILIKE :business_name) AND (users.email ::text ILIKE :email) AND (trucker.phone ::text ILIKE :phone) AND (trucker.vehicle_number ::text ILIKE :dot)) ");


$sel->execute(array("searchQuery" => $searchQuery,"name"=>$nameb,"business_name"=>$business_nameb,"email"=>$emailb,"phone"=>$phoneb,"dot"=>$dotb));

$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records
$truckerlist = $Global->db->prepare("SELECT users.id,users.name,users.business_name,users.email,to_char(users.created_date,'MM-DD-YYYY') as created_date,users.last_login,trucker.phone,users.status FROM users  INNER JOIN trucker ON users.id = trucker.user_id WHERE  (users.name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery OR users.created_date ::text ILIKE :searchQuery OR users.last_login ::text ILIKE :searchQuery OR trucker.phone ::text ILIKE :searchQuery)  AND users.user_type='trucker' AND ((users.name ::text ILIKE :name) AND (users.business_name ::text ILIKE :business_name) AND (users.email ::text ILIKE :email) AND (trucker.phone ::text ILIKE :phone) AND (trucker.vehicle_number ::text ILIKE :dot))  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$truckerlist->execute(array("searchQuery" => $searchQuery,"name"=>$nameb,"business_name"=>$business_nameb,"email"=>$emailb,"phone"=>$phoneb,"dot"=>$dotb));
$rdatas = $truckerlist->fetchAll(PDO::FETCH_ASSOC);
$data=array();
if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
		$value['last_login']=$Global->timeAgo($value['last_login']);
		$value['edit_per']=$edit_per;
		$data[]=$value;
	}
}


// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);
echo json_encode($response);
?>