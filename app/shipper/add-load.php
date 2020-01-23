 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Add Load");
 ?>
 <style type="text/css">
/*::-webkit-input-placeholder { text-align:right; }
input:-moz-placeholder { text-align:right; }

test svn add */
.newaddc{
  margin-right:10px;
  margin-left:10px;
}
 </style>
<div class="my-3 my-md-5">
   <div class="container">
      <div class="page-header">
         <i class="icon-TodayLoads"></i>&nbsp;&nbsp;
         <h1 class="page-title">
            Add Load
         </h1>
         &nbsp;&nbsp;&nbsp;
         <span class="tool toottip" data-tip="Add a new load, to add multiple loads select 'Add Multiple Loads' menu option" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
      </div>
      <div class="row   row-deck">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="page-title">  Add Single Load 
                  </h3>
               </div>
               <form method="post" name="addformload" id="addformload" action="" autocomplete="off">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Origin Address <span class="tool toottip" data-tip="The starting point or location of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                              <input type="text" id="autocomplete_search_orgin" name="origin" class="form-control" placeholder="Origin Address"  >
                              <label id="autocomplete_search_orgin-error" class="error" for="autocomplete_search_orgin" style="display: none;"></label>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                          <div class="form-group">
                             <label class="form-label">Pickup Date</label>
                             <div class="input-icon mb-3">
                                <!-- input-icon -->
                                <input type="text" id="pickup_date" name="pickup_date" class="form-control" placeholder="MM/DD/YYYY" />
                                <span class="input-icon-addon">
                                <i class="fe fe-calendar"></i>
                                </span>
                             </div>
                          </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Pickup Time</label>
                              <div class="input-icon mb-3">
                                 <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                       <select name="pickup_hour" class="form-control" id="pickup_hour">
                                       <?php $i=0;while($i<=12){ if($i==0){$selected='selected=selected';}else{$selected='';} 
                                          echo'<option '.$selected.' value="'.$i.'">'.$i.'</option>'; $i++;}?>
                                       </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                       <select name="pickup_minute" class="form-control" id="pickup_minute">
                                          <option value="00">00</option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                       </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                       <select name="pickup_second" class="form-control" id="pickup_second">
                                          <option value="AM">AM</option>
                                          <option value="PM">PM</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Destination Address <span class="tool toottip" data-tip="The delivery point or location of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                              <input type="text" id="autocomplete_search_destin" name="destination" class="form-control" placeholder="Destination Address">
                              <label id="autocomplete_search_destin-error" class="error" for="autocomplete_search_destin" style="display: none;"></label>
                              <input type="hidden" id="orgin_lat"   name="origin_lat" value="">
                              <input type="hidden" id="orgin_lng"   name="origin_lng" value="">
                              <input type="hidden" id="destination_lat"   name="destination_lat" value="">
                              <input type="hidden" id="destination_lng"   name="destination_lng" value="">
                              <input type="hidden" id="locality" value="" />
                              <input type="hidden" id="administrative_area_level_1" value="" />
                              <input type="hidden" id="country"  value="" />
                              <input type="hidden" id="country_code" value="" />
                              <input type="hidden" id="postal_code" value="" />
                              <input type="hidden" id="orgin_city" name="origin_city" value="" />
                              <input type="hidden" id="orgin_state" value="" name="origin_state" />
                              <input type="hidden" id="orgin_country"  value="" name="origin_country" />
                              <input type="hidden" id="orgin_country_code" value=""  name="origin_country_code" />
                              <input type="hidden" id="orgin_postal" value="" name="origin_postal" />
                              <input type="hidden" id="destination_city" value="" name="destination_city" />
                              <input type="hidden" id="destination_state" value="" name="destination_state" />
                              <input type="hidden" id="destination_country"  value="" name="destination_country" />
                              <input type="hidden" id="destination_country_code" value="" name="destination_country_code" />
                              <input type="hidden" id="destination_postal" value="" name="destination_postal" />
                              <input type="hidden" id="origin_valid" value="" name="origin_valid" />
                              <input type="hidden" id="destination_valid" value="" name="destination_valid" />
                              <input type="hidden" name="app_type" value="web">
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Delivery Date</label>
                              <div class="input-icon mb-3">
                                 <!-- input-icon  -->
                                 <input type="text" id="delivery_date" name="delivery_date" class="form-control" placeholder="MM/DD/YYYY" />
                                 <label id="delivery_date-error" class="error" for="delivery_date" style="display: none;"></label>
                                   <span class="input-icon-addon">
                                <i class="fe fe-calendar"></i>
                                </span>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Delivery Time</label>
                              <div class="input-icon mb-3">
                                 <div class="row">
                                    <div class="col-sm-4 col-md-4">
                                       <select name="delivery_hour" class="form-control" id="delivery_hour">
                                       <?php $i=0;while($i<=12){ if($i==0){$selected='selected=selected';}else{$selected='';} 
                                          echo'<option '.$selected.' value="'.$i.'">'.$i.'</option>'; $i++;}?>
                                       </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                       <select name="delivery_minute" id="delivery_minute" class="form-control">
                                          <option value="00">00</option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                       </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4">
                                       <select name="delivery_second"  class="form-control" id="delivery_second">
                                          <option value="AM">AM</option>
                                          <option value="PM">PM</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Equipment <span class="tool toottip" data-tip="The vehicle type that suits for your load." tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                              <!--   <div id="append_equipment"></div> -->
                              <select class="form-control" id="equipment" name="equipment">
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="row">
                              <div class="col-sm-6 col-md-6">
                                 <div class="form-group">
                                    <label class="form-label">Weight <span class="tool toottip" data-tip="The exact weight of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                    <div class=" mb-3">
                                       <!-- input-icon -->
                                       <input type="text" id="weight" name="weight" placeholder="lbs" maxlength="6" class="form-control"/>
                                       <!--  <span class="input-icon-addon">
                                          lbs 
                                          </span> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                 <div class="form-group">
                                    <label class="form-label">Length <span class="tool toottip" data-tip="The exact length of the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                    <div class="mb-3">
                                       <!-- input-icon  -->
                                       <input type="text" name="length" id="length" maxlength="2" placeholder="ft" class="form-control"/>
                                       <label id="length-error" class="error" for="length" style="display:none;"></label>
                                       <!--   <span class="input-icon-addon">
                                          ft 
                                          </span> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="row">
                              <div class="col-sm-6 col-md-6">
                                 <div class="form-group">
                                    <label class="form-label">Height <span class="tool toottip" data-tip="The exact height of the load." tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                    <input type="text" name="height" id="height" maxlength="3" placeholder="ft" class="form-control"/>
                                    <label id="height-error" class="height" for="height" style="display:none;"></label>
                                 </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                 <div class="form-group">
                                    <label class="form-label">Price <span class="tool toottip" data-tip="Freight charges that you can pay for the load." tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
                                    <input type="text" name="price" id="price" placeholder="$" class="form-control" data-mask="000.000.000.000.000,00" data-mask-reverse="true" />
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group ">
                              <label class="form-label">Truck Load <span class="tool toottip" data-tip="The application supports Full Truck Load (FTL) only for now. Less than Truck Load (LTL) coming soon." tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>                    
                              <div class="selectgroup w-100">
                                 <label class="selectgroup-item">
                                 <input type="radio" name="truck_load_type" value="FTL" class="selectgroup-input" checked="">
                                 <span class="selectgroup-button">FTL</span>
                                 </label>
                                 <label class="selectgroup-item">
                                 <input type="radio" name="truck_load_type" value="LTL" class="selectgroup-input" disabled>
                                 <span class="selectgroup-button">LTL</span>
                                 </label>                          
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                           <div class="form-group">
                              <h3 class="page-title">Load Contact Information</h3>
                           </div>
                        </div>
                         <div class="col-sm-12 col-md-12">
                           <div class="form-group"><a href="JavaScript:void(0);" id="getdetail"><u>Get Contact Detail from My Profile</u></a></div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Name</label>
                              <input type="text" id="shipper_name" name="shipper_name" class="form-control" placeholder="Contact Name">
                              <label id="shipper_name-error" class="shipper_name" for="shipper_name"   style="display:none;"></label>
                           </div>
                        </div>
                        <!-- <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Business Name</label>
                              <input type="text" id="business_name" name="business_name" class="form-control" placeholder="">
                           </div>
                           </div> -->
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Email</label>
                              <input type="text" id="shipper_email" name="shipper_email" class="form-control" placeholder="Contact Email address">
                               <label id="shipper_name-error" class="shipper_email" for="shipper_email" style="display:none;"></label>
                           </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <div class="form-group">
                              <label class="form-label">Phone</label>
                              <input type="text" id="shipper_phone" name="shipper_phone" class="form-control" placeholder="Contact Phone number">
                               <label id="shipper_name-error" class="shipper_phone" for="shipper_phone" style="display:none;"></label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer text-right">
                     <div id="msg"></div>
                     <button type="reset" class="btn btn-secondary"><i class="fe fe-minus-circle mr-2"></i>Cancel</button>
                     <button type="submit" class="btn btn-primary addnewload"><i class="fe fe-plus-circle mr-2"></i>Add Load</button>                 
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div >
      <div id="openloads" class="row row-deck animated fadeIn">
         
        <h1 class="dgrid-title pl-4">
                <i class="fe fe-package"></i> Recently Added Loads
             </h1>   
        <div class="col-12">
            <div class="card "> 
               <div class="table-responsive">
                  <h4 class="dgrid-title">&nbsp; </h4>
                  <table id="viewloads1" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th></th>
                           <th>LOAD ID</th>
                           <th>ORIGIN</th>
                           <th>DESTINATION</th>
                           <th>PICKUP DATE</th>
                           <th>STATUS</th>
                           <th>PRICE</th>
                        </tr>
                     </thead>
                     <tbody id="viewloads_append_row">
                     </tbody>
                  </table>       
               </div>
            </div>
         </div>
      </div>
      
      <!--
       <div id="viewloads_list" class="row row-deck animated fadeIn">         
           <h1 class="dgrid-title pl-4">
                <i class="fe fe-package"></i> Loads List
             </h1>             
              <div class="col-12">
                <div class="card ">  

                  <div class="table-responsive"> 
                     <h1 class="dgrid-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1> 
                    <table id="viewloads" class="viewloads table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                       <thead>
                        <tr>
                           <th></th>
                           <th>LOAD ID</th>
                           <th>ORIGIN</th>
                           <th>DESTINATION</th>
                           <th>PICKUP DATE</th>
                           <th>STATUS</th>
                           <th>PRICE</th>
                        </tr>
                     </thead>
                     
                </table>       
               </div>
            </div>
         </div>
      </div>
      -->
       </div>  


   </div>
</div>
<?php $Global->Footer(); 


?>
<script>
$(document).ready(function(){
   

})

</script>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirm_add_load" tabindex="-1" role="dialog" aria-labelledby="cancel_confirm" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header  text-center">
            <h5 class="modal-title" id="mySmallModalLabel">Confirm Add Load</h5>
            <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body cancel-trip">
            <div class="row">
               <div class="col-md-12 ldetails">
                  <div class="row d-flex ">
                     <div class="col-sm-5 col-md-5">
                        <h3 id="origin_disp">Houston, TX</h3>
                     </div>
                     <div class="col-sm-1 col-md-1 align-self-center arrow-r">
                     </div>
                     <div class="col-sm-6 col-md-6">
                        <h3 id="destination_disp">Richmond, VA</h3>
                     </div>
                  </div>
                  <div class="row   trip mappop ">
                     <h4 class="subtitle">Load Details</h4>
                     <div class="col-md-6  "><label class="">Truck Load </label>
                        <span class="load-info" id="truck_load_type_disp"></span>
                     </div>
                     <div class="col-md-6  "> <label> Distance </label>
                        <span class="  load-info  km " id="distance_disp">0</span>
                     </div>
                     <div class="col-md-6  "><label class="">Price</label>
                        <span class="load-info doll" id="price_disp"></span>
                     </div>
                     <div class="col-md-6  "> <label class="">Weight</label>
                        <span class="load-info lbs" id="weight_disp"></span>
                     </div>
                     <div class="col-md-6  "><label class="">Length</label>
                        <span class="load-info ft" id="length_disp"></span>
                     </div>
                     <div class="col-md-6  "><label class="">Height</label>
                        <span class="load-info ft" id="height_disp"></span>
                     </div>
                     <div class="col-md-6  "> <label class="">Equipment</label>
                        <span class="load-info" id="equipment_disp"></span>
                     </div>
                  </div>
                  <div class="row   trip mappop ">
                     <div class="col-md-6">
                        <h4 class="subtitle">Pickup Date & Time</h4>
                        <ul class=" ">
                           <li>
                              <label> Date </label>
                              <span class="load-info"  id="pickupdate_disp" ></span>
                           </li>
                           <li>
                              <label class="timelabel_pickup"> Time </label>
                              <span class="load-info time" id="pickuptime_disp" class=""></span>
                           </li>
                        </ul>
                     </div>
                     <div class="col-md-6">
                        <h4 class="subtitle">Delivery Date & Time</h4>
                        <ul class=" ">
                           <li>
                              <label> Date </label>
                              <span class="load-info" id="deliverydate_disp" class=""></span>
                           </li>
                           <li>
                              <label class="timelabel_delivery"> Time </label>
                              <span class="load-info time" id="deliverytime_disp" class=""></span>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="row   trip mappop ">
                     <h4 class="subtitle">Contact Details</h4>
                     <div class="col-md-6  "><label class="">Name </label>
                        <span class="load-info" id="cont_name"></span>
                     </div>
                     <div class="col-md-6  "><label class="">Email</label>
                        <span class="load-info " id="cont_email"></span>
                     </div>
                     <!-- <div class="col-md-6  "> <label> Business Name </label>
                        <span class="  load-info   " id="cont__busi_name"></span>
                        </div> -->
                     <div class="col-md-6  "> <label class="">Phone</label>
                        <span class="load-info " id="cont_ph"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer modalfooter">
            <div class=" text-right pr-3 pb-3">
               <button type="button" class="btn btn-primary submitformload">Save </button> 
               <button type="button" class="btn btn-primary save_add_new">Save & Add New </button> 
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
            </div>
         </div>
      </div>
   </div>
</div>
</div>




