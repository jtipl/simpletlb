<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

if(empty($token)){
    $aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){
	 $user_id=isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
	 if(empty($user_id)){
        $aVars = array('status' =>0 ,"msg"=>"User id is empty");
	 }elseif(!empty($user_id) && !is_numeric($user_id)){
        $aVars = array('status' =>0 ,"msg"=>"Invalid user id");
	 }else{
		//Multi Login Check 
		$multi_lgn = $Global->db->prepare("SELECT session_id FROM users WHERE  id =:id AND status=1 ");
		$multi_lgn->execute(array("id"=>$_POST['user_id']));
		$multi_lgn_acc = $multi_lgn->fetch(PDO::FETCH_ASSOC);
		$session_stored_id=$multi_lgn_acc['session_id'];
		$session_page_id=$_POST['session_id'];

		$session_login=3;
		if($session_stored_id &&  $session_page_id){
		  if($session_stored_id!=$session_page_id){
		    $session_login=1;
		  }if($session_stored_id==$session_page_id){
		    $session_login=2;
		  }
		}

		var_dump($session_stored_id);
		var_dump($session_page_id);

			$aVars=array("status"=>1 , "auth"=>$session_login,"tes"=>var_dump($session_login));


	 }
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}
echo json_encode($aVars);
exit;
?>
