<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);

if(empty($token)){
    $aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){
    $user_id=isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
    //echo $user_id;exit;
    if(empty($user_id)){
        $aVars = array('status' =>0 ,"msg"=>"User id is empty");
    }else if(!empty($user_id) &&  !is_numeric($user_id)){
        $aVars = array('status' =>0 ,"msg"=>"User id accept only numberic");
    }  else {  
        $check=$Global->db->prepare("SELECT * FROM loads WHERE user_id=:user_id AND status=0 ORDER by id DESC ");
        $check->execute(array("user_id"=>$user_id));
        $rowchk=$check->fetch(PDO::FETCH_ASSOC);
        $data=array(
                "id"=>$rowchk["id"],
                "load_id"=>$rowchk["load_id"],
                "origin"=>$rowchk["origin"],
                "destination"=>$rowchk["destination"],
                "pickup_date"=>$rowchk["pickup_date"],
                "delivery_date"=>$rowchk["delivery_date"],
                "pickup_time"=>$rowchk["pickup_time"],
                "delivery_time"=>$rowchk["delivery_time"],
                "truck_load_type"=>$rowchk["truck_load_type"],
                "weight"=>$rowchk["weight"],
                "length"=>$rowchk["length"],
                "price"=>$rowchk["price"]
                );

        $aVars = array('status' =>1 ,"data" =>$data);
    }    
 }else{
    $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
 
echo json_encode($aVars);
exit;
?>


