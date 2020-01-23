<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();

$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);
$CheckvalidToken=$Global->CheckValidToken($token);
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';

if(empty($token)){
			$aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){

	$aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif($CheckvalidToken['status']==1){

$con_type = isset($_POST["con_type"]) ? $_POST["con_type"] : '';
$cont_list = isset($_POST["contacts_list"]) ? $_POST["contacts_list"] : '';
$subject= isset($_POST["subject"]) ? $_POST["subject"] : '';
$email_content = isset($_POST["email_content"]) ? $_POST["email_content"] : '';
$cont_lists=json_encode($cont_list);
$contacts_list = str_replace("[", "{", $cont_lists);
$contacts_list = str_replace("]", "}", $contacts_list);


		if($con_type==1){
			$cont_type ="broker";
		}else if($con_type==2){
			$cont_type = "trucker";
		}else if($con_type==3){
			$cont_type = "shipper";
		}

		if(empty($contacts_list)){
			$aVars=array("status"=>0,"msg"=>"Please specify at least one recipient");
		}elseif(empty($subject)){
			$aVars=array("status"=>0,"msg"=>"Please enter subject");
		}elseif(empty($email_content)){
			$aVars=array("status"=>0,"msg"=>"Please enter Content");
		}else{
			$cont_data =  array(
            'user_id'=>$user_id, 
            'subject'=> $subject, 
            'mail_template'=>$email_content,
            'cont_type'=>$cont_type,
            'contacts_list'=>$contacts_list,
            'status'=>1 ,       
	         );
	        $last_id=$Global->InsertData("mail_list",$cont_data);

	        foreach ($cont_list as $key => $value) {
	        		$to_addr_id = $value;
				$contactlist_stmt = $Global->db->prepare( "SELECT name, business_name, email FROM users WHERE user_type = :cont_type AND id= :con_ids AND status=1");
				$contactlist_stmt->execute(array("cont_type"=>$cont_type,"con_ids" =>$to_addr_id));
				$contactlist_results = $contactlist_stmt->fetch(PDO::FETCH_ASSOC);
				$to_address= $contactlist_results['email'];
				$email_template= isset($email_content) ? $email_content : '';
				$broker_subject= isset($subject) ? $subject : '';
				$_SESSIONemail="Senthilkumar.Rengaraj@jeevantechnologies.com";

			    $delivery_status=$Global->AdminSendEmail($_SESSIONemail,$to_address,$broker_subject,$email_template);
				 $deli_data =  array(
			        'mail_list_id'=> $last_id, 
		            'user_id'=>$user_id, 
		            'to_address'=> $to_address,
		            'to_addr_id'=> $to_addr_id,
		            //'open_status'=>$open_status,
		            'delivery_status'=>$delivery_status,
		            'status'=>1 ,       
			          );
			      $last_ids=$Global->InsertData("delivery_mail",$deli_data);

	        
	        } 
	         $aVars=array("status"=>1 , "msg"=>"Successfully Send ");
   }

}else{
	 $aVars=array("status"=>2 , "msg"=>"Invalid Token");
}

echo json_encode($aVars);
exit;


   ?>+
