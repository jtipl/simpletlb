 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Picked Loads");
$picked = isset($_REQUEST["pi"]) ? $_REQUEST["pi"] : '';
if(!empty($picked)){
  $req = $Global->decode($picked);
  ?>
  <script>
      $(document).ready(function(){
          var operation = '<?php echo $req; ?>';
          $.ajax({
            type:'POST',
            url:LoadBoard.API+'broker/notification-count-view',
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
<style>
.navigation{width: 1244px;}

</style>
<script type="text/javascript">
  $(document).ready(function(){
      var pickedloadscount=0;
      $.ajax({
          type: "post",
          url: LoadBoard.API+'broker/loads-count',
          dataType: "json",
          async:false,
          data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
          success: function (result) {
            if(result.status==1){
              pickedloadscount=result.pickedloadscount;
            }
          }
      });

       var pickedloadscount = pickedloadscount;
        if(pickedloadscount==0){
          $(".export").hide();
        }
       
    $(".export_csv").click(function(){
      var export_page = $("input[name='export_page']:checked").val();
      var user_id = LoadBoard.userid;
      
      var token = LoadBoard.token;
        var total_count = pickedloadscount;
  
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

            var href=LoadBoard.API+"broker/download-excel-current-view-loads?token="+token+"&operation=picked&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"broker/download-excel-all-loads?token="+token+"&operation=picked&length=all&user_id="+user_id;
            window.location.href=href;
          } 
        } 
    });
  });
</script>



  <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
                <i class="icon-Truck mr-2"></i>
         <h1 class="page-title">
          Present Loads
        </h1> 
            </div>            
            

<div class="row animated fadeIn ">
  <div class="col-md-12 accordion" id="accordionExample">
    <div class="lb-tabs">
      <nav>
        <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">
           <a class="nav-item nav-link active" id="nav-trucker-tab" data-toggle="tab" href="#nav-trucker" role="tab" aria-controls="nav-trucker" aria-selected="false"> <i class="icon-PickedLoads"></i> &nbsp;&nbsp; Picked Loads
            &nbsp; &nbsp;
            <span class="tool toottip" style="font-weight: normal;" data-tip="The list of loads that are picked by truckers and on road" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
           </a>    
        </div>
      </nav>


    <div class="tab-content " id="nav-tabContent">
      <div class="tab-pane animated  fadeIn  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <div class="table-responsive">
              <h3 class="dgrid-title" ></h3>
              &nbsp;
              <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
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

                  
                  <!-- Export Excel & PDF  starts here -->  
                    <div class="export">              
                    <?php require_once "export-page.php"; ?>
                    </div>
                    <!-- Export Excel & PDF  ends here -->      
  
    <!-- Export Excel & PDF  ends here -->   
      </div>
    </div>


</div>
</div>
</div>






          </div>
        </div>
    <!--   </div> -->


  


<?php $Global->Footer(); ?>
<script type="text/javascript" language="javascript" >
  
  $(document).ready(function() {
    
       $('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });
      var table = $('#viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." ,"zeroRecords": "No relevant information available" , "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
           dom: 'Bfrtip',
            "ajax": {
             url :LoadBoard.API+'broker/in-progress',
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
              "order": [[ 1, "desc" ]],
              //"order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "dot" }
          
                
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
        targets: 5,
        render: function (data,type,row) {
                 return formatPhoneNumber(row.phone);
                    
                    

                }
      },

       {
        targets: 4,
        render: function (data,type,row) {
            var mystring = row.name.toUpperCase();
                      if(mystring.length > 15){
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...</span></a>';
               } else {
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+mystring+'</a>';
               } 
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
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
    }
        });



function formatPhoneNumber(phoneNumberString) {
  var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
  var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
  if (match) {
    return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
  }
  return null
}


  });
 
      function Ucfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>
