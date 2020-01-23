<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

$valid=$Global->CheckValidToken($_POST['token']);
print_r($valid);

?>