
<div class="modal fade" id="common_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="common_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header   text-center">
                <h5 class="modal-title " id="mySmallModalLabel">Load Details</h5>
                <!-- <div class="modal-title  " id="mySmallModalLabel">Load Details</div> -->
                <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body cancel-trip">

                <div class="row">
                    <div class="col-md-12">
                        <div class="map-header-layer mapview_head table-responsive"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 ldetails">
                        <div class="row d-flex ">
                            <div class="col-sm-5 col-md-5">
                                <h3 id="head_origin">Houston, TX</h3>

                            </div>
                            <div class="col-sm-1 col-md-1 align-self-center arrow-r">
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <h3 id="head_destination">Richmond, VA</h3>
                            </div>
                        </div>
                        <div class="row   trip mappop">						
                            <div class="col-md-12  ">	
							<h4 class="subtitle">Load Details  <span class="pull-right">Created Date: <span id="head_created_date">Jun 15, 2019</span></span></h4>
                                
                              <!--  <ul class=" ">

                                    <li>
                                        <label> Load-ID </label>
                                        <span class="  load-info  " id="head_loadid">LI-000</span>
                                    </li>
                                    <li>
                                        <label> Price</label>
                                        <span class="  load-info doll" id="head_price">100</span>
                                    </li>
                                    <li>
                                        <label> Weight </label>
                                        <span class="load-info lbs " id="head_weight">48k</span>
                                    </li>
                                    <li>
                                        <label> Length </label>
                                        <span class=" load-info ft  " id="head_length">48ft</span>
                                    </li>
                                    <li>
                                        <label> Distance </label>
                                        <span class="  load-info  km" id="head_distance">0</span>
                                    </li>

                                    <li>
                                        <label> Equipment </label>
                                        <span class="  load-info  " id="head_truck">Flatbed</span>
                                    </li>
                                </ul> -->
                            </div>
							<div class="col-md-4 col-sm-6">	<label> Load-ID </label>
                                        <span class="  load-info  " id="head_loadid">LI-000</span>
							</div>
							<div class="col-md-4 col-sm-6">	<label> Price</label>
                                        <span class="  load-info doll" id="head_price">100</span>
							</div>
							<div class="col-md-4 col-sm-6">	<label> Weight </label>
                                        <span class="load-info lbs " id="head_weight">48k</span>
							</div>
							<div class="col-md-4 col-sm-6">	
							 <label> Length </label>
                                        <span class=" load-info ft  " id="head_length">48ft</span>
							</div>
                            <div class="col-md-4 col-sm-6"> 
                             <label> Height </label>
                                        <span class=" load-info ft  " id="head_height">48ft</span>
                            </div>
							<div class="col-md-4 col-sm-6">	
							 <label> Distance </label>
                                        <span class="  load-info  km" id="head_distance">0</span>
							</div>
							<div class="col-md-4 col-sm-6">	
							<label> Equipment </label>
                                        <span class="  load-info  " id="head_truck">Flatbed</span>
							</div>
							
                        </div>
                        <div class="row   trip mappop">
                            <div class="col-md-6">
                               <!--  <h4 class="subtitle">Pickup</h4> -->
                                <ul class=" ">
                                    <li class="comm_addr_org w-100" style="display: none;">
                                        <label> Pickup </label>
                                        <span class="  load-info addrs " id="head_orgaddr"></span>
                                    </li>
                                    <li>
                                        <label> Date </label>
                                        <span class="load-info" id="head_pdate">Jun 15, 2019</span>

                                    </li>
                                    <li class="loadtime" style="display: none;">
                                        <label> Time </label>
                                        <span class="  load-info  time" id="head_pickup_time">00:00:AM</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                               <!--  <h4 class="subtitle">Delivery</h4> -->
                                <ul class=" ">
                                    <li class="comm_addr_des w-100" style="display: none;">
                                        <label> Delivery </label>
                                        <span class="  load-info addrs " id="head_desaddr"></span>
                                    </li>
                                    <li>
                                        <label> Date </label>
                                        <span class="load-info" id="head_ddate">Jun 17, 2019</span>

                                    </li>
                                    <li class="loadtime" style="display: none;">
                                        <label> Time </label>
                                        <span class="load-info  time" id="head_delivery_time">00:00:AM</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row trip mappop">
                            
                                <h4 class="subtitle">Broker Details</h4>
								
								<div class="col-md-8 col-sm-12">
								<label> Broker </label>
                                <span class="  load-info  " id="head_broker">Super Logistics Logistics Logistics</span>
								</div>
								<!-- <div class="col-md-4 col-sm-12 phone_broker" style="display: none;">
								 <label> Phone </label>
                                <span class="  load-info  " id="head_phone">0000000000</span>
								</div> -->
								<div class="col-md-4 col-sm-12 comments_broker" style="display: none;">
								 <label> Comments </label>
                                <span class="  load-info  " id="head_comments">0000000000</span>
								</div>
								
								
                              <!--  <ul class=" ">
                                    <li class="w-100 ">
                                        <label> Broker </label>
                                        <span class="  load-info  " id="head_broker">Super Logistics Logistics Logistics</span>
                                    </li>
                                    <li class="phone_broker" style="display: none;">
                                        <label> Phone </label>
                                        <span class="  load-info  " id="head_phone">0000000000</span>
                                    </li>
                                    <li class="comments_broker w-100 " style="display: none;">
                                        <label> Comments </label>
                                        <span class="  load-info  " id="head_comments">0000000000</span>
                                    </li>
                                </ul> -->
								
                         
                        </div>
                            <div class="row trip mappop contact_details">
                            
                                <h4 class="subtitle">Load Contact Details</h4>
                                
                                <div class="col-md-8 col-sm-12">
                                <label>Name </label>
                                <span class="  load-info  con_nam" id="con_name">Super</span>
                                </div>
                                <div class="col-md-4 col-sm-12" >
                                 <label>Phone </label>
                                <span class="  load-info con_phn" id="con_phone">0000000000</span>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                 <label>Email </label>
                                <span class="  load-info  con_ema " id="con_email">0000000000</span>
                                </div>
                                
                          
                                
                         
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   
    $(document).on("click", ".cls_lod", function() {
        $("body").removeClass("modal-xscroll");
    });

    function mapmodal(load_id = "") {
        if (load_id != '') {
            $.ajax({
                type: 'post',
                url: LoadBoard.API + 'broker/get-load',
                dataType: "json",
                async:false,
                contentType: "application/json",
                headers: {
                    Authorization: "Bearer "+LoadBoard.token
                },
                data: JSON.stringify({ 
                    "load_id":window.atob(load_id),
                    "user_type":LoadBoard.user_type,
                    "user_id": LoadBoard.userid
                  
                 }),
                success: function(result) {
                    
                    if (result.status == 1) {
                        $(".phone_broker").hide();
                        $(".contact_details").hide();

                        
                        var orgsplit = result.data.origin.split(",");
                        var dessplit = result.data.destination.split(",");

                        var distance = distancecal(result.data.origin_lat, result.data.origin_lng, result.data.destination_lat, result.data.destination_lng);

                        $("#head_distance").html(distance);
                        $("#head_origin").html(orgsplit[0] + ", " + orgsplit[1]);
                        $("#head_destination").html(dessplit[0] + ", " + dessplit[1]);
                        $("#head_weight").html(result.data.weight);
                        $("#head_height").html(result.data.height);
                        $("#head_truck").html(result.data.truck_name);
                        $("#head_length").html(result.data.length);
                        $("#head_broker").html(result.data.business_name);
                        $("#head_loadid").html(result.data.load_id);



                        $("#head_price").html(result.data.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                        $(".comm_addr_org").hide();
                        $(".comm_addr_des").hide();
                        //Trucker
                        if (LoadBoard.user_type == 'trucker') {
                            if (result.data.content == true) {
                                $("#head_orgaddr").html(result.data.origin_address);
                                $("#head_desaddr").html(result.data.destination_address);

                                $("#head_phone").html(formatPhoneNumber(result.data.phone));
                                $(".comm_addr_org").show();
                                $(".comm_addr_des").show();
                                $(".phone_broker").show();
                                $(".contact_details").show();

                                $("#con_name").html(result.data.name);
                                $("#con_email").html(result.data.email);
                                $("#con_phone").html(formatPhoneNumber(result.data.con_phone));

                                
                                
                            }
                           // alert(result.data.suggest_comments)
                            if (result.data.suggest_comments != '') {
                                $("#head_comments").html(result.data.suggest_comments);
                                $(".comments_broker").show();
                            }
                        }

                        //$(".comments_broker").hide();
                        if (LoadBoard.user_type == 'broker') {
                            $("#head_orgaddr").html(result.data.origin_address);
                            $("#head_desaddr").html(result.data.destination_address);
                            $(".comm_addr_org").show();
                            $(".comm_addr_des ").show();
                            $("#head_phone").html(formatPhoneNumber(result.data.phone));
                            $(".phone_broker").show();
                            $(".contact_details").show();
                            $("#con_name").html(result.data.name);
                            $("#con_email").html(result.data.email);
                            $("#con_phone").html(formatPhoneNumber(result.data.con_phone));
                            if (result.data.suggest_comments != '') {
                                $("#head_comments").html(result.data.suggest_comments);
                                $(".comments_broker").show();
                            }

                        }

                        //Pickup time and delivery time 
                        $(".loadtime").hide();
                        if (result.data.pickup_time != '' && result.data.delivery_time != '') {
                            $("#head_pickup_time").html(result.data.pickup_time);
                            $("#head_delivery_time").html(result.data.delivery_time);
                            $(".loadtime").show();

                        }

                        var pdate = result.data.pickup_date.split("-");
                        var pyear = pdate[0];
                        var pmonth = pdate[1];
                        var pdate = pdate[2];
                        var p_mthname = GetMonthName(pmonth);
                        var pdata = p_mthname + " " + pdate + ", " + pyear;
                        $("#head_pdate").html(pdata);
                        
                        var ddate = result.data.delivery_date.split("-");
                        var dyear = ddate[0];
                        var dmonth = ddate[1];
                        var ddate = ddate[2];
                        var d_mthname = GetMonthName(dmonth);
                        var ddata = d_mthname + " " + ddate + ", " + dyear;
                        $("#head_ddate").html(ddata);

                        var created_date = result.data.created_date.split("-");
                        var cdyear = created_date[0];
                        var cdmonth = created_date[1];
                        var cddate = created_date[2];
                        var cd_mthname = GetMonthName(pmonth);
                        var cddata = cd_mthname + " " + cddate + ", " + cdyear;
                        $("#head_created_date").html(cddata);

                        


                        var org = result.data.origin;
                        var des = result.data.destination;
                        var orglat = result.data.origin_lat + "," + result.data.origin_lng;
                        var deslat = result.data.destination_lat + "," + result.data.destination_lng;
                        var framesrc = LoadBoard.APP + "map?org=" + window.btoa(orglat) + "&des=" + window.btoa(deslat);
                        var iframe = '<iframe src="' + framesrc + '" style="width:100%;min-height:200px;"   scrolling="no" allowfullscreen  frameBorder="0" ></iframe>';
                        $(".mapview_head").html(iframe);
                        $("body").addClass("modal-xscroll");

                        $("#common_modal").modal("show");
                    } else if (result.status == 2) {
                        window.location.href = LoadBoard.APP + "logout";
                    }

                }
            });

        }

    }







    function formatPhoneNumber(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
        var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
        if (match) {
            return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
        }
        return null
    }

    //Get Month Name
    function GetMonthName(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber - 1];
    }
</script>