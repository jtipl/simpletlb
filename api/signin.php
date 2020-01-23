<?php
 date_default_timezone_set("Asia/kolkata");
require_once(dirname(__FILE__)."../../elements/Global.php");
class SignIn extends LoadBoard
{
	public function LSignIn($arr=array()){

		$email=isset($arr['email']) ? trim($arr['email']) : '';
		$password=isset($arr['password']) ? trim($arr['password']) : '';
		$remember_me=isset($arr['remember_me']) ? trim($arr['remember_me']) : '';
		$unit_test=isset($arr['unit_test']) ? $arr['unit_test'] : '';

		$check= $this->db->prepare("SELECT session_id,id,password,email,user_type,name,business_name,image FROM users WHERE email :: text ILIKE :email AND status=1");
		$check->execute(array("email"=>$email));
		$rowchk=$check->fetch(PDO::FETCH_ASSOC);

		$app_type=isset($arr['app_type']) ? trim($arr['app_type']) : '';
		$apptype=strtolower($app_type);

		if($apptype == "web" || $apptype == "ios" || $apptype == "android"){
			$apptype = 1;
		}else{
			$apptype= 0;
		}


		if(empty($email)){
			$aVars=array("status"=>0,"msg"=>"Please enter the email");
		}elseif(!empty($email) && parent::EmailValidation($email)==false){
			$aVars=array("status"=>0,"msg"=>"Please enter a valid Email");
		}elseif(empty($password)){
			$aVars=array("status"=>0,"msg"=>"Please enter the password");	
		}elseif(empty($app_type)){
			$aVars=array("status"=>0,"msg"=>"Please enter the app type");
		}elseif(!empty($app_type) && $apptype == 0 ){
			$aVars=array("status"=>0,"msg"=>"Please enter the valid app type");
		}else if(!empty($email) && !empty($rowchk)){
			if(password_verify($password,$rowchk['password'])){
				$data=array(
		            "id" => $rowchk['id'],
		            "email" => $rowchk['email'],
		            "name" => $rowchk['name']
		          );
				session_regenerate_id();
				$token=parent::GenerateToken($data);
				

				$_SESSION['user_id']=$rowchk['id'];
				$_SESSION['loggedin'] = true;
				$_SESSION['email']=$rowchk['email'];
				$_SESSION['user_type']=$rowchk['user_type'];
				$_SESSION['token']=$token;
				$_SESSION['name']=$rowchk['name'];
				$_SESSION['business_name']=$rowchk['business_name'];
				$_SESSION['timestamp']=time();

				//Multi Login Check 
				$multi_lgn = $this->db->prepare("SELECT session_id FROM users WHERE  id =:id AND status=1 ");
				$multi_lgn->execute(array("id"=>$_SESSION['user_id']));
				$multi_lgn_acc = $multi_lgn->fetch(PDO::FETCH_ASSOC);
				$_SESSION['old_session_id']="";
				if(!empty($multi_lgn_acc)){
						$_SESSION['old_session_id']=$multi_lgn_acc['session_id'];
				}
				
				//Mobile app login check with last login
				$datas = array("last_login"=>date('Y-m-d H:i:s'),"session_id"=>session_id());
				$conditions_user_id = array("id"=>$_SESSION['user_id']);
				$this->UpdateData("users",$datas,$conditions_user_id);

				$_SESSION["session_id"] = session_id();

				$first_time=0;
				if($rowchk['user_type']=='trucker'){
					$first_timepro= $this->db->prepare("SELECT id FROM trucker WHERE user_id =:user_id AND status=1");
					$first_timepro->execute(array("user_id"=>$rowchk['id']));
					$first_rowchk=$first_timepro->fetch(PDO::FETCH_ASSOC);
					if(!empty($first_rowchk)){
						$first_time=0;
					}else{
						$first_time=1;
					}
				}
				
				$imgurl="";
				if(!empty($rowchk['image'])){
					$imgurl=SITEURL."app/assets/uploads/original/".$rowchk['image'];
				}

				
				if(strtolower($app_type) == "web"){

					$aVars=array("status"=>1,"msg"=>"Login successfully","token"=>$token,"user_type"=>$rowchk['user_type'],"first_profile"=>$first_time,"user_id"=>$rowchk['id'],"name"=>$rowchk['name'],"email"=>$rowchk['email'],"image"=>$imgurl);	
				}elseif (strtolower($app_type)=='ios' || strtolower($app_type)=='android') {

					if($rowchk['user_type']=='trucker'){
						$aVars=array("status"=>1,"msg"=>"Login successfully","token"=>$token,"user_type"=>$rowchk['user_type'],"first_profile"=>$first_time,"user_id"=>$rowchk['id'],"name"=>$rowchk['name'],"email"=>$rowchk['email'],"image"=>$imgurl);	
					}else{
						$aVars=array("status"=>0,"msg"=>array("email"=>"User not found"));	
					}
					
				
				}



			}else{
				$aVars=array("status"=>0,"msg"=>array("password"=>"Password does not match"));	
			}
		}else{
			$aVars=array("status"=>0,"msg"=>array("email"=>"User not found"));	
		}
		if($unit_test==1){
			return $aVars;
		}else{
			echo json_encode($aVars);
			exit;
		}

	}




}
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);
if(!empty($input)){
	$signin=new SignIn();
	$signin->LSignIn($input);
}

?>