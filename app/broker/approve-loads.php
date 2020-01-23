<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: '';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
$user_id=isset($_SESSION['user_id'])? $_SESSION['user_id'] :'';
// Search 
$searchQuery = "%";
if($searchValue != ''){
    $searchQuery ="%".$searchValue."%";
}
// Total number of records without filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id");
$sel->execute(array("user_id"=>$user_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecords = $records['allcount'];
// Total number of record with filtering
$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id  AND (orgin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) ");
$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = $records['allcount'];
// Fetch records

/*echo "select DISTINCT u.id,u.name,u.email,br.phone,lt.load_id,lt.broker_id,l.orgin,l.destination from users u inner join broker br on
u.id = br.user_id inner join loads_trip lt on br.id = lt.broker_id inner join loads l
on lt.load_id = l.id and lt.load_id = '".$_REQUEST["load_id"]."' and lt.broker_id = '".$_REQUEST["broker_id"]."'";exit;
*/
/*
$loadslist = $Global->db->prepare("SELECT id,orgin,destination,price,status,load_id FROM loads WHERE user_id=:user_id  AND   (orgin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
array("searchQuery" => $searchQuery,"user_id"=>$user_id)) */


$loadslist = $Global->db->prepare("select DISTINCT u.id,u.name,u.email,br.phone,lt.id,lt.load_id,lt.broker_id,lt.trucker_id,l.id,l.orgin,l.destination,l.status from users u inner join broker br 
on u.id = br.user_id inner join loads_trip lt on br.id = lt.broker_id inner join loads l on  
lt.load_id = '".$_REQUEST["load_id"]."' and l.status = '1'  and lt.load_id = l.id");
$loadslist->execute();
$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
// Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);
echo json_encode($response);
?>