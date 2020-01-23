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
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads l  
			INNER JOIN truck_type tt ON l.truck_id = tt.id");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];


// Total number of record with filtering/
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads l JOIN truck_type tt ON l.truck_id = tt.id  AND (l.origin ::text ILIKE :searchQuery OR l.destination ::text ILIKE :searchQuery OR l.price :: text ILIKE :searchQuery OR l.load_id ::text ILIKE :searchQuery
		OR tt.truck_name ::text ILIKE :searchQuery OR l.length ::text ILIKE :searchQuery) ");
$sel->execute(array("searchQuery" => $searchQuery));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records


$load_list = $Global->db->prepare("SELECT l.load_id ,l.origin,l.destination,l.pickup_date,l.delivery_date,l.truck_id,tt.truck_name,l.length,l.price,l.status FROM loads l INNER JOIN truck_type tt
		ON l.truck_id = tt.id AND (l.origin ::text ILIKE :searchQuery OR l.destination ::text ILIKE :searchQuery OR l.price :: text ILIKE :searchQuery OR l.load_id ::text ILIKE :searchQuery
		OR tt.truck_name ::text ILIKE :searchQuery OR l.length ::text ILIKE :searchQuery OR l.pickup_date ::text ILIKE :searchQuery OR l.delivery_date ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
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