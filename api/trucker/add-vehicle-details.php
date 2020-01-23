<?php
error_reporting(0);
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);


if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

	$user_id=isset($_REQUEST['user_id']) ? trim($_REQUEST['user_id']) : '';
	//echo $user_id;exit;
	$popup_action=isset($_REQUEST['popup_action']) ? trim($_REQUEST['popup_action']) : '';
	$app_type = isset($_REQUEST['app_type']) ? trim($_REQUEST['app_type']) : '';
	

	$veh_id_no=isset($_REQUEST['veh_id_no']) ? trim($_REQUEST['veh_id_no']) : '';
	$veh_unit=isset($_REQUEST['veh_unit']) ? trim($_REQUEST['veh_unit']) : '';
	$veh_make=isset($_REQUEST['veh_make']) ? trim($_REQUEST['veh_make']) : '';
	$veh_model=isset($_REQUEST['veh_model']) ? trim($_REQUEST['veh_model']) : '';
	$veh_type=isset($_REQUEST['veh_type']) ? trim($_REQUEST['veh_type']) : '';
	$veh_weight=isset($_REQUEST['veh_weight']) ? trim($_REQUEST['veh_weight']) : '';
	$veh_length=isset($_REQUEST['veh_length']) ? trim($_REQUEST['veh_length']) : '';
	$veh_height=isset($_REQUEST['veh_height']) ? trim($_REQUEST['veh_height']) : '';
	
	$TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];

    $stmt = $Global->db->prepare("SELECT * FROM vehicle_details WHERE trucker_id=:trucker_id AND veh_id_no=:veh_id_no ");
	$stmt->execute(array("trucker_id"=>$trucker_id,"veh_id_no"=>$veh_id_no));
	$stmt_result = $stmt->fetch();
	if($stmt_result["veh_id_no"]==""){
		$mystring = $veh_id_no;
		$findme   = 'ioq';
		$pos = strpos($mystring, $findme);
		if (preg_match('/^[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+$/', $mystring)) {
		    $flag=1;
		} else {
		    $flag=0;
		}
		if(empty($user_id)){
			$aVars=array("status"=>0,"msg"=>"User id is empty","popup"=>false);
		} elseif(!empty($user_id) && !is_numeric($user_id)){
			$aVars=array("status"=>0,"msg"=>"Invalid user id","popup"=>false);
		} else if(strlen($veh_id_no) < 17){
			$aVars=array("status"=>0,"msg"=>"VIN number can be maximum of 17 characters","popup"=>false); 
		} else if(strlen($veh_make) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Make information can be maximum of 20 characters","popup"=>false); 
	    } else if(strlen($veh_model) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Model information can be maximum of 20 characters","popup"=>false); 
	    } else if(strlen($veh_type) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Type information can be maximum of 20 characters","popup"=>false); 
	    } else {
	    	if($flag==0){
	    		$aVars=array("status"=>0,"msg"=>array("veh_id_no"=>"Alphabets 'I, O, Q' are not allowed in VIN number")); 
	    	} else if($flag==1){
	    		$app_check = $Global->CheckApptype($app_type);
	    		//echo "app check = ".$app_check;exit;
	    		//echo "app_type = ".$app_type." function =".$Global->CheckApptype($app_type);exit;
	    		$aVars=array("status"=>3,"popup"=>true);
	    		if($popup_action=="update-vehicle-details" || ($app_check==0 || $app_check=="")){
		    		$datas=array(
						'user_id' => $user_id,
						'trucker_id' => $trucker_id,
						'veh_id_no' => $veh_id_no,
						'veh_unit' => $veh_unit,
						'veh_make' => $veh_make,
						'veh_model' => $veh_model,
						'veh_type' => $veh_type,
						'veh_weight' => $veh_weight,
						'veh_length' => $veh_length,
						'veh_height' => $veh_height
					);
					$Global->InsertData("vehicle_details",$datas);
					$aVars=array("status"=>1,"msg"=>"Vehicle details added successfully"); 
				} /*else {
					$aVars=array("status"=>0 , "msg"=>"Please check valid ios and android");
				}*/
			}
		}
	} else {
		$aVars=array("status"=>0,"msg"=>array("veh_id_no"=>"Vehicle identification number already exit","popup"=>false)); 
	}
	 
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>