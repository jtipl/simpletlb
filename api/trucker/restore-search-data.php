<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);

$user_id=isset($_POST['user_id']) ? $_POST['user_id'] : 0;
$operation=isset($_POST['operation']) ? trim($_POST['operation']) : "";
$get_id=isset($_POST['get_id']) ? trim($_POST['get_id']) : 0;

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

		if(!empty($operation) == 'resetdata'){
			    $reset_data=$Global->db->prepare("SELECT * FROM search_save WHERE user_id=:user_id AND  id= :get_id AND status=1");
				$reset_data->execute(array("user_id"=>$user_id,"get_id"=>$get_id));
				$greset_data=$reset_data->fetch(PDO::FETCH_ASSOC);
				$aVars=array("status"=>1 , "msg"=>"Reset Data Successfully","data" =>$greset_data);

		  }else{
		     	$aVars=array("status"=>2 , "msg"=>"Invalid operation");
		     }



}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>
