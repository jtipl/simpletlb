 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Favorite Truckers");

$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '';
$delivered_encode = isset($_REQUEST["delivered_encode"]) ? $_REQUEST["delivered_encode"] : '';
if(!empty($delivered_encode)){
   $req = $Global->decode($delivered_encode);
   ?>
 <script>
      $(document).ready(function(){
          var operation = '<?php echo $req; ?>';
          $.ajax({
            type:'POST',
            url:LoadBoard.API+'shipper/notification-count-view',
            dataType: 'json',
            data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
            success : function(result){
              if(result.status==1){
               // toastr.success(result.msg);
               // window.location.href=LoadBoard.APP+"shipper/in-progress?picked_encode="+picked_req;
                return true;
              } else if(result.status==0){
                //toastr.error(result.msg);
                return false;
              }
            }
          });
      });
    </script>
   <?php
}

 ?>        
<script type="text/javascript">
  $(document).ready(function() {

      var favouriteTotalrecords=0;
      $.ajax({
          type: "post",
          url: LoadBoard.API+'shipper/loads-count',
          dataType: "json",
          async:false,
          data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
          success: function (result) {
            if(result.status==1){
              favouriteTotalrecords=result.favouriteTotalrecords;
            }
          }
      });


    //alert(favouriteTotalrecords);

    if(favouriteTotalrecords==0){
      $(".export").hide();
    }

    $(".export_csv").click(function(){
        var export_page = $("input[name='export_page']:checked").val();
        var user_id = LoadBoard.userid;
        var total_count = favouriteTotalrecords;
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
            //alert(start);
            var length = '10';
            var href=LoadBoard.API+"shipper/download-favorite-current-view-loads?token="+LoadBoard.token+"&operation=favorite&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"shipper/download-favorite-all-loads?token="+LoadBoard.token+"&operation=favorite&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } 
    });

});
</script>

 <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <i class="icon-Favourite"></i>&nbsp;&nbsp;
          <h1 class="page-title">
                My Favorites
                 <!-- <span class="tool toottip" data-tip="The list of finished loads" tabindex="1" ><i class="fa fa-question-circle-o"></i></span> -->
              </h1> 
            </div>            
            <div class="row row-cards row-deck">
             <div class="col-12">
                <div class="card">
                
                  <div class="table-responsive">
                    <h3 class="dgrid-title"> Favorite Truckers

                    </h3>
                      <!--<h3 class="dgrid-title" style="float: left; position: absolute;left: 20px; top: 0px;"> Past Loads</h3>-->
                      <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th class="index_sort"><div>Trucker Name</div></th>
                            <th><div>Business Name</div></th>
                            <th><div>Email</div></th>
                            <th><div>Phone</div></th>
                        <th><div>USDOT</div></th>
                        </tr>
                    </thead>
                  </table> 
                               
                  </div>
                    <div class="export">
                  <?php require_once "export-page.php"; ?>
                  </div>   
                </div>
           
              </div>
            </div>
          </div>
        </div>
     <!-- Extra div </div>-->


 



<?php $Global->Footer(); ?>
<script type="text/javascript" language="javascript" >
  
  $(document).ready(function() {
   
      $('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });

      
      var table = $('#viewloads').DataTable({
        language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
              "ajax": {
               url:LoadBoard.API+'shipper/trucker-list',
               type:"post",
               headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
               contentType: "application/json",
               "data": function(data){
                data.user_id =LoadBoard.userid
                return   JSON.stringify(data);
               },   
              "dataFilter": function(data) {
                var data = JSON.parse(data);
                var rowCount =data.iTotalDisplayRecords;
                if(rowCount==0){
                  $("#export").hide();
                  $("#viewloads_info").hide();
                } else {
                  $("#export").show();
                    $("#viewloads_info").show();
                }
                $("#total_count").val(rowCount)
                return JSON.stringify(data);
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
              //"order": [[ 0, "desc" ]],
              //"order": [[ 0, "desc" ]],
              "columns": [
                {"data": "name"},
                {"data": "business_name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "dot"}
            ],
    columnDefs: [

     {
        targets: 0,
        render: function (data,type,row) {
          var favclass = "";
                    var favcon = "";
                    if (row.status == 0) {
                        favclass = "star";
                        favcon = '<span class="tool" data-tip="Mark this trucker favorite" tabindex="1" ><a class="star btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    } else if (row.status == 1) {
                        favclass = "star-fav";
                        favcon = '<span class="tool" data-tip="Remove from favorite list" tabindex="1" ><a class="star-fav btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    } else {
                        favclass = "star";
                        favcon = '<span class="tool" data-tip="Mark this trucker favorite" tabindex="1" ><a class="star btncursor favclick favorite_' + row.trucker_id + '" data-shipper-id="' + row.shipper_id + '" data-trucker-id="' + row.trucker_id + '"></a></span>';
                    }
                    return favcon + '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >' + Ucfirst(row.name) + '</a>';
               // return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+Ucfirst(row.name)+'</a>';
        }
      },
      {
        targets: 1,
        render: function (data,type,row) {
          var mystring = row.business_name.toUpperCase();
          if(mystring.length > 50){
            return '<span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,50)+'...</span>';
          } else {
            return mystring;
          }  
        }
      },
        {
        targets: 3,
        render: function (data,type,row) {
                 return formatPhoneNumber(row.phone);
                    
                    

                }
      },
      
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    }
});


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
     //alert(".favorite_"+bid);
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
                table.ajax.reload();
            } else if (result.status == 2) {
                window.location.href = LoadBoard.APP + "logout";
            }
        }
    });
});



function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

});





function Ucfirst(string) 
{
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
</script>
