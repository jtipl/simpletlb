 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Profile");
//print_r($_SESSION);
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : '';
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '';
$token = isset($_SESSION['token']) ? $_SESSION['token']: '';


?>
<style type="text/css">
  .add_vehicle_tab{float: right;font-size: 16px;
    float: right;
    color: #295a9f;}
    .panel
{
  box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.1);
  border:1px solid rgba(0, 40, 100, 0.20 );
  border-radius: 5px;
  padding:15px;
}
::-webkit-input-placeholder { 
  color: #adb5bd;
}
::-moz-placeholder { 
  color: #adb5bd;
}
:-ms-input-placeholder { 
  color: #adb5bd;
}
:-moz-placeholder { 
  color: #adb5bd;
}
.mb15
{
  margin-top: 15px;
}

.tiles                            {display:block; margin:0 0 30px 0; overflow:hidden;}
.tiles .button                        {color:#fff; display:block; font-weight:bold; overflow:hidden; padding:20px 10px; text-align:center;}
.tiles .button.blue                     {background:#1f497d; border:2px solid #10253f;}
.tiles .button.orange                     {background:#f79646; border:2px solid #e46c0a;}
.tiles .button.green                    {background:#9bbb59; border:2px solid #4f6228;}

.panel-group .panel                     {margin-bottom:0; border-radius:0;}
.panel-group .panel+.panel                  {margin-top:0;}
.panel-default                        {border:none;}
.panel-heading                        {padding:10px 10px; border:none; border-radius:0; }
.panel-default>.panel-heading                 { background:none; border-top:1px solid rgba(0, 40, 100, 0.20 );}
.panel-default>.panel-heading+.panel-collapse>.panel-body   {border:none;}
/*.panel-heading .accordion-toggle:after            {content:"\e114"; float:right; color:grey;}
.panel-heading .accordion-toggle.collapsed:after      {content:"\e080";}*/
.accordion-toggle{
  font-weight: normal;
}

</style>
<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/card-js.min.css">
<script src="<?php echo SITEURL; ?>app/assets/js/card-js.min.js"></script> 
        <div class="my-3 my-md-5">
          <div class="container animated fadeIn">
            <div class="page-header">
              <i class="icon-ManageProfileB"></i>&nbsp;&nbsp;
          <h1 class="page-title">
                Manage Profile
              </h1> 
            </div>   

    <div class="row  ">
      
    <div class="col-md-12 col-lg-12 col-sm-12 ">
<div class="lb-tabs">
  <nav>
    <div class="nav lb-nav-tabss" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <i class="icon-Broker mr-2" ></i> Contact Details</a>
       
   
      
       <!-- <a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"> <i class="fa fa-credit-card mr-2" ></i> Subscription & Billing</a>      -->

      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> <i class="fa fa-key mr-2" ></i> Change Password</a>     
        
  </div>
  </nav>



   <!-- Trucker profile starts here -->   
  <div class="tab-content animated  fadeIn" id="nav-tabContent">
    <div class="tab-pane fade  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
          <form id="shipper_profile" method="post" action="">
      <div class="tab-pane fade  active show" id="nav-shipper" role="tabpanel" aria-labelledby="nav-home-tab">
       <div class="row">
          
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" placeholder="Name" value="" name="shipper_name" id="shipper_name">    
              </div>
          </div>
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Business Name</label>
                <input type="text" class="form-control" placeholder="Business Name" value="" name="business_name" id="business_name">    
              </div>
          </div>
          <div class="col-sm-6 col-md-6">
            <div class="form-group">
              <label class="form-label">Email <span class="tool toottip" data-tip="The Email address is your user id. Hence it cannot be changed. If you still want to change it, write to support desk." tabindex="1" ><i class="fa fa-question-circle-o"></i></span></label>
              <input type="email" class="form-control" placeholder="Email" value="" name="shipper_email" id="shipper_email">
            </div>
          </div>
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                      <label class="form-label">Phone</label>
                  <input type="text" name="shipper_phone" id="shipper_phone" value="" placeholder="Phone" class="form-control" >          
             </div>
          </div> 
          <div class="col-sm-6 col-md-6">
             <div class="form-group">
                  <label class="form-label">Address</label>
               <textarea rows="1" class="form-control" name="shipper_addr" id="shipper_addr" placeholder="Business Address"></textarea>
              </div>
          </div> 
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
              <label class="form-label">Country</label>      
                <select class="form-control" name="country" id="country">
                 <!--  <option value="231">United States of America</option> -->
                </select>
              </div>
          </div>    
            <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-label">State</label>
               <select class="form-control"  name="state" id="state">
                <option value="">Please Select State</option>
              </select>
              </div>
          </div> 
          <div class="col-sm-6 col-md-6">
             <div class="form-group">
                <label class="form-label">City</label>
                <input type="hidden" id="city_val" value="">
                <select class="form-control" name="city" id="city">
                    <option value="">Please Select City</option>
                </select>
              </div>
          </div> 
        
          <div class="col-sm-6 col-md-6">
           <div class="form-group">
                <label class="form-label">Zip</label>
              <input type="text" class="form-control" name="zipcode" id="zipcode" value="" placeholder="ZIP Code">
              <label id="zipcode-error" class="error" for="zipcode" style="display: none;"></label>
              </div>
          </div> 

           <input type="hidden" name="city_name" id="city_name">
           <input type="hidden" name="state_name" id="state_name">
          
         
         <div class="col-md-12  text-center">       
          <div id="msg"></div>       
           <button type="submit" class="btn btn-primary"> <i class="fe fe-edit mr-2"></i> Update Profile</button> 
        </div>
      </div>
    </form>  
  </div>
</div>
  <!-- Trucker profile ends here -->  
  <div class="tab-pane  animated  fadeIn" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
<!--    <form id="creditcard" method="post" action="">
 -->     <form id="addcredit" method="post" action="" novalidate="novalidate">
     <div class="row">
      <div class="col-sm-3 col-md-3">
       <div class="card " style="min-height: 365px;">
        <div class="card-status bg-green"></div>
                  <div class="card-body text-center">
                    <div class="card-category">Trial</div>
                    <div class="display-3 my-4">$10</div>
                    <ul class="list-unstyled leading-loose">
                      <li><strong>30</strong> Days</li>
                   
                    </ul>
                   <!--  <div class="text-center mt-6">
                      <a href="#" class="btn btn-secondary btn-block">Choose plan</a>
                    </div> -->
                  </div>
                </div>
      </div>
       <div class="col-sm-9 col-md-9">
       <!--  <form id="addcredit" method="post" action="" novalidate="novalidate"> -->
                  <div class="panel">
<div class="row">
    <div class="col-sm-6 col-md-6">
<div class="row">
<div class="col-sm-6 col-md-6">
              <div class="form-group">
              <label class="form-label">First Name</label>      
               <input type="text" class="form-control" placeholder="First Name" value="" name="firstname" id="firstname">   
              </div>
</div>
   <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-label">Last Name</label>
               <input type="text" class="form-control" placeholder="Last Name" value="" name="lastname" id="lastname">   
              </div>
            </div>
</div>
        
              <div class="form-group">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" placeholder="Address" value="" name="pay_address" id="pay_address">    
              </div>

 <div class="form-group">
              <label class="form-label">Phone</label>      
                 <input type="text" class="form-control" placeholder="Phone" value="" name="pay_phone" id="pay_phone">   
              </div>

     
<div class="row">
    <div class="col-sm-6 col-md-6">
              <div class="form-group">
              <label class="form-label">Country</label>      
                <select class="form-control" name="pay_country" id="pay_country">
                </select>
              </div>
</div>
                 <div class="col-sm-6 col-md-6">
            <div class="form-group">
                <label class="form-label">State</label>
               <select class="form-control"  name="pay_state" id="pay_state">
                <option value="">Please Select State</option>
              </select>
              </div>
            </div>
            <div class="col-sm-6 col-md-6">
             <div class="form-group">
                <label class="form-label">City</label>
                <select class="form-control" name="pay_city" id="pay_city">
                    <option value="">Please Select City</option>
                </select>
              </div>
        </div>
          <div class="col-sm-6 col-md-6">
           <div class="form-group">
               <label class="form-label">Zip</label>
              <input type="text" class="form-control" name="pay_zipcode" id="pay_zipcode" value="" placeholder="ZIP Code">
              </div>
          </div>

</div>

    </div>
        <!-- col-sm-6 col-md-6 -->
  <div class="col-sm-6 col-md-6">

          <div id="my-card-2 " class="card-js" data-capture-name="true">

            <input class="card-number my-custom-class card_number" name="card_number">
            <input class="name card_holders_name" id="the-card-name-id" name="card_holders_name" placeholder="Name on card">
            <input class="expiry_month" name="expiry_month">
            >
            <input class="expiry_year" name="expiry_year">
            <input class="cvc" name="cvc">

          </div>

             <!--  <div class="form-group mb15">
                <input type="text" class="form-control" name="billing_address" id="billing_address" value="" placeholder="Billing Address">
                </div> -->
 
          <div class=" text-right  p-2" style="margin:25px 0px 0px 0px;">     
         <button type="submit" class="btn btn-primary" >Make Payment</button>
           <div class="btn-wrapper">
      

        </div>

 </div>

 
      </div>
      <!-- col-sm-6 col-md-6 -->

    </div>
     <!-- row -->

        </div>
      <!-- </form> -->
      </div>



    </div>

    <!-- <div class="row">
      <div class="col-sm-12 col-md-12 payment_methods">
        <div class="page-header">
         <h1 class="page-title">
          <i class="fe fe-dollar-sign"></i> Payment Methods
        </h1> 
      </div>
        <div class="container">
    
    <div class="panel-group" id="accordion">
       
        
       
    </div>
</div>
      </div>
    </div> -->


  
</form>
</div>


<!-- Change Password Starts here -->
<div class="tab-pane  animated  fadeIn" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
   <form id="changepwdform" method="post" action="">
  <div class="row">
      <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <label class="form-label">Current Password</label>                        
            <input type="password" name="old_pwd" id="old_pwd" class="form-control" value="">
            <label id="old_pwd-error" class="error" for="old_pwd" style="display: none;"></label>
          </div>
          <div class="form-group">
            <label class="form-label">New Password</label>                        
            <input type="password" name="new_pwd" id="new_pwd" class="form-control" value="">
          </div>                  

          <div class="form-group">
            <label class="form-label">Confirm New Password</label>                        
            <input type="password" name="confirm_pwd" id="confirm_pwd" class="form-control" value="">
          </div>
      </div>  
     
      <div class="col-md-12  text-center">   
       <div id="msgs"></div>               
       <button type="submit" class="btn btn-primary "><i class="fe fe-check-square mr-2"></i> Change Password </button> 
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
     <div class="modal fade " id="por_upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2" id="mySmallModalLabel">Update Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h2 class="text-cyan ">Update Profile</h2>
        <p>Do you want to update the changes?</p>       
        </div>
    <div class="modal-footer">
      <input type="hidden" id="data-profile" data-profile="">
       <button type="button" class="btn btn-primary update_pro">Yes</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
    
    </div>
  </div>
</div>



<!-- <div class="modal fade" id="add_credit_card" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="common_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  " role="document">
        <div class="modal-content">
            <div class="modal-header  text-center">
                <div class="modal-title  " id="mySmallModalLabel">Add Credit Card</div>
                <button type="button" class="close creditclose" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
<form id="addcredit" method="post" action="" novalidate="novalidate">
                  <div class="panel">
          <div id="my-card-2 " class="card-js" data-capture-name="true">
             <input class="card-number my-custom-class card_number" name="card_number">
             <input class="name card_holders_name" id="the-card-name-id" name="card_holders_name" placeholder="Name on card">
   <input class="expiry_month" name="expiry_month">
  <input class="expiry_year" name="expiry_year">
    <input class="cvc" name="cvc">
          </div>
          <div class=" text-center  p-2" style="margin:10px 0px 0px 0px;">     
 
        <button type="button" class="btn btn-primary creditclose" data-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary" >Add</button>
      </div>
        </div>
      </form>

            </div>
        </div>
    </div>
</div> -->



<?php $Global->Footer(); ?>
  
   
<link href="<?php echo SITEURL; ?>app/assets/css/animate.css" rel="stylesheet" />
<script type="text/javascript">
 
$(document).ready(function(){
  $(".payment_methods").hide();
 Getcountrylist();

   $(".add_credit_card").on('click',function(){
    $("#add_credit_card").modal("show");
   });

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


$('#pay_country').on('change', function() {
  if(this.value!=''){
       state_list(this.value);
  }
});

$('#pay_state').on('change',function(){
    var state_id = $(this).val();
    if(state_id!=''){
      city_list(state_id);
  }
});
/* state_list();
 city_list(3919);
*/




 $("#shipper_phone").focusout(function(){
        //var val = parseFloat($('#shipper_phone').val());
          var val_exp = $(this).val().split('-');
          var val_open_bracket = val_exp[0].split('(');
          var val_close_bracket = val_exp[0].split(')');
          var val_open_bracket_replace =val_open_bracket[1].replace(')','');
          var val_close_bracket_replace =val_close_bracket[0].replace('(','');
          //alert(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          var val = parseFloat(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
          if (isNaN(val) || (val === 0))
          {
            $("#shipper_phone").val('');
            $("label#shipper_phone-error").html('Phone number cannot accept all zero values').css('display','block');
            return false;
          } else {
            $("label#shipper_phone-error").html("").css('display','none');
            return true;
          }
        }); 
       jQuery.validator.addMethod("validatePhone", function (txtPhone) {
                  //var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\.  ]?(\d{4})$/;
                  var filter=/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/;

                  if (filter.test(txtPhone)) {
                      return true;
                  } else {
                      return false;
                  }
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


              jQuery.validator.addMethod("busi_namevalid", function (inputtxt) {
                 var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
                  if (filter.test(inputtxt)) {
                      return false;
                  } else {
                      return true;
                  }
              });
              jQuery.validator.addMethod("name_valid", function (inputtxt) {
                 var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
                  if (filter.test(inputtxt)) {
                      return false;
                  } else {
                      return true;
                  }
              });

          jQuery.validator.addMethod("zero_validate", function (inputtxt) {
            var val_exp = inputtxt.split('-');
            var val_open_bracket = val_exp[0].split('(');
            var val_close_bracket = val_exp[0].split(')');
            var val_open_bracket_replace =val_open_bracket[1].replace(')','');
            var val_close_bracket_replace =val_close_bracket[0].replace('(','');
            //alert(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
            var val = parseFloat(val_open_bracket_replace+val_close_bracket_replace+val_exp[2]);
               // var val = parseFloat(val1);
                  if (isNaN(val) || (val === 0))
                  {
                    return false;
                } else {
                    return true;
                }
          });

          


            $("#shipper_profile").validate({
                  rules: {
                    shipper_name: {
                      required:true,
                      name_valid:true,
                    },
                    business_name: {
                      required:true,
                       busi_namevalid:true,

                    },
                    shipper_phone:{
                      required:true,
                      validatePhone: true,
                      zero_validate:true,
                    },
                    shipper_addr:{
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
                    shipper_name: {
                      required: "Please enter the name",
                      name_valid:"Please enter a valid Name",
                    },
                    business_name: {
                      required:  "Please enter the business name",
                      busi_namevalid:"Please enter a valid Business Name",

                    },
                    shipper_phone:{
                      required:"Please enter the Phone Number",
                      validatePhone:"Enter a valid Phone Number",
                      zero_validate:"Phone number cannot accept all zero values",
                    },
                    shipper_addr:{
                      required:"Please enter the Address",
                    },
                    country:{
                      required:"Please select the Country",
                     },
                    state:{
                      required:"Please select the State",
                    },
                    city:{
                      required:"Please select the City",
                    },
                    zipcode:{
                      required:"Please enter the Zip code",
                      validateZip:"Enter a valid zipCode",
                      minlength:"Enter a valid zipCode",
                    }
                  },
                  submitHandler: function() {

                  $("#city_name").val($("#city option:selected").html());
                  $("#state_name").val($("#state option:selected").html());
                  var data=$('#shipper_profile').serialize();
                  $("#data-profile").attr("data-profile",window.btoa(data));

                /*    swal.fire({
                        title: "Confirmation!",
                        text: "Do you want to update the changes?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        confirmButtonClass: 'btn-md',
                        cancelButtonClass: 'btn-md',
                        showCloseButton: true,
                        allowOutsideClick:false,
                    }).then(result => {
                      if(result.value==true){
                        var data=window.atob($("#data-profile").attr("data-profile"));
                        shipper_profile(data); 
                      }
                    });
                     $("body").removeClass("swal2-height-auto");*/
                      shipper_profile(data);   
                  }
                });

               


            $("#changepwdform").validate({
                rules: {
                  old_pwd: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                   },
                  new_pwd: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                  },
                  confirm_pwd: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                    equalTo: "#new_pwd"
                  }
                  
                },
                messages: {
                   old_pwd: {
                    required:  "Please enter the current password",
                    minlength: "New Password and Confirm Password mismatch",
                    maxlength: "New Password and Confirm Password mismatch",
                   },
                  new_pwd: {
                    required:  "Please enter the new password",
                    minlength: "New Password and Confirm Password mismatch",
                    maxlength: "New Password and Confirm Password mismatch",
                  },
                  confirm_pwd: {
                   required:  "Please enter the confirm new password",
                   minlength: "New Password and Confirm Password mismatch",
                   maxlength: "New Password and Confirm Password mismatch",
                   equalTo:   "New Password and Confirm Password mismatch"
                  }
                },
                submitHandler: function() {
                  swal.fire({
                        title: "Confirmation!",
                        text: "Do you want to update the changes?",
                        type: "success",
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
                        var data1=$('#changepwdform').serialize();
                        update_changepwd(data1);
                      }
                    });
                     $("body").removeClass("swal2-height-auto");
                }
           });

  jQuery.validator.addMethod("PayvalidateZip", function (txtZip) {
                  var country=$("#pay_country").val();
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

  var creditcard= $("#addcredit").validate({
        ignore: [],
                rules: {
                  card_number: {
                    required: true,
                   },
                  card_holders_name: {
                    required: true,
                  },
                  expiry_month: {
                    required: true,
                  
                  },/*expiry_year: {
                    required: true,
                  
                  },*/cvc: {
                    required: true,
                    minlength: 3,
                    maxlength: 3,
                  
                  },pay_address: {
                    required: true,
                    maxlength: 100,
                  },
                  pay_phone: {
                     required:true,
                     validatePhone: true,
                     zero_validate:true,
                  },
                 pay_country:{
                      required:true,
                     },
                  pay_state:{
                      required:true,
                    },
                  pay_city:{
                      required:true,
                    },
                  pay_zipcode:{
                      required:true,
                      PayvalidateZip: true,
                      minlength:5,
                    },
                    firstname:{
                      required:true,
                      name_valid:true
                     }, lastname:{
                         required:true,
                         name_valid:true

                     },
                  
                },
                messages: {
                   card_number: {
                    required:  "Please enter the Credit Card Number",
                   }, card_holders_name: {
                    required:  "Please enter the Card Holder Name",
                   }, expiry_month: {
                     required:  "Please enter the Expiry Date",
                   }, /*expiry_year: {
                    required:  "Please enter the expire year",
                   }*/ cvc: {
                    required:  "Please enter the CVV",
                   }, pay_address: {
                    required:  "Please enter the Billing Address",
                   }, 
                    pay_phone: {
                    required:  "Please enter the Phone Number",
                   }, 
                    pay_country:{
                      required:"Please select the Country",
                     },
                    pay_state:{
                      required:"Please select the State",
                    },
                    pay_city:{
                      required:"Please select the City",
                    },
                    firstname:{
                      required:"Please enter the First Name",
                       name_valid:"Please enter a valid First Name",
                    },
                 lastname:{
                      required:"Please enter the Last Name",
                       name_valid:"Please enter a valid Last Name",
                    },

                    pay_zipcode:{
                      required:"Please enter the Zip code",
                      PayvalidateZip:"Enter a valid zipCode",
                      minlength:"Enter a valid zipCode",
                    }              
                },
                submitHandler: function() {
                  swal.fire({
                        title: "Confirmation!",
                        text: "Do you want to purchase the package?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        confirmButtonClass: 'btn-md',
                        cancelButtonClass: 'btn-md',
                        showCloseButton: true,
                        allowOutsideClick:false,
                    }).then(result => {
                      //alert(result.value);
                      //console.log(result.value+"Dfg")
                      if(result.value==true){
                          addcreditcard();
                      }
                    });
                     $("body").removeClass("swal2-height-auto");
                }
           });

            $(document).on('click','.creditclose',function(e){
                      creditcard.resetForm();
                });



     $("#shipper_phone,#pay_phone").keypress(function(e){
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

   
    


      $("#shipper_phone,#pay_phone").keypress(function(e){ 
                 if (this.value.length == 0 && e.which == 48 ){
                  return false;
                 }
          });
 
      $('#shipper_phone,#pay_phone').on('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
         e.target.value = !x[2] ? x[1] : '(' + x[1] + ')-' + x[2] + (x[3] ? '-' + x[3] : '');
        });

 
    $("#shipper_email").attr("readonly","readonly");

  
      

      $('#zipcode').on("focusout",function(e){
          var city=$("#city option:selected").html();
          var state=$("#state option:selected").html();
          var zipcode= $(this).val();
              $.ajax({
                type:'POST',
                url:LoadBoard.API+'shipper/location-list',
                dataType: "json",
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
                //data:{operation:"zip_list",city_name:city,state_name:state,zipcode:zipcode},
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

         getShipperProfile(LoadBoard.userid);

         $('#the-card-name-id').keyup(function(){
            this.value = this.value.toUpperCase();
        });

         payment_methods();
   
});


function getShipperProfile(user_id){
 //alert(LoadBoard.API+'shipper-get-profile');
  $.ajax({
      type: 'post',
      url: LoadBoard.API+'shipper/get-profile',
      dataType: "json",
     // data:{user_id:LoadBoard.userid,token:LoadBoard.token},
      headers: {
                 Authorization: "Bearer "+LoadBoard.token
                },
        data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
            }),
        contentType: "application/json",
      async:false,
      success: function (result) { 
          if(result.status==1){
              if(result.data.address_line1!=""){
              var address1 = result.data.address_line1;
              } else {
              var address1 = "";
              }
              if(result.data.address_line2!=""){
              var address2 = result.data.address_line2;
              } else {
              var address2 = "";
              }
              $("#shipper_name").val(result.data.name);
              $("#business_name").val(result.data.business_name);
              $("#shipper_email").val(result.data.email);
              $("#shipper_phone").val(formatPhoneNumber(result.data.phone));
              $("#shipper_addr").val(address1+' '+address2);
              $("#zipcode").val(result.data.zipcode);

              $("#pay_zipcode").val(result.data.zipcode);
              $("#pay_address").val(address1+' '+address2);
              $("#pay_phone").val(formatPhoneNumber(result.data.phone));

              $("#the-card-name-id").val(result.data.name.toUpperCase());

              Getcountrylist(result.data.country);
              state_list(result.data.country,result.data.state);
              city_list(result.data.state,result.data.city);
          }else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   

          }
         
        

      }
  });       
}

function shipper_profile(data){
 /* $('.preloader').show();*/
  $('html, body').animate({
        scrollTop: $('html').offset().top - 0 
  }, 'fast');
 var Url;
  $.ajax({
      type: 'post',
      url: LoadBoard.API+'shipper/update-profile',
      dataType: "json",
      //data: data+"&token="+LoadBoard.token,
       headers: {
                 Authorization: "Bearer "+LoadBoard.token
                },
        data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
              "shipper_name": $("#shipper_name").val(),
              "business_name": $("#business_name").val(),
              "shipper_email": $("#shipper_email").val(),
              "shipper_phone": $("#shipper_phone").val(),
              "shipper_addr": $("#shipper_addr").val(),
              "country": $("#country").val(),
              "state": $("#state").val(),
              "city": $("#city").val(),
              "zipcode": $("#zipcode").val(),
              "city_name": $("#city_name").val(),
              "state_name": $("#state_name").val(),
            }),
        contentType: "application/json",
       success: function (result) {
          if(result.status==3){
              swal.fire({
                  title: "Confirmation!",
                  text: "Do you want to update the changes?",
                  type: "success",
                  showCancelButton: true,
                  confirmButtonText: 'Yes',
                  cancelButtonText: 'No',
                  confirmButtonClass: 'btn-md',
                  cancelButtonClass: 'btn-md',
                  showCloseButton: true,
                  allowOutsideClick:false,
              }).then(result => {
                if(result.value==true){
                   $('.preloader').show();
                  $.ajax({
                      type: 'post',
                      url: LoadBoard.API+'shipper/update-profile',
                      dataType: "json",
                      headers:{
                                 Authorization: "Bearer "+LoadBoard.token
                              },
                      data: JSON.stringify({ 
                            "user_id": LoadBoard.userid, 
                            "shipper_name": $("#shipper_name").val(),
                            "business_name": $("#business_name").val(),
                            "shipper_email": $("#shipper_email").val(),
                            "shipper_phone": $("#shipper_phone").val(),
                            "shipper_addr": $("#shipper_addr").val(),
                            "country": $("#country").val(),
                            "state": $("#state").val(),
                            "city": $("#city").val(),
                            "zipcode": $("#zipcode").val(),
                            "city_name": $("#city_name").val(),
                            "state_name": $("#state_name").val(),
                            "success_data": "valid",
                          }),
                      contentType: "application/json",
                      success: function (result) {
                        if(result.status==1){
                           $('.preloader').hide();
                            $("#zipcode").css("border","1px solid rgba(0, 40, 100, 0.20 )");
                            $("#zipcode-error").html(result.msg).hide();
                              toastr.options = { 
                              "progressBar": true,
                              "positionClass": "toast-top-full-width",
                              "timeOut": "2000",
                              "extendedTimeOut": "1000",
                            }
                            toastr.success(result.msg); 
                        }
                      }
                  });
                }
              });
              $("body").removeClass("swal2-height-auto");
          }else if(result.status==0){
             $('.preloader').hide();
           if(result.msg =='Enter a valid zipcode'){
               $("#zipcode").css("border","1px solid red");
               $("#zipcode-error").html(result.msg).show();;
              }
             return false;                   
          }
          else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   
          }
      }
  });        
}

function update_changepwd(data1){
   $('.preloader').show();
  $('html, body').animate({
        scrollTop: $('html').offset().top - 0 
  }, 'fast');
  $.ajax({
      type: 'post',
      url: LoadBoard.API+'change-password',
      dataType: "json",
      headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
      dataType: "json",
      data: JSON.stringify({ 
        "old_pwd": $("#old_pwd").val(), 
        "new_pwd": $("#new_pwd").val(),
        "confirm_pwd": $("#confirm_pwd").val(),
        "user_id":LoadBoard.userid            
      }),
      contentType: "application/json",
      //data: data1+"&token="+LoadBoard.token,
      success: function (result) {
           $('.preloader').hide();
          if(result.status==1){
           // $('.preloader').hide();
              $("#old_pwd").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#old_pwd-error").html(result.msg).hide();
                toastr.options = { 
                "progressBar": true,
                "positionClass": "toast-top-full-width",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
              }
              toastr.success(result.msg);
              return false;      
            $('input[type=password]').val("");
          }else if(result.status==0){
         
             if(result.msg =='Old Password not matched'){
                $("#old_pwd").css("border","1px solid red");
                $("#old_pwd-error").html(result.msg).show();
              }
               /* toastr.options = { 
                "progressBar": true,
                "positionClass": "toast-top-full-width",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
              }*/
             //  toastr.error(result.msg);
               return false;
          }else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   
          }
      }
  });     
}

function addcreditcard(){
   // var myCard = $('#my-card-2');
   $.ajax({
      type: 'post',
      url: LoadBoard.API+'shipper/payment',
      dataType: "json",
      headers: {
             Authorization: "Bearer "+LoadBoard.token
          },
      dataType: "json",
      data: JSON.stringify({ 
        "card_number": encodeURIComponent(window.btoa($(".card_number").val())), 
        "card_holders_name": encodeURIComponent(window.btoa($(".card_holders_name").val())),
        "expiry_month":encodeURIComponent(window.btoa( $(".expiry-month").val())),
        "expiry_year":encodeURIComponent(window.btoa($(".expiry-year").val())),
        "cvc": encodeURIComponent(window.btoa($(".cvc").val())),        
        "user_id" :LoadBoard.userid, 
        "cardtype" :encodeURIComponent(window.btoa($('.card-type-icon').attr('id'))),
        "pay_address" :encodeURIComponent(window.btoa($('#billing_address').val())),
        "pay_phone" :encodeURIComponent(window.btoa($('#pay_phone').val())),
        "pay_country" :encodeURIComponent(window.btoa($('#pay_country').val())),
        "pay_state" :encodeURIComponent(window.btoa($('#pay_state').val())),
        "pay_city" :encodeURIComponent(window.btoa($('#pay_city').val())),
        "pay_zipcode" :encodeURIComponent(window.btoa($('#pay_zipcode').val())),
        "firstname" :encodeURIComponent(window.btoa($('#firstname').val())),
        "lastname" :encodeURIComponent(window.btoa($('#lastname').val())),
        "city" :encodeURIComponent(window.btoa($("#city option:selected").html())),
        "state" :encodeURIComponent(window.btoa($("#state option:selected").html()))
      
      }),
      contentType: "application/json",
      success: function (result) {
          $('.preloader').hide();
          if(result.status==1){
              toastr.options = { 
                "progressBar": true,
                "positionClass": "toast-top-full-width",
                "timeOut": "2000",
                "extendedTimeOut": "1000",
              }
              toastr.success(result.msg);

            $(".card_number").val("");
            $(".card_holders_name").val("");
            $(".expiry-month").val("");
            $(".expiry-year").val("");
            $(".cvc").val("");       
            $("#billing_address").val(""); 
            payment_methods();      
            
          }else if(result.status==0){
              swal.fire({
                        title: "Error!",
                        text: result.msg,
                        type: "error",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        confirmButtonClass: 'btn-md',
                        cancelButtonClass: 'btn-md',
                        showCloseButton: true,
                        allowOutsideClick:false,
                    }).then(result => {
                        return false;
                    });           
                      $("body").removeClass("swal2-height-auto");    
               return false;
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
        //data:{operation:"state_list" ,country_id:country },
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

                $("#pay_state").append(option); 
                $("#pay_city").val("");




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
               $("#pay_city").html(option);    
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
        url:LoadBoard.API+'shipper/location-list',
        dataType: 'json',
        async:false,
         headers: {
                 Authorization: "Bearer "+LoadBoard.token
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"country_list"
                   
            }),
          contentType: "application/json",
      //  data:{operation:"country_list"},
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
               $("#pay_country").html(option);    
            }
          }
        }
    }); 
}

function payment_methods(){

   $.ajax({
        type:'POST',
        url:LoadBoard.API+'shipper/payment-methods',
        dataType: 'json',
        async:false,
        headers: {
           Authorization: "Bearer "+LoadBoard.token
         },
        data: JSON.stringify({"user_id": LoadBoard.userid}),
        contentType: "application/json",
        success:function(result){
          console.log(result)
          var content="";
          if(result.status==1){
                var paydata=result.data;
                if(paydata.length!=''){

                 for (var i =0; i<paydata.length; i++) {   
                    content +='<div class="panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne'+i+'"><img src="http://pngimg.com/uploads/visa/visa_PNG18.png" style="width: 50px;height: 31px; float: right;">'+paydata[i].cardnumber+'</a></h4></div><div id="collapseOne'+i+'" class="panel-collapse collapse"><div class="panel-body">'+i+'</div></div></div>';
                  }
                  $("#accordion").html(content);
                    $(".payment_methods").show();
                }else{
                    $(".payment_methods").hide();

                }
          }
        }
    }); 

}
</script>


 
