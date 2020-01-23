<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$role_type=isset($_SESSION['user_type']) ? trim($_SESSION['user_type']) : '';
$check_role = $Global->db->prepare("SELECT id FROM roles_list WHERE status=1 AND role_name ILIKE :role_name");
$check_role->execute(array("role_name"=>$role_type));
$data_role = $check_role->fetch(PDO::FETCH_ASSOC);
$role_id=$data_role['id'];


$check_feature = $Global->db->prepare("SELECT role_id, feature_id, read, creates, edit FROM mapping_role_feature WHERE status=1 AND role_id =:role_id AND read= 1");
$check_feature->execute(array("role_id"=>$role_id));
$get_feature_id = $check_feature->fetchAll(PDO::FETCH_ASSOC);
//print_r($get_feature_id);
$data=array();
foreach ($get_feature_id as $keys => $values) {
$feature_id=$values['feature_id'];

$featurelist = $Global->db->prepare("SELECT id,sub_menu, menu_url,feature_name,is_report FROM feature_list WHERE status=1 AND id = :feature_id ");
$featurelist->execute(array("feature_id"=>$feature_id));
$data[] = $featurelist->fetchAll(PDO::FETCH_ASSOC);
}



/*$check=$Global->db->prepare("SELECT id,password,user_type,user_name FROM admin_users WHERE user_name ILIKE :user_name AND status=1");
$check->execute(array("user_name"=>$user_name));
$rowchk=$check->fetch(PDO::FETCH_ASSOC);
*/
//print_r($data);exit();

?>
<div class="fixed-sidebar-left">
      <ul class="nav navbar-nav side-nav nicescroll-bar" id="left_menu">
        <li class="navigation-header">
          <span>Main</span> 
          <hr/>
        </li>
  
        <?php foreach ($data as $key => $value) { 
         $url= $value[0]['menu_url']; 
         ?>
        

        <li>
          <a href="javascript:void(0);" data-toggle="collapse" data-target="#<?php echo $value[0]['id'];?>"><div class="pull-left"><i class="fa fa-users  mr-20"></i><span class="right-nav-text"><?php echo $value[0]['feature_name'];?></span></div><div class="pull-right"><i class="ti-angle-down"></i></div><div class="clearfix"></div></a>
          <ul id="<?php echo $value[0]['id'];?>" class="collapse collapse-level-1">
              <li>
              <a href="<?php echo SITEURL.$url."?id=".$value[0]['id'];?>"><?php echo $value[0]['sub_menu'];?></a>
            </li>
           </ul>
      </li>   



        <?php }?>
      </ul>
    </div>
   
