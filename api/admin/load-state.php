<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
if($CheckvalidToken['status']==1){
	$check=$Global->db->prepare("SELECT origin_state FROM loads WHERE user_id=:user_id GROUP BY origin_state");
$check->execute(array("user_id"=>$user_id));
$rowchk=$check->fetchAll(PDO::FETCH_ASSOC);
$arr=array();
if(!empty($rowchk)){
	foreach ($rowchk as $key => $value) {
		$sel = $Global->db->prepare("SELECT count(*)  FROM loads WHERE user_id=:user_id AND origin_state=:origin_state");
		$sel->execute(array("origin_state"=>$value['origin_state'],"user_id"=>$user_id));
		$records =$sel->fetch(PDO::FETCH_ASSOC);

		$sel1 = $Global->db->prepare("SELECT origin FROM loads WHERE user_id=:user_id AND origin_state=:origin_state");
		$sel1->execute(array("origin_state"=>$value['origin_state'],"user_id"=>$user_id));
		$records1 =$sel1->fetch(PDO::FETCH_ASSOC);


		    $org="";
		    if(!empty($records1['origin'])){
		      $or=explode(",",$records1['origin']);
		      $org=trim($or[1]);
		      $orgc=trim($or[2]);
		     
		      if($org=='South Carolina'){
		        $orglast='sc';
		      }else{
		        $orglast=$org;
		      }
		      if($orgc=='USA'){
		        $orn='us';
		      }else{
		        $orn='ca';
		      }
		      $org_cc=$orn.'-'.$orglast;
		    }

			$values['load_count']=$records['count'];
			$values['title']=strtolower($org_cc);
	
		$arr[]=$values;
	}


	$arra=array("status"=>1,"data"=>$arr);
}else{
	$arra=array("status"=>0,"data"=>array());
}
}else{
	$arra=array("status"=>2 , "msg"=>"Invalid Token");

}

echo json_encode($arra,JSON_HEX_QUOT|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS);

exit;
?>