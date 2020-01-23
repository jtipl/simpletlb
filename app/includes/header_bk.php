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

$VerifiedCheck=$Global->VerifiedCheck();
$expiring_encode = $Global->encode('expiring');
$approval_encode = $Global->encode('awaiting');
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

</style>

<!--<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>/app/assets/css/notification.css">-->
<script type="text/javascript">
  $(document).ready(function(){
    var user_type = LoadBoard.user_type;
    //alert(user_type)
    if(user_type=="broker"){
        setInterval(function(){
          broker_notification();
        },1000);
      }
  });

  function broker_notification(){
     $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/notification-count',
        dataType: 'json',
      //  data:"token="+LoadBoard.token,
        data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
        success:function(result){

          

          if(result.status==0){
             $(".no_notification").html('No notification Found').css({"color": "red","text-align":"center", "font-size": "14px"});
                $(".notification_bell").removeClass('nav-unread ');
          } else {
            $(".no_notification").html('');
             $(".notification_bell").addClass('nav-unread');


            if(result.total_expired_loads!=0){
              $("#expiring_loads").show();
              var exp="<?php echo $expiring_encode;  ?>";
              var link=LoadBoard.APP+LoadBoard.user_type+"/loads?e="+exp;
              $("#load_expired_count").html('<span class="small alert-danger" >Expiring</span> &nbsp;&nbsp;&nbsp;<span class="small text-muted">'+result.total_expired_loads+'&nbsp;&nbsp;&nbsp;of your loads will get Expired soon.&nbsp;&nbsp;&nbsp;<a href="'+link+'" class="view_links">View </a></span>');
            } else {
              $("#expiring_loads").hide();
            }
            if(result.total_approve_loads!=0){

              $("#approving_loads").show();
              var awat="<?php echo $approval_encode;  ?>";
              var link=LoadBoard.APP+LoadBoard.user_type+"/loads?a="+awat;
              $("#load_approve_count").html('<span class="small alert-success" >Approval</span> &nbsp;&nbsp;&nbsp;<span class="small text-muted">'+result.total_approve_loads+'&nbsp;&nbsp;&nbsp;of your loads are awaiting for your approval.&nbsp;&nbsp;&nbsp;<a href="'+link+'" class="view_links">View </a></span>');
 
            } else {
              $("#approving_loads").hide();
            }  
          }

        }
      });
  }
</script> 
 <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="<?php echo SITEURL; ?>">
                <img src="<?php echo SITEURL; ?>app/assets/brand/logo.png" class="header-brand-img" alt="LoadBoard logo">
              </a>
              <div class="d-flex order-lg-2 ml-auto">                
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
                </div> 

                <div class="dropdown">
                   <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                   <span class="avatar avatar-blue"><?php $name=str_split(isset($_SESSION['name']) ? $_SESSION['name'] : ''); echo strtoupper($name[0]);  ?></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php $name=isset($_SESSION['name']) ? $_SESSION['name'] : ''; echo ucfirst($name); ?></span>                     
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
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                  <?php } ?>


                    <a class="dropdown-item" href="<?php echo SITEURL; ?>app/logout">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
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