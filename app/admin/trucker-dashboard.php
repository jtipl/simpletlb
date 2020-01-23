<?php
  require_once("../../elements/Global.php");
  $Global=new LoadBoard();
$Global->AfterAdminloginCheck();
  
  $Global->admin_header("SimpleTLB - Trucker Dashboard");
?>
<link href="<?php echo SITEURL; ?>app/admin/dist/map/css/jqvmap.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
   
tspan.highcharts-anchor{
  display: none;
}
.dataTables_wrapper.no-footer .dataTables_scrollBody{
  border-bottom: 2px solid #f5f5f5;
}

  </style>
  <!-- Main Content -->
  <div class="page-wrapper">
      <div class="container-fluid pt-30">
        <!-- Row -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Trucker Dashboard - <span class="trucker_name">vk</span></h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="javascript:void(0);"><span>Trucker Management</span></a></li>
            <li class=""><a href="javascript:void(0);"><span>Trucker List</span></a></li>
            <li class="active"><a href="javascript:void(0);"><span>Dashboard</span></a></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div class="panel-body pa-0">
                    <div class="sm-data-box">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                            <span class="txt-dark block counter awaiting_count"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Awaiting Approval</span>
                          </div>
                       <!--    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class=" icon-rocket data-right-rep-icon txt-success"></i>
                          </div> -->
                        </div>
                        <div class="progress-anim">
                          <div class="progress">
                            <div class="progress-bar progress-bar-warning
                            wow animated progress-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div class="panel-body pa-0">
                    <div class="sm-data-box">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                            <span class="txt-dark block counter upcoming_count"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Upcoming trips</span>
                          </div>
                       <!--    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class="icon-location-pin data-right-rep-icon txt-warning"></i>
                          </div> -->
                        </div>
                        <div class="progress-anim">
                          <div class="progress">
                            <div class="progress-bar progress-bar-primary
                            wow animated progress-animated" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div class="panel-body pa-0">
                    <div class="sm-data-box">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                            <span class="txt-dark block counter in_loads"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Picked Loads</span>
                          </div>
                        <!--   <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class=" icon-close data-right-rep-icon txt-danger"></i>
                          </div> -->
                        </div>
                        <div class="progress-anim">
                          <div class="progress">
                            <div class="progress-bar progress-bar-info
                            wow animated progress-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                  <div class="panel-body pa-0">
                    <div class="sm-data-box">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                            <span class="txt-dark block counter total_loads"><span class="Postgres Credential">00</span></span>
                            <span class="capitalize-font block">Delivery Loads</span>
                          </div>
                       <!--    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class="icon-direction  data-right-rep-icon txt-primary"></i>
                          </div> -->
                        </div>
                        <div class="progress-anim">
                          <div class="progress">
                            <div class="progress-bar progress-bar-success
                            wow animated progress-animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /Row -->
<!--<div class="row">
            <div class="col-lg-3 col-xs-12">
              <div class="panel panel-default card-view  pa-0">
                <div class="panel-wrapper collapse in">
                  <div class="panel-body  pa-0">
                    <div class="profile-box">
                      <div class="profile-cover-pic">
                        <div class="profile-image-overlay"></div>
                      </div>
                      <div class="profile-info text-center mb-15">
                        <div class="profile-img-wrap">
                          <img class="inline-block mb-10" src="../img/mock1.jpg" alt="user"/>
                          <div class="fileupload btn btn-default">
                            <span class="btn-text">edit</span>
                            <input class="upload" type="file">
                          </div>
                        </div>  
                        <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-dark business_name" id="broker_name">Madalyn Rascon</h5>
                        <h6 class="block capitalize-font pb-20 " id="broker_business_name">Developer Geek</h6>
                      </div>  
                      <div class="social-info">
                        <div class="row">
                          <div class="col-xs-4 text-center">
                            <span class="counts block head-font"><span class="counter-anim" id="favorites">00</span></span>
                            <span class="counts-text block">Favorites</span>
                          </div>
                          <div class="col-xs-4 text-center">
                            <span class="counts block head-font"><span class="counter-anim" id="rate">246</span></span>
                            <span class="counts-text block">Rating</span>
                          </div>
                          <div class="col-xs-4 text-center">
                            <span class="counts block head-font"><span class="counter-anim" id="like">898</span></span>
                            <span class="counts-text block">Likes</span>
                          </div>
                        </div>
                       <a href="<?php echo SITEURL; ?>app/admin/broker-profile?id=<?php echo $_REQUEST['id']; ?>"> <button class="btn btn-primary btn-block  mt-30" data-toggle="modal" data-target="#myModal"><i class="icon-eye mr-10"></i><span class="btn-text">View Profile</span></button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
   <div class="panel panel-default border-panel card-view">
      <div class="panel-heading">
         <div class="pull-left">
            <h6 class="panel-title txt-dark">balance statistics</h6>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="panel-wrapper collapse in">
         <div class="panel-body">
            <ul class="flex-stat flex-stat-2 mt-20">
               <li>
                  <span class="block"><span class="initial">$ </span><span class="txt-dark weight-300 counter-anim data-rep">7,115,008</span></span>
                  <span class="block">Bitcoin Price</span>
               </li>
               <li>
                  <span class="block"><span class="initial">$ </span><span class="txt-dark weight-300 counter-anim data-rep">5,426.21</span></span>
                  <span class="block">Since Last Month (USD)</span>
               </li>
               <li>
                  <span class="block">
                  <i class="zmdi zmdi-caret-up pr-10 font-24 txt-success"></i><span class="txt-dark weight-300 data-rep"><span class="counter-anim">89</span>%</span>
                  </span>
                  <span class="block">Since Last Month (%)</span>
               </li>
            </ul>
            <div id="chart_1s" class="morris-chart" style="height:330px;"></div>
         </div>
      </div>
   </div>
</div>


          </div> -->
          <!-- /Row -->
          <!-- Row -->
          <div class="row">
           <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                  <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">State Wise Loads</h6>
                   
                  </div> 
                  &nbsp;&nbsp;&nbsp;<!-- <select>
                       <option value="">Select Option</option>
                       <option value="1">Awaiting Approval</option>
                       <option value="2">Upcoming Trips</option>
                       <option value="3">In Progress</option>
                     </select> -->
                  <div class="pull-right">
                   
                     <a href="#" class="pull-left inline-block refresh mr-15">
                     <p>Total Loads -  <span class="map_loads">0</span></p>
                     
                    </a>
                    <a href="#" class="pull-left inline-block refresh mr-15">
                      <i class="zmdi zmdi-replay"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                      <i class="zmdi zmdi-fullscreen"></i>
                    </a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body" style="padding-top: 0px !important;">
                <!--       <div id="dvMap" style="height: 400px">
</div> -->
<!--     <div id="vmap" style=" height: 400px;"></div>
 -->    <div id="container"></div>


                  </div>
                </div>
                          </div>
                      </div>
      
      <div class="col-lg-4 col-md-6 col-xs-12">
            <div class="panel panel-default border-panel card-view">
              <div class="panel-heading">
                <div class="pull-left">
                  <h6 class="panel-title txt-dark">recent activity</h6>
                </div>
               <!--  <a class="txt-danger pull-right right-float-sub-text inline-block" href="javascript:void(0)"> clear all </a> -->
                <div class="clearfix"></div>
              </div>
              <div class="panel-wrapper task-panel collapse in">
                <div class="panel-body row pa-0">
                  <div class="list-group recent_activity mb-0">
                             
                  
                  </div>
                </div>
              </div>
            </div>
          </div>           
 <!--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
   <div class="panel panel-default card-view panel-refresh">

      <div class="refresh-container">
         <div class="la-anim-1"></div>
      </div>
      <div class="panel-heading">
         <div class="pull-left">
            <h6 class="panel-title txt-dark">Loads by Status</h6>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="panel-wrapper collapse in">
         <div class="panel-body row">
            <div class="col-sm-6 pa-0">
               <div id="e_chart_3ssss" class="" style="height:185px;"></div>
            </div>
            <div class="col-sm-6 pr-0 pt-30">
               <div class="label-chatrs">
                  <div class="">
                     <span class="clabels circular-clabels inline-block bg-red mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">AWAITING APPROVAL</span>
                  </div>
                                    <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-blue mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">UPCOMING</span>
                  </div>  
                   <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-orange mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">IN PROGRESS</span>
                  </div>                
                  <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-green mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">PAST LOAD</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
    <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div>
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      AWAITING
                    </span>
                    <span class="label label-warning pull-right" id="awaitn">50%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      UPCOMING
                    </span>
                    <span class="label label-warning pull-right" id="upcom">10%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      IN PROGRESS
                    </span>
                    <span class="label label-warning pull-right" id="in_pro">30%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      PAST LOAD
                    </span>
                    <span class="label label-warning pull-right" id="past_ld">10%</span>
                    <div class="clearfix"></div>
                  </div>
                </div>  
              </div>
   </div>
</div> -->
            </div> 
          <!-- Row -->
   <!-- Row -->
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                  <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Awaiting Approval</h6>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="pull-left inline-block refresh mr-15">
                      <i class="zmdi zmdi-replay"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                      <i class="zmdi zmdi-fullscreen"></i>
                    </a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body row pa-0">
                    <div class="table-wrap">
                      <div class="table-responsive">
                        <table id="await_loads" class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                              <!-- <th>Broker Name</th> -->
                              <th>Price</th>
                            </tr>
                          </thead>
                          <tbody>
                        </table>
                      </div>
                    </div>  
                  </div>  
                </div>
              </div>
            </div> 
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                  <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Upcoming Trips</h6>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="pull-left inline-block refresh mr-15">
                      <i class="zmdi zmdi-replay"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                      <i class="zmdi zmdi-fullscreen"></i>
                    </a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body row pa-0">
                    <div class="table-wrap">
                      <div class="table-responsive">
                        <table id="upcom_loads" class="table table-hover mb-0">
                          <thead>
                           <tr>
                             <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                          <!--     <th>Broker Name</th> -->
                              <th>Price</th>
                              
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>  
                  </div>  
                </div>
              </div>
            </div>
          </div>
          <!-- Row -->
         <!-- Row -->
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                  <div class="refresh-container">
                    <div class="la-anim-1"></div>
                  </div>
                  <div class="panel-heading">
                    <div class="pull-left">
                      <h6 class="panel-title txt-dark">Picked Loads</h6>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="pull-left inline-block refresh mr-15">
                        <i class="zmdi zmdi-replay"></i>
                      </a>
                      <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen"></i>
                      </a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                      <div class="table-wrap">
                        <div class="table-responsive">
                          <table id="pick_ld" class="table table-hover mb-0">
                            <thead>
                              <tr>
                                <th>Load-Id</th>
                                <th>Origin</th>
                                <th>Destniation</th>
                               
                                <th>Price</th>
                              </tr>
                            </thead>
                            <tbody>
                          </table>
                        </div>
                      </div>  
                    </div>  
                  </div>
                </div>
              </div> 
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                  <div class="refresh-container">
                    <div class="la-anim-1"></div>
                  </div>
                  <div class="panel-heading">
                    <div class="pull-left">
                      <h6 class="panel-title txt-dark"> Denied Loads</h6>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="pull-left inline-block refresh mr-15">
                        <i class="zmdi zmdi-replay"></i>
                      </a>
                      <a href="#" class="pull-left inline-block full-screen mr-15">
                        <i class="zmdi zmdi-fullscreen"></i>
                      </a>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                      <div class="table-wrap">
                        <div class="table-responsive">
                          <table id="denid_ld" class="table table-hover mb-0">
                            <thead>
                             <tr>
                               <th>Load-Id</th>
                                <th>Origin</th>
                                <th>Destniation</th>
                                <th>Price</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>  
                    </div>  
                  </div>
                </div>
              </div>
            </div>
         <!-- Row -->
                <!-- Row -->
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                  <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Delivered Loads</h6>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="pull-left inline-block refresh mr-15">
                      <i class="zmdi zmdi-replay"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                      <i class="zmdi zmdi-fullscreen"></i>
                    </a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body row pa-0">
                    <div class="table-wrap">
                      <div class="table-responsive">
                        <table id="deliv_ld" class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                              <th>Price</th>
                            </tr>
                          </thead>
                          <tbody>
                        </table>
                      </div>
                    </div>  
                  </div>  
                </div>
              </div>
            </div> 
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                <div class="refresh-container">
                  <div class="la-anim-1"></div>
                </div>
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Cancelled Loads</h6>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="pull-left inline-block refresh mr-15">
                      <i class="zmdi zmdi-replay"></i>
                    </a>
                    <a href="#" class="pull-left inline-block full-screen mr-15">
                      <i class="zmdi zmdi-fullscreen"></i>
                    </a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body row pa-0">
                    <div class="table-wrap">
                      <div class="table-responsive">
                        <table id="cancel_ld" class="table table-hover mb-0">
                          <thead>
                           <tr>
                              <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                             <!--  <th>Broker Name</th> -->
                              <th>Price</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>  
                  </div>  
                </div>
              </div>
            </div>
          </div>
       <!-- Row -->
          <!-- Row -->



          </div>  
          <!-- Row -->
        
       <?php  
      $Global->admin_footer();
        ?>
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;sensor=false"></script>
 <script type="text/javascript">
 	var user_id=getUrlParameter('id');
 	var awaits= 0;
 	var upcom= 0;
 	var in_load =0;
 	var past_load =0;
function msToTime(s) {
  var ms = s % 1000;
  s = (s - ms) / 1000;
  var secs = s % 60;
  s = (s - secs) / 60;
  var mins = s % 60;
  var hrs = (s - mins) / 60;

  return hrs + ':' + mins + ':' + secs + '.' + ms;
}
var periods = {
  month: 30 * 24 * 60 * 60 * 1000,
  week: 7 * 24 * 60 * 60 * 1000,
  day: 24 * 60 * 60 * 1000,
  hour: 60 * 60 * 1000,
  minute: 60 * 1000
};

function formatTime(timeCreated) {
  var diff = Date.now() - timeCreated;
console.log(diff)
  if (diff > periods.month) {
    // it was at least a month ago
    return Math.floor(diff / periods.month) + "m";
  } else if (diff > periods.week) {
    return Math.floor(diff / periods.week) + "w";
  } else if (diff > periods.day) {
    return Math.floor(diff / periods.day) + "d";
  } else if (diff > periods.hour) {
    return Math.floor(diff / periods.hour) + "h";
  } else if (diff > periods.minute) {
    return Math.floor(diff / periods.minute) + "m";
  }
  return "Just now";
}
 	 $( document ).ready(function() {
         $.ajax({
              type:'POST',
                url:LoadBoard.API+'admin/trucker-dashboard',
                dataType: 'json',
                async:false,
                headers: {
                  Authorization: "Bearer "+LoadBoard.admintoken
                },
              contentType: "application/json",
              data:JSON.stringify({"user_id":user_id}),
              success:function(result){


	              if(result.status==2){
	              window.location.href=LoadBoard.APP+"logout";
	              }else if(result.status==1){
	              $(".awaiting_count").html(result.data.awaiting_count);
	              $(".upcoming_count").html(result.data.upcoming_count);
	              $(".in_loads").html(result.data.inprogress_count);
	              $(".past_loads").html(result.data.past_count);
	              $(".cancel_loads").html(result.data.cancelled_count);
	              $(".total_loads").html(result.data.past_count);
	              $("#awaitn").html(result.data.awaiting_percentage.toFixed(2));
	              $("#upcom").html(result.data.upcoming_percentage.toFixed(2));
	              $("#in_pro").html(result.data.inprogress_percentage.toFixed(2));
	              $("#past_ld").html(result.data.past_percentage.toFixed(2));
                $(".map_loads").html(result.data.confrm_state_count);
               $(".trucker_name").html(result.data.name);

                    awaits = result.data.awaiting_percentage;
                    upcom = result.data.upcoming_percentage;
                    in_load = result.data.inprogress_percentage;
                    past_load = result.data.past_percentage;
                    var content="";
                    console.log(result.data.awaiting_records)
                    if(result.data.awaiting_records!=''){
                          for (var i = 0; i < result.data.awaiting_records.length; i++) {
                            var convr_time=formatTime(msToTime(new Date(result.data.awaiting_records[i].confirm_date).valueOf()));
                            
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.awaiting_records[i].load_id+' - Awaiting Approval</p><div class="clearfix"></div></a>';
                          }

                          for (var i = 0; i < result.data.upcoming_records.length; i++) {
                              var uconvr_time=formatTime(msToTime(new Date(result.data.upcoming_records[i].approval_date).valueOf()));
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.upcoming_records[i].load_id+' - Upcoming Trips</p><div class="clearfix"></div></a>';
                          }

                           for (var i = 0; i < result.data.inprogress_records.length; i++) {
                            var inconvr_time=formatTime(msToTime(new Date(result.data.inprogress_records[i].picked_date).valueOf()));

                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.inprogress_records[i].load_id+' - Picked Loads</p><div class="clearfix"></div></a>';
                          }

                            for (var i = 0; i < result.data.past_records.length; i++) {
                               var dconvr_time=formatTime(msToTime(new Date(result.data.past_records[i].delivered_date).valueOf()));
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-truck pull-left"></i><p class="pull-left">'+result.data.past_records[i].load_id+' - Delivery Loads</p><div class="clearfix"></div></a>';
                          }
                     
                     
                      $(".recent_activity").html(content);


                    }else{
                      content='<a style="text-align:center;" href="#" class="list-group-item">No records found<div class="clearfix"></div></a>';
                      $(".recent_activity").html(content);
                    }

	          	  }
          	  }
          });

      if( $('#e_chart_3ssss').length > 0 ){
    var eChart_3 = echarts.init(document.getElementById('e_chart_3ssss'));
    var data = [{
      value: awaits,
      name: ''
    }, 
    {
      value: upcom,
      name: ''
    },{
      value: in_load,
     name: ''
    },  {
      value: past_load,
      name: ''
    }];
    var option3 = {
      tooltip: {
        show: true,
        trigger: 'item',
        backgroundColor: 'rgba(33,33,33,1)',
        borderRadius:0,
        padding:10,
        formatter: "{b}: {c} ({d}%)",
        textStyle: {
          color: '#fff',
          fontStyle: 'normal',
          fontWeight: 'normal',
          fontFamily: "'Montserrat', sans-serif",
          fontSize: 12
        } 
      },
      series: [{
        type: 'pie',
        selectedMode: 'single',
        radius: ['90%', '40%'],
        color: ['#da4296', '#fd6421', '#243f6b', '#4dad44'],
        labelLine: {
          normal: {
            show: false
          }
        },
        data: data
      }]
    };
    eChart_3.setOption(option3);
    eChart_3.resize();
  }


      
      

	});

   function escapeXml(string) {
        return string.replace(/[<>]/g, function (c) {
          switch (c) {
            case '<': return '\u003c';
            case '>': return '\u003e';
          }
        });
      }
   table = $('#await_loads').DataTable({
            "pageLength": 5,

          "scrollY": 285,
          "scrollX": true,

         // dom: 'Bfrtip',
            //"ajax": LoadBoard.API+'trucker/awaiting-loads?user_id='+user_id+'',
           "ajax": {
            url: LoadBoard.API+'trucker/awaiting-loads',
            type:"post",
            headers: {
             Authorization: "Bearer "+LoadBoard.admintoken
            },
            contentType: "application/json",
            "dataFilter": function(data) {
              var awaiting_data = JSON.parse(data);
              console.log(awaiting_data)
              if(awaiting_data.status==2){
                  window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                return JSON.stringify(awaiting_data);  
              }
              
            },

           "data": function(data){
              data.user_id =user_id
              return   JSON.stringify(data);
          },


          },

             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
              /*  {"data": "weight"},
                {"data": "length"},*/
               // {"data": "business_name"},
                {"data": "price" },
            ],
    columnDefs: [
          {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
       /* {
          targets:3,
          render:function(data,type,row){
             return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
          }
       },*/
              {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });
     table = $('#upcom_loads').DataTable({
            "pageLength": 5,
             "scrollY": 285,
          "scrollX": true,

         // dom: 'Bfrtip',
          //  "ajax": LoadBoard.API+'trucker/upcoming-trips?user_id='+user_id+'',
           "ajax": {
            url: LoadBoard.API+'trucker/upcoming-trips',
            type:"post",
             headers: {
                 Authorization: "Bearer "+LoadBoard.admintoken
               },
             contentType: "application/json",
            "dataFilter": function(data) {
              var data = JSON.parse(data);
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                 return JSON.stringify(data);
              }
            },
             "data": function(data){
                data.user_id =user_id
                return   JSON.stringify(data);
             },
          },


             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
               /* {"data": "business_name"},*/
              /*  {"data": "vehicle_details"},*/
            ],
    columnDefs: [
          {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
       /* {
          targets:3,
          render:function(data,type,row){
             return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
          }
       },*/
           {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });

     table = $('#pick_ld').DataTable({
            "pageLength": 5,
            "scrollY": 285,
            "scrollX": true,

         // dom: 'Bfrtip',
            //"ajax": LoadBoard.API+'trucker/inprogress-trips?user_id='+user_id+'',
            "ajax": {
            url: LoadBoard.API+'trucker/inprogress-trips',
            type:"post",
             headers: {
                 Authorization: "Bearer "+LoadBoard.admintoken
               },
             contentType: "application/json",
            "dataFilter": function(data) {
              //console.log(data);
              var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
              if(rowCount ==0){
              $("#export").hide();
              } else {
              $("#export").show();
              }
              $("#total_count").val(rowCount);
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                 return JSON.stringify(data);
              }
             
            },
            "data": function(data){
              data.user_id =user_id
              return   JSON.stringify(data);
           },
          },
             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
               // {"data": "business_name"},
            ],
    columnDefs: [
     {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
       /* {
          targets:3,
          render:function(data,type,row){
             return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
          }
       },*/
              {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

          
     ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });

      table = $('#denid_ld').DataTable({
            "pageLength": 5,
             "scrollY": 285,
             "scrollX": true,
        
         // dom: 'Bfrtip',
          //  "ajax": LoadBoard.API+'trucker/denied-loads?user_id='+user_id+'',
             "ajax": {
            url: LoadBoard.API+'trucker/denied-loads',
            type:"post",
            headers: {
              Authorization: "Bearer "+LoadBoard.admintoken
            },
            contentType: "application/json",
            "dataFilter": function(data) {
              //console.log(data);
              var data = JSON.parse(data);
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                 return JSON.stringify(data);
              }
             
            },
             "data": function(data){
              data.user_id =LoadBoard.userid
              return   JSON.stringify(data);
            },
          },
             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
            ],
    columnDefs: [
     {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
       /* {
          targets:3,
          render:function(data,type,row){
             return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
          }
       },*/
              {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

          
     ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });
       table = $('#deliv_ld').DataTable({
         // dom: 'Bfrtip',
      // "ajax": LoadBoard.API+'trucker/past-loads?user_id='+user_id+'',
      "scrollY": 285,
      "scrollX": true,
        "ajax": {
        url: LoadBoard.API+'trucker/past-loads',
        type:"post",
        headers: {
        Authorization: "Bearer "+LoadBoard.admintoken
        },
        contentType: "application/json",
        "dataFilter": function(data) {
        //console.log(data);
        var data = JSON.parse(data);
        if(data.status==2){
          window.location.href = LoadBoard.APP + "admin/logout";
        }else{
           return JSON.stringify(data);  
        }

        },
        "data": function(data){
                data.user_id =user_id
                return   JSON.stringify(data);
            },
        },
             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
            ],
    columnDefs: [
     {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
       
              {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

          
     ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });

       table = $('#cancel_ld').DataTable({
         // dom: 'Bfrtip',
          //  "ajax": LoadBoard.API+'trucker/cancel-loads?user_id='+user_id+'',
        "scrollY": 285,
        "scrollX": true,
             "ajax": {
          url: LoadBoard.API+'trucker/cancel-loads',
          type:"post",
          headers: {
            Authorization: "Bearer "+LoadBoard.admintoken
          },
          contentType: "application/json",
          "dataFilter": function(data) {
            var data = JSON.parse(data);
          
            if(data.status==2){
                   window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                return JSON.stringify(data);  
              }
          },
           "data": function(data){
              data.user_id =user_id
              return   JSON.stringify(data);
          },
        },
             "bLengthChange": true,  
              "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
             "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
               // {"data": "business_name"},
            ],
    columnDefs: [
     {
            targets: 0,
            render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

            }
          },
          {
          targets: 1,
          render: function (data,type,row) {
                 var orgt=row.origin.split(",");
                 return orgt[0]+", "+orgt[1];

                  }
        },
         {
          targets: 2,
          render: function (data,type,row) {
                   var dest=row.destination.split(",");
                 return dest[0]+", "+dest[1];

                  }
        },
     /*   {
          targets:3,
          render:function(data,type,row){
             return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
          }
       },*/
              {
        targets: 3,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      }

          
     ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });
        function trimObj(obj) {
        if (!Array.isArray(obj) && typeof obj != 'object') return obj;
        return Object.keys(obj).reduce(function(acc, key) {
        acc[key.trim()] = typeof obj[key] == 'string'? obj[key].trim() : trimObj(obj[key]);
        return acc;
        }, Array.isArray(obj)? []:{});
        }
$(document).ready(function(){

    //Array of JSON objects.
    var loadslist="";
    var arrData=[];
     $.ajax({
       
        url:LoadBoard.API+'admin/trucker-loads-state',
        dataType: 'json',
        type:"post",
        headers: {
            Authorization: "Bearer "+LoadBoard.admintoken
          },
        contentType: "application/json",
        async:false,
        data:JSON.stringify({"user_id":user_id}),
        success:function(result){
             if(result.status==2){
                   window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                var AssocArray = []; 
                var AssocArray1 = []; 
                if(result.data){
                 for (var i = 0; i < result.data.length; i++) {
                    if(result.data[i].title=='south carolina'){
                      var rr='sc';
                    }else{
                       var rr=result.data[i].title;
                    }
                   var arr = { "hc-key": result.data[i].title, "value": result.data[i].load_count}; 
                    AssocArray1.push(arr);
                     // JSON.stringify(AssocArray); 
                     // JSON.stringify(AssocArray1); 
                  }
                 console.log(AssocArray1)
                var data = [
                    ['us-ca', 0],
                    ['us-or', 1],
                    ['us-nd', 2],
                    ['ca-sk', 3],
                    ['us-mt', 4],
                    ['us-az', 5],
                    ['us-nv', 6],
                    ['us-al', 7],
                    ['us-nm', 8],
                    ['us-co', 9],
                    ['us-wy', 10],
                    ['us-wi', 11],
                    ['us-ks', 12],
                    ['us-ne', 13],
                    ['us-ok', 14],
                    ['us-mi', 15],
                    ['us-ak', 16],
                    ['us-oh', 17],
                    ['ca-bc', 18],
                    ['ca-nu', 19],
                    ['ca-nt', 20],
                    ['ca-ab', 21],
                    ['us-ma', 22],
                    ['us-vt', 23],
                    ['us-mn', 24],
                    ['us-wa', 25],
                    ['us-id', 26],
                    ['us-ar', 27],
                    ['us-tx', 28],
                    ['us-ri', 29],
                    ['us-fl', 30],
                    ['us-ms', 31],
                    ['us-ut', 32],
                    ['us-nc', 33],
                    ['us-ga', 34],
                    ['us-va', 35],
                    ['us-tn', 36],
                    ['us-ia', 37],
                    ['us-md', 38],
                    ['us-de', 39],
                    ['us-mo', 40],
                    ['us-pa', 41],
                    ['us-nj', 42],
                    ['us-ny', 43],
                    ['us-la', 44],
                    ['us-nh', 45],
                    ['us-me', 46],
                    ['us-sd', 47],
                    ['us-ct', 48],
                    ['us-il', 49],
                    ['us-in', 50],
                    ['us-ky', 51],
                    ['us-wv', 52],
                    ['us-dc', 53],
                    ['ca-on', 54],
                    ['ca-qc', 55],
                    ['ca-nb', 56],
                    ['ca-ns', 57],
                    ['ca-nl', 58],
                    ['ca-mb', 59],
                    ['us-sc', 60],
                    ['ca-yt', 61],
                    ['ca-pe', 62],
                    ['undefined', 63]
                ];
                //console.log(data)
                //console.log(AssocArray)
                // Create the chart
                Highcharts.mapChart('container', {
                    chart: {
                        map: 'custom/usa-and-canada'
                    },

                    title: {
                        text: ''
                    },

                    subtitle: {
                        text: ''
                    },

                    mapNavigation: {
                        enabled: true,
                        buttonOptions: {
                            verticalAlign: 'bottom'
                        }
                    },

                    series: [{
                        data: AssocArray1,
                        name: 'UNITED STATES AND CANADA',
                        borderColor: 'black',

                        states: {
                            hover: {
                                color: '#BADA55'
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}',
                            style: {
                               fontWeight: 'normal',
                            },
                            //color:'red'
                        }
                    }]
                });


                }
             
                   
              }
         
        }
      }); 




});
 </script>
 <script src="<?php echo SITEURL; ?>app/admin/dist/map/js/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/usa-and-canada.js"></script>
