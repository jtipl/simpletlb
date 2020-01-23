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
$sel = $Global->db->prepare("SELECT 
						count(*) allcount
						FROM loads l
						INNER JOIN truck_type tt ON l.truck_id = tt.id
						INNER JOIN users u ON l.user_id = u.id
						WHERE 
						u.user_type ='broker' ");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT 
						count(*) allcount
						FROM loads l
						INNER JOIN truck_type tt ON l.truck_id = tt.id
						INNER JOIN users u ON l.user_id = u.id
						WHERE 
						u.user_type ='broker' ");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records
$brokerlist = $Global->db->prepare("
						SELECT 
						u.id,u.name,u.email, l.load_id , l.origin ,l.destination,
						l.weight,l.length,l.price,l.truck_id,tt.truck_name,l.status
						FROM loads l
						INNER JOIN truck_type tt ON l.truck_id = tt.id
						INNER JOIN users u ON l.user_id = u.id
						WHERE 
						u.user_type ='broker' 
							AND (
								l.origin ::text ILIKE :searchQuery 
								OR 
								l.destination ::text ILIKE :searchQuery
								OR 
								l.weight ::text ILIKE :searchQuery
								OR 
								l.length ::text ILIKE :searchQuery
								OR 
								l.price ::text ILIKE :searchQuery
								OR 
								l.weight ::text ILIKE :searchQuery
								OR
								tt.truck_name ::text ILIKE :searchQuery
							) LIMIT ".$rowperpage." OFFSET ".$row);
$brokerlist->execute(array("searchQuery" => $searchQuery));
$data = $brokerlist->fetchAll(PDO::FETCH_ASSOC);
// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);
echo json_encode($response);
?>