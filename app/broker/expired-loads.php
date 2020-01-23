 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - Expired Loads");
 ?>        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
          <h1 class="page-title">
                <i class="fa fa-history"></i> Past Loads
                <span class="tool toottip" data-tip="The list of loads that have passed the mentioned pickup date and expired" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
              </h1> 
            </div>            
            <div class="row row-cards row-deck">
             <div class="col-12">
                <div class="card">
                
                  <div class="table-responsive">
                    <h3 class="dgrid-title"> Expired Loads 
                    </h3>
                      <!--<h3 class="dgrid-title" style="float: left; position: absolute;left: 20px; top: 0px;"> Past Loads</h3>-->
                      <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                            <th><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Pickup Date</div></th>
                            <th><div>Status</div></th>
                             <th><div>Price</div></th>
                            <!--  <th>Action</th> -->
                        </tr>
                    </thead>
                  </table>   
                  <div class="export">              
                    <?php require_once "export-page.php"; ?>
                    </div>                    
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
       
      var expiredtotalRecords=0;
      $.ajax({
          type: "post",
          url: LoadBoard.API+'broker/loads-count',
          dataType: "json",
          async:false,
          data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
          success: function (result) {
            if(result.status==1){
              expiredtotalRecords=result.expiredtotalRecords;
            }
          }
      });

      var total_count = expiredtotalRecords;
      if(total_count==0){
        $(".export").hide();
      }

      
    $(".export_csv").click(function(){
      var export_page = $("input[name='export_page']:checked").val();
      var user_id = LoadBoard.userid;
      var total_count = expiredtotalRecords;
      //alert(total_count);
      var token = LoadBoard.token;
      if(total_count!=0){
          $(".export").show();
          if(export_page=="1"){
            var pageid = $("li.active > .page-link").attr("data-dt-idx");
            var draw = pageid;
            
            for(var i=1; i <= total_count; i++){
              if(draw==i && i>1){
                var start = ((i-1) * 10);
              } else {
                var start = 0;
              }
            }
            var length = '10';
            var href=LoadBoard.API+"broker/download-excel-current-view-loads?token="+token+"&operation=expired-loads&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"broker/download-excel-all-loads?token="+token+"&operation=expired-loads&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } 
    });

   
      var table = $('#viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." ,"zeroRecords": "No relevant information available" },
            "ajax": LoadBoard.API+'broker/view-loads?user_id='+LoadBoard.userid+'&operation=expired_loads',
             "bLengthChange": false, 
             "type": "POST",
              "bProcessing": false,
              "serverSide": true,
              "bInfo": false,
              "order": [[ 0, "desc" ]],
              "columns": [
              
                 {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "status"},
                {"data": "price" }
              //  {"data": "approve_status" }     
              
              
                
            ],
      columnDefs: [{
       targets: 5,
       render: function (data,type,row) {
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
      },{
        targets: 4,
        render: function (data,type,row) {
            var date = row.pickup_date.split('-');
            return date[1]+'/'+date[2]+'/'+date[0]
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
                 return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    
                    

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
        
        render: function (data,type,row) {
                return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
      }, {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      }
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    }
        });
 table.columns( [5] ).visible( false );

      function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

  });

</script>
