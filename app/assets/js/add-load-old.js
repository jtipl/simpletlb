function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
  }
  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  $("#orgin_city").val("");
  $("#orgin_state").val("");
  $("#orgin_country").val("");
  $("#orgin_postal").val("");
  $("#orgin_country_code").val("");
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      
     // orgin_state
      if(addressType=='locality'){
          document.getElementById("orgin_city").value = val;
      } if(addressType=='administrative_area_level_1'){
          document.getElementById("orgin_state").value = val;
      }if(addressType=='country'){
          document.getElementById("orgin_country").value = val;
      }if(addressType=='postal_code'){
          document.getElementById("orgin_postal").value = val;
      }

         document.getElementById(addressType).value = val;
    }
    // for the country, get the country code (the "short name") also
    if (addressType == "country") {
      document.getElementById("orgin_country_code").value = place.address_components[i].short_name;
    }
  }
}
var placeSearch, autocomplete;
/*var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
};*/

var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};


function initialize() {

  autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('autocomplete_search_orgin')), {
    //  componentRestrictions: {country: "in"}
          componentRestrictions: {'country': ['us', 'ca']}
    });
  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  // Get Latitude and longitude
  var isoriginval =false;
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    //alert(place)
    $('#orgin_lat').val(place.geometry.location.lat());
    $('#orgin_lng').val(place.geometry.location.lng());
    fillInAddress();
    var isoriginval =true;
  });

}
google.maps.event.addDomListener(window, 'load', initialize);


function fillInAddress1() {
  // Get the place details from the autocomplete object.
  var place = autocomplete1.getPlace();

  for (var component in componentForm) {
    document.getElementById(component).value = '';
  }
  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  $("#destination_city").val("");
  $("#destination_state").val("");
  $("#destination_country").val("");
  $("#destination_postal").val("");
  $("#destination_country_code").val("");
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm1[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
     
      if(addressType=='locality'){
          document.getElementById("destination_city").value = val;
      } if(addressType=='administrative_area_level_1'){
          document.getElementById("destination_state").value = val;
      }if(addressType=='country'){
          document.getElementById("destination_country").value = val;
      }if(addressType=='postal_code'){
          document.getElementById("destination_postal").value = val;
      }
      document.getElementById(addressType).value = val;
    }
    // for the country, get the country code (the "short name") also
    if (addressType == "country") {
      document.getElementById("destination_country_code").value = place.address_components[i].short_name;
    }
  }
}


var placeSearch1, autocomplete1;
var componentForm1 = {
 // street_number: 'short_name',
  //route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};

function initialize2() {
  autocomplete1 = new google.maps.places.Autocomplete(
    (document.getElementById('autocomplete_search_destin')), {
    //  componentRestrictions: {country: "in"}
          componentRestrictions: {'country': ['us', 'ca']}

    });
  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  // Get Latitude and longitude
  var isdestingval =false;
  google.maps.event.addListener(autocomplete1, 'place_changed', function() {
    var place = autocomplete1.getPlace();
    $('#destination_lat').val(place.geometry.location.lat());
    $('#destination_lng').val(place.geometry.location.lng());
    fillInAddress1();
    var isdestingval =true;
  });

}
google.maps.event.addDomListener(window, 'load', initialize2);

$(document).ready(function(){

  $("#autocomplete_search_orgin").on("change",function(){
    //alert("hii")
    $(this).val("");
  })
  $("#autocomplete_search_destin").on("change",function(){
    //alert("hii")
    $(this).val("");
  })

   equipment();

  $("#pickup_date").datepicker({
      todayHighlight:'TRUE',
      startDate: '-0d',
      autoclose: true,
      onSelect: function() {
        return $(this).trigger('change');
      }
  });

  $("#delivery_date").datepicker({
      todayHighlight:'TRUE',
      startDate: '-0d',
      autoclose: true,
      onSelect: function() {
        return $(this).trigger('change');
      }
  });

  $("#pickup_date").on("change",function (){ 
      $("label#pickup_date-error").html('');
  });
  $("#delivery_date").on("change",function (){ 
      $("label#delivery_date-error").html('');
  });

 /* $("#autocomplete_search_orgin").on("keyup",function(){
    var autocomplete_search_orgin =$(this).val();
    if(autocomplete_search_orgin!=""){
      //alert("HIII")
      $("label#autocomplete_search_orgin-error").html("").css("display","none");
    }
  });
  $("#autocomplete_search_destin").on("keyup",function(){
    var autocomplete_search_destin =$(this).val();
    if(autocomplete_search_destin!=""){
      //alert("HIII")
      $("label#autocomplete_search_destin-error").html("").css("display","none");
    }
  });*/

  jQuery.validator.addMethod("special_charac", function (inputtxt) {
     var filter = /[\^£$%&*}{@#~?><>|=_+¬-]/;
      if (filter.test(inputtxt)) {
          return false;
      } else {
          return true;
      }
  });

  jQuery.validator.addMethod("zero_validate", function (inputtxt) {
     var filter = /^[-+]?[0][0-6]+$/;
      if (filter.test(inputtxt)) {
          return false;
      } else {
          return true;
      }
  });

jQuery.validator.addMethod("origincityvalid", function (inputtxt) {
      var origincity_valid=$("#orgin_city").val();
      if(origincity_valid!=''){
        $("#autocomplete_search_orgin-error").css("display","none");
        return true;
      }else{
         $("#autocomplete_search_orgin-error").css("display","block");
        return false;
      }
 });
jQuery.validator.addMethod("destinationcityvalid", function (inputtxt) {
    var destination_valid=$("#destination_city").val();
        if(destination_valid!=''){
           $("#autocomplete_search_destin-error").css("display","none");
           return true;
        }else{
           $("#autocomplete_search_destin-error").css("display","block");
          return false;
        }
});

    $("#addformload").validate({
                rules: {
                  origin:{
                    required:true,
                    //origincityvalid:true,
                   // special_charac:true,
                  },
                  destination:{
                    required:true,
                   // destinationcityvalid:true,
                    //special_charac:true,
                  },
                  pickup_date:{
                    required:true,
                  },
                  delivery_date:{
                    required:true,
                  },
                  weight:{
                    required:true,
                     maxlength: 6,
                     zero_validate:true
                  },
                  length:{
                    required:true,
                    //maxlength: 2,
                    zero_validate:true
                  },
                  height:{
                    required:true,
                    maxlength: 3,
                    zero_validate:true
                  },
                  equipment:{
                    required:true,
                  },
                  price:{
                    required:true,
                    zero_validate:true
                  },
                },
                messages: {
                    origin:{
                    required:"Please enter valid origin address",
                    origincityvalid:"Please enter valid origin address",
                   // special_charac:"Please enter the valid origin",
                  },
                  destination:{
                    required:"Please enter valid destination address",
                    destinationcityvalid:"Please enter valid destination address",
                   // special_charac:"Please enter the valid destination",
                  },
                  pickup_date:{
                    required:"Please enter valid pickup date",
                  },
                  delivery_date:{
                    required:"Please enter valid delivery date",
                  },
                  weight:{
                    required:"Please enter the weight",
                    zero_validate:"Weight cannot accept all zero values "
                  },
                  length:{
                    required:"Please enter the length",
                     zero_validate:"Length cannot accept all zero values "
                  },
                  height:{
                    required:"Please enter the height",
                     zero_validate:"Height cannot accept all zero values "
                  },
                  equipment:{
                    required:"Please enter the equipment ",
                  },
                  price:{
                    required:"Please enter the price",
                    zero_validate:"Price cannot accept all zero values "
                  },
                },

                submitHandler: function() {
                    var origin_lat = $("#orgin_lat").val();
                    var origin_lng = $("#orgin_lng").val();
                    var destination_lat = $("#destination_lat").val();
                    var destination_lng = $("#destination_lng").val();

                    var autocomplete_search_orgin = $("#autocomplete_search_orgin").val();
                    var autocomplete_search_destin = $("#autocomplete_search_destin").val();
                    var pickup_date = $("#pickup_date").val();
                    var delivery_date = $("#delivery_date").val();

                    var pickup_hour = $("#pickup_hour").val();
                    var delivery_hour = $("#delivery_hour").val();

                    var pickup_minute = $("#pickup_minute").val();
                    var delivery_minute = $("#delivery_minute").val();

                    var pickup_second = $("#pickup_second").val();
                    var delivery_second = $("#delivery_second").val();                  

                    var weight = $("#weight").val();
                    var length = $("#length").val();
                    var height = $("#height").val();
                    var price = $("#price").val();

                    //alert(orgin_lng)

                     var distance=distancecal(origin_lat,origin_lng,destination_lat,destination_lng,"K");
                     $("#distance_disp").html(distance);
                   // var equipment = $("input[name=equipment]:checked").val();
                     var equipment = $("#equipment").val();
                      $.ajax({
                        type:'POST',
                        url:LoadBoard.API+'trucker/equipment-list',
                        async:false,
                        dataType: 'json',
                        data:{operation:"equipment-list","equipment":equipment },
                        success:function(result){
                            //alert(result.truck_name);
                            $("#equipment_disp").html(result.truck_name);
                        }
                      });

                    var pickup_time_format = pickup_hour+":"+pickup_minute+" "+pickup_second;
                    if(pickup_time_format=="0:00 AM"){
                      pickup_time_format_val = "";
                      $("#pickuptime_disp").html(pickup_time_format_val).removeClass("time");
                      $(".timelabel_pickup").hide();
                    } else {
                      pickup_time_format_val = pickup_time_format;
                      $("#pickuptime_disp").html(pickup_time_format_val).addClass("time");
                      $(".timelabel_pickup").show();
                    }
                    var delivery_time_format = delivery_hour+":"+delivery_minute+" "+delivery_second;
                    if(delivery_time_format=="0:00 AM"){
                      delivery_time_format_val = "";
                      $("#deliverytime_disp").html(delivery_time_format_val).removeClass("time");
                      $(".timelabel_delivery").hide();
                    } else {
                      delivery_time_format_val = delivery_time_format;

                      $("#deliverytime_disp").html(delivery_time_format_val).addClass("time");
                      $(".timelabel_delivery").show();
                    }



                    $("#origin_disp").html(autocomplete_search_orgin);
                    $("#destination_disp").html(autocomplete_search_destin);
                   // $("#pickupdate_disp").html(pickup_date);

                    var pdate =pickup_date.split("/");
                    var pyear = pdate[2];
                    var pmonth = pdate[0];
                    var pdate = pdate[1];
                    var p_mthname = GetMonthName(pmonth);
                    var pdata = p_mthname + " " + pdate + ", " + pyear;
                    $("#pickupdate_disp").html(pdata);


                   // $("#deliverydate_disp").html(delivery_date);
                    var ddate = delivery_date.split("/");
                    var dyear = ddate[2];
                    var dmonth = ddate[0];
                    var ddate = ddate[1];
                    var d_mthname = GetMonthName(dmonth);
                    var ddata = d_mthname + " " + ddate + ", " + dyear;

                    
                    $("#deliverydate_disp").html(ddata);

                    
                    $("#truck_load_type_disp").html($("input[name=truck_load_type]:checked").val());
                    

                    $("#weight_disp").html(weight);
                    $("#length_disp").html(length);
                    $("#price_disp").html(price);
                    $("#height_disp").html(height);
                    if(pickup_date==delivery_date) {
                      if(pickup_time_format_val > delivery_time_format_val && delivery_time_format_val > "12:00 AM"){
                        $("label#delivery_time-error").html("Delivery time should be greater than pickup time").css("display","block");
                        return false;
                      } else {
                        //alert("less");
                        $("#confirm_add_load").modal("show");
                      }
                    } else {
                      $("#confirm_add_load").modal("show");
                    }
                  }
              });

        $(".submitformload").on('click',function(){
          var orgin_lat = $("#orgin_lat").val();
          var orgin_lng = $("#orgin_lng").val();
          var destination_lat = $("#destination_lat").val();
          var destination_lng = $("#destination_lng").val();
          var data=$('#addformload').serialize();
          addloadcheck(data); 
        });

        var $pdatepic = $('#pickup_date').datepicker();
        var $ddatepic = $('#delivery_date').datepicker();

        $(".save_add_new").on('click',function(){
            var orgin_lat = $("#orgin_lat").val();
            var orgin_lng = $("#orgin_lng").val();
            var destination_lat = $("#destination_lat").val();
            var destination_lng = $("#destination_lng").val();
            $pdatepic.datepicker('setDate', new Date());
            $ddatepic.datepicker('setDate', new Date());
            var data=$('#addformload').serialize();
            addloadcheck1(data);
        });

        $("#weight").focusout(function(){
          var val = parseFloat($('#weight').val());
          if (isNaN(val) || (val === 0))
          {
            $("label#weight-error").html("");
            $("span#weight-error").html('Weight cannot accept all zero values').css('display','block');
          } else {
            $("span#weight-error").html("").css('display','none');
          }
        });
        $("#length").focusout(function(){
          var val = parseFloat($('#weight').val());
          if (isNaN(val) || (val === 0))
          {
            $("label#length-error").html("");
            $("span#length-error").html('Length cannot accept all zero values').css('display','block');
          }else {
            $("span#length-error").html("").css('display','none');
          }
        });

        $("#height").focusout(function(){
          var val = parseFloat($('#height').val());
          if (isNaN(val) || (val === 0))
          {
            $("label#height-error").html("");
            $("span#height-error").html('Height cannot accept all zero values').css('display','block');
          }else {
            $("span#height-error").html("").css('display','none');
          }
        });
         $("#price").focusout(function(){
          var val = parseFloat($('#weight').val());
          if (isNaN(val) || (val === 0))
          {
            $("label#price-error").html("");
            $("span#price-error").html('Price cannot accept all zero values').css('display','block');
          }else {
            $("span#price-error").html("").css('display','none');
          }
        });
         $("#weight,#length,#price,#height").keypress(function(e){
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

       

        $("#weight,#length,#price,#height").keypress(function(e){ 
           if (this.value.length == 0 && e.which == 48 ){
            return false;
           }
        });

    

   
    /*$(".addnewload").on('click',function(){

      var autocomplete_search_orgin = $("#autocomplete_search_orgin").val();
      var autocomplete_search_destin = $("#autocomplete_search_destin").val();

      var regx = /^[0-9_.-]+$/;
      var orgin_lat = $("#orgin_lat").val();
      var orgin_lng = $("#orgin_lng").val();
      var destination_lat = $("#destination_lat").val();
      var destination_lng = $("#destination_lng").val();

      var pickup_date = $("#pickup_date").val();
      var delivery_date = $("#delivery_date").val();
     // var truck_load = $("#truck_load").val();

      var weight = $("#weight").val();
      var length = $("#length").val();
      var equipment = $("#equipment").val();

      var orgin_check=alphanumeric(autocomplete_search_orgin);
      var destination_check=alphanumeric(autocomplete_search_destin);

      var price = $("#price").val();
      if(autocomplete_search_orgin==""){
           toastr.error("Invalid : Enter a Valid Origin", "Origin", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(autocomplete_search_destin==""){
         toastr.error("Invalid: Enter a valid destination", "Destination", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(autocomplete_search_orgin!='' && orgin_check==false ){
          toastr.error("Origin should be valid address or city", "Origin", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      } else if(autocomplete_search_destin!='' && destination_check==false ){
          toastr.error("Destination should be valid address or city", "Destination", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(pickup_date==""){
            toastr.error("Pickup date cannot be empty", "Pickup Date", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;   
      }
      else if(delivery_date==""){
            toastr.error("Delivery date cannot be empty", "Delivery Date", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(weight==""){
             toastr.error("Weight cannot be empty", "Weight", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(length==""){
          toastr.error("Length cannot be empty ", "Length", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
       else if(equipment==""){
           toastr.error(" Please select Any One", "Equipment", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else if(price==""){
            toastr.error("Enter a valid Price ", "Price", {
              "timeOut": "0",
              "extendedTImeout": "0"
          });
          return false;
      }
      else {
          var data=$('#addformload').serialize();
          addloadcheck(data); 
      }
    });*/
});

function equipment(truck_id){

}
function addloadcheck(data=""){
 
  
   $('.preloader').show();
   $.ajax({
      type: 'post',
      url: LoadBoard.API+'broker/add-load',
      dataType: "json",
      data: data+"&token="+LoadBoard.token,
      success: function (result) {
       
        if(result.status==1){
           $('.preloader').hide();
           $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
           $("#autocomplete_search_destin-error").html(result.msg).hide();
            
            $("input[type=text],input[type=time]").val('');
            
            window.location.href=LoadBoard.APP+"broker/loads";
        }else if(result.status==0){
           $('.preloader').hide();
          if(result.msg == 'Please enter the origin Latitude' || result.msg == 'Invalid address please provide valid origin city'){
              $("#autocomplete_search_orgin").css("border","1px solid red");
              $("#autocomplete_search_orgin-error").html(result.msg).show();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }else if(result.msg == 'Please enter the destination latitude' || result.msg == 'Invalid address please provide valid destination city'){
              $("#autocomplete_search_destin").css("border","1px solid red");
              $("#autocomplete_search_destin-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }else if(result.msg == 'Please enter the valid length'){
              $("#length").css("border","1px solid red");
              $("#length-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }  else if(result.msg == 'Delivery date should be greater than Pickup date'){
              $("#delivery_date").css("border","1px solid red");
              $("#delivery_date-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
          } else if(result.msg == 'Destination should be valid address or city'){
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid red");
              $("#autocomplete_search_destin-error").html(result.msg).show();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
          }   else if(result.msg == 'Orgin should be valid address or city'){
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
              $("#autocomplete_search_orgin").css("border","1px solid red");
              $("#autocomplete_search_orgin-error").html(result.msg).show();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
          }   

          $("#confirm_add_load").modal("hide");
          return false;
        }else if(result.status==2){
           window.location.href = LoadBoard.APP+'logout';                   
        }
      }
   });
   
}

function addloadcheck1(data=""){
 
  
   $('.preloader').show();
   $.ajax({
      type: 'post',
      url: LoadBoard.API+'broker/add-load',
      dataType: "json",
      data: data+"&token="+LoadBoard.token,
      success: function (result) {
        if(result.status==1){
           $('.preloader').hide();
           $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
           $("#autocomplete_search_destin-error").html(result.msg).hide();
            
            $("input[type=text],input[type=time]").val('');
            $('#addformload')[0].reset();
            $("#confirm_add_load").modal("hide");
            //window.location.href=LoadBoard.APP+"broker/loads";
        }else if(result.status==0){
           $('.preloader').hide();
          if(result.msg == 'Please enter the origin Latitude' || result.msg == 'Invalid address please provide valid origin city'){
              $("#autocomplete_search_orgin").css("border","1px solid red");
              $("#autocomplete_search_orgin-error").html(result.msg).show();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }else if(result.msg == 'Please enter the destination latitude' || result.msg == 'Invalid address please provide valid destination city'){
              $("#autocomplete_search_destin").css("border","1px solid red");
              $("#autocomplete_search_destin-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }else if(result.msg == 'Please enter the valid length'){
              $("#length").css("border","1px solid red");
              $("#length-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
          }  else if(result.msg == 'Delivery date should be greater than Pickup date'){
              $("#delivery_date").css("border","1px solid red");
              $("#delivery_date-error").html(result.msg).show();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();

          }  else if(result.msg == 'Destination should be valid address or city'){
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
              $("#autocomplete_search_orgin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_orgin-error").html(result.msg).hide();
              $("#autocomplete_search_destin").css("border","1px solid red");
              $("#autocomplete_search_destin-error").html(result.msg).show();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
          }   else if(result.msg == 'Orgin should be valid address or city'){
              $("#delivery_date").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#delivery_date-error").html(result.msg).hide();
              $("#autocomplete_search_orgin").css("border","1px solid red");
              $("#autocomplete_search_orgin-error").html(result.msg).show();
              $("#autocomplete_search_destin").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#autocomplete_search_destin-error").html(result.msg).hide();
              $("#length").css("border","1px solid rgba(0, 40, 100, 0.20 )");
              $("#length-error").html(result.msg).hide();
          }   
          $("#confirm_add_load").modal("hide");
          return false;
        }else if(result.status==2){
           window.location.href = LoadBoard.APP+'logout';                   
        }
      }
   });
   
}





  function alphanumeric(inputtxt) {
    var filter = /[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/;
    if (filter.test(inputtxt)) {
        return false;
    } else {
        return true;
    }
  }




var inputEle1 = document.getElementById('timepicker1');
var inputEle2 = document.getElementById('timepicker2');

function pickup_time() {
  var timeSplit = inputEle.value.split(':'),
    hours,
    minutes,
    meridian;
  hours = timeSplit[0];
  minutes = timeSplit[1];
  if (hours > 12) {
    meridian = 'PM';
    hours -= 12;
  } else if (hours < 12) {
    meridian = 'AM';
    if (hours == 0) {
      hours = 12;
    }
  } else {
    meridian = 'PM';
  }
  alert(hours + ':' + minutes + ':' + meridian);
}

function delivery_time() {
  var timeSplit = inputEle2.value.split(':'),
    hours,
    minutes,
    meridian;
  hours = timeSplit[0];
  minutes = timeSplit[1];
  if (hours > 12) {
    meridian = 'PM';
    hours -= 12;
  } else if (hours < 12) {
    meridian = 'AM';
    if (hours == 0) {
      hours = 12;
    }
  } else {
    meridian = 'PM';
  }
  alert(hours + ':' + minutes + ':' + meridian);
}


function equipment(){
 


  $.ajax({
    type:'POST',
    url:LoadBoard.API+'trucker/equipment-list',
    dataType: 'json',
    data:{operation:"equipment" },
    success:function(result){
   

      $(".pickup_time_display").hide(); 
  $(".delivery_time_display").hide(); 
  $(".toggle_pickuptime").click(function(){
      //alert("hi");
      $(this).hide();
      $(".pickup_time_display").show();
  });
   $(".toggle_deliverytime").click(function(){
      //alert("hi");
      $(this).hide();
      $(".delivery_time_display").show();
  });

  //

  $(".myclose").click(function(){
    $(".toggle_pickuptime").show();
    $(".pickup_time_display").hide();
  });

  $(".myclose1").click(function(){
    $(".toggle_deliverytime").show();
    $(".delivery_time_display").hide();
  });


      var selectoption='<option value="">Please select equipment</option>';
      for(i=0;i<result.data.length;i++){
          selectoption +='<option value="'+result.data[i]["id"]+'">'+result.data[i]["truck_name"]+'</option>';
          /*if(result.data[i]["truck_name"]=="Flatbed"){
            var check = 'checked=checked';
          } else {
            var check  = '';
          }
          var  option ='<div class="selectgroup w-25 equipmentlist"><label class="selectgroup-item"><input type="radio" '+check+' id="equipment" name="equipment"  value="'+result.data[i]["id"]+'" class="selectgroup-input" ><span class="selectgroup-button">'+result.data[i]["truck_name"]+'</span></label></div>'; */
         // $("#append_equipment").append(option);
      } 
  
      $("#equipment").html(selectoption);
    }
  });
}


  function distancecal(lat1, lon1, lat2, lon2, unit) {
    if ((lat1 == lat2) && (lon1 == lon2)) {
        return 0;
    }
    else {
        var radlat1 = Math.PI * lat1/180;
        var radlat2 = Math.PI * lat2/180;
        var theta = lon1-lon2;
        var radtheta = Math.PI * theta/180;
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        if (dist > 1) {
            dist = 1;
        }
        dist = Math.acos(dist);
        dist = dist * 180/Math.PI;
        dist = dist * 60 * 1.1515;
        if (unit=="K") { dist = dist * 1.609344 }
        if (unit=="N") { dist = dist * 0.8684 }
        return dist;
    }
}

  //Get Month Name
    function GetMonthName(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber - 1];
    }