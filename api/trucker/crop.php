<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){
	$data = $_POST["image"];

    $image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$imageName = time() . '.png';
	$imageName1=DIRECTORY."app/assets/uploads/original/".$imageName;
	$imgurl=SITEURL."app/assets/uploads/original/".$imageName;
	file_put_contents($imageName1, $data);
	$aVars=array("status"=>1 , "msg"=>"Uploaded successfully" ,"src"=>$imgurl,"image"=>$imageName);


}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;

?>

