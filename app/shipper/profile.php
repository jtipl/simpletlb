 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Shipper Profile");
 ?>
 <div class="py-3 my-md-5">
  <div class="container animated fadeIn">
  <div class="text-center top_profile ">
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
               <label class="control-label">Phone</label>
               <input type="text" name="phone" id="phone" class="form-control"   data-mask-clearifnotmatch="true" placeholder="(000) 000 - 0000">        
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Address</label>
            <textarea rows="2" class="form-control" name="address" id="address"  placeholder="Business Address"></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Country</label>      
            <select class="form-control" name="country" id="country">
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">State</label>      
              <select class="form-control" name="state" id="state">
              <!--   <option value="">Please Select State</option> -->
              </select>
          </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
            <label class="control-label">City</label>      
              <select class="form-control" name="city" id="city">
              <!--   <option value="">Please Select City</option> -->

              </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Zip</label>
            <input type="text" class="form-control" name="zipcode" id="zipcode"  placeholder="ZIP Code" >
            <label id="zipcode-error" class="error" for="zipcode" style="display: none;"></label>
          </div>
          <input type="hidden" name="city_name" id="city_name">
          <input type="hidden" name="state_name" id="state_name">
        </div>
            <div class="col-md-12 text-center" >
            <button type="submit" class="btn btn-primary nextBtn pull-right" >Save</button>
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
        <h2 class="display-4 my-4  ">Thank You! You can now start adding loads.</h2>
        <!-- <p>You can now start using LoadBoard application</p> -->
        <a href="<?php echo SITEURL; ?>app/shipper/add-load" id="goto" class="btn btn-primary">Add Loads</a>
    </div> 


  </div>
</div>
  <?php $Global->Footer(); ?>
       <script type="text/javascript">
            $(document).ready(function(){
            $('#country').on('change', function() {
              if(this.value!=''){
                state_list(this.value);
             }
            });

         $('#state').on('change',function(){
              var state_id = $(this).val();
              city_list(state_id);
         });
         //state_list();
         //city_list(3919);
    });

      $(document).ready(function() {
        Getcountrylist();
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
             /* jQuery.validator.addMethod("validateZip", function (txtZip) {
                  var filter = /^[0-9]{5}(-[0-9]{4})?$/;
                  var filter1 = /^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$/;
                   
                    if (filter.test(txtZip)) {
                        return true;
                    }else if(filter1.test(txtZip)){
                        return true;
                    } else {
                        return false;
                    }
              });
*/
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
                      required:true,
                      validatePhone: true,
                    },
                    address:{
                      required:true,
                    },
                    country:{
                      required:true,
                     },
                    state:{
                      required:true,
                    },
                    city:{
                      required:true,
                    },
                    zipcode:{
                      required:true,
                      validateZip: true,
                      minlength:5,
                    }

                  },
                  messages: {
                    phone:{
                      required:"Phone number cannot be empty",
                      validatePhone:"Enter a valid phone Number",
                    },
                    address:{
                      required:"Address cannot be empty",
                    },
                    country:{
                      required:"Country cannot be empty",
                     },
                    state:{
                      required:"State should not be empty",
                    },
                    city:{
                      required:"City cannot be empty",
                    },
                    zipcode:{
                      required:"Zip code cannot be empty",
                      validateZip:"Enter a valid zipCode",
                      minlength:"Enter a valid zipCode",
                    }
                  },
                  submitHandler: function() {
                  var city_name=$("#city option:selected").html();
                  var state_name=$("#state option:selected").html();
                  $("#city_name").val(city_name);
                  $("#state_name").val(state_name);
                  var data=$('#add_profile').serialize();
                  add_profile(data);
                  }
                });

        $("#phone").keypress(function(e){
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

        $("#phone").keypress(function(e){ 
                 if (this.value.length == 0 && e.which == 48 ){
                  return false;
                 }
          });

        /*$('#goto').click(function(){
           window.location.href= LoadBoard.APP+'shipper/add-load';
         // window.location.href = LoadBoard.API+'shipper/add-load';
        });*/

 
      $('#phone').on('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
         e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? ' - ' + x[3] : '');
        });



  });

       function add_profile(data){
         var Url;
         $.ajax({
            type: 'post',
            url: LoadBoard.API+'shipper/profile',
            dataType: "json",
          //  data: data+"&token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
           dataType: "json",
            headers: {
                 Authorization: "Bearer "+LoadBoard.token
              },
           data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
              "phone": $("#phone").val(),
              "address": $("#address").val(),
              "country":$("#country").val(),
              "state":$("#state").val(),
              "city": $("#city").val(),
              "zipcode": $("#zipcode").val(),
              "city_name":$("#city option:selected").html(),
              "state_name":$("#state option:selected").html(),
            }),
            contentType: "application/json",
            success: function (result) {
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
              }else if(result.status==0){
                if(result.msg =='Enter a valid zipcode'){
                   $("#zipcode").css("border","1px solid red");
                   $("#zipcode-error").html(result.msg).show();
                }
                    toastr.options = { 
                      "progressBar": true,
                      "positionClass": "toast-top-full-width",
                      "timeOut": "2000",
                      "extendedTimeOut": "1000",
                    }
                   //toastr.error(result.msg);                    
                   return false;
              }else if(result.status==2){
                  window.location.href = LoadBoard.APP+'logout';                   
             }
          }
         });        
      }
           //phone validation shipper/add-load
          function validatePhone(txtPhone) {
            var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/;
            if (filter.test(txtPhone)) {
                return true;
            } else {
                return false;
            }
          }
          //city validation
          function validateCity(txtCity) {
            var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
            if (filter.test(txtCity)) {
                return false;
            } else {
                return true;
            }
          }
          //zipcode validation
           function validateZip(txtZip) {
            var filter = /^[0-9]{5}(-[0-9]{4})?$/;
            if (filter.test(txtZip)) {
                return true;
            } else {
                return false;
            }
          }


function state_list(country="",state=""){
    var state = state;
     $.ajax({
        type:'POST',
        url:LoadBoard.API+'shipper/location-list',
        dataType: 'json',
        async:false,
         headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"state_list",
                "country_id":country        
            }),
          contentType: "application/json",
       // data:{operation:"state_list" ,country_id:country },
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
        url:LoadBoard.API+'shipper/location-list',
        dataType: 'json',
        async:false,
         headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"city_list",
                "state_id":state        
            }),
          contentType: "application/json",
        //data:{operation:"city_list" , state_id: state},
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




    $(document).ready(function() {
      $('#zipcode').on("focusout",function(e){
          var city=$("#city option:selected").html();
          var state=$("#state option:selected").html();
          var zipcode= $(this).val();
              $.ajax({
                type:'POST',
                url:LoadBoard.API+'shipper/location-list',
                dataType: 'json',
                 headers: {
                 Authorization: "Bearer "+LoadBoard.token
            },
            data: JSON.stringify({
                  "user_id":LoadBoard.userid,
                 "operation":"zip_list",
                  "city_name":city,
                  "state_name":state,
                  "zipcode":zipcode          
              }),
          contentType: "application/json",
               // data:{operation:"zip_list",city_name:city,state_name:state,zipcode:zipcode},
                success:function(result){
                      if(result.status==0){
                         $("#zipcode").css("border","1px solid red");
                         $("#zipcode-error").html("Enter a valid ZipCode").show();
                       return false;   
                     }
                }
            });
         
        });
    });
   
   function Getcountrylist(country=""){
   var countrys= country;
    $.ajax({
        type:'POST',
        url:LoadBoard.API+'shipper/location-list',
        dataType: 'json',
        async:false,
        headers: {
           Authorization: "Bearer "+LoadBoard.token
        },
        data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"country_list",  
          }),
          contentType: "application/json",
        //data:{operation:"country_list"},
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
