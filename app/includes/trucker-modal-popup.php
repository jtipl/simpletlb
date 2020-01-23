   
<!-- Truker Popup -->
<div class="modal fade" id="truker_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="common_modal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered  " role="document">
 <div class="modal-content"> 
  <div class="modal-header   text-center">
        <div class="modal-title  " id="mySmallModalLabel">Trucker Details</div>
        <button type="button" class="close cls_lod cls_trucker" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
            <div class="modal-body">
                
                                       
                   <div class=" trucker-info ">                                                                
                    <ul class=" ">
                     <!--
                  <li class=" bname " >
                    <label> Business Name </label>
                    <span class="   title" id="truck_business">-</span>
                   </li> -->
                   <li >
         <label>Business Name </label>
         <span class="  bpopuptitle" id="truck_business">LI-000</span>
                </li> 
                <li >
         <label> Name </label>
         <span class="  load-info " id="truck_name">LI-000</span>
                </li> 
                <li >
                 <label> Email</label>
                 <span class="  load-info" id="truck_email">100</span>
                </li>               
                <li >
                 <label> Phone </label>
                 <span class="load-info  " id="truck_phone"></span>
                </li>
                <li >
                 <label> USDOT </label>
                 <span class=" load-info   " id="truck_dot"></span>
                </li>  
             <!--    <li >
                  <label> Weight </label>
                  <span class=" load-info  lbs " id="truck_weight"></span>
                </li>   
                  <li >
                  <label> Length </label>
                  <span class=" load-info  ft " id="truck_length"></span>
                </li>   -->
                 <li >
                  <label> Driving Licence Number </label>
                  <span class=" load-info" id="truck_licence"></span>
                </li> 
                <li >
                  <label> Licence Issuing State </label>
                  <span class=" load-info" id="truck_issuing_state"></span>
                </li>
                <li>
                  <label> Licence Expiry Date </label>
                  <span class=" load-info" id="truck_lic_exp_date"></span>
                </li>                                                           
                </ul>                     
                   </div> 
                
                 
               
                  
                  
 
    </div>
  </div>
</div>
  </div> 
  <!-- Truker Popup -->

  <script type="text/javascript">
    $(document).ready(function(){
      $(".cls_trucker").on('click',function(){
        var url = window.location.href;  
        var tabsid = $("#tabsid").val();
        //alert(url+'---'+tabsid)
        if(url==LoadBoard.APP+"broker/loads" && tabsid=="awaiting"){
          $("#approve").modal("show");
        }
      });
    })

      function trukerpopup(id=""){
    $("#approve").modal("hide");
   $.ajax({
          type: 'post',
          url: LoadBoard.API+'trucker/get-trucker',
          async:false,
          dataType: "json",
          //data: {"trucker_id":window.atob(id),"token":LoadBoard.token},
          contentType: "application/json",
          headers: {
             Authorization: "Bearer "+LoadBoard.token
           },
          data:  JSON.stringify({"trucker_id":window.atob(id)}),
          success: function (result) {
              if(result.status==1){
                  var bname='NIL';
                  if(result.data.business_name!='')
                      bname=result.data.business_name;
                     var name=result.data.name;
                     var ucnama=jsUcfirst(name);

                     if(result.data.vehicle_expiry_date=="" || result.data.vehicle_expiry_date=="01-01-1970"){
                      var vehicle_expiry_date = "";
                     } else {
                      var vehicle_expiry_date = result.data.vehicle_expiry_date;
                     }

                  $("#truck_business").html(bname);
                  $("#truck_name").html(ucnama);
                  $("#truck_email").html(result.data.email);
                  $("#truck_phone").html(formatPhoneNumber(result.data.phone));
                  $("#truck_dot").html(result.data.dot);
                  $("#truck_weight").html(result.data.vehicle_weight);
                  $("#truck_length").html(result.data.vehicle_length);
                  $("#truck_licence").html(result.data.vehicle_licence_no);
                 // $("#truck_issuing_state").html(result.data.vehicle_issuing_state);
                  //$("#truck_lic_exp_date").html(vehicle_expiry_date);
                  if(vehicle_expiry_date=="01-01-1970"){
                    $("#truck_lic_exp_date").html('');  
                  } else {
                    $("#truck_lic_exp_date").html(vehicle_expiry_date);  
                  }


                 if(result.data.vehicle_issuing_state!=""){
                    $.ajax({
                      type:'POST',
                      url:LoadBoard.API+'broker/location-list',
                      async:false,
                      dataType: 'json',
                      contentType: "application/json",
                      headers: {
                       Authorization: "Bearer "+LoadBoard.token
                      },
                      data:JSON.stringify({operation:"state_name" ,state_id:result.data.vehicle_issuing_state }),
                      success:function(result){
                        $("#truck_issuing_state").html(result.data);
                      }
                    }); 
                 }



                


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