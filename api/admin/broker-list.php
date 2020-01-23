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
$country 			=isset($_REQUEST['country']) ? trim($_REQUEST['country']): '';
$state 				=isset($_REQUEST['state']) ? trim($_REQUEST['state']): '';
$city				=isset($_REQUEST['city']) ? trim($_REQUEST['city']): '';
// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}

$nameb="%";
$business_nameb="%";
$emailb="%";
$phoneb="%";
$countryb="%";
$stateb="%";
$cityb="%";

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
if ($country!='') {
	$countryb ="%".$country."%";
}
if ($state!='') {
	$stateb ="%".$state."%";
}
if ($city!='') {
	$cityb ="%".$city."%";
}


// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users  INNER JOIN broker  ON users.id = broker.user_id WHERE users.user_type='broker'");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users  INNER JOIN broker  ON users.id = broker.user_id WHERE  (users.name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery OR users.created_date ::text ILIKE :searchQuery OR users.last_login ::text ILIKE :searchQuery OR broker.phone ::text ILIKE :searchQuery) AND users.user_type='broker' AND ((users.name ::text ILIKE :name) AND (users.business_name ::text ILIKE :business_name) AND (users.email ::text ILIKE :email) AND (broker.phone ::text ILIKE :phone) AND  (broker.country ::text ILIKE :country) AND (broker.state ::text ILIKE :state) AND (broker.city ::text ILIKE :city)) ");


$sel->execute(array("searchQuery" => $searchQuery,"name"=>$nameb,"business_name"=>$business_nameb,"email"=>$emailb,"phone"=>$phoneb,"country"=>$countryb,"state"=>$stateb,"city"=>$cityb));

$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records
$brokerlist = $Global->db->prepare("SELECT users.id,broker.id as broker_id,users.name,users.business_name,users.email,to_char(users.created_date,'MM-DD-YYYY') as created_date,users.last_login,broker.phone,users.status FROM users  INNER JOIN broker ON users.id = broker.user_id WHERE  (users.name ::text ILIKE :searchQuery OR users.business_name ::text ILIKE :searchQuery OR users.email ::text ILIKE :searchQuery OR users.created_date ::text ILIKE :searchQuery OR users.last_login ::text ILIKE :searchQuery OR broker.phone ::text ILIKE :searchQuery)  AND users.user_type='broker' AND ((users.name ::text ILIKE :name) AND (users.business_name ::text ILIKE :business_name) AND (users.email ::text ILIKE :email) AND (broker.phone ::text ILIKE :phone) AND  (broker.country ::text ILIKE :country) AND (broker.state ::text ILIKE :state) AND (broker.city ::text ILIKE :city))  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$brokerlist->execute(array("searchQuery" => $searchQuery,"name"=>$nameb,"business_name"=>$business_nameb,"email"=>$emailb,"phone"=>$phoneb,"country"=>$countryb,"state"=>$stateb,"city"=>$cityb));
$rdatas = $brokerlist->fetchAll(PDO::FETCH_ASSOC);
$data=array();
if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
		//$value["phone"]=$Global->formatPhoneNumber($value['phone']);
		$value['last_login']=$Global->timeAgo($value['last_login']);
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
  "aaData" => $data
);
echo json_encode($response);
?>