<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$draw = $_REQUEST['draw'] ? $_REQUEST['draw'] : '';
$row = $_REQUEST['start'] ? $_REQUEST['start'] : '0';
$rowperpage = $_REQUEST['length'] ? $_REQUEST['length'] : '10'; 
$columnIndex = $_REQUEST['order'][0]['column']; 
$columnName = $_REQUEST['columns'][$columnIndex]['data']; 
$columnSortOrder = $_REQUEST['order'][0]['dir']; 
$searchValue = $_REQUEST['search']['value']; 
// Search 
$searchQuery = "%";
if($searchValue != ''){
	$searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM delivery_mail as deli INNER JOIN mail_list as mail ON
 		 deli.mail_list_id=mail.id INNER JOIN admin_users as users ON deli.user_id=users.id ");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];


// Total number of record with filtering/
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM delivery_mail as deli INNER JOIN mail_list as mail ON
 		 deli.mail_list_id=mail.id  INNER JOIN admin_users as users ON deli.user_id=users.id AND (deli.id ::text ILIKE :searchQuery OR deli.mail_list_id ::text ILIKE :searchQuery OR deli.user_id ::text ILIKE :searchQuery OR deli.to_address ::text ILIKE :searchQuery OR deli.open_status ::text ILIKE :searchQuery OR deli.delivery_status ::text ILIKE :searchQuery OR deli.created_date ::text ILIKE :searchQuery OR deli.status ::text ILIKE :searchQuery OR deli.to_addr_id  ::text ILIKE :searchQuery OR mail.id ::text ILIKE :searchQuery OR mail.user_id ::text ILIKE :searchQuery OR mail.subject ::text ILIKE :searchQuery OR mail.mail_template ::text ILIKE :searchQuery OR mail.cont_type ::text ILIKE :searchQuery)");
$sel->execute(array("searchQuery" => $searchQuery));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records


$load_list = $Global->db->prepare("SELECT users.user_name,deli.id, deli.mail_list_id, deli.user_id, deli.to_address, deli.open_status, deli.delivery_status, to_char(deli.created_date,'MM-DD-YYYY') as created_date, deli.status, deli.to_addr_id ,mail.id, mail.user_id, mail.subject, mail.mail_template,mail.cont_type FROM  delivery_mail as deli INNER JOIN mail_list as mail ON deli.mail_list_id=mail.id  INNER JOIN admin_users as users ON deli.user_id=users.id  AND (deli.id ::text ILIKE :searchQuery OR deli.mail_list_id ::text ILIKE :searchQuery OR deli.user_id ::text ILIKE :searchQuery OR deli.to_address ::text ILIKE :searchQuery OR deli.open_status ::text ILIKE :searchQuery OR deli.delivery_status ::text ILIKE :searchQuery OR deli.created_date ::text ILIKE :searchQuery OR deli.status ::text ILIKE :searchQuery OR deli.to_addr_id  ::text ILIKE :searchQuery OR mail.id ::text ILIKE :searchQuery OR mail.user_id ::text ILIKE :searchQuery OR mail.subject ::text ILIKE :searchQuery OR mail.mail_template ::text ILIKE :searchQuery OR mail.cont_type ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$load_list->execute(array("searchQuery" => $searchQuery));
$data = $load_list->fetchAll(PDO::FETCH_ASSOC);
// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);
echo json_encode($response);
?>