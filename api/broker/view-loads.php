<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');

$_REQUEST = json_decode($inputJSON, TRUE);

if(empty($token)){
	$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

$draw = isset($_REQUEST['draw']) ? $_REQUEST['draw']: '';
$row =  isset($_REQUEST['start']) ? $_REQUEST['start']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
$columnIndex =isset($_REQUEST['order'][0]['column']) ? $_REQUEST['order'][0]['column']: '';
$columnName =   isset($_REQUEST['columns'][$columnIndex]['data']) ? $_REQUEST['columns'][$columnIndex]['data']: 'id';
$columnSortOrder = isset($_REQUEST['order'][0]['dir']) ? $_REQUEST['order'][0]['dir']: '';
$searchValue =    isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value']: '';
$user_id=isset($_REQUEST['user_id'])? $_REQUEST['user_id'] :0;
$token=isset($_REQUEST['token'])? $_REQUEST['token'] :'';
$operation=isset($_REQUEST['operation'])? $_REQUEST['operation'] :'';
if(empty($user_id)){
		$aVars=array("status"=>0,"msg"=>"User id is empty");
	}elseif(!empty($user_id) && !is_numeric($user_id)){
		$aVars=array("status"=>0,"msg"=>"Invalid user id");
	}else{
		if(!empty($operation)){
	// Search 
	$searchQuery = "%";
	if($searchValue != ''){
		$searchQuery ="%".$searchValue."%";
	}
	if($operation=='pending'){
		
		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND   pickup_date >= CURRENT_DATE ");
		$sel->execute(array("user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		//$totalRecords = count($records);
		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND    (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date >= CURRENT_DATE ");
		$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$records =$sel->fetchAll(PDO::FETCH_ASSOC);
		//$totalRecordwithFilter = count($records);


		$loadslist = $Global->db->prepare("SELECT array_sort(cancel_truckers) = array_sort(confirm_truckers_id) as condition ,approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND    (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date >= CURRENT_DATE  ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);


		$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);

		$arrd=array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				
				 if($value['approve_status']==1 && $value['condition']==''){
				 	continue;
				 }
				$arrd[]=$value;
			}
		}


		$response = array("status"=>1,"draw" =>intval($draw),"iTotalRecords" => count($arrd),"iTotalDisplayRecords" =>count($arrd),"aaData" => $arrd);

	

	
	}elseif($operation=='reopen'){

		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND pickup_date >= CURRENT_DATE AND status IN(0,5,1) AND approve_status IN (0,2)");
		$sel->execute(array("user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecords = $records['allcount'];
		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND status IN(0,5,1)  AND approve_status IN (0,2) AND (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date >= CURRENT_DATE ");
		$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecordwithFilter = $records['allcount'];

		$loadslist = $Global->db->prepare("SELECT approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1)  AND approve_status IN (0,2) AND  (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date >= CURRENT_DATE ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
		$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
		$response = array("status"=>1,"draw" => intval($draw),"iTotalRecords" => $totalRecords,"iTotalDisplayRecords" =>$totalRecordwithFilter,"aaData" => $data);
	}elseif($operation=='expired_loads'){

		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND pickup_date < CURRENT_DATE AND status =0 AND pickup_date < CURRENT_DATE   ");
		$sel->execute(array("user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecords = $records['allcount'];
		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND pickup_date < CURRENT_DATE AND  status=0  AND (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date < CURRENT_DATE  ");
		$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecordwithFilter = $records['allcount'];

		$loadslist = $Global->db->prepare("SELECT approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE user_id=:user_id AND status=0  AND pickup_date < CURRENT_DATE  AND   (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) AND pickup_date < CURRENT_DATE   ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);
		$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
		$response = array("status"=>1,"draw" => intval($draw),"iTotalRecords" => $totalRecords,"iTotalDisplayRecords" =>$totalRecordwithFilter,"aaData" => $data);

	}elseif($operation=='awaiting'){
		

		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE cancel_truckers <> confirm_truckers_id AND  user_id=:user_id AND status IN(1,5) AND  approve_status=1   ");
		//Old one cancel_truckers <> confirm_truckers_id
		 
		$sel->execute(array("user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecords = $records['allcount'];
		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE cancel_truckers <> confirm_truckers_id AND user_id=:user_id  AND status IN(1,5) AND approve_status=1 AND  (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery)   ");
		$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecordwithFilter = $records['allcount']; 

		$loadslist = $Global->db->prepare("SELECT array_sort(cancel_truckers) = array_sort(confirm_truckers_id) as condition,origin_address,destination_address,id, confirm_truckers_id,cancel_truckers,approve_status,id,origin as origin,destination,pickup_date,price,status,load_id FROM loads WHERE cancel_truckers <> confirm_truckers_id AND user_id=:user_id  AND status IN(1,5) AND approve_status=1  AND  (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);

		$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);

		$arr=array();
		if(!empty($data)){
			foreach ($data as $key => $value) {
				if($value['condition']==true){
					continue;
				}
				$arr[]=$value;
			}
		}
		
		// Response
		$response = array("status"=>1,"draw" => intval($draw),"iTotalRecords" => count($arr),"iTotalDisplayRecords" => count($arr),"aaData" => $arr);

	
	}elseif($operation=='ready_pickup'){

		// Total number of records without filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN users ON users.id=loads_trip.user_id WHERE loads.user_id=:user_id AND loads.status=3 AND loads_trip.is_delete=0 AND  loads_trip.load_status=3 AND loads_trip.trucker_status=2 ");
		$sel->execute(array("user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecords = $records['allcount'];
		// Total number of record with filtering
		$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id  INNER JOIN users ON users.id=loads_trip.user_id WHERE loads.user_id=:user_id  and loads.status =3 AND loads_trip.is_delete=0  AND loads_trip.load_status=3  AND loads_trip.trucker_status=2 AND      (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.price :: text ILIKE :searchQuery OR loads.load_id ::text ILIKE :searchQuery)  ");
		$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);
		$totalRecordwithFilter = $records['allcount'];

		$loadslist = $Global->db->prepare("SELECT loads_trip.trucker_id,loads.approve_status,loads.id,loads.origin as origin,loads.destination,loads.pickup_date,loads.price,loads.status,loads.load_id,users.name FROM loads INNER JOIN loads_trip ON loads_trip.load_id=loads.id INNER JOIN users ON users.id=loads_trip.user_id WHERE loads.user_id=:user_id  and loads.status =3  AND loads_trip.is_delete=0 AND loads_trip.load_status=3  AND loads_trip.trucker_status=2 AND   (loads.origin ::text ILIKE :searchQuery OR loads.destination ::text ILIKE :searchQuery OR loads.price :: text ILIKE :searchQuery OR loads.load_id ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."  LIMIT ".$rowperpage." OFFSET ".$row);


		$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
		$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
		// Response
		$response = array("status"=>1,"draw" => intval($draw),"iTotalRecords" => $totalRecords,"iTotalDisplayRecords" => $totalRecordwithFilter,"aaData" => $data);

	}elseif($operation=='expiring'){

			$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']: '';
			$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
			$curr->execute();
			$currDate = $curr->fetch(PDO::FETCH_ASSOC);

			// Total number of records without filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND  status IN(0,5,1) AND approve_status IN (0,2) AND (pickup_date = '".$currDate['current_date']."' OR pickup_date = '".date("Y-m-d")."')");
			$sel->execute(array("user_id"=>$user_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];
			// Total number of record with filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND approve_status IN (0,2) AND  (pickup_date = '".$currDate['current_date']."' OR pickup_date = '".date("Y-m-d")."')
			 AND   (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) ");
			$sel->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

			$loadslist = $Global->db->prepare("SELECT approve_status,id,origin as origin,pickup_date,destination,price,status,load_id FROM loads WHERE user_id=:user_id AND status IN(0,5,1) AND approve_status IN (0,2) AND  (pickup_date = '".$currDate['current_date']."' OR pickup_date = '".date("Y-m-d")."')
			 AND   (origin ::text ILIKE :searchQuery OR destination ::text ILIKE :searchQuery OR price :: text ILIKE :searchQuery OR load_id ::text ILIKE :searchQuery) ORDER BY ".$columnName." ".$columnSortOrder."   LIMIT ".$rowperpage." OFFSET ".$row);

			$loadslist->execute(array("searchQuery" => $searchQuery,"user_id"=>$user_id));
			$data = $loadslist->fetchAll(PDO::FETCH_ASSOC);
			// Response
			$response = array("status"=>1,"draw" => intval($draw),"iTotalRecords" => $totalRecords,"iTotalDisplayRecords" => $totalRecordwithFilter,"aaData" => $data);

	}else{
			$response = array("status"=>0,"msg"=>"Operation Error");
	}

}else{
	$response = array("status"=>0,"msg"=>"Operation Cannot be empty");
}

	}


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}



function array_diff_assoc_recursive($array1, $array2) {
    $difference=array();
    foreach($array1 as $key => $value) {
        if( is_array($value) ) {
            if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
                $difference[$key] = $value;
            } else {
                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                if( !empty($new_diff) )
                    $difference[$key] = $new_diff;
            }
        } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
            $difference[$key] = $value;
        }
    }
    return $difference;
}

function check_diff_multi($array1, $array2){
    $result = array();
    foreach($array1 as $key => $val) {
         if(isset($array2[$key])){
           if(is_array($val) && $array2[$key]){
               $result[$key] = check_diff_multi($val, $array2[$key]);
           }
       } else {
           $result[$key] = $val;
       }
    }

    return $result;
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}


echo json_encode($response);
?>
