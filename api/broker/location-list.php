<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
if($CheckvalidToken['status']==1){

	$country_id=isset($_POST['country_id']) ? trim($_POST['country_id']) : '';
	$state_id=isset($_POST['state_id']) ? trim($_POST['state_id']) : '';
	$city_name=isset($_POST['city_name']) ? trim($_POST['city_name']) : '';
	$state_name=isset($_POST['state_name']) ? trim($_POST['state_name']) : '';
	$zipcode=isset($_POST['zipcode']) ? trim($_POST['zipcode']) : '';


	if(!empty($_POST["operation"])){

	if($_POST["operation"] === "state_name"){
	//echo "SELECT * FROM states WHERE id = '$state_id' ORDER BY name";exit;
	$state_stmt = $Global->db->prepare("SELECT * FROM states WHERE id = :state_id ORDER BY name");
	//$state_stmt->bindValue("state_id", $state_id);
	$state_stmt->execute(array("state_id"=>$state_id));
	$state_results = $state_stmt->fetch(PDO::FETCH_ASSOC);
	$state_name = $state_results["name"];
	//echo $state_name;exit;
	$aVars=array("status"=>1 , "data" =>$state_name);

	}elseif($_POST["operation"] === "state_list"){
	$state_stmt = $Global->db->prepare( "SELECT * FROM states WHERE country_id = :cid ORDER BY name");
	$state_stmt->bindValue(":cid", trim($country_id));
	$state_stmt->execute();
	$state_results = $state_stmt->fetchAll();
	$aVars=array("status"=>1 , "data" =>$state_results);

	}
	elseif($_POST["operation"] === "city_list"){
	$city_stmt = $Global->db->prepare("SELECT * FROM cities WHERE state_id = :sid ORDER BY name");
	$city_stmt->bindValue(":sid", trim($state_id));
	$city_stmt->execute();
	$city_results = $city_stmt->fetchAll();
	$aVars=array("status"=>1 , "data" =>$city_results);

	}
	elseif($_POST["operation"] === "zip_list"){
	$data=array(
		"st_name" => $state_name,
		"ct_name" => $city_name
	);
	$zip_stmt = $Global->db->prepare("SELECT zip_code FROM public.zipcode where state= :st_name and city= :ct_name");
	$zip_stmt->execute($data);
	$zip_results = $zip_stmt->fetchAll();
	if(!empty($zip_results)){
		$zip=[];
		foreach ($zip_results as $key => $values) {
			$zip[]=$values['zip_code'];
		}
		if(in_array($zipcode, $zip)){
			$aVars=array("status"=>1);

		}else{
			$aVars=array("status"=>0);

		}

	}else{
		$aVars=array("status"=>0);

	}
	}elseif($_POST["operation"] === "state_list_valid"){
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

	}elseif($_POST["operation"] === "city_list_valid"){
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
	}elseif($_POST['operation']=='country_list'){

	$country_smt = $Global->db->prepare("SELECT * FROM countries WHERE id IN(231,38)  ORDER BY id DESC");
	$country_smt->execute();
	$country_res = $country_smt->fetchAll(PDO::FETCH_ASSOC);
	$aVars=array("status"=>1 , "data" =>$country_res);
	}

}else{
	$aVars=array("status"=>0 , "msg" =>"Invalid operation");

}
}else{
	$aVars=array("status"=>2,"msg"=>"Invalid Token");

}


echo json_encode($aVars);
exit;
?>