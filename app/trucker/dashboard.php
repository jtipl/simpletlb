<?php 

require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Dashboard");
//print_r($_SESSION);exit;
?>

  <link href="<?php echo SITEURL; ?>app/assets/js/charts-c3/plugin.css" rel="stylesheet" />
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <i class="icon-Dashboard"></i>&nbsp;&nbsp;
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>

            <div class="row row-cards">

              <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-orange  mr-3 icon-stamp">
                      <!--<i class="fe fe-box"></i>-->
                      <i class="icon-AwaitingApproval"></i>
                    </span>
                    <div>
                      <h4 class="m-0 awaiting_count">1</h4>
                      <small class="text-muted">Awaiting</small>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red  mr-3 icon-stamp">
                      <!--<i class=" fe fe-truck"></i>-->
                      <i class="icon-UpComing"></i>
                    </span>
                    <div>
                      <h4 class="m-0 upcoming_count">1</h4>
                      <small class="text-muted">Upcoming trips</small>
                    </div>
                  </div>
                </div>
              </div>
              

              <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-orange  mr-3 icon-stamp">
                      <!--<i class=" fe fe-truck"></i>-->
                      <i class="icon-Loads-InProgress"></i>
                    </span>
                    <div>
                      <h4 class="m-0 in_loads">1</h4>
                      <small class="text-muted">In progress</small>
                    </div>
                  </div>
                </div>
              </div>

               <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-grey  mr-3 icon-stamp">
                      <!--<i class=" fe fe-x "></i>-->
                      <i class="icon-CancelledLoads"></i>
                    </span>
                    <div>
                      <h4 class="m-0 cancel_loads">1</h4>
                      <small class="text-muted">Cancelled trips</small>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green  mr-3 icon-stamp">
                      <!--<i class="  fe fe-thumbs-up "></i>-->
                      <i class="icon-PastLoad"></i>
                    </span>
                    <div>
                      <h4 class="m-0 past_loads">1</h4>
                      <small class="text-muted">Past loads</small>
                    </div>
                  </div>
                </div>
              </div>

             <div class="col-md-4  col-lg-2 col-sm-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-gray-dark mr-3 icon-stamp">
                     <!-- <i class=" fe fe-layers "></i>-->
                     <i class="icon-ReOpend"></i>
                    </span>
                    <div>
                      <h4 class="m-0 total_loads">0</h4>
                      <small class="text-muted">Denied loads</small>
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
   Loads In Progress &nbsp;&nbsp; </h2>  
              
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
</div>

<div class="col-lg-4 graph">
  <div class="row">
    <div class="col-sm-12">
        <div class="card dinfo">
           <div class="card-body pl-4 pt-0 line">
            <h2 class="page-title dashboard-icon">
              <i class="icon-LoadStatus"></i> Loads Chart</h2>
              <div id="pie"></div>
              <div class="exp"></div>
            </div>
        </div>
    </div>
  </div>
</div>
         

<div class="col-lg-12">
                <div class="card dinfo">
                 <div class="card-header">

                    <h1 class="page-title">
                      <!--<i class="fe fe-box"></i>-->
                      <i class="icon-AwaitingApproval"></i>&nbsp;
                     Awaiting Approval&nbsp;</h1>
              <span class="tool toottip" data-tip="The list of loads that you have confirmed and waiting for the Approval from the user who has added the load." tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
                  
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-striped table-vcenter trucker_table">
                      <thead>
                        <tr>
                          <th>LOAD-ID</th>
                          <th>ORIGIN</th>
                          <th>DESTINATION</th>
                          <th>PRICE</th>
                          <th>BROKER/SHIPPER</th>
                        </tr>
                      </thead>
                      <tbody class="awaiting_records">
                        <tr>
                          <td></td>
                          <td></td>
                          <td class="text-nowrap"></td>
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
                      <!---<i class=" fe fe-truck"></i>--><i class="icon-UpComing"></i>&nbsp;Upcoming Trips&nbsp;</h1>
              <span class="tool toottip" data-tip="The list of Approved loads ready for your pickup." tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
                    
                  
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
                      <tbody class="upcoming_records">
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
                    <h1 class="page-title"><span class="stamp-md bg-grey  mr-3">
                      <!--<i class=" fe fe-x "></i>-->
                      <i class="icon-CancelledLoads"></i>
                    Cancelled Loads</h1>
             
                   <span class="tool toottip" data-tip="The list of loads that you have confirmed and cancelled." tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
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
                      <tbody class="cancelled_records">
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
               
              
          
            </div>
            
            
          </div>
        </div>
      </div>

 <script>
      var awaiting_percentage=0;
      var cancelled_percentage=0;
      var upcoming_percentage=0;
      var inprogress_percentage=0;
      var past_percentage=0;

      $( document ).ready(function() {
         $.ajax({
              type:'POST',
              url:LoadBoard.API+'trucker/dashboard',
              dataType: 'json',
              async:false,
              headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
              data: JSON.stringify({ 
                "user_id":LoadBoard.userid            
              }),
              contentType: "application/json",
              success:function(result){
              if(result.status==2){
              window.location.href=LoadBoard.APP+"logout";
              }else if(result.status==1){

              $(".awaiting_count").html(result.data.awaiting_count);
              $(".upcoming_count").html(result.data.upcoming_count);
              $(".in_loads").html(result.data.inprogress_count);
              $(".past_loads").html(result.data.past_count);
              $(".cancel_loads").html(result.data.cancelled_count);
               $(".total_loads").html(result.data.total_records_count);

              awaiting_percentage=result.data.awaiting_percentage;
              cancelled_percentage=result.data.cancelled_percentage;
              upcoming_percentage=result.data.upcoming_percentage;
              inprogress_percentage=result.data.inprogress_percentage;
              past_percentage=result.data.past_percentage;

              //alert(awaiting_percentage)
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
              
              if(result.data.awaiting_records.length!=0){
              $(".awaiting_records").empty();
                   for (i = 0; i < result.data.awaiting_records.length; i++) {
                     var orgt=result.data.awaiting_records[i]['origin'].split(",");
                     var dest=result.data.awaiting_records[i]['destination'].split(",");
                     //alert(result.data.awaiting_records[i]['broker_id']);

                     if(result.data.awaiting_records[i]['load_status']==1){
                      $("#awaiting_load").hide();
                     } else {
                      $("#awaiting_load").show();
                     }


                     var awaiting_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.awaiting_records[i]['id']) + '\')">'+result.data.awaiting_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.awaiting_records[i]['price']+'</td><td><a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\''+window.btoa(result.data.awaiting_records[i]['broker_id']) +  '\',\''+window.btoa(result.data.awaiting_records[i]['shipper_id']) +  '\')" >'+result.data.awaiting_records[i]['name']+'</a></td></tr>';
                     $(".awaiting_records").append(awaiting_records);
                   }
              }else{
               var awaiting_records='<tr class="text-center"><td colspan="5">No relevant information available</td></tr>';
                $(".awaiting_records").html(awaiting_records);
              }

              if(result.data.cancelled_records.length!=0){
              $(".cancelled_records").empty();
                   for (i = 0; i < result.data.cancelled_records.length; i++) {
                     var orgt=result.data.cancelled_records[i]['origin'].split(",");
                     var dest=result.data.cancelled_records[i]['destination'].split(",");
                     var cancelled_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.cancelled_records[i]['id']) + '\')">'+result.data.cancelled_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.cancelled_records[i]['price']+'</td></tr>';
                     $(".cancelled_records").append(cancelled_records);
                   }
              }else{
               var cancelled_records='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
                $(".cancelled_records").html(cancelled_records);
              }

                if(result.data.upcoming_records.length!=0){
              $(".upcoming_records").empty();
                   for (i = 0; i < result.data.upcoming_records.length; i++) {
                     var orgt=result.data.upcoming_records[i]['origin'].split(",");
                     var dest=result.data.upcoming_records[i]['destination'].split(",");
                     var upcoming_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.upcoming_records[i]['id']) + '\')">'+result.data.upcoming_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.upcoming_records[i]['price']+'</td></tr>';
                     $(".upcoming_records").append(upcoming_records);
                   }
              }else{
               var upcoming_records='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
                $(".upcoming_records").html(upcoming_records);
              }

                   if(result.data.inprogress_records.length!=0){
                     $(".inprogress_records").empty();
                   for (i = 0; i < result.data.inprogress_records.length; i++) {
                     var orgt=result.data.inprogress_records[i]['origin'].split(",");
                     var dest=result.data.inprogress_records[i]['destination'].split(",");
                     var inprogress_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.inprogress_records[i]['id']) + '\')">'+result.data.inprogress_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.inprogress_records[i]['price']+'</td></tr>';
                     $(".inprogress_records").append(inprogress_records);
                   }
              }else{
               var inprogress_records='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
                $(".inprogress_records").html(inprogress_records);
              }

                   if(result.data.past_records.length!=0){
                     $(".past_records").empty();
                   for (i = 0; i < result.data.past_records.length; i++) {
                     var orgt=result.data.past_records[i]['origin'].split(",");
                     var dest=result.data.past_records[i]['destination'].split(",");
                     var past_records='<tr><td><a class="search_modals" href="javascript:void(0)" onclick="mapmodal(\'' + window.btoa(result.data.past_records[i]['id']) + '\')">'+result.data.past_records[i]['load_id']+'</a></td><td>'+orgt[0]+", "+orgt[1]+'</td><td>'+dest[0]+", "+dest[1]+'</td><td>$'+result.data.past_records[i]['price']+'</td></tr>';
                     $(".past_records").append(past_records);
                   }
              }else{
               var past_records='<tr class="text-center"><td colspan="4">No relevant information available</td></tr>';
                $(".past_records").html(past_records);
              }



             }
             }
         }); 
 

         var pie = new d3pie("pie", {
            header: {
              title: {
                //text: "Load Chart",
                fontSize: 24,
              }
            },
            effects: {
              load: {
                effect: "none"
              }
            },
            size: {
            pieOuterRadius: "70%",
            canvasHeight: 280,
          },
            data: {
              content: [
                

                 { label: "AWAITING", value: Math.round(awaiting_percentage), color: "#DEB887" },
                { label: "CANCELLED", value: Math.round(cancelled_percentage), color: "#A9A9A9" },
                { label: "UPCOMING", value: Math.round(upcoming_percentage), color: "#DC143C" },
                { label: "INPROGRESS", value: Math.round(inprogress_percentage), color: "#F4A460" },
                { label: "PASTLOADS", value: Math.round(past_percentage), color: "#2E8B57" }

                
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





      });    

                    </script>


 <?php $Global->Footer(); ?>




