<style type="text/css">
  #cancel_origin,#cancel_destination{
    font-size: 20px !important;
  }
          
</style>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="cancel_confirm" tabindex="-1" role="dialog" aria-labelledby="cancel_confirm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content"> 
  <div class="modal-header  text-center">
        <h5 class="modal-title " id="mySmallModalLabel">Cancel Your Load</h5>
        <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
      <div class="modal-body cancel-trip">
       <div class="row d-flex">    
          <div class="col-sm-5 col-md-5">   
        <h3 id="cancel_origin"  >Houston, TX</h3>      
    <!--   <address>
        <small id="cancel_pdate">Jun 15, 2019</small> 
      </address>    -->     
       </div>
       <div class="col-sm-1 col-md-1 align-self-center arrow-r">  
       </div>
       <div class="col-sm-6 col-md-6">       
          <h3  id="cancel_destination" >Richmond, VA</h3> 
     <!--   <address>
      <small id="cancel_ddate">Jun 17, 2019</small>
      </address>      --> 
       </div>    
       </div>   
     <div class="row trip  mappop mappop">    
      <h4 class="subtitle">Load Details</h4>              
   <!-- <ul class=" ">
      
                                    <li >
                                                <label> Load-ID </label>
                                               <span class="  load-info  " id="cancel_loadid">LI-000</span>
                                  </li>   
                                    <li >
                                                <label> Price</label>
                                               <span class="  load-info doll  " id="cancel_price">100</span>
                                  </li>  
                                   <li >
                                                <label> Weight </label>
                                               <span class="   load-info lbs " id="cancel_weight">48k</span>
                                  </li>
                                    <li >
                                                <label> Length </label>
                                                  <span class=" load-info ft  " id="cancel_length">48ft</span>
                                  </li> 
                                    <li >
                                                <label> Distance </label>
                                               <span class="  load-info  km " id="cancel_distance">0</span>
                                  </li>  
                                 
                                 
                                     
                                                <li >
                                                <label> Equipment </label>
                                                 <span class=" load-info  " id="cancel_truck">Flatbed</span>
                                  </li>
                                </ul>-->

<div class="col-md-6 col-sm-6">	
 <label> Load-ID </label>
<span class="  load-info  " id="cancel_loadid">LI-000</span>
</div>	
<div class="col-md-6 col-sm-6">	
<label> Price</label>
<span class="  load-info doll  " id="cancel_price">100</span>
</div>	
<div class="col-md-6 col-sm-6">	
<label> Weight </label>
<span class="   load-info lbs " id="cancel_weight">48k</span>
</div>	
<div class="col-md-6 col-sm-6">	
<label> Length </label>
<span class=" load-info ft  " id="cancel_length">48ft</span>
</div>	
<div class="col-md-6 col-sm-6"> 
<label> Height </label>
<span class=" load-info ft  " id="cancel_height">48ft</span>
</div>  
<div class="col-md-6 col-sm-6">	
<label> Distance </label>
<span class="  load-info  km " id="cancel_distance">0</span>
</div>	
<div class="col-md-6 col-sm-6">	
<label> Equipment </label>
<span class=" load-info  " id="cancel_truck">Flatbed</span>
</div>	
		
	                               
      <h4 class="subtitle my-3">Pickup & Delivery</h4>     

<div class="col-md-6 col-sm-6">	
<ul class="">
 <li class="w-100 cancel_ord_adr" style="display: none;">
   <label> Pickup  </label>
    <span class="  load-info addrs " id="cancel_orgaddr"></span>
 </li>  
 <li class="">
    <label> Date </label>
     <span class="   load-info " id="cancel_pdate">00:00:AM</span>
  </li>
                                   <li class="canceltime" >
                                                <label> Time </label>
                                               <span class="   load-info time " id="cancel_ptime">00:00:AM</span>
</li>
</ul>								  
</div>	  
<div class="col-md-6 col-sm-6">	
<ul class="">
     <li class=" w-100 cancel_delivery_adr"  style="display: none;" >
                                                <label> Delivery  </label>
                                               <span class="  load-info addrs " id="cancel_desaddr"></span>
                                  </li> 

 <li class="">
                                                <label> Date </label>
                                               <span class="   load-info " id="cancel_ddate">00:00:AM</span>
                                  </li>

                                    <li  class="canceltime"  style="display:none;">
                                                <label> Time </label>
                                                  <span class=" load-info time  " id="cancel_dtime">00:00:AM</span>
                                  </li>                                            
    </ul>   
</div>
 

                               
	
          <h4 class="subtitle my-3">Broker Details</h4>   
          <div class="col-md-12 col-sm-12">	
		  <label> Broker </label>
          <span class="  load-info  " id="cancel_broker">Super Logistics Logistics Logistics</span>                                   
   </div>
     </div> 
      <div class="row ">  
    <div class="col-sm-12 col-md-12 my-3">
     <div class="form-group">
      <label class="form-label">Reason for Cancellation</label>     
      <textarea class="form-control" name="example-textarea-input"  id="cancel_reason"   placeholder="Reason"></textarea>
      <label style="display: none;"  class="error cancel_err">Please enter the reason</label>
      </div>      
    </div>
      </div> 
  <div class=" text-right pr-3 pb-3">
         
        <button type="button" class="btn btn-secondary cancel_cls" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary cancel_conf"  >Cancel Load</button>
      </div> 
    </div>
  </div>
</div>
  </div>  



<!--
  <div class="modal fade  " id="cancel_trips" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2 pop_up_font" id="mySmallModalLabel">Cancel Load Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <p>Do you want to Cancel the Load?</p>       
        </div>
    <div class="modal-footer">
      <input type="hidden" id="tabs" value="" />
      <button type="button" class="btn btn-primary cancel_con">Yes</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
             </div>
    
    </div>
  </div>
</div>
--->
<div class="modal fade  " id="stay_tab" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2" id="mySmallModalLabel">Success Cancelled Loads</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <p>Do you want to Cancel the Load?</p>       
        </div>
   
    
    </div>
  </div>
</div>





  <script type="text/javascript">
  var Globaltrip=0;
  var Globalres='';
  var pickedtable;
  $(document).ready(function() {
    $(document).on('click','.minus',function(){
      var tabs = $(this).attr("id");
      //alert(tabs);
      $("#tabs").val(tabs);
    });
     $( document ).on("click", ".cls_lod", function(){
         $("body").removeClass("modal-xscroll");
       });

      $("#cancel_reason").keypress(function(){
        if($("#cancel_reason").val()==''){
          $(".cancel_err").show();
        }else{
          $(".cancel_err").hide();
        }
      });

    $( document ).on("click", ".cancel_cls", function(){
        $(".cancel_err").hide();
      });

    $( document ).on("click", ".cancel_conf", function(){
      Globalres=$("#cancel_reason").val();
      
      if($("#cancel_reason").val()==''){
        $(".cancel_err").show();
          return false;
      }else{

        $("#cancel_confirm").modal("hide");
        swal.fire({
              title: "Confirmation!",
              text: "Do you want to cancel this load?",
              type: "error",
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              confirmButtonClass: 'btn-md',
              cancelButtonClass: 'btn-md',
              showCloseButton: true,
              allowOutsideClick:false,
          }).then(result => {
            //alert(result.value);
            if(result.value==true){
              $('.preloader').show();
              $.ajax({
                  type: 'post',
                  url: LoadBoard.API+'trucker/cancel-trip',
                  dataType: "json",
                  headers: {
                    Authorization: "Bearer "+LoadBoard.token
                   },
                  contentType: "application/json",
                  data: JSON.stringify({ 
                    "user_id": LoadBoard.userid, 
                    "tripid":Globaltrip,
                    "reason":Globalres,
                }),
                  success: function (result) {
                    $(".cancel_con").attr("disabled", false);
                    if(result.status==1){
                     // return false;
                    $('.preloader').hide();
                    $("#cancel_trips").modal("hide");
                    var load_process=$(".cancel_con").attr("data-id");
                    window.location.href=LoadBoard.APP+"trucker/loads?pro="+window.btoa(load_process);
                  }
                }
              });
            }
        });
           $("body").removeClass("swal2-height-auto");

       
      }

       

      });
  });
    
    function mapcancel(load_id="",tripid="",reload=""){
      $(".cancel_con").attr("data-id",reload);
      Globaltrip=window.atob(tripid);

       if(load_id!=''){
         $.ajax({
          type: 'post',
          url: LoadBoard.API+'broker/get-load',
          dataType: "json",
          async:false,
          contentType: "application/json",
           headers: {
                    Authorization: "Bearer "+LoadBoard.token
           },
          data: JSON.stringify({ 
            "load_id":window.atob(load_id),
            "user_type":LoadBoard.user_type,
            "user_id": LoadBoard.userid,
          }),
       //  data: {"id":window.atob(load_id),"token":LoadBoard.token},
          success: function (result) {
              if(result.status==1){
                  var orgsplit=result.data.origin.split(",");
                  var dessplit=result.data.destination.split(",");

                  var distance=distancecal(result.data.origin_lat,result.data.origin_lng,result.data.destination_lat,result.data.destination_lng);
                     //Pickup time and delivery time 
                  $(".canceltime").hide();
                  if(result.data.pickup_time!='' &&  result.data.delivery_time!=''){
                    $("#cancel_ptime").html(result.data.pickup_time);
                    $("#cancel_dtime").html(result.data.delivery_time);
                    $(".canceltime").show();
                  }


  
                if(result.data.origin_address!=''){
                      $("#cancel_orgaddr").html(result.data.origin_address);
                      $(".cancel_ord_adr").show();
                }if(result.data.destination_address!=''){
                     $("#cancel_desaddr").html(result.data.destination_address);
                     $(".cancel_delivery_adr").show();

                }
                

                  $("#cancel_distance").html(distance);
                  $("#cancel_origin").html(result.data.origin);
                  $("#cancel_destination").html(result.data.destination);
                  $("#cancel_weight").html(result.data.weight);
                  $("#cancel_truck").html(result.data.truck_name);
                  $("#cancel_length").html(result.data.length);
                  $("#cancel_height").html(result.data.height);

                  $("#cancel_broker").html(result.data.business_name);
                  $("#cancel_loadid").html(result.data.load_id);
                  $("#cancel_price").html( result.data.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                  var pdate= result.data.pickup_date.split("-");
                  var pyear=pdate[0];
                  var pmonth=pdate[1];
                  var pdate=pdate[2];
                  var p_mthname=GetMonthName(pmonth);
                  var pdata=p_mthname+" "+pdate+", "+pyear;
                  $("#cancel_pdate").html(pdata);
                  var ddate= result.data.delivery_date.split("-");
                  var dyear=ddate[0];
                  var dmonth=ddate[1];
                  var ddate=ddate[2];
                  var d_mthname=GetMonthName(pmonth);
                  var ddata=d_mthname+" "+ddate+", "+dyear;
                  $("#cancel_ddate").html(ddata);
                  var org=result.data.origin;
                  var des=result.data.destination;
                  var framesrc=LoadBoard.APP+"map?org="+window.btoa(org)+"&des="+window.btoa(des);
                  var iframe='<iframe src="'+framesrc+'" style="width:100%;min-height:200px;"   scrolling="no"  frameBorder="0"  allowfullscreen ></iframe>';
                  $(".mapview_head").html(iframe);

                  //Clear Old One
                  $("#cancel_reason").val("");
                  $("body").addClass("modal-xscroll");
                  $("#cancel_confirm").modal("show");
              }else if(result.status==2){
                window.location.href=LoadBoard.APP+"logout";
              }

          }
        });

      }
    }

 
        //Get Month Name
function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
}
  </script>
