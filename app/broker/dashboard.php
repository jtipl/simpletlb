<?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Dashboard");
?>
     <link href="<?php echo SITEURL; ?>app/assets/js/charts-c3/plugin.css" rel="stylesheet" />
        <div class="my-3 my-md-5 dboard">
          <div class="container">
            <div class="page-header">
              <i class="icon-Dashboard"></i>&nbsp;&nbsp;
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards">
          
        <div class="  col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3 icon-stamp">
                     <!-- <i class="fe fe-box"></i>-->
                     <i class="icon-TodayLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 today_loads">00</h4>
                      <small class="text-muted">Today Loads</small>
                    </div>
                  </div>
                </div>
              </div>      
            
      <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-cyan  mr-3 icon-stamp">
                      <!--<i class=" fe fe-truck "></i>-->
                      <i class="icon-PickedLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 picked_loads">00</h4>
                      <small class="text-muted">Picked Loads</small>
                    </div>
                  </div>
                </div>
              </div>  
      
      <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md  bg-green  mr-3 icon-stamp">
                      <!--<i class=" fe fe-thumbs-up "></i>-->
                      <i class="icon-DeliveredLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 deliv_loads">00</h4>
                      <small class="text-muted">Delivered Loads</small>
                    </div>
                  </div>
                </div>
              </div>
      
      <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-orange mr-3 icon-stamp">
                      <!--<i class=" fe fe-x "></i>-->
                      <i class="icon-CancelledLoad"></i>
                    </span>
                    <div>
                      <h4 class="m-0 cancel_loads">00</h4>
                      <small class="text-muted">Cancelled Loads</small>
                    </div>
                  </div>
                </div>
              </div>
        
      <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-danger mr-3 icon-stamp">
                      <!--<i class=" fe fe-clock "></i>-->
                      <i class="icon-ExpiredLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 expire_loads">00</h4>
                      <small class="text-muted">Expired Loads</small>
                    </div>
                  </div>
                </div>
              </div>  
      
      <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-gray-dark mr-3 icon-stamp">
                      <!--<i class=" fe fe-layers "></i>-->
                      <i class="icon-TotalLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 total_loads">00</h4>
                      <small class="text-muted">Total Loads</small>
                    </div>
                  </div> 
                </div>
              </div>  
        
        
         <div class="col-md-4 graph">                
                <div class="row">
                 <div class="col-sm-12">
                    <div class="card dinfo">                     
                      <div class="card-body pl-4 pt-0 line">
                        <h2 class="page-title dashboard-icon">
                        <i class="icon-LoadStatus"></i> Load Status
                      </h2>
<!--       <div id="chart-pie" style="height: 12rem;"></div> -->                        
            <div id="pie"></div>
        <div class="exp"></div>
                      </div>
                    </div>
                   
                  </div>
           </div>
              </div> 
       



       
<div class="col-lg-4">
    
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<div class="card dinfo">
 <div class="card-header">
 <h2 class="page-title">
  <i class="icon-Loads-InProgress"></i>
  <!--<i class="fa fa-exchange  "></i>--> Loads In Progress</h2>  
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>		        
 </div>

    <div class="card-body">         
    <div class="text-center slider-records" style="display: none;">
 </div>

     <div class="dsh-progress slider_div " style="display: none;">
    <div class=" truck-bg ">
    <i class="fe fe-truck "></i>
    </div>
    </div> 
 
    <div class="slider_div" style="display: none;">
   <div class="carousel-inner load_details myiprogress">
 <!--    <div class="carousel-item active">
  <h5><a href="#" > NY-WA-00051</a> </h5>
     <ul class="">
  <li><b>Price </b><span class="to_price">1,000</span></li>
  <li><b>Origin </b><span class="top_origin">New York, NY</span></li>
  <li><b>Destination </b><span class="top_destination">SeaTac, WA</span></li>
  </ul>
    </div>
    <div class="carousel-item">
  <h5><a href="#" > OY-A-00061</a> </h5>
    <ul class="">
  <li><b>Price </b><span class="to_price">2,000</span></li>
  <li><b>Origin </b><span class="top_origin">New York, NY</span></li>
  <li><b>Destination </b><span class="top_destination">SeaTac, WA</span></li>
  </ul>
    </div>
    <div class="carousel-item">
  <h5><a href="#" > PY-YA-00071</a> </h5>
    <ul class="">
  <li><b>Price </b><span class="to_price">3,000</span></li>
  <li><b>Origin </b><span class="top_origin">New York, NY</span></li>
  <li><b>Destination </b><span class="top_destination">SeaTac, WA</span></li>
  </ul>
    </div> -->
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>  
</div>



  </div>

 </div>

</div>
    
          <!--     <div class="card dinfo">
                 <div class="card-header">
                    <h2 class="page-title"><i class="fa fa-exchange  "></i> Loads In Progress</h2>                  
                  </div>
                  <div class="card-body">
          <div class="dsh-progress">
          <div class=" truck-bg ">
          <i class="fe fe-truck "></i>
        </div>          
                    <h5><a href="#" > NY-WA-00051</a> </h5>
          </div>
          <div class="load_details">  
          <ul class="">
          <li><b>Price </b><span class="to_price">2,000</span></li>
          <li><b>Origin </b><span class="top_origin">New York, NY</span></li>
          <li><b>Destination </b><span class="top_destination">SeaTac, WA</span></li>
          </ul>
          </div>
                  </div>
                </div>  -->
       
              </div>
 
             <!--  <div class="col-lg-6">
                <div class="card">
                  
                 <div class="card-header">
                    <h1 class="page-title">  Today Loads </h1>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="today_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
                <script>
                  require(['c3', 'jquery'], function(c3, $) {
                    $(document).ready(function(){
                      var chart = c3.generate({
                        bindto: '#chart-development-activity', // id of chart wrapper
                        data: {
                          columns: [
                              // each columns data
                            ['data1', 0, 5, 1, 2, 7, 5, 6, 8, 24, 7, 12, 5, 6, 3, 2, 2, 6, 30, 10, 10, 15, 14, 47, 65, 55]
                          ],
                          type: 'area', // default type of chart
                          groups: [
                            [ 'data1', 'data2', 'data3']
                          ],
                          colors: {
                            'data1': tabler.colors["blue"]
                          },
                          names: {
                              // name of each serie
                            'data1': 'Purchases'
                          }
                        },
                        axis: {
                          y: {
                            padding: {
                              bottom: 0,
                            },
                            show: false,
                              tick: {
                              outer: false
                            }
                          },
                          x: {
                            padding: {
                              left: 0,
                              right: 0
                            },
                            show: false
                          }
                        },
                        legend: {
                          position: 'inset',
                          padding: 0,
                          inset: {
                                      anchor: 'top-left',
                            x: 20,
                            y: 8,
                            step: 10
                          }
                        },
                        tooltip: {
                          format: {
                            title: function (x) {
                              return '';
                            }
                          }
                        },
                        padding: {
                          bottom: 0,
                          left: -1,
                          right: -1
                        },
                        point: {
                          show: false
                        }
                      });
                    });
                  });
                </script>
              </div> -->

            
                 <!--  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body text-center">
                        <div class="h5">New feedback</div>
                        <div class="display-4 font-weight-bold mb-4">62</div>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-red" style="width: 28%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body text-center">
                        <div class="h5">Today profit</div>
                        <div class="display-4 font-weight-bold mb-4">$652</div>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-green" style="width: 84%"></div>
                        </div>
                      </div>
                    </div>
                  </div> -->
               
        
         <div class="col-md-4 graph">                
                <div class="row">
                <div class="col-sm-12">
                    
                    <div class="card dinfo">   
                      <div class="card-body pl-4 pt-0 line">
                        <h2 class="page-title dashboard-icon">
                        <i class="icon-MissedLoad"></i> Missed Loads
                      </h2> 
<!--             <div id="chart-pie" style="height: 12rem;"></div> --> 
        <div id="pie_wait"></div>
          <div class="exp"></div>
                      </div>
                    </div>                   
                  </div>
         </div>
              </div>
        
          <div class="col-lg-6">
                <div class="card dinfo">
                 <div class="card-header">
                    <h1 class="page-title "> 
                      <i class="icon-LoadListing"></i> <!--<i class=" fe fe-truck "></i>-->  Recent Loads&nbsp;</h1>
                    <span class="tool toottip" data-tip="The list of loads that you have recently added " tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="recent_loads">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div>
        
  <div class="col-lg-6">
                <div class="card dinfo">
                 <div class="card-header">
                    <h1 class="page-title"> 
                      <i class="icon-heading-AwaitingApprov"></i>
                      <!--<i class="fe fe-box  "></i>--> 
                      Awaiting Approval&nbsp;
                    </h1>
                    <span class="tool toottip" data-tip="List of loads that are confirmed by Trucker(s) and awaiting your approval" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="awaiting_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div>
                        
                 <!--  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body text-center">
                        <div class="h5">New feedback</div>
                        <div class="display-4 font-weight-bold mb-4">62</div>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-red" style="width: 28%"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-body text-center">
                        <div class="h5">Today profit</div>
                        <div class="display-4 font-weight-bold mb-4">$652</div>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-green" style="width: 84%"></div>
                        </div>
                      </div>
                    </div>
                  </div> -->
             
        
  <!--   Cancelled Loads comment by jay //      
               <div class="col-lg-6">
                <div class="card dinfo">
                  
                 <div class="card-header">
                    <h2 class="page-title"><i class="fe fe-x "></i>  Cancelled Loads</h2>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="cancel_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div> -->
        
<!--   Expired Loads comment by jay // 
        <div class="col-lg-6">
                <div class="card">
                  
                 <div class="card-header">
                    <h1 class="page-title">Expired Loads</h1>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="expired_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>               
              </div> -->
        
        
        
              <!--  <div class="col-lg-6">
                <div class="card dinfo">
                  
                 <div class="card-header">
                    <h2 class="page-title"><i class="fa fa-exchange  "></i> Loads In Progress</h2>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="progress_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div>
         -->
        
        
      <!--    Past Loads comment by jay //  
    <div class="col-lg-6">
                <div class="card">
                  
                 <div class="card-header">
                    <h1 class="page-title">Past Loads</h1>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                        </tr>
                      </thead>
                      <tbody class="past_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
                          <td ></td>
                        </tr>
                      
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div>  -->
        
        
        
             <!--  <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3">
                      <i class="fe fe-dollar-sign"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)">132 <small>Sales</small></a></h4>
                      <small class="text-muted">12 waiting payments</small>
                    </div>
                  </div>
                </div>
              </div> -->
           <!--    <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green mr-3">
                      <i class="fe fe-shopping-cart"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)">78 <small>Orders</small></a></h4>
                      <small class="text-muted">32 shipped</small>
                    </div>
                  </div>
                </div>
              </div> -->
           <!--    <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red mr-3">
                      <i class="fe fe-users"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)">1,352 <small>Members</small></a></h4>
                      <small class="text-muted">163 registered today</small>
                    </div>
                  </div>
                </div>
              </div> -->
            <!--   <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-yellow mr-3">
                      <i class="fe fe-message-square"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)">132 <small>Comments</small></a></h4>
                      <small class="text-muted">16 waiting</small>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
            
            
          </div>
        </div>
      </div>

 <script>
      var pending_per=0;
      var approval_per=0;
      var picked_per=0;
      var delivery_per=0;
      var cancel_per=0;
      var expired_per=0;
      $( document ).ready(function() {
         $.ajax({
              type:'POST',
              url:LoadBoard.API+'broker/dashboard',
              dataType: 'json',
              async:false,
              headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
              data: JSON.stringify({ 
                "user_id":LoadBoard.userid            
              }),
              contentType: "application/json",
              //data:{ user_id: LoadBoard.userid},
              success:function(result){
              if(result.status==2){
              window.location.href=LoadBoard.APP+"logout";
              }else if(result.status==1){
              $(".today_loads").html(result.data.today_loads);
             // $(".waiting_loads").html(result.data.total_loads);
              $(".picked_loads").html(result.data.picked_loads);
              $(".deliv_loads").html(result.data.delivered_loads);
              $(".pending_loads").html(result.data.pending_loads);
              $(".total_loads").html(result.data.total_loads);
              $(".cancel_loads").html(result.data.cancel_count);
              $(".expire_loads").html(result.data.expired_count);

              pending_per=result.data.pending_percentage;
              approval_per=result.data.approval_percentage;
              picked_per=result.data.picked_percentage;
              delivery_per=result.data.delivery_percentage;
              cancel_per=result.data.cancel_percentage;
              expired_per=result.data.expired_percentage;

              if(result.data.recent_records.length!=0){
              $(".recent_loads").empty();
                   for (i = 0; i < result.data.recent_records.length; i++) {
                     var orgt=result.data.recent_records[i]['origin'].split(",");
                     var dest=result.data.recent_records[i]['destination'].split(",");
                     var recent_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.recent_records[i]['id']) + '\')">'+result.data.recent_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.recent_records[i]['price']+'</td></tr>';
                     $(".recent_loads").append(recent_records);
                   }
              }else{
              var recent_records='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
              $(".recent_loads").html(recent_records);
              }


              if(result.data.today_records.length!=0){
              $(".today_records").empty();
                   for (i = 0; i < result.data.today_records.length; i++) {
                     var orgt=result.data.today_records[i]['origin'].split(",");
                     var dest=result.data.today_records[i]['destination'].split(",");
                     var todayrecords='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.today_records[i]['id']) + '\')">'+result.data.today_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.today_records[i]['price']+'</td></tr>';
                     $(".today_records").append(todayrecords);
                   }
              }else{
              var todayrecords='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
              $(".today_records").html(todayrecords);
              }


              if(result.data.inprogress_records.length!=0){
              $(".progress_records").empty();
                   for (i = 0; i < result.data.inprogress_records.length; i++) {

                     var orgt=result.data.inprogress_records[i]['origin'].split(",");
                     var dest=result.data.inprogress_records[i]['destination'].split(",");
                     var inprog_rec='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.inprogress_records[i]['id']) + '\')">'+result.data.inprogress_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.inprogress_records[i]['price']+'</td></tr>';
                     $(".progress_records").append(inprog_rec);
                     var clasac='';
                     if(i==0){
                      clasac='active';
                     }
                     var sliderrow='<div class="carousel-item '+clasac+'"><h5><a href="javascript:void(0);" > '+result.data.inprogress_records[i]['load_id']+'</a> </h5><ul class=""><li><b>Origin </b><span class="top_origin">'+orgt[0]+", "+orgt[1]+'</span></li><li><b>Destination </b><span class="top_destination">'+dest[0]+", "+dest[1]+'</span></li><li><b>Price </b><span class="to_price">'+result.data.inprogress_records[i]['price']+'</span></li></ul></div>';
                     $(".load_details").append(sliderrow);


                        }
                $(".slider-records").hide();
                $(".slider_div").show();
              }else{
                var inprog_rec='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
                $(".slider_div").hide();
                $(".slider-records").html("No relevant information available");
                $(".slider-records").show();
                $(".progress_records").html(inprog_rec);
              }


              if(result.data.past_records.length!=0){
              $(".past_records").empty();
                   for (i = 0; i < result.data.past_records.length; i++) {
                     var orgt=result.data.past_records[i]['origin'].split(",");
                     var dest=result.data.past_records[i]['destination'].split(",");
                     var pastrec='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.past_records[i]['id']) + '\')">'+result.data.past_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.past_records[i]['price']+'</td></tr>';
                     $(".past_records").append(pastrec);
                   }
              }else{
              var pastrec='<tr class="text-center"><td  colspan="4">No relevant information available</td></tr>';
              $(".past_records").html(pastrec);
              }

              if(result.data.cancel_records.length!=0){
              $(".cancel_records").empty();
                   for (i = 0; i < result.data.cancel_records.length; i++) {
                     var orgt=result.data.cancel_records[i]['origin'].split(",");
                     var dest=result.data.cancel_records[i]['destination'].split(",");
                     var pastrec='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.cancel_records[i]['id']) + '\')">'+result.data.cancel_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.cancel_records[i]['price']+'</td></tr>';
                     $(".cancel_records").append(pastrec);
                   }
              }else{
              var pastrec='<tr class="text-center"><td  colspan="4">No relevant information available</td></tr>';
              $(".cancel_records").html(pastrec);
              }

              if(result.data.expired_records.length!=0){
              $(".expired_records").empty();
                   for (i = 0; i < result.data.expired_records.length; i++) {
                     var orgt=result.data.expired_records[i]['origin'].split(",");
                     var dest=result.data.expired_records[i]['destination'].split(",");
                     var pastrec='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.expired_records[i]['id']) + '\')">'+result.data.expired_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.expired_records[i]['price']+'</td></tr>';
                     $(".expired_records").append(pastrec);
                   }
              }else{
              var pastrec='<tr class="text-center"><td  colspan="4">No relevant information available</td></tr>';
              $(".expired_records").html(pastrec);
              }

               if(result.data.awaiting_records.length!=0){
              $(".awaiting_records").empty();
                   for (i = 0; i < result.data.awaiting_records.length; i++) {
                     var orgt=result.data.awaiting_records[i]['origin'].split(",");
                     var dest=result.data.awaiting_records[i]['destination'].split(",");
                     var pastrec='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.awaiting_records[i]['id']) + '\')">'+result.data.awaiting_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.awaiting_records[i]['price']+'</td></tr>';
                     $(".awaiting_records").append(pastrec);
                   }
              }else{
              var pastrec='<tr class="text-center"><td  colspan="4">No relevant information available</td></tr>';
              $(".awaiting_records").html(pastrec);
              }



             }
             }
         }); 


        // <i class="icon-LoadStatus"></i>
         var pie = new d3pie("pie", {
            header: {
             title: {
             //  text: "Load Status",
                fontSize: 24,
       // bottom:10
              },
      subtitle: {
      text:     ".",
      color:    "#fff",
      fontSize: 35,     
      },
      
            },
            effects: {
              load: {
                effect: "none"
              }
            },
            size: {
            pieOuterRadius: "100%",
            canvasHeight: 280,
           // canvasWidth: 250
          },
            data: {
              content: [
                { label: "OPEN LOAD", value: pending_per, color: "#1c3353" },
                { label: "APPROVAL", value: approval_per, color: "#467fcf" },
                { label: "PICKED", value: picked_per, color: "#17a2b8" },
                { label: "DELIVERED", value: delivery_per, color: "#5eba00" },
                //{ label: "NOT YET ", value: 1, color: "#000" },
               // { label: "CANCEL", value: 5, color: "#2E8B57" }
              ]
            }, tooltips: {
    enabled: true,
    type: "placeholder",
    string: "",
        placeholderParser: null,

    string: "{label}, {percentage}%"
  }
          });    



         var pie_2 = new d3pie("pie_wait", {
            header: {
              title: {
                //text: "Missed Loads",
                fontSize: 24,
              },
          subtitle: {
        text:     ".",
        color:    "#fff",
        fontSize: 24,     
        },
            },
            effects: {
              load: {
                effect: "none"
              }
            },
            size: {
            pieOuterRadius: "100%",
            canvasHeight: 280,
           // canvasWidth: 250
          },
            data: {
              content: [
                { label: "CANCEL", value: cancel_per, color: "#fd9644" },
                { label: "EXPIRED", value: expired_per, color: "#cd201f" }
              ]
            }, tooltips: {
    enabled: true,
    type: "placeholder",
    string: "",
        placeholderParser: null,

    string: "{label}, {percentage}%"
  }
          });    



      });    

                    </script>

 <?php $Global->Footer(); ?>