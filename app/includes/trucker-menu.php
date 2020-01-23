   <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$loadactive="";
$myloads="";
$upcoming="";
$pastloads="";
$dashboard="";
$reports="";
if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/search-loads")!=false){
  $loadactive='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/awaiting-approval")!=false){
  $myloads='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/upcoming-trips")!=false){
  $myloads='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/in-progress")!=false){
  $myloads='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads")!=false &&  strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads-reports")==false){
  $myloads='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/past-loads")!=false){
  $pastloads='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/dashboard")!=false){
  $dashboard='active';
}if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/cancel-loads")!=false){
  $pastloads='active';
}
if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads-reports")!=false){
  $reports='active';
}
?>
 <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">           
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<?php echo SITEURL; ?>app/trucker/dashboard" class="nav-link  <?php echo $dashboard; ?>"><i class="icon-homeB"></i>&nbsp; Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo SITEURL; ?>app/trucker/search-loads" class="nav-link <?php echo $loadactive; ?>">
                      <!--<i class="fe fe-search"></i>--><i class="icon-SearchLoad"></i>&nbsp; Search Loads</a>                    
                  </li>
                  <li class="nav-item dropdown">
                    <a href="<?php echo SITEURL; ?>app/trucker/loads" class="nav-link <?php echo $myloads; ?> " data-toggle=""><i class="icon-TodayLoads"></i>&nbsp; My Loads</a>
                   <!--  <div class="dropdown-menu dropdown-menu-arrow">
                     <a href="<?php //echo SITEURL; ?>app/trucker/upcoming-trips" class="dropdown-item <?php echo $upcoming; ?>">Upcoming Trips</a>  
                      <a href="<?php //echo SITEURL; ?>app/trucker/in-progress" class="dropdown-item ">In-Progress</a> 
            <a href="<?php //echo SITEURL; ?>app/trucker/awaiting-approval" class="dropdown-item ">Awaiting Approval</a>                   
                    </div> -->
                  </li>
                  <li class="nav-item dropdown">
                    <a href="<?php echo SITEURL; ?>app/trucker/past-loads" class="nav-link <?php echo $pastloads; ?> " data-toggle="">
                      <!--<i class="fa fa-history"></i></i>--> 
                      <i class="icon-PastLoad"></i> &nbsp; &nbsp;Past Loads</a>
                  </li>
                 <!--  <li class="nav-item dropdown">
                    <a href="<?php echo SITEURL; ?>app/trucker/past-loads" class="nav-link <?php echo $pastloads; ?>" ><i class="fe fe-file-text"></i> Past Loads</a>                   
                  </li>     

                    <li class="nav-item dropdown arrow">
                    <a href="javascript:void(0)" class="nav-link <?php echo $pastloads; ?> " data-toggle="dropdown"><i class="fa fa-history"></i>Past Loads</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?php echo SITEURL; ?>app/trucker/past-loads" class="dropdown-item  ?>  ">Delivered Loads</a>  
                      <a href="<?php echo SITEURL; ?>app/trucker/cancel-loads" class="dropdown-item ?> ">Cancelled Loads</a>                   
                    </div>
                  </li>
                -->
  <li class="nav-item dropdown arrow">
                    <a href="javascript:void(0)" class="nav-link <?php echo $reports; ?>" data-toggle="dropdown"><i class="icon-Report"></i>&nbsp; Reports</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="<?php echo SITEURL; ?>app/trucker/loads-reports" class="dropdown-item    ">Loads Reports
                       </a>
                      
                                       
                    </div>
                  </li>

                </ul>
              </div>
            </div>
          </div>
        </div>