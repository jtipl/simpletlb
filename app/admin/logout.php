<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
session_start();
session_destroy();
$url = SITEURL.'app/admin/';
header("location:".$url);
?>