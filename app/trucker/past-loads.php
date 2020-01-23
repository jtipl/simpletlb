 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Past Loads");
$cancelload_encode = isset($_REQUEST["cancelload_encode"]) ? $_REQUEST["cancelload_encode"] : '';
$cancelload_decode = $Global->decode($cancelload_encode);
//echo $cancelload_decode;
if(!empty($cancelload_decode)){
  $req = $cancelload_decode;
}else {
  $req = 0;
}
if($req) { ?>
<script type="text/javascript">
$(document).ready(function(){
  var operation ="<?php echo $cancelload_decode; ?>";
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
        //alert(result.status)
        if(result.status==1){
          $("#nav-trucker-tab").removeClass("active");
          $("#nav-trucker").removeClass("active");
          $("#nav-cancel").addClass("active");
          $("#nav-cancel-tab").addClass("active");
        } else if(result.status==0){

        }
      }
    });
});

</script>
<?php } ?>
<div class="my-3 my-md-5">
  <div class="container animated fadeIn">

 <div class="page-header">
          <h1 class="page-title">
            <!--<i class="fe fe-rotate-ccw mr-2"></i> Awaiting Approval-->
            <i class="icon-PastLoad"></i> Past Loads
          </h1>    
             <!--  &nbsp;&nbsp;
              <span class="tool" data-tip="List of loads that you have finished" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>   -->          
            </div>

    
    <div class="row animated fadeIn ">
      <div class="col-md-12 accordion" id="accordionExample">
        <div class="lb-tabs">
          <nav>
            <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-trucker-tab" data-toggle="tab" href="#nav-trucker" role="tab" aria-controls="nav-trucker" aria-selected="false"> 
             Delivered Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="List of loads that you have finished" tabindex="1" ><i class="icon-DeliveredLoads"></i></span></a>

                  <a class="nav-item nav-link" id="nav-cancel-tab" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="false"> 
        Cancelled Loads &nbsp;&nbsp;<span class="tool" style="font-weight: normal;" data-tip="List of loads that you have confirmed and cancelled" tabindex="1" ><i class="icon-CancelledLoads"></i></span></a>  
             </div>
          </nav>  


          <div class="tab-content " id="nav-tabContent">
            
            <!-- Delivered load-->
            <div class="tab-pane animated  fadeIn  active show" id="nav-trucker" role="tabpanel" aria-labelledby="nav-trucker-tab">
              <div class="table-responsive"> 
                 <h1 class="dgrid-title"> &nbsp;</h1>
                <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                          <th class="index_sort"><div>Load-Id</div></th>
                          <th><div>Origin</div></th>
                          <th><div>Destination</div></th>
                          <th><div>VIN</div></th>
                        
                          <th><div>Broker/Shipper</div></th>
                          <th><div>Price</div></th>
                        </tr>
                    </thead>
                </table> 


              </div>
            </div>
            <!-- Delivered load ends here -->


            <!-- Cancelled load start here-->
            <div class="tab-pane animated fadeIn" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab">
              <div class="table-responsive"> 
              <h1 class="dgrid-title"> &nbsp;</h1>
                  <table id="cancelled_table" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th class="index_sort"><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Weight</div></th>
                            <th><div>Length</div></th>
                            <th><div>Price</div></th>
                            <th><div>Cancelled date</div></th>    
                        </tr>
                    </thead>
                </table>   
              </div>
            </div>
            <!-- Cancelled load ends here-->
            <div class="export_past_loads">
              <?php require_once "export-page.php"; ?>
              <input type="hidden" id="tabsid" value="" />
              <input type="hidden" id="total_count1" value="" />
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      
      
       




<?php $Global->Footer(); ?>
    



<script type="text/javascript">

var tripvar=0;
$(document).ready(function(){
  $('th').on("click", function (event) {
      if($(event.target).is("div"))
          event.stopImmediatePropagation();
  });
      

  $(".export_csv").click(function(){
    var export_page = $("input[name='export_page']:checked").val();
    var user_id = LoadBoard.userid;
    var total_count1 =$("#total_count1").val();
    var total_count = total_count1;
    //alert(total_count)
    if(total_count!=0){
      var tabsid = $("#tabsid").val();
      if(tabsid=="delivered_table"){
        var operation = "delivered";
      }else if(tabsid=="cancelled_table"){
        var operation = "cancel-loads";
      }

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
          var href=LoadBoard.API+"trucker/download-excel-current-view-loads?token="+LoadBoard.token+"&operation="+operation+"&user_id="+user_id+"&start="+start+"&length="+length;
          window.location.href=href;
        }
        else if(export_page=="2"){
          var href=LoadBoard.API+"trucker/download-excel-all-loads?token="+LoadBoard.token+"&operation="+operation+"&length=all&user_id="+user_id;
          window.location.href=href;
        } 
      } 
    });

    


// cancel load starts here
var cancelled_table= $('#cancelled_table').DataTable({
       language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
        "ajax": {
          url: LoadBoard.API+'trucker/cancel-loads',
          type:"post",
          headers: {
            Authorization: "Bearer "+LoadBoard.token
          },
          contentType: "application/json",
          "dataFilter": function(data) {
            var data = JSON.parse(data);
            var rowCount =data.iTotalDisplayRecords;
            if(rowCount==0){
              $("#export").hide();
              $("#cancelled_table_info").hide();
            } else {
              $("#export").show();
              $("#cancelled_table_info").show();
            }
            
            $("#total_count1").val(rowCount);
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
              {"data": "weight"},
              {"data": "length"},
              {"data": "price" },
              {"data": "cancel_date" },
          ],
  columnDefs: [
     {
      targets: 2,
      render: function (data,type,row) {
           var orgt=row.origin.split(",");
           return orgt[0]+", "+orgt[1];
        }
    },
    {
      targets: 3,
      render: function (data,type,row) {
        var dest=row.destination.split(",");
        return dest[0]+", "+dest[1];
      }
    },
    {
     targets: 7,
     render: function (data,type,row) {
       var date=row.cancel_date;
       dateTime = moment(date).format("MM-DD-YYYY HH:mm:ss");
       return(dateTime);
      }
    },
    {
      targets: 6,
      render: function (data,type,row) {
        if(row.suggest_price==0)
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        else
          return  "$"+row.suggest_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
    },
    {
      targets: 0,
      bSortable: false, 
        render: function (data,type,row) {
        return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
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
// cancel load ends here




var delivered_table= $('#viewloads').DataTable({
 language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
    dom: 'Bfrtip',
"ajax": {
  url: LoadBoard.API+'trucker/past-loads',
  type:"post",
  headers: {
     Authorization: "Bearer "+LoadBoard.token
   },
  contentType: "application/json",
  "dataFilter": function(data) {
    var data = JSON.parse(data);
    var rowCount =data.iTotalDisplayRecords;
    //alert(rowCount);
    if(rowCount==0){
      $("#export").hide();
      $("#viewloads_info").hide();
    } else {
      $("#export").show();
      $("#viewloads_info").show();

    }
    $("#total_count1").val(rowCount);
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
      {"data": "veh_id_no"},
      {"data": "business_name"},
      {"data": "price" }
  ],

columnDefs: [
  {
  targets: 5,
  render: function (data,type,row) {
  var favclass="";
  var favcon="";
  if(row.favorite_status==0){
      favclass="star";
      favcon='<span class="tool" data-tip="Mark this broker favorite" tabindex="1" ><a                            class="star btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'" data-broker-id="'+row.broker_id+'" data-shipper-id="'+row.shipper_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
  }else if(row.favorite_status==1){
      favclass="star-fav";
      favcon='<span class="tool" data-tip="Remove from favorite list" tabindex="1" ><a class="star-fav btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'" data-broker-id="'+row.broker_id+'" data-shipper-id="'+row.shipper_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
  }else{
      favclass="star";
      favcon='<span class="tool" data-tip="Mark this broker favorite" tabindex="1" ><a class="star btncursor favclick favorite_'+row.broker_id+' favoritesid_'+row.shipper_id+'" data-broker-id="'+row.broker_id+'" data-shipper-id="'+row.shipper_id+'" data-trucker-id="'+row.trucker_id+'"></a></span>';
  }
  return favcon+'<a class="search_modals" href="javascript:void(0)"  onclick="brokerpopup(\'' + window.btoa(row.broker_id) + '\',\'' + window.btoa(row.shipper_id) + '\')" >'+row.business_name.toUpperCase()+'</a>';
  }
  },
  {
  targets: 2,
  render: function (data,type,row) {
     var orgt=row.origin.split(",");
     return orgt[0]+", "+orgt[1];
  }
  },
  {
  targets: 3,
  render: function (data,type,row) {
    var dest=row.destination.split(",");
    return dest[0]+", "+dest[1];
  }
},
{
targets: 6,
render: function (data,type,row) {
if(row.suggest_price==0)
  return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
else
  return  "$"+row.suggest_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
},
{
targets: 0,
bSortable: false, 
render: function (data,type,row) {
 return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
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
                 delivered_table.ajax.reload();
            }else if(result.status==2){
              window.location.href=LoadBoard.APP+"logout";
            }
          }
        });
    });

    $(document).on("click","#nav-trucker-tab",function(){
       delivered_table.ajax.url(LoadBoard.API+'trucker/past-loads').load();
      // delivered_table.ajax.reload();
    });
    $(document).on("click","#nav-cancel-tab",function(){
       cancelled_table.ajax.url( LoadBoard.API+'trucker/cancel-loads').load();
       //cancelled_table.ajax.reload();
    });

    $("#tabsid").val("delivered_table");
    $(document).on("click",".nav-item",function(){
        var href = $(this).attr("href"); 
        //alert(href)
        if(href=="#nav-trucker"){
          $("#tabsid").val('delivered_table');
        }
        else if(href=="#nav-cancel"){
          $("#tabsid").val('cancelled_table');
        }
    });
});


function jsUcfirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>
