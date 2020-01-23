<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

if($_POST["operation"] === "state_list_valid"){
	$data=$_POST['data'];
	$state_stmt = $Global->db->prepare( "SELECT * FROM states WHERE country_id = :cid and name ILIKE :name");
	$state_stmt->execute(array(":cid"=>'231',":name"=>$data));
	$state_count = $state_stmt->rowCount();
	if($state_count == '' && $state_count == 0 && $state_count == null && $state_count == '0'){
		$state_results=0;
	}else{
		$state_results=1;
	}
	$aVars=array("status"=>$state_results);

}
if($_POST["operation"] === "city_list_valid"){
	$data=$_POST['data'];
	$city_stmt = $Global->db->prepare( "SELECT  * FROM cities WHERE name ILIKE :name AND state_id = ANY(ARRAY[3919, 3920, 3921, 3922, 3923, 3924, 3925, 3926, 3927, 3928, 3929, 3930, 3931, 3932, 3933, 3934, 3935, 3936, 3937, 3938, 3939, 3940, 3941, 3942, 3943, 3944, 3945, 3946, 3947, 3948, 3949, 3950, 3951, 3952, 3953, 3954, 3955, 3956, 3957, 3958, 3959, 3960, 3961, 3962, 3963, 3964, 3965, 3966, 3967, 3968, 3969, 3970, 3971, 3972, 3973, 3974, 3975, 3976, 3977, 3978])");
	$city_stmt->execute(array(":name"=>$data));
	$city_count = $city_stmt->rowCount();
	if($city_count == '' && $city_count == 0 && $city_count == null && $city_count == '0'){
		$city_results=0;
	}else{
		$city_results=1;
	}
	$aVars=array("status"=>$city_results);
}

echo json_encode($aVars);
exit;
?>
