<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$check=$Global->db->prepare("SELECT id,truck_name FROM truck_type WHERE status=:status");
$check->execute(array("status"=>1));
$rowchk=$check->fetchAll(PDO::FETCH_ASSOC);
if(!empty($rowchk))
    $aVars=array("status"=>1,"list"=>$rowchk);
else
    $aVars=array("status"=>0,"list"=>[]);

echo json_encode($aVars);

