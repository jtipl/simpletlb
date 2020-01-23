<?php
require_ONce("../../elements/Global.php");
$Global          = new LoadBoard();
$token=$Global->getBearerToken();
$inputJSON = file_get_contents('php://input');
$_REQUEST = json_decode($inputJSON, TRUE);
$user_id = isset($_REQUEST["user_id"]) ? $_REQUEST["user_id"] : '';
$CheckvalidToken=$Global->CheckValidToken($token);

if(empty($token)){
            $aVars=array("status"=>0 , "msg"=>"Empty token");
}elseif(empty($user_id)){
    $aVars=array("status"=>0,"msg"=>"User id is empty");
}elseif ($CheckvalidToken['status'] == 1) {
    // BrokerDetails starts
    $TruckerDetails = $Global->TruckerDetails($user_id);
    $trucker_id     = $TruckerDetails["id"];
    
    
    $curr = $Global->db->prepare('SELECT CURRENT_DATE +1 AS CURRENT_DATE');
    $curr->execute();
    $currDate     = $curr->fetch(PDO::FETCH_ASSOC);
    $current_date = date('Y-m-d');
    $tomarrowDate = $currDate['current_date'];
   /* print_r($trucker_id);
*/
    
    // Total New Loads Notification Start Here

    $loads_newloads = $Global->db->prepare("SELECT * FROM loads WHERE  status IN(0,1)  AND created_date BETWEEN NOW() - INTERVAL '24 HOURS' AND NOW() AND NOT (:trucker_id = ANY (notification_view_trucker_ids)) ");
    $loads_newloads->execute(array("trucker_id" => $trucker_id));
    $rowloads_newloads = $loads_newloads->fetchAll(PDO::FETCH_ASSOC);
    //$total_newloads=$rowloads_newloads["count"];
    $total_newloads=0;
    foreach($rowloads_newloads as $key => $val){
        $load_strip_sql = $Global->db->prepare("SELECT * FROM loads_trip WHERE load_id=:load_id ");
        $load_strip_sql->execute(array("load_id" => $val["id"]));
        $load_strip_fetcn = $load_strip_sql->fetch(PDO::FETCH_ASSOC);
        $load_status = $load_strip_fetcn["load_status"];
        if($load_status!=1){
            $total_newloads_row=count($rowloads_newloads)-1;
            //echo $total_newloads_row;exit;
            if($total_newloads_row==-1){
                $total_newloads = 0;
            } else {
                $total_newloads = count($rowloads_newloads);
            }
        } 
    }


    //$load_id = $rowloads_newloads["id"];

    /*
    $load_strip_sql = $Global->db->prepare("SELECT * FROM loads_trip WHERE load_id=:load_id ");
    $load_strip_rows->execute(array("load_id" => $load_id));
    $load_strip_fetcn = $load_strip_rows->fetch(PDO::FETCH_ASSOC);
    echo $load_strip_fetcn["id"];exit;
    $total_newloads    = $rowloads_newloads["count"];
    */
    // Total New Load Notification Start Here
    
    // Upcoming strips starts here
    //echo $trucker_id;exit;
    $upcomSql = $Global->db->prepare("SELECT count(*) as count FROM loads 
        INNER JOIN loads_trip ON loads.id=loads_trip.load_id 
        WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status=2 
        AND loads_trip.trucker_status=2 AND loads_trip.trucker_notification_view=0");
    $upcomSql->execute(array( "trucker_id" => $trucker_id));
    $rowloads_upcomSql = $upcomSql->fetch(PDO::FETCH_ASSOC);
    $totalloads_upcoming_trips  = $rowloads_upcomSql["count"];
    //echo $totalloads_upcoming_trips;exit;
    // Upcoming strips ends here


    // Denied starts here 
    $loads_denied = $Global->db->prepare("SELECT count(*) AS count FROM loads  JOIN loads_trip  ON loads.id=loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.trucker_status =1  AND loads_trip.denied_status=1 AND loads_trip.trucker_notification_view=0");
    $loads_denied->execute(array( "trucker_id" => $trucker_id));
    $rowloads_denied = $loads_denied->fetch(PDO::FETCH_ASSOC);
    $total_denied    = $rowloads_denied["count"];
    // Denied ends here 
    
    // Upcoming loads ready AS picked starts here 
    //echo "sELECT count(*) AS count FROM loads l JOIN loads_trip lt ON l.id=lt.load_id AND 
    
    $loads_upcomingtrips_pickupdate = $Global->db->prepare("SELECT count(*) AS count FROM loads JOIN loads_trip  ON loads.id=loads_trip.load_id WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.load_status =2  AND (loads.pickup_date='" . $current_date . "' or loads.pickup_date='" . $tomarrowDate . "') AND  loads_trip.trucker_notification_view=0 ");
    $loads_upcomingtrips_pickupdate->execute(array("trucker_id" => $trucker_id));
    $row_upcomingtrips_pickupdate = $loads_upcomingtrips_pickupdate->fetch(PDO::FETCH_ASSOC);
    $total_upcomingtrips_pickupdate     = $row_upcomingtrips_pickupdate["count"];

    

    //print_r($total_upcomingtrips);exit;
    // Upcoming loads set AS picked  ends here 
    
    
    // Cancel Trip Starts Here 
    $loads_canceltrip = $Global->db->prepare("SELECT count(*) AS count FROM loads JOIN loads_trip  
        ON loads.id=loads_trip.load_id  WHERE loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status =2 AND loads_trip.trucker_notification_view in(0,1)");
    $loads_canceltrip->execute(array("trucker_id" => $trucker_id));
    $rowloads_canceltrip = $loads_canceltrip->fetch(PDO::FETCH_ASSOC);
    $total_canceltrip    = $rowloads_canceltrip["count"];

    // Cancel Trip Ends Here
    
    
    // cancel reopen trucker start here
    /*
    Select l.status,l.approve_status,lt.load_id,lt.trucker_id,lt.load_status,lt.cancel_status from loads l
    inner JOIN loads_trip lt 
    
    ON l.id =lt.load_id AND l.status = 5 AND l.approve_status = 0 AND lt.cancel_status=0
    */
    
    $loads_cancel_reopentrip = $Global->db->prepare("SELECT count(*) AS count FROM loads INNER JOIN loads_trip ON loads.id =loads_trip.load_id WHERE loads.status = 5   AND loads_trip.trucker_id=:trucker_id AND loads_trip.cancel_status=0  AND loads_trip.denied_status=1  AND loads_trip.trucker_notification_view=1");
    $loads_cancel_reopentrip->execute(array( "trucker_id" => $trucker_id));
    $rowloads_cancel_reopentrip = $loads_cancel_reopentrip->fetch(PDO::FETCH_ASSOC);
    $total_cancel_reopentrip    = $rowloads_cancel_reopentrip["count"];
    
    // cancel reopen trucker ends here
    
    if ($total_newloads == 0 && $total_denied == 0 && $total_upcomingtrips_pickupdate == 0 && $total_canceltrip == 0 && $total_cancel_reopentrip == 0 && $totalloads_upcoming_trips==0) {
        $aVars = array(
            'status' => 0,
            "no_count" => 0
        );
    } else {
        
        if ($total_newloads != 0) {
            $msg_count1 = 1;
        } else {
            $msg_count1 = 0;
        }
        
        if ($total_denied != 0) {
            $msg_count2 = 1;
        } else {
            $msg_count2 = 0;
        }
        
        if ($total_upcomingtrips_pickupdate != 0) {
            $msg_count3 = 1;
        } else {
            $msg_count3 = 0;
        }
        
        if ($total_canceltrip != 0) {
            $msg_count4 = 1;
        } else {
            $msg_count4 = 0;
        }
        
        if ($total_cancel_reopentrip != 0) {
            $msg_count5 = 1;
        } else {
            $msg_count5 = 0;
        }
        
        if($totalloads_upcoming_trips!=0){
            $msg_count6 =1;
        } else {
            $msg_count6 =0;
        }

        $total_count = ($msg_count1 + $msg_count2 + $msg_count3 + $msg_count4 + $msg_count5 + $msg_count6);
        $new_load_encode = $Global->encode('newload');
        $aVars = array(
            'status' => 1,
            "total_count" => $total_count,
            "total_newloads" => $total_newloads,
            "total_newloads_code" => $new_load_encode,
            "total_denied" => $total_denied,
            "totalloads_upcoming_trips" => $totalloads_upcoming_trips,
            "total_upcomingtrips_pickupdate" => $total_upcomingtrips_pickupdate,
            "total_canceltrip" => $total_canceltrip,
            "total_cancel_reopentrip" => $total_cancel_reopentrip
        );
    }
    } else {
    $aVars = array(
        "status" => 2,
        "msg" => "Invalid Token"

    );
}
echo jsON_encode($aVars);

?>