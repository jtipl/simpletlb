<?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Loads Reports");
?>
 
<div class="my-3 my-md-5">
  <div class="container">
   <!--  <div class="page-header">
          <h1 class="page-title">
                <i class="fe fe-file"></i> Loads Reports

              </h1> 
            </div> -->
             <div class="my-3 my-md-5">
          <div class="container animated fadeIn">
            <div class="page-header">
              <i class="icon-Report"></i>&nbsp;
          <h1 class="page-title">
                 Loads Reports
              </h1> 
            </div>   

    <div class="row animated fadeIn ">
    
    <div class="col-md-12 accordion" id="accordionExample">
<div class="lb-tabs">
  <nav>
    <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">

 <a class="nav-item nav-link  active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> 
          Search by loads</a>
    
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> 
       Search by truckers</a>  
     
    </div>
  </nav>
  <div class="tab-content " id="nav-tabContent">
    <div class="tab-pane animated  fadeIn  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="table-responsive"> 
<div class="row   row-deck">             
      <div class="col-md-12 col-sm-12">

        <div class="accordion animated headShake" id="accordionExample">
        
          <div class="">

           
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <form class="" id="search_loads" method="post" autocomplete="off">
                <div class="card-body animated fadeIn">
                  <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Load-Id
                         
                        </label>
                       <div class="input-icon mb-3">
                          <input type="text" class="form-control" name="loadid" placeholder="Load-Id" id="loadid">
                        </div>
                      </div>  
                    </div>   

                        <div class="col-sm-6 col-md-3">
                          <div class="form-group">
                            <label class="form-label">Origin 
                             
                            </label>
                            <input type="text" id="autocomplete_search_orgin" name="autocomplete_search_orgin" class="form-control" placeholder="Origin"  >
                            <label class="error search_origin" style="display: none;" >Please select the origin
                            </label>
                          </div>
                        </div>
                       
                        <div class="col-sm-6 col-md-3">
                          <div class="form-group">
                            <label class="form-label">Destination 
                           
                            </label>
                            <input type="text" id="autocomplete_search_destin" name="autocomplete_search_destin" class="form-control" placeholder="Destination">
                          </div>
                        </div>  

                     <div class="col-sm-6 col-md-3">  
                      <div class="form-group">
                    <label class="form-label">Load Status
                         
                        </label>
                       <div class="input-icon mb-3 ms">
                        <select id="load_status"  multiple="multiple" class="form-control "   >
                        <option value="0">Open</option>
                           <option value="1">Awaiting approval</option>
                           <option value="2">Load approved for pickup</option>
                           <option value="3">Load Picked by trucker</option>
                           <option value="4">Delivered</option>
                           <option value="5">Re-Opened</option>
                      </select>

                        </div>
                      </div>  
                    </div> 

                  </div>
 <div class="row">
 <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Date Type                       
                        </label>
                     <select id="datetype" class="form-control">
                       <option value="">Select Datetype</option>
                       <option value="created_date">Created Date</option>
                       <option value="pickup_date">Pickup Date</option>
                       <option value="delivery_date">Delivery Date</option>
                     </select>

                      </div>  
                    </div> 
                    <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">From Date
                         
                        </label>
                       <div class="input-icon mb-3">
                          <input type="text" name="field-name"  id="from_date" name="from_date" class="form-control startdate" data-mask="00/00/0000" data-mask-clearifnotmatch="true" placeholder="MM/DD/YYYY" />
                          <span class="input-icon-addon">
                            <i class="fe fe-calendar">
                            </i>
                          </span>
                        </div>
                      </div>  
                    </div>     
                    
                     <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">To Date
                         
                        </label>
                       <div class="input-icon mb-3">
                          <input type="text" name="field-name"  id="to_date" name="to_date" class="form-control enddate" data-mask="00/00/0000" data-mask-clearifnotmatch="true" placeholder="MM/DD/YYYY" />
                          <span class="input-icon-addon">
                            <i class="fe fe-calendar">
                            </i>
                          </span>
                        </div>
                            <label class="error datecheck" style="display: none;">From date should be less than to date</label>

                      </div>  
                    </div>                  



                     
                     <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                    <label class="form-label">Equipment
                         
                        </label>
                       <div class="input-icon mb-3 ms">
                        <select id="multiple-checkboxes"  multiple="multiple" class="form-control "   >
                       
                      </select>

                        </div>
                      </div>  
                    </div>     
                       

 <div class="col-sm-6 col-md-6 col-lg-3">
                          <div class="form-group">
                            <label class="form-label">Price 
                            </label>
                            <div class="input-icon mb-3">
                            <input type="text" id="price" name="price" class="form-control">
                             <span class="input-icon-addon">
                               $ 
                            </span>
                          </div>

                          </div>
                        </div>  
 

 <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Weight </label>
                       <div class="input-icon mb-3">
                            <input type="text" name="weight" id="weight" class="form-control"   />
                            <span class="input-icon-addon">
                               lbs 
                            </span>
                          </div>
                      </div>  
                  </div>    
                    <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Length </label>
                       <div class="input-icon mb-3">
                            <input type="text" name="length" id="length" class="form-control"   />
                            <span class="input-icon-addon">
                               ft 
                            </span>
                          </div>
                      </div>  
                  </div>       
                         <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Height </label>
                       <div class="input-icon mb-3">

                            <input type="text" name="height" id="height" class="form-control"   />
                            <span class="input-icon-addon">
                               ft 
                            </span>
                          </div>
                      </div>  
                  </div>   

                      
                  </div>



                  <div class="row" style="float: right;">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group ">   
                        <div class="form-group">
                        
                          <button type="submit" class="btn btn-primary ">
                            <i class="fe fe-search mr-2">
                            </i>Search
                          </button>     
                          <button type="reset" class="btn btn-primary" id="clear_search" >
                            <i class="fe fe-x mr-2">
                            </i>Clear
                          </button>     
                        </div>
                      </div>
                    </div>     
                  </div>
                </div>             
              </form> 
            </div>
          </div>  
        </div>
      </div>  
    </div>
                       
                  </div>
   
   </div>
    
  
  <div class="tab-pane  animated  fadeIn" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
   <div class="table-responsive"> 
                  <div class="row   row-deck">             
      <div class="col-md-12 col-sm-12">

        <div class="accordion animated headShake" id="accordionExample">
        
          <div class="">

           
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <form class="" id="trucker_search_loads" method="post" autocomplete="off">
                <div class="card-body animated fadeIn">
                  <div class="row">
                    <div class="col-sm-6 col-md-3">
                          <div class="form-group">
                            <label class="form-label">Trucker Name 
                             
                            </label>
                            <input type="text" id="trucker_name" name="trucker_name" class="form-control" placeholder="Trucker Name"  >
                           
                          </div>
                        </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Load-Id
                         
                        </label>
                       <div class="input-icon mb-3">
                        <select class="select2"></select>
                      <!--     <input type="text" class="form-control" name="trucker_loadid" placeholder="Load-Id" id="trucker_loadid"> -->
                        </div>
                      </div>  
                    </div>   

                        
                       
                        <div class="col-sm-6 col-md-3">
                          <div class="form-group">
                            <label class="form-label">Business Name 
                           
                            </label>
                            <input type="text" id="business_name" name="business_name" class="form-control" placeholder="Business Name">
                          </div>
                        </div>  

                        <div class="col-sm-6 col-md-3">
                          <div class="form-group">
                            <label class="form-label">USDOT
                           
                            </label>
                            <input type="text" id="usdot" name="usdot" class="form-control" placeholder="USDOT">
                          </div>
                        </div>  

                     <div class="col-sm-6 col-md-3">  
                      <div class="form-group">
                    <label class="form-label">Trucker Status
                         
                        </label>
                       <div class="input-icon mb-3 ms">

                        <select id="trucker_load_status"  multiple="multiple" class="form-control "   >
                           <option value="1">Confirmed</option>
                           <option value="2">Approved</option>
                           <option value="3">Picked</option>
                           <option value="4">Delivered</option>
                         
                      </select>

                        </div>
                      </div>  
                    </div> 
<div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">Date Type                       
                        </label>
                     <select id="trucker_datetype" class="form-control">
                       <option value="">Select Datetype</option>
                       <option value="created_date">Created Date</option>
                       <option value="pickup_date">Pickup Date</option>
                       <option value="delivery_date">Delivery Date</option>
                     </select>

                      </div>  
                    </div> 
                    <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">From Date
                         
                        </label>
                       <div class="input-icon mb-3">
                          <input type="text" name="field-name"  id="trucker_from_date" name="trucker_from_date" class="form-control startdate" data-mask="00/00/0000" data-mask-clearifnotmatch="true" placeholder="MM/DD/YYYY" />
                          <span class="input-icon-addon">
                            <i class="fe fe-calendar">
                            </i>
                          </span>
                        </div>
                      </div>  
                    </div>     
                    
                     <div class="col-sm-6 col-md-6 col-lg-3">  
                      <div class="form-group">
                        <label class="form-label">To Date
                         
                        </label>
                       <div class="input-icon mb-3">
                          <input type="text" name="field-name"  id="trucker_to_date" name="trucker_to_date" class="form-control enddate" data-mask="00/00/0000" data-mask-clearifnotmatch="true" placeholder="MM/DD/YYYY" />
                          <span class="input-icon-addon">
                            <i class="fe fe-calendar">
                            </i>
                          </span>
                        </div>
                            <label class="error trucker_datecheck" style="display: none;">From date should be less than to date</label>

                      </div>  
                    </div>                  

                  </div>



                  <div class="row" style="float: right;">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group ">   
                        <div class="form-group">
                        
                          <button type="submit" class="btn btn-primary ">
                            <i class="fe fe-search mr-2">
                            </i>Search
                          </button>     
                          <button type="reset" class="btn btn-primary" id="trucker_clear_search" >
                            <i class="fe fe-x mr-2">
                            </i>Clear
                          </button>     
                        </div>
                      </div>
                    </div>     
                  </div>
                </div>             
              </form> 
            </div>
          </div>  
        </div>
      </div>  
    </div>
                 
                  </div>
    
    </div>
  
    
  
  


  </div>
</div>
     
     
</div> 

</div>

</div>
</div>

    
    <div class="row row-deck animated fadeIn">  
         
      <h1 class="dgrid-title  pl-4" style="font-size: 1.5rem;">
        <i class="icon-LoadDetails">
        </i> 
        <span class="dytitle">Loads List</span>
       
       <!--  <span class="tool" data-tip="The list of open loads available for your confirmation that suits your search criteria " tabindex="1" >
          <i class="fa fa-question-circle-o">
          </i>
        </span> -->
      </h1>             
      <div class="col-12">
        <div class="card ">  
          <div class="table-responsive newreports loadsreport"> 
            <h1 class="dgrid-title">&nbsp; 
            </h1> 
            <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
              <thead>
                <tr>
                  
                  <th class="index_sort">
                    <div>Load-Id
                    </div>
                  </th>
                  <th>
                    <div>Origin
                    </div>
                  </th>
                  <th>
                    <div>Destination
                    </div>
                  </th>
                  <th>
                    <div>Pickup Date
                    </div>
                  </th>
                  <th>
                    <div>Delivery Date
                    </div>
                  </th>
                  
                  
                 
                  <th>
                    <div> Status
                    </div> 
                  </th>
                   <th>
                    <div> Trucker Name
                    </div> 
                  </th>
                  <th>
                    <div>Created Date
                    </div>
                  </th>
                 <th>
                    <div>Equipment
                    </div>
                  </th>
                   <th>
                    <div>Price
                    </div>
                  </th>
                     <th>
                    <div>Weight
                    </div>
                  </th>
                
                   <th>
                    <div>Length
                    </div>
                  </th>
                
                   <th>
                    <div>Height
                    </div>
                  </th>
                
                
                  
                
               
                </tr>
              </thead>
            </table>  
                
            

            <input type="hidden" id="total_count" value="" /> 
            <input type="hidden" id="tabsid" value="" />

          </div>
           <div class="export">              
                    <?php require_once "export-page.php"; ?>
                    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- </div> -->
<!-- Modal -->
<?php $Global->Footer(); ?>
<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-datepicker.css">

