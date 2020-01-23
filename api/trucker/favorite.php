<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);
$trucker_id=isset($_POST['trucker_id']) ? trim($_POST['trucker_id']) : '';
$broker_id=isset($_POST['broker_id']) ? trim($_POST['broker_id']) : '';
$shipper_id=isset($_POST['shipper_id']) ? trim($_POST['shipper_id']) : '';
$favorite_status=isset($_POST['favorite_status']) ? $_POST['favorite_status'] : 0;
///$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;


if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
		if($broker_id != 0  && $broker_id != null && $broker_id != ''){
				$stmt = $Global->db->prepare("SELECT id FROM favorite WHERE trucker_id=:trucker_id AND broker_id=:broker_id AND favorite_type='broker_favorite' ");
				$stmt->execute(array("trucker_id"=>$trucker_id,"broker_id"=>$broker_id));
				$stmt_result = $stmt->fetch(PDO::FETCH_ASSOC);
				if(empty($stmt_result)){
					$datas=array(
						'trucker_id' => $trucker_id,
						'broker_id' => $broker_id,
						'status' => $favorite_status,
						'favorite_type' => "broker_favorite",
						'created_by' => $user_id			
					);
					$Global->InsertData("favorite",$datas);
				$aVars=array("status"=>1 , "msg"=>"Favorite successfully");
				}else{
						$deldata=array(
					        "status"		=>$favorite_status,
							'updated_by' 	=> $user_id,	
							'updated_date'  => date("Y-m-d H:i:s")
					    );
					    $del_conditions =array("broker_id"=>$broker_id,"trucker_id"=>$trucker_id,"favorite_type"=>"broker_favorite");
					    $Global->UpdateData("favorite",$deldata,$del_conditions);
						$aVars=array("status"=>1 , "msg"=>"Unfavorite successfully");
				}

		}else if($shipper_id != 0  && $shipper_id != null && $shipper_id != ''){
				$stmt = $Global->db->prepare("SELECT id FROM favorite WHERE trucker_id=:trucker_id AND shipper_id=:shipper_id AND favorite_type='shipper_favorite' ");
				$stmt->execute(array("trucker_id"=>$trucker_id,"shipper_id"=>$shipper_id));
				$stmt_result = $stmt->fetch(PDO::FETCH_ASSOC);
				if(empty($stmt_result)){
					$datas=array(
						'trucker_id' => $trucker_id,
						'shipper_id' => $shipper_id,
						'status' => $favorite_status,
						'favorite_type' => "shipper_favorite",
						'created_by' => $user_id			
					);
					$Global->InsertData("favorite",$datas);
				$aVars=array("status"=>1 , "msg"=>"Favorite successfully");
				}else{
						$deldata=array(
					        "status"		=>$favorite_status,
							'updated_by' 	=> $user_id,	
							'updated_date'  => date("Y-m-d H:i:s")
					    );
					    $del_conditions =array("shipper_id"=>$shipper_id,"trucker_id"=>$trucker_id,"favorite_type"=>"shipper_favorite");
					    $Global->UpdateData("favorite",$deldata,$del_conditions);
						$aVars=array("status"=>1 , "msg"=>"Unfavorite successfully");
				}

			
		}

	 
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>