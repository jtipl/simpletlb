<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();

$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id = isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : '';
$popup_action=isset($_REQUEST['popup_action']) ? trim($_REQUEST['popup_action']) : '';
$CheckvalidToken=$Global->CheckValidToken($token);



if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	
	$edituniqueid=isset($_REQUEST['edituniqueid']) ? trim($_REQUEST['edituniqueid']) : '';
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
    // trucker_id=:trucker_id AND veh_id_no=:veh_id_no

    $stmt = $Global->db->prepare("SELECT id FROM vehicle_details WHERE id!=:id AND veh_id_no=:veh_id_no  ");
	$stmt->execute(array("id"=>$edituniqueid,"veh_id_no"=>$veh_id_no));
	$stmt_result = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($stmt_result);exit;
	//echo $stmt_result["veh_id_no"]."---".$veh_id_no;exit;
	if(empty($stmt_result)){
	    $mystring = $veh_id_no;
		$findme   = 'ioq';
		$pos = strpos($mystring, $findme);
		
		if (preg_match('/^[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+$/', $mystring)) {
		    $flag=1;
		} else {
		    $flag=0;
		}
		if(strlen($veh_id_no) < 17){
			$aVars=array("status"=>0,"msg"=>"VIN number can be maximum of 17 characters","popup"=>false); 
		}
	    else if(strlen($veh_make) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Make information can be maximum of 20 characters","popup"=>false); 
	    } else if(strlen($veh_model) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Model information can be maximum of 20 characters","popup"=>false); 
	    } else if(strlen($veh_type) > 20){
	    	$aVars=array("status"=>0,"msg"=>"Vehicle Type information can be maximum of 20 characters","popup"=>false); 
	    } else {
	    	if($flag==0){
	    		$aVars=array("status"=>0,"msg"=>array("veh_id_no"=>"Alphabets 'I, O, Q' are not allowed in VIN number","popup"=>false)); 
	    	} else if($flag==1){
	    		$aVars=array("status"=>3,"popup"=>true);
	    		if($popup_action=="update-vehicle-details"){
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
					$conditions =array("id"=>$edituniqueid);
					$Global->UpdateData("vehicle_details",$datas,$conditions);
					$aVars=array("status"=>1,"msg"=>"Vehicle details updated successfully"); 
				}
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