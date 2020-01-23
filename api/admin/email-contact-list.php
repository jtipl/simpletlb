<?php
require_once("../../elements/Global.php");
$Global = new LoadBoard();
$token  = $Global->getBearerToken();

$CheckvalidToken = $Global->CheckValidToken($token);
$inputJSON       = file_get_contents('php://input');
$input           = json_decode($inputJSON, TRUE);


if ($CheckvalidToken['status'] == 1) {
    $operation = isset($input['operation']) ? trim($input['operation']) : '';
    $user_id=isset($input['user_id']) ? trim($input['user_id']) : '';
    $contyp_list=isset($input['contact_type']) ? trim($input['contact_type']) : '';
    if (!empty($operation)) {
        if ($operation == 'contact_type') {
            $contact_smt = $Global->db->prepare("SELECT  DISTINCT user_type FROM users WHERE status=1");
            $contact_smt->execute();
            $contact_type = $contact_smt->fetchAll(PDO::FETCH_ASSOC); 
            $aVars = array("status" => 1,"data" => $contact_type);
        }elseif($operation === "contact_type_list"){
				if(empty($user_id)){
					$aVars=array("status"=>0 , "msg" =>"User id is empty");
				}else{

					  if($contyp_list==1){
		                   $cont_type ="broker";
		               }else if($contyp_list==2){
		                   $cont_type = "trucker";
		               }else if($contyp_list==3){
		                   $cont_type = "shipper";
		               }

					$contactlist_stmt = $Global->db->prepare( "SELECT id,name,user_type,email FROM users WHERE user_type = :cont_type AND status=1");
					$contactlist_stmt->execute(array("cont_type"=>$cont_type));
					$contactlist_results = $contactlist_stmt->fetchAll(PDO::FETCH_ASSOC);
					$aVars=array("status"=>1 , "data" =>$contactlist_results);
				}
		
	   }
        
    }else{
        $aVars = array("status" => 0, "msg" => "Invalid operation");
        
    }
    
} else {
    $aVars = array( "status" => 2,"msg" => "Invalid Token");
    
}

echo json_encode($aVars);
exit;
?>