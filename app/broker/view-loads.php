 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();


if(isset($_REQUEST['e'])){
  $expiring_decode = $Global->decode($_REQUEST['e']);
}
if(isset($_REQUEST['a'])){
  $approval_decode = $Global->decode($_REQUEST['a']);
}

if(isset($expiring_decode)){
  $req = "exp";  
}
else if(isset($approval_decode)){
  $req = "app";  
} else {
  $req = "";
}
 if($req=="exp"){
  $heading = 'Loads To Be Expired';
}
else if($req=="app"){
  $heading = 'Loads Awaiting For Approval';
}
else {
  $heading = 'Pending loads';
}
$Global->Header("LoadBoard - ".$heading);
?>  
<style type="text/css">
/* div#DataTables_Table_0_filter{ float: right; }#DataTables_Table_0_paginate{float: right;}.tootl{    text-decoration: none !important; color: #495057;} 
.load_details{
  float:left; margin-bottom: 5px;
} */
</style>
       <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
          <h1 class="page-title">
                <i class="fe fe-truck"></i> Current Loads
              </h1> 
            </div>            
            <div class="row row-cards row-deck">
             <div class="col-12">
                <div class="card">
                
                  <div class="table-responsive">
                      <h3 class="card-title" style="float: left; position: absolute;left: 20px; top: 20px;"> 
                      <?php echo $heading; ?>
                    </h3>
                     <input type="hidden" id="request" class="request" value="<?php echo $req; ?>" />
                      <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th></th>
                            <th>Load-Id</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Pickup Date</th>
                            <th>Status</th>
                             <th>Price</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                  </table>                    
                  </div>
                </div>
           
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="approve" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content"> 
  
  <div class="modal-header text-center">
        <div class="modal-title  " id="mySmallModalLabel">Approve Trucker</div>
        <button type="button" class="close approve_close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
       
      <div class="modal-body ap">
      
      <!-- <table id="approve_loads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                        <th>ORGIN</th>
                        <th>DESITNATION</th>
                        <th>TRUCKER NAME</th>
                        <th>PHONE</th>
                        <th>EMAIL</th>
                        <th></th>

                           
                        </tr>
                    </thead>
                </table>    -->    
      <div class="table-responsive"> 
        
        <table class="table table-striped table-bordered table-sm pag table-hover card-table table-vcenter text-nowrap approvel_loads" width="100%"  >
          <thead>
            <tr>
                        <th >NAME</th>
                        <th>PHONE</th>
                        <th>EMAIL</th>
                        <th>USDOT</th>
<!--                         <th>PHONE</th>
 -->                       <!--  <th>EMAIL</th> -->
                        <th>ACTION</th> 

            </tr>
          </thead>
          <tbody class="appcls">
            
          </tbody>
        </table>
      </div>
     
 <!--  <div class=" text-right pr-3 pb-3">
     <input type="hidden"  value="" id="search_bid">
    <input type="hidden" value="" id="search_lid">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary confirm_click" data-dismiss="modal" data-toggle="modal" data-target="#load" >Confirm</button>
      </div>  -->
    </div>
  </div>
</div>
  </div> 


 <!--  <div class="modal fade" id="trucker_confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content"> 
  
  <div class="modal-header bg-dark text-center">
        <h5 class="modal-title h2" id="mySmallModalLabel">Confirm Your Trucker</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
            <div class="modal-body cancel-trip">
                  <div class="row text-center">
                  <h3  >Do you want to Approve the <span id="tconfirm_name">Trucker()</span> for shipping the load?</h3>  
                  </div>
  <div class=" text-center  p-2">    
           <input type="hidden" value="" id="tload_id"> 
           

        <button type="button" class="btn btn-primary" data-dismiss="modal" >No</button>
         <button type="button" class="btn btn-primary tconfirm" data-dismiss="modal">Yes</button>
      </div> 
                  
                  
                  
                  
    </div>




  </div>
</div>
  </div>  -->

  <div class="modal fade  " id="trucker_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header " style="text-align: center;">
        <h5 class="modal-title h2" id="mySmallModalLabel">Confirm Trucker</h5>
        <button type="button" class="close approve_close " data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center cancel-trip">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <p>Do you want to Approve the <span id="tconfirm_name">Trucker()</span> for shipping the load?</p>    
        <div class="row" style="text-align: left;">
       <div class="col-6">
         <label><b>Quoted Price :</b></label>
        <div class="form-group">
         <h3 class="">$<span class="quoted_price"></span></h3>
      </div>
       </div>
       <div class="col-6">
        <div class="form-group">
          <a href="javascript:void(0);" id="editlink">Edit</a>

          <div id="editprice" style="display: none;">
        
      </div>

      </div>
       </div>
     
       <div class="col-12">
         <div class="form-group">
           <label><b>Comments :</b></label>
        <textarea class="form-control form-control-sm suggest_comments" rows="5" cols="5" ></textarea>
         </div>
          </div>
        </div>
        </div>
    <div class="modal-footer">
                 <input type="hidden" value="" id="tload_id"> 
        <button type="button" class="btn btn-secondary tcancel" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary tconfirm">Save</button></div>
    
    </div>
  </div>
</div>

<?php $Global->Footer(); ?>
<script type="text/javascript" language="javascript" >
  var searchdata="";
var searchtable;
  var datatableshow=0;
  var common_loadid=0;
 var approve_url= LoadBoard.API+"broker/approve-loads";
 var table;
  $(document).ready(function() {
      var request = $(".request").val();
       table = $('#viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." },
            "ajax": LoadBoard.API+'broker/view-loads?user_id='+LoadBoard.userid+'&operation='+request,
             "bLengthChange": false,  
             "type": "POST",
              "bProcessing": true,
              "bServerSide": true,
              "bInfo": false,
              //"order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "status"},
                {"data": "price" },
                {"data": "approve_status" }             
                
            ],
    columnDefs: [{
       targets: 5,
       render: function (data,type,row) {
                    /*if (row.status==1) {
                      return '<button data-id="'+row.id+'" type="button" class=" btn-primary approve_modal">APPROVE</button>';
                    } else {
                      return '<span class="status-icon bg-green"></span>Open';
                    } */    
                    if (row.status==0) {
                      return '<span class="status-icon bg-red "></span>Yet to Confirm by Trucker';
                    } else if(row.status==1) {
                      return '<span class="status-icon bg-info"></span>Awaiting for your Approval';
                    } else if(row.status==2){
                      return '<span class="status-icon bg-success"></span>Load Approved for Pickup';
                    }else if(row.status==3){
                      return '<span class="status-icon bg-info"></span>Load Picked by Trucker';
                    } else if(row.status==4){
                      return '<span class="status-icon bg-success"></span>Load Delivered by Trucker';
                    }  else if(row.status==5){
                      return '<span class="status-icon bg-success"></span>Reopen Yet to Confirm by Trucker';
                    }  else{
                      return '';
                    }          
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
        render: function (data,type,row) {

                    if(row.approve_status==1){
                      return '<button data-id="'+row.id+'" type="button" class=" btn-primary approve_modal btn-sm" data-origin="'+window.btoa(row.origin)+'"  data-des="'+window.btoa(row.destination)+'" data-loadid="'+window.btoa(row.load_id)+'" data-price="'+window.btoa(row.price)+'">APPROVE</button>';
                    }else if(row.approve_status==2){
                      return '<button  type="button"  class="disabled btn-secondary btn-sm" >APPROVE</button>';
                    }else{
                      return '<button  type="button"   class=" disabled btn-secondary btn-sm" >APPROVE</button>';
                    }

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

       searchtable=$('.approvel_loads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." },
          "ajax": {
            url: approve_url,
          "data": function(data){
            data.token = LoadBoard.token;
            data.load_id = common_loadid;
          },
          },
           "processing": false,
             "dom": '<"load_details">frtip',
            "bLengthChange": false, 
            "type": "POST",
            "processing": true,
            "serverSide": true,
            "bInfo": false,
              "columns": [
                //{"data":"orgin"},
               // {"data": "destination"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "email"},
                {"data": "dot"},
                {"data": "load_status" }
              
            ],
        columnDefs: [{
                targets: 0,
                 render:function (data,type,row) {
                  return jsUcfirst(row.name);
                                   }
          }, 
          {
                targets: 1,
                 render:function (data,type,row) {
                  return formatPhoneNumber(row.phone);
                                  

                                   }
          }, 

          
      {
        targets: 2,
        render: function (data,type,row) {
                var string = row.email;
                if(string.length>20){
                   var trimmedString = string.substring(0, 10);
                 return '<a class="tootl" href="javascript:void(0);" title="'+string+'"">'+trimmedString+'</a>';
              }else{
                return row.email;
              }

                }
      },
     

      {
                targets: 4,
                 render:function (data,type,row) {
                  
                  if(row.load_status == 1 && row.trucker_status==1){
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
                    return '<button type="button" "'+bt+'" class="btn-primary '+btcls+'  btn-sm" data-id="'+window.btoa(row.tripid)+'" data-truker-id="'+window.btoa(row.trucker_id)+'" data-load-id="'+window.btoa(row.loadpid)+'" data-email-id="'+window.btoa(row.email)+'"  data-truker-name="'+window.btoa(row.name)+'" data-price="'+window.btoa(row.price)+'" >APPROVE</button>';
                  }else if(row.load_status ==2  && row.trucker_status==1 ){
                    return '  <a href="javascript:void(0)" class="btn btn-success  btn-sm"> APPROVED</a>';
                  }else{
                       return ' <a href="javascript:void(0)" class="btn btn-danger btn-sm"> DENIED</a>';
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
    $(".top_loadid").html(window.atob($(this).attr("data-loadid")));
    $(".to_price").html(+window.atob($(this).attr("data-price")));
     var orgt=window.atob($(this).attr("data-origin")).split(",");
     var dest=window.atob($(this).attr("data-des")).split(",");
    $(".top_origin").html(orgt[0]+", "+orgt[1]);
    $(".top_destination").html(dest[0]+", "+dest[1]);
    var lid=$(this).attr("data-id");
    common_loadid = lid;
     searchtable.ajax.reload();
     $("#approve").modal("show");
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
    $("#editprice").html('<label><b>Negotiated Price :</b> </label><a id="editclose" style="float:right;" href="javascript:void(0);"><i class="fe fe-x"></i></a><input type="text" name="" class="form-control form-control-sm suggest_price"><label class="error price_error" style="display:none;">Please enter the price</label>');
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
          }else{
            TruckerConfirm(load_id,trucker_id,tripid,email,truker_name,suggest_price,suggest_comments);
          }

       }else{
            TruckerConfirm(load_id,trucker_id,tripid,email,truker_name,suggest_price,suggest_comments);
       }      
      });

      function jsUcfirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

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
    return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
  }
  return null
}


</script>
