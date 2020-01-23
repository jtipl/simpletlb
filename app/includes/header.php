 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
 $user_type = isset($_SESSION["user_type"]) ? $_SESSION['user_type']: '';
 if($user_type=="trucker"){
  $profile_page = $user_type.'/trucker-profile';
}
else if($user_type=="broker"){
  $profile_page = $user_type.'/broker-profile';
}
else  if($user_type=="shipper"){
  $profile_page = $user_type.'/shipper-profile';
}


//Multilogin check wiht lastlogin

$multi_datas = array("last_access"=>date('Y-m-d H:i:s'));
$conditions_multi = array("id"=>$_SESSION['user_id']);
$Global->UpdateData("users",$multi_datas,$conditions_multi);

$last_accdetails = $Global->db->prepare("SELECT id FROM users WHERE last_access < NOW() - INTERVAL '10 minute' AND id =:id AND status=1 ");
$last_accdetails->execute(array("id"=>$_SESSION['user_id']));
$last_accrow = $last_accdetails->fetch(PDO::FETCH_ASSOC);
$lastaccess_check=false;
if(!empty($last_accrow)){
  $lastaccess_check=true;
}

//Get Updated Name
$udetails = $Global->db->prepare("SELECT name,image FROM users WHERE status = :status AND id =:id ");
$udetails->execute(array("status"=>1,"id"=>$_SESSION['user_id']));
$urow = $udetails->fetch(PDO::FETCH_ASSOC);

$VerifiedCheck=$Global->VerifiedCheck();
//$expiring_encode = $Global->encode('expiring');
//$approval_encode = $Global->encode('awaiting');

$expiring_encode = $Global->encode('expiring');
$approval_encode = $Global->encode('awaiting');
$picked_encode = $Global->encode('picked');
$delivered_encode = $Global->encode('delivered');
$canceltrip_encode = $Global->encode('reopen');
$denied_loads = $Global->encode('denied');
$upcommingall = $Global->encode('upcommingall');
$re_open_view_encode = $Global->encode('re_open');


$new_load_encode = $Global->encode('newload');
$cancelload_encode = $Global->encode('cancelload');

// echo $new_load_decode;
$verifychk=$Global->VerifiedCheck();



?>
<style type="text/css">
 .dropdown-item1 {
  display: block;
  width: 100%;
  padding: 0.25rem 1.5rem;
  clear: both;
  font-weight: 400;
  color: #212529;
  text-align: inherit;
  white-space: nowrap;
  background-color: transparent;
  border: 0;
}
#export{
  margin-left:3%;
}
.export_pdf,.export_csv{
  cursor: pointer;
  text-decoration: none;
}
.export_csv{
  margin-left:1%;
  color: #008000;
}
.export_pdf{
  color:red;
}
.notify{font-size: 14px;}
.alert-title h3 { font-size: 1.1rem;}
</style>
<!--<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>/app/assets/css/notification.css">-->

 <div class="header">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="<?php echo SITEURL; ?>">
                <img src="<?php echo SITEURL; ?>app/img/logo.png" class="header-brand-img" alt="LoadBoard logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown  d-md-flex bubble notify">
                 
                    <a class="nav-link bell_animate" data-toggle="dropdown">
                      <i class="fe fe-bell"></i>
                      <span class="notification_bell"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow msg alert-msg">
                      <div class="alert-title">
                        <h3>Notifications</h3> 
                        <small>You have <span class="total_notify_message">  </span> unread messages</p> </small >
                      </div>
                      <div id="no-alert" align="center">
                        <div id="no_notification_count"></div>
                      </div>
                      <div id="alert-link" class="alert-link">
                          
                          <div id="load_newloadnotify_count"></div>
                          <div id="load_denied_count"></div>
                          <div id="load_canceltrip_count"></div>
                          <div id="load_cancel_reopentrip_count"></div>
                          <div id="load_upcomingtripall_count"></div>
                          <div id="load_upcomingtrip_count"></div>
                          <div id="load_upcoming_deliveredtrips_count"></div>
                          <div id="load_pickupdate_expired_count"></div>
                          <div id="load_expired_count"></div>
                          <div id="load_approve_count"></div>
                      </div>
                </div>
                <!--                
               <div class="dropdown  d-md-flex">
                 <?php if($user_type=="broker") { ?>
                  <a class="nav-link icon" data-toggle="dropdown">
                    <i class="fe fe-bell bell"></i>
                    <span class="notification notification_bell"></span>
                  </a> 
                  
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow msg">
                      <div class="no_notification"></div>
                      <div  class="dropdown-item1 d-flex expiring_loads">
                        <div id="expiring_loads">
                          <span id="load_expired_count"></span> 
                        </div>
                      </div>
                      <div  class="dropdown-item d-flex approving_loads">
                         <div id="approving_loads">
                           <span id="load_approve_count"></span>
                        </div>
                      </div>
                  </div>

                  <?php } ?>
                -->
                </div> 

                <div class="dropdown dropdown-text">
                   <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
               
                    <?php if($_SESSION['user_type']=='broker'){ ?>
                  <!--<span class="avatar avatar-blue"><?php $name=str_split(isset($_SESSION['name']) ? $_SESSION['name'] : ''); echo strtoupper($name[0]);  ?></span> -->
                  <span class="avatar avatar-blue">
                      <img id="common_avatar" src="<?php echo SITEURL."app/assets/uploads/no-image.png"?>" >
                  </span>
                     <?php } ?>
                       <?php if($_SESSION['user_type']=='shipper'){ ?>
                  <!--<span class="avatar avatar-blue"><?php $name=str_split(isset($_SESSION['name']) ? $_SESSION['name'] : ''); echo strtoupper($name[0]);  ?></span> 
                -->
                <span class="avatar avatar-blue">
                      <img id="common_avatar" src="<?php echo SITEURL."app/assets/uploads/no-image.png"?>" >
                  </span>
                     <?php } ?>
 <?php if($_SESSION['user_type']=='trucker'){ ?>
                      <span class="avatar avatar-blue">

                       <?php if(empty($urow['image'])){ ?>

  <img id="common_avatar" src="<?php echo SITEURL."app/assets/uploads/no-image.png"?>" >
                       <?php }else { ?>
  <img id="common_avatar" src="<?php echo SITEURL."app/assets/uploads/original/".$urow['image']; ?>" >
                       <?php } ?>
                      

                      </span>
                     <?php } ?>



                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php $name=isset($_SESSION['name']) ? $_SESSION['name'] : ''; echo ucfirst($urow['name']); ?></span>                     
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                   <!--  <a class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>  -->
                    <!--<a class="dropdown-item" href="#">
                      <span class="float-right"><span class="badge badge-primary">6</span></span>
                      <i class="dropdown-icon fe fe-mail"></i> Inbox
                    </a>
                 <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a> -->
                   <!--  <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" >
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a> -->
                   <?php if($VerifiedCheck==true){ ?>
                    <a  href="<?php echo SITEURL.'app/'.$profile_page; ?>" class="dropdown-item" href="javascript:void(0);">
                      <!--<i class="dropdown-icon fe fe-user"></i>-->
                      <i class="dropdown-icon icon-Broker"></i> Profile
                    </a>
                    <?php if($user_type=='broker'){ ?>
                        <a  href="<?php echo SITEURL.'app/broker/trucker-list'?>" class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon icon-Favourite"></i> My Favorites
                    </a>
                    <?php }?>
                        <?php if($user_type=='shipper'){ ?>
                        <a  href="<?php echo SITEURL.'app/shipper/trucker-list'?>" class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon icon-Favourite"></i> My Favorites
                    </a>
                    <?php }?>
                     <?php if($user_type=='trucker'){ ?>
                        <a  href="<?php echo SITEURL.'app/trucker/broker-list'?>" class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon icon-Favourite"></i> My Favorites
                    </a>

                      <!--  <a  href="<?php //echo SITEURL.'app/trucker/view-list'?>" class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon fe fe-check-circle"></i> Recently Viewed Loads
                    </a> -->

                    <?php }?>
                  <?php } ?>


                    <a class="dropdown-item" href="<?php echo SITEURL; ?>app/logout">
                      <i class="dropdown-icon icon-logout"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>


  <div class="preloader"  >  
<div class="container-loader">
                <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
                                <circle cx="170" cy="170" r="160" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="135" stroke="#88c4ff"/>
                                <circle cx="170" cy="170" r="110" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="85" stroke="#88c4ff"/>
                </svg>  
</div>
  </div>
<?php 
//Multi Login Check 
$multi_lgn = $Global->db->prepare("SELECT session_id FROM users WHERE  id =:id AND status=1 ");
$multi_lgn->execute(array("id"=>$_SESSION['user_id']));
$multi_lgn_acc = $multi_lgn->fetch(PDO::FETCH_ASSOC);
$session_stored_id=$multi_lgn_acc['session_id'];
$session_page_id=$_SESSION['session_id'];

/*var_dump($session_stored_id);
var_dump($session_page_id);
var_dump($_SESSION['old_session_id']."OLDDD");*/

$session_login=3;
if($session_stored_id &&  $session_page_id){
  if($session_stored_id!=$session_page_id && empty($_SESSION['old_session_id']) ){
    $session_login=1;
  }if($session_stored_id==$session_page_id && !empty($_SESSION['old_session_id'])){
    $session_login=2;
  }/*if($session_stored_id==$session_page_id && empty($_SESSION['old_session_id'])){
    $session_login=1;
  }*/
}

//var_dump($session_login.'session_login');



?>
  <script type="text/javascript">

 $(document).ready(function() {

 var session_login="<?php  echo $session_login?>";

 var g1="<?php  echo $session_stored_id?>";
 var g2="<?php  echo $session_page_id?>";
 var g3="<?php  echo $_SESSION['old_session_id']?>";

    $(".total_notify_message").html(0);
    $(".preloader").hide();
    var user_type = LoadBoard.user_type;
    var verifychk = '<?php echo $verifychk; ?>';
    //alert(verifychk);
    if (verifychk == true) {
        if (user_type == "broker") {
            setInterval(function() {
                broker_notification();
            }, 3000)
            broker_notification();
        } else if (user_type == "trucker") {
            setInterval(function() {
                trucker_notification();
            }, 3000)
            trucker_notification();
        } else if (user_type == "shipper") {
            setInterval(function() {
                shipper_notification();
            }, 3000)
            shipper_notification();
        }
    }
$(".bell_animate").click(function(){
      if(verifychk==true || verifychk==1) {
        if (user_type=="broker") {
            //alert("broker")
            setInterval(function() {
                broker_notification();
            }, 3000)
            
            broker_notification();
        } else if(user_type=="trucker") {
            setInterval(function() {
                trucker_notification();
            }, 3000)
            trucker_notification();
        } else  if (user_type=="shipper") {
            //alert("broker")
            setInterval(function() {
                shipper_notification();
            }, 3000)
            
            shipper_notification();
        }
        $(".alert-link").css('display','block');
      }
    })

   // authcheck(session_login);
   /* setInterval(function() {
              authcheck(session_login);
      }, 3000)*/
});

function authcheck(session_login=""){
  
  if(session_login==1){
       window.location.href = LoadBoard.APP + "logout";
       window.location.href = "<?php echo SITEURL; ?>"+"401";
  }else if(session_login==2){
    Swal.fire(
      'Information!',
      'Another session was active for the same user and it is logged out',
      'warning'
      );
      $("body").removeClass("swal2-height-auto");
    return false;
  }

}

function trucker_notification() {
    var url = LoadBoard.API + 'trucker/notification-count';
    $.ajax({
        type: 'POST',
        url: LoadBoard.API + 'trucker/notification-count',
        dataType: 'json',
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "user_id": LoadBoard.userid,
        }),
        contentType: "application/json",
        // data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
        success: function(result) {
            if (result.status == 0) {
                $(".no_notification").html('No notification Found').css({
                    "color": "red",
                    "text-align": "center",
                    "font-size": "14px"
                });
                $(".notification_bell").removeClass('nav-unread ');
                $(".bell_animate").removeClass("bell icon");
                $(".total_notify_message").html(0);
                $("#no_notification_count").html('<p><span class="text-center">No Notifications Found<span></p>').show();
                $("#alert-link").hide();
                $("#no-alert").show();
            } else {
                $("#no_notification_count").hide();
                $(".no_notification").html('');
                $(".notification_bell").addClass('nav-unread');


                $(".total_notify_message").html(result.total_count);
                // New load notify starts here
                if (result.total_newloads != 0) {
                    var new_load_encode = '<?php echo $new_load_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/search-loads?nl=" + new_load_encode;
                    if (result.total_newloads == 1) {
                        var load = 'Load is';
                    } else if (result.total_newloads > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_newloadnotify_count").html('<p class="dropdown-item"> <i class="text-warning"></i>&nbsp;&nbsp;<span class="small text-danger notify">' + result.total_newloads + '</span>  <span style="color:orange" class="small text-default notify"> ' + load + ' Newly Added.</span>&nbsp;&nbsp;&nbsp;&nbsp; <a style="float:right" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_newloadnotify_count").hide();
                }

                // New load notify ends here

                // Denied Starts here
                if (result.total_denied != 0) {
                    var denied = "<?php echo $denied_loads; ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?de=" + denied;
                    if (result.total_denied == 1) {
                        var load = 'Load is';
                    } else if (result.total_denied > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_denied_count").html('<p class="dropdown-item"><i class="text-danger"></i>&nbsp;<span class="small text-danger notify">' + result.total_denied + '</span> <span  class="small text-default notify">' + load + ' Denied by Broker.</span>&nbsp;&nbsp;&nbsp;&nbsp; <a href="' + link + '" style="float:right" class="btn">View</a></p>');
                } else {
                    $("#load_denied_count").hide();
                }
                // Denied ends  here

                // Upcomming Trips Starts here
                //load_upcomingtripall_count
                if (result.totalloads_upcoming_trips != 0) {
                    var upcommingall = "<?php echo $upcommingall; ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?uall=" + upcommingall;
                    if (result.totalloads_upcoming_trips == 1) {
                        var load = 'load is';
                    } else if (result.totalloads_upcoming_trips > 1) {
                        var load = 'loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcomingtripall_count").html('<p class="dropdown-item"><i class="text-primary"></i>  <span class="small text-danger notify">' + result.totalloads_upcoming_trips + ' </span> <span  class="small text-default notify">' + load + ' approved by the provider</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');
                } else {
                    $("#load_upcomingtripall_count").hide();
                }

                // Upcomming Trips Ends here

                // Upcoming set as picked notify starts here
                if (result.total_upcomingtrips_pickupdate != 0) {
                    var picked = "<?php echo $Global->encode('pi'); ?>";
                    //var link=LoadBoard.APP+LoadBoard.user_type+"/loads?picked="+picked;

                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?pi=" + picked;
                    if (result.total_upcomingtrips_pickupdate == 1) {
                        var load = 'Load is';
                    } else if (result.total_upcomingtrips_pickupdate > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcomingtrip_count").html('<p class="dropdown-item"><i class="text-primary"></i>  <span class="small text-danger notify">' + result.total_upcomingtrips_pickupdate + ' </span> <span  class="small text-default notify"> ' + load + ' ready to pickup.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_upcomingtrip_count").hide();
                }
                // Upcoming set as picked notify ends here



                // Cancel Trip trucker starts here
                if (result.total_canceltrip != 0) {
                    var cancelload_encode = '<?php echo $cancelload_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/past-loads?cancelload_encode=" + cancelload_encode;
                    if (result.total_canceltrip == 1) {
                        var load = 'Load is';
                    } else if (result.total_canceltrip > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_canceltrip_count").html('<p class="dropdown-item"><i class="cancel-soon"></i>&nbsp; <span class="small text-danger notify">' + result.total_canceltrip + '</span> <span style="color:#000;" class="small text-default notify">' + load + ' cancelled.</span> <a style="float:right" href="' + link + '" class="btn">View</a></p>');
                } else {
                    $("#load_canceltrip_count").hide();
                }
                // Cancel Trip trucker ends here

                // cancel reopen trucker start here
                if (result.total_cancel_reopentrip != 0) {
                    var re_open_view_encode = "<?php echo $re_open_view_encode; ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/search-loads?re_open_view_encode=" + re_open_view_encode;
                    if (result.total_cancel_reopentrip == 1) {
                        var load = 'Load is';
                    } else if (result.total_cancel_reopentrip > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_cancel_reopentrip_count").html('<p class="dropdown-item"><i class="confirm-load"></i>&nbsp; <span class="small text-danger notify">' + result.total_cancel_reopentrip + '</span> <span style="color:#000;" class="small text-default notify">' + load + ' available for trucker.</span> <a style="float:right" href="' + link + '" class="btn">View</a></p>');
                } else {
                    $("#load_cancel_reopentrip_count").hide();
                }

                // cancel reopen trucker start here

            }
        }
    });
}


function broker_notification() {
    $.ajax({
        type: 'POST',
        url: LoadBoard.API + 'broker/notification-count',
        dataType: 'json',
        data: "token=" + LoadBoard.token + "&user_id=" + LoadBoard.userid,
        success: function(result) {
            if (result.status == 0) {

                $(".no_notification").html('No notification Found').css({
                    "color": "red",
                    "text-align": "center",
                    "font-size": "14px"
                });
                $(".notification_bell").removeClass('nav-unread ');
                $(".bell_animate").removeClass("bell icon");
                $(".total_notify_message").html(0);
                $("#no_notification_count").html('<p><span class="text-center">No Notifications Found<span></p>').show();

                $("#alert-link").hide();
                $("#no-alert").show();
            } else {
                $("#no_notification_count").hide();
                $(".no_notification").html('');
                $(".notification_bell").addClass('nav-unread');

                $(".total_notify_message").html(result.total_count);

                // Expiring Loads starts here
                if (result.total_expired_loads != 0) {
                    var exp = "<?php echo $expiring_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?e=" + exp;
                    if (result.total_expired_loads == 1) {
                        var load = 'Load is';
                    } else if (result.total_expired_loads > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_expired_count").html('<p class="dropdown-item"><i class="text-danger"></i> <span class="small text-danger notify">' + result.total_expired_loads + ' </span> <span class="small text-default notify"> ' + load + '  Expiring soon.</span> <a style="float:right;" href="' + link + '"  class="btn">View</a></p></div>');

                } else {
                    $("#load_expired_count").hide();
                }
                // Expiring Loads ends here

                // Approve Loads starts here
                if (result.total_approve_loads != 0) {
                    var awat = "<?php echo $approval_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?a=" + awat;
                    if (result.total_approve_loads == 1) {
                        var load = 'Load is';
                    } else if (result.total_approve_loads > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_approve_count").html('<p class="dropdown-item"><i class=" approved-load"></i> <span class="small text-danger notify">' + result.total_approve_loads + ' </span> <span class="small text-default notify"> ' + load + '  Awaiting approval.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_approve_count").hide();
                }
                // Approve Loads ends here

                // Cancel Loads Starts here
                if (result.total_canceltrip != 0) {
                    var cancel = "<?php echo $canceltrip_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?re=" + cancel;
                    if (result.total_canceltrip == 1) {
                        var load = 'Load is';
                    } else if (result.total_canceltrip > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_canceltrip_count").html('<p class="dropdown-item"><i class="cancel-soon"></i>  <span class="small text-danger notify">' + result.total_canceltrip + ' </span> <span class="small text-default notify"> ' + load + ' Cancelled by Trucker.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_canceltrip_count").hide();
                }
                // Cancel Loads Ends here


                // picked Loads Starts here
                if (result.total_picked != 0) {
                    var picked_encode = '<?php echo $picked_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/in-progress?pi=" + picked_encode;
                    if (result.total_picked == 1) {
                        var load = 'Load is';
                    } else if (result.total_picked > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcomingtrip_count").html('<p class="dropdown-item"><i class="text-primary"></i> <span class="small text-danger notify">' + result.total_picked + ' </span> <span class="small text-default notify"> ' + load + ' Picked by Trucker.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_upcomingtrip_count").hide();
                }
                // picked Loads ends here

                // delivere Loads Starts here
                if (result.total_delivered != 0) {
                    var delivered_encode = '<?php echo $delivered_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/past-loads?dli=" + delivered_encode;
                    if (result.total_delivered == 1) {
                        var load = 'Load is';
                    } else if (result.total_delivered > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcoming_deliveredtrips_count").html('<p class="dropdown-item"><i class="delivered"></i><span class="small text-danger notify">' + result.total_delivered + ' </span> <span style="color:#000;" class="small text-default notify"> ' + load + ' Delivered by Trucker </span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_upcoming_deliveredtrips_count").hide();
                }
                // delivere Loads ends here

            }
        }
    });
}
function shipper_notification() {
    $.ajax({
        type: 'POST',
        url: LoadBoard.API + 'shipper/notification-count',
        dataType: 'json',
        data: "token=" + LoadBoard.token + "&user_id=" + LoadBoard.userid,
        success: function(result) {
            if (result.status == 0) {

                $(".no_notification").html('No notification Found').css({
                    "color": "red",
                    "text-align": "center",
                    "font-size": "14px"
                });
                $(".notification_bell").removeClass('nav-unread ');
                $(".bell_animate").removeClass("bell icon");
                $(".total_notify_message").html(0);
                $("#no_notification_count").html('<p><span class="text-center">No Notifications Found<span></p>').show();

                $("#alert-link").hide();
                $("#no-alert").show();
            } else {
                $("#no_notification_count").hide();
                $(".no_notification").html('');
                $(".notification_bell").addClass('nav-unread');

                $(".total_notify_message").html(result.total_count);

                // Expiring Loads starts here
                if (result.total_expired_loads != 0) {
                    var exp = "<?php echo $expiring_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?e=" + exp;
                    if (result.total_expired_loads == 1) {
                        var load = 'Load is';
                    } else if (result.total_expired_loads > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_expired_count").html('<p class="dropdown-item"><i class="text-danger"></i> <span class="small text-danger notify">' + result.total_expired_loads + ' </span> <span class="small text-default notify"> ' + load + '  Expiring soon.</span> <a style="float:right;" href="' + link + '"  class="btn">View</a></p></div>');

                } else {
                    $("#load_expired_count").hide();
                }
                // Expiring Loads ends here

                // Approve Loads starts here
                if (result.total_approve_loads != 0) {
                    var awat = "<?php echo $approval_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?a=" + awat;
                    if (result.total_approve_loads == 1) {
                        var load = 'Load is';
                    } else if (result.total_approve_loads > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_approve_count").html('<p class="dropdown-item"><i class=" approved-load"></i> <span class="small text-danger notify">' + result.total_approve_loads + ' </span> <span class="small text-default notify"> ' + load + '  Awaiting approval.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_approve_count").hide();
                }
                // Approve Loads ends here

                // Cancel Loads Starts here
                if (result.total_canceltrip != 0) {
                    var cancel = "<?php echo $canceltrip_encode;  ?>";
                    var link = LoadBoard.APP + LoadBoard.user_type + "/loads?re=" + cancel;
                    if (result.total_canceltrip == 1) {
                        var load = 'Load is';
                    } else if (result.total_canceltrip > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_canceltrip_count").html('<p class="dropdown-item"><i class="cancel-soon"></i>  <span class="small text-danger notify">' + result.total_canceltrip + ' </span> <span class="small text-default notify"> ' + load + ' Cancelled by Trucker.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_canceltrip_count").hide();
                }
                // Cancel Loads Ends here


                // picked Loads Starts here
                if (result.total_picked != 0) {
                    var picked_encode = '<?php echo $picked_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/in-progress?pi=" + picked_encode;
                    if (result.total_picked == 1) {
                        var load = 'Load is';
                    } else if (result.total_picked > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcomingtrip_count").html('<p class="dropdown-item"><i class="text-primary"></i> <span class="small text-danger notify">' + result.total_picked + ' </span> <span class="small text-default notify"> ' + load + ' Picked by Trucker.</span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_upcomingtrip_count").hide();
                }
                // picked Loads ends here

                // delivere Loads Starts here
                if (result.total_delivered != 0) {
                    var delivered_encode = '<?php echo $delivered_encode; ?>';
                    var link = LoadBoard.APP + LoadBoard.user_type + "/past-loads?dli=" + delivered_encode;
                    if (result.total_delivered == 1) {
                        var load = 'Load is';
                    } else if (result.total_delivered > 1) {
                        var load = 'Loads are';
                    }
                    $(".bell_animate").addClass("bell icon");
                    $("#load_upcoming_deliveredtrips_count").html('<p class="dropdown-item"><i class="delivered"></i><span class="small text-danger notify">' + result.total_delivered + ' </span> <span style="color:#000;" class="small text-default notify"> ' + load + ' Delivered by Trucker </span> <a style="float:right;" href="' + link + '" class="btn">View</a></p>');

                } else {
                    $("#load_upcoming_deliveredtrips_count").hide();
                }
                // delivere Loads ends here

            }
        }
    });
}
</script> 

