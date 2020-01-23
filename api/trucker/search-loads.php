<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :'';

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

	$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
	$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
	$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
	$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
	$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: '';
	$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
	$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
	$origin=isset($_REQUEST['origin'])? $_REQUEST['origin'] :'';
	$destination=isset($_REQUEST['destination'])? $_REQUEST['destination'] :'';
	$pickup_date=isset($_REQUEST['pickup_date'])? $_REQUEST['pickup_date'] :'';
	$truck_load_type=isset($_REQUEST['truck_load_type'])? $_REQUEST['truck_load_type'] :'';
	$truck_type=isset($_REQUEST['truck_type'])? $_REQUEST['truck_type'] :'';
	$weight=isset($_REQUEST['weight'])? $_REQUEST['weight'] :0;
	$deadhead=isset($_REQUEST['deadhead'])? $_REQUEST['deadhead'] :0;
	$des_deadhead=isset($_REQUEST['des_deadhead'])? $_REQUEST['des_deadhead'] :0;
	$action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';

	$orglat=isset($_REQUEST['orglat'])? $_REQUEST['orglat'] :0;
	$orglon=isset($_REQUEST['orglon'])? $_REQUEST['orglon'] :0;
	$deslat=isset($_REQUEST['destination_lat'])? $_REQUEST['destination_lat'] :0;
	$deslon=isset($_REQUEST['destination_lng'])? $_REQUEST['destination_lng'] :0;
	//Get Trucker Id
	$trucker_det = $Global->db->prepare("SELECT id FROM trucker WHERE status = :status AND user_id =:user_id ");
	$trucker_det->execute(array("status"=>1,"user_id"=>$user_id));
	$trrow = $trucker_det->fetch(PDO::FETCH_ASSOC);

	$datecheck=date_parse($pickup_date);

	//Validation for search loads 
	/*if(empty($origin)){
		$response=array("status"=>0,"msg"=>"Please select the origin");
	}else*/
	$validation=false;
	if(!empty($origin))
		$validation=true;

	
	if(!empty($deadhead) && !is_numeric($deadhead) && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the numeric value for origin deadhead");
	}elseif(!empty($des_deadhead) && !is_numeric($des_deadhead) && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the numeric value for destination deadhead");
	}elseif(!empty($pickup_date) && $datecheck['year']==false && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the date format");
	}elseif(!empty($weight) && !is_numeric($weight) && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the numeric value for origin deadhead");
	}elseif(empty($orglat) && !empty($origin) && $validation==true ){
		$response=array("status"=>0,"msg"=>"Please enter the origin latitude");
	}elseif(empty($orglon) && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the origin longitude");
	}/*elseif(!empty($orglat) && validacoorignates($orglat)==false && $validation==true ){
		$response=array("status"=>0,"msg"=>"Please enter the valid origin latitude");
	}elseif(!empty($orglon) && validacoorignates($orglon)==false && $validation==true ){
		$response=array("status"=>0,"msg"=>"Please enter the valid origin longitude");
	}elseif(!empty($deslat) && validacoorignates($deslat)==false  && $validation==true){
		$response=array("status"=>0,"msg"=>"Please enter the valid destination latitude");
	}elseif(!empty($deslon) && validacoorignates($deslon)==false && $validation==true ){
		$response=array("status"=>0,"msg"=>"Please enter the valid destination longitude");
	}*/else{

		$pdate=NULL;
	if($pickup_date!=''){
		$dt=explode("/", $pickup_date);
		$pdate=$dt[2].'-'.$dt[0].'-'.$dt[1];
	}
	// Search 
	$searchQuery = "%";
	if($searchValue != ''){
		$searchQuery ="%".$searchValue."%";
	}

	//Check Zipcode search Origin
	if(!empty($origin)){

		$origin_exp=explode(',',$origin);
		$origin_count=count($origin_exp);
		$originzips=str_replace( ' ', '', $origin_exp[1]);
		$orgzip=Zipcode($originzips);
		if($origin_count === 2 && $orgzip == false){
		//	$origin_st=$origin_exp[0];
			$origin = $origin_exp[0];
			$orgval="loads.origin_state";

		}else if($orgzip==true){
			$zip= preg_match_all("/[A-Z]+|\d+/",$originzips, $orgn_zip);
			$origin_zipcode=$orgn_zip[0][1];
			$origin_state_check = $Global->db->prepare("SELECT state FROM public.zipcode where zip_code= :origin_zip");
			$origin_state_check->execute(array("origin_zip"=>$origin_zipcode));
			$origin_state_name= $origin_state_check->fetch(PDO::FETCH_ASSOC);
			$origin = $origin_state_name['state'];
			$orgval="loads.origin_state";
		}else{
			$origin=$origin;
			$orgval="loads.origin";
		}


	}

	$re_open_status='';
	if($action=="all_search_loads"){
		$re_open_status="AND loads.status NOT IN('2','3','4')";
	}else if($action=="re_open"){
		$re_open_status="AND loads.status IN ('5')";
	}
	//Check Zipcode search Destination
	if(!empty($destination)){
		$destination_exp=explode(',',$destination);
		$destinat_count= count($destination_exp);
		$destinationzips=str_replace( ' ', '', $destination_exp[1]);
		$destinationzipszip=Zipcode($destinationzips);
		if($destinat_count === 2 && $destinationzipszip == false){
			$destination = $destination_exp[0];
			$desval="loads.destination_state";
		}else if($destinationzipszip==true){
			$zip= preg_match_all("/[A-Z]+|\d+/",$destinationzips, $destination_zip);
			$destination_zipcode=$destination_zip[0][1];
			$destination__state_check = $Global->db->prepare("SELECT state FROM public.zipcode where zip_code = :origin_zip");
			$destination__state_check->execute(array("origin_zip"=>$destination_zipcode));
			$destination_state_name= $destination__state_check->fetch(PDO::FETCH_ASSOC);
			$destination = $destination_state_name['state'];
			$desval="loads.destination_state";
		}else{
			$destination=$destination;
			$desval="loads.destination";
		}
	}

	$Query="";
	$origin_deadhead=true;
	$destination_deadhead=true;
	$org_query="";
	$deadhead_records=true;
	$Query="";
	if($origin!=''){
		$Query .="AND ".$orgval." ='".$origin."'";
	}if($destination!=''){
		$Query .="AND ".$desval." = '".$destination."'";
	}if($pickup_date!=''){
		$Query .="AND loads.pickup_date = '".$pdate."'";
	}if($truck_load_type!=''){
		$Query .="AND loads.truck_load_type = '".$truck_load_type."'";
	}if($weight!=''){
		$Query .="AND loads.weight = '".$weight."'";
	}if($truck_type!=''){
		$Query .="AND loads.truck_id IN(".$truck_type.")";
	}if($origin!='' && $deadhead!=''){
		$vararr=array(
			"deadhead"=>$deadhead,
			"orglat"=>$orglat,
			"orglon"=>$orglon
		);
		$orgdeadhead=originDeadhead($vararr,"",$Global);
		if(!empty($orgdeadhead))
			$Query .="OR loads.id IN(".$orgdeadhead.")";

	}if($destination!='' && $des_deadhead!=''){
		$vararr=array(
			"des_deadhead"=>$des_deadhead,
			"deslat"=>$deslat,
			"deslon"=>$deslon
		);
		$desdeadhead=destinationDeadhead($vararr,"",$Global);
		if(!empty($desdeadhead))
			$Query .="AND loads.id IN(".$desdeadhead.")";
		

	}if($origin!='' && $deadhead!='' &&  $destination!='' && $des_deadhead!=''){

		$vararr=array(
			"des_deadhead"=>$des_deadhead,
			"deslat"=>$deslat,
			"deslon"=>$deslon,
			"deadhead"=>$deadhead,
			"orglat"=>$orglat,
			"orglon"=>$orglon
		);
		$alldeadhead=Deadhead($vararr,"",$Global);
		$deadhead_records=$alldeadhead['deadhead_records'];

		if($deadhead_records==true)
			$Query .="AND loads.id IN(".$alldeadhead['load_id'].")";
	}


	// Total number of records without filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users INNER JOIN loads ON users.id = loads.user_id AND users.status=1 AND loads.id NOT IN(SELECT load_id FROM loads_trip WHERE trucker_id=:trucker_id AND loads.pickup_date >= CURRENT_DATE AND loads.enable=0)");
	$sel->execute(array(":trucker_id"=>$trrow['id']));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecords = $records['allcount'];
	// Total number of record with filtering
	$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users INNER JOIN loads ON users.id = loads.user_id LEFT JOIN truck_type as truck ON truck.id=loads.truck_id WHERE  (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.price :: text ILIKE :searchQuery OR loads.load_id ::text ILIKE :searchQuery OR users.business_name :: text ILIKE :searchQuery OR loads.weight :: text ILIKE :searchQuery OR truck.truck_name ::text ILIKE :searchQuery  OR  loads.length :: text ILIKE :searchQuery) AND  users.status=1 AND loads.id NOT IN(SELECT load_id FROM loads_trip WHERE trucker_id=:trucker_id AND cancel_status=0  AND history_status!=2)  AND loads.id NOT IN(SELECT load_id FROM loads_trip WHERE trucker_id=:trucker_id AND load_status=2 AND cancel_status=0)   ".$re_open_status."  AND loads.pickup_date >= CURRENT_DATE AND loads.enable=0  $Query");
	$sel->execute(array("searchQuery" => $searchQuery,":trucker_id"=>$trrow['id']));
	$records =$sel->fetch(PDO::FETCH_ASSOC);
	$totalRecordwithFilter = $records['allcount'];
	// Fetch records
	$loadslist = $Global->db->prepare("SELECT loads.approve_status,loads.created_date, loads.broker_id,truck.truck_name,loads.length, to_char(loads.delivery_date,'MM-DD-YYYY') as delivery_date,loads.id,loads.weight,loads.truck_load_type,loads.truck_id,to_char(loads.pickup_date,'MM-DD-YYYY') as pickup_date,loads.id,loads.origin as origin,loads.destination,loads.price,loads.status,loads.load_id,users.business_name as broker FROM users INNER JOIN loads ON users.id = loads.user_id LEFT JOIN truck_type as truck ON truck.id=loads.truck_id WHERE (loads.origin ::text ILIKE :searchQuery OR truck.truck_name ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.price :: text ILIKE :searchQuery OR loads.load_id ::text ILIKE :searchQuery OR users.business_name :: text ILIKE :searchQuery OR loads.weight :: text ILIKE :searchQuery OR  loads.length :: text ILIKE :searchQuery ) AND users.status=1 AND loads.id NOT IN(SELECT load_id FROM loads_trip WHERE trucker_id=:trucker_id AND cancel_status=0  AND history_status!=2)  AND loads.id NOT IN(SELECT load_id FROM loads_trip WHERE trucker_id=:trucker_id AND load_status=2 AND cancel_status=0)  ".$re_open_status."  AND loads.pickup_date >= CURRENT_DATE AND loads.enable=0 $Query ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);

	$loadslist->execute(array("searchQuery" => $searchQuery,":trucker_id"=>$trrow['id']));
	$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
	$resdata=array();
	if(!empty($data)){
		foreach ($data as $key => $value) {
		$sel = $Global->db->prepare("SELECT wish_list_status FROM wish_list WHERE load_id=:load_id AND user_id=:user_id");
		$sel->execute(array("user_id"=>$user_id,"load_id"=>$value['id']));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
			$wish_status=$records['wish_list_status'];
			if ($wish_status == '' && $wish_status ==null && $wish_status == 0) {

				$wish_list_status=0;
			}else{
				$wish_list_status=$wish_status;
			}
			$value['wish_status']=$wish_list_status;
			$value['created_date']=$Global->timeAgo($value['created_date']);
			$resdata[]=$value;
		}
	}
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" =>  ($deadhead_records==true) ? $totalRecordwithFilter: 0,
		"data" => ($deadhead_records==true) ? $resdata: array() ,
		"status" => 1,
		"origin_deadhead"=>$deadhead_records
	);

	}

		
}else{
	$response=array("status"=>2,"msg"=>"Invalid Token");

}
echo json_encode($response);
//Check if Zipcode in string
function Zipcode($string){
  if (preg_match('~[0-9]+~', $string)) {
    return true;
  }else{
  	return false;
  }
}
//Origin deadhead loads
function originDeadhead($arr=array(),$condition="",$Global=""){
	$orglon=$arr['orglon'];
	$orglat=$arr['orglat'];
	$deadhead=$arr['deadhead'];
	$distances=$Global->db->prepare("SELECT id FROM (SELECT  *,(3959 * acos( cos( radians( $orglat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($orglon) ) + sin( radians($orglat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM loads) al WHERE distance < ".$deadhead." AND pickup_date >= CURRENT_DATE");
	$distances->execute(array());
	$getdisd_query=$distances->fetchAll(PDO::FETCH_ASSOC);
	$or_elements = array();
	if(!empty($getdisd_query)){
		foreach($getdisd_query as $va) {
			$or_elements[] = $va['id'];
		}
	} 

	if(empty($or_elements))
		$origin_loads="";
	else
		$origin_loads=implode(',', $or_elements);
	
	return $origin_loads;

}
//Destination deadhead loads
function destinationDeadhead($arr=array(),$condition="",$Global=""){
	$deslon=$arr['deslon'];
	$deslat=$arr['deslat'];
	$des_deadhead=$arr['des_deadhead'];
	
	$distance=$Global->db->prepare("SELECT id FROM (SELECT  *,(3959 * acos( cos( radians( $deslat) ) * cos( radians( destination_lat ) ) * cos( radians( destination_lng ) - radians($deslon) ) + sin( radians($deslat) ) * sin( radians( destination_lat ) ) ) ) AS distance FROM loads) al WHERE distance < ".$des_deadhead." AND pickup_date >= CURRENT_DATE");


	$distance->execute(array());
	$getdis_query=$distance->fetchAll(PDO::FETCH_ASSOC);
	$elements = array();
	if(!empty($getdis_query)){
		foreach($getdis_query as $va) {
			$elements[] = $va['id'];
		}
	} 


	if(empty($elements))
		$disloads="";
	else
		$disloads=implode(',', $elements);


	return $disloads;
}

function Deadhead($arr=array(),$condition="",$Global=""){
	$orglon=$arr['orglon'];
	$orglat=$arr['orglat'];
	$deadhead=$arr['deadhead'];
	$distances=$Global->db->prepare("SELECT id FROM (SELECT  *,(3959 * acos( cos( radians( $orglat) ) * cos( radians( origin_lat ) ) * cos( radians( origin_lng ) - radians($orglon) ) + sin( radians($orglat) ) * sin( radians( origin_lat ) ) ) ) AS distance FROM loads) al WHERE distance < ".$deadhead." AND pickup_date >= CURRENT_DATE");

	$distances->execute(array());
	$getdisd_query=$distances->fetchAll(PDO::FETCH_ASSOC);
	$or_elements = array();
	if(!empty($getdisd_query)){
		foreach($getdisd_query as $va) {
			$or_elements[] = $va['id'];
		}
	} 


	$deslon=$arr['deslon'];
	$deslat=$arr['deslat'];
	$des_deadhead=$arr['des_deadhead'];
	
	$distance=$Global->db->prepare("SELECT id FROM (SELECT  *,(3959 * acos( cos( radians( $deslat) ) * cos( radians( destination_lat ) ) * cos( radians( destination_lng ) - radians($deslon) ) + sin( radians($deslat) ) * sin( radians( destination_lat ) ) ) ) AS distance FROM loads) al WHERE distance < ".$des_deadhead." AND pickup_date >= CURRENT_DATE");


	$distance->execute(array());
	$getdis_query=$distance->fetchAll(PDO::FETCH_ASSOC);
	$elements = array();
	if(!empty($getdis_query)){
		foreach($getdis_query as $va) {
			$elements[] = $va['id'];
		}
	} 

	if(!empty($elements) && !empty($or_elements)){
		$all_loads=array_intersect($or_elements,$elements);
		$deadhead=true;
		if(empty($all_loads))
			$deadhead=false;
		else
			$deadhead=true;

		$all_loads=implode(',', $all_loads);
	}else{
		$all_loads="";
		$deadhead=false;

	}



	return array("load_id"=>$all_loads,"deadhead_records"=>$deadhead);


}

function validacoorignates($value=""){
	 $pattern ='/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/';
       
  if (preg_match($pattern, $value)) {
        return true;
    } else {
        return false;
    }
}

?>