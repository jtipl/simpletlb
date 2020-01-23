<?php 
   require_once("../../elements/Global.php");
   $Global=new LoadBoard();
   $Global->AfterloginCheck();
   $Global->Header("SimpleTLB - Search Loads");
   $re_open_view_encode = isset($_REQUEST["re_open_view_encode"]) ? $_REQUEST['re_open_view_encode']: '';
   $re_open_decode = $Global->decode($re_open_view_encode);
   
   $new_load_encode = isset($_REQUEST["nl"]) ? $_REQUEST['nl']: '';
   $new_load_decode = $Global->decode($new_load_encode);
   $user_id = isset($_SESSION["user_id"]) ? $_SESSION['user_id']: '';
   
   $count_data=$Global->db->prepare("SELECT COUNT(*) AS total FROM search_save WHERE user_id=:user_id AND status=1");
   $count_data->execute(array("user_id"=>$user_id));
   $count_dataser=$count_data->fetch(PDO::FETCH_ASSOC);
?>
<input type="hidden" id="re_open_decode" value="<?php echo $re_open_decode; ?>" />
<div class="my-3 my-md-5">
   <div class="container">
      <div class="row   row-deck">
         <div class="col-md-12 col-sm-12">
            <div class="accordion animated headShake" id="accordionExample">
               <div class="card">
                  <div class="card-header sub " id="headingOne">
                     <!--<h2 class="mb-0 ">
                        <button type="button" class="btn btn-link btn-block" data-toggle="collapse" data-tarcount="#collapseOne"><i class="fe fe-search"></i> Search Loads</button>           
                         <i class="fe fe-search"></i> Search Loads      
                        </h2>-->
                     <h1 class="page-title pl-4 recloads"  style="padding-left: 0px !important">
                        <i class="icon-SearchLoad"></i> Search Loads
                     </h1>
                     <?php if($count_dataser['total'] != 0){ ?>
                     <ul class="gets_search">
                        
                        <li class="dropdown load-top pull-right">
                         <!--   <a href="javascript:void(0);" id="search_saves_drop" class=" search_saves_list pull-right">
                           Save Search<i class="fe fe-chevron-down"></i></a>
                           <ul class="dropdown-menu" id="menu">
                           </ul> -->

                           <div class="dropdown">
  <a href="javascript;void(0);" class="search_saves_list pull-right dropdown-toggle" id="search_saves_drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Saved Search
  </a>
  <div class="dropdown-menu" id="menu" aria-labelledby="dropdownMenuButton">
    <!-- <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a> -->
  </div>
</div>



                        </li>
                        <a href="javascript:void(0);" class="recent_loads marbdr1 pull-right">
                        Recently Viewed Loads</a>
                        <a href="javascript:void(0);" class="wish_loads marbdr1 pull-right">
                        Wish List </a>
                     </ul>
                     <?php }else{?>
                     <ul>
                        <a href="javascript:void(0);" class="recent_loads  pull-right">
                        Recently Viewed Loads</a>
                        <a href="javascript:void(0);" class="wish_loads  marbdr1 pull-right">
                        Wish List </a>
                     </ul>
                     <?php }?>
                  </div>
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                     <form class="" id="search_loads" method="post" autocomplete="off">
                        <div class="card-body animated fadeIn">
                           <div class="row">
                              <div class="col-sm-12 col-md-8">
                                 <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                       <div class="form-group">
                                          <label class="form-label">Origin <span class="tool" style="font-weight: normal;" data-tip="The starting point or location of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                          <input type="text" id="autocomplete_search_orgin" name="autocomplete_search_orgin" class="form-control" placeholder="Origin"  >
                                          <label class="error search_origin" style="display: none;" >Please select the origin</label>
                                          <input type="hidden" id="orgin_lat"   name="orgin_lat" value="">
                                          <input type="hidden" id="orgin_lng"   name="orgin_lng" value="">
                                          <input type="hidden" id="orgin_state" value="" name="origin_state" />
                                          <input type="hidden" id="destination_state" value="" name="destination_state" />
                                          <input type="hidden" id="destination_lat"   name="destination_lat" value="">
                                          <input type="hidden" id="destination_lng"   name="destination_lng" value="">
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                       <div class="form-group">
                                          <label class="form-label">Deadhead <span class="tool" style="font-weight: normal;" data-tip="The maximum search distance towards Origin with empty truck" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                          <input type="text" name="deadhead" id="deadhead"  value="" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control" placeholder="Miles">
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                       <div class="form-group">
                                          <label class="form-label">Destination <span class="tool" style="font-weight: normal;" data-tip="The delivery point or location of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                          <input type="text" id="autocomplete_search_destin" name="autocomplete_search_destin" class="form-control" placeholder="Destination">
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                       <div class="form-group">
                                          <label class="form-label">Deadhead <span class="tool" style="font-weight: normal;" data-tip="The maximum search distance for loads around the delivery point" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                          <input type="text" name="des_deadhead" id="des_deadhead" value="" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control" placeholder="Miles">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-3">
                                 <div class="form-group">
                                    <label class="form-label">Pickup Date</label>
                                    <div class="input-icon mb-3">
                                       <input type="text" name="field-name"  id="pickup_date" name="pickup_date" class="form-control" data-mask="00/00/0000" data-mask-clearifnotmatch="true" placeholder="MM/DD/YYYY" />
                                       <span class="input-icon-addon">
                                       <i class="fe fe-calendar"></i>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <!--  <div class="col-sm-6 col-md-6 col-lg-3">
                                 <div class="form-group ">   
                                 <label class="form-label">Truck Load</label>                    
                                       <div class="selectgroup w-100">
                                 
                                         <label class="selectgroup-item">
                                           <input type="radio" name="truck_load_type" value="FTL" class="selectgroup-input truck_load_type" >
                                           <span class="selectgroup-button">FTL</span>
                                         </label>
                                         <label class="selectgroup-item">
                                           <input type="radio" name="truck_load_type" value="LTL" class="selectgroup-input truck_load_type" disabled>
                                           <span class="selectgroup-button">LTL</span>
                                         </label>                          
                                       </div>
                                     </div>
                                  </div>      -->            
                              <div class="col-sm-6 col-md-6 col-lg-2">
                                 <div class="form-group">
                                    <label class="form-label">Max Weight <span class="tool" style="font-weight: normal;" data-tip="The maximum weight of the load that suits you" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                    <div class="input-icon mb-3">
                                       <input type="text" name="weight"  maxlength="6" id="weight" class="form-control"   />
                                       <span class="input-icon-addon">
                                       lbs 
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-6">
                                 <div class="form-group">
                                    <div class="form-label">Equipment <span class="tool" style="font-weight: normal;" data-tip="The vehicle type for which you are looking for load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></div>
                                    <div class=" pt-1">
                                       <?php 
                                          $equipment_types=$Global->equipment_type();
                                          if(!empty($equipment_types)){ 
                                            foreach ($equipment_types as $key => $types) {
                                            ?>
                                       <label class="custom-control custom-checkbox custom-control-inline ">
                                       <input type="checkbox" class="custom-control-input" name="truck_type[]" value="<?php echo $types['id']; ?>">
                                       <span class="custom-control-label"><?php echo $types['truck_name']; ?></span>
                                       </label>
                                       <?php } } ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-4">
                                 <div class="form-group ">
                                    <div class="form-group">
                                       <label class="form-label">&nbsp;</label>
                                       <button type="submit" class="btn btn-primary  " id="triggersub"><i class="fe fe-search mr-2"></i>Search</button>
                                       <button type="button" style="display:none;" class="btn btn-primary show_btn" id="save_search" ><i class="fe fe-save mr-2"></i>Save Search</button>
                                       <button type="reset" class="btn btn-primary" id="clear_search" ><i class="fe fe-x mr-2"></i>Clear</button>      
                                    </div>
                                 </div>
                              </div>
                              <!--  <div class="form-group">
                                 <label class="form-label">Equipment</label>
                                 <div class="selectgroup w-100">
                                   <label class="selectgroup-item">
                                     <input type="radio" name="Equipment" value="50" class="selectgroup-input" checked="">
                                     <span class="selectgroup-button">Flatbed</span>
                                   </label>
                                   <label class="selectgroup-item">
                                     <input type="radio" name="Equipment" value="100" class="selectgroup-input">
                                     <span class="selectgroup-button">Van</span>
                                   </label>
                                   <label class="selectgroup-item">
                                     <input type="radio" name="Equipment" value="150" class="selectgroup-input">
                                     <span class="selectgroup-button">Reefer</span>
                                   </label>
                                   <label class="selectgroup-item">
                                     <input type="radio" name="Equipment" value="200" class="selectgroup-input">
                                     <span class="selectgroup-button">Stepdeck</span>
                                   </label>
                                   <label class="selectgroup-item">
                                     <input type="radio" name="Equipment" value="250" class="selectgroup-input">
                                     <span class="selectgroup-button">Power </span>
                                   </label>
                                 </div>
                                 </div> -->
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row row-deck animated fadeIn">
         <h1 class="dgrid-title pl-4">
            <i class="icon-LoadDetails"></i> <span class="dytitle_ch">Available Loads</span> 
            <span class="tool dytitle_head" data-tip="The list of open loads available for your confirmation that suits your search criteria " tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
         </h1>
         <div class="col-12">
            <div class="card ">
               <div class="table-responsive">
                  <h1 class="dgrid-title">&nbsp;&nbsp;&nbsp;&nbsp;</h1>
                  <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th></th>
                           <th class="index_sort">
                              <div>Load-Id</div>
                           </th>
                           <th>
                              <div>Origin</div>
                           </th>
                           <th>
                              <div>Destination</div>
                           </th>
                           <!--  <th><div>Weight</div></th>
                              <th><div>Length</div></th> -->
                           <th>
                              <div>Pickup Date</div>
                           </th>
                           <th>
                              <div>Delivery Date</div>
                           </th>
                           <th>
                              <div> Equipment</div>
                           </th>
                           <th>
                              <div>Broker/Shipper</div>
                           </th>
                           <!--   <th>PickUp Date</th> -->
                           <th>
                              <div>Price</div>
                           </th>
                             <th>
                              <div>Status</div>
                           </th>
                           <!--  <th>Action</th> -->
                           <!--    <th><div>Age</div></th> -->
                           <!--    <th>Type</th>
                              <th>TruckId</th> -->
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- </div> -->
<!-- Modal -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header text-center">
            <h5 class="modal-title " id="mySmallModalLabel">Confirm Your Load</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
            </button>
         </div>
         <div class="modal-body cancel-trip">
            <div class="row  ">
               <div class="col-md-12  ">
                  <div class=" mapview table-responsive"></div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="row d-flex ">
                     <div class="col-sm-5 col-md-5">
                        <h3 id="m_origin"  >Houston, TX</h3>
                        <!--  <address>
                           <small id="m_pdate">Jun 15, 2019</small> 
                           </address>      -->                                                    
                     </div>
                     <div class="col-sm-1 col-md-1 align-self-center arrow-r">  
                     </div>
                     <div class="col-sm-6 col-md-6">
                        <h3 id="m_destination" >Richmond, VA</h3>
                        <!--   <address>
                           <small id="m_ddate">Jun 17, 2019</small>
                           </address>    -->                                      
                     </div>
                  </div>
                  <div class="row trip mappop ">
                     <h4 class="subtitle">Load Details  <span class="pull-right">Created Date: <span id="created_date">Jun 15, 2019</span></span></h4>
                     <!--   <ul class=" ">
                        <li >
                                      <label> Load-ID </label>
                                     <span class="  load-info  " id="m_loadid">LI-000</span>
                        </li>  
                           <li >
                                      <label> Price</label>
                                     <span class="  load-info doll " id="m_price">100</span>
                        </li>  
                          <li >
                                      <label> Weight </label>
                                     <span class="  lbs load-info " id="m_weight">48k</span>
                        </li>
                          <li >
                                      <label> Length </label>
                                        <span class=" load-info ft   " id="m_length">48ft</span>
                        </li>  
                         <li >
                                <label> Distance </label>
                                     <span class="  load-info km  " id="m_distance">0</span>
                        </li> 
                         <li class="" >
                                      <label> Equipment </label>
                                       <span class="  load-info  " id="m_truck">Flatbed</span>
                        </li>
                        </ul> -->
                     <div class="col-md-4 col-sm-6"><label> Load-ID </label>
                        <span class="  load-info  " id="m_loadid">LI-000</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Price</label>
                        <span class="  load-info doll " id="m_price">100</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Weight </label>
                        <span class="  lbs load-info " id="m_weight">48k</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Length </label>
                        <span class=" load-info ft   " id="m_length">48ft</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Height </label>
                        <span class=" load-info ft   " id="m_height">48ft</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Distance </label>
                        <span class="  load-info km  " id="m_distance">0</span>
                     </div>
                     <div class="col-md-4 col-sm-6"><label> Equipment </label>
                        <span class="  load-info  " id="m_truck">Flatbed</span>
                     </div>
                     <h4 class="subtitle my-3">Pickup & Delivery</h4>
                     <div class="col-md-6 col-sm-6">
                        <ul class=" ">
                           <li >
                              <label> Date </label>
                              <span class="  load-info  " id="m_pdate"></span>
                           </li>
                           <li class="timesearch" style="display: none;" >
                              <label> Time </label>
                              <span class="  time load-info " id="m_ptime">00:00:AM</span>
                           </li>
                        </ul>
                     </div>
                     <div class="col-md-6 col-sm-6">
                        <ul>
                           <li >
                              <label> Date </label>
                              <span class="  load-info  " id="m_ddate"></span>
                           </li>
                           <li class="timesearch" style="display: none;"  >
                              <label> Time </label>
                              <span class=" load-info time   " id="m_dtime">00:00:AM</span>
                           </li>
                        </ul>
                     </div>
                     <h4 class="subtitle my-3">Broker Details</h4>
                     <ul class="">
                        <li class="w-100 "  >
                           <label> Broker </label>
                           <span class="  load-info title " id="m_broker">Super Logistics Logistics Logistics</span>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class=" text-center  p-2">     
               <input type="hidden"  value="" id="search_bid">
               <input type="hidden" value="" id="search_lid">  

               <span class="search_con_update">
              
             </span>

            </div>
         </div>
      </div>
   </div>
</div>
<?php $Global->Footer(); ?>
<!-- Modal -->
<!--
   <div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="load" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
   
       <div class="modal-content">   
    <div class="  text-center"><button type="button" class="close px-xl-3" data-dismiss="modal" aria-label="Close">
           </button>
           <img class=" " src="<?php echo SITEURL; ?>app/assets/images/load.jpg" alt="Your Load">
         </div>
         <div class="modal-body">      
          <div class="row">
             <div class="col-sm-12 col-md-12 text-center">
          <h3 class="display-4 my-4">Awesome! You’ve confirmed this load.</h3>  
   <h3 class="">      
   <label class="load_origin ">Houston, TX </label> <i class="fa fa-long-arrow-right" data-toggle="tooltip" title="" data-original-title="fa fa-long-arrow-right"></i> <label class="load_destination "> Richmond, VA</label>     
   </h3>    
      <p class=" text-center ">
        A Notification is sent to the person who has added this Load. </p>
         <p class=" text-center ">We will keep you informed upon his approval by email.</p>
         <p class=" text-center ">You can find the load details under “My Loads” for further reference.
   
        </p>
   <a href="<?php echo SITEURL; ?>app/trucker/loads" type="button" class="btn btn-success">My Loads</a>     
         </div> 
          </div>  
         </div>
       </div>
     </div>
   </div>
   -->
<div class="modal fade" id="load" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="load" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header   text-center">
            <div class="modal-title" id="mySmallModalLabel">Awaiting Load Approval</div>
            <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close">         
            </button>
         </div>
         <div class="modal-body cancel-trip text-center">
            <img class="" src="<?php echo SITEURL; ?>app/assets/images/load.jpg" alt="Your Load">
            <div class="row d-flex">
               <div class="col-sm-5 col-md-5 text-center">
                  <h3 id="load_origin" class="load_origin"  >Houston, TX</h3>
               </div>
               <div class="col-sm-1 col-md-1 align-self-center arrow-r">  
               </div>
               <div class="col-sm-6 col-md-6 text-center">
                  <h3 id="load_destination" class="load_destination" >Richmond, VA</h3>
               </div>
            </div>
            <hr>
            <p class="text-justify confimpop">Thank you for confirming the load. A Notification mail is sent to the person who has added this Load. We will keep you informed upon his approval by email. </p>
            <p class="text-justify confimpopb">You can find the load details under “My Loads” for further reference.</p>
            <!-- <p class="mb-1">
               A Notification is sent to the person who has added this Load. </p>
               <p class="mb-1">We will keep you informed upon his approval by email.</p>
               <p class="mb-2">You can find the load details under “My Loads” for further reference.
               </p> -->
            <center>
               <a href="<?php echo SITEURL; ?>app/trucker/loads" class="btn btn-primary">My Loads</a>
            </center>
         </div>
      </div>
   </div>
</div>
<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-datepicker.css">
<?php if(!empty($new_load_encode)){ ?>
<script type="text/javascript">
   $(document).ready(function(){
   
     var operation ="<?php echo $new_load_decode; ?>";
    // alert(operation);
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'trucker/notification-count-view',
         dataType: 'json',
         headers: {
                Authorization: "Bearer "+LoadBoard.token
         },
         data: JSON.stringify({
               "user_id":LoadBoard.userid,
               "req":operation
                  
           }),
         contentType: "application/json",
        // data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
         success : function(result){
           if(result.status==1){
             //toastr.success(result.msg);
           } else if(result.status==0){
             //toastr.error(result.msg);
           }
         }
       });
   });
   
   
</script>
<?php } ?>
<?php if(!empty($re_open_view_encode)){ ?>
<script type="text/javascript">
   $(document).ready(function(){
   
     var operation ="<?php echo $re_open_decode; ?>";
     //alert(operation);
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'trucker/notification-count-view',
         dataType: 'json',
         headers: {
                Authorization: "Bearer "+LoadBoard.token
         },
         data: JSON.stringify({
               "user_id":LoadBoard.userid,
               "req":operation
                  
           }),
         contentType: "application/json",
         //data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
         success : function(result){
           if(result.status==1){
             //toastr.success(result.msg);
              
           } else if(result.status==0){
             //toastr.error(result.msg);
           }
         }
       });
   });
   
   
</script>
<?php } ?>
<div class="modal fade  " id="save_search_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
      <div class="modal-header " style="text-align: center;">
            <h5 class="modal-title" id="mySmallModalLabel">Save Your Search</h5>
         <!-- <div class="modal-title" id="mySmallModalLabel">Confirm Trucker</div> -->
         <button type="button" class="close approve_close " data-dismiss="modal" aria-label="Close">         
         </button>
      </div>
        <form class="" id="valid_save_search" method="post" autocomplete="off">
      <div class="modal-body">
         <!--  <div class="avatar avatar-lime avatar-xl  mb-2   animated headShake  ">
            <i class="fe fe-package"  ></i>
            </div> -->
       <!--   <h4>Do you want to save your Search?</h4> -->
         <div class="quoted ">
            <div class="row">
               <div class="col-sm-2 col-md-2">
                  <div class="form-group">
                     <label class="form-label">Name </label>
                  </div>
               </div>
               <div class="col-sm-8 col-md-8">
                  <input type="text" id="search_name" name="search_name" class="form-control" placeholder="">
                  <label id="search_name-error" class="error" for="search_name" style="display: none;text"></label>
               </div>
            </div>
         </div>
            
       

      <div class=" text-right pr-3 pb-3" style="margin-top: 20px;">
            <button type="button" class="btn btn-secondary scancel " data-dismiss="modal">Close</button>

            <button type="submit" class="btn btn-primary sconfirm">Save </button>  
         </div>
      </div>
    </form>
   </div>
</div>
<!-- Modal -->