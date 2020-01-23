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
  input[type=search]{padding: 10px 30px 10px 10px;}
  .add_vehicle_tab{float: right;}
  .addrow,.deleterow,.editrow{
    cursor: pointer;
  }
  .add_vehicle_tab{font-size: 16px;float:right;color:#295a9f;}
  .deleterow{color:#295a9f;}
  .imagePreview {
    width: 100%;
    height: 200px;
    background-position: center center !important;
  background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
  background-color:#fff !important;
    background-size: cover !important;
  background-repeat:no-repeat !important;
    display: inline-block !important;
}
.btn-primary-upload
{
  display:block;
  border-radius:0px;
  margin-top:-5px;
      color: #fff;
    background-color: #467fcf;
    border-color: #467fcf;
}


</style>
<div class="my-3 my-md-5">
  <div class="container animated fadeIn">
    <div class="page-header">
      <i class="icon-ManageProfileB"></i>&nbsp;&nbsp;
      <h1 class="page-title">
        Manage Profile
      </h1> 
    </div>   

    <div class="row">
    
    <div class="col-lg-12 col-md-8 col-sm-12 ">
      <div class="lb-tabs">
      <nav>
        <div class="nav lb-nav-tabss" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <i class="icon-Trucker mr-2" ></i> Contact Details</a>
           <a class="nav-item nav-link" id="nav-vehicle-tab" data-toggle="tab" href="#nav-vehicle" role="tab" aria-controls="nav-vehicle" aria-selected="false"> <i class="icon-Truck"></i>&nbsp; Vehicle Details </a>  
         
         
           <a class="nav-item nav-link" id="nav-profile-tab1" data-toggle="tab" href="#nav-profile1" role="tab" aria-controls="nav-profile1" aria-selected="false"> <i class="fe fe-credit-card mr-2" ></i>Bank Details</a>  

          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> <i class="fa fa-key mr-2" ></i> Change Password</a>     
           
          

        </div> 
      </nav>




   <!-- Trucker profile starts here -->   
<div class="tab-content animated  fadeIn" id="nav-tabContent">
<div class="tab-pane fade  active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <form id="trucker_profile" method="post" action="" autocomplete="off">
  <div class="tab-pane fade  active show" id="nav-broker" role="tabpanel" aria-labelledby="nav-home-tab">

    <div class="row">
      <div class="col-lg-3">
        <br><div class="container">
    <label class="form-label">Profile Image</label>
    <div class="imagePreview"></div>
<label class="btn btn-primary-upload">
             Upload
             <input type="file" name="upload_image" value="Upload Photo" class="uploadFile img" id="upload_image" style="width: 0px;height: 0px;overflow: hidden;" />
             <input type="hidden" name="crop_image" id="crop_image">
            <br />
            <div id="uploaded_image"></div>


        </label>

  </div><!-- container -->


      </div>
      <div class="col-lg-4  offset-lg-1">
                  <div class="form-group">
                    <label class="form-label">Name</label>
                     <input type="text" class="form-control" tabindex=1 name="trucker_name" id="trucker_name" placeholder="Name" value="" >    
                  </div>
             
                  <div class="form-group">
                  <label class="form-label">Phone</label>
        <input type="text" name="trucker_phone" tabindex=3 id="trucker_phone" data-mask-clearifnotmatch="true" placeholder="(000) 000 - 0000" class="form-control">  
         <span></span>        
         </div>

   <div class="form-group">
        <label class="form-label">US DOT</label>
         <input type="text" class="form-control" tabindex=5 maxlength="8" name="us_dot" id="us_dot"  placeholder="US DOT" >
         <span></span>
      </div>
 
      <div class="form-group">
          <label class="form-label">Address</label>
          <textarea rows="1" class="form-control" name="address" tabindex=7 id="address"  placeholder="Address"></textarea>
          <label id="address-error" class="error" for="address" style="display: none;"></label>
        </div>

    <div class="form-group">
        <label class="form-label">State</label>      
          <select class="form-control" tabindex=9 name="state" id="state">
             <option value="">Please Select State</option> 
          </select>
          <label id="state-error" class="error" for="state" style="display: none;"></label>
      </div> 

     <div class="form-group">
        <label class="form-label">ZIP Code</label>      
          <input type="text" class="form-control" tabindex=11 name="zipcode" id="zipcode"  placeholder="ZIP Code" >
            <label id="zipcode-error" class="error" for="zipcode" style="display: none;"></label>
          <input type="hidden" name="city_name" id="city_name">
          <input type="hidden" name="state_name" id="state_name">
      </div>
      <div class="form-group">
         
            <label class="form-label">License Expiry Date</label>       
              <div class="input-icon ">                
            <input type="text" name="vehicle_expiry_date" tabindex=13 placeholder="License Expiry Date" id="vehicle_expiry_date" date-format="mm/dd/yyyy" class="form-control" value="">
            <label id="vehicle_expiry_date-error" class="error" for="vehicle_expiry_date" style="display: none;"></label><span class="input-icon-addon"><i class="fe fe-calendar" style="margin: 0px 0px 3px 12px;"></i></span>
          </div>
      </div>




      </div>
      <div class="col-lg-4">
                  <div class="form-group">
                    <label class="form-label">Business Name</label>
                    <input type="text" class="form-control" tabindex=2 placeholder="Business Name" value="" name="trucker_business_name" id="trucker_business_name">           
                  </div>

                  <div class="form-group">
                    <label class="form-label">Email  &nbsp;&nbsp;
              <span class="tool" data-tip="The Email address is your user id. Hence it cannot be changed. If you still want to change it, write to support desk" ><i class="fa fa-question-circle-o"></i></span>  </label>
                    <input type="email" tabindex=4 class="form-control" placeholder="" value="" name="trucker_email" id="trucker_email">           
                  </div>

                  <div class="form-group">
                    <label class="form-label">Mc Number</label>
                    <input type="text" class="form-control" tabindex=6 maxlength="7" placeholder="Mc Number" value="" name="mc_number" id="mc_number">           
                  </div>


  <div class="form-group">
     <label class="form-label">Country</label>      
      <select class="form-control trucker_country" tabindex=8 name="country" id="country" >
          <option value="">--Select Country--</option>
       </select>
       <label id="country-error" class="error" for="country" style="display: none;"></label>
  </div>

     <div class="form-group">
        <label class="form-label">City</label>      
          <select class="form-control" name="city" tabindex=10 id="city">
             <option value="">Please Select City</option> 
          </select>
          <label id="city-error" class="error" for="city" style="display: none;"></label>
      </div>

                  <div class="form-group">
                    <label class="form-label">Driver License Number</label>                        
                    <input type="text" tabindex=12 name="vehicle_licence_no" id="vehicle_licence_no"  placeholder="Driver License Number" class="form-control" value="">
                    <label id="vehicle_licence_no-error" class="error" for="vehicle_licence_no" style="display: none;"></label>
                  </div>

                  <div class="form-group">
                    <label class="form-label">License Issuing State</label>                        
                    <select name="vehicle_issuing_state" id="vehicle_issuing_state" tabindex=14 class="form-control">
                        <option value="">--Select License Issuing State--</option>
                    </select>
                    <label id="vehicle_issuing_state-error" class="error" for="vehicle_issuing_state" style="display: none;"></label>
                  </div>
                  


      </div>

       <div class="col-md-12  text-center">
         <div  id="contact_continue_button" class="text-center"></div>
        </div>
    

    </div>
   
     
 
</form>  
</div>
</div>
  <!-- Trucker profile ends here -->  

  <div class="tab-pane  animated  fadeIn" id="nav-profile1" role="tabpanel" aria-labelledby="nav-profile-tab1">
   <form id="trucker_bank" method="post" action="" autocomplete="off">
  <div class="row">
      <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Bank Name</label>                        
            <input type="text" tabindex=1 placeholder="Bank Name" name="bank_name" id="bank_name" class="form-control" value="">
            <label id="bank_name-error" class="error" for="" style="display: none;"></label>
          </div>
        
          <div class="form-group">
            <label class="form-label">Account Number</label>                        
            <input type="text" tabindex=3 placeholder="Account Number" name="accno" id="accno" class="form-control" value="" maxlength="17">
            <label id="bank_accno-error" class="error" for="" style="display: none;"></label>
          </div>                  

          <div class="form-group">
            <label class="form-label">Routing Transit Number</label>                        
            <input type="text" tabindex=5 placeholder="Routing Transit Number" name="routing_number" id="routing_number" class="form-control" value="" maxlength="9">
            <label id="routing_number-error" class="error" for="vehicle_expiry_date" style="display: none;"></label>
          </div>
      </div>  
      <div class="col-sm-6 col-md-6">
            <div class="form-group">
            <label class="form-label">Account Holder Name</label>                        
            <input type="text"  tabindex=2 placeholder="Account Holder Name" name="bank_acc_holder_name" id="bank_acc_holder_name" class="form-control" value="">
            <label id="bank_acc_holder_name-error" class="error" for="" style="display: none;"></label>
          </div>

            <div class="form-group">
              <label class="form-label">Account Holder Phone Number</label>                        
              <input type="text" tabindex=4 placeholder="Account Holder Phone Number" name="bank_phone_no" id="bank_phone_no" class="form-control" value="" />
              <label id="bank_phone_no-error" class="error" for="bank_phone_no"></label>
            </div>



      </div>  
      <div class="col-md-12  text-center">                  
       <button type="submit" class="btn btn-primary "><i class="fe fe-check-square mr-2"></i> Update </button> 
      </div>
  </div>
</form>
</div>


<!-- Change Password Starts here -->
<div class="tab-pane  animated  fadeIn" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
   <form id="trucker_changepwd" method="post" action="" autocomplete="off">
  <div class="row">
      <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <label class="form-label">Current Password</label>                        
            <input type="password" name="old_pwd" placeholder="Current Password" id="old_pwd" class="form-control" value="">
            <label id="old_pwd-error" class="error" for="old_pwd" style="display: none;"></label>
          </div>
          <div class="form-group">
            <label class="form-label">New Password</label>                        
            <input type="password" name="new_pwd" placeholder="New Password" id="new_pwd" class="form-control" value="">
          </div>                  

          <div class="form-group">
            <label class="form-label">Confirm New Password</label>                        
            <input type="password" name="confirm_pwd" placeholder="Confirm New Password" id="confirm_pwd" class="form-control" value="">
          </div>
      </div>  
      <div class="col-md-12  text-center">                  
       <button type="submit" class="btn btn-primary "><i class="fe fe-check-square mr-2"></i> Change Password </button> 
      </div>
  </div>
</form>
</div>

   <!-- Trucker profile Vehicle details starts here --> 
<div class="tab-pane  animated  fadeIn" id="nav-vehicle" role="tabpanel" aria-labelledby="nav-vehicle-tab">
    <form id="trucker_profile" method="post" action="" autocomplete="off">
      <div class="tab-pane fade  active show" id="nav-broker" role="tabpanel" aria-labelledby="nav-vehicle-tab">
        <div class="row">
          <div class="col-sm-12 col-md-12">
                <div class="">
                    <h2 class="page-title">
                    <a href="#" class="add_vehicle_tab"  data-toggle="modal" data-target="#add_vehicle_tab">Click here to Add Vehicle Details </a> 
                  </h2>
                </div>
                
                <div class="table-responsive">  
                  <h1 class="dgrid-title"></h1>
                  &nbsp;&nbsp;
                  <table id="viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="10%"><div>ID.No</div></th>
                          <th width="10%"><div>Vin</div></th>
                          <th width="10%"><div>Unit</div></th>
                          <th width="10%"><div>make</div></th>
                          <th width="10%"><div>model</div></th>
                          <th width="10%"><div>type</div></th>
                          <th width="10%"><div>weight</div></th>
                          <th width="10%"><div>length</div></th>
                          <th width="10%"><div>height</div></th>
                          <th width="10%"><div>Action</div></th>
                        </tr>
                    </thead>
                </table>     
                  <!--
                  <table id="vehicle-details" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th><div>ID.No</div></th>
                          <th><div>Vin</div></th>
                          <th><div>Unit</div></th>
                          <th><div>make</div></th>
                          <th><div>model</div></th>
                          <th><div>type</div></th>
                          <th><div>weight</div></th>
                          <th><div>length</div></th>
                          <th><div>height</div></th>
                          <th><div>Action</div></th>
                        </tr>
                      </thead>
                  </table>
                  -->
                  <!--<div class="card-footer text-center">
                  <button type="submit" id="submit-veh-details" style="display: block;" class="btn btn-primary submit-veh-details">
                      Submit

                    </button>
                  </div> -->
               </div>
              <!--</div>-->



           
          </div>
        </div>
      </div>
    </form>
</div>
   <!-- Trucker profile Vehicle details ends here --> 

</div>
</div>
</div> 
</div>
</div>
</div> 
<div id="uploadimageModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
<!--             <button type="button" class="close" data-dismiss="modal">&times;</button>
 -->            <h4 class="modal-title">Upload & Crop Image</h4>
          </div>
          <div class="modal-body">
            <div class="row">
            <div class="col-md-8 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px"></div>
            </div>
            <div class="col-md-4" style="padding-top:30px;">
              <br />
              <br />
              <br/>
              <button class="btn btn-primary crop_image">Crop & Upload Image</button>
          </div>
        </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>
<?php $Global->Footer(); ?>


<script type="text/javascript">
 var data1 = LoadBoard.userid;

$(document).ready(function() {

    var veh_table = $('#viewloads').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Search for...",
            "zeroRecords": "No relevant information available"
        },
        "ajax": {
            url: LoadBoard.API + 'trucker/get-vehicle-details',
            type: "post",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            contentType: "application/json",

            "data": function(data) {
                data.user_id = data1;
                return JSON.stringify(data);
            },
            "dataFilter": function(data) {
                var data = JSON.parse(data);
                var rowCount =data.iTotalDisplayRecords;
                //alert(rowCount);
                if(rowCount==0){
                  $("#contact_continue_button").html('<button id="continue" type="submit" class="btn btn-primary continuevalid"> <i class="fe fe-edit mr-2"></i> Update and Continue Profile</button> ');
                } else {
                  $("#contact_continue_button").html('<button id="same" type="submit" class="btn btn-primary continuevalid"> <i class="fe fe-edit mr-2"></i> Update Profile</button> ');
                }
                return JSON.stringify(data);
              },
        },
        "bLengthChange": false,
        "type": "POST",
        "bProcessing": false,
        "serverSide": true,
        "bInfo": false,
        "order": [
            [0, "asc"]
        ],
        "columns": [{
                "data": "id"
            },
            {
                "data": "veh_id_no"
            },
            {
                "data": "veh_unit"
            },
            {
                "data": "veh_make"
            },
            {
                "data": "veh_model"
            },
            {
                "data": "veh_type"
            },
            {
                "data": "veh_weight"
            },
            {
                "data": "veh_height"
            },
            {
                "data": "veh_length"
            }
        ],
        columnDefs: [{
                targets: 0,
                bSortable: true,
                "visible": false,
                render: function(data, type, row) {
                    return row.veh_id_no;
                }
            },
            {
                targets: 1,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_id_no;
                }
            },
            {
                targets: 2,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_unit;
                }
            },
            {
                targets: 3,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_make;
                }
            },
            {
                targets: 4,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_model;
                }
            },
            {
                targets: 5,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_type;
                }
            },
            {
                targets: 6,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_weight;
                }
            },
            {
                targets: 7,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_length;
                }
            },
            {
                targets: 8,
                width: "10%",
                bSortable: true,
                render: function(data, type, row) {
                    return row.veh_height;
                }
            },
            {
                targets: 9,
                width: "10%",
                bSortable: false,
                render: function(data, type, row) {
                    return '<a id="' + row.id + '" class="editrow"><span class="action_tool" data-tip="Edit" tabindex="1" ><i class="fa fa-pencil" aria-hidden="true"></i></span></a>&nbsp;&nbsp;&nbsp;<a id="' + row.id + '" class="deleterow"><span class="action_tool" data-tip="Delete" tabindex="1" ><i class="fa fa-trash" aria-hidden="true"></i></span></a>';

                }
            }

        ]

    });




    Getcountrylist();
    $('#country').on('change', function() {
        if (this.value != '') {
            state_list(this.value);
        }
    });

    $('#state').on('change', function() {
        var state_id = $(this).val();
        city_list(state_id);
    });

    jQuery.validator.addMethod("validatePhone", function(txtPhone) {
        //var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/;
        var filter = /^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/;

        if (filter.test(txtPhone)) {
            return true;
        } else {
            return false;
        }
    });
    jQuery.validator.addMethod("name_valid", function(inputtxt) {
        var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
        if (filter.test(inputtxt)) {
            return false;
        } else {
            return true;
        }
    });
    jQuery.validator.addMethod("busi_namevalid", function(inputtxt) {
        var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
        if (filter.test(inputtxt)) {
            return false;
        } else {
            return true;
        }
    });
    jQuery.validator.addMethod("routing_valid", function(routing) {
        if (routing.length !== 9) {
            return false;
        }

        var checksumTotal = (7 * (parseInt(routing.charAt(0), 10) + parseInt(routing.charAt(3), 10) + parseInt(routing.charAt(6), 10))) +
            (3 * (parseInt(routing.charAt(1), 10) + parseInt(routing.charAt(4), 10) + parseInt(routing.charAt(7), 10))) +
            (9 * (parseInt(routing.charAt(2), 10) + parseInt(routing.charAt(5), 10) + parseInt(routing.charAt(8), 10)));
        var checksumMod = checksumTotal % 10;
        if (checksumMod !== 0) {
            return false;
        } else {
            return true;
        }

    });

    jQuery.validator.addMethod("zero_validate", function(inputtxt) {
        var val_exp = inputtxt.split('-');
        var val_open_bracket = val_exp[0].split('(');
        var val_close_bracket = val_exp[0].split(')');
        var val_open_bracket_replace = val_open_bracket[1].replace(')', '');
        var val_close_bracket_replace = val_close_bracket[0].replace('(', '');
        var val = parseFloat(val_open_bracket_replace + val_close_bracket_replace + val_exp[2]);
        if (isNaN(val) || (val === 0)) {
            return false;
        } else {
            return true;
        }
    });


    jQuery.validator.addMethod("zero_validate1", function(inputtxt) {

        var val = parseFloat(inputtxt);
        // var val = parseFloat(val1);
        if (isNaN(val) || (val === 0)) {
            return false;
        } else {
            return true;
        }
    });


    jQuery.validator.addMethod("driving_licence_no", function(inputtxt) {
        var filter = /[\'^£$%&*()}{@#~?><>,|=_+¬-]/;
        if (filter.test(inputtxt)) {
            return false;
        } else {
            return true;
        }
    });

    jQuery.validator.addMethod("bank_name_valid", function(inputtxt) {
        var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
        if (filter.test(inputtxt)) {
            return false;
        } else {
            return true;
        }
    });

    jQuery.validator.addMethod("veh_weight_space", function(inputtxt) {
        var filter = /[\'^£$%&*()}{@#~?><>,|=_+¬-]/;
        if (filter.test(inputtxt)) {
            return false;
        } else {
            return true;
        }
    });


    $("#vehicle_licence_no").attr("maxlength", 20);

    $('#vehicle_licence_no').on('keypress', function() {
        var c = this.selectionStart,
            r = /[^a-z0-9]/gi,
            v = $(this).val();
        if (r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
        }
        this.setSelectionRange(c, c);
    });

    jQuery.validator.addMethod("validateZip", function(txtZip) {
        var country = $("#country").val();
        if (country == 231) {
            var us = /^\d{5}(?:-\d{4})?$/;
            if (us.test(txtZip)) {
                return true;
            } else {
                return false;
            }
        } else if (country == 38) {
            var canada = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;
            if (canada.test(txtZip)) {
                return true;
            } else {
                return false;
            }
        }

    });

    $("#trucker_profile").validate({
        rules: {
            trucker_name: {
                required: true,
                name_valid: true,
            },
            trucker_business_name: {
                required: true,
                busi_namevalid: true,
            },
            trucker_phone: {
                required: true,
                validatePhone: true,
                zero_validate: true,
            },
            us_dot: {
                required: true,
                minlength: 8,
                zero_validate1: true,
            },
            weight: {
                required: true,
                maxlength: 6,
                zero_validate1: true,
            },
            length: {
                required: true,
                //  minlength:2,
                //  maxlength:2,
                zero_validate1: true,
            },
            equipment: {
                required: true,
            },
            address: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            zipcode: {
                required: true,
                validateZip: true,
                minlength: 5,
            }

        },
        messages: {
            trucker_name: {
                required: "Please enter the Name",
                name_valid: "Please enter a valid Name",
            },
            trucker_business_name: {
                required: "Please enter the Business Name",
                busi_namevalid: "Please enter a valid Business Name",

            },
            trucker_phone: {
                required: "Please enter the Phone Number",
                validatePhone: "Enter a valid Phone Number",
                zero_validate: "Enter a valid Phone Number",
            },
            us_dot: {
                required: "Please enter the US DOT Number",
                minlength: "Please enter a valid US DOT Number",
                zero_validate1: "Please enter a valid US DOT Number",
            },
            weight: {
                required: "Please enter the Weight",
                minlength: "Weight cannot be Zero",
                zero_validate1: "Weight cannot be Zero",
            },
            length: {
                required: "Please enter the Length",
                minlength: "Length can be maximum of 2 digits",
                zero_validate1: "Length cannot be Zero",
            },
            equipment: {
                required: "Equipment Type should not be empty",
            },
            address: {
                required: "Please Enter the Address"
            },
            country: {
                required: "Please Select the Country"
            },
            state: {
                required: "Please Select the State"
            },
            city: {
                required: "Please Select the City"
            },
            zipcode: {
                required: "Please Enter the Zipcode",
                validateZip: "Enter a valid Zipcode"
            },

        },
        submitHandler: function() {
            var city_name = $("#city option:selected").html();
            var state_name = $("#state option:selected").html();

            //alert(state_name);
            $("#city_name").val(city_name);
            $("#state_name").val(state_name);
            var data = $('#trucker_profile').serialize();
            var vehicle_licence_no = $("#vehicle_licence_no").val();
            var vehicle_issuing_state = $("#vehicle_issuing_state").val();
            var vehicle_expiry_date = $("#vehicle_expiry_date").val();
            if (vehicle_licence_no != "") {
                if (vehicle_issuing_state == "" && vehicle_expiry_date == "") {
                    $("label#vehicle_expiry_date-error").html('Please pick the License Expiry Date').css('display', 'block');
                    $("label#vehicle_issuing_state-error").html('Please select the License Issuing State').css('display', 'block');
                    return false;
                }
            }

            if (vehicle_issuing_state != "") {
                if (vehicle_licence_no == "" && vehicle_expiry_date == "") {
                    $("label#vehicle_licence_no-error").html('Please enter the Driver License Number').css('display', 'block');
                    $("label#vehicle_expiry_date-error").html('Please pick the License Expiry Date').css('display', 'block');
                    return false;
                }
            }
            if (vehicle_expiry_date != "") {
                if (vehicle_licence_no == "" && vehicle_issuing_state == "") {
                    $("label#vehicle_issuing_state-error").html('Please select the License Issuing State').css('display', 'block');
                    $("label#vehicle_licence_no-error").html('Please enter driver License Number').css('display', 'block');
                    return false;
                }
            }
            
            
            if (vehicle_licence_no == "" && (vehicle_issuing_state != "" && vehicle_expiry_date != "")) {
                $("label#vehicle_licence_no-error").html('Please enter the driver License Number').css('display', 'block');
            } else if (vehicle_issuing_state == "" && (vehicle_licence_no != "" && vehicle_expiry_date != "")) {
                $("label#vehicle_issuing_state-error").html('Please select the License Issuing State').css('display', 'block');
            } else if (vehicle_expiry_date == "" && (vehicle_licence_no != "" && vehicle_licence_no != "")) {
                $("label#vehicle_expiry_date-error").html('Please pick the License Expiry Date').css('display', 'block');
            } else {
               trucker_profile(data);
              
/*                swal.fire({
                    title: "Confirmation!",
                    text: "Do you want to update the changes?",
                    type: "success",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonClass: 'btn-md',
                    cancelButtonClass: 'btn-md',
                    showCloseButton: true,
                    allowOutsideClick: false,
                }).then(result => {
                    if (result.value == true) {
                       
                    }
                });
                $("body").removeClass("swal2-height-auto");*/
              }



        }
    });


    // Bank starts here
    $("#trucker_bank").validate({
        rules: {
            bank_name: {
                required: true,
                name_valid: true
            },
            bank_acc_holder_name: {
                required: true,
                name_valid: true,
                maxlength: 17
            },
            accno: {
                required: true,
                digits: true
            },
            routing_number: {
                required: true,
                digits: true,
                routing_valid: true

            },
            bank_phone_no: {
                required: true,
                validatePhone: true,
                zero_validate: true,
            },

        },
        messages: {
            bank_name: {
                required: "Please enter the Bank Name",
                name_valid: "Please enter a valid Bank Name"
            },
            bank_acc_holder_name: {
                required: "Please enter the Account Holder Name",
                name_valid: "Please enter a valid  Account Holder Name",
            },
            accno: {
                required: "Please enter the Account Number",
                digits: "Please enter a valid  Account Number",
            },
            routing_number: {
                required: "Please enter the Routing Transit Number",
                digits: "Please enter a valid Routing Transit Number",
                routing_valid: "Please enter a valid Routing Transit Number"
            },
            bank_phone_no: {
                required: "Please enter the Account Holder Phone Number",
                validatePhone: "Enter a valid Account Holder Phone Number",
                zero_validate: "Enter a valid Account Holder Phone Number",
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
                allowOutsideClick: false,
            }).then(result => {
                if (result.value == true) {
                    var bankdata = $('#trucker_bank').serialize();
                    truckerBankDetails(bankdata);
                }
            });
            $("body").removeClass("swal2-height-auto");
        }
    });
    // Bank ends here

    // Change password Starts here 
    $("#trucker_changepwd").validate({
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
                required: "Please enter the Current Password",
                minlength: "New Password and Confirm Password mismatch",
                maxlength: "New Password and Confirm Password mismatch",
            },
            new_pwd: {
                required: "Please enter the New Password",
                minlength: "New Password and Confirm Password mismatch",
                maxlength: "New Password and Confirm Password mismatch",
            },
            confirm_pwd: {
                required: "Please enter the Confirm New Password",
                minlength: "New Password and Confirm Password mismatch",
                maxlength: "New Password and Confirm Password mismatch",
                equalTo: "New Password and Confirm Password mismatch"
            }
        },
        submitHandler: function() {
            swal.fire({
                title: "Confirmation!",
                text: "Do you want to change the Password?",
                type: "success",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                confirmButtonClass: 'btn-md',
                cancelButtonClass: 'btn-md',
                showCloseButton: true,
                allowOutsideClick: false,
            }).then(result => {
                if (result.value == true) {
                    var data1 = $('#trucker_changepwd').serialize();
                    trucker_update_changepwd(data1);
                }
            });
            $("body").removeClass("swal2-height-auto");
        }
    });




    issuing_state();
    $("#vehicle_expiry_date").attr("readonly", "readonly");

    $("#vehicle_expiry_date").datepicker({
        todayHighlight: 'TRUE',
        startDate: '-0d',
        autoclose: true,
        onSelect: function() {
            return $(this).trigger('change');
        }
    });


    $("#veh_unit,#editveh_weight").on('keypress', function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
            $("label#veh_unit-error,label#editveh_weight-error").html('Vehicle Unit Only accept Numberic').css('display', 'block');
        } else {
            $("label#veh_unit-error,label#editveh_weight-error").html('').css('display', 'none');
        }
    });
    $("#veh_weight,#editveh_weight").on('keypress', function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
            $("label#veh_weight-error,label#editveh_weight-error").html('Vehicle Weight can be maximum of 6 digits').css('display', 'block');
        } else {
            $("label#veh_weight-error,label#editveh_weight-error").html('').css('display', 'none');
        }
    });

    $("#veh_length,#editveh_length").on('keypress', function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
            $("label#veh_length-error,label#editveh_length-error").html('Vehicle Length can be maximum of 2 digits').css('display', 'block');
        } else {
            $("label#veh_length-error,label#editveh_length-error").html('').css('display', 'none');
        }
    });

    $("#veh_height,#editveh_height").on('keypress', function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
            $("label#veh_height-error,label#editveh_height-error").html('Vehicle Height can be maximum of 3 digits').css('display', 'block');
        } else {
            $("label#veh_height-error,label#editveh_height-error").html('').css('display', 'none');
        }
    });



    //get_vehicle_details();

    $("#trucker_email").attr("readonly", "readonly");

    $("#trucker_phone,#us_dot,#weight,#bank_phone_no").keypress(function(e) {
        var regex = new RegExp(/^[0-9]+$/);
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });
    $("#trucker_phone,#us_dot,#weight,#bank_phone_no").keypress(function(e) {
        if (this.value.length == 0 && e.which == 48) {
            return false;
        }
    });

    document.getElementById('trucker_phone').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? ' - ' + x[3] : '');
    });
    document.getElementById('bank_phone_no').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? ' - ' + x[3] : '');
    });




    $(".add_vehicle_tab").on('click', function() {
        var veh_id_no = $("#veh_id_no").val('');
        var veh_make = $("#veh_make").val('');
        var veh_model = $("#veh_model").val('');
        var veh_type = $("#veh_type").val('');
        var veh_weight = $("#veh_weight").val('');
        var veh_length = $("#veh_length").val('');
        var veh_height = $("#veh_height").val('');
        //alert("hi");
        //if($("#edituniqueid").val(''))
        $("#editcontinuevalid").hide();
        $("#continuevalid").html('<button type="submit" id="add_vehicle_details" class="btn btn-primary">Save</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>');
        $("#edituniqueid").val('');
        $("#veh_unit").val('');
        $("label#veh_id_no-error,label#editveh_id_no-error").html('').css('display', 'none');
        $("label#veh_id_no1-error,label#editveh_id_no-error").html('').css('display', 'none');
        $("label#veh_weight-error,label#editveh_weight-error").html('').css('display', 'none');
        $("label#veh_length-error,label#editveh_length-error").html('').css('display', 'none');
        $("label#veh_height-error,label#editveh_height-error").html('').css('display', 'none');
    });



    jQuery.validator.addMethod("validateVin", function(inputtxt) {
        var filter = /((^[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+)|(^[abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ0123456789]+))+[0123456789abcdefghjklmnprstuvwxyzABCDEFGHJKLMNPRSTUVWXYZ]+$/i;
        if (!inputtxt.match(filter)) {
            return false;
        } else {
            return true;
        }
    });
    $("#veh_unit").attr("maxlength", 20);
    $("#form-vehicle-details").validate({
        rules: {
            veh_id_no: {
                required: true,
                maxlength: 17,
                validateVin: true,
                //ioqvvalidate:true
            },
            veh_unit: {
                maxlength: 20
            },
            veh_weight: {
                veh_weight_space: true,
                maxlength: 6
            },
            veh_length: {
                veh_weight_space: true,
                maxlength: 2
            },
            veh_height: {
                veh_weight_space: true,
                maxlength: 3
            }
        },
        messages: {
            veh_id_no: {
                required: "Please enter the Vehicle Identification Number",
                veh_id_no: "Enter a valid VIN number",
                validateVin: "Enter a valid VIN number",
                //ioqvvalidate:"IOQ should not allowed"
            },
            veh_unit: {
                maxlength: "Vehicle Unit can be maximum of 10 digits"
            },
            veh_weight: {
                maxlength: "Vehicle Weight can be maximum of 6 digits"
            },
            veh_length: {
                maxlength: "Vehicle Length can be maximum of 2 digits"
            },
            veh_height: {
                maxlength: "Vehicle Height can be maximum of 3 digits"
            }
        },
        submitHandler: function() {
            var data = $('#form-vehicle-details').serialize();
            if (veh_id_no == "") {
                $("label#veh_id_no-error").html("Please enter the Vehicle Identification Number").css('display', 'block');
                return false;
            } else {
                    var veh_id_no = $("#veh_id_no").val();
                    var edituniqueid = $("#edituniqueid").val();
                    if (edituniqueid != "") {
                        var url = 'update-vehicle-details';
                    } else {
                        var url = 'add-vehicle-details';
                    }
                    $.ajax({
                        type: 'post',
                        async:false,
                        url: LoadBoard.API + 'trucker/' + url,
                        dataType: "json",
                        headers: {
                            Authorization: "Bearer " + LoadBoard.token
                        },
                        data: JSON.stringify({
                            "edituniqueid": edituniqueid,
                            "veh_id_no": veh_id_no,
                            "user_id": LoadBoard.userid,
                            "veh_unit": $("#veh_unit").val(),
                            "veh_make": $("#veh_make").val(),
                            "veh_model": $("#veh_model").val(),
                            "veh_type": $("#veh_type").val(),
                            "veh_weight": $("#veh_weight").val(),
                            "veh_length": $("#veh_length").val(),
                            "veh_height": $("#veh_height").val(),
                            "app_type":"web"
                        }),
                        contentType: "application/json",
                        success: function(result) {
                           if(result.status==3){
                              $("#add_vehicle_tab").modal("hide");
                              swal.fire({
                                  title: "Confirmation!",
                                  text: "Do you want to update the Vehicle Details?",
                                  type: "success",
                                  showCancelButton: true,
                                  confirmButtonText: 'Yes',
                                  cancelButtonText: 'No',
                                  confirmButtonClass: 'btn-md',
                                  cancelButtonClass: 'btn-md',
                                  showCloseButton: true,
                                  allowOutsideClick: false,
                              }).then(result => {
                                 if(result.value == true) {
                                    $("#add_vehicle_tab").modal("hide");
                                    $.ajax({
                                      type: 'post',
                                      async:false,
                                      url: LoadBoard.API + 'trucker/' + url,
                                      dataType: "json",
                                      headers: {
                                          Authorization: "Bearer " + LoadBoard.token
                                      },
                                      data: JSON.stringify({
                                        "edituniqueid": edituniqueid,
                                        "veh_id_no": veh_id_no,
                                        "veh_unit": $("#veh_unit").val(),
                                        "veh_make": $("#veh_make").val(),
                                        "veh_model": $("#veh_model").val(),
                                        "veh_type": $("#veh_type").val(),
                                        "veh_weight": $("#veh_weight").val(),
                                        "veh_length": $("#veh_length").val(),
                                        "veh_height": $("#veh_height").val(),
                                        "user_id": LoadBoard.userid,
                                        "popup_action":"update-vehicle-details"
                                      }),
                                      contentType: "application/json",
                                      success: function(result) {
                                        if(result.status==1) {
                                            toastr.options = {
                                              "progressBar": true,
                                              "positionClass": "toast-top-full-width",
                                              "timeOut": "2000",
                                              "extendedTimeOut": "1000",
                                            }
                                            toastr.success(result.msg);
                                            $("#add_vehicle_tab").modal("hide");
                                            $("#nav-vehicle-tab").addClass("active");
                                            $("#nav-profile-tab").removeClass("active");
                                            $("#nav-profile-tab1").removeClass("active");
                                            $("#nav-home-tab").removeClass("active");
                                            veh_table.ajax.reload();
                                            var button= $(".continuevalid").attr("id");
                                            if(button=="continue"){
                                              $("#nav-vehicle-tab").removeClass("active");
                                              $("#nav-vehicle").removeClass("active");
                                              $("#nav-home-tab").removeClass("active");
                                              $("#nav-home").removeClass("active");
                                              $("#nav-profile-tab1").addClass("active");
                                              $("#nav-profile1").addClass("active");
                                            } 
                                         }
                                      }
                                    });
                                  } else {
                                    $("#add_vehicle_tab").modal("show");
                                  }
                              });
                           } else if(result.status==0)  {
                              toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                              }
                              if(result.msg.veh_id_no=="Alphabets 'I, O, Q' are not allowed in VIN number") {
                                $("label#veh_id_no-error").html("").append(result.msg.veh_id_no).css('display', 'block');
                              }
                              if(result.msg=="IOQ should not allowed") {
                                  $("label#veh_id_no-error").html("").append(result.msg).css('display', 'block');
                              } else if(result.msg=="Vehicle identification number should be allowed 17 characters only" || result.msg=="VIN number can be maximum of 17 characters") {
                                  $("label#veh_id_no-error").html("").append(result.msg).css('display', 'block');
                              } else if(result.msg["veh_id_no"]=="Vehicle identification number already exit") {
                                  $("label#veh_id_no1-error").html("").append(result.msg["veh_id_no"]).css('display', 'block');
                              } else if(result.msg=="Vehicle make data character is too long. It should be less than 20 characters") {
                                  $("label#veh_make-error").html("").append(result.msg).css('display', 'block');
                              } else if(result.msg=="Vehicle modal data character is too long. It should be less than 20 characters") {
                                  $("label#veh_model-error").html("").append(result.msg).css('display', 'block');
                              } else if(result.msg=="Vehicle type data character is too long. It should be less than 20 characters") {
                                  $("label#veh_type-error").html("").append(result.msg).css('display', 'block');
                              }
                           }
                        }
                    });
                $("body").removeClass("swal2-height-auto");
            }
        }
    });




    $("#viewloads").on("click", ".deleterow", function() {
        $("#uniqueid").val($(this).attr("id"));

        swal.fire({
            title: "Confirmation!",
            text: "Do you want to delete the vehicle details?",
            type: "error",
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn-md',
            cancelButtonClass: 'btn-md',
            showCloseButton: true,
            allowOutsideClick: false,
        }).then(result => {
            //alert(result.value);
            if (result.value == true) {
                var uniqueid = $("#uniqueid").val();
                //alert(uniqueid)
                $.ajax({
                    type: 'post',
                    url: LoadBoard.API + 'trucker/delete-vehicle-details',
                    dataType: "json",
                    headers: {
                        Authorization: "Bearer " + LoadBoard.token
                    },
                    data: JSON.stringify({
                        "uniqueid": uniqueid,
                        "user_id": LoadBoard.userid
                    }),
                    contentType: "application/json",

                    // data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&uniqueid="+uniqueid,
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                            }
                            toastr.success(result.msg);
                            $("#conirm-vehicle-delete").modal("hide");
                            $("#nav-vehicle-tab").addClass("active");
                            $("#nav-profile-tab").removeClass("active");
                            $("#nav-profile-tab1").removeClass("active");
                            $("#nav-home-tab").removeClass("active");
                            veh_table.ajax.reload();
                        }
                    }
                })
            }
        });
        $("body").removeClass("swal2-height-auto");
    });

    $("#viewloads").on("click", ".editrow", function() {
        $("#edituniqueid").val($(this).attr("id"));
        $("#edit_vehicle_tab").modal("show");
        var uniqueid = $(this).attr("id");
        //alert(uniqueid);
        $("#add_vehicle_tab").modal("show");
        $("label#editveh_id_no-error").html('').css("display", "none");
        $("label#veh_id_no1-error,label#editveh_id_no-error").html('').css('display', 'none');
        $("label#editveh_weight-error").html('').css("display", "none");
        $("label#editveh_length-error").html('').css("display", "none");
        $("label#editveh_height-error").html('').css("display", "none");
        //$("#continuevalid").hide();
        $("#editcontinuevalid").html('').append('<button type="submit" id="update_vehicle_details" class="btn btn-primary">Save</button><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>');

        $.ajax({
            type: 'post',
            url: LoadBoard.API + 'trucker/edit-get-vehicle-details',
            dataType: "json",
            headers: {
                Authorization: "Bearer " + LoadBoard.token
            },
            data: JSON.stringify({
                "uniqueid": uniqueid,
                "user_id": LoadBoard.userid
            }),
            contentType: "application/json",
            // data: "token="+LoadBoard.token+"&user_id="+LoadBoard.userid+"&uniqueid="+uniqueid,
            success: function(result) {
                //alert(result.status);
                if (result.status == 1) {
                    $("#veh_id_no").val(result.data[0]["veh_id_no"]);
                    $("#veh_make").val(result.data[0]["veh_make"]);
                    $("#veh_model").val(result.data[0]["veh_model"]);
                    $("#veh_type").val(result.data[0]["veh_type"]);
                    $("#veh_unit").val(result.data[0]["veh_unit"]);
                    $("#veh_weight").val(result.data[0]["veh_weight"]);
                    $("#veh_length").val(result.data[0]["veh_length"]);
                    $("#veh_height").val(result.data[0]["veh_height"]);
                }
            }
        });
    });




    // Vehicle Details Ends Here
    $(document).on("click", "#nav-vehicle-tab", function() {
        veh_table.ajax.url(LoadBoard.API + 'trucker/get-vehicle-details').load();
        //pickedtable.ajax.reload();
    });


    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square' //circle
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#upload_image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function() {
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });


    $('.crop_image').click(function(event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response) {
            $('#uploadimageModal').modal('hide');
            $(".imagePreview").css("background", 'url(' + response + ')');
            $("#crop_image").val(response);
        })
    });

    getTruckerProfile(LoadBoard.userid);


});




function truckerBankDetails(bankdata) {
    $('.preloader').show();
    $.ajax({
        type: 'post',
        url: LoadBoard.API + 'trucker/trucker-bankdetails',
        dataType: 'json',
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "bank_name": $("#bank_name").val(),
            "bank_acc_holder_name": $("#bank_acc_holder_name").val(),
            "accno": $("#accno").val(),
            "routing_number": $("#routing_number").val(),
            "bank_phone_no": $("#bank_phone_no").val(),
            "user_id": LoadBoard.userid
        }),
        contentType: "application/json",
        ///data: bankdata,
        success: function(result) {
            if (result.status == 1) {
                $('.preloader').hide();
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                }
                toastr.success(result.msg);
            } else if (result.status == 2) {
                window.href.location = LoadBoard.APP + "logout";
            } else if (result.status == 0) {
                $('.preloader').hide();
                if (result.msg.bank_name == "Enter a valid Bank Name") {
                    $("label#bank_name-error").html(result.msg).css('display', 'block');
                } else if (result.msg.bank_acc_holder_name == "Please enter a valid  Account Holder Name") {
                    $("label#bank_acc_holder_name-error").html(result.msg).css('display', 'block');
                } else if (result.msg == "Please enter the Bank Account Number" || result.msg.accno == "Enter a valid Bank Account Number") {
                    $("label#bank_accno-error").html(result.msg).css('display', 'block');
                } else if (result.msg == "Please enter the Routing Transit Number" || result.msg.routing_number == "Please enter a valid Routing Transit Number") {
                    $("label#routing_number-error").html(result.msg).css('display', 'block');
                }
                /*
                toastr.options = { 
                  "progressBar": true,
                  "positionClass": "toast-top-full-width",
                  "timeOut": "2000",
                  "extendedTimeOut": "1000",
                }
                toastr.error(result.msg);
                */
                return false;

            }
        }
    });
}

/*function validateVin(vin) {
  var re = new RegExp("^[A-HJ-NPR-Z\\d]{8}[\\dX][A-HJ-NPR-Z\\d]{2}\\d{6}$");
  return vin.match(re);
}*/

function getTruckerProfile(user_id) {
    //alert(LoadBoard.API+'trucker-profile');
    //alert(LoadBoard.token);
    //alert(LoadBoard.userid);
    $.ajax({
        type: 'post',
        // url: LoadBoard.API+'trucker/get-profile?user_id='+LoadBoard.userid+"&token="+LoadBoard.token,
        url: LoadBoard.API + 'trucker/get-profile',
        dataType: "json",
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        async:false,
        data: JSON.stringify({
            "user_id": LoadBoard.userid
        }),
        contentType: "application/json",

        success: function(result) {
            if (result.status == 1) {
                $("#trucker_name").val(result.data.name);
                $("#trucker_business_name").val(result.data.business_name);
                $("#trucker_email").val(result.data.email);
                $("#trucker_phone").val(formatPhoneNumber(result.data.phone));
                $("#us_dot").val(result.data.vehicle_number);
                $("#weight").val(result.data.weight);
                $("#length").val(result.data.length);
                $("#truck_id").val(result.data.truck_id);

                if (result.data.image != '') {
                    var imgurl = LoadBoard.APP + "assets/uploads/original/" + result.data.image;
                    $(".imagePreview").css("background", 'url(' + imgurl + ')');
                    $("#common_avatar").attr("src", imgurl);
                }

                $("#address").html(result.data.address_line1);
                $("#country").val(result.data.country);
                $("#state").val(result.data.state);
                $("#city").val(result.data.city);
                $("#mc_number").val(result.data.mc_number);
                state_list(result.data.country, result.data.state);
                city_list(result.data.state, result.data.city);
                if (result.data.zipcode == 0) {
                    var zipcode = "";
                } else {
                    var zipcode = result.data.zipcode;
                }
                //alert(zipcode)
                $("#zipcode").val(zipcode);

                $("#vehicle_licence_no").val(result.data.vehicle_licence_no);
                //issuing_state(result.data.vehicle_issuing_state);
                //$("#vehicle_issuing_state").val(result.data.vehicle_issuing_state);
                issuing_state(result.data.vehicle_issuing_state)
                // 01/01/1970
                if (result.data.vehicle_expiry_date == "01/01/1970") {
                    var vehicle_expiry_date = "";
                } else {
                    var vehicle_expiry_date = result.data.vehicle_expiry_date;
                }
                $("#vehicle_expiry_date").val(vehicle_expiry_date);
                $("#bank_phone_no").val(formatPhoneNumber(result.data.bank_phone_no));
                $("#bank_name").val(result.data.bank_name);
                if (result.data.account_number != 0)
                    $("#accno").val(result.data.account_number);
                $("#bank_acc_holder_name").val(result.data.bank_acc_holder_name);
                if (result.data.routing_number != 0)
                    $("#routing_number").val(result.data.routing_number);



                equipment(result.data.truck_id);
            } else if (result.status == 2) {
                window.location.href = LoadBoard.APP + 'logout';
            }
        }
    });
}


function trucker_profile(data) {
   // $('.preloader').show();
    var Url;
    $.ajax({
        type: 'post',
        url: LoadBoard.API + 'trucker/update-profile',
        dataType: "json",
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "trucker_name": $("#trucker_name").val(),
            "vehicle_licence_no": $("#vehicle_licence_no").val(),
            "trucker_business_name": $("#trucker_business_name").val(),
            "vehicle_issuing_state": $("#vehicle_issuing_state").val(),
            "trucker_email": $("#trucker_email").val(),
            "vehicle_expiry_date": $("#vehicle_expiry_date").val(),
            "trucker_email": $("#trucker_email").val(),
            "trucker_phone": $("#trucker_phone").val(),
            "us_dot": $("#us_dot").val(),
            "mc_number": $("#mc_number").val(),
            "address": $("#address").val(),
            "country": $("#country").val(),
            "state": $("#state").val(),
            "city": $("#city").val(),
            "zipcode": $("#zipcode").val(),
            "state_name": $("#state_name").val(),
            "city_name": $("#city_name").val(),
            "crop_image": $("#crop_image").val(),
            "user_id": LoadBoard.userid
        }),
        contentType: "application/json",
        success: function(result) {
            if (result.status == 3) {
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
                    allowOutsideClick: false,
                }).then(result => {
                    if (result.value == true) {
                      $('.preloader').show();
                     $.ajax({
                          type: 'post',
                          url: LoadBoard.API + 'trucker/update-profile',
                          dataType: "json",
                          headers: {
                              Authorization: "Bearer " + LoadBoard.token
                          },
                          data: JSON.stringify({
                              "trucker_name": $("#trucker_name").val(),
                              "vehicle_licence_no": $("#vehicle_licence_no").val(),
                              "trucker_business_name": $("#trucker_business_name").val(),
                              "vehicle_issuing_state": $("#vehicle_issuing_state").val(),
                              "trucker_email": $("#trucker_email").val(),
                              "vehicle_expiry_date": $("#vehicle_expiry_date").val(),
                              "trucker_email": $("#trucker_email").val(),
                              "trucker_phone": $("#trucker_phone").val(),
                              "us_dot": $("#us_dot").val(),
                              "mc_number": $("#mc_number").val(),
                              "address": $("#address").val(),
                              "country": $("#country").val(),
                              "state": $("#state").val(),
                              "city": $("#city").val(),
                              "zipcode": $("#zipcode").val(),
                              "state_name": $("#state_name").val(),
                              "city_name": $("#city_name").val(),
                              "crop_image": $("#crop_image").val(),
                              "success_data": "valid",
                              "user_id": LoadBoard.userid
                          }),
                          contentType: "application/json",
                          success: function(result) {
                              if (result.status == 1) {
                                getTruckerProfile(LoadBoard.userid);
                                  $('.preloader').hide();
                                  toastr.options = {
                                      "progressBar": true,
                                      "positionClass": "toast-top-full-width",
                                      "timeOut": "2000",
                                      "extendedTimeOut": "1000",
                                  }
                                  toastr.success(result.msg);
                                  var button= $(".continuevalid").attr("id");
                                  //alert(button);
                                  if(button=="continue"){
                                    $("#nav-vehicle-tab").addClass("active");
                                    $("#nav-vehicle").addClass("active");
                                    $("#nav-home-tab").removeClass("active");
                                     $("#nav-home").removeClass("active");
                                    $("#nav-profile-tab1").removeClass("active");
                                    $("#nav-profile1").removeClass("active");
                                  } else if(button=="same"){
                                    $("#nav-vehicle-tab").removeClass("active");
                                    $("#nav-vehicle").removeClass("active");
                                    $("#nav-home-tab").addClass("active");
                                     $("#nav-home").addClass("active");
                                    $("#nav-profile-tab1").removeClass("active");
                                    $("#nav-profile1").removeClass("active");
                                  }
                                }
                            }
                       });
                    }
      
                });
                $("body").removeClass("swal2-height-auto");               
            } else if (result.status == 0) {
                $('.preloader').hide();
                if (result.msg.zipcode == "Enter a valid Zipcode") {
                    $("label#zipcode-error").html(result.msg.zipcode).css('display', 'block');
                    return false;
                }

                if (result.msg == "Please enter the driver license number") {
                    $("label#vehicle_licence_no-error").html(result.msg).css('display', 'block');
                } else if (result.msg == "Please select the license issuing state") {
                    $("label#vehicle_issuing_state-error").html(result.msg).css('display', 'block');
                } else if (result.msg == "Please pick the vehicle expiry date") {
                    $("label#vehicle_expiry_date-error").html("Please pick the license expiry date").css('display', 'block');
                }  
                return false;
            } else if (result.status == 2) {
                window.location.href = LoadBoard.APP + 'logout';
            }
        }
    });


}

function trucker_update_changepwd(data1) {
    $('.preloader').show();
    $.ajax({
        type: 'post',
        url: LoadBoard.API + 'change-password',
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        dataType: "json",
        data: JSON.stringify({
            "old_pwd": $("#old_pwd").val(),
            "new_pwd": $("#new_pwd").val(),
            "confirm_pwd": $("#confirm_pwd").val(),
            "user_id": LoadBoard.userid
        }),
        contentType: "application/json",
        success: function(result) {

            if (result.status == 1) {
                $('.preloader').hide();
                $("#old_pwd").css("border", "1px solid rgba(0, 40, 100, 0.20 )");
                //$("label#old_pwd-error").html(result.msg).css('display','block');
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                }
                toastr.success(result.msg);
                $("input[type=password]").val('');

                // window.location.href = LoadBoard.APP+'trucker/trucker-profile';
                //return true;
            } else if (result.status == 0) {
                $('.preloader').hide();
                //if(result.msg =='Current Password not matched'){
                $("#old_pwd").css("border", "1px solid red");
                $("label#old_pwd-error").html(result.msg.old_pwd).css('display', 'block');
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-top-full-width",
                    "timeOut": "2000",
                    "extendedTimeOut": "1000",
                }
                toastr.error(result.msg.old_pwd);
                //}
                //toastr.error(result.msg);                    
                return false;
            } else if (result.status == 2) {
                window.location.href = LoadBoard.APP + 'logout';
            }
        }
    });
}

function equipment(truck_id) {
    $.ajax({
        type: 'POST',
        url: LoadBoard.API + 'trucker/equipment-list',
        dataType: 'json',
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "operation": "equipment",
            "user_id": LoadBoard.userid
        }),
        contentType: "application/json",
        // data:{operation:"equipment" },
        success: function(result) {
            if (result.status == 1) {
                var arr = [];
                for (j = 0; j < truckidlength; j++) {
                    var t = truck_id_exp[j];
                    arr.push(t);
                }
                var tmpi = [];
                for (var i = 0; i < result.data.length; i++) {
                    if (tmpi.indexOf(result.data.length) == -1) {
                        tmpi.push(result.data[i]['id'] + "<>" + result.data[i]['truck_name']);
                    }
                    var tmp = [];
                    for (var j = 0; j < arr.length; j++) {
                        if (tmp.indexOf(arr[j]) == -1) {
                            tmp.push(arr[j]);
                        }
                    }
                }

                for (k = 0; k < tmpi.length; k++) {
                    var exp = tmpi[k].split('<>');
                    var option = '<label class="custom-control custom-checkbox custom-control-inline col-sm-5"><input type="checkbox"  name="equipment[]"   id="equipment" class="custom-control-input equipment"  value="' + exp[0] + '"><span class="custom-control-label">' + exp[1] + '</span></label>';
                    $("#append_equipment").append(option);

                }

                var eqarr = [];
                $(".equipment").each(function(index, element) {
                    eqarr.push($(this).val());
                });
                var truck_id_exp = truck_id.split(",");
                var truckidlength = truck_id_exp.length;
                $.each(truck_id_exp, function(index, element) {
                    if ($.inArray(element, eqarr) >= 0) {
                        $("input[value=" + element + "]").prop("checked", true);
                    }
                });


            }
        }
    });
}

function validatePhone(txtPhone) {
    var filter = /^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/;
    if (filter.test(txtPhone)) {
        return true;
    } else {
        return false;
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

function issuing_state(state) {

    var state = state;


    // alert(state);
    $.ajax({
        url: LoadBoard.API + 'trucker/location-list',
        type: 'post',
        dataType: "json",
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "user_id": LoadBoard.userid,
            "operation": "state_list",
            "country_id": "231"
        }),
        contentType: "application/json",
        //data:{operation:"state_list" ,country_id:"231" },
        success: function(result) {

            if (result.status) {
                if (result.data.length != 0) {
                    for (var i = 0; i < result.data.length; i++) {
                        if (result.data[i]['id'] == state) {
                            var selected = "selected=selected";
                        } else {
                            var selected = "";
                        }
                        var option = "<option " + selected + " value=" + result.data[i]['id'] + ">" + result.data[i]['name'] + "</option>";
                        $("#vehicle_issuing_state").append(option);
                    }
                }
            }
        }
    });
}



function get_vehicle_details() {
    $.ajax({
        type: 'post',

        url: LoadBoard.API + 'trucker/get-vehicle-details',
        dataType: "json",
        data: "token=" + LoadBoard.token + "&user_id=" + LoadBoard.userid,
        success: function(result) {
            alert(result.status);
            if (result.status == 1) {
                $("#vehicle-details tbody").empty();
                if (result.data.length == 0) {
                    var htm = '<tr><td class="text-center" colspan="10">No relevant information available</td></tr>';
                    $("#vehicle-details tbody").append(htm);
                } else {
                    for (i = 0; i < result.data.length; i++) {
                        if (result.data[i]["veh_unit"] == null) {
                            var veh_unit = '';
                        } else {
                            var veh_unit = result.data[i]["veh_unit"];
                        }
                        var htm = '<tr><td>' + (i + 1) + '.</td><td>' + result.data[i]["veh_id_no"] + '</td><td>' + veh_unit + '</td><td>' + result.data[i]["veh_make"] + '</td><td>' + result.data[i]["veh_model"] + '</td><td>' + result.data[i]["veh_type"] + '</td><td>' + result.data[i]["veh_weight"] + '</td><td>' + result.data[i]["veh_length"] + '</td><td>' + result.data[i]["veh_height"] + '</td><td><a id="' + result.data[i]["id"] + '" class="editrow"><span class="action_tool" data-tip="Edit" tabindex="1" ><i class="fa fa-pencil" aria-hidden="true"></i></span></a>&nbsp;&nbsp;&nbsp;<a id="' + result.data[i]["id"] + '" class="deleterow"><span class="action_tool" data-tip="Delete" tabindex="1" ><i class="fa fa-trash" aria-hidden="true"></i></span></a></td></tr>';
                        $("#vehicle-details tbody").append(htm);
                    }
                }
            }
        }
    });
}




function Getcountrylist(country = "") {
    var countrys = country;
    //alert(countrys)
    $.ajax({
        url: LoadBoard.API + 'trucker/location-list',
        dataType: "json",
        type: 'post',
        async:false,
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "user_id": LoadBoard.userid,
            "operation": "country_list",
        }),
        contentType: "application/json",
        // data:{operation:"country_list"},
        success: function(result) {
            if (result.status) {
                var country = $("#country").val();
                if (result.data.length != 0) {
                    $("#country").empty();
                    var option = "<option value=''>Select Country</option>";
                    for (var i = 0; i < result.data.length; i++) {

                        if (result.data[i]['id'] == countrys) {
                            var selected = "selected=selected";
                        } else {
                            var selected = "";
                        }

                        option += "<option value=" + result.data[i]['id'] + ">" + result.data[i]['name'] + "</option>";
                    }
                    $("#country").html(option);
                }
            }
        }
    });
}

function state_list(country = "", state = "") {
    var state = state;
    /// alert(state)
    $.ajax({
        url: LoadBoard.API + 'trucker/location-list',
        dataType: "json",
        type: 'post',
        async:false,
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "user_id": LoadBoard.userid,
            "operation": "state_list",
            "country_id": country
        }),
        contentType: "application/json",
        // data:{operation:"state_list" ,country_id:country },
        success: function(result) {
            if (result.status) {
                if (result.data.length != 0) {
                    $("#state").empty();
                    var option = "<option value=''>Please Select State</option>";
                    for (var i = 0; i < result.data.length; i++) {
                        if (result.data[i]['id'] == state) {
                            var selected = "selected=selected";
                        } else {
                            var selected = "";
                        }
                        option += "<option " + selected + " value=" + result.data[i]['id'] + ">" + result.data[i]['name'] + "</option>";

                    }
                    $("#state").append(option);
                    $("#city").val("");
                }
            }
        }
    });
}



function city_list(state_id = "", city = "") {
    var state = state_id;
    var city = city;
    //alert(city)
    $.ajax({
        url: LoadBoard.API + 'trucker/location-list',
        dataType: "json",
        type: 'post',
        headers: {
            Authorization: "Bearer " + LoadBoard.token
        },
        data: JSON.stringify({
            "user_id": LoadBoard.userid,
            "operation": "city_list",
            "state_id": state
        }),
        contentType: "application/json",
        // data:{operation:"city_list" , state_id: state},
        success: function(result) {

            if (result.status) {
                if (result.data.length != 0) {
                    $("#city").empty();
                    var option = "<option value=''>Please Select City</option>";
                    for (var i = 0; i < result.data.length; i++) {
                        if (result.data[i]['id'] == city) {
                            var selected = "selected=selected";
                        } else {
                            var selected = "";
                        }
                        option += "<option " + selected + " value=" + result.data[i]['id'] + ">" + result.data[i]['name'] + "</option>";

                    }
                    $("#city").html(option);
                }
            }
        }
    });
} 
</script>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="add_vehicle_tab" tabindex="-1" role="dialog" aria-labelledby="cancel_confirm" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content"> 
      <div class="modal-header  text-center">
        <h5 class="modal-title" id="mySmallModalLabel">Vehicle Details</h5>
        <button type="button" class="close cls_lod" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body cancel-trip">
          <form name="form-vehicle-details" id="form-vehicle-details" method="post">
            <input type="hidden" id="edituniqueid" name="edituniqueid" value="" />
          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Vehicle Identification Number</label>
                 <input type="text" class="form-control" maxlength="17" name="veh_id_no" id="veh_id_no" placeholder="Vehicle Identification Number" value="" > 
                 <label id="veh_id_no-error" class="error" for="" style="display: none;"></label>
                 <label id="veh_id_no1-error" class="error" for="" style="display: none;"></label>  
              </div>
            </div>
             <div class="col-sm-6 col-md-6">
              <div class="form-group">
                <label class="form-label">Unit / Truck Number</label>
                 <input type="text" class="form-control" name="veh_unit" id="veh_unit" placeholder="Unit / Truck Number" value="" >   
                 <label id="veh_unit-error" class="error" for="" style="display: none;"></label> 
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Make</label>                        
                <input type="text" id="veh_make" name="veh_make" class="form-control" placeholder="Make" value="">
                <label id="veh_make-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Model</label>
                 <input type="text" class="form-control" name="veh_model" id="veh_model" placeholder="Model" value="" > 
                 <label id="veh_model-error" class="error" for="" style="display: none;"></label>   
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Type</label>                        
                <input type="text" name="veh_type"  id="veh_type"  class="form-control" placeholder="Type" value="">
                <label id="veh_type-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
           
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Weight</label>
                 <input type="text" class="form-control" name="veh_weight" placeholder="lbs" maxlength="6" id="veh_weight" placeholder="" value="" >   
                 <label id="veh_weight-error" class="error" for="" style="display: none;"></label> 
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Length</label>                        
                <input type="text" name="veh_length" placeholder="ft" id="veh_length" maxlength="3"  class="form-control" value="">
                <label id="veh_length-error" class="error" for="" style="display: none;"></label>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="form-group">
                <label class="form-label">Height</label>
                 <input type="text" class="form-control" name="veh_height" placeholder="ft" maxlength="3" id="veh_height" placeholder="" value="" >  
                 <label id="veh_height-error" class="error" for="" style="display: none;"></label>  
              </div>
            </div>
          </div>     
          
          <div class="text-right pr-3 pb-3">
            <div id="continuevalid"></div>
            <div id="editcontinuevalid"></div>
          </div>  
          </form>
      </div>
    </div>
  </div>
</div>





<div class="modal fade  " id="conirm-vehicle-delete" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2 pop_up_font" id="mySmallModalLabel">Delete Vehicle Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <p>Are you sure want to Delete the Vehicle Details?</p>       
        </div>
    <div class="modal-footer">
      <input type="hidden" id="uniqueid" value="" />
      <button type="button" class="btn btn-primary delete_vehicle">Yes</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
             </div>
    
    </div>
  </div>
</div>