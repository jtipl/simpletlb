<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);

$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$origin=isset($_POST['origin']) ? trim($_POST['origin']) : '';
$destination=isset($_POST['destination']) ? trim($_POST['destination']) : '';
$pickup_date=isset($_POST['pickup_date']) ? $_POST['pickup_date'] : '';
$truck_load_type=isset($_POST['truck_load_type']) ? $_POST['truck_load_type'] :'';
$truck_type=isset($_POST['truck_type']) ? $_POST['truck_type'] : '';
$weight=!empty($_POST['weight']) ? $_POST['weight'] : 0;
$deadhead=!empty($_POST['deadhead']) ? trim($_POST['deadhead']) : 0;
$des_deadhead=!empty($_POST['des_deadhead']) ? trim($_POST['des_deadhead']) : 0;
$search_name=isset($_POST['search_name']) ? trim($_POST['search_name']) : '';
$operation=isset($_POST['operation']) ? trim($_POST['operation']) : '';
$orgin_lng=isset($_POST['orgin_lng']) ? trim($_POST['orgin_lng']) : '';
$orgin_lat=isset($_POST['orgin_lat']) ? $_POST['orgin_lat'] : '';
$destination_lat=isset($_POST['destination_lat']) ? $_POST['destination_lat'] :'';
$destination_lng=isset($_POST['destination_lng']) ? $_POST['destination_lng'] : '';

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

$count_data=$Global->db->prepare("SELECT COUNT(*) AS total FROM search_save WHERE user_id=:user_id AND status=1");
$count_data->execute(array("user_id"=>$user_id));
$count_dataser=$count_data->fetch(PDO::FETCH_ASSOC);
	if ($count_dataser['total'] <5) {

		$name_valid=$Global->CharacterCheck($search_name);

		 	 $search_check=$Global->db->prepare("SELECT search_name FROM search_save WHERE search_name  ILIKE  :search_name AND user_id=:user_id  AND  status=1");
			$search_check->execute(array("search_name"=>$search_name,"user_id"=>$user_id));
			$search_rowchk=$search_check->fetch(PDO::FETCH_ASSOC);

			if(empty($origin)){
				$aVars=array("status"=>0 , "msg"=>"Please enter the origin");
			}elseif(empty($search_name)){
				$aVars=array("status"=>0 , "msg"=>"Please enter the name");
			}elseif(!empty($search_name) && $name_valid==false ){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid name");
			}elseif(!empty($search_name) && is_numeric($search_name)){
				$aVars=array("status"=>0,"msg"=>"Please enter a valid name");
			}elseif(empty($search_rowchk)){
				$data = array(
				"user_id" => $user_id,
				"search_name" =>$search_name,
				"origin" => $origin,
				"destination" => $destination,
				"pickup_date" => $pickup_date,
				"truck_load_type" => $truck_load_type,
				"weight" => !empty($_POST['weight']) ? $_POST['weight'] : 0,
				"truck_id" => $truck_type,
				"deadhead" =>!empty($_POST['deadhead']) ? $_POST['deadhead'] : 0 ,
				"des_deadhead" => !empty($_POST['des_deadhead']) ? $_POST['des_deadhead'] : 0,
				"orgin_lng" =>$orgin_lng,
				"orgin_lat" =>$orgin_lat,
				"destination_lat" =>$destination_lat,
				"destination_lng" =>$destination_lng,
				"created_by" => $user_id,
				"status"=>1
				);
				$Global->InsertData("search_save",$data);
				$aVars=array("status"=>1 , "msg"=>"Search Criteria added Successfully");
			}else{
				$aVars=array("status"=>2 , "msg"=>"This name already saved");
			}
		
	}else{

		$aVars=array("status"=>2 , "msg"=>"You have only save five Search Criteria");
	}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>
