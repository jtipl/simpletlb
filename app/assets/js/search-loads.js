//Google Map Init
var componentForm = {
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
};
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
  var options = {
  types: ['(regions)'],
  //componentRestrictions: {country: "in"}
          componentRestrictions: {'country': ['us', 'ca']}

 };
 //regions
  var input_orgin = document.getElementById('autocomplete_search_orgin');
  var autocomplete_search_orgin = new google.maps.places.Autocomplete(input_orgin,options);
  autocomplete_search_orgin.addListener('place_changed', function () {
    var place_orgin = autocomplete_search_orgin.getPlace();
    /*for (var i = 0; i < place_orgin.address_components.length; i++) {
    var addressType = place_orgin.address_components[i].types[0];
    if (componentForm[addressType]) {
    var val = place_orgin.address_components[i][componentForm[addressType]];
    if(addressType=='administrative_area_level_1'){
    document.getElementById("orgin_state").value = val;
        }
      }
    }*/
    $('#orgin_lat').val(place_orgin.geometry['location'].lat());
    $('#orgin_lng').val(place_orgin.geometry['location'].lng());
  });
}
google.maps.event.addDomListener(window, 'load', initialize2);
function initialize2() {
  var options2 = {
  types: ['(regions)'],
//  componentRestrictions: {country: "in"}
   componentRestrictions: {'country': ['us', 'ca']}

 };
  var input_desting = document.getElementById('autocomplete_search_destin');
  var autocomplete_search_destin = new google.maps.places.Autocomplete(input_desting,options2);
  autocomplete_search_destin.addListener('place_changed', function () {
    var place_detsin = autocomplete_search_destin.getPlace();
   /* for (var i = 0; i < place_detsin.address_components.length; i++) {
    var addressType = place_detsin.address_components[i].types[0];
    if (componentForm[addressType]) {
    var val = place_detsin.address_components[i][componentForm[addressType]];
    if(addressType=='administrative_area_level_1'){
    document.getElementById("destination_state").value = val;
        }
      }
    }*/
    $('#destination_lat').val(place_detsin.geometry['location'].lat());
    $('#destination_lng').val(place_detsin.geometry['location'].lng());
  });

}
var searchdata="";
var searchtable;

function originInAddress(place) {
  if(!place)
    var place = autocomplete.getPlace();

  $('#orgin_lat').val(place.geometry['location'].lat());
  $('#orgin_lng').val(place.geometry['location'].lng());

}
function destinationInAddress(place) {
  if(!place)
    var place = autocomplete.getPlace();

  $('#destination_lat').val(place.geometry['location'].lat());
  $('#destination_lng').val(place.geometry['location'].lng());

}
$(document).ready(function(){
  $("#weight").keypress(function(e){
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

       

        $("#weight").keypress(function(e){ 
           if (this.value.length == 0 && e.which == 48 ){
            return false;
           }
        });



  $("#autocomplete_search_orgin").on("change",function(){
    var val = $(this).val();
    if(val!=""){
      $(this).css('border','1px solid rgba(0, 40, 100, 0.2)');
      //alert("hi");
      $("label.search_origin").css('border','1px solid rgba(0, 40, 100, 0.2)').html("");
    }
    $(this).val("");
  });
  $("#autocomplete_search_destin").on("change",function(){
    var val = $(this).val();
    if(val!=""){
      $(this).css('border','1px solid rgba(0, 40, 100, 0.2)');
    }
    $(this).val("");
  });
 /*$('#autocomplete_search_orgin').keydown(function (e) {
            if (e.keyCode == 13 || e.keyCode == 9) {
                $(e.target).blur();
                if($(".pac-container .pac-item:first span:eq(3)").text() == "")
                    var firstResult = $(".pac-container .pac-item:first .pac-item-query").text();
                else
                    var firstResult = $(".pac-container .pac-item:first .pac-item-query").text() + ", " + $(".pac-container .pac-item:first span:eq(3)").text();

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({"address":firstResult }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        placeName = results[0];
                        e.target.value = firstResult;
                        originInAddress(placeName);
                       

                    }
                });
            }

        });*/
    
 /* $('#autocomplete_search_destin').keydown(function (e) {
            if (e.keyCode == 13 || e.keyCode == 9) {
                $(e.target).blur();
                if($(".pac-container .pac-item:first span:eq(3)").text() == "")
                    var firstResult = $(".pac-container .pac-item:first .pac-item-query").text();
                else
                    var firstResult = $(".pac-container .pac-item:first .pac-item-query").text() + ", " + $(".pac-container .pac-item:first span:eq(3)").text();

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({"address":firstResult }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        placeName = results[0];
                        e.target.value = firstResult;
                        destinationInAddress(placeName);
                    }
                });
            }

        });
*/
    

$('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });

 // $.getScript(LoadBoard.APP+"assets/js/jquery-1.11.1.min.js");

var seracrtop=getUrlParameter('id');
if(seracrtop!=undefined && seracrtop!='undefined'){
  $("#autocomplete_search_orgin").val(seracrtop .replace(/\+/g, ' '));

}
  //DatePciker  Init
  $("#pickup_date").datepicker({
        todayHighlight:'TRUE',
       // startDate: '-0d',
        autoclose: true ,
    }).on('changeDate', function (selected) {
       // var minDate1 = new Date(selected.date.valueOf());
       // $('#delivery_date').datepicker('setStartDate', minDate1);
       
    });

    //Weight validation
     $("#weight").keypress(function(e){
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

    //Autocomplete validation
     $('#autocomplete_search_orgin').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    //Weight keypress validation
    $('#weight').keypress(function(e){ 
       if (this.value.length == 0 && e.which == 48 ){
        return false;
      }
    });

    //Autocomplete places
     $('#autocomplete_search_destin').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9-]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

   
   // Search load starts here
    if($("#re_open_decode").val()!=""){
      var re_open_decode = $("#re_open_decode").val();
      var action = "re_open"; 
    } else {
      var re_open_decode = "";
      var action = "all_search_loads";
    }
    // Search load ends here
   

   

      searchtable=$('#viewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": "", "sSearch": "<a href='javscript:void(0);' id='clear_loads' style='display:none'>Clear Loads</a> _INPUT_"},
          dom: 'Bfrtip',
          "ajax": {
           // url: LoadBoard.API+"trucker/search-loads?action="+action,
            url: LoadBoard.API+"trucker/search-loads",
            type:"post",
             headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
              contentType: "application/json",
          "data": function(data){
              $('.preloader').show();
             var truck_types = [];
            $.each($("input[name='truck_type[]']:checked"), function(){            
                truck_types.push($(this).val());
            });
           var truck_models=truck_types.join(", ");
           var trutype="";
            if($("input[name='truck_load_type']:checked").val()!=undefined || $("input[name='truck_load_type']:checked").val()!='undefined'){
                  trutype=$("input[name='truck_load_type']:checked").val();
            }
            var ttype="";
            if(trutype==undefined){
              ttype="";
            }
            else{
              ttype=trutype;
            }
          //  data.token = LoadBoard.token;
            data.origin = $("#autocomplete_search_orgin").val();
            data.destination = $("#autocomplete_search_destin").val();
            data.pickup_date = $("#pickup_date").val();
            data.truck_load_type = ttype;
            data.truck_type = truck_models;
            data.weight = $("#weight").val();
            data.deadhead = $("#deadhead").val();
            data.des_deadhead = $("#des_deadhead").val();
            data.destination_lat = $("#destination_lat").val();
            data.destination_lng = $("#destination_lng").val();
            data.orglat = $("#orgin_lat").val();
            data.orglon = $("#orgin_lng").val();
            data.des_action = $("#des_action").val();
            data.org_action = $("#org_action").val();
            data.user_id =LoadBoard.userid,
            data.action =action;
              return   JSON.stringify(data);
          },
           "dataFilter": function(data) {
                 $('.preloader').hide();
           
             var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
            if(rowCount ==0){
              $("#viewloads_info").hide();
            } else {
              $("#viewloads_info").show();

              }

              if(data.recent_loads!=undefined){
                  if(data.data!=""){
                     $("#clear_loads").show();

                  }else{
                     $("#clear_loads").hide();

                  }
              }else{
                $("#clear_loads").hide();
              }
              if(data.status==2){
                   window.location.href = LoadBoard.APP + "logout";
              }else{
                 return JSON.stringify(data);
              }
            },

          },
             "bLengthChange": false,  
              "type": "POST",
              "showNEntries" : false,
              //"bInfo":false,
              "bPaginate":true,
              "bProcessing": false,
              "bServerSide": true,
              "bSortable": false,
              "bAutoWidth": false,
              "order": [[ 1, "desc" ]],
              "columns": [
                {"data":"id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "delivery_date"},
               /*  {"data": "weight"},
                {"data": "length"},*/
                {"data": "truck_name" },
                {"data": "broker" },
              /*  {"data": "pickup_date" },*/
                {"data": "price" },
                {"data": "status" },
               // {"data": "load_id"},
               //{"data": "created_date"}
               // {"data": "weight" },
               // {"data": "truck_load_type" },
               // {"data": "truck_id" }
                
            ],
    columnDefs: [
      {
        targets: 0,
        bSortable: false, 
        render: function (data,type,row) {
          if(row.wish_status==1){
            return '<span class="tool" style="font-weight: normal;" data-tip="Remove from wish list" tabindex="1" ><a class="fa fa-bookmark wish wishlist_'+row.id+'" id="wish_click" href="javascript:void(0)" data-load-id="'+window.btoa(row.id)+'" ></a></span>';
          }else if(row.wish_status==0){
            return '<span class="tool" style="font-weight: normal;" data-tip="Add to wish list" tabindex="1" ><a class="fe fe-bookmark not_wish wishlist_'+row.id+'" id="wish_click" href="javascript:void(0)"  data-load-id="'+window.btoa(row.id)+'" ></a></span>';
          }else{
            return '<a class="fe fe-bookmark not_wish wishlist_'+row.id+'" id="wish_click" href="javascript:void(0)" data-load-id="'+window.btoa(row.id)+'" ></a>';
          }


          // return '<a class="icon search_modals" href="javascript:void(0)" data-pdate="'+window.btoa(row.pickup_date)+'" data-origin="'+window.btoa(row.orgin)+'" data-dest="'+window.btoa(row.destination)+'" data-ddate="'+window.btoa(row.delivery_date)+'"  data-weight="'+window.btoa(row.weight)+'" data-length="'+window.btoa(row.length)+'" data-equ="'+window.btoa(row.truck_id)+'" data-broker="'+window.btoa(row.broker)+'" data-loadu-id="'+window.btoa(row.load_id)+'" data-tname="'+window.btoa(row.truck_name)+'" data-load-id="'+window.btoa(row.id)+'" data-bid="'+window.btoa(row.broker_id)+'"><i class="fe fe-external-link"></i></a>';
        }
      },
      {
        targets: 1,

       // width:"10%",
        render: function (data,type,row) {
                return '<a class="search_modals" href="javascript:void(0)" data-pdate="'+window.btoa(row.pickup_date)+'" data-origin="'+window.btoa(row.orgin)+'" data-dest="'+window.btoa(row.destination)+'" data-ddate="'+window.btoa(row.delivery_date)+'"  data-weight="'+window.btoa(row.weight)+'" data-length="'+window.btoa(row.length)+'" data-equ="'+window.btoa(row.truck_id)+'" data-broker="'+window.btoa(row.broker)+'" data-loadu-id="'+window.btoa(row.load_id)+'" data-tname="'+window.btoa(row.truck_name)+'" data-load-id="'+window.btoa(row.id)+'" data-bid="'+window.btoa(row.broker_id)+'">'+row.load_id+'</a>';
            }
      },
      
       {
        targets: 2,
       // width:"10%",
        render: function (data,type,row) {
               var orgt=row.origin.split(",");
               return orgt[0]+", "+orgt[1];

                }
      },
       
       {
        targets: 3,
        //width:"10%",
        render: function (data,type,row) {
            var dest=row.destination.split(",");
            return dest[0]+", "+dest[1];
          }
      },
      {
        targets: 4,
       // width:"10%",
        render: function (data,type,row) {
            return row.pickup_date;
          }
      },
      {
        targets: 5,
        //width:"10%",
        render: function (data,type,row) {
            return row.delivery_date;
          }
      },
      {
        targets: 6,
        //width:"5%",
        render: function (data,type,row) {
            return row.truck_name;
          }
      },
      {
        targets:7,
       // width:"10%",
          render: function (data,type,row) {
              var mystring = row.broker;
              if(mystring.length > 15){
                return '<span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...</span>';
              } else {
                return mystring;
              }
          }
        },
        {
        targets: 8,
       // width:"10%",
        render: function (data,type,row) {
           return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },

       {
        targets: 9,
        visible:false,
        render: function (data,type,row) {
            
            if(row.status==0 || row.status==5 || (row.approve_status!=1 && row.status!=1) && row.approve_status!=2 && row.status!=2 ){
              return '<span class="badge badge-success">Available</span>';
            }else{
              return '<span class="badge badge-danger">Not Available</span>';
            }
        }
      },
      
      ],
    }); 

       // searchtable.columns([9]).visible(false);

 //Clear recently viewed loads
 $(document).on("click", "#clear_loads", function() {
         swal.fire({
                    title: "Confirmation!",
                    text: "Do you want to clear the loads?",
                    type: "success",
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
                      
                   $.ajax({
                    type: 'post',
                    url: LoadBoard.API + 'trucker/clear-loads',
                    dataType: "json",
                    headers: {
                        Authorization: "Bearer " + LoadBoard.token
                    },
                    data: JSON.stringify({
                        "user_id": LoadBoard.userid
                    }),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                            }
                            toastr.success(result.msg);
                            searchtable.ajax.url(LoadBoard.API+"trucker/view-list").load();

                              
                        }
                    }
                })


                    }
                });
                 $("body").removeClass("swal2-height-auto");
        
    });

       $("#autocomplete_search_orgin").keypress(function(){
        if($("#autocomplete_search_orgin").val()==''){
          $(".search_origin").show();
          $("#autocomplete_search_orgin").css('border','1px solid red');
        }else{
          $(".search_origin").hide();
           $("#autocomplete_search_orgin").css('border','1px solid rgba(0, 40, 100, 0.20  )');
        }
      });
 //Search Datatable
     $('#search_loads').on('submit', function (e) {
          e.preventDefault();
         $("#clear_loads").hide();
          var autocomplete_search_orgin = $("#autocomplete_search_orgin").val();
          var autocomplete_search_destin = $("#autocomplete_search_destin").val();
          var pickup_date = $("#pickup_date").val();
         if(autocomplete_search_orgin==""){
           $(".search_origin").show();
            $("#autocomplete_search_orgin").css('border','1px solid red');
           return false;
          }else{
            $(".search_origin").hide();
            $("#autocomplete_search_orgin").css('border','1px solid rgba(0, 40, 100, 0.20 )');

            //searchtable.ajax.reload();
            searchtable.ajax.url(LoadBoard.API+"trucker/search-loads").load();
              $(".show_btn").show();

          }
      });
     
    //Clear Search
    $("#clear_search").on('click',function(e){
      $(".show_btn").hide();
      $("#autocomplete_search_orgin").val("");
      $("#autocomplete_search_destin").val("");
      $("#clear_loads").hide();

      $(".dytitle_ch").html("Available Loads");
      $(".dytitle_head").attr("data-tip","The list of open loads available for your confirmation that suits your search criteria");

       searchtable.ajax.url(LoadBoard.API+"trucker/search-loads").load();
       searchtable.columns([9]).visible(false);
      //
     // searchtable.ajax.reload();

    });

    $(".search_saves_list").on('click',function(e){
      $("#autocomplete_search_orgin").val("");
      $("#autocomplete_search_destin").val("");
      $("#clear_loads").hide();

      $(".dytitle_ch").html("Available Loads");
      $(".dytitle_head").attr("data-tip","The list of open loads available for your confirmation that suits your search criteria");



     // searchtable.ajax.reload();

    });

    //Recent viewed loads 
    //Confirm Popup Click Event
   $( document ).on("click", ".recent_loads", function(){
     $("#clear_loads").show();
      $(".dytitle_ch").html("Recently Viewed Loads");
      $(".dytitle_head").attr("data-tip"," The list of recently viewed loads");

       searchtable.ajax.url(LoadBoard.API+"trucker/view-list").load();
       searchtable.columns([9]).visible(true);
   });

     $( document ).on("click", ".wish_loads", function(){
     $("#clear_loads").hide();
      $(".dytitle_ch").html("Wish List");
      $(".dytitle_head").attr("data-tip"," The list of Wished loads");

       searchtable.ajax.url(LoadBoard.API+"trucker/wish-list").load();
       searchtable.columns([9]).visible(true);
   });



   //Confirm Popup Click Event
   $( document ).on("click", ".search_modals", function(){
    $(".preloader").show();
    $("#load").hide();

    var url_value = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
    var viewlist=false;
    if(url_value!=undefined && url_value!='undefined' && url_value=='search-loads'){
      viewlist=true;
    }

     $.ajax({
          type: 'post',
          url: LoadBoard.API+'broker/get-load',
          dataType: "json",
          async:false,
          contentType: "application/json",
          headers: {
              Authorization: "Bearer "+LoadBoard.token
            },
          data: JSON.stringify({ 
            "load_id":window.atob($(this).attr("data-load-id")),
            "user_type":LoadBoard.user_type,
            "user_id": LoadBoard.userid,
            "viewlist":viewlist
          }),
          success: function (result) {
           
              if(result.status==1){
                 $(".preloader").hide();
               
                  var orgsplit=result.data.origin.split(",");
                  var dessplit=result.data.destination.split(",");

                  var distance=distancecal(result.data.origin_lat,result.data.origin_lng,result.data.destination_lat,result.data.destination_lng);
                  $("#m_distance").html(distance);

                  $("#m_origin").html(orgsplit[0]+", "+orgsplit[1]);
                  $("#m_destination").html(dessplit[0]+", "+dessplit[1]);
                  $("#m_weight").html(result.data.weight);
                  $("#m_height").html(result.data.height);

                  $("#m_truck").html(result.data.truck_name);
                  $("#m_length").html(result.data.length);
                  $("#m_broker").html(result.data.business_name);
                  $("#m_loadid").html(result.data.load_id);
                  $("#m_price").html(result.data.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

                   //Pickup time and delivery time 
                  $(".timesearch").hide();
                  if(result.data.pickup_time!='' &&  result.data.delivery_time!=''){
                    $("#m_ptime").html(result.data.pickup_time);
                    $("#m_dtime").html(result.data.delivery_time);
                    $(".timesearch").show();

                  }


                  var pdate= result.data.pickup_date.split("-");
                  var pyear=pdate[0];
                  var pmonth=pdate[1];
                  var pdate=pdate[2];
                  var p_mthname=GetMonthName(pmonth);
                  var pdata=p_mthname+" "+pdate+", "+pyear;
                  $("#m_pdate").html(pdata);

                  var ddate= result.data.delivery_date.split("-");
                  var dyear=ddate[0];
                  var dmonth=ddate[1];
                  var ddate=ddate[2];
                  var d_mthname=GetMonthName(pmonth);
                  var ddata=d_mthname+" "+ddate+", "+dyear;
                  $("#m_ddate").html(ddata);
                  $("#search_lid").val(result.data.id);
                  $("#search_bid").val(result.data.broker_id);

                  var created_date = result.data.created_date.split("-");
                  var cdyear = created_date[0];
                  var cdmonth = created_date[1];
                  var cddate = created_date[2];
                  var cd_mthname = GetMonthName(pmonth);
                  var cddata = cd_mthname + " " + cddate + ", " + cdyear;
                  $("#created_date").html(cddata);

                        
              /*  var org=result.data.origin_lat+","+" "+result.data.destination_lng;
                  var des=result.data.destination_lat+","+" "+result.data.origin_lng;*/
                  var org=result.data.origin;
                  var des=result.data.destination;
                  var orglat=result.data.origin_lat+","+result.data.origin_lng;
                  var deslat=result.data.destination_lat+","+result.data.destination_lng;

                  var framesrc=LoadBoard.APP+"map?org="+window.btoa(orglat)+"&des="+window.btoa(deslat);
                  var iframe='<iframe src="'+framesrc+'" style="width:100%;min-height:250px;"   scrolling="no"  frameBorder="0"  allowfullscreen></iframe>';
                  $(".mapview").html(iframe);
                  
                  var dybutton="";
                   if(result.data.status==0 || result.data.status==5 || (result.data.status==1 && result.data.approve_status==1)){

                    // if(result.data.status==0 || result.data.status==5 || (result.data.approve_status!=1 && result.data.status!=1) && result.data.approve_status!=2 && result.data.status!=2 ){
                    dybutton='<button type="button" class="btn btn-primary" data-dismiss="modal" >Close</button>  <button type="button" class="btn btn-primary confirm_click" data-dismiss="modal" data-toggle="modal" data-target="#load" >Confirm</button>';
                   }
                   $(".search_con_update").html(dybutton);
                  
                  


                  $("#confirm").modal("show");
              }else if(result.status==2){
                window.location.href=LoadBoard.APP+"logout";
              }

          }
        });


   
  });

    $(document).ready(function(){
        $(".dropdowhjghjn").click(function(){
            $(this).find(".dropdown-menu").slideToggle("fast");
        });
        Getsearch();     
    });


$(document).on("click", ".restore_data", function() {
      $.ajax({
          type: 'post',
          url: LoadBoard.API+'trucker/restore-search-data',
          dataType: "json",
          async:false,
          contentType: "application/json",
          headers: {
              Authorization: "Bearer "+LoadBoard.token
            },
          data: JSON.stringify({ 
            "get_id":$(this).attr("data-get-id"),
            "operation":"resetdata",
            "user_id": LoadBoard.userid
          }),
          success: function (result) {
               if (result.status == 1) { 
                          
                  $("#autocomplete_search_orgin").val(result.data.origin);
                 // google.maps.event.trigger(autocompleteautocomplete, 'place_changed');
                  
                  //google.maps.event.addDomListener(window, 'load', initialize);
                  //originInAddress(result.data.origin)
                  $("#autocomplete_search_destin").val(result.data.destination);
                  $("#orgin_lng").val(result.data.orgin_lng);
                  $("#orgin_lat").val(result.data.orgin_lat);
                  $("#destination_lat").val(result.data.destination_lat);
                  $("#destination_lng").val(result.data.destination_lng);
                  $("#pickup_date").val(result.data.pickup_date);
                    if (result.data.weight != 0) {  
                        $("#weight").val(result.data.weight);
                    }else{
                        $("#weight").val('');
                    }
                    if(result.data.deadhead != 0){
                        $("#deadhead").val(result.data.deadhead);
                    }else{
                       $("#deadhead").val('');
                    }
                    if(result.data.des_deadhead != 0){
                        $("#des_deadhead").val(result.data.des_deadhead);
                    }else{
                       $("#des_deadhead").val('');
                    }
                    $('input.custom-control-input').prop('checked', false);
                    var array = result.data.truck_id.split(",");
                    for (i=0;i<array.length;i++){
                     let j=parseInt(array[i]);
                     $('input.custom-control-input[value="'+j+'"]').prop('checked', true)
                    }
                       //$("#search_loads").trigger("submit");
                       //$('#search_loads').trigger('submit');
                      document.getElementById('triggersub').click();
                      searchtable.columns([9]).visible(false);



                       //return false
               }else{
                   toastr.options = {
                      "progressBar": true,
                      "positionClass": "toast-top-full-width",
                      "timeOut": "2000",
                      "extendedTimeOut": "1000",
                   }
                   toastr.error(result.msg);
               } 
             }
        });

});

$("#save_search").click( function(){
    $("#save_search_confirm").modal("show");
});

  $(document).on("click", ".approve_close", function() {
      $("#search_name").val('');
      $("#search_name").css("border","1px solid rgba(0, 40, 100, 0.20 )");
      $("#search_name-error").hide();
        $("body").removeClass("modal-xscroll");
        $("#save_search_confirm").modal("hide");

    });

$(document).on("click", ".scancel", function() {
     $("#search_name").val('');
      $("#search_name").css("border","1px solid rgba(0, 40, 100, 0.20 )");
      $("#search_name-error").hide();
      $("body").removeClass("modal-xscroll");
      $("#save_search_confirm").modal("hide");
  });
//$(document).on("click", "#sconfirm", function() {
            jQuery.validator.addMethod("name_valid", function (input) {
                 var filter = /[\'^£$%&*0-9()}{@.#~?><>,|=_+¬-]/;
                  if (filter.test(input)) {
                      return false;
                  } else {
                      return true;
                  }
              });

             $("#valid_save_search").validate({
                rules: {
                  search_name: {
                    required: true,
                    name_valid:true,
                    maxlength:15
                   }
                },
                messages: {
                  search_name:{
                    required: "Please enter the Name",
                    name_valid: "Please enter a valid Name"
                  }
                },
                submitHandler: function() {
            
                  var truck_types = [];
          $.each($("input[name='truck_type[]']:checked"), function(){            
              truck_types.push($(this).val());
          });
          var truck_models=truck_types.join(", ");
          var trutype="";
            if($("input[name='truck_load_type']:checked").val()!=undefined || $("input[name='truck_load_type']:checked").val()!='undefined'){
                  trutype=$("input[name='truck_load_type']:checked").val();
            }
            var ttype="";
            if(trutype==undefined){
              ttype="";
            }
            else{
              ttype=trutype;
            }
               $.ajax({
                    type: 'post',
                    url: LoadBoard.API+'trucker/save_search',
                    dataType: "json",
                    async:false,
                    headers: {
                        Authorization: "Bearer "+LoadBoard.token
                      },
                    data: JSON.stringify({ 
                       "user_id": LoadBoard.userid,
                       "search_name" : $("#search_name").val(),            
                       "origin" : $("#autocomplete_search_orgin").val(),
                       "destination" : $("#autocomplete_search_destin").val(),
                       "pickup_date" : $("#pickup_date").val(),
                       "truck_load_type" : ttype,
                       "truck_type" : truck_models,
                       "weight" : $("#weight").val(),
                       "deadhead" : $("#deadhead").val(),
                        "des_deadhead" : $("#des_deadhead").val(),
                        "orgin_lng" :$("#orgin_lng").val(),
                        "orgin_lat" :$("#orgin_lat").val(),
                        "destination_lat" :$("#destination_lat").val(),
                        "destination_lng" :$("#destination_lng").val(),
                      }),
                     contentType: "application/json",
                    success: function (result) {
                      if (result.status == 1) {
                          $("#save_search_confirm").modal("hide");
                           toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                           }
                             toastr.success(result.msg);
                             $("#search_name").val("");
                            // Getsearch();
                              location.reload();
                              
                                    
                        }else{
                          if(result.msg=='You have only save five Search Criteria' || result.msg=='Please enter the origin' || result.msg=='Please enter the name' || result.msg=='Please enter a valid name' || result.msg=='This name already saved' ){
                             $("#search_name").css("border","1px solid red");
                             $("#search_name-error").html(result.msg).show();
                            }
              
                        }

                    }
                  });

                    
                }
             });



/*$(".sconfirm").click( function(){



            
           
  });*/

$(document).on("click", ".searchdel",function(){
 
   swal.fire({
                    title: "Confirmation!",
                    text: "Do you want to clear the save search?",
                    type: "success",
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
                      
                   $.ajax({
                    type: 'post',
                    url: LoadBoard.API + 'trucker/clear-save',
                    dataType: "json",
                    headers: {
                        Authorization: "Bearer " + LoadBoard.token
                    },
                    data: JSON.stringify({
                        "user_id": LoadBoard.userid,
                        "id": $(this).attr("data-get-id")
                    }),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.status == 1) {
                            toastr.options = {
                                "progressBar": true,
                                "positionClass": "toast-top-full-width",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                            }
                            toastr.success(result.msg);
                            Getsearch();
                           // searchtable.ajax.url(LoadBoard.API+"trucker/view-list").load();

                              
                        }
                    }
                })


                    }
                });
                 $("body").removeClass("swal2-height-auto");
});
  

$(document).on("click", "#wish_click",function(){
      var lid=window.atob($(this).attr("data-load-id"));
      var wished=0;
      if($(".wishlist_"+lid).hasClass("wish")){
        wished=0;
      }else if($(".wishlist_"+lid).hasClass("not_wish")){
        wished=1;
      }
   $.ajax({
          type: 'post',
          url: LoadBoard.API+'trucker/wish-list-data',
          dataType: "json",
          async:false,
          contentType: "application/json",
          headers: {
              Authorization: "Bearer "+LoadBoard.token
            },
          data: JSON.stringify({ 
            "load_id":window.atob($(this).attr("data-load-id")),
            "wish_status":wished,
            "user_id": LoadBoard.userid
          }),
          success: function (result) {
             if(result.status==1){
                if($(".wishlist_"+lid).hasClass("not_wish")){
                  $(".wishlist_"+lid).removeClass("not_wish");
                  $(".wishlist_"+lid).addClass("wish");
                }else if($(".wishlist_"+lid).hasClass("wish")){
                  $(".wishlist_"+lid).removeClass("wish");
                  $(".wishlist_"+lid).addClass("not_wish");
                }
                 searchtable.ajax.reload();
            }else if(result.status==2){
              window.location.href=LoadBoard.APP+"logout";
            }



          }

   });

});

   //After Confirm Popup Click Event
   $(document).on("click", ".confirm_click",function(){
    //$(".confirm_click").on('click',function(e){
       $(".preloader").show();
      $("#confirm_click").attr("disabled", true);

      $(".load_origin").html($("#m_origin").html());
      $(".load_destination").html($("#m_destination").html());
        $.ajax({
          type: 'post',
          headers: {
            Authorization: "Bearer "+LoadBoard.token
          },
          contentType: "application/json",
          url: LoadBoard.API+'trucker/confirm-load',
          dataType: "json",
          data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
              "broker_id":$("#search_bid").val(),
              "load_id":$("#search_lid").val(),
              "user_type":LoadBoard.user_type
            }),
          success: function (result) {
            if(result.status==1){
               $(".preloader").hide();
              $("#confirm_click").attr("disabled", false);
              $("#confirm").modal("hide");
             // searchtable.ajax.reload();
                searchtable.ajax.url(LoadBoard.API+"trucker/search-loads").load();
              $("#load").modal("show");
            }else if(result.status==0){
               $(".preloader").hide();
              toastr.error(result.msg);
              return false;
            }else if(result.status==2){
                  window.location.href = LoadBoard.APP+'logout';                   
             }
         
          }
        });
    });

//Get Month Name
function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
}

function Getsearch(){
         $.ajax({
          type: 'post',
          url: LoadBoard.API+'trucker/get-search',
          dataType: "json",
          async:false,
          headers: {
              Authorization: "Bearer "+LoadBoard.token
            },
          data: JSON.stringify({ 
             "user_id": LoadBoard.userid,
             "operation":"get_data"
            }),
           contentType: "application/json",
            success: function (result) {
              if (result.status == 1) {

                          var list='';
                            if(result.data.length!=0){
                                $("#menu").empty("");

                              for (var i =0; i<result.data.length; i++) {
                                list+= '<a style="width:80%; float:left;" href="javascript:void(0);" class="restore_data dropdown-item" data-get-id="'+result.data[i]['id']+'">'+result.data[i]['search_name']+'</a><i class="fa fa-trash float-right btncursor searchdel" style="width:20%;margin-top:5px;" data-get-id="'+result.data[i]['id']+'" ></i>';
                                }
                                $("#menu").append(list);
                            }
                            
                          }
        
         }
       });  

}


  });



  



