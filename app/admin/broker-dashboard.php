  <?php
  require_once("../../elements/Global.php");
  $Global=new LoadBoard();
$Global->AfterAdminloginCheck();
  
  $Global->admin_header("SimpleTLB - Broker Dashboard");
  ?>

  <style type="text/css">
    .jvectormap-container{
      background: #fff !important;
    }
  </style>
  <!-- Main Content -->
  <div class="page-wrapper">
      <div class="container-fluid pt-30">
        <!-- Row -->
         <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Broker Dashboard - <span class="broker_name">vk</span></h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="javascript:void(0);"><span>Broker Management</span></a></li>
            <li class=""><a href="javascript:void(0);"><span>Broker List</span></a></li>
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
                            <span class="txt-dark block counter total_loads"><span class="Postgres Credential">00</span></span>
                            <span class="capitalize-font block">Total Loads</span>
                          </div>
                         <!--  <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class="icon-direction  data-right-rep-icon txt-primary"></i>
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
                            <span class="txt-dark block counter awaiting_count"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Awaiting Approval</span>
                          </div>
                        <!--   <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
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
                            <span class="txt-dark block counter pickup_count"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Ready for Pickup</span>
                          </div>
                         <!--  <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
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
                            <span class="txt-dark block counter delivery_count"><span class="counter-anim">00</span></span>
                            <span class="capitalize-font block">Delivered Loads</span>
                          </div>
                       <!--    <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                            <i class=" icon-close data-right-rep-icon txt-danger"></i>
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
                     
  <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">OPEN</span>
                  </div>
                                    <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-blue mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">APPROVAL</span>
                  </div>  
                   <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-orange mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">PICKED</span>
                  </div>                
                  <div class="mb-5">
                     <span class="clabels circular-clabels inline-block bg-green mr-5"></span>
                     <span class="clabels-text font-12 inline-block txt-dark capitalize-font">DELIVERED</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
    <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div>
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      OPEN LOADS
                    </span>
                    <span class="label label-warning pull-right" id="pending_perc">50%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      AWAITING APPROVAL
                    </span>
                    <span class="label label-warning pull-right" id="approval_perc">10%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      PICKED LOADS
                    </span>
                    <span class="label label-warning pull-right" id="picked_perc">30%</span>
                    <div class="clearfix"></div>
                    <hr class="light-grey-hr row mt-10 mb-10">
                    <span class="pull-left inline-block capitalize-font txt-dark">
                      DELIVERED LOADS
                    </span>
                    <span class="label label-warning pull-right" id="delivery_perc">10%</span>
                    <div class="clearfix"></div>
                  </div>
                </div>  
              </div>
   </div>
</div> -->
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
                    <h6 class="panel-title txt-dark">Open Loads</h6>
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
                        <table id="openloads" class="table table-hover mb-0">
                          <thead>
                            <tr>
                              <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                              <th>Pickupdate</th>
<!--                               <th>Status</th>
 -->                              <th>Price</th>
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
                    <h6 class="panel-title txt-dark">Expiring Loads (Nearing Pickup Date)</h6>
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
                        <table id="expiring" class="table table-hover mb-0">
                          <thead>
                           <tr>
                              <th>Load-Id</th>
                              <th>Origin</th>
                              <th>Destniation</th>
                              <th>Pickupdate</th>
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
                            <table class="table table-hover mb-0" id="awaiting">
                              <thead>
                                <tr>
                                 <th>Load-Id</th>
                                  <th>Origin</th>
                                  <th>Destniation</th>
                                  <th>Pickupdate</th>
                                
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
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                      <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                      <div class="pull-left">
                        <h6 class="panel-title txt-dark">Ready for Pickup</h6>
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
                            <table class="table table-hover mb-0" id="ready_pickup">
                              <thead>
                                <tr>
                                  <th>Load-Id</th>
                                  <th>Origin</th>
                                  <th>Destniation</th>
                                  <th>Pickupdate</th>
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
                              <table class="table table-hover mb-0" id="picked">
                                <thead>
                                  <tr>
                                   <th>LOAD-ID</th>
                                    <th>ORIGIN</th>
                                    <th>DESTNIATION</th>
                                    <th>TRUCKER NAME</th>
                                   <!--  <th>PHONE</th> -->
                                  <!--   <th>USDOT</th> -->
                                  </tr>
                                </thead>
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
                              <table class="table table-hover mb-0" id="awa_viewloads">
                                <thead>
                                  <tr>
                                   <th>LOAD-ID</th>
                                    <th>ORIGIN</th>
                                    <th>DESTNIATION</th>
                                    <th>TRUCKER NAME</th>
                                   <!--  <th>PHONE</th> -->
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
                        <h6 class="panel-title txt-dark">Expired Loads (Went Past Pickup Date)</h6>
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
                            <table class="table table-hover mb-0" id="expired_viewloads">
                              <thead>
                                <tr>
                                 <th>LOAD-ID</th>
                                  <th>ORIGIN</th>
                                  <th>DESTNIATION</th>
                                  <th>PICKED DATE</th>
                                 <!--  <th>STATUS</th> -->
                                  <th>PRICE</th>
                                </tr>
                              </thead>
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
                            <table class="table table-hover mb-0" id="cancel_viewloads">
                              <thead>
                                <tr>
                                 <th>LOAD-ID</th>
                                  <th>ORIGIN</th>
                                  <th>DESTNIATION</th>
                                  <th>TRUCKER NAME</th>
<!--                                   <th>CANCELLED REASON</th>
 -->                                  <th>CANCELLED DATE</th>
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


        
        
       <?php  
      $Global->admin_footer();
        ?>
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;sensor=false"></script>

 <script type="text/javascript">
        var user_id=getUrlParameter('id');
        var pending_per=0;
        var approval_per=0;
        var picked_per=0;
        var delivery_per=0;
        var cancel_per=0;
        var expired_per=0;
        var pen= 0;
        var apprl=  0;
        var pick= 0;
        var deliver= 0;
        var chart_data='';
        var periods = {
  month: 30 * 24 * 60 * 60 * 1000,
  week: 7 * 24 * 60 * 60 * 1000,
  day: 24 * 60 * 60 * 1000,
  hour: 60 * 60 * 1000,
  minute: 60 * 1000
};
function msToTime(s) {
  var ms = s % 1000;
  s = (s - ms) / 1000;
  var secs = s % 60;
  s = (s - secs) / 60;
  var mins = s % 60;
  var hrs = (s - mins) / 60;

  return hrs + ':' + mins + ':' + secs + '.' + ms;
}

function formatTime(timeCreated) {
  var diff = Date.now() - timeCreated;
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
                url:LoadBoard.API+'admin/broker-dashboard',
                dataType: 'json',
                async:false,
                 headers: {
                  Authorization: "Bearer "+LoadBoard.admintoken
                },
              contentType: "application/json",
                data:JSON.stringify({"user_id":user_id}),
                success:function(result){
      
                      if(result.status==2){
                      window.location.href=LoadBoard.APP+"admin/logout";
                      }else if(result.status==1){
                      $(".picked_loads").html(result.data.picked_loads);
                      $(".deliv_loads").html(result.data.delivered_loads);
                      $(".total_loads").html(result.data.total_loads);
                      $(".map_loads").html(result.data.total_loads);
                      $(".cancel_loads").html(result.data.cancel_count);
                      $("#broker_name").html(result.data.broker_name);
                      $("#broker_business_name").html(result.data.business_name);
                      $("#favorites").html(result.data.my_favorite.toFixed(2)+ '%');
                      $("#pen_per").html(result.data.pending_percentage.toFixed(2)+ '%');
                      $("#appr_per").html(result.data.approval_percentage.toFixed(2)+ '%');
                      $("#pick_per").html(result.data.picked_percentage.toFixed(2)+ '%');
                      $("#deliver_per").html(result.data.delivery_percentage.toFixed(2)+ '%');
                      $("#pen").html(result.data.pending_loads+ "  loads");
                      $("#apprl").html(result.data.approval_loads+ "  loads");
                      $("#pick").html(result.data.picked_loads+ "  loads");
                      $("#deliver").html(result.data.delivered_loads+ "  loads");
                      $("#pending_perc").html(result.data.pending_percentage.toFixed(2)+ '%');
                      $("#approval_perc").html(result.data.approval_percentage.toFixed(2)+ '%');
                      $("#picked_perc").html(result.data.picked_percentage.toFixed(2)+ '%');
                      $("#delivery_perc").html(result.data.delivery_percentage.toFixed(2)+ '%');
                      pending_per=result.data.pending_percentage;
                      approval_per=result.data.approval_percentage;
                      picked_per=result.data.picked_percentage;
                      delivery_per=result.data.delivery_percentage;
                      cancel_per=result.data.cancel_percentage;
                      expired_per=result.data.expired_percentage;

                       $(".awaiting_count").html(result.data.approval_loads);
                       $(".pickup_count").html(result.data.approve_pickup);
                       $(".delivery_count").html(result.data.delivered_loads);
                       $(".broker_name").html(result.data.name);


                       pen= result.data.pending_loads;
                       apprl= result.data.approval_loads;
                       pick= result.data.picked_loads;
                       deliver= result.data.delivered_loads;
                       chart_data= result.data.daily_reports;
                        var content="";
                        if(result.data.recent_open!=''){
                          for (var i = 0; i < result.data.recent_open.length; i++) {
                            var convr_time=formatTime(msToTime(new Date(result.data.recent_open[i].confirm_date).valueOf()));
                            
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.recent_open[i].load_id+' - Open Loads</p><div class="clearfix"></div></a>';
                          }

                          for (var i = 0; i < result.data.recent_awaiting.length; i++) {
                              var uconvr_time=formatTime(msToTime(new Date(result.data.recent_awaiting[i].approval_date).valueOf()));
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.recent_awaiting[i].load_id+' - Awaiting Approval</p><div class="clearfix"></div></a>';
                          }

                           for (var i = 0; i < result.data.recent_pickup.length; i++) {
                            var inconvr_time=formatTime(msToTime(new Date(result.data.recent_pickup[i].picked_date).valueOf()));

                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-calendar-check pull-left"></i><p class="pull-left">'+result.data.recent_pickup[i].load_id+' - Ready For Pickup</p><div class="clearfix"></div></a>';
                          }

                            for (var i = 0; i < result.data.recent_delivered.length; i++) {
                               var dconvr_time=formatTime(msToTime(new Date(result.data.recent_delivered[i].delivered_date).valueOf()));
                             content +='<a href="#" class="list-group-item"><span class="badge transparent-badge badge-info capitalize-font"></span><i class="zmdi zmdi-truck pull-left"></i><p class="pull-left">'+result.data.recent_delivered[i].load_id+' - Delivery Loads</p><div class="clearfix"></div></a>';
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
      value: pen,
      name: ''
    }, 
    {
      value: pick,
      name: ''
    },{
      value: apprl,
     name: ''
    },  {
      value: deliver,
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




   table = $('#openloads').DataTable({
         // dom: 'Bfrtip',
       /* buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],*/
            "pageLength": 5,

          "scrollY": 285,
          "scrollX": true,

            "ajax": LoadBoard.API+'broker/view-loads?user_id='+user_id+'&operation=pending',
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
                {"data": "pickup_date"},
                {"data": "price" },
               /* {"data": "status"}*/
            ],
    columnDefs: [/*{
       targets: 4,
       "bSort": false,
       render: function (data,type,row) {
              if (row.status==0) {
                return '<span class="status-icon bg-success "></span>Open for Trucker';
              } else if(row.status==1) {
                return '<span class="status-icon bg-info"></span>Awaiting for your Approval';
              } else if(row.status==2){
                return '<span class="status-icon bg-success"></span>Load Approved for Pickup';
              }else if(row.status==3){
                return '<span class="status-icon bg-info"></span>Load Picked by Trucker';
              } else if(row.status==4){
                return '<span class="status-icon bg-success"></span>Load Delivered by Trucker';
              }  else if(row.status==5){
                return '<span class="status-icon bg-success"></span>Re-opened for Trucker';
              }  else{
                return '';
              }          
          }
      },*/
      {
        targets: 3,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
        targets: 4,
        render: function (data,type,row) {
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
    

         {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      },
      
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    }
     
        });


      table = $('#expiring').DataTable({
         // dom: 'Bfrtip',
       /* buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],*/
            "pageLength": 5,
             "scrollY": 285,
          "scrollX": true,

            "ajax": LoadBoard.API+'broker/view-loads?user_id='+user_id+'&operation=expiring',
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
                {"data": "pickup_date"},
                {"data": "price" },
              //  {"data": "status"}
            ],
    columnDefs: [/*{
       targets: 4,
       "bSort": false,
       render: function (data,type,row) {
              if (row.status==0) {
                return '<span class="status-icon bg-success "></span>Open for Trucker';
              } else if(row.status==1) {
                return '<span class="status-icon bg-info"></span>Awaiting for your Approval';
              } else if(row.status==2){
                return '<span class="status-icon bg-success"></span>Load Approved for Pickup';
              }else if(row.status==3){
                return '<span class="status-icon bg-info"></span>Load Picked by Trucker';
              } else if(row.status==4){
                return '<span class="status-icon bg-success"></span>Load Delivered by Trucker';
              }  else if(row.status==5){
                return '<span class="status-icon bg-success"></span>Re-opened for Trucker';
              }  else{
                return '';
              }          
          }
      },*/
      {
        targets: 3,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
        targets: 4,
        render: function (data,type,row) {
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
    

         {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      },
      
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
       
    }
     
        });


  if($('#chart_1s').length > 0) {
        // Area Chart
      /*  var data=[{
            period: 10,
            loads: 180,
        }
       ];*/
       var data= chart_data;
       


        var areaChart = Morris.Area({
            element: 'chart_1s',
            data: data,
            xkey: 'period',
            ykeys: ['loads'],
            labels: ['loads'],
            pointSize: 3,
            lineWidth: 2,
            grid: false,
            pointStrokeColors:['#00b0ec'],
            pointFillColors:['#ffffff'],
            behaveLikeLine: true,
            smooth: false,
            hideHover: 'auto',
            lineColors: ['#00b0ec'],
            resize: true,
            gridTextColor:'#878787',
            gridTextFamily:"Poppins",
            parseTime: false,
            fillOpacity:0.6
        }); 
        /* Switchery Init*/
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('#morris_switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        var swichMorris = function() {
            if($("#morris_switch").is(":checked")) {
                areaChart.setData(data);
                areaChart.redraw();
            } 
        }
        swichMorris();  
        $(document).on('change', '#morris_switch', function () {
            swichMorris();
        }); 
    }

      $.ajax({
        type:'POST',
        url:LoadBoard.API+'admin/load-state',
        type:"post",
        headers: {
            Authorization: "Bearer "+LoadBoard.admintoken
          },
        contentType: "application/json",
        dataType: 'json',
        async:false,
        data:JSON.stringify({user_id:user_id})  ,
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

   table = $('#awaiting').DataTable({
        //  dom: 'Bfrtip',
        /*buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],*/
            "pageLength": 5,
            "scrollY": 285,
            "scrollX": true,

            "ajax": LoadBoard.API+'broker/view-loads?user_id='+user_id+'&operation=awaiting',
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
                {"data": "pickup_date"},
                {"data": "price" },
               
            ],
    columnDefs: [
      {
        targets: 3,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
        targets: 4,
        render: function (data,type,row) {
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
    

         {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      },
      
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        
    }
     
        });

    table = $('#ready_pickup').DataTable({
         // dom: 'Bfrtip',
       /* buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],*/
            "pageLength": 5,
             "scrollY": 285,
          "scrollX": true,

            "ajax": LoadBoard.API+'broker/view-loads?user_id='+user_id+'&operation=ready_pickup',
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
                {"data": "pickup_date"},
                {"data": "price" },
            ],
    columnDefs: [
      {
        targets: 3,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
        targets: 4,
        render: function (data,type,row) {
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
    

         {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      },
      
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
       
    }
     
        });


   </script>

       


<script type="text/javascript">
    //Array of JSON objects.
    var loadslist="";
    var arrData=[];
   

  table = $('#picked').DataTable({
         // dom: 'Bfrtip',
            "pageLength": 5,
            "scrollY": 285,
            "scrollX": true,
            "ajax": {
            url: LoadBoard.API+'broker/in-progress',
            type:"post",
            headers: {
             Authorization: "Bearer "+LoadBoard.admintoken
            },
            contentType: "application/json",
            "dataFilter": function(data) {
              var inprogress = JSON.parse(data);
              if(inprogress.status==2){
                  window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                return JSON.stringify(inprogress);  
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
                {"data": "name"},
               // {"data": "phone"},
                //{"data": "dot" }
            ],
    columnDefs: [
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
        targets: 4,
        render: function (data,type,row) {
                 return formatPhoneNumber(row.phone);
                    
                    

                }
      },*/{
        targets: 5,
        render: function (data,type,row) {
                 return row.dot;
                }
      },

       {
        targets: 3,
        render: function (data,type,row) {
          
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+Ucfirst(row.name)+'</a>';
                }
      },
      

       /* {
        targets: 0,
         bSortable: false, 
        render: function (data,type,row) {
                return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
      },*/

       {
        targets: 0,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      }
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
     
    }
     
        });

    table = $('#awa_viewloads').DataTable({
         // dom: 'Bfrtip',
           "pageLength": 5,
            "scrollY": 285,
          "scrollX": true,
            "ajax": {
              url: LoadBoard.API+'broker/past-loads',
              type:"post",
              headers: {
               Authorization: "Bearer "+LoadBoard.admintoken
              },
            contentType: "application/json",
            "dataFilter": function(data) {
              var pastloads = JSON.parse(data);
              if(pastloads.status==2){
                  window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                return JSON.stringify(pastloads);  
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
                {"data": "name"},
               // {"data": "phone"},
              //  {"data": "dot" }
            ],
    columnDefs: [
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
    /*  {
        targets: 4,
        render: function (data,type,row) {
                 return formatPhoneNumber(row.phone);
                    
                    

                }
      },*/

       {
        targets: 3,
        render: function (data,type,row) {
         
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+Ucfirst(row.name)+'</a>';
                }
      },
      

       /* {
        targets: 0,
         bSortable: false, 
        render: function (data,type,row) {
                return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
      },*/

       {
        targets: 0,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      }
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        
    }
     
        });

    table = $('#expired_viewloads').DataTable({
         // dom: 'Bfrtip',
            "pageLength": 5,
             "scrollY": 285,
          "scrollX": true,

            "ajax":LoadBoard.API+'broker/view-loads?user_id='+user_id+'&operation=expired_loads',
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
              {"data": "pickup_date"},
            //  {"data": "status"},
              {"data": "price" }
            ],
    columnDefs: [
      /*{
       targets: 4,
       render: function (data,type,row) {
        return '<span class="status-icon bg-red"></span>Expired';
        }
      },*/{
        targets: 3,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
        targets: 4,
        render: function (data,type,row) {
                 return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    
                    

                }
      },

  
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
       
    }
     
        });
   table = $('#cancel_viewloads').DataTable({
            "pageLength": 5,
             "scrollY": 285,
          "scrollX": true,
             "ajax": {
            url: LoadBoard.API+'broker/cancel-loads',
            type:"post",
            headers: {
             Authorization: "Bearer "+LoadBoard.admintoken
            },
            contentType: "application/json",
            "dataFilter": function(data) {
              var cancel_data = JSON.parse(data);
              if(cancel_data.status==2){
                  window.location.href = LoadBoard.APP + "admin/logout";
              }else{
                return JSON.stringify(cancel_data);  
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
                {"data": "name"},
               /* {"data": "cancel_reason" },*/
                {"data": "cancel_date" }
            ],
    columnDefs: [
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
                 //  return jsUcfirst(row.name);
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+Ucfirst(row.name)+'</a>';
                      
                      

                  }
        },
            {
        targets: 5,
        render: function (data,type,row) {
               var date=row.cancel_date;
               dateTime = moment(date).format("MM-DD-YYYY HH:mm:ss");
               return(dateTime);
              
                }
      },

        /*{
        targets: 0,
        render: function (data,type,row) {
                return row.id;
                }
      } */

    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    
     
        });
  
function formatPhoneNumber(phoneNumberString) {
  var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
  var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
  if (match) {
    return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
  }
  return null
} 

function Ucfirst(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
}  


</script>
 <script src="<?php echo SITEURL; ?>app/admin/dist/map/js/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/custom/usa-and-canada.js"></script>
