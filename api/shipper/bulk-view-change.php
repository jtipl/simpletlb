<?php
error_reporting(0);
//ini_set('max_execution_time', 300);
require_once("../../elements/Global.php");
$shipper_user_id= isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
$Global=new LoadBoard();
//print_r($_POST['value']);
if(isset($_POST['field'])){
  $pdate=$_POST['value'];
  $istatus =array($_POST['field']=>$pdate);
  $conditions =array('id'=>$_POST['id']);
  $Global->UpdateData("temp_loads",$istatus,$conditions);	
  $aVars=array("status"=>1,"msg"=>"Upload Successfully");
}else if(isset($_POST['action']) && $_POST['action']=='delete'){
  $conditions =array("user_id"=>$shipper_user_id,"reload_status"=> 1);
  $Global->DeleteData("temp_loads",$conditions);	
  $aVars=array("status"=>1,"msg"=>"Delete Successfully");	
}else{
 	 $aVars=array("status"=>0,"msg"=>"Invalid data");
}
echo json_encode($aVars);
?>
