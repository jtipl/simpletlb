<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);

$trucker_id=isset($_POST['trucker_id']) ? trim($_POST['trucker_id']) : '';
$broker_id=isset($_POST['broker_id']) ? trim($_POST['broker_id']) : '';
$load_id=isset($_POST['load_id']) ? $_POST['load_id'] : 0;
$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$wish_status=isset($_POST['wish_status']) ? $_POST['wish_status'] : 0;

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

	$rowchk = $Global->TruckerUserDetails($user_id);

	$wishcheck=$Global->db->prepare("SELECT load_id,wish_list_status FROM wish_list WHERE load_id=:load_id AND user_id=:user_id AND status=1");
		$wishcheck->execute(array("load_id"=>$load_id,"user_id"=>$user_id));
		$wish_rowchk=$wishcheck->fetch(PDO::FETCH_ASSOC);
			if(empty($wish_rowchk)){
			$wish_data =  array(
				"load_id"=> $load_id,
				"created_by"=>$user_id,
				"user_id"=>$user_id,
				"trucker_id"=>$rowchk['id'],
				"wish_list_status"=>$wish_status,
				"status"=>1
			);
			$Global->InsertData("wish_list",$wish_data);
			$aVars=array("status"=>1 , "msg"=>"Added Successfully in your Wish List");
		   }else{
		
				$unwish_data=array(
			        "wish_list_status"=>$wish_status,
			        'updated_by' 	=> $user_id,	
					'updated_date'  => date("Y-m-d H:i:s")
			    );
			    $del_conditions =array("load_id"=>$load_id,"user_id"=>$user_id);
			    $Global->UpdateData("wish_list",$unwish_data,$del_conditions);
				$aVars=array("status"=>1 , "msg"=>"Removed Successfully in your Wish List");

		   }



		
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>