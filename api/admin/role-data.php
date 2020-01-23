<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$role_name =isset($_POST['role_name']) ? $_POST['role_name']: '';
$role_map =isset($_POST['role_map']) ? $_POST['role_map']: '';
$check_role = $Global->db->prepare("SELECT count(*) FROM roles_list WHERE status=1 and role_name ILIKE :roles_name");
$check_role->execute(array("roles_name"=>$role_name));
$check_role_id = $check_role->fetch(PDO::FETCH_ASSOC);
$check_it=$check_role_id['count'];
	if(empty($role_name)){
			$aVars=array("status"=>0,"msg"=>"Please enter the Role Name");
	}elseif($check_it != 0){
			 $aVars=array("status"=>0,"msg"=>"This role name is already define");
	}else{
			$data =  array(
				"role_name"=>$role_name,
				"status"=>1
			);
			$last_id=$Global->InsertData("roles_list",$data);

			$role_id = $Global->db->prepare("SELECT id FROM roles_list WHERE status=1 and role_name ILIKE :roles_name");
			$role_id->execute(array("roles_name"=>$role_name));
			$get_id = $role_id->fetch(PDO::FETCH_ASSOC);
			foreach ($role_map as $key => $value) {
				$read_val=0;
				$edit_val=0;
				$create_val=0;
				$map = explode("/",$value);
				$map_id=$map[0];
				$map_permisions=$map[1];
				if($map_permisions == 'read'){
					$read_val=1;
				}elseif($map_permisions == 'edit'){
					$edit_val=1;
				}elseif($map_permisions == 'create'){
					$create_val=1;
				}
					$data =  array(
					"feature_id"=> $map_id,
					"role_id"=>$get_id['id'],
					"read"=>isset($read_val) ? $read_val: 0,
					"creates"=>isset($create_val) ? $create_val: 0,
					"edit"=>isset($edit_val) ? $edit_val: 0,
					"status"=>1
					);
					$last_id=$Global->InsertData("mapping_role_feature",$data);
				
			}

			$aVars=array("status"=>1,"msg"=>"Registered Successfully"); 	
		}
echo json_encode($aVars);
exit;	
?>