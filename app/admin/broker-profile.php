    <?php
    require_once("../../elements/Global.php");
    $Global=new LoadBoard();
    $Global->AfterAdminloginCheck();
    $Global->admin_header("SimpleTLB - Broker Profile");
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
                          <img class="inline-block mb-10" src="../img/mock1.jpg" alt="user"/>
                          <div class="fileupload btn btn-default">
                            <span class="btn-text">edit</span>
                            <input class="upload" type="file">
                          </div>
                        </div>  
                        <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-dark business_name" id="broker_names">Madalyn Rascon</h5>
                        <h6 class="block capitalize-font pb-20 " id="broker_business_name">Developer Geek</h6>
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
                <div  class="panel-body pb-0">
                  <div  class="tab-struct custom-tab-1">
                    <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                      <li class="active" role="presentation"><a  data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false"><span>profile</span></a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent_8">
                      <div  id="profile_8" class="tab-pane fade active in" role="tabpanel">
                          <div class="col-lg-12">
                            <div class="">
                              <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                  <div class="col-lg-12">
                                    <div class="form-wrap">
                                      <form action="#">
                                        <div class="form-body overflow-hide">
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputuname_01">Name</label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                              <input type="text" class="form-control" id="broker_name"  >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Business Name</label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-briefcase"></i></div>
                                              <input type="email" class="form-control" id="business_name" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Email</label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                              <input type="email" class="form-control" id="broker_email" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputEmail_01">Phone</label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                              <input type="email" class="form-control" id="broker_phone" >
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10" for="exampleInputuname_01">Address</label>
                                            <div class="input-group">
                                              <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                                              <input type="text" class="form-control" id="broker_addr">
                                            </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">Country</label>
                                            <select class="form-control" id="country"  tabindex="1">
                                             
                                            </select>
                                          </div>
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">State</label>
                                            
                                            <select class="form-control custom-select"  name="state" id="state">
                <option value="">Please Select State</option>
              </select>

                                          </div>
                                           <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">City</label>
                                            <input type="hidden" id="city_val" value="">
                <select class="form-control custom-select" name="city" id="city">
                    <option value="">Please Select City</option>
                </select>
                                          </div>  
                                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label class="control-label mb-10">Zip</label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" value="" >
                                          </div>

                                        </div>
<!--                                         <div class="form-actions mt-10">      
                                          <button type="submit" class="btn btn-success mr-10 mb-30">Update profile</button>
                                        </div>  -->       
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
 
$(document).ready(function(){/**/
 Getcountrylist();

 $('#country').on('change', function() {
  if(this.value!=''){
       state_list(this.value);
  }
});

$('#state').on('change',function(){
    var state_id = $(this).val();
    if(state_id!=''){
      city_list(state_id);
  }
});


 $("#broker_phone").focusout(function(){
        //var val = parseFloat($('#broker_phone').val());
          var val_exp = $(this).val().split('-');
          var val_open_bracket = val_exp[0].split('(');
          var val_close_bracket = val_exp[0].split(')');
          var val_open_bracket_replace =val_open_bracket[1].replace(')','');
          var val_close_bracket_replace =val_close_bracket[0].replace('(','');
          //alert(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          var val = parseFloat(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          if (isNaN(val) || (val === 0))
          {
            $("#broker_phone").val('');
            $("label#broker_phone-error").html('Phone number cannot accept all zero values').css('display','block');
            return false;
          } else {
            $("label#broker_phone-error").html("").css('display','none');
            return true;
          }
        }); 



     $("#broker_phone,#zipcode").keypress(function(e){
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

   
    $( document ).on("click", ".update_pro", function(){
      var data=window.atob($("#data-profile").attr("data-profile"));
      broker_profile(data);   
      $("#por_upcom_status").modal("hide");

    });


      $("#broker_phone,#zipcode").keypress(function(e){ 
                 if (this.value.length == 0 && e.which == 48 ){
                  return false;
                 }
          });
 
      $('#broker_phone').on('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
         e.target.value = !x[2] ? x[1] : '(' + x[1] + ')-' + x[2] + (x[3] ? '-' + x[3] : '');
        });

 
    $("#broker_email").attr("readonly","readonly");


      $('#zipcode').on("focusout",function(e){
          var city=$("#city option:selected").html();
          var state=$("#state option:selected").html();
          var zipcode= $(this).val();
              $.ajax({
                type:'POST',
                url:LoadBoard.API+'broker/location-list',
                dataType: 'json',
                data:{operation:"zip_list",city_name:city,state_name:state,zipcode:zipcode},
                success:function(result){
                      if(result.status==0){
                         $("#zipcode").css("border","1px solid red");
                         $("#zipcode-error").html("Enter a valid ZipCode").show();
                        //toastr.error("Enter a valid ZipCode ");
                       return false;   
                     }
                }
            });
         
        });

        var user_id=getUrlParameter('id');
        //alert(user_id)
         getBrokerProfile(user_id);
   
});


function getBrokerProfile(user_id){
  $.ajax({
      type: 'post',
      url: LoadBoard.API+'broker/get-broker',
      dataType: "json",
      headers: {
        Authorization: "Bearer "+LoadBoard.admintoken
      },
      data: JSON.stringify({
          "broker_id": user_id,
      }),
      contentType: "application/json",
      //data:{"broker_id":user_id,token:LoadBoard.admintoken},
      async:false,
      success: function (result) {
          if(result.status==1){
              if(result.data.address_line1!=""){
                var address1 = result.data.address_line1;
              } else {
                var address1 = "";
              }
              
              $("#broker_name").val(result.data.name);
              $("#business_name").val(result.data.business_name);
              $("#broker_email").val(result.data.email);
              $("#broker_phone").val(formatPhoneNumber(result.data.phone));
              $("#broker_addr").val(address1);
              $("#zipcode").val(result.data.zipcode);
              $("#broker_names").html(result.data.name);
              $("#broker_business_name").html(result.data.business_name);
              $("#favorites").html(result.data.my_favorite);
              Getcountrylist(result.data.country);
              state_list(result.data.country,result.data.state);
              city_list(result.data.state,result.data.city);
          }else if(result.status==2){
             window.location.href = LoadBoard.APP+'logout';                   
          }
      }
  });       
}


function state_list(country="",state=""){
    var state = state;
     $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/location-list',
        dataType: 'json',
        async:false,
        data:{operation:"state_list" ,country_id:country },
        success:function(result){
          
          if(result.status){
            if(result.data.length!=0){
              $("#state").empty();
               var option="<option value=''>Please Select State</option>"; 
            for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==state){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
               
              }
               $("#state").append(option); 
               $("#city").val("");



            }
          }
        }
      }); 
    }

function city_list(state_id="",city=""){
    var state = state_id;
    var city = city;
     $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/location-list',
        dataType: 'json',
        async:false,
        data:{operation:"city_list" , state_id: state},
        success:function(result){
         
          if(result.status){
            if(result.data.length!=0){
                $("#city").empty();
                var option="<option value=''>Please Select City</option>";                        
                for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==city){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
                }
               $("#city").html(option);    
            }
          }
        }
    }); 
  }


  
   

    function formatPhoneNumber(phoneNumberString) {
  var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
  var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
  if (match) {
    return '(' + match[1] + ')'+' '+ match[2] + ' - ' + match[3]
  }
  return null
}

function Getcountrylist(country=""){
   var countrys= country;
    $.ajax({
        type:'POST',
        url:LoadBoard.API+'broker/location-list',
        dataType: 'json',
        async:false,
        data:{operation:"country_list"},
        success:function(result){
          if(result.status){
             var country=$("#country").val();
            if(result.data.length!=0){
                $("#country").empty();
                var option="<option value=''>Please Select Country</option>";                        
                for (var i =0; i<result.data.length; i++) {
                 
                 if(result.data[i]['id']==countrys){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
                }
               $("#country").html(option);    
            }
          }
        }
    }); 
}
</script>