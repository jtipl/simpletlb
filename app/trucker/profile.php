 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->Header("SimpleTLB - Trucker Profile");
 ?>
  <div class="py-3 ">
   <div class="container animated fadeIn">
      <div class="text-center top_profile  ">
         <h2 class="display-4 my-4 text-primary">Welcome to SimpleTLB</h2>
         <p>Please complete your profile to serve you best!</p>
      </div>
      <div class="row top_profile">
         <div class="col col-profile mx-auto">
            <form class="card animated bounceInDown" id="add_profile" role="form"  method="post" autocomplete="off">
               <div class="card-body p-4">
                  <div class="card-title text-cyan text-center"><?php $name=isset($_SESSION['name']) ? $_SESSION['name'] : ''; echo ucfirst($name); ?> </div>
                  <div class="card-subtitle  text-center"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?></div>


<div class="row">
  <div class="col-md-6">
      <div class="form-group">
          <label class="form-label">Address</label>
          <textarea rows="1" class="form-control" name="address" id="address"  placeholder="Address"></textarea>
          <label id="address-error" class="error" for="address" style="display: none;"></label>
        </div>
    </div>
     <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Country</label>      
        <select class="form-control" name="country" id="country">
            <option value="">--Select Country--</option>
           
         </select>
         <label id="country-error" class="error" for="country" style="display: none;"></label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">State</label>      
          <select class="form-control" name="state" id="state">
             <option value="">Please Select State</option> 
          </select>
          <label id="state-error" class="error" for="state" style="display: none;"></label>
      </div>
    </div>
    <div class="col-md-6">
       <div class="form-group">
          <label class="form-label">City</label>      
            <select class="form-control" name="city" id="city">
               <option value="">Please Select City</option> 

            </select>
            <label id="city-error" class="error" for="city" style="display: none;"></label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">ZIP Code</label>
            <input type="text" class="form-control" name="zipcode" id="zipcode"  placeholder="ZIP Code" >
            <label id="zipcode-error" class="error" for="zipcode" style="display: none;"></label>
          </div>
          <input type="hidden" name="city_name" id="city_name">
          <input type="hidden" name="state_name" id="state_name">
        </div>
  <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Phone</label>
                           <input type="text" name="phone" id="phone" class="form-control"  data-mask-clearifnotmatch="true" placeholder="(000) 000 - 0000">        
                        </div>
            </div>
            <div class="col-md-6">
                        <div class="form-group">
                              <label class="form-label">US DOT</label>
                              <input type="text" maxlength="8" name="us_dot" id="us_dot" class="form-control" placeholder="US DOT" />
                           </div>
            </div>
             <div class="col-md-6">
                        <div class="form-group">
                              <label class="form-label">Mc Number</label>
                              <input type="text" maxlength="7" name="mc_number" id="mc_number" class="form-control" placeholder="Mc Number" />
                           </div>
            </div>
            <div class="col-md-6">
                          <div class="form-group">
            <label class="form-label">Driving Licence Number</label>                        
            <input type="text" name="vehicle_licence_no" placeholder="Driving Licence Number" id="vehicle_licence_no" maxlength="20"  class="form-control" value="">
            <label id="vehicle_licence_no-error" class="error" for="vehicle_licence_no"  style="display: none;"></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">License Expiry Date</label>                        
            <input type="text" name="vehicle_expiry_date" placeholder="License Expiry Date" id="vehicle_expiry_date" date-format="mm/dd/yyyy" class="form-control" value="">
            <label id="vehicle_expiry_date-error" class="error" for="vehicle_expiry_date" style="display: none;"></label><span class="input-icon-addon"><i class="fe fe-calendar" style="padding: 15px 12px 2px 2px;"></i></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">License Issuing State</label>                        
            <select name="vehicle_issuing_state"  id="vehicle_issuing_state"  class="form-control">
                <option value="">--Select License Issuing State--</option>
            </select>
            <label id="vehicle_issuing_state-error" class="error" for="vehicle_issuing_state" style="display: none;"></label>
          </div>
        </div>
        

                      <div class="col-md-12 text-center" >
                        <button type="submit" class="btn btn-primary  text-center" >Save</button>
                      </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="alert alert-successn text-center my-7  p-6 animated bounceInDown profile_success" role="alert">
         <div class="avatar avatar-xxl bg-white">
            <i class="fe fe-check-circle text-success " data-toggle="tooltip" data-original-title="" title=""></i>
         </div>
         <h2 class="display-4 my-4  ">Thank You! You can now start looking for loads</h2>
         <a href="<?php echo SITEURL; ?>app/trucker/search-loads" type="button" id="goto" class="btn btn-primary">Search Loads</a>
      </div>
   </div>
  </div>
  <?php $Global->Footer(); ?>
  <link href="<?php echo SITEURL; ?>app/assets/css/animate.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
       <script type="text/javascript">
      $(document).ready(function() {
          issuing_state();
           $("#vehicle_expiry_date").attr("readonly","readonly");

$("#vehicle_expiry_date").datepicker({
  todayHighlight:'TRUE',
  startDate: '-0d',
  autoclose: true,
  onSelect: function() {
    return $(this).trigger('change');
  }
});
Getcountrylist();
$('#country').on('change', function() {
    if(this.value!=''){
      state_list(this.value);
   }
  });

$('#state').on('change',function(){
    var state_id = $(this).val();
    city_list(state_id);
});
         $('.profile_success').hide();
          jQuery.validator.addMethod("validatePhone", function (txtPhone) {
            //var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/;
                  var filter=/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/;

                if (filter.test(txtPhone)) {
                    return true;
                } else {
                    return false;
                }
            });
         jQuery.validator.addMethod("driving_licence_no", function (inputtxt) {
              var filter = /[\'^£$%&*()}{@#~?><>,|=_+¬-]/;
              if (filter.test(inputtxt)) {
                  return false;
              } else {
                  return true;
              }
          });

         $("#vehicle_licence_no").attr("maxlength",20);

        $('#vehicle_licence_no').on('keypress', function() {
          var c = this.selectionStart,
              r = /[^a-z0-9]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
        });

          jQuery.validator.addMethod("validateZip", function (txtZip) {
                  var country=$("#country").val();
                  if(country==231){
                    var us =  /^\d{5}(?:-\d{4})?$/;
                    if (us.test(txtZip)) {
                        return true;
                    }else {
                        return false;
                    }
                  }else if(country==38){
                    var canada = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;
                    if (canada.test(txtZip)) {
                        return true;
                    }else {
                        return false;
                    }
                  }
                 
              });
        
         $("#add_profile").validate({
              rules: {
                phone:{
                  required: true,
                  validatePhone: true,
                },
                us_dot:{
                  required: true,
                  minlength:8
                },
                address:{
                  required:true
                },
                country:{
                  required:true
                },
                state:{
                  required:true
                },
                city:{
                  required:true
                },
                zipcode:{
                  required:true,
                  validateZip:true,
                   minlength:5,
                }
              },
              messages: {
                  address:{
                    required:"Please Enter the address"
                  },
                  country:{
                    required:"Please Select the country"
                  },
                  state:{
                    required:"Please Select the state"
                  },
                  city:{
                    required:"Please Enter the city"
                  },
                  zipcode:{
                    required:"Please Enter the zipcode",
                    validateZip:"Enter a valid zipCode"
                  },
                  phone:{
                    required: "Please enter the Phone Number",
                    validatePhone: "Enter a valid phone Number",
                    minlength:"Enter a valid zipCode",
                  },
                  us_dot:{
                    required: "Please enter the US DOT Number",
                    minlength:"Enter a valid US DOT",
                   },
                  max_weight:{
                    required: "Please enter the Weight",
                    minlength:"Enter a valid Weight",
                  },
                   max_length:{
                    required: "Please enter the length",
                    minlength:"Enter a valid Length",
                  },
                  equipment:{
                    required: "Equipment Type should not be empty",
                  }
               },
            submitHandler: function() {

                var data=$('#add_profile').serialize();

                var city_name=$("#city option:selected").html();
                  var state_name=$("#state option:selected").html();
                  
                  //alert(state_name);
                  $("#city_name").val(city_name);
                  $("#state_name").val(state_name);
                var vehicle_licence_no = $("#vehicle_licence_no").val();
                var vehicle_issuing_state = $("#vehicle_issuing_state").val();
                var vehicle_expiry_date = $("#vehicle_expiry_date").val();
                /*
                if(vehicle_licence_no!="" && vehicle_issuing_state==""){
                  $("label#vehicle_issuing_state-error").html('Please select the license issuing state').css('display','block');
                } if(vehicle_licence_no!="" && vehicle_issuing_state!="" && vehicle_expiry_date==""){
                  $("label#vehicle_expiry_date-error").html('Please pick the license Expiry Date').css('display','block');
                } else if(vehicle_issuing_state!="" && vehicle_licence_no==""){
                  $("label#vehicle_licence_no-error").html('Please enter the driving license No').css('display','block');
                }

                else {
                 */

                if (vehicle_licence_no != "") {
                    if (vehicle_issuing_state == "" && vehicle_expiry_date == "") {
                      //  $("#vehicle_expiry_date").css("border", "1px solid red");
                        $("label#vehicle_expiry_date-error").html('Please pick the License Expiry Date').css('display', 'block');
                      //  $("#vehicle_issuing_state").css("border", "1px solid red");
                        $("label#vehicle_issuing_state-error").html('Please select the License Issuing State').css('display', 'block');
                        //$("#vehicle_licence_no").css('border','1px solid rgba(0, 40, 100, 0.20');
                        return false;
                    }
                }

                if (vehicle_issuing_state != "") {
                    if (vehicle_licence_no == "" && vehicle_expiry_date == "") {
                       // $("#vehicle_licence_no").css("border", "1px solid red");
                        $("label#vehicle_licence_no-error").html('Please enter the Driver License Number').css('display', 'block');
                      //  $("#vehicle_expiry_date").css("border", "1px solid red");
                        $("label#vehicle_expiry_date-error").html('Please pick the License Expiry Date').css('display', 'block');
                        //  $("#vehicle_issuing_state").css('border','1px solid rgba(0, 40, 100, 0.20');
                        return false;
                    }
                }
                if (vehicle_expiry_date != "") {
                    if (vehicle_licence_no == "" && vehicle_issuing_state == "") {
                        // $("#vehicle_expiry_date").css('border','1px solid rgba(0, 40, 100, 0.20');
                       // $("#vehicle_issuing_state").css("border", "1px solid red");
                        $("label#vehicle_issuing_state-error").html('Please select the License Issuing State').css('display', 'block');
                       // $("#vehicle_licence_no").css("border", "1px solid red");
                        $("label#vehicle_licence_no-error").html('Please enter driver License Number').css('display', 'block');
                        return false;
                    }
                }
                add_profile(data);
               //}
            }
         });

         $("#phone,#us_dot,#max_weight,#max_length").keypress(function(e){
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

        $("#phone,#us_dot,#max_weight,#max_length").keypress(function(e){ 
           if (this.value.length == 0 && e.which == 48 ){
            return false;
           }
        });

        document.getElementById('phone').addEventListener('input', function (e) {
          var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
          e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? ' - ' + x[3] : '');
        });

  });


       function add_profile(data){
         var Url;
         $.ajax({
            type: 'post',
            url: LoadBoard.API+'trucker/profile',
            dataType: "json",
            headers: {
                 Authorization: "Bearer "+LoadBoard.token
              },
             contentType: "application/json",
          //  data: data+"&token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
            data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
              "city_name":$("#city_name").val(),
              "state_name":$("#state_name").val(),
              "address":$("#address").val(),
              "country":$("#country").val(),
              "state":$("#state").val(),
              "city":$("#city").val(),
              "zipcode":$("#zipcode").val(),
              "phone": $("#phone").val(),
              "us_dot": $("#us_dot").val(),
              "vehicle_licence_no":$("#vehicle_licence_no").val(),
              "vehicle_issuing_state":$("#vehicle_issuing_state").val(),
              "vehicle_expiry_date":$("#vehicle_expiry_date").val(),
               "mc_number": $("#mc_number").val(),
            }),
            
            success: function (result) {
              //return false;
              if(result.status==1){
                toastr.options = { 
                  "progressBar": true,
                  "positionClass": "toast-top-full-width",
                  "timeOut": "2000",
                  "extendedTimeOut": "1000",
                }
            toastr.success(result.msg); 
              $('.top_profile').hide();
              $('.profile_success').show();
              $('#add_profile')[0].reset();                   
            }else if(result.status==0){/*
                toastr.options = { 
                "progressBar": true,
                "positionClass": "toast-top-full-width",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
                }
                toastr.error(result.msg);     
                */     

                if(result.msg=="Zip code cannot be empty"){
                  $("label#zipcode-error").html(result.msg).css('display','block');
                  return false;
                }else if(result.msg.zipcode=="Enter a valid zipcode"){
                  $("label#zipcode-error").html(result.msg.zipcode).css('display','block');
                  return false;
                }  else if(result.msg=="City cannot be empty"){
                  $("label#city-error").html(result.msg).css('display','block');
                  return false;
                } else if(result.msg=="State cannot be empty"){
                  $("label#state-error").html(result.msg).css('display','block');
                  return false;
                } else if(result.msg=="Country cannot be empty"){
                  $("label#country-error").html(result.msg).css('display','block');
                  return false;
                } else if(result.msg=="Address cannot be empty"){
                  $("label#address-error").html(result.msg).css('display','block');
                  return false;
                } /*else if(result.msg.veh_issuing_state=="Please Select the Issuing State"){
                  alert("issuing state")
                  
                  $("label#vehicle_expiry_date-error").html('Please pick the license Expiry Date').css('display','block')
                  $("label#vehicle_licence_no-error").html('Please enter the driving license No').css('display','block');
                  return false;
                } else if(result.msg.veh_license_no=="Please Enter the Vehicle Licence Number"){
                  alert("license");
                  $("label#vehicle_issuing_state-error").html('Please select the license issuing state').css('display','block');
                  $("label#vehicle_expiry_date-error").html('Please pick the license Expiry Date').css('display','block')
                  return false;
                } else if(result.msg.vehicle_expiry_date=="Please Pick the Vehicle Expiry Date"){
                  alert("expiry date");
                  $("label#vehicle_licence_no-error").html('Please enter the driving license No').css('display','block');
                  $("label#vehicle_issuing_state-error").html('Please select the license issuing state').css('display','block');
                  return false;
                }*/

                  
                  
                  
              }else if(result.status==2){
                  window.location.href = LoadBoard.APP+'logout';                   
             }
            }
         });        
      }

    $("#equipment").attr('checked','checked');

    //phone validation broker/add-load
          function validatePhone(txtPhone) {
            var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/;
            if (filter.test(txtPhone)) {
                return true;
            } else {
                return false;
            }
          }

function issuing_state(state){
    var state = state;
     $.ajax({
          type: 'post',
          url:LoadBoard.API+'trucker/location-list',
          dataType: "json",
          headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"state_list",
                "country_id":"231"         
            }),
          contentType: "application/json",
        success:function(result){
          if(result.status){
            if(result.data.length!=0){
            for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==state){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                var option="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
                $("#vehicle_issuing_state").append(option); 
              }
            }
          }
        }
      }); 
    }

function Getcountrylist(country=""){
   var countrys= country;
    $.ajax({
          type: 'post',
          url:LoadBoard.API+'trucker/location-list',
          dataType: "json",
          headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"country_list",       
            }),
          contentType: "application/json",
      success:function(result){
        if(result.status == 1){
           var country=$("#country").val();
          if(result.data.length!=0){
              $("#country").empty();
              var option="<option value=''>Select Country</option>";                        
              for (var i =0; i<result.data.length; i++) {
               
               if(result.data[i]['id']==countrys){
                  var selected = "selected=selected";
               } else {
                  var selected = "";
               }
               option+="<option value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
              }
             $("#country").html(option);    
          }
        }
      }
  }); 
} 

function state_list(country="",state=""){
  var state = state;
 $.ajax({
          type: 'post',
          url:LoadBoard.API+'trucker/location-list',
          dataType: "json",
          headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"state_list",
                "country_id":country       
            }),
          contentType: "application/json",
    //data:{operation:"state_list" ,country_id:country },
    success:function(result){
      if(result.status == 1){
        if(result.data.length!=0){
          $("#state").empty();
           var option="<option value=''>Please Select State</option>"; 
            for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==state){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option  value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
                
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
          type: 'post',
          url:LoadBoard.API+'trucker/location-list',
          dataType: "json",
          headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"city_list",
                "state_id":state       
            }),
          contentType: "application/json",
       // data:{operation:"city_list" , state_id: state},
        success:function(result){
         
          if(result.status == 1){
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
      </script>