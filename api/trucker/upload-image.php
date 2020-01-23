<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : ''; 

if(empty($token)){
            $aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif($CheckvalidToken['status']==1){

    $fileinfo = @getimagesize($_FILES["image"]["tmp_name"]);    
    $allowed_image_extension = array("png","jpg","jpeg");
    $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

    if (!file_exists($_FILES["image"]["tmp_name"])) {
        $aVars=array("status"=>0 , "msg"=>"Choose image file to upload");
    }else if (! in_array($file_extension, $allowed_image_extension)) {
        $aVars=array("status"=>0 , "msg"=>"Upload valiid images. Only PNG and JPEG are allowed");
    }else {
        $rand=rand();
        $imageName = time() .'.'.$file_extension;
        $target = DIRECTORY."app/assets/uploads/original/" .$imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {

            $datas=array(
                    "image"=>$imageName,
                //  "small_profile_image"=>$newFileName1. ".". $ext1
                );
                $conditions_user_id =array("id"=>$user_id);
                $var=$Global->UpdateData("users",$datas,$conditions_user_id);
            
    

            
            $aVars=array("status"=>1 , "msg"=>"Image uploaded successfully","url"=>SITEURL."app/assets/uploads/original/".$imageName);
        }else{



         $aVars=array("status"=>0 , "msg"=>"Problem in uploading image files");
        }
    }






}else{
    $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;
?>