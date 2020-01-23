<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$token=$Global->getBearerToken();
$CheckvalidToken=$Global->CheckValidToken($token);

if($CheckvalidToken['status']==1){
	$curr = $Global->db->prepare('SELECT CURRENT_DATE +1 as CURRENT_DATE');
	$curr->execute();
	$currDate = $curr->fetch(PDO::FETCH_ASSOC);

	//=====================================Broker=======================================//
	//Total broker Count
	$total_broker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='broker' AND status=1");
	$total_broker->execute();
    $total_broker_row=$total_broker->fetch(PDO::FETCH_ASSOC);
    $broker_count=$total_broker_row["count"];
    //Total broker web count
    $web_broker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='broker' AND app_type='web' AND status=1");
	$web_broker->execute();
    $web_broker_row=$web_broker->fetch(PDO::FETCH_ASSOC);
    $broker_web_count=$web_broker_row["count"];

    //Total broker ios count
    $ios_broker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='broker' AND app_type='ios' AND status=1");
	$ios_broker->execute();
    $ios_broker_row=$ios_broker->fetch(PDO::FETCH_ASSOC);
    $broker_ios_count=$ios_broker_row["count"];

    //Total broker android count
    $android_broker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='broker' AND app_type='android' AND status=1");
	$android_broker->execute();
    $android_broker_row=$android_broker->fetch(PDO::FETCH_ASSOC);
    $broker_android_count=$android_broker_row["count"];

	//=====================================Trucker=======================================//

    //Total trucker Count
	$total_trucker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='trucker' AND status=1");
	$total_trucker->execute();
    $total_trucker_row=$total_trucker->fetch(PDO::FETCH_ASSOC);
    $trucker_count=$total_trucker_row["count"];

    //Total trucker web count
    $web_trucker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='trucker' AND app_type='web' AND status=1");
	$web_trucker->execute();
    $web_trucker_row=$web_trucker->fetch(PDO::FETCH_ASSOC);
    $trucker_web_count=$web_trucker_row["count"];

    //Total trucker ios count
    $ios_trucker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='trucker' AND app_type='ios' AND status=1");
	$ios_trucker->execute();
    $ios_trucker_row=$ios_trucker->fetch(PDO::FETCH_ASSOC);
    $trucker_ios_count=$ios_trucker_row["count"];

    //Total trucker android count
    $android_trucker = $Global->db->prepare("SELECT count(*)  FROM users WHERE user_type='trucker' AND app_type='android' AND status=1");
	$android_trucker->execute();
    $android_trucker_row=$android_trucker->fetch(PDO::FETCH_ASSOC);
    $trucker_android_count=$android_trucker_row["count"];
   

	$aVars = array(
		'status' => 1, 
		"broker_count"=>$broker_count,
		"broker_web_count"=>$broker_web_count,
		"broker_ios_count"=>$broker_ios_count,
		"broker_android_count"=>$broker_android_count,

		"trucker_count"=>$trucker_count,
		"trucker_web_count"=>$trucker_web_count,
		"trucker_ios_count"=>$trucker_ios_count,
		"trucker_android_count"=>$trucker_android_count

	);
}else{
	$aVars=array("status"=>2 , "msg"=>"Invalid Token");

}
		

echo json_encode($aVars);
exit;

?>