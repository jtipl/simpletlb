<?php

require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);
$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, TRUE);


$operation = isset($_POST['operation']) ? $_POST['operation']: '';
$name = isset($_POST['name']) ? $_POST['name']: '';
$days = isset($_POST['days']) ? $_POST['days']: '';
$userid = isset($_POST['userid']) ? $_POST['userid']: '';
$role_type=isset($_POST['user_type']) ? trim($_POST['user_type']) : '';
$feature_id_url=isset($_POST['id']) ? trim($_POST['id']) : '';
$price=isset($_POST['price']) ? trim($_POST['price']) : '';

if($CheckvalidToken['status']==1){
	if(empty($operation)){
		$aVars= array("status"=>0,"msg"=>"Empty operation");
	}else{
		if($operation=='add'){

			$scheck = $Global->db->prepare("SELECT name FROM subscription WHERE name=:name");
			$scheck->execute(array("name"=>$name));
			$sduplicate = $scheck->fetch(PDO::FETCH_ASSOC);

			if(empty($name)){
				$aVars= array("status"=>0,"msg"=>"Please enter the subscription name");
			}elseif(!empty($name) && !empty($sduplicate)){
				$aVars= array("status"=>0,"msg"=>"Subscription already exists");
			}elseif(empty($price)){
				$aVars= array("status"=>0,"msg"=>"Please enter the price");
			}elseif(empty($days)){
				$aVars= array("status"=>0,"msg"=>"Please enter the days");
			}else{
				$data = array("name"=>$name,"days"=>$days,"price"=>$price,"status"=>1,"created_by"=>$userid);
				$Global->InsertData("subscription",$data);
				$aVars= array("status"=>1,"msg"=>"Subscription added Successfully");
			  }
		}elseif($operation=='update'){
			$id = isset($_POST['id']) ? $_POST['id']: '';

			$scheck = $Global->db->prepare("SELECT name FROM subscription WHERE name=:name AND id!=:id");
			$scheck->execute(array("name"=>$name,"id"=>$id));
			$sduplicate = $scheck->fetch(PDO::FETCH_ASSOC);

			if(empty($name)){
				$aVars= array("status"=>0,"msg"=>"Please enter the subscription name");
			}elseif(!empty($name) && !empty($sduplicate)){
				$aVars= array("status"=>0,"msg"=>"Subscription already exists");
			}elseif(empty($price)){
				$aVars= array("status"=>0,"msg"=>"Please enter the price");
			}elseif(empty($days)){
				$aVars= array("status"=>0,"msg"=>"Please enter the days");
			}else{

				$data = array("name"=>$name,"days"=>$days,"price"=>$price,"updated_by"=>$userid,"updated_date"=>date("Y-m-d H:i:s"));
				$conditions =array("id"=>$id);
				$Global->UpdateData("subscription",$data,$conditions);

				$aVars= array("status"=>1,"msg"=>"Subscription updated Successfully");
			  }
		}elseif($operation=='listing'){

			$check_role = $Global->db->prepare("SELECT id FROM roles_list WHERE status=1 AND role_name ILIKE :role_name");
			$check_role->execute(array("role_name"=>$role_type));
			$data_role = $check_role->fetch(PDO::FETCH_ASSOC);
			$role_id=$data_role['id'];

			$check_feature = $Global->db->prepare("SELECT count(*) FROM mapping_role_feature WHERE status=1 AND role_id =:role_id AND edit=1 AND feature_id=:feature_id");
			$check_feature->execute(array("role_id"=>$role_id, "feature_id"=>$feature_id_url));
			$get_feature_id = $check_feature->fetch(PDO::FETCH_ASSOC);
			$edit_check=$get_feature_id['count'];
			if($edit_check == 1){
				$edit_per=1;
			}else{
				$edit_per=0;
			}

			$draw = isset($_POST['draw']) ? $_POST['draw']: '';
			$row =  isset($_POST['start']) ? $_POST['start']: '';
			$rowperpage = isset($_POST['length']) ? $_POST['length']: '10';
			$columnIndex =isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column']: '';
			$columnName =   isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data']: 'id';
			$columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir']: '';
			$searchValue =    isset($_POST['search']['value']) ? $_POST['search']['value']: '';
			// Search 
			$searchQuery = "%";
			if($searchValue != ''){
				$searchQuery ="%".$searchValue."%";
			}
			// Total number of records without filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM subscription");
			$sel->execute();
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecords = $records['allcount'];

			// Total number of record with filtering
			$sel = $Global->db->prepare("SELECT count(*) as allcount FROM subscription WHERE (name ::text ILIKE :searchQuery OR days ::text ILIKE :searchQuery ) ");
			$sel->execute(array("searchQuery" => $searchQuery));
			$records =$sel->fetch(PDO::FETCH_ASSOC);
			$totalRecordwithFilter = $records['allcount'];

		
			// Fetch records
			$subscription = $Global->db->prepare("SELECT price,status,id,name,days,to_char(created_date,'MM-DD-YYYY') as created_date FROM subscription WHERE (name ::text ILIKE :searchQuery OR days ::text ILIKE :searchQuery )  ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$rowperpage." OFFSET ".$row);

			$subscription->execute(array("searchQuery" => $searchQuery));
			$rdatas = $subscription->fetchAll(PDO::FETCH_ASSOC);

		

			$data=array();
			if(!empty($rdatas)){
			foreach ($rdatas as $key => $value) {
				$value['edit_per']=$edit_per;
				$data[]=$value;
			  }
			}
			// Response
			$aVars = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
			);

		}elseif($operation=='change_status'){
			$id = isset($_POST['id']) ? $_POST['id']: '';
			$status = isset($_POST['status']) ? $_POST['status']: '';
			if($status==0){
				$sts = 1;
			} else if($status==1){
				$sts = 0;
			}
			$check=$Global->db->prepare("UPDATE subscription SET status =:status WHERE id=:id ");
			$check->execute(array('id' => $id,"status"=>$sts));
			$aVars= array("status"=>1,"msg"=>"Subscription status changed successfully");

		}else{
			$aVars= array("status"=>0,"msg"=>"Invalid operation");
		}
		
	}

}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");
}
echo json_encode($aVars);
exit;
?>