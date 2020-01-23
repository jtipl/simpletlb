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

		 if(!empty($operation) == 'get_data'){
			   $get_data=$Global->db->prepare("SELECT id, search_name FROM search_save WHERE user_id=:user_id AND status=1");
				$get_data->execute(array("user_id"=>$user_id));
				$get_dataser=$get_data->fetchAll(PDO::FETCH_ASSOC);

				$count_data=$Global->db->prepare("SELECT COUNT(*) AS total FROM search_save WHERE user_id=:user_id AND status=1");
				$count_data->execute(array("user_id"=>$user_id));
				$count_dataser=$count_data->fetch(PDO::FETCH_ASSOC);


				$aVars=array("status"=>1 , "msg"=>"Get Data Successfully","data" =>$get_dataser,"total"=>$count_dataser['total']);

		  }else{
		     	$aVars=array("status"=>2 , "msg"=>"Invalid operation");
		  }



}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>
