<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$action =isset($_POST['action']) ? $_POST['action']: '';
if($action == 'get_feature'){
$featurelist = $Global->db->prepare("SELECT id,feature_name,is_report FROM feature_list WHERE status=1");
$featurelist->execute();
$data = $featurelist->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
}
if($action == 'get_role'){
$roleslist = $Global->db->prepare("SELECT id,role_name FROM roles_list WHERE status=1");
$roleslist->execute();
$datas = $roleslist->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($datas);
}
?>

