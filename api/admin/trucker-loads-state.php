<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);

$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
      $arra=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){
  $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$trucker_id_get=$Global->db->prepare("SELECT id FROM trucker WHERE user_id=:user_id AND status=1");
$trucker_id_get->execute(array("user_id"=>$user_id));
$trucker_id_gets=$trucker_id_get->fetch(PDO::FETCH_ASSOC);
$trucker_id=$trucker_id_gets['id'];

$check=$Global->db->prepare("SELECT loads.origin_state FROM loads INNER JOIN loads_trip as trips ON loads.id=trips.load_id WHERE trips.trucker_id= :trucker_id AND trips.load_status =1 AND trips.trucker_status=1 AND  trips.cancel_status =0 AND trips.is_delete =0 AND  trips.denied_status = 0 GROUP BY loads.origin_state ");
$check->execute(array("trucker_id"=>$trucker_id));
$rowchk=$check->fetchAll(PDO::FETCH_ASSOC);

$arr=array();
if(!empty($rowchk)){
  foreach ($rowchk as $key => $value) {


    $sel = $Global->db->prepare("SELECT count(*) FROM loads INNER JOIN loads_trip as trips ON loads.id=trips.load_id WHERE trips.trucker_id= 41 AND trips.load_status =1 AND trips.trucker_status=1 
    AND  trips.cancel_status =0 AND trips.is_delete =0 AND  trips.denied_status = 0 AND loads.origin_state=:origin_state ");
    $sel->execute(array("origin_state"=>$value['origin_state']));
    $records =$sel->fetch(PDO::FETCH_ASSOC);

     $sel1 = $Global->db->prepare("SELECT loads.origin FROM loads INNER JOIN loads_trip as trips ON loads.id=trips.load_id WHERE trips.trucker_id= 41 AND trips.load_status =1 AND trips.trucker_status=1 
    AND  trips.cancel_status =0 AND trips.is_delete =0 AND  trips.denied_status = 0 AND loads.origin_state=:origin_state ");
    $sel1->execute(array("origin_state"=>$value['origin_state']));
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

echo json_encode($arra);
exit;
?>