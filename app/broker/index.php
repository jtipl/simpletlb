 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
//echo $_SERVER['REQUEST_URI']."<br/>";
if(strpos($_SERVER['REQUEST_URI'], "/app/broker/")!=false){
	//echo "index";
	header("Location:".SITEURL."404");
}
?>