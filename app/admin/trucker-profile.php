    <?php
    require_once("../../elements/Global.php");
    $Global=new LoadBoard();
    $Global->admin_header("SimpleTLB - Trucker Profile");
    ?>
<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid pt-30">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-3 col-xs-12">
                <div class="panel panel-default card-view  pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body  pa-0">
                            <div class="profile-box">
                                <div class="profile-cover-pic">
                                    <div class="profile-image-overlay"></div>
                                </div>
                                <div class="profile-info text-center mb-15">
                                    <div class="profile-img-wrap">
                                        <img class="inline-block mb-10" src="../img/mock1.jpg" alt="user" />
<!--                                         <div class="fileupload btn btn-default">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" type="file">
                                        </div> -->
                                    </div>
                                    <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-dark business_name" id="trucker_names">Madalyn Rascon</h5>
                                    <h6 class="block capitalize-font pb-20 " id="trucker_business_name">Developer Geek</h6>
                                </div>
                                <div class="social-info">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <span class="counts block head-font"><span class="counter-anim" id="favorites">00</span></span>
                                            <span class="counts-text block">Favorites</span>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <span class="counts block head-font"><span class="counter-anim" id="rate">246</span></span>
                                            <span class="counts-text block">Rating</span>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <span class="counts block head-font"><span class="counter-anim" id="like">898</span></span>
                                            <span class="counts-text block">Likes</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pb-0">
                            <div class="tab-struct custom-tab-1">
                                <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                                    <li class="active" role="presentation"><a data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false"><span>profile</span></a></li>
                                </ul>
<div class="tab-content" id="myTabContent_8">
    <div id="profile_8" class="tab-pane fade active in" role="tabpanel">
        <div class="col-lg-12">
            <div class="">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="col-lg-12">
                            <div class="form-wrap">
                                <form action="#">
                                    <div class="form-body overflow-hide">
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                <input type="text" class="form-control" id="trucker_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Business Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                                                <input type="email" class="form-control" id="tr_business_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                                <input type="email" class="form-control" id="trucker_email">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input type="email" class="form-control" id="trucker_phone">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Driver License Number</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input type="email" class="form-control" id="trucker_license_no">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">License Issuing State</label>
                                            <select class="form-control custom-select" name="license_issue_state" id="license_issue_state">
                                                <option value="">Please Select State</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">License Expiry Date</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="license_date">
                                                <span class="input-group-addon">
                                                  <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">Vehicle Number</label>
                                            <input type="text" class="form-control" name="us_dot" id="us_dot" value="">
                                         </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>   
   <?php  $Global->admin_footer();?>
   <script type="text/javascript">
       $(document).ready(function(){

        //state_list();
         $("#trucker_phone").focusout(function(){
          var val_exp = $(this).val().split('-');
          var val_open_bracket = val_exp[0].split('(');
          var val_close_bracket = val_exp[0].split(')');
          var val_open_bracket_replace =val_open_bracket[1].replace(')','');
          var val_close_bracket_replace =val_close_bracket[0].replace('(','');
          //alert(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          var val = parseFloat(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          if (isNaN(val) || (val === 0))
          {
            $("#trucker_phone").val('');
            $("label#trucker_phone-error").html('Phone number cannot accept all zero values').css('display','block');
            return false;
          } else {
            $("label#trucker_phone-error").html("").css('display','none');
            return true;
          }

        });
/*
        $("#trucker_phone,#us_dot").keypress(function(e){
            var regex = new RegExp(/^[0-9]+$/);
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else {
                e.preventDefault();
                return false;
            } 
          });
*/
        var user_id=getUrlParameter('id');
         getBrokerProfile(user_id);
       });

function getBrokerProfile(user_id){ 
  $.ajax({
      type: 'post',
      url: LoadBoard.API+'trucker/get-profile',
      dataType: "json",
      headers: {
           Authorization: "Bearer "+LoadBoard.admintoken
          },
      data: JSON.stringify({ 
                "user_id":user_id            
            }),
      contentType: "application/json",
      //data:{user_id:user_id,token:LoadBoard.admintoken},
      async:false,
      success: function (result) {
        console.log(result);  
          if(result.status==1){
              $("#trucker_name").val(result.data.name);
              $("#tr_business_name").val(result.data.business_name);
              $("#trucker_email").val(result.data.email);
              $("#trucker_phone").val(formatPhoneNumber(result.data.phone));
              $("#us_dot").val(result.data.vehicle_number);
              $("#trucker_names").html(result.data.name);
              $("#trucker_business_name").html(result.data.business_name);
              $("#favorites").html(result.data.my_favorite);
              $("#trucker_license_no").html(result.data.vehicle_licence_no);
              state_list(result.data.vehicle_issuing_state);
              $("#license_date").html(result.data.vehicle_expiry_date);
          }else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   
          }
      }
  });       
}

function state_list(state=""){
    var state = state;
     $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/location-list',
        dataType: 'json',
        async:false,
        data:{operation:"state_list" ,country_id:231 },
        success:function(result){
          
          if(result.status){
            if(result.data.length!=0){
              $("#license_issue_state").empty();
               var option="<option value=''>Please Select State</option>"; 
            for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==state){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
               
              }
               $("#license_issue_state").append(option); 
               


            }
          }
        }
      }); 
    }
   </script>>
 