 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - Cancelled  Loads");
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '';
$reopen_status = isset($_REQUEST["re"]) ? $_REQUEST["re"] : '';
if(!empty($reopen_status)){
   $req = $Global->decode($_REQUEST['re']);

}
 ?>        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
          <h1 class="page-title">
                <i class="fa fa-history"></i> Past Loads
              </h1> 
            </div>            
            <div class="row row-cards row-deck">
             <div class="col-12">
                <div class="card">
                
                  <div class="table-responsive">
                    <h3 class="dgrid-title"> Cancelled Loads
                      <span class="tool toottip" data-tip="The list of loads that you have approved but cancelled by the Trucker" tabindex="1" ><i class="fa fa-question-circle-o"></i></span>
                    </h3>
                      <!--<h3 class="dgrid-title" style="float: left; position: absolute;left: 20px; top: 0px;"> Past Loads</h3>-->
                      <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                            <th><div>Load-Id</div></th>
                            <th><div>Origin</div></th>
                            <th><div>Destination</div></th>
                            <th><div>Trucker Name</div></th>
                            <th><div>Phone</div></th>
                            <th><div>Cancelled Reason</div></th>
                            <th><div>Cancelled Date</div></th>
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
<script type="text/javascript">
  $(document).ready(function(){

       $('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });
       
      var canceltotalRecords=0;
      $.ajax({
          type: "post",
          url: LoadBoard.API+'broker/loads-count',
          dataType: "json",
          async:false,
          data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
          success: function (result) {
            if(result.status==1){
              canceltotalRecords=result.canceltotalRecords;
            }
          }
      });

     var cancel_load_count = canceltotalRecords;
    // alert(cancel_load_count);
    
     if(cancel_load_count==0){
      $(".export").hide();
     } else {
      $(".export").show();
     }
      
    $(".export_csv").click(function(){
      var export_page = $("input[name='export_page']:checked").val();
      var user_id = LoadBoard.userid;
      var cancel_load_count = canceltotalRecords;
      var token = LoadBoard.token;
      if(cancel_load_count!=0){
          $(".export").show();
          if(export_page=="1"){
            var pageid = $("li.active > .page-link").attr("data-dt-idx");
            var draw = pageid;
            
            for(var i=1; i <= cancel_load_count; i++){
              if(draw==i && i>1){
                var start = ((i-1) * 10);
              } else {
                var start = 0;
              }
            }
            var length = '10';
            var href=LoadBoard.API+"broker/download-excel-current-view-loads?token="+token+"&operation=cancel-loads&user_id="+user_id+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href=LoadBoard.API+"broker/download-excel-all-loads?token="+token+"&operation=cancel-loads&length=all&user_id="+user_id;
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
        }
    });
  });
</script>

<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
     var table = $('#viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." ,"zeroRecords": "No relevant information available"},
            "ajax": LoadBoard.API+'broker/cancel-loads',
             "bLengthChange": false, 
             "type": "POST",
              "processing": true,
              "serverSide": true,
              "bInfo": false,
              //"order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "cancel_reason" },
                {"data": "cancel_date" }
              
              
                
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
                 //  return jsUcfirst(row.name);
                    return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+Ucfirst(row.name)+'</a>';
                      
                      

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
        targets: 0,
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

<!-- var date = new Date('2010-10-11T00:00:00+05:30');
alert((date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear()); -->