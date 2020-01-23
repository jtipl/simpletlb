 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - Past Loads");
$cancelload_encode = isset($_REQUEST["cancelload_encode"]) ? $_REQUEST["cancelload_encode"] : '';

$cancelload_decode = $Global->decode($cancelload_encode);
 ?>

 <?php if(!empty($cancelload_encode)){ ?>}
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
        if(result.status==1){
          //toastr.success(result.msg);
          window.location.href=link+"#";
             window.onload = function() {
              if(!window.location.hash) {
                  window.location = window.location + '#';
                  window.location.reload();
              }
          } 
        } else if(result.status==0){
          //toastr.error(result.msg);
        }
      }
    });
});


</script>
<?php } ?>
        <div class="my-3 my-md-5">
          <div class="container">
      
 <div class="page-header">
          <h1 class="page-title">
<!--                 <i class="fe fe-rotate-ccw mr-2"></i> Awaiting Approval-->
                <i class="fa fa-history"></i> Past Loads 
              </h1>   
              &nbsp;&nbsp;
              <span class="tool" data-tip="List of loads that you have confirmed and cancelled" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>           
            </div> 
      
      
        <div class="row  animated fadeIn">                                  
              <div class="col-12 accordion"  id="accordionExample">
                <div class="card ">              
                  <div class="table-responsive"> 
                    <h3 class="dgrid-title" > Cancelled Loads &nbsp;&nbsp;</h3>

                     <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Weight</div></th>
                            <th><div>Length</div></th>
                            <th><div>Price</div></th>
                            <th><div>Cancelled date</div></th>    
                        </tr>
                    </thead>
                </table>   
                <?php require_once "export-page.php"; ?>  
                  </div>
                </div>           
              </div>
         </div>
            </div>
        </div>
   <!--    </div> -->
     
    
    


<!-- Modal -->



<?php $Global->Footer(); ?>
    



<script type="text/javascript">
  var tripvar=0;
  $(document).ready(function(){
$('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });
    var cancel_load_count=0;
    $.ajax({
        type: "post",
        url: LoadBoard.API+'trucker/loads-count',
        dataType: "json",
        async:false,
        data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
        success: function (result) {
          if(result.status==1){
            cancel_load_count=result.cancel_load_count;
          }
        }
    });


    var cancel_load_count = cancel_load_count;
    ///alert(delivered_Total_Count);
    if(cancel_load_count==0){
      $("#export").hide();
    } else {
      $("#export").show();
    }

      $(".export_csv").click(function(){
        var export_page = $("input[name='export_page']:checked").val();
        var user_id = LoadBoard.userid;
        var total_count = cancel_load_count;
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
            var href=LoadBoard.API+"trucker/download-excel-current-view-loads?token="+LoadBoard.token+"&operation=cancel-loads&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"trucker/download-excel-all-loads?token="+LoadBoard.token+"&operation=cancel-loads&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } 
    });




    var pickedtable= $('#viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available" },
          "ajax": {
            url: LoadBoard.API+"trucker/cancel-loads"
          },
            "bLengthChange": false, 
            "type": "POST",
            "bProcessing": false,
            "serverSide": true,
            "bInfo": false,
              "order": [[ 0, "desc" ]],
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
    columnDefs: [/*{
       targets: 4,
       render: function (data,type,row) {
                    if (data.status==1) {
                      return '<span class="label label-success">Active</span>';
                    } else {
                      return '<span class="status-icon bg-green"></span>Open';
                    }                    
                }
      },*/
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

  


  });



 
</script>
