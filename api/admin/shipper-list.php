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
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users u JOIN shipper sh ON u.id = sh.user_id AND u.user_type='shipper'");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users u JOIN shipper sh ON u.id = sh.user_id AND u.user_type='shipper' AND (u.name ::text ILIKE :searchQuery OR sh.phone ::text ILIKE :searchQuery) ");
$sel->execute(array("searchQuery" => $searchQuery));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records
$shipperlist = $Global->db->prepare("SELECT u.id,u.name,u.email,u.user_type,u.status,sh.phone FROM users u JOIN shipper sh on (u.name ::text ILIKE :searchQuery OR sh.phone ::text ILIKE :searchQuery) AND u.user_type='shipper' AND u.id = sh.user_id ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
$shipperlist->execute(array("searchQuery" => $searchQuery));
$data = $shipperlist->fetchAll(PDO::FETCH_ASSOC);
// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);
echo json_encode($response);
?>