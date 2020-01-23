<?php
require_once("../elements/Global.php");
$Global=new LoadBoard();

if(isset($_SESSION['user_id'])){
	$datas = array("session_id"=>$_SESSION['old_session_id']);
	$conditions_user_id = array("id"=>$_SESSION['user_id']);
	$Global->UpdateData("users",$datas,$conditions_user_id);
}

unset($_SESSION['user_id']);
unset($_SESSION['loggedin'] );
unset($_SESSION['email']);
unset($_SESSION['user_type']);
unset($_SESSION['token']);
unset($_SESSION['name']);
unset($_SESSION['business_name']);
unset($_SESSION['session_id']);
unset($_SESSION['old_session_id']);
session_destroy();


?>
<script type="text/javascript">
	window.location.href="<?php echo SITEURL; ?>";
</script>


