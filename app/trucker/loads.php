 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - My Loads");
$denied_loads = isset($_REQUEST["de"]) ? $_REQUEST["de"] : '';
$pi = isset($_REQUEST["pi"]) ? $_REQUEST["pi"] : '';
$uall = isset($_REQUEST["uall"]) ? $_REQUEST["uall"] : '';
$uall_decode = $Global->decode($uall);
$pi_decode = $Global->decode($pi);
$de_decode = $Global->decode($denied_loads);

if(!empty($uall_decode)){
  $req = $uall_decode;
}
else if(!empty($pi_decode)){
  $req = $pi_decode;
}
else if(!empty($de_decode)){
  $req = $de_decode;
}
else {
  $req = '0';
}
//echo $req;
if($req) { ?>
<script type="text/javascript">
$(document).ready(function(){
  var operation ="<?php echo $req; ?>";
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
      //data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
      success : function(result){
        if(result.status==1){
          //alert(result.msg);
          if(result.msg=="denied Load Viewed Successfully"){
             $("#tabsid").val('denied-loads');
             $("#nav-denied-tab").addClass("active");
            $("#nav-trucker-tab").removeClass("active");
            $("#nav-denied").addClass("active");
            $("#nav-trucker").removeClass("active");
          } else if(result.msg=="Upcoming Trips Load Viewed Successfully"){
            $("#tabsid").val('upcoming-trips');
            $("#nav-home-tab").addClass("active");
            $("#nav-trucker-tab").removeClass("active");
            $("#nav-home").addClass("active");
            $("#nav-trucker").removeClass("active");
          } else if(result.msg=="All Upcoming  Viewed Successfully"){
            //alert("all");
            $("#tabsid").val('upcoming-trips');
             $("#nav-home-tab").addClass("active");
            $("#nav-trucker-tab").removeClass("active");
            $("#nav-home").addClass("active");
            $("#nav-trucker").removeClass("active");
          }
        }
      }
  });
});
</script>
<?php } ?>
<style type="text/css">
  .text-center{text-align: center;}
  .add_vehicle_tab1{float: right;}
</style> 
    <div class="my-3 my-md-5">
          <div class="container animated fadeIn">
            <div class="page-header">
              <i class="icon-TodayLoads"></i>&nbsp;&nbsp;
          <h1 class="page-title">
                My Loads
              </h1> 
            </div>   

    <div class="row animated fadeIn ">
    
    <div class="col-md-12 accordion" id="accordionExample">
<div class="lb-tabs">
  <nav>
    <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">

      <a class="nav-item nav-link active" id="nav-trucker-tab" data-toggle="tab" href="#nav-trucker" role="tab" aria-controls="nav-trucker" aria-selected="false"> 
        <!--<i class="fe fe-rotate-ccw mr-2" ></i>-->
        <i class="icon-AwaitingApprov"></i> &nbsp; Awaiting Approval &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="List of loads that you have confirmed and waiting for the Approval from the user who has added the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>    

      <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> 
        <!--<i class="fe fe-truck mr-2" ></i>-->
        <i class="icon-UpComing"></i> &nbsp; Upcoming Trips  &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="List of Approved loads ready for your pickup" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>

      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> 
        <!--<i class="fa fa-exchange mr-2" ></i>--><i class="icon-PickedLoads"></i> &nbsp; Picked Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="The load that you have picked up and on road" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>    

      <a class="nav-item nav-link" id="nav-denied-tab" data-toggle="tab" href="#nav-denied" role="tab" aria-controls="nav-denied" aria-selected="false"> 
        <!--
        <i class="fa fa-ban mr-2" ></i>--><i class="icon-Deneid"></i> &nbsp; Denied Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="List of loads that you had confirmed but not approved by the user who has added the load" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>      

    </div>
  </nav>
  <div class="tab-content " id="nav-tabContent">
    <div class="tab-pane animated  fadeIn  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="table-responsive"> 
   <h1 class="dgrid-title"> &nbsp;</h1>

                     <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th class="index_sort"><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Price</div></th>
                            <th><div>Broker/Shipper</div></th>
                            <th class="text-center">VIN</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>     
                  </div>
   
   </div>
    
  
  <div class="tab-pane  animated  fadeIn" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
   <div class="table-responsive"> 
   <h1 class="dgrid-title"> &nbsp;</h1>
                  
              <table id="proviewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th class="index_sort"><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Price</div></th>
                            <th><div>Broker/Shipper</div></th>
                            <th><div>VIN</div></th>
                            <th><div>Action</div></th>
                        </tr>
                    </thead>
                </table>   
              </div>
    
    </div>
  
      <div class="tab-pane animated  fadeIn   " id="nav-trucker" role="tabpanel" aria-labelledby="nav-trucker-tab">
     <div class="table-responsive"> 
   <h1 class="dgrid-title"> &nbsp;</h1>
      
                    <table id="awa_viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th class="index_sort"><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Weight</div></th>
                            <th><div>Length</div></th>
                            <th><div>Broker/Shipper</div></th>
                            <th><div>Price</div></th>
                            <th><div>Action</div></th>
                        </tr>
                    </thead>
                </table>   
                  </div>
  </div>
    
   <div class="tab-pane animated  fadeIn " id="nav-denied" role="tabpanel" aria-labelledby="nav-denied-tab">
    <div class="table-responsive"> 
   <h1 class="dgrid-title"> &nbsp;</h1>
                     <table id="denied_loads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                              <th></th>
                            <th class="index_sort"><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                             <th><div>Price</div></th>
                            <th><div>Broker/Shipper</div></th>
                            <th><div>Broker/Shipper Phone</div></th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                  </table>     
                  </div>
   
   </div>
  
  <div class="trucker_export">
   <?php require_once "export-page.php"; ?>  
   <input type="hidden" id="tabsid" value="" /> 
   <input type="hidden" id="total_count" value="" />
 </div>


  </div>
</div>
     
     
     </div> 
    
       </div>

     </div>
        </div>
    <!--   </div> -->
     
    
    


<!-- Modal -->


<?php $Global->Footer(); ?>
<div class="modal fade " id="upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm2">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title h2 text-center" id="mySmallModalLabel">Pick Load</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
       <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
         <i class="fe fe-package"  ></i>
       </div>
          <h2 class="text-cyan ">Load Picked</h2>
          <p>Do you want to update the Load status as <strong>'Picked'?</strong></p>       
      </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary tripca">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<div class="modal fade " id="por_upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm2">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title h2 text-center" id="mySmallModalLabel">Pick Load</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h2 class="text-cyan ">Load Delivered</h2>
        <p>Do you want to update the Load status as <strong>'Delivered'?</strong></p>       
        </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary pro_tripca">Yes</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
           </div>
    
    </div>
  </div>
</div>




<script type="text/javascript">

/*
function myload_count(){
  var awaitingTotalrecords=0;
  var upcoming_trips_count=0;
  var picked_loads_total_records=0;
  var denied_total_records=0;
  $.ajax({
    type: "post",
    url: LoadBoard.API+'trucker/loads-count',
    dataType: "json",
    async:false,
    data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
    success: function (result) {
        if(result.status==1){
          awaitingTotalrecords=result.awaitingTotalrecords;
          upcoming_trips_count=result.upcoming_trips_count;
          picked_loads_total_records=result.picked_loads_total_records;
          denied_total_records=result.denied_total_records;
          
          //alert(awaitingTotalrecords);
          if(awaitingTotalrecords==0){
            $("#export").hide();
          } else {
            $("#export").show();
          }

          if(upcoming_trips_count==0){
            $("#export").hide();
          } else {
            $("#export").show();
          }

          if(picked_loads_total_records==0){
            $("#export").hide();
          } else {
            $(".trucker_export").show();
          }

          if(denied_total_records==0){
            $("#export").hide();
          } else {
            $("#export").show();
          }
        }
      }
  });
}

*/
  var tripvar=0;
  var tripvar_in=0;
  var tripvar_awating=0;
  $(document).ready(function(){

      $('th').on("click", function (event) {
          if($(event.target).is("div"))
              event.stopImmediatePropagation();
      });

  /*
  $.ajax({
    type: "post",
    url: LoadBoard.API+'trucker/loads-count',
    dataType: "json",
    async:false,
    data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
    success: function (result) {
        if(result.status==1){
          awaitingTotalrecords=result.awaitingTotalrecords;
          //alert(awaitingTotalrecords);
          if(awaitingTotalrecords==0){
            $(".trucker_export").hide();
          } else {
            //alert("show");
            $(".trucker_export").show();
          }
          $("#total_count").val(awaitingTotalrecords);
        }
      }
  });
  */
  
    $(".export_csv").click(function(){
      var export_page = $("input[name='export_page']:checked").val();
      var user_id = LoadBoard.userid;
      var token = LoadBoard.token;
      var tabsid = $("#tabsid").val();
      var total_count = $("#total_count").val();
      
      //if(tabsid=='awaiting' || tabsid==''){
        //var total_count = awaitingTotalrecords;
      //} else {
        var total_count = $("#total_count").val();  
      //} 

      /*else if(tabsid=="upcoming-trips"){
        var total_count = upcoming_trips_count;
      } else if(tabsid=="picked-loads"){
        var total_count = picked_loads_total_records;
      } else if(tabsid=="denied-loads"){
        var total_count = denied_total_records;
      }
      */
      //alert(total_count);
      if(total_count!=0){
          $(".export").show();
          if(export_page=="1"){
            var pageid = $("li.active > .page-link").attr("data-dt-idx");
            var draw = pageid;
            for(var i=1; i<=total_count; i++){
              if(draw==i && i==1){
                var start = 0;
              }
              else if(draw==i && i>1){
                var start = ((i-1) * 10);
              }
            }
            var length = '10';
            var href=LoadBoard.API+"trucker/download-excel-current-view-loads?token="+token+"&operation="+tabsid+"&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          } else if(export_page=="2"){
            var href=LoadBoard.API+"trucker/download-excel-all-loads?token="+token+"&operation="+tabsid+"&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } else {

           toastr.options = { 
              "progressBar": true,
              "positionClass": "toast-top-full-width",
              "timeOut": "2000",
              "extendedTimeOut": "1000",
            }
            toastr.error("No relevant information available To Export Data");
            $(".export").hide();
        }
    });

   





    var pickedtable= $('#viewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+'trucker/upcoming-trips',
            type:"post",
             headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
             contentType: "application/json",
            "dataFilter": function(data) {
              var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
              if(rowCount ==0){
              $("#export").hide();
              $("#viewloads_info").hide();
              } else {
              $("#export").show();
              $("#viewloads_info").show();
              }
              $("#total_count").val(rowCount)
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "logout";
              }else{
                 return JSON.stringify(data);
              }
            },
             "data": function(data){
                data.user_id =LoadBoard.userid
                return   JSON.stringify(data);
             },
          },
             "bLengthChange": false,  
              "type": "POST",
              "showNEntries" : false,
              //"bInfo":false,
              "bPaginate":true,
              "bProcessing": false,
              "bServerSide": true,
              "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 1, "desc" ]],
              "columns": [
                {"data": "pickup_date"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
                {"data": "business_name"},
                {"data": "vehicle_details"},
                {"data": "tripstatus" },
            ],
    columnDefs: [
       {
        targets: 2,
         width: "10%",
        render: function (data,type,row) {
               var orgt=row.origin.split(",");
               return orgt[0]+", "+orgt[1];

                }
      },
      {
        targets: 3,
         width: "10%",
        render: function (data,type,row) {
                 var dest=row.destination.split(",");
               return dest[0]+", "+dest[1];

                }
      },
      {
        targets:5,
        width:"10%",
        render:function(data,type,row){
           //return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
           var mystring = row.business_name.toUpperCase();
           if(mystring.length > 15){
               return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...'+'</span></a>';
          } else {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" >'+mystring+'</a>';
          }
        }
      },
       {
        targets: 4,
         width: "10%",
        render: function (data,type,row) {
            if(row.suggest_price==0)
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              else
                return  "$"+row.suggest_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      },
      {
        targets: 6,
        width: "10%",
        bSortable: false, 
        render: function (data,type,row) {
             if(row.vehicle_details.length==0){
              var htm = '<a href="#"  class="add_vehicle_tab1"  data-toggle="modal" data-target="#add_vehicle_tab1"><i class="fa fa-plus my-3"></i> </a>';
             } else {
                var htm = "<select size='1' class='form-control vinnodisp' data-id='"+row.id+"' style='width:150px;'  id='vinnodisp'><option value=''>--Select VIN NO--</option>";
                for (var i = 0; i < row.vehicle_details.length; i++) {
                  if(row.veh_id_no==row.vehicle_details[i]["veh_id_no"]){
                    var selected ='selected';
                  } else {
                     var selected ='';
                  }
                   htm = htm + "<option "+selected+"  value='"+row.vehicle_details[i]["veh_id_no"]+"'>"+row.vehicle_details[i]["veh_id_no"]+"</option>";
                }
                htm += '</select><a href="#" style="margin:-32px -16px" class="add_vehicle_tab1"  data-toggle="modal" data-target="#add_vehicle_tab1"><i class="fa fa-plus my-3"></i> </a>';

                /*
                var htm = "<a href='#'  class='add_vehicle_tab1'  data-toggle='modal' data-target='#add_vehicle_tab1'><i class='fa fa-plus my-3'></i> </a> <select size='1' class='form-control vinnodisp' style='width:150px;'  id='vinnodisp'><option value=''>--Select VIN NO--</option>";
                for (var i = 0; i < row.vehicle_details.length; i++) {
                  if(row.veh_id_no==row.vehicle_details[i]["veh_id_no"]){
                    var selected ='selected=selected';
                  } else {
                     var selected ='';
                  }
                   htm = htm + "<option "+selected+" value='"+row.vehicle_details[i]["veh_id_no"]+"'>"+row.vehicle_details[i]["veh_id_no"]+"</option>";
                }
                htm += "</select> ";
                */
            }
            return htm;
        }
      },

      {
        targets: 7,
        width:"20%",
        bSortable: false, 
        render: function (data,type,row) {
          // old btn btn-success btn-sm trip_pick
          var upcoming='upcoming';
          return '&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="btn btn-outline-success pickbutton btn-sm pick trip_pick" data-tr="'+window.btoa(row.tripid)+'">Mark as Picked</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" id="upcoming_trip" onclick="mapcancel(\'' + window.btoa(row.id) + '\',\'' + window.btoa(row.tripid) + '\',\''+upcoming+'\')"  class="btn btn-outline-danger btn-sm minus"> Cancel Trip</a>';

        }
      },
        {
        targets: 0,
         width: "5%",
           bSortable: false, 
        render: function (data,type,row) {
       return '<a class="icon search_modals" href="javascript:void(0)" id="upcoming_trip" onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';

                }
      }, {
        targets: 1,
         width: "10%",
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

          }
      }
    ],

    }); 

        $( document ).on("click", ".trip_pick", function(){
          tripvar=$(this).attr("data-tr");
          //$("#upcom_status").modal("show");
          swal.fire({
            title: "Confirmation!",
            text: "Do you want to update the Load status as 'Picked'?",
            type: 'success',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn-md',
            cancelButtonClass: 'btn-md',
            showCloseButton: true,
            allowOutsideClick:false,
          }).then(result => {
            if(result.value==true){

                $(".preloader").show();
                $(".tripca").attr("disabled", true);
                $.ajax({
                  type: 'post',
                  url: LoadBoard.API+'trucker/trip-picked',
                  dataType: "json",
                  contentType: "application/json",
                  headers: {
                      Authorization: "Bearer "+LoadBoard.token
                  },
                  data: JSON.stringify({ 
                     "tripid": window.atob(tripvar),
                      "user_id": LoadBoard.userid,
                   }),
                  success: function (result) {
                   $(".tripca").attr("disabled", false);
                      if(result.status==1){
                        $(".preloader").hide();
                        toastr.options = { 
                        "progressBar": true,
                        "positionClass": "toast-top-full-width",
                        "timeOut": "2000",
                        "extendedTimeOut": "1000",
                      }
                    toastr.success(result.msg); 
                    $("#upcom_status").modal("hide");
                      pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                      pickedtable.ajax.reload();
                 

                      var awaitingTotalrecords=0;
                      var upcoming_trips_count=0;
                      var picked_loads_total_records=0;
                      var denied_total_records=0;
                      $.ajax({
                        type: "post",
                        url: LoadBoard.API+'trucker/loads-count',
                        dataType: "json",
                        async:false,
                        data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
                        success: function (result) {
                            if(result.status==1){
                              awaitingTotalrecords=result.awaitingTotalrecords;
                              upcoming_trips_count=result.upcoming_trips_count;
                              picked_loads_total_records=result.picked_loads_total_records;
                              denied_total_records=result.denied_total_records;
                              if(upcoming_trips_count==0){
                                $("#export").hide();
                              } else {
                                $("#export").show();
                              }
                            }
                          }
                      });
                  }else if(result.status==2){
                     window.location.href = LoadBoard.APP+'logout';                   
                }
              }
            
            });  

            }
          });
           $("body").removeClass("swal2-height-auto");
        });

       


       //In progress 
        var inprogresstable= $('#proviewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+'trucker/inprogress-trips',
            type:"post",
             headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
             contentType: "application/json",
            "dataFilter": function(data) {
              var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
              if(rowCount ==0){
              $("#export").hide();
              $("#proviewloads_info").hide();
              } else {
              $("#export").show();
              $("#proviewloads_info").show();
              }
              $("#total_count").val(rowCount);
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "logout";
              }else{
                 return JSON.stringify(data);
              }
             
            },
            "data": function(data){
              data.user_id =LoadBoard.userid
              return   JSON.stringify(data);
           },
          },
             "bLengthChange": false,  
              "type": "POST",
              "showNEntries" : false,
              //"bInfo":false,
              "bPaginate":true,
              "bProcessing": false,
              "bServerSide": true,
              "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 1, "desc" ]],
              "columns": [
                {"data": "pickup_date"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
                {"data": "business_name"},
                {"data": "phone"},
                {"data": "tripstatus" },
            ],
    columnDefs: [
       {
        targets: 2,
        width:"10%",
        render: function (data,type,row) {
               var orgt=row.origin.split(",");
               return orgt[0]+", "+orgt[1];

                }
      },
       {
        targets: 3,
        width:"10%",
        render: function (data,type,row) {
          var dest=row.destination.split(",");
          return dest[0]+", "+dest[1];
             }
      },
      {
        targets:5,
        width:"10%",
        render:function(data,type,row){
         var favclass="";
         var favcon="";
          if(row.favorite_status==0){
              favclass="star";
              favcon='<span class="tool" data-tip="Mark this broker favorite" tabindex="1" ><a class="star btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'"  data-broker-id="'+row.broker_id+'" data-shipper-id="'+row.shipper_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
          }else if(row.favorite_status==1){
              favclass="star-fav";
              favcon='<span class="tool" data-tip="Remove from favorite list" tabindex="1" ><a class="star-fav btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'"  data-shipper-id="'+row.shipper_id+'" data-broker-id="'+row.broker_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
          }else{
              favclass="star";
              favcon='<span class="tool" data-tip="Mark this broker favorite" tabindex="1" ><a class="star btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'"  data-shipper-id="'+row.shipper_id+'" data-broker-id="'+row.broker_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
          }
          var mystring = row.business_name.toUpperCase();
          if(mystring.length > 15){
           return favcon+'<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...'+'</span></a>';
          } else {
            return favcon+'<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" >'+mystring+'</a>';
          }
        }
      },
      {
        targets: 6,
        width:"10%",
        render:function (data,type,row) {
           return row.veh_id_no;
         }
      }, 
      {
        targets: 4,
        width:"5%",
        render: function (data,type,row) {
          if(row.suggest_price==0)
            return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          else
            return  "$"+row.suggest_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
     
      {
        targets: 7,
        width:"15%",
        bSortable: false, 
        render: function (data,type,row) {
            return '<a href="javascript:void(0)" class="btn  pickbutton btn-outline-success btn-sm pick  pro_trip_pick" data-tr="'+window.btoa(row.tripid)+'"  >Mark as Delivered</a>';
        }
      },
      {
        targets: 0,
        width:"5%",
         bSortable: false, 
        render: function (data,type,row) {
          return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';

        }
      },
      {
        targets: 1,
        width:"10%",
        render: function (data,type,row) {
           return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';
           }
        }
    ],
  }); 

$( document ).on("click", ".pro_trip_pick", function(){
   tripvar_in=$(this).attr("data-tr");
  //$("#por_upcom_status").modal("show");
  swal.fire({
      title: "Confirmation!",
      text: "Do you want to update the Load status as 'Delivered'?",
      type: 'success',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
      confirmButtonClass: 'btn-md',
      cancelButtonClass: 'btn-md',
      showCloseButton: true,
      allowOutsideClick:false,
  }).then(result => {
    if(result.value==true){
      $(".preloader").show();
      $(".pro_tripca").attr("disabled", true);
      $.ajax({
        type: 'post',
        url: LoadBoard.API+'trucker/trip-delivered',
        dataType: "json",
        contentType: "application/json",
        headers: {
           Authorization: "Bearer "+LoadBoard.token
          },
        data: JSON.stringify({ 
          "tripid": window.atob(tripvar_in),
          "user_id": LoadBoard.userid,
        }),
      success: function (result) {
      $(".pro_tripca").attr("disabled", false);
      if(result.status==1){
        $(".preloader").hide();
        toastr.options = { 
        "progressBar": true,
        "positionClass": "toast-top-full-width",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        }
        toastr.success(result.msg); 
        $("#por_upcom_status").modal("hide");
        inprogresstable.ajax.reload();
        var awaitingTotalrecords=0;
        var upcoming_trips_count=0;
        var picked_loads_total_records=0;
        var denied_total_records=0;
          $.ajax({
            type: "post",
            url: LoadBoard.API+'trucker/loads-count',
            dataType: "json",
            async:false,
            data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
            success: function (result) {
                if(result.status==1){
                  awaitingTotalrecords=result.awaitingTotalrecords;
                  upcoming_trips_count=result.upcoming_trips_count;
                  picked_loads_total_records=result.picked_loads_total_records;
                  denied_total_records=result.denied_total_records;
                  if(picked_loads_total_records==0){
                    $("#export").hide();
                  } else {
                    $("#export").show();
                  }
                }
              }
          });
          }else if(result.status==2){
             window.location.href = LoadBoard.APP+'logout';                   
          }
        }
      });  
    }
  })
   $("body").removeClass("swal2-height-auto");
});


        





      //Denied Loads
       var denied_loads=  $('#denied_loads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+'trucker/denied-loads',
            type:"post",
            headers: {
              Authorization: "Bearer "+LoadBoard.token
            },
            contentType: "application/json",
            "dataFilter": function(data) {
              var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
              if(rowCount ==0){
              $("#export").hide();
              $("#denied_loads_info").hide();
              } else {
              $("#export").show();
              $("#denied_loads_info").show();
              }
              $("#total_count").val(rowCount)
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "logout";
              }else{
                 return JSON.stringify(data);
              }
             
            },
             "data": function(data){
              data.user_id =LoadBoard.userid
              return   JSON.stringify(data);
            },
          },
             "bLengthChange": false,  
              "type": "POST",
              "showNEntries" : false,
              //"bInfo":false,
              "bPaginate":true,
              "bProcessing": false,
              "bServerSide": true,
              "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 1, "desc" ]],
              "columns": [
                {"data": "tripid"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "price" },
                {"data": "business_name"},
                {"data": "phone"},
                {"data": "tripstatus" },
            ],
    columnDefs: [
       {
        targets: 2,
        width:"10%",
        render: function (data,type,row) {
               var orgt=row.origin.split(",");
               return orgt[0]+", "+orgt[1];

                }
      },
       {
        targets: 3,
        width:"10%",
        render: function (data,type,row) {
                 var dest=row.destination.split(",");
               return dest[0]+", "+dest[1];

                }
      },
      {
        targets:5,
        width:"10%",
        render:function(data,type,row){
          var mystring = row.business_name.toUpperCase();
          if(mystring.length > 30){
           return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,30)+'...'+'</span></a>';
          } else {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" >'+mystring+'</a>';
          }
        }
      },
      {
        targets: 6,
         width:"10%",
        render:function (data,type,row) {
         return formatPhoneNumber(row.phone);
        }
      }, 
      {
        targets: 4,
        width:"10%",
        render: function (data,type,row) {
           
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
      {
        targets: 7,
        "visible":false,
         bSortable: false, 
        render: function (data,type,row) {
          return '-';
        }
      },
      {
        targets: 0,
         width:"5%",
         bSortable: false, 
        render: function (data,type,row) {
          return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
          }
      },
      {
        targets: 1,
         width:"10%",
        render: function (data,type,row) {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

          }
        }
      ],

    }); 





               //Awating for Approval
       var awatingtable=  $('#awa_viewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+'trucker/awaiting-loads',
            type:"post",
            headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
              contentType: "application/json",
            "dataFilter": function(data) {
              var awaiting_data = JSON.parse(data);
              var rowCount =awaiting_data.iTotalDisplayRecords;
              if(rowCount ==0){
              $("#export").hide();
              $("#awa_viewloads_info").hide();

              } else {
              $("#export").show();
              $("#awa_viewloads_info").show();

              }
              $("#total_count").val(rowCount)
              if(awaiting_data.status==2){
                   window.location.href = LoadBoard.APP + "logout";
              }else{
                return JSON.stringify(awaiting_data);  
              }
              
            },

           "data": function(data){

              data.user_id =LoadBoard.userid
              return   JSON.stringify(data);
          },


          },
            "bLengthChange": false,  
              "type": "POST",
              "showNEntries" : false,
              //"bInfo":false,
              "bPaginate":true,
              "bProcessing": false,
              "bServerSide": true,
              "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 1, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "weight"},
                {"data": "length"},
                {"data": "business_name"},
                {"data": "price" },
                {"data": "tripstatus" },
            ],
    columnDefs: [
       {
        targets: 2,
        width:"10%",
        render: function (data,type,row) {
            var orgt=row.origin.split(",");
            return orgt[0]+", "+orgt[1];
          }
      },
      {
        targets: 3,
        width:"10%",
        render: function (data,type,row) {
          var dest=row.destination.split(",");
          return dest[0]+", "+dest[1];
        }
      },
      {
        targets:6,
        width:"10%",
        render:function(data,type,row){
          var mystring = row.business_name.toUpperCase();
          if(mystring.length > 15){
           return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...'+'</span></a>';
          } else {
            return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" >'+mystring+'</a>';
          } 
        }

      },
      {
        targets: 7,
        width:"10%",
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      },
        {
        targets: 8,
        width:"15%",
         bSortable: false, 
        render: function (data,type,row) {
          var awaiting='awaiting';
                return '<a href="javascript:void(0)" id="awating_approval" onclick="mapcancel(\'' + window.btoa(row.id) + '\',\'' + window.btoa(row.tripid) + '\',\'' + awaiting + '\')"  class="btn btn-outline-danger btn-sm minus"> Cancel Load</a>';

                }
      },
       {
        targets: 0,
        width:"6%",
         bSortable: false, 
        render: function (data,type,row) {
       return '<a class="icon search_modals" href="javascript:void(0)"  id="awating_approval" onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';

                }
      },
       {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';
           }
        }
     ],
  }); 





       $(document).on("click","#nav-home-tab",function(){
            pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
            //pickedtable.ajax.reload();
       });
       $(document).on("click","#nav-profile-tab",function(){
            inprogresstable.ajax.url(LoadBoard.API+"trucker/inprogress-trips").load();
            //inprogresstable.ajax.reload();
       });
       $(document).on("click","#nav-trucker-tab",function(){
           awatingtable.ajax.url(LoadBoard.API+"trucker/awaiting-loads").load();
          // awatingtable.ajax.reload();
       });
       $(document).on("click","#nav-denied-tab",function(){
            denied_loads.ajax.url(LoadBoard.API+"trucker/denied-loads").load();
            //denied_loads.ajax.reload();
       });
      
      
       $(document).on("click",".nav-item",function(){
        var href = $(this).attr("href");  
        if(href=="#nav-trucker"){
          $("#tabsid").val('awaiting');
          
        } else if(href=="#nav-home"){
          $("#tabsid").val('upcoming-trips');
          
        } else if(href=="#nav-profile"){
          $("#tabsid").val('picked-loads');
          
        } else if(href=="#nav-denied"){
          $("#tabsid").val('denied-loads');
          
        }
    });




        var denied="<?php echo $denied_loads; ?>";
        var pi_decode="<?php echo $pi_decode; ?>";
       
       if(denied!=''){
          $("#nav-trucker-tab").removeClass("active");
          $("#nav-home-tab").removeClass("active");
          $("#nav-profile-tab").removeClass("active");  
          $("#nav-denied-tab").addClass("active"); 
          
          $("#nav-denied").addClass("active");
          $("#nav-trucker").removeClass("active");
          $("#nav-home").removeClass("active");
          $("#nav-profile").removeClass("active");  
          //denied_loads.ajax.reload(); 
       }
       else if(pi_decode!=""){
          $("#nav-trucker-tab").removeClass("active");
          $("#nav-home-tab").addClass("active");
          $("#nav-profile-tab").removeClass("active");  
          $("#nav-denied-tab").removeClass("active"); 
          
          $("#nav-denied").removeClass("active");
          $("#nav-trucker").removeClass("active");
          $("#nav-home").addClass("active");
          $("#nav-profile").removeClass("active");    
       

       }
       
       else {
           $("#nav-trucker-tab").addClass("active");
          $("#nav-home-tab").removeClass("active");
          $("#nav-profile-tab").removeClass("active");  
          $("#nav-denied-tab").removeClass("active"); 
          
          $("#nav-denied").removeClass("active");
          $("#nav-trucker").addClass("active");
          $("#nav-home").removeClass("active");
          $("#nav-profile").removeClass("active");  
         // alert(awaitingTotalrecords)
           
       }


       //Cancel load reload
    var reload=getUrlParameter('pro');
    
    if(reload!=undefined && reload!='undefined'){
         if(window.atob(reload)=='upcoming'){
      
         $("#nav-trucker-tab").removeClass("active");
          $("#nav-home-tab").addClass("active");
          $("#nav-profile-tab").removeClass("active");  
          $("#nav-denied-tab").removeClass("active"); 
          
          $("#nav-denied").removeClass("active");
          $("#nav-trucker").removeClass("active");
          $("#nav-home").addClass("active");
          $("#nav-profile").removeClass("active");    

    }if(window.atob(reload)=='awaiting'){
          $("#nav-trucker-tab").addClass("active");
          $("#nav-home-tab").removeClass("active");
          $("#nav-profile-tab").removeClass("active");  
          $("#nav-denied-tab").removeClass("active"); 
          
          $("#nav-denied").removeClass("active");
          $("#nav-trucker").addClass("active");
          $("#nav-home").removeClass("active");
          $("#nav-profile").removeClass("active");  
        }

    }

     $(document).on("click", ".favclick",function(){
          var tid=$(this).attr("data-trucker-id");
          var bid=$(this).attr("data-broker-id");
          var sid=$(this).attr("data-shipper-id");
          var fav=0;
          if(bid != 0){
              if($(".favorite_"+bid).hasClass("star")){
                  fav=1;
              }else if($(".favorite_"+bid).hasClass("star-fav")){
                  fav=0;
              }
          }else if(sid != 0){

            if($(".favoritesid_"+sid).hasClass("star")){
                fav=1;
            }else if($(".favoritesid_"+sid).hasClass("star-fav")){
                fav=0;
            }
          }
       $.ajax({
          type: 'post',
          url: LoadBoard.API+'trucker/favorite',
          dataType: "json",
          headers: {
          Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({ 
          "user_id":LoadBoard.userid,
          "trucker_id": tid,
          "broker_id": bid,
          "shipper_id": sid,
          "favorite_status":fav,        
          }),
          contentType: "application/json",
          success: function (result) {
              if(result.status==1){
                if($(".favorite_"+bid).hasClass("star")){
                  $(".favorite_"+bid).removeClass("star");
                  $(".favorite_"+bid).addClass("star-fav");
                }else if($(".favorite_"+bid).hasClass("star-fav")){
                  $(".favorite_"+bid).removeClass("star-fav");
                  $(".favorite_"+bid).addClass("star");
                }
                  inprogresstable.ajax.url(LoadBoard.API+"trucker/inprogress-trips").load();
                  inprogresstable.ajax.reload();
              }else if(result.status==2){
                window.location.href=LoadBoard.APP+"logout";
              }

          }
        });
         
    });



     $(document).on("change",".vinnodisp",function(){
        //alert("hii");
        var veh_id_noval = $(this).val();
        //$("#vinno_modal").modal("show");
        $("#veh_id_noval").val(veh_id_noval);
        /*
        var rowtable= $("#viewloads tbody tr").find("td:eq(1)").html().split(">");
        var rowtable1 = rowtable[1].split("</a");
        var load_id_exp = rowtable1[0].split("000");
        var load_id = load_id_exp[1];
        */
        var load_id = $(this).attr("data-id");
        //alert(load_id)
        
        $("#load_id").val(load_id);
          swal.fire({
              title: "Assign Vehicle!",
              text: "Do you want to assign this vehicle to the load?",
              type: "success",
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              confirmButtonClass: 'btn-md',
              cancelButtonClass: 'btn-md',
              showCloseButton: true,
              allowOutsideClick:false,
          }).then(result => {
              //alert(result.value);
              if(result.value==true){
                $.ajax({
                type: 'post',
                url: LoadBoard.API+'trucker/vehicle-update',
                dataType: "json",
                headers: {
                Authorization: "Bearer "+LoadBoard.token
                },
                contentType: "application/json",
                data: JSON.stringify({ 
                "user_id": LoadBoard.userid, 
                "veh_id_no":veh_id_noval,
                "load_id":load_id
                }),
                // data: {"veh_id_no":veh_id_noval,"load_id":load_id,"token":LoadBoard.token,"user_id":LoadBoard.userid},
                success: function (result) {
                  if(result.status==1){
                      toastr.options = { 
                      "progressBar": true,
                      "positionClass": "toast-top-full-width",
                      "timeOut": "2000",
                      "extendedTimeOut": "1000",
                    }
                    toastr.success(result.msg);
                  }
                }
              });
              } else {
                pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                  pickedtable.ajax.reload();
                //location.reload();
              }
          });
           $("body").removeClass("swal2-height-auto");
     });

     /*
     $(document).on("click",".vehicle_load",function(){
        var veh_id_noval = $("#veh_id_noval").val();
        var load_id = $("#load_id").val();
        $("#vinno_modal").modal("hide");
                         $.ajax({
                type: 'post',
                url: LoadBoard.API+'trucker/vehicle-update',
                dataType: "json",
                data: {"veh_id_no":veh_id_noval,"load_id":load_id,"token":LoadBoard.token,"user_id":LoadBoard.userid},
                success: function (result) {
                  if(result.status==1){
                      toastr.options = { 
                      "progressBar": true,
                      "positionClass": "toast-top-full-width",
                      "timeOut": "2000",
                      "extendedTimeOut": "1000",
                    }
                    toastr.success(result.msg);
                  }
                }
              });
     });
     */



     $("#veh_unit").on('keypress',function(event){
        $(this).val($(this).val().replace(/[^\d].+/, ""));
          if((event.which < 48 || event.which > 57)) {
              event.preventDefault();
             $("label#veh_unit-error").html('Vehicle Unit Only accept Numberic').css('display','block');
          } else {
            $("label#veh_unit-error").html('').css('display','none');
          }
    });

     $("#veh_weight").on('keypress',function(event){
        $(this).val($(this).val().replace(/[^\d].+/, ""));
          if((event.which < 48 || event.which > 57)) {
              event.preventDefault();
             $("label#veh_weight-error").html('Vehicle Weight Only accept Numberic 3 digits').css('display','block');
          } else {
            $("label#veh_weight-error").html('').css('display','none');
          }
    });

    $("#veh_length").on('keypress',function(event){
        $(this).val($(this).val().replace(/[^\d].+/, ""));
          if((event.which < 48 || event.which > 57)) {
              event.preventDefault();
             $("label#veh_length-error").html('Vehicle Length Only accept Numberic 2 digits').css('display','block');
          } else {
            $("label#veh_length-error").html('').css('display','none');
          }
    });

    $("#veh_height").on('keypress',function(event){
        $(this).val($(this).val().replace(/[^\d].+/, ""));
          if((event.which < 48 || event.which > 57)) {
              event.preventDefault();
             $("label#veh_height-error").html('Vehicle Height Only accept Numberic 3 digits').css('display','block');
          } else {
             $("label#veh_height-error").html('').css('display','none');
          }
    });

    $(document).on('click',".add_vehicle_tab1",function(){
      $("#veh_id_no").val('');
      $("#veh_make").val('');
      $("#veh_model").val('');
      $("#veh_type").val('');
      $("#veh_unit").val('');
      $("#veh_weight").val('');
      $("#veh_length").val('');
      $("#veh_height").val('');
      $("label#veh_id_no-error").html("").css('display','none');
    });
    $('#veh_id_no').bind('keypress', function (event) {
            var regex = new RegExp("^[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });

     $(document).on('click','.add_vehicle_details',function(){
        var veh_id_no =$("#veh_id_no").val();
        var veh_make =$("#veh_make").val();
        var veh_model =$("#veh_model").val();
        var veh_type =$("#veh_type").val();
        var veh_unit =$("#veh_unit").val();
        var veh_weight =$("#veh_weight").val();
        var veh_length =$("#veh_length").val();
        var veh_height =$("#veh_height").val();
        //alert(veh_id_no);alert(veh_make);
        var url = 'add-vehicle-details';
        if(veh_id_no==""){
          $("label#veh_id_no-error").html("Please enter the vehicle identification number").css('display','block');
          return false;
        } else {
            $("label#veh_id_no-error").html("").css('display','none');
            $.ajax({
              type: 'post',
              url: LoadBoard.API+'trucker/'+url,
              dataType: "json",
              headers: {
                Authorization: "Bearer "+LoadBoard.token
                },
              contentType: "application/json",
              data: JSON.stringify({ 
                  "user_id": LoadBoard.userid, 
                  "veh_id_no": veh_id_no,
                  "veh_unit":veh_unit ,
                  "veh_make":veh_make,
                  "veh_model":veh_model,
                  "veh_type":veh_type,
                  "veh_weight" :veh_weight,
                  "veh_length" :veh_length,
                  "veh_height" :veh_height,
              }),
                           // data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&veh_id_no="+veh_id_no+"&veh_make="+veh_make+"&veh_model="+veh_model+"&veh_type="+veh_type+"&veh_unit="+veh_unit+"&veh_weight="+veh_weight+"&veh_length="+veh_length+"&veh_height="+veh_height,
              success:function(result){
                $("#veh_id_no").val('');
                $("#veh_make").val('');
                $("#veh_model").val('');
                $("#veh_type").val('');
                $("#veh_unit").val('');
                $("#veh_weight").val('');
                $("#veh_length").val('');
                $("#veh_height").val('');
                if(result.status==1){
                  toastr.options = { 
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                  }
                  toastr.success(result.msg);
                  
                  pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                  pickedtable.ajax.reload();
                  //vinnoformat();
                  $("#veh_id_no").val('');
                  $("#veh_make").val('');
                  $("#veh_model").val('');
                  $("#veh_type").val('');
                  $("#veh_unit").val('');
                  $("#veh_weight").val('');
                  $("#veh_length").val('');
                  $("#veh_height").val('');
                } else if(result.status==0){
                  /*
                  toastr.options = { 
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                  }
                  toastr.error(result.msg);
                  */
                  $("label#veh_id_no-error").html(result.msg).css('display','block');
                  pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                  pickedtable.ajax.reload();
                  //vinnoformat();
                }
              }
            });
        }
     });

      $(document).on('click','.save_vehicle_details',function(){
        var veh_id_no =$("#veh_id_no").val();
        var veh_make =$("#veh_make").val();
        var veh_model =$("#veh_model").val();
        var veh_type =$("#veh_type").val();
        var veh_unit =$("#veh_unit").val();
        var veh_weight =$("#veh_weight").val();
        var veh_length =$("#veh_length").val();
        var veh_height =$("#veh_height").val();
        //alert(veh_id_no);alert(veh_make);
        var url = 'add-vehicle-details';
        if(veh_id_no==""){
          $("label#veh_id_no-error").html("Please enter the vehicle identification number").css('display','block');
          return false;
        } else {
            $.ajax({
               type: 'post',
               url: LoadBoard.API+'trucker/'+url,
               dataType: "json",
               headers: {
                Authorization: "Bearer "+LoadBoard.token
                },
              contentType: "application/json",
              data: JSON.stringify({ 
                  "user_id": LoadBoard.userid, 
                  "veh_id_no": veh_id_no,
                  "veh_unit":veh_unit ,
                  "veh_make":veh_make,
                  "veh_model":veh_model,
                  "veh_type":veh_type,
                  "veh_weight" :veh_weight,
                  "veh_length" :veh_length,
                  "veh_height" :veh_height,
              }),
              //data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&veh_id_no="+veh_id_no+"&veh_make="+veh_make+"&veh_model="+veh_model+"&veh_type="+veh_type+"&veh_unit="+veh_unit+"&veh_weight="+veh_weight+"&veh_length="+veh_length+"&veh_height="+veh_height,
              success:function(result){
                $("#veh_id_no").val('');
                $("#veh_make").val('');
                $("#veh_model").val('');
                $("#veh_type").val('');
                $("#veh_unit").val('');
                $("#veh_weight").val('');
                $("#veh_length").val('');
                $("#veh_height").val('');
                if(result.status==1){
                  toastr.options = { 
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                  }
                  toastr.success(result.msg);
                  
                  pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                  pickedtable.ajax.reload();
                  //vinnoformat();
                  $("#add_vehicle_tab1").modal("hide");
                } else if(result.status==0){
                  toastr.options = { 
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                  }
                  toastr.error(result.msg);
                  
                  pickedtable.ajax.url(LoadBoard.API+"trucker/upcoming-trips").load();
                  pickedtable.ajax.reload();
                  //vinnoformat();
                }
              }
            });
        }
     });
     // vinnoformat();
  });
  
   function formatPhoneNumber(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
        var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
        if (match) {
            return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
        }
        return null
    }




function vinnoformat(){

  //alert(row.veh_id_no);
  $.ajax({
    type: "post",
    url: LoadBoard.API+'trucker/get-vehicle-details',
    dataType: "json",
    async:false,
    data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
    success: function (result) {
        if(result.status==1){
          for (i = 0; i < result.data.length; i++)
          {  
            $('.vinnodisp').append('<option value="'+result.data[i]["veh_id_no"]+'">'+result.data[i]["veh_id_no"]+'</option>');
          }
        }
    }
  });
}


</script>



  <div class="modal fade  " id="vinno_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2 pop_up_font" id="mySmallModalLabel">Assign Vehicle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
      <input type="hidden" id="veh_id_noval" value="" />
      <input type="hidden" id="load_id" value="" />
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <p>Do you want to assign this vehicle to the load?</p>       
        </div>
    <div class="modal-footer">
      <input type="hidden" id="tabs" value="" />
      <button type="button" class="btn btn-primary vehicle_load">Yes</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
             </div>
    
    </div>
  </div>
</div>







<div class="modal fade" data-backdrop="static" data-keyboard="false" id="add_vehicle_tab1" tabindex="-1" role="dialog" aria-labelledby="cancel_confirm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content"> 
      <div class="modal-header  text-center">
        <h5 class="modal-title" id="mySmallModalLabel">Vehicle Details</h5>
        <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body cancel-trip">
          <form name="form-vehicle-details" id="form-vehicle-details" method="post">
          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Vehicle Identification Number</label>
                 <input type="text" class="form-control" maxlength="17" name="veh_id_no" id="veh_id_no" placeholder="" value="" > 
                 <label id="veh_id_no-error" class="error" for="" style="display: none;"></label>  
              </div>
            </div>
             <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Unit / Truck Number</label>
                 <input type="text" class="form-control" name="veh_unit" id="veh_unit" placeholder="" value="" >   
                 <label id="veh_unit-error" class="error" for="" style="display: none;"></label> 
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Make</label>                        
                <input type="text" id="veh_make" name="veh_make" class="form-control" value="">
                <label id="veh_make-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Model</label>
                 <input type="text" class="form-control" name="veh_model" id="veh_model" placeholder="" value="" > 
                 <label id="veh_model-error" class="error" for="" style="display: none;"></label>   
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Type</label>                        
                <input type="text" name="veh_type" id="veh_type"  class="form-control" value="">
                <label id="veh_type-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
           
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Weight</label>
                 <input type="text" class="form-control" name="veh_weight" maxlength="6" id="veh_weight" placeholder="" value="" >   
                 <label id="veh_weight-error" class="error" for="" style="display: none;"></label> 
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Length</label>                        
                <input type="text" name="veh_length" id="veh_length" maxlength="3"  class="form-control" value="">
                <label id="veh_length-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Height</label>
                 <input type="text" class="form-control" name="veh_height" maxlength="3" id="veh_height" placeholder="" value="" >  
                 <label id="veh_height-error" class="error" for="" style="display: none;"></label>  
              </div>
            </div>
          </div>   
          
          <div class="text-right pr-3 pb-3">
            <button type="button" id="save_vehicle_details" class="btn btn-primary save_vehicle_details">Save </button> 
            <button type="button" id="add_vehicle_details" class="btn btn-primary add_vehicle_details">Save & Add New </button> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>  
          </form>
      </div>
    </div>
  </div>
</div>