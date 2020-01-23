 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB -  Recently Viewed Loads");

?>      
<script type="text/javascript">
  $(document).ready(function() {
    $(".export_csv").click(function(){
        var export_page = $("input[name='export_page']:checked").val();
        var user_id = LoadBoard.userid;
        var total_count = $("#total_count").val();
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
            var href=LoadBoard.API+"trucker/download-excel-current-view-loads?token="+LoadBoard.token+"&operation=recent_viewloads&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"trucker/download-excel-all-loads?token="+LoadBoard.token+"&operation=recent_viewloads&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } 
    });

});
</script>

 <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
          <h1 class="page-title">
                <i class="fe fe-check-circle"></i> Recently Viewed Loads
                 <!-- <span class="tool toottip" data-tip="The list of finished loads" tabindex="1" ><i class="fa fa-question-circle-o"></i></span> -->
              </h1> 
            </div>            
            <div class="row row-cards row-deck">
             <div class="col-12">
                <div class="card">
                
                  <div class="table-responsive">
                    <h3 class="dgrid-title"> Loads Listing

                    </h3>
                      <!--<h3 class="dgrid-title" style="float: left; position: absolute;left: 20px; top: 0px;"> Past Loads</h3>-->
                      <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th><div>Load-id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Pickup date</div></th>
                            <th><div>Delivery date</div></th>
                            <th><div>Equipment</div></th>
                            <th><div>Price</div></th>
                        </tr>
                    </thead>
                  </table> 
                                 
                  </div>
                  <div class="export">
                  <?php require_once "export-page.php"; ?>
                   
                  <input type="hidden" id="total_count" value="" />

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
               url:LoadBoard.API+'trucker/view-list',
               type:"post",
               headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
               "data": function(data){
                 data.user_id =LoadBoard.userid
                return  JSON.stringify(data);
               },   
              contentType: "application/json",
              "dataFilter": function(data) {
                var data = JSON.parse(data);
                var rowCount =data.iTotalDisplayRecords;
                //alert(rowCount)
                if(rowCount==0){
                  $("#export").hide();
                } else {
                  $("#export").show();
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
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "delivery_date"},
                {"data": "truck_name"},
                {"data": "price"},
            ],
    columnDefs: [

     {
      targets: 1,
      render: function (data,type,row) {
           var orgt=row.origin.split(",");
           return orgt[0]+", "+orgt[1];
        }
    },
      {
      targets: 2,
      render: function (data,type,row) {
        var dest=row.destination.split(",");
        return dest[0]+", "+dest[1];
      }
    },

 {
      targets: 0,
        render: function (data,type,row) {
          return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';
        }
    },

     
       {
        targets: 6,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      },

       
      
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    }
        });

      

       $(document).on("click", "#clear_loads", function() {
         swal.fire({
                    title: "Confirmation!",
                    text: "Do you want to clear the loads?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonClass: 'btn-md',
                    cancelButtonClass: 'btn-md',
                    showCloseButton: true,
                    allowOutsideClick: false,
                }).then(result => {
                    //alert(result.value);
                  if (result.value == true) {
                      
                   $.ajax({
                    type: 'post',
                    url: LoadBoard.API + 'trucker/clear-loads',
                    dataType: "json",
                    headers: {
                        Authorization: "Bearer " + LoadBoard.token
                    },
                    data: JSON.stringify({
                        "user_id": LoadBoard.userid
                    }),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                            }
                            toastr.success(result.msg);
                            table.ajax.reload();
                        }
                    }
                })


                    }
                });
                 $("body").removeClass("swal2-height-auto");
        
    });

  });




</script>
