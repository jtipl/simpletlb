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
// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM truck_type");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];

// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM truck_type WHERE (truck_name ::text ILIKE :searchQuery) ");
$sel->execute(array("searchQuery" => $searchQuery));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];

// Fetch records
$trucklists = $Global->db->prepare("SELECT id,truck_name,to_char(truck_type.created_date,'MM-DD-YYYY') as created_date,status FROM truck_type WHERE (truck_name ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$rowperpage." OFFSET ".$row);
$trucklists->execute(array("searchQuery" => $searchQuery));
$rdatas = $trucklists->fetchAll(PDO::FETCH_ASSOC);

$data=array();
if(!empty($rdatas)){
	foreach ($rdatas as $key => $value) {
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