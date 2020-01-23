 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Past Loads");
$delivered_encode = isset($_REQUEST["dli"]) ? $_REQUEST["dli"] : '';

$denied_loads = isset($_REQUEST["de"]) ? $_REQUEST["de"] : '';
$pi = isset($_REQUEST["pi"]) ? $_REQUEST["pi"] : '';
$pi_decode = $Global->decode($pi);
$de_decode = $Global->decode($delivered_encode);

if(!empty($pi_decode)){
  $req = $pi_decode;
}
else if(!empty($de_decode)){
  $req = $de_decode;
}
else {
  $req = '0';
}
//echo $req;
?>
      <div class="my-3 my-md-5">
          <div class="container animated fadeIn">
            <div class="page-header">
              <i class="icon-PastLoad"></i>&nbsp;
          <h1 class="page-title">
                Past Loads
              </h1> 
            </div>   

    <div class="row animated fadeIn ">
    
    <div class="col-md-12 accordion" id="accordionExample">
<div class="lb-tabs">
  <nav>
    <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">

      <a class="nav-item nav-link active" id="nav-trucker-tab" data-toggle="tab" href="#nav-trucker" role="tab" aria-controls="nav-trucker" aria-selected="false"> 
       <i class="icon-DeliveredLoads"></i> &nbsp;  Delivered Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="The list of finished loads" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>    

      <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> 
         <i class="icon-ExpiredLoads"></i>&nbsp;
         Expired Loads  &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="The list of loads that have passed the mentioned pickup date and expired" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>

      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> 
        <i class="icon-CancelledLoads"></i> &nbsp;
        Cancelled Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="The list of loads that you have approved but cancelled by the Trucker" tabindex="1" ><i class="fa fa-question-circle-o"></i></span></a>    
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
                            <th><div>Pickup Date</div></th>
                            <th><div>Status</div></th>
                             <th><div>Price</div></th>
                           
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
                            <th><div>Trucker Name</div></th>
                            <th><div>Phone</div></th>
                            <th><div>Cancelled Reason</div></th>
                            <th><div>Cancelled Date</div></th>
                           
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
                            <th><div>Trucker Name</div></th>
                        <th><div>Phone</div></th>
                        <th><div>USDOT</div></th>
                           
                        </tr>
                    </thead>
                </table>   
                  </div>
  </div>
    
  
  
  
   <?php require_once "export-page.php"; ?>  
   <input type="hidden" id="tabsid" value="" />
   <input type="hidden" id="total_count1" value="" /> 

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



var tripvar = 0;
var tripvar_in = 0;
var tripvar_awating = 0;
var common_operation = "expired_loads";
$(document).ready(function() {

    $('th').on("click", function(event) {
        if ($(event.target).is("div"))
            event.stopImmediatePropagation();
    });




    $(".export_csv").click(function() {
        var export_page = $("input[name='export_page']:checked").val();
        var user_id = LoadBoard.userid;
        var tabsid = $("#tabsid").val();
        //alert(tabsid)
        if (tabsid == "delivered_table") {
            var operation = "delivered";
        } else if (tabsid == "expiredloads") {
            var operation = "expired-loads";
        } else if (tabsid == "cancelloads") {
            var operation = "cancel-loads";
        }

        var total_count1 = $("#total_count1").val();
        var total_count = total_count1;
       // alert(total_count);
        if (total_count != 0) {
            $("#export").show();
            if (export_page == "1") {
                var pageid = $("li.active > .page-link").attr("data-dt-idx");
                var draw = pageid;
                for (var i = 1; i <= total_count; i++) {
                    if (draw == i && i == 1) {
                        var start = 0;
                    } else if (draw == i && i > 1) {
                        var start = ((i - 1) * 10);
                    }
                }
                var length = '10';
                var href = LoadBoard.API + "shipper/download-excel-current-view-loads?token=" + LoadBoard.token + "&operation=" + operation + "&user_id=" + user_id + "&start=" + start + "&length=" + length;
                window.location.href = href;
            } else if (export_page == "2") {
                var href = LoadBoard.API + "shipper/download-excel-all-loads?token=" + LoadBoard.token + "&operation=" + operation + "&length=all&user_id=" + user_id;
                window.location.href = href;
            }
        }
    });




    var expiredloads = $('#viewloads').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Search for...",
            "zeroRecords": "No relevant information available",
            "sInfo": " _START_ - _END_ of _TOTAL_ ",
            "infoFiltered": ""
        },
        dom: 'Bfrtip',


        "ajax": {
            url: LoadBoard.API + 'shipper/view-loads',
            type: "post",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            contentType: "application/json",
            "dataFilter": function(data) {

                var data = JSON.parse(data);
                var rowCount = data.iTotalDisplayRecords;
                if (rowCount == 0) {
                    $("#export").hide();
                    $("#viewloads_info").hide();
                } else {
                    $("#export").show();
                    $("#viewloads_info").show();
                }
                $("#total_count").val(rowCount);
                if (data.status == 2) {
                    window.location.href = LoadBoard.APP + "logout";
                } else {
                    return JSON.stringify(data);
                }

            },
            "data": function(data) {
                data.user_id = LoadBoard.userid;
                data.operation = common_operation;
                return JSON.stringify(data);
            },
        },


        "bLengthChange": false,
        "type": "POST",
        "showNEntries": false,
        //"bInfo":false,
        "bPaginate": true,
        "bProcessing": false,
        "bServerSide": true,
        "bSortable": false,
        "bAutoWidth": false,
        "order": [
            [1, "desc"]
        ],
        "columns": [

            {
                "data": "id"
            },
            {
                "data": "load_id"
            },
            {
                "data": "origin"
            },
            {
                "data": "destination"
            },
            {
                "data": "pickup_date"
            },
            {
                "data": "status"
            },
            {
                "data": "price"
            }
        ],
        columnDefs: [{
                targets: 5,
                render: function(data, type, row) {
                    /*if (row.status==1) {
                      return '<button data-id="'+row.id+'" type="button" class=" btn-primary approve_modal">APPROVE</button>';
                    } else {
                      return '<span class="status-icon bg-green"></span>Open';
                    } */

                    return '<span class="status-icon bg-red"></span>Expired';
                    /* if (row.status==0) {
                       return '<span class="status-icon bg-red "></span>Open for Trucker';
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
                     }  */
                }
            }, {
                targets: 4,
                render: function(data, type, row) {
                    var date = row.pickup_date.split('-');
                    return date[1] + '/' + date[2] + '/' + date[0]
                }
            },

            {
                targets: 2,
                render: function(data, type, row) {
                    var orgt = row.origin.split(",");

                    return orgt[0] + ", " + orgt[1];

                }
            },
            {
                targets: 3,
                render: function(data, type, row) {
                    var dest = row.destination.split(",");
                    return dest[0] + ", " + dest[1];

                }
            },
            {
                targets: 6,
                render: function(data, type, row) {
                    return "$" + row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                }
            },
            /*   {
                targets: 7,
                render: function (data,type,row) {

                            if(row.approve_status==1){
                              return '<button data-id="'+row.id+'" type="button" class=" btn-primary approve_modal btn-sm" data-origin="'+window.btoa(row.origin)+'"  data-des="'+window.btoa(row.destination)+'" data-loadid="'+window.btoa(row.load_id)+'" data-price="'+window.btoa(row.price)+'">APPROVE</button>';
                            }else if(row.approve_status==2){
                              return '<button  type="button"  class="disabled btn-secondary btn-sm btndis" >APPROVE</button>';
                            }else{
                              return '<button  type="button"   class=" disabled btn-secondary btn-sm btndis" >APPROVE</button>';
                            }

                        }
              },*/

            {
                targets: 0,
                bSortable: false,

                render: function(data, type, row) {
                    
                    return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
            }, {
                targets: 1,
                render: function(data, type, row) {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >' + row.load_id + '</a>';

                }
            }

        ],
        "drawCallback": function() {
            $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        }
    });

    $(document).on("click", ".trip_pick", function() {
        tripvar = $(this).attr("data-tr");
        $("#upcom_status").modal("show");
    });

    $(document).on("click", ".tripca", function() {
        $(".preloader").show();
        $(".tripca").attr("disabled", true);
        $.ajax({
            type: 'post',
            url: LoadBoard.API + 'trucker/trip-picked',
            dataType: "json",
            data: {
                "tripid": window.atob(tripvar),
                "token": LoadBoard.token
            },
            success: function(result) {
                $(".tripca").attr("disabled", false);
                if (result.status == 1) {
                    $(".preloader").hide();
                    toastr.options = {
                        "progressBar": true,
                        "positionClass": "toast-top-full-width",
                        "timeOut": "2000",
                        "extendedTimeOut": "1000",
                    }
                    toastr.success(result.msg);
                    $("#upcom_status").modal("hide");
                    pickedtable.ajax.reload();
                } else if (result.status == 2) {
                    window.location.href = LoadBoard.APP + 'logout';
                }
            }

        });
    });


    //In progress 
    var cancelloads = $('#proviewloads').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Search for...",
            "zeroRecords": "No relevant information available",
            "sInfo": " _START_ - _END_ of _TOTAL_ ",
            "infoFiltered": ""
        },
        dom: 'Bfrtip',
        "ajax": {
            url: LoadBoard.API + 'shipper/cancel-loads', //?user_id='+LoadBoard.userid,
            type: "post",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            contentType: "application/json",
            "dataFilter": function(data) {
                
                var data = JSON.parse(data);
                var rowCount = data.iTotalDisplayRecords;
                if (rowCount == 0) {
                    $("#export").hide();
                    $("#proviewloads_info").hide();
                } else {
                    $("#export").show();
                    $("#proviewloads_info").show();
                }
                $("#total_count").val(rowCount)
                return JSON.stringify(data);
            },
            "data": function(data) {
                data.user_id = LoadBoard.userid
                return JSON.stringify(data);
            },
        },
        "bLengthChange": false,
        "type": "POST",
        "showNEntries": false,
        //"bInfo":false,
        "bPaginate": true,
        "bProcessing": false,
        "bServerSide": true,
        "bSortable": false,
        "bAutoWidth": false,
        "order": [[ 1, "desc" ]],
        "columns": [{
                "data": "id"
            },
            {
                "data": "load_id"
            },
            {
                "data": "origin"
            },
            {
                "data": "destination"
            },
            {
                "data": "name"
            },
            {
                "data": "phone"
            },
            {
                "data": "cancel_reason"
            },
            {
                "data": "cancel_date"
            }



        ],
        columnDefs: [{
                targets: 2,
                render: function(data, type, row) {
                    var orgt = row.origin.split(",");

                    return orgt[0] + ", " + orgt[1];

                }
            },
            {
                targets: 3,
                render: function(data, type, row) {
                    var dest = row.destination.split(",");
                    return dest[0] + ", " + dest[1];

                }
            },
            {
                targets: 5,
                render: function(data, type, row) {
                    return formatPhoneNumber(row.phone);



                }
            },
            {
                targets: 4,
                render: function(data, type, row) {
                    var mystring = row.name.toUpperCase();
                      if(mystring.length > 15){
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >' + mystring.substring(0,15) + '...</span></a>';
                  } else {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >' + mystring + '</a>';
                  }


                }
            },
            {
                targets: 7,
                render: function(data, type, row) {
                    var date = row.cancel_date;
                    dateTime = moment(date).format("MM-DD-YYYY HH:mm:ss");
                    return (dateTime);

                }
            },

            {
                targets: 0,
                bSortable: false,
                render: function(data, type, row) {
                    return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
            }, {
                targets: 1,
                render: function(data, type, row) {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >' + row.load_id + '</a>';

                }
            }

        ],
        "drawCallback": function() {
            $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        }
    });



    $(document).on("click", ".pro_trip_pick", function() {
        tripvar_in = $(this).attr("data-tr");
        $("#por_upcom_status").modal("show");
    });


    $(document).on("click", ".pro_tripca", function() {
        $(".preloader").show();
        $(".pro_tripca").attr("disabled", true);
        $.ajax({
            type: 'post',
            url: LoadBoard.API + 'trucker/trip-delivered',
            dataType: "json",
            data: {
                "tripid": window.atob(tripvar_in),
                "token": LoadBoard.token
            },
            success: function(result) {
                $(".pro_tripca").attr("disabled", false);
                if (result.status == 1) {
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
                } else if (result.status == 2) {
                    window.location.href = LoadBoard.APP + 'logout';
                }
            }

        });
    });


    //Delivered Load
    var delivered_table = $("#awa_viewloads").DataTable({
        language: {
            search: "",
            searchPlaceholder: "Search for...",
            "zeroRecords": "No relevant information available",
            "sInfo": " _START_ - _END_ of _TOTAL_ ",
            "infoFiltered": ""
        },
        dom: 'Bfrtip',
        "ajax": {
            url: LoadBoard.API + 'shipper/past-loads',
            type: "post",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            contentType: "application/json",
            "dataFilter": function(data) {
             
                var data = JSON.parse(data);
                var rowCount = data.iTotalDisplayRecords;
                if (rowCount == 0) {
                    $("#export").hide();
                    $("#awa_viewloads_info").hide();

                } else {
                    $("#export").show();
                    $("#awa_viewloads_info").show();

                }
                $("#total_count1").val(rowCount)
                return JSON.stringify(data);
            },
            "data": function(data) {
                data.user_id = LoadBoard.userid
                return JSON.stringify(data);
            },
        },
        "bLengthChange": false,
        "type": "POST",
        "showNEntries": false,
        //"bInfo":false,
        "bPaginate": true,
        "bProcessing": false,
        "bServerSide": true,
        "bSortable": false,
        "bAutoWidth": false,
        "order": [
            [1, "desc"]
        ],
        //"order": [[ 0, "desc" ]],
        "columns": [{
                "data": "id"
            },
            {
                "data": "load_id"
            },
            {
                "data": "origin"
            },
            {
                "data": "destination"
            },
            {
                "data": "name"
            },
            {
                "data": "phone"
            },
            {
                "data": "dot"
            }
        ],
        columnDefs: [{
                targets: 2,
                render: function(data, type, row) {
                    var orgt = row.origin.split(",");
                    return orgt[0] + ", " + orgt[1];
                }
            },
            {
                targets: 3,
                render: function(data, type, row) {
                    var dest = row.destination.split(",");
                    return dest[0] + ", " + dest[1];
                }
            },
            {
                targets: 5,
                render: function(data, type, row) {
                    return formatPhoneNumber(row.phone);
                }
            },
            {
                targets: 4,
                render: function(data, type, row) {
                    var favclass = "";
                    var favcon = "";
                    if (row.favorite_status == 0) {
                        favclass = "star";
                        favcon = '<span class="tool" data-tip="Mark this trucker favorite" tabindex="1" ><a class="star btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    } else if (row.favorite_status == 1) {
                        favclass = "star-fav";
                        favcon = '<span class="tool" data-tip="Remove from favorite list" tabindex="1" ><a class="star-fav btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    } else {
                        favclass = "star";
                        favcon = '<span class="tool" data-tip="Mark this trucker favorite" tabindex="1" ><a class="star btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    }
                    var mystring = row.name.toUpperCase();
                    if(mystring.length > 15){
                     return favcon + '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >' + mystring.substring(0,15) + '...</span></a>';
                    } else {
                      return favcon + '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >' + mystring + '</a>';
                    }
                    //return favcon + '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >' + Ucfirst(row.name) + '</a>';
                }
            },
            {
                targets: 0,
                bSortable: false,
                render: function(data, type, row) {
                    return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
            },
            {
                targets: 1,
                render: function(data, type, row) {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >' + row.load_id + '</a>';
                }
            }
        ],
        "drawCallback": function() {
            $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        }
    });

    //Denied Loads
    var denied_loads = $('#denied_loads').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Search for...",
            "zeroRecords": "No relevant information available"
        },
        "ajax": {
            url: LoadBoard.API + "trucker/denied-loads"
        },
        "bLengthChange": false,
        "type": "POST",
        "bProcessing": false,
        "serverSide": true,
        "bInfo": false,
        "order": [
            [1, "desc"]
        ],
        "columns": [{
                "data": "tripid"
            },
            {
                "data": "load_id"
            },
            {
                "data": "origin"
            },
            {
                "data": "destination"
            },
            {
                "data": "price"
            },
            {
                "data": "business_name"
            },
            {
                "data": "phone"
            },
            {
                "data": "tripstatus"
            },


        ],
        columnDefs: [{
                targets: 2,
                render: function(data, type, row) {
                    var orgt = row.origin.split(",");
                    return orgt[0] + ", " + orgt[1];
                }
            },
            {
                targets: 3,
                render: function(data, type, row) {
                    var dest = row.destination.split(",");
                    return dest[0] + ", " + dest[1];
                }
            },
            {
                targets: 5,
                render: function(data, type, row) {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\')" >' + row.business_name.toUpperCase() + '</a>';
                }
            },
            {
                targets: 6,
                render: function(data, type, row) {
                    return formatPhoneNumber(row.phone);
                }
            },
            {
                targets: 4,
                render: function(data, type, row) {
                    return "$" + row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                }
            },
            {
                targets: 7,
                "visible": false,
                bSortable: false,
                render: function(data, type, row) {
                    return '-';
                }
            },
            {
                targets: 0,
                bSortable: false,
                render: function(data, type, row) {
                    return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';

                }
            },
            {
                targets: 1,
                render: function(data, type, row) {
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >' + row.load_id + '</a>';

                }
            }
        ],

    });



    $(document).on("click", "#nav-home-tab", function() {
        common_operation = "expired_loads";
        expiredloads.ajax.url(LoadBoard.API + 'shipper/view-loads').load();
    });
    $(document).on("click", "#nav-profile-tab", function() {
        cancelloads.ajax.url(LoadBoard.API + 'shipper/cancel-loads').load();

    });
    $(document).on("click", "#nav-trucker-tab", function() {
        delivered_table.ajax.url(LoadBoard.API + "shipper/past-loads").load();
    });

    // alert(awaitingTotalrecords);

    $("#tabsid").val('delivered_table');
    $(document).on("click", ".nav-item", function() {
        var href = $(this).attr("href");

        if (href == "#nav-trucker") {
            $("#tabsid").val('delivered_table');
        } else if (href == "#nav-home") {
            $("#tabsid").val('expiredloads');
        } else if (href == "#nav-profile") {
            $("#tabsid").val('cancelloads');
        }
    });




    var denied = "<?php echo $denied_loads; ?>";
    var pi_decode = "<?php echo $pi_decode; ?>";

    if (denied != '') {
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");
        $("#nav-denied-tab").addClass("active");

        $("#nav-denied").addClass("active");
        $("#nav-trucker").removeClass("active");
        $("#nav-home").removeClass("active");
        $("#nav-profile").removeClass("active");
        //denied_loads.ajax.reload(); 
    } else if (pi_decode != "") {
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-home-tab").addClass("active");
        $("#nav-profile-tab").removeClass("active");
        $("#nav-denied-tab").removeClass("active");

        $("#nav-denied").removeClass("active");
        $("#nav-trucker").removeClass("active");
        $("#nav-home").addClass("active");
        $("#nav-profile").removeClass("active");


    } else {
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
    var reload = getUrlParameter('pro');

    if (reload != undefined && reload != 'undefined') {
        if (window.atob(reload) == 'upcoming') {

            $("#nav-trucker-tab").removeClass("active");
            $("#nav-home-tab").addClass("active");
            $("#nav-profile-tab").removeClass("active");
            $("#nav-denied-tab").removeClass("active");

            $("#nav-denied").removeClass("active");
            $("#nav-trucker").removeClass("active");
            $("#nav-home").addClass("active");
            $("#nav-profile").removeClass("active");

        }
        if (window.atob(reload) == 'awaiting') {
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

    $(document).on("click", ".favclick", function() {
        var tid = $(this).attr("data-trucker-id");
        var bid = $(this).attr("data-shipper-id");
        //alert(bid); alert(tid);
        var fav = 0;
        if ($(".favorite_" + tid).hasClass("star")) {
            fav = 1;
        } else if ($(".favorite_" + tid).hasClass("star-fav")) {
            fav = 0;
        }
        // alert(".favorite_"+bid);
        $.ajax({
            type: 'post',
            url: LoadBoard.API + 'shipper/favorite',
            dataType: "json",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            data: JSON.stringify({
                "user_id": LoadBoard.userid,
                "trucker_id": tid,
                "shipper_id": bid,
                "favorite_status": fav,
            }),
            contentType: "application/json",
            success: function(result) {
                if (result.status == 1) {
                    if ($(".favorite_" + bid).hasClass("star")) {
                        $(".favorite_" + bid).removeClass("star");
                        $(".favorite_" + bid).addClass("star-fav");
                    } else if ($(".favorite_" + bid).hasClass("star-fav")) {
                        $(".favorite_" + bid).removeClass("star-fav");
                        $(".favorite_" + bid).addClass("star");
                    }
                    delivered_table.ajax.reload();
                } else if (result.status == 2) {
                    window.location.href = LoadBoard.APP + "logout";
                }
            }
        });

    });




});

function Ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function formatPhoneNumber(phoneNumberString) {
    var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
    var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
    if (match) {
        return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
    }
    return null
}

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}



function vinnoformat() {
    $.ajax({
        type: "post",
        url: LoadBoard.API + 'trucker/get-vehicle-details',
        dataType: "json",
        async: false,
        data: "token=" + LoadBoard.token + "&user_id=" + LoadBoard.userid,
        success: function(result) {
            if (result.status == 1) {
                for (i = 0; i < result.data.length; i++) {
      
                    $('.vinnodisp').append('<option value="' + result.data[i]["id"] + '">' + result.data[i]["veh_id_no"] + '</option>');
                }
            }
        }
    });
}

</script>
<?php if($req) { ?>
<script type="text/javascript">
$(document).ready(function(){
  var operation ="<?php echo $req; ?>";
 // alert(operation);
   $.ajax({
      type:'POST',
      url:LoadBoard.API+'trucker/notification-count-view',
      dataType: 'json',
      data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
      success : function(result){
        if(result.status==1){
          if(result.msg=="denied Load Viewed Successfully"){
             $("#tabsid").val('denied-loads');
          } else if(result.msg=="Upcoming Trips Load Viewed Successfully"){
            $("#tabsid").val('upcoming-trips');
          }
        }
      }
  });
});
</script>
<?php } ?>




<?php if(!empty($delivered_encode)){
$req = $Global->decode($delivered_encode);?>
 <script>
      $(document).ready(function(){
          var operation = '<?php echo $req; ?>';
          $.ajax({
            type:'POST',
            url:LoadBoard.API+'shippper/notification-count-view',
            dataType: 'json',
            data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
            success : function(result){
              if(result.status==1){
               // toastr.success(result.msg);
               // window.location.href=LoadBoard.APP+"broker/in-progress?picked_encode="+picked_req;
                return true;
              } else if(result.status==0){
                //toastr.error(result.msg);
                return false;
              }
            }
          });
      });
    </script>
<?php } ?> 