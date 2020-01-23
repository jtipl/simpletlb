
<!-- Broker Popup -->
<div class="modal fade" id="broker_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="common_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  " role="document">
        <div class="modal-content">
            <div class="modal-header  text-center">
                <div class="modal-title  " id="mySmallModalLabel" id="title">Broker/Shipper Details</div>
                <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class=" trucker-info ">
                    <ul class=" ">
                        <!--
                        <li class=" bname ">
                            <label> Business Name </label>
                            <span class="load-info   title" id="broker_business">-</span>
                        </li>
                        --->
                        <li>
                            <label> Business Name </label>
                            <span class="  tpopuptitle" id="broker_business">LI-000</span>
                        </li>
                        <li>
                            <label> Name </label>
                            <span class="  load-info " id="broker_name">LI-000</span>
                        </li>
                        <li>
                            <label> Email</label>
                            <span class="  load-info" id="broker_email">100</span>
                        </li>
                        <li id="awaiting_load">
                            <label> Phone </label>
                            <span class="load-info  " id="broker_phone"></span>
                        </li>
                        <!--    
                          <li>
                            <label> Address </label>
                            <span class=" load-info   " id="broker_address"></span>
                          </li> 
                        -->
                        <li>
                            <label> City </label>
                            <span class=" load-info   " id="broker_city"></span>
                        </li>
                        <li>
                            <label> State </label>
                            <span class=" load-info" id="broker_state"></span>
                       </li> 
                        <li>
                            <label> Country </label>
                            <span class=" load-info" id="broker_country"></span>
                       </li> 
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
  function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
 function brokerpopup(id="",sid=""){
  var bro=window.atob(id);
  var ship=window.atob(sid);
  var url;
    if(bro !=0 && bro !=null && bro !=''&& bro !='0'){
      url='broker/get-broker';
    }else if(ship !=0 && ship !=null && ship !=''&& ship !='0'){
        url='shipper/get-shipper';
    }
   $.ajax({
          type: 'post',
          url: LoadBoard.API+url,
          dataType: "json",
          contentType: "application/json",
          headers: {
             Authorization: "Bearer "+LoadBoard.token
           },
          data:  JSON.stringify({
            "broker_id":window.atob(id),
            "shipper_id":window.atob(sid)
          }),
          success: function (result) {

              if(result.status==1){
                  var bname='NIL';
                  if(result.data.business_name!='')
                      bname=result.data.business_name;
                     var name=result.data.name;
                     var ucnama=jsUcfirst(name);
                  $("#broker_business").html(bname);
                  $("#broker_name").html(ucnama);
                  $("#broker_email").html(result.data.email);
                  $("#broker_phone").html(formatPhoneNumber(result.data.phone));
                 // $("#broker_address").html(result.data.address_line1);
                 $("#broker_city").html(result.data.city_name);
                  $("#broker_state").html(result.data.state_name);
                  $("#broker_country").html(result.data.country_name);
              $("#broker_modal").modal("show");
              }else if(result.status==2){
                window.location.href=LoadBoard.APP+"logout";
              }

          }
        });
}</script>