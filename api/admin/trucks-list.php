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
$trucklists = $Global->db->prepare("SELECT * FROM truck_type WHERE (truck_name ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$rowperpage." OFFSET ".$row);
$trucklists->execute(array("searchQuery" => $searchQuery));
$data = $trucklists->fetchAll(PDO::FETCH_ASSOC);

// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>


