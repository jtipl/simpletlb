<?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$home="";
$addload="";
$openloads="";
$pastloads="";
$reports="";
if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/dashboard")!=false){
  $home='active';
}
if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/add-load")!=false || strpos($_SERVER['REQUEST_URI'], "/app/shipper/view-bulk")!=false || strpos($_SERVER['REQUEST_URI'], "/app/shipper/bulk-upload")!=false){
  $addload='active';
}
if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/loads")!=false && strpos($_SERVER['REQUEST_URI'], "/app/shipper/loads-report")==false  || strpos($_SERVER['REQUEST_URI'], "/app/shipper/in-progress")!=false){
  $openloads='active';
}
if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/past-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/shipper/expired-loads")!=false){
  $pastloads='active';
}
if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/loads-reports")!=false){
  $reports='active';
}
?>
 <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">           
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<?php echo SITEURL; ?>app/shipper/dashboard" class="nav-link <?php echo $home; ?>"><i class="icon-homeB"></i>&nbsp; Home</a>
                  </li>
                  
                  


                    <li class="nav-item dropdown arrow">
                    <a href="javascript:void(0)" class="nav-link  <?php echo $addload; ?>" data-toggle="dropdown"><i class="icon-TodayLoads"></i>&nbsp; Add Load</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="<?php echo SITEURL; ?>app/shipper/add-load" class="dropdown-item  ">Add Single Load
                        
                      </a>  
                      <a href="<?php echo SITEURL; ?>app/shipper/bulk-upload" class="dropdown-item ">Add Multiple Loads
                         
                      </a>                   
                    </div>
                  </li>



                  <li class="nav-item dropdown arrow">
                    <a href="javascript:void(0)" class="nav-link <?php echo $openloads; ?>" data-toggle="dropdown">
                      <!--<i class="fe fe-truck"></i>--><i class="icon-Truck"></i>&nbsp; Present Loads</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="<?php echo SITEURL; ?>app/shipper/loads" class="dropdown-item    ">Open Loads
                       </a>
                      <a href="<?php echo SITEURL; ?>app/shipper/in-progress" class="dropdown-item    ">Picked Loads
                       
                      </a>  
                                       
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo SITEURL; ?>app/shipper/past-loads" class="nav-link <?php echo $pastloads; ?>"> <!--<i class="fa fa-history"></i>--><i class="icon-PastLoad"></i> &nbsp;&nbsp; Past Loads</a>
                  </li>
                  


                    <li class="nav-item dropdown arrow">
                    <a href="javascript:void(0)" class="nav-link <?php echo $reports; ?>" data-toggle="dropdown"><i class="icon-Report"></i>&nbsp; Reports</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="<?php echo SITEURL; ?>app/shipper/loads-reports" class="dropdown-item    ">Loads Reports
                       </a>
                      
                                       
                    </div>
                  </li>



                </ul>
              </div>
            </div>
          </div>
        </div>
