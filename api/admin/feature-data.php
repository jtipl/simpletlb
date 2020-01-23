<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$feature_name =isset($_POST['feature_name']) ? $_POST['feature_name']: '';
$report_enable =isset($_POST['report_enable']) ? $_POST['report_enable']: 0;

		if(empty($feature_name)){
			$aVars=array("status"=>0,"msg"=>"Please enter the Feature Name");
		}else{
			$data =  array(
				"feature_name"=>$feature_name,
				"is_report"=>$report_enable,
				"status"=>1
			);
			$last_id=$Global->InsertData("feature_list",$data);
			$aVars=array("status"=>1,"msg"=>"Registered Successfully"); 	
		}
		echo json_encode($aVars);
		exit;
 ?>

