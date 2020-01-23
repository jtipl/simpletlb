 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '';
$expire_req = isset($_REQUEST["e"]) ? $_REQUEST["e"] : '';
$awaiting_req = isset($_REQUEST["a"]) ? $_REQUEST["a"] : '';
$ready_pickup = isset($_REQUEST["r"]) ? $_REQUEST["r"] : '';
$reopen_status = isset($_REQUEST["re"]) ? $_REQUEST["re"] : '';
$load_id=isset($_REQUEST['load_id'])? $_REQUEST['load_id'] :0;
if(!empty($expire_req)){
   $req = $Global->decode($_REQUEST['e']);
   $heading = 'Loads To Be Expired';
}elseif(!empty($awaiting_req)){
   $req = $Global->decode($_REQUEST['a']);
   $heading = 'Loads Awaiting For Approval';
}elseif(!empty($ready_pickup)){
   $req = $Global->decode($_REQUEST['r']);
   $heading = 'Ready For Pickup';
}elseif(!empty($reopen_status)){
   $req = $Global->decode($_REQUEST['re']);
}else{
   $heading = 'Pending loads';
   $req='pending';
}
$Global->Header("LoadBoard - Open Loads");

$sel = $Global->db->prepare("SELECT count(*) as allcount 
FROM loads WHERE user_id=:user_id AND pickup_date >= CURRENT_DATE AND status=0");
$sel->execute(array("user_id"=>$user_id));
$records =$sel->fetch(PDO::FETCH_ASSOC);
$openloadscount = $records['allcount'];




?>


<div class="my-3 my-md-5">
    <div class="container animated fadeIn">
      <div class="page-header">
         <h1 class="page-title">
          <i class="fe fe-truck mr-2"></i> Present Loads
        </h1> 
      </div>   

<div class="row animated fadeIn ">
  <div class="col-md-12 accordion" id="accordionExample">
    <div class="lb-tabs">
      <nav>
        <div class="nav lb-nav-tabss sm" id="nav-tab" role="tablist">
           <a class="nav-item nav-link active" id="nav-trucker-tab" data-toggle="tab" href="#nav-trucker" role="tab" aria-controls="nav-trucker" aria-selected="false"> <i class="fe fe-truck mr-2" ></i> Open Loads</a>    
                 <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> <i class="fa fa-warning mr-2" ></i> Expiring Loads</a>     

          <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <i class=" fe fe-rotate-ccw mr-2" ></i> Awaiting Approval</a>
           <a class="nav-item nav-link " id="nav-ready" data-toggle="tab" href="#nav-ready" role="tab" aria-controls="nav-ready" aria-selected="true"> <i class=" fe fe-truck mr-2" ></i> Ready for Pickup</a>

        </div>
      </nav>


  <div class="tab-content " id="nav-tabContent">
    <div class="tab-pane animated  fadeIn  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="table-responsive">
       <h4 class="dgrid-title">&nbsp; </h4>
        <table id="viewloads" class="viewloads table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
        <thead>
          <tr>
              <th></th>
              <th>Load-Id</th>
              <th>Origin</th>
              <th>Destination</th>
              <th>Pickup Date</th>
              <th>Status</th>
              <th>Price</th>
              <th class="last_column"></th>
              <th>Trucker Name</th>
          </tr>
      </thead>
    </table>                    
    </div>

    <!-- Export Excel & PDF starts here -->  
    <div class="export">              
    <?php require_once "export_page.php"; ?>
    </div>
    <!-- Export Excel & PDF  ends here -->   
</div>
    
  
  
  
     

   
    
  
  
  
  
  
</div>
</div>


</div> 

</div>

</div>
</div>
<!-- </div> -->
     
  <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="approve" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content"> 
  <div class="modal-header text-center">
        <div class="modal-title  " id="mySmallModalLabel">Approve Trucker


        </div>
        <button type="button" class="close approve_close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
      <div class="modal-body ap">
      <div class="table-responsive"> 
         <h1 class="dgrid-title">&nbsp;</h1>

        <table class="table table-striped table-bordered table-sm pag table-hover card-table table-vcenter text-nowrap approvel_loads" width="100%"  >
          <thead>
            <tr>
                <th>NAME</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>USDOT</th>
                <th>ACTION</th> 
            </tr>
          </thead>
          <tbody class="appcls">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  </div>     
  

   <div class="modal fade  " id="trucker_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header " style="text-align: center;">
        <div class="modal-title" id="mySmallModalLabel">Confirm Trucker</div>
        <button type="button" class="close approve_close " data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center ">
     <div class="avatar avatar-lime avatar-xl  mb-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h4>Do you want to Approve the trucker <b id="tconfirm_name" class=" text-primary">Trucker()</b> for shipping the load?</h4>    
       
      <div class="quoted ">
    <ul class="ap-loads">
    <li>
      <div class="col-lg-12">
        <table>
            <tr>
              <td><b>Quoted Price</b>  <span class="quoted_price to_price"></span>&nbsp;</td>
              <td>&nbsp;<a href="javascript:void(0);" id="editlink" class="">Update</a> </td>
              <td><div id="editprice" style="display: none;" class="qprice"> </div></td>
            </tr>
        </table>
      </div>
      <!--
      <b>Quoted Price</b>  <span class="quoted_price to_price"></span> 
      &nbsp;&nbsp;
      <a href="javascript:void(0);" id="editlink" class="">Update</a>  
      -->
     </li>
   <!-- <li><div id="editprice" style="display: none;" class="qprice"> </div></li> -->
    <li class="comment"> <b>Comments </b> <textarea class="form-control form-control-sm suggest_comments"  rows="4" cols="3" ></textarea></li> 
     <li><div id="" style="display: none;" class="qcomment error">Please enter 100 characters        
      </div></li>
    </ul>   
      </div> 

    <div class="mt-3">
                 <input type="hidden" value="" id="tload_id"> 
        <button type="button" class="btn btn-secondary tcancel mr-4  " data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary tconfirm">Confirm </button></div>    
      
        </div>

    
    </div>
  </div>
</div>  


<!-- Modal -->



    
<div class="modal fade " id="upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title h2" id="mySmallModalLabel">Status Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h2 class="text-cyan ">Load Picked</h2>
        <p>Are you sure you want to change Status <strong>Load Picked?</strong></p>       
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary tripca">Save changes</button>      </div>
    
    </div>
  </div>
</div>
<div class="modal fade " id="por_upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title h2" id="mySmallModalLabel">Status Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h2 class="text-cyan ">Load Delivered</h2>
        <p>Are you sure you want to change Status <strong>Load Delivered?</strong></p>       
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary pro_tripca">Save changes</button>      </div>
    
    </div>
  </div>
</div>



<?php $Global->Footer(); 

$openloadssel = $Global->db->prepare("SELECT count(*) as allcount 
FROM loads WHERE user_id=:user_id AND status=0");
$openloadssel->execute(array("user_id"=>$user_id));
$openloadsrecords =$openloadssel->fetch(PDO::FETCH_ASSOC);
$openloadscount = $openloadsrecords['allcount'];

?>

<script type="text/javascript" language="javascript" >
var searchdata="";
var searchtable;
var datatableshow=0;
var common_loadid=0;
var approve_url= LoadBoard.API+"broker/approve-loads";
var common_operation="<?php echo $req; ?>";
 var table;
 var namevisible=false;

$(document).ready(function() {
  //var table1 = $('.approvel_loads').dataTable();
 //Get the total rows


  var req = '<?php echo $req; ?>';
    if(req=="pending"){
      var openloadscount = '<?php echo $openloadscount; ?>';
      if(openloadscount==0){
        $(".export").hide();
      }
    }
    $(".export_pdf").click(function(){
        var export_page = $("input[name='export_page']:checked").val();
         var user_id = LoadBoard.userid;
        if(common_operation=='pending'){
          var total_count = '<?php echo $openloadscount; ?>';
        }
        if(export_page=="2"){
           var href="<?php echo SITEURL; ?>api/broker/download-pdf-all-loads?token="+LoadBoard.token+"&operation=pending&length=all&user_id="+LoadBoard.userid;
          window.open(href,'_blank');
        } else if(export_page=="1"){
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

            var href="<?php echo SITEURL; ?>api/broker/download-pdf-current-loads?token="+LoadBoard.token+"&operation=pending&user_id="+LoadBoard.userid+"&start="+start+"&length="+length;
             window.open(href,'_blank');
        }
    });

    $(".export_csv").click(function(){
      var export_page = $("input[name='export_page']:checked").val();
      var user_id = LoadBoard.userid;
      var openloadscount = '<?php echo $openloadscount; ?>';
      var token = LoadBoard.token;
          if(common_operation=='pending'){
            var total_count = '<?php echo $openloadscount; ?>';
          }
      
      if(openloadscount!=0){
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

            var href="<?php echo SITEURL; ?>api/broker/download-excel-current-view-loads?token="+LoadBoard.token+"&operation=pending&user_id="+LoadBoard.userid+"&start="+start+"&length="+length;
            window.location.href=href;
          }
          else if(export_page=="2"){
            var href="<?php echo SITEURL; ?>api/broker/download-excel-all-loads?token="+LoadBoard.token+"&operation=pending&length=all&user_id="+LoadBoard.userid;
            window.location.href=href;
          } 
        } 
    });


    //console.log(common_operation+"common_operation")
    if(common_operation=='pending'){
        $("#nav-trucker-tab").addClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");  
        $("#nav-ready").removeClass("active");   
        $(".last_column").css('border-bottom','2px solid #dee2e6').html(''); 
        $("#export").show();     
    } else if(common_operation=='awaiting'){
        $("#nav-home-tab").addClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");
        $("#nav-ready").removeClass("active");         
        $("#export").hide();
      }else if(common_operation=='expiring'){
        $("#nav-profile-tab").addClass("active");   
        $("#nav-home-tab").removeClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-ready").removeClass("active");         
        $("#export").hide();

      }else if(common_operation=='ready_pickup'){
        $("#nav-ready").addClass("active");   
        $("#nav-profile-tab").removeClass("active");   
        $("#nav-home-tab").removeClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#export").hide();

      }else{
        $("#nav-trucker-tab").addClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active"); 
         $("#nav-ready").removeClass("active");         
         $("#export").show();

      }
      var request = $(".request").val();
       table = $('.viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available" },
          dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
            "ajax": LoadBoard.API+'broker/view-loads?user_id='+LoadBoard.userid+'&operation='+common_operation,
             "bLengthChange": false,  
             "type": "POST",
              "bProcessing": false,
              "bServerSide": true,
              "bInfo": false,
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "status"},
                {"data": "price" },
                {"data": "approve_status" },
                {"data": "name" }             
            ],
    columnDefs: [{
       targets: 5,

       render: function (data,type,row) {
              if (row.status==0) {
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
              }          
          }
      },
      {
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
      {
        targets: 7,
         bSortable: false, 
        render: function (data,type,row) {
            if(row.approve_status==1){
              return '<button data-id="'+row.id+'" type="button" class=" btn btn-outline-primary btn-sm approve approve_modal  btncursor"  data-origin="'+window.btoa(row.origin)+'"  data-des="'+window.btoa(row.destination)+'" data-loadid="'+window.btoa(row.load_id)+'" data-price="'+window.btoa(row.price)+'">APPROVE</button>';
              //return '<button data-id="'+row.id+'" type="button" class=" btn btn-outline-primary btn-sm approve_modal btn-sm btncursor" data-origin="'+window.btoa(row.origin)+'"  data-des="'+window.btoa(row.destination)+'" data-loadid="'+window.btoa(row.load_id)+'" data-price="'+window.btoa(row.price)+'">APPROVE</button>';
            }else if(row.approve_status==2){
              var columns = $("table.viewloads").find('tbody tr td').eq(7);
               return '';
            }else{
               var columns = $("table.viewloads").find('tbody tr td').eq(7);
               return '';
            }
          }
      },

        {
        targets: 0,
        bSortable: false, 
        render: function (data,type,row) {
        //  console.log(row)
                return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';
                }
      }, {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      },
         {
        targets: 8,
       "visible": namevisible,
        render: function (data,type,row) {
          if(row.name!=undefined){
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+jsUcfirst(row.name)+'</a>';
              }else{
                return '';
              }
                


                }
      },
      
     
    ],
        "drawCallback": function () {
        $('.dataTables_paginate > .pagination a').addClass('myNewClassName');
        //console.log("afsdf")
    }
     
        });

   
 
 $(document).on("click",".nav-item",function(){
        var href = $(this).attr("href");
        //alert(href);
        if(href=='#nav-trucker'){
        $("#nav-trucker-tab").addClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");  
        $("#nav-ready").removeClass("active");
         $(".last_column").css('border-bottom','2px solid #dee2e6').html('');
        var columns = $("table.viewloads").find('thead tr td').eq(7).hide();
         table.columns( [8] ).visible( false );

        $("#export").show();
      }else if(href=='#nav-home'){
        $("#nav-home-tab").addClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");
        $("#nav-ready").removeClass("active");  
       $(".last_column").css('border-bottom','2px solid #dee2e6').html('ACTION');
        var columns = $("table.viewloads").find('thead tr td').eq(7).show(); 
         table.columns( [8] ).visible( false );

        $("#export").hide();
      }else if(href=='#nav-profile'){
        $("#nav-profile-tab").addClass("active");   
        $("#nav-home-tab").removeClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-ready").removeClass("active");  
        $(".last_column").css('border-bottom','2px solid #dee2e6').html('');
        var columns = $("table.viewloads").find('thead tr td').eq(7).hide();
         table.columns( [8] ).visible( false );

         $("#export").hide();    
      }else if(href=='#nav-ready'){
        $("#nav-ready").addClass("active");   
        $("#nav-profile-tab").removeClass("active");   
        $("#nav-home-tab").removeClass("active");
        $("#nav-trucker-tab").removeClass("active");
       $(".last_column").css('border-bottom','2px solid #dee2e6').html('');  
       var columns = $("table.viewloads").find('thead tr td').eq(7).hide();  
         table.columns( [8] ).visible( true );

        $("#export").hide();
      }else{
          $("#nav-trucker-tab").addClass("active");
          $("#nav-home-tab").removeClass("active");
          $("#nav-profile-tab").removeClass("active"); 
          $("#nav-ready").removeClass("active");     
          $(".last_column").css('border-bottom','2px solid #dee2e6').html('');   
          var columns = $("table.viewloads").find('thead tr td').eq(7).hide();  
          $("#export").show();
         table.columns( [8] ).visible( false );
       

      }
    });

    $(document).on("click","#nav-trucker-tab",function(){
        table.ajax.url(LoadBoard.API+"broker/view-loads?user_id="+LoadBoard.userid+"&operation=pending" ).load();
        table.ajax.reload();
    });
    $(document).on("click","#nav-home-tab",function(){
        table.ajax.url(LoadBoard.API+"broker/view-loads?user_id="+LoadBoard.userid+"&operation=awaiting" ).load();
        table.ajax.reload();
    });
    $(document).on("click","#nav-profile-tab",function(){
         table.ajax.url(LoadBoard.API+"broker/view-loads?user_id="+LoadBoard.userid+"&operation=expiring" ).load();
        table.ajax.reload();
    });
     $(document).on("click","#nav-ready",function(){
         table.ajax.url(LoadBoard.API+"broker/view-loads?user_id="+LoadBoard.userid+"&operation=ready_pickup" ).load();
        table.ajax.reload();
    });


     
       searchtable=$('.approvel_loads').DataTable({
         language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available" },
          "ajax": {
            url: approve_url,
            "data": function(data){
                data.token = LoadBoard.token;
                data.load_id = common_loadid;
            },
          },
<<<<<mine<< .
          },
           "processing": false,
             "dom": '<"load_details">frtip',
            "bLengthChange": false, 
            "type": "POST",
            "bProcessing": false,
            "serverSide": true,
            "bInfo": false,
              "columns": [
                //{"data":"orgin"},
               // {"data": "destination"},
                {"data": "name","sWidth": "10%"},
                {"data": "phone"},
                {"data": "email"},
                {"data": "dot"},
                {"data": "load_status" }
              
            ],
        columnDefs: [{
          bSortable: false, 
                targets: 0,
                 render:function (data,type,row) {
                
                  if(row.hover_trucker==1 && row.cancelaf_inlist == 1){
                     return jsUcfirst(row.name)+'  <a href="#" class="help "><i class="fa fa-question-circle" data-toggle="tooltip" title="help" data-original-title="help"></i></a>';
                  }else if(row.hover_trucker==1 && row.cancelbe_inlist == 1){
                     return jsUcfirst(row.name)+'  <a href="#" class="help "><i class="fa fa-question-circle" data-toggle="tooltip" title="help1" data-original-title="help1"></i></a>';
                  }else if(row.hover_trucker==1 && row.denied_inlist == 1){

                     return jsUcfirst(row.name)+' <a href="#" class="help "><i class="fa fa-question-circle" data-toggle="tooltip" title="help2" data-original-title="help2"></i></a>';
                  }else{
                    return jsUcfirst(row.name);
                  }
                 


                                   }
||||||| .r455
          },
           "processing": false,
             "dom": '<"load_details">frtip',
            "bLengthChange": false, 
            "type": "POST",
            "bProcessing": false,
            "serverSide": true,
            "bInfo": false,
              "columns": [
                //{"data":"orgin"},
               // {"data": "destination"},
                {"data": "name","sWidth": "10%"},
                {"data": "phone"},
                {"data": "email"},
                {"data": "dot"},
                {"data": "load_status" }
              
            ],
        columnDefs: [{
          bSortable: false, 
                targets: 0,
                 render:function (data,type,row) {
                  return jsUcfirst(row.name);
                                   }
=======
          "processing": false,
          "dom": '<"load_details">frtip',
          "bLengthChange": false, 
          "type": "POST",
          "bProcessing": false,
          "serverSide": true,
          "bFilter":false,
          "bInfo": false,
          "columns": [
              {"data": "name","sWidth": "10%"},
              {"data": "phone"},
              {"data": "email"},
              {"data": "dot"},
              {"data": "load_status" }
          ],
          columnDefs: [{
            bSortable: false, 
            targets: 0,
            render:function (data,type,row) {
              return jsUcfirst(row.name);
            }
>>>>>>> .r466
          }, 
          {
            targets: 1,
            width:"10px",
             render:function (data,type,row) {
              return formatPhoneNumber(row.phone);
                                  

                                   }
          }, 

          
      {
        targets: 2,
        render: function (data,type,row) {
                //var string = row.email;
                //if(string.length>20){
                   //var trimmedString = string.substring(0, 10);
                // return '<a class="tootl" href="javascript:void(0);" title="'+string+'"">'+trimmedString+'</a>';
            //  }else{
                return row.email;
             // }

                }
      },
     

      {
                targets: 4,
                 render:function (data,type,row) {
                  
                  if(row.load_status == 1 && row.trucker_status==1 && row.denied_status==0){
                     var bt="";
                        var btcls="confirm_approve";
                  /*  var bt="";
                    var btcls="";
                    if(row.unapporve==undefined || row.unapporve=='undefined'){
                    
                       bt="";
                        btcls="confirm_approve";
                    }else{
                         bt="disabled"; 
                      btcls="";
                    }*/
                    //console.log(bt+"br")
                    return '<button type="button" "'+bt+'" class="btn btn-outline-primary btn-sm approve btncursor  confirm_approve " data-id="'+window.btoa(row.tripid)+'" data-truker-id="'+window.btoa(row.trucker_id)+'" data-load-id="'+window.btoa(row.loadpid)+'" data-email-id="'+window.btoa(row.email)+'"  data-truker-name="'+window.btoa(row.name)+'" data-price="'+window.btoa(row.price)+'">APPROVE</button>';
                    //return '<button type="button" "'+bt+'" class="btn-primary btncursor  '+btcls+'  btn-sm" data-id="'+window.btoa(row.tripid)+'" data-truker-id="'+window.btoa(row.trucker_id)+'" data-load-id="'+window.btoa(row.loadpid)+'" data-email-id="'+window.btoa(row.email)+'"  data-truker-name="'+window.btoa(row.name)+'" data-price="'+window.btoa(row.price)+'" >APPROVE</button>';
                  }else if(row.load_status ==2  && row.trucker_status==2 ){
                    return '  <span class="status-icon bg-success"></span><span class="fosize">APPROVED</span>';

                  }else if(row.load_status ==1 && row.trucker_status==1 && row.denied_status==1){
                       return '<span class="status-icon bg-danger"></span><span class="fosize">DENIED</span>';
                  }
                  
                   /* return '<button type="button" class="btn-primary confirm_approve " data-id="'+row.tripid+'" data-truker-id="'+row.trucker_id+'" data-load-id="'+row.loadpid+'" data-email-id="'+row.email+'"  data-truker-name="'+row.name+'" >APPROVE</button>';*/
                 }
          }],
        }); 

/*     $("div.load_details").html('<b>Load Id : </b><span class="top_loadid">12121212</span>&nbsp;&nbsp;<b>Price : </b><span class="to_price">125</span><br><b>Origin : </b> <span class="top_origin">Alabama</span><br> <b>Destination : </b><span class="top_destination">Newyork</span>');
 */
  $("div.load_details").html('<ul class="ap-loads"><li><b>Load Id  </b><span class="top_loadid">12121212</span> <b class="b-price">Price </b><span class="to_price">125</span></li><li><b>Origin </b><span class="top_origin">Alabama</span></li><li><b>Destination  </b><span class="top_destination">Newyork</span></li></ul> ');

  $( document ).on("click", ".approve_modal", function(){
     $('body').addClass('modal-xscroll');
      $("#approve").modal("show");
    //  alert("hi");
    $(".top_loadid").html(window.atob($(this).attr("data-loadid")));
    $(".to_price").html(+window.atob($(this).attr("data-price")));
     var orgt=window.atob($(this).attr("data-origin")).split(",");
     var dest=window.atob($(this).attr("data-des")).split(",");
    $(".top_origin").html(orgt[0]+", "+orgt[1]);
    $(".top_destination").html(dest[0]+", "+dest[1]);
    var lid=$(this).attr("data-id");

    common_loadid = lid;
     searchtable.ajax.reload();
     //alert(searchtable.fnGetData().length);

   
  });
  $( document ).on("click", ".approve_close", function(){
        $("body").removeClass("modal-xscroll");

  });

  $( document ).on("click", ".tcancel", function(){
         $("body").removeClass("modal-xscroll");
         $("#trucker_confirm").modal("hide");
         $("#approve").modal("show");

});

  $(document).on("click","#editlink",function(){
    $("#editprice").html('<label><b>Negotiated Price </b> </label><a id="editclose" href="javascript:void(0);"><i class="fe fe-x"></i></a><input type="text" name="" class="form-control form-control-sm suggest_price"><label class="error price_error" style="display:none;">Please enter the price</label>');
    $("#editlink").hide();
    $("#editprice").show();      

  });
  $(document).on("click","#editclose",function(){
    $("#editprice").html("");
     $("#editprice").hide();  
     $("#editlink").show();
  });

  $( document ).on("click", ".confirm_approve", function(){
     
    $(".price_error").hide();
    $("#approve").modal("hide");
    var tripid=$(this).attr("data-id");
      $("#tconfirm_name").html(jsUcfirst(window.atob($(this).attr("data-truker-name"))));
       $('body').addClass('modal-xscroll');
      var qutoeprice=window.atob($(this).attr("data-price"));
     
      if(qutoeprice!=undefined )
        $(".quoted_price").html(qutoeprice);
      else
        $(".quoted_price").html('0');


      $(".tconfirm").attr("ttripid",window.atob(tripid));
      $(".tconfirm").attr("ttrucker_id",window.atob($(this).attr("data-truker-id")));
      $(".tconfirm").attr("temail",window.atob($(this).attr("data-email-id")));
      $(".tconfirm").attr("ttruckername",window.atob($(this).attr("data-truker-name")));
      $(".tconfirm").attr("tloadid",window.atob($(this).attr("data-load-id")));
      $("#trucker_confirm").modal("show");
  });


      $(document).on("click", ".tconfirm", function(){
      $('body').addClass('modal-xscroll');
        
      var price_req;
      if($("#editprice").is(":visible")){
          price_req=true;
      } else{
          price_req=false;         
      }
       
      var load_id=$(".tconfirm").attr("tloadid");
      var trucker_id=$(".tconfirm").attr("ttrucker_id");
      var tripid=$(".tconfirm").attr("ttripid");
      var email=$(".tconfirm").attr("temail");
      var truker_name=$(".tconfirm").attr("ttruckername");
      var suggest_price=$(".suggest_price").val();
      var suggest_comments=$.trim($(".suggest_comments").val());
       
       if(price_req==true){
        var sugg_price=$(".suggest_price").val();
          if(sugg_price==''){
              $(".price_error").show();
              return false;
          }else if(sugg_price!='' &&  !$.isNumeric(sugg_price)  ){
              $(".price_error").show();
              return false;
          }else if(suggest_comments!='' &&  suggest_comments.length>=100){
             $(".qcomment").show();
              return false;
          }else{
            TruckerConfirm(load_id,trucker_id,tripid,email,truker_name,suggest_price,suggest_comments);
          }

       }else if(suggest_comments!='' && suggest_comments.length>=100){
             $(".qcomment").show();
              return false;
          }else{
            TruckerConfirm(load_id,trucker_id,tripid,email,truker_name,suggest_price,suggest_comments);
       }      
      });



  //  $(".suggest_price").keypress(function(e){

$(document).on("keypress", ".suggest_price", function(e){
    var regex = new RegExp(/^[0-9]+$/);
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
      $(".price_error").hide();
      return true;
    }
    else {
    e.preventDefault();
    return false;
    } 
    });
$(document).on("keypress", ".suggest_comments", function(e){
   
     if($(this).val().length>=100){
             $(".qcomment").show();
              return false;
          }else{
            $(".qcomment").hide();
          }
      

  
    });

/*    $( "#DataTables_Table_0_wrapper" ).children('.row').find(".col-sm-12").addClass("reddy");
$("#DataTables_Table_0_wrapper:first").children('.row').find(".col-sm-12").css( 
              "background-color", "green"); 

$("#DataTables_Table_0_wrapper:class:first").children('.row').find(".col-sm-12").addClass("green"); */

      $(document).on("keypress", ".suggest_price", function(e){
     if (this.value.length == 0 && e.which == 48 ){
      return false;
    }
    });


  });

 function TruckerConfirm(load_id,trucker_id,tripid,email,truker_name,suggest_price,suggest_comments){
      $('.preloader').show();
  
        $("#trucker_confirm").modal("hide");
        $("#approve").modal("show");
        $(".tconfirm").attr("disabled", true);
        $(".confirm_approve").attr("disabled", true);
          $.ajax({
          type: 'post',
          url: LoadBoard.API+'broker/trucker-confirm',
          dataType: "json",
          data: {
            load_id:load_id,
            trucker_id:trucker_id,
            tripid:tripid,
            email:email,
            truker_name:truker_name,
            suggest_price:suggest_price,
            suggest_comments:suggest_comments,
            token:LoadBoard.token
          },
          success: function (result) {
           $('.preloader').hide();
           $(".tconfirm").attr("disabled", false);
          $(".confirm_approve").attr("disabled", false);
            //if(result.status==1){
               searchtable.ajax.url( LoadBoard.API+"broker/unapprove-loads" ).load();
               searchtable.ajax.reload();
               table.ajax.reload();
               $("#trucker_confirm").modal("hide");
           //}
          }

          });
 }

 function formatPhoneNumber(phoneNumberString) {
  var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
  var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
  if (match) {
    return '(' + match[1] + ')-' + match[2] + '-' + match[3]
  }
  return null
}
 function trukerpopup(id=""){
   $.ajax({
          type: 'get',
          url: LoadBoard.API+'trucker/get-trucker',
          dataType: "json",
          data: {"trucker_id":window.atob(id),"token":LoadBoard.token},
          success: function (result) {
              if(result.status==1){
                  var bname='NIL';
                  if(result.data.business_name!='')
                      bname=result.data.business_name;
                     var name=result.data.name;
                     var ucnama=jsUcfirst(name);
                  $("#trucker_business").html(bname);
                  $("#trucker_name").html(ucnama);
                  $("#trucker_email").html(result.data.email);
                  $("#trucker_phone").html(formatPhoneNumber(result.data.phone));
                  $("#trucker_dot").html(result.data.dot);
                  $("#trucker_weight").html(result.data.vehicle_weight);
                  $("#trucker_length").html(result.data.vehicle_length);

                $("#truker_modal").modal("show");
              }else if(result.status==2){
                window.location.href=LoadBoard.APP+"logout";
              }

          }
        });
}
      function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

</script>


<!-- loader -->
<div class="modal fade" id="loader" tabindex="-1" role="dialog" aria-labelledby="load" aria-hidden="true">
  <div class=" modal-dialog-centered" role="document">  
<div class="container-loader">
                <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
                                <circle cx="170" cy="170" r="160" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="135" stroke="#88c4ff"/>
                                <circle cx="170" cy="170" r="110" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="85" stroke="#88c4ff"/>
                </svg>  
</div>
  </div>
</div>


<!-- Truker Popup -->
<div class="modal fade" id="truker_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="common_modal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered  " role="document">
 <div class="modal-content"> 
  <div class="modal-header   text-center">
        <div class="modal-title  " id="mySmallModalLabel">Trucker Details</div>
        <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
            <div class="modal-body">
                
                                       
                   <div class=" trucker-info ">                                                                
                    <ul class=" ">
                  <li class=" bname " >
                    <label> Business Name </label>
                    <span class="   title" id="trucker_business">-</span>
                   </li>  
                <li >
         <label> Name </label>
         <span class="  load-info " id="trucker_name">LI-000</span>
                </li> 
                <li >
                 <label> Email</label>
                 <span class="  load-info" id="trucker_email">100</span>
                </li>               
                <li >
                 <label> Phone </label>
                 <span class="load-info  " id="trucker_phone"></span>
                </li>
                <li >
                 <label> USDOT </label>
                 <span class=" load-info   " id="trucker_dot"></span>
                </li>  
                <li >
                  <label> Weight </label>
                  <span class=" load-info  lbs " id="trucker_weight"></span>
                </li> 
                <li >
                  <label> Length </label>
                  <span class=" load-info  ft " id="trucker_length"></span>
                </li>                                                          
                </ul>                     
                   </div> 
                
                 
               
                  
                  
 
    </div>
  </div>
</div>
  </div> 
  <!-- Truker Popup -->
<?php
if(!empty($expire_req) || !empty($awaiting_req) || !empty($reopen_status)){ ?>
  
<script>
  $(document).ready(function(){
      var operation = '<?php echo $req; ?>';
      //alert(operation);
      if(operation=="expiring"){
        var e = '<?php echo $expire_req;?>';
        var link = LoadBoard.APP+"broker/loads?e="+e;
        //alert(link);
      }
      else if(operation=="awaiting"){
        var a = '<?php echo $awaiting_req;?>';
        var link = LoadBoard.APP+"broker/loads?a="+a;
       // alert(link);
      } else if(operation=="reopen"){
        var re = '<?php echo $reopen_status;?>';
        var link = LoadBoard.APP+"broker/loads?re="+re;
      }
      
      if(common_operation=='pending'){
        $("#nav-trucker-tab").addClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");  
        $("#nav-ready").removeClass("active");   
        $(".last_column").css('border-bottom','2px solid #dee2e6').html(''); 
        $("#export").show();   
      } else if(common_operation=='awaiting'){
        $("#nav-home-tab").addClass("active");
        $("#nav-trucker-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");
        $("#nav-ready").removeClass("active");         
        $("#export").hide();
      } else if(common_operation=='reopen'){
        $("#nav-trucker-tab").addClass("active");
        $("#nav-home-tab").removeClass("active");
        $("#nav-profile-tab").removeClass("active");  
        $("#nav-ready").removeClass("active");   
        $(".last_column").css('border-bottom','2px solid #dee2e6').html(''); 
        $("#export").hide();   
      }
      $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/notification-count-view',
        dataType: 'json',
        data:"token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&req="+operation,
        success : function(result){
          if(result.status==1){
           // toastr.success(result.msg);
           
          
          } else if(result.status==0){
            //toastr.error(result.msg);
          }
        }
      });
  });

</script>
<?php } ?>