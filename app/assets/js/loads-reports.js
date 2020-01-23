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
          componentRestrictions: {'country': ['us', 'ca']}

 };
 //regions
  var input_orgin = document.getElementById('autocomplete_search_orgin');
  var autocomplete_search_orgin = new google.maps.places.Autocomplete(input_orgin,options);
  autocomplete_search_orgin.addListener('place_changed', function () {
    var place_orgin = autocomplete_search_orgin.getPlace();
    $('#orgin_lat').val(place_orgin.geometry['location'].lat());
    $('#orgin_lng').val(place_orgin.geometry['location'].lng());
  });
}
google.maps.event.addDomListener(window, 'load', initialize2);
function initialize2() {
  var options2 = {
  types: ['(regions)'],
   componentRestrictions: {'country': ['us', 'ca']}

 };
  var input_desting = document.getElementById('autocomplete_search_destin');
  var autocomplete_search_destin = new google.maps.places.Autocomplete(input_desting,options2);
  autocomplete_search_destin.addListener('place_changed', function () {
    var place_detsin = autocomplete_search_destin.getPlace();
    $('#destination_lat').val(place_detsin.geometry['location'].lat());
    $('#destination_lng').val(place_detsin.geometry['location'].lng());
  });

}
var searchdata="";
var searchtable;
var trucker_searchtable;

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

var searchurl="";
$(document).ready(function(){

 $(".btn-group").addClass("kumar");

$(".select2").select2({
 placeholder: "Search by Load-Id",
 width: '250px',
 ajax: {
 url: LoadBoard.API+"broker/loads-data",
 dataType: 'json',
 //delay: 250,
 data: function (params) {
 return {
           q: params.term, // search term
           page: params.page,
           user_id: LoadBoard.userid
       };
   },
   processResults: function (data, params) {
    params.page = params.page || 1;
    console.log(params.page)
      return {
            results: $.map(data.items, function(obj) {
              return { id: obj.id, text: obj.text };
            })
          };
   },
   cache: false
 },
 // escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
 minimumInputLength: 0,
 //templateResult: formatRepo,
 //templateSelection: formatRepoSelection
 });
 
/* function formatRepo (repo) {
 if (repo.loading) return repo.text;
 return repo.text;
 }
 
 function formatRepoSelection (repo) {
 return  repo.text;
 }*/


   equipment();
 $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
         // noneSelectedText: 'Please Select At Least One'
        });
  $('#load_status').multiselect({
          includeSelectAllOption: true,
          //noneSelectedText: 'Please Select At Least One'
        });
  $('#trucker_load_status').multiselect({
          includeSelectAllOption: true,
          //noneSelectedText: 'Please Select At Least One'
        });

$('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });


var seracrtop=getUrlParameter('id');
//console.log(seracrtop)
if(seracrtop!=undefined && seracrtop!='undefined'){
  $("#autocomplete_search_orgin").val(seracrtop .replace(/\+/g, ' '));

}

$("#from_date").prop('disabled', true);
$("#to_date").prop('disabled', true);

$("#trucker_from_date").prop('disabled', true);
$("#trucker_to_date").prop('disabled', true);

$("#datetype").change(function() {
  console.log($(this).onsearch);
  if($(this).val()=='created_date' || $(this).val()=='pickup_date'  || $(this).val()=='delivery_date'  ){
    $("#from_date").prop('disabled', false);
    $("#to_date").prop('disabled', false);
  }else{
    $("#from_date").prop('disabled', true);
    $("#to_date").prop('disabled', true);
  }
 });

$("#trucker_datetype").change(function() {
  console.log($(this).onsearch);
  if($(this).val()=='created_date' || $(this).val()=='pickup_date'  || $(this).val()=='delivery_date'  ){
    $("#trucker_from_date").prop('disabled', false);
    $("#trucker_to_date").prop('disabled', false);
  }else{
    $("#trucker_from_date").prop('disabled', true);
    $("#trucker_to_date").prop('disabled', true);
  }
 });


$("#trucker_from_date").datepicker({
        todayHighlight:'TRUE',
        //startDate: '-0d',
        autoclose: true,
               onSelect: function() {
          return $(this).trigger('change');
        }

    });


$("#trucker_to_date").datepicker({
        todayHighlight:'TRUE',
        //startDate: '-0d',
        autoclose: true,
                onSelect: function() {
          return $(this).trigger('change');
        }

    });
$("#from_date").datepicker({
        todayHighlight:'TRUE',
        //startDate: '-0d',
        autoclose: true,
               onSelect: function() {
          return $(this).trigger('change');
        }

    });


$("#to_date").datepicker({
        todayHighlight:'TRUE',
        //startDate: '-0d',
        autoclose: true,
                onSelect: function() {
          return $(this).trigger('change');
        }

    });

    //Weight validation
     $("#weight,#height,#length,#price").keypress(function(e){
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
    $('#weight,#height,#length,#price').keypress(function(e){ 
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
 

      searchtable=$('#viewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+"broker/loads-reports",
           "data": function(data){
              data.token = LoadBoard.token;
              data.origin = $("#autocomplete_search_orgin").val();
              data.destination = $("#autocomplete_search_destin").val();
              data.loadid = $("#loadid").val();
              data.from_date = $("#from_date").val();
              data.to_date = $("#to_date").val();
              data.datetype = $("#datetype").val();
              data.equipment = $("#multiple-checkboxes").val();
              data.loadstatus = $("#load_status").val();
              data.loadweight = $("#weight").val();
              data.loadlength = $("#length").val();
              data.loadheight = $("#height").val();
              data.price = $("#price").val();

              data.trucker_loadid = $(".select2").val();
              data.trucker_from_date = $("#trucker_from_date").val();
              data.trucker_to_date = $("#trucker_to_date").val();
              data.trucker_datetype = $("#trucker_datetype").val();
              data.trucker_loadstatus = $("#trucker_load_status").val();
              data.trucker_name=$("#trucker_name").val();
              data.business_name=$("#business_name").val();
              data.usdot=$("#usdot").val();
            },
            "dataFilter": function(data) {
              //console.log(data);
              var data = JSON.parse(data);
              var rowCount =data.iTotalDisplayRecords;
              //alert(rowCount);
              if(rowCount ==0){
              $("#export").hide();
              $("#viewloads_info").hide();
              } else {
              $("#export").show();
               $("#viewloads_info").show();
              }
              $("#total_count").val(rowCount)
              return JSON.stringify(data);
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
              "order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "pickup_date"},
                {"data": "delivery_date"},
                {"data": "status"},
                {"data": "trucker_name"},
                {"data": "created_date"},
                {"data": "truck_name"},
                {"data": "price" },
                {"data": "weight"},
                {"data": "length"},
                {"data": "height"}
            ],
    //  dom: 'Bfrtip',

    columnDefs: [
      {
        targets: 1,
        render: function (data,type,row) {
          var orgt=row.origin.split(",");
          return orgt[0]+", "+orgt[1];
        }
      },
      {
        targets: 2,
        render: function (data,type,row) {
          var dest=row.destination.split(",");
          return dest[0]+", "+dest[1];
        }
      },
      {
        targets: 0,
        render: function (data,type,row) {
          return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

        }
      },
      {
        targets: 9,
        render: function (data,type,row) {
        return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
      {
        targets: 6,
        bSortable:false,
        render: function (data,type,row) {
          if(row.trucker_name!=undefined){
            var mystring = row.trucker_name.toUpperCase();
            if(mystring.length > 15){
                return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" ><span class="tool_string stringtooltip" data-tip="'+mystring+'" tabindex="1" >'+mystring.substring(0,15)+'...</span></a>';
             } else {
               return '<a class="search_modals" href="javascript:void(0)"  onclick="trukerpopup(\'' + window.btoa(row.trucker_id) + '\')" >'+mystring+'</a>';
             }   
              }else{
                return '';
              }
                }
      },
      {
       targets: 5,
        bSortable:false,

       render: function (data,type,row) {
       
        if(row.searchtype==undefined){
          if(row.status==1 && row.approve_status==1){
               return '<span class="status-icon bg-success "></span>Open for Trucker';
             } if (row.status==0) {
                return '<span class="status-icon bg-success "></span>Open for Trucker';
              } else if(row.status==1) {
                return '<span class="status-icon bg-info"></span>Awaiting for your Approval';
              } else if(row.status==2){
                return '<span class="status-icon bg-success"></span>Load Approved for Pickup';
              }else if(row.status==3){
                return '<span class="status-icon bg-info"></span>Load Picked by Trucker';
              } else if(row.status==4){
                return '<span class="status-icon bg-success"></span>Load Delivered by Trucker';
              }  else if(row.status==5){
                return '<span class="status-icon bg-success"></span>Re-opened for Trucker';
              }  else{
                return '';
              }  
            }else{
              if(row.load_status==1){
                return '<span class="status-icon bg-info"></span>Confirmed';
              }else if(row.load_status==2){
                  return '<span class="status-icon bg-warning "></span>Approved';
              }else if(row.load_status==3){
                   return '<span class="status-icon  bg-primary "></span>Picked';
              }else if(row.load_status==4){
                   return '<span class="status-icon bg-success "></span>Delivered';
              }else{
                return '';
              }
            }
                    
          }
      },
     
    ],
 

        }); 



      
     searchtable.columns( [8] ).visible( false );
     searchtable.columns( [9] ).visible( false );
     searchtable.columns( [10] ).visible( false );
     searchtable.columns( [11] ).visible( false );
     searchtable.columns( [12] ).visible( false );
     $('#search_loads').on('submit', function (e) {
          e.preventDefault();
          var from_date=$("#from_date").val();
          var to_date=$("#to_date").val();
          var commondata="";
          if($("#price").val()!=''){
            commondata += searchtable.columns( [9] ).visible( true );
          }if($("#weight").val()!=''){
             commondata += searchtable.columns( [10] ).visible( true );
          }if($("#length").val()!=''){
             commondata += searchtable.columns( [11] ).visible( true );
          }if($("#height").val()!=''){
             commondata += searchtable.columns( [12] ).visible( true );
          }if($("#multiple-checkboxes").val()!=''){
             commondata += searchtable.columns( [8] ).visible( true );
          }
          $(".datecheck").hide();  
          $("#from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
          $("#to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");     
          if(from_date!='' && to_date!=''){
               if(from_date > to_date){
                  $(".datecheck").show();
                  $("#from_date").css("border","1px solid red");
                  $("#to_date").css("border","1px solid red");
                  return false;
             }else{
                $("#from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
                $("#to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");   
                $(".datecheck").hide();            
                searchtable.ajax.url(LoadBoard.API+"broker/loads-reports").load();
              }  
          }else{
            $("#from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
            $("#to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");   
            $(".datecheck").hide();            
            searchtable.ajax.url(LoadBoard.API+"broker/loads-reports").load();
          }
                  
          
      });

     searchtable.columns( [8] ).visible( false );
     searchtable.columns( [9] ).visible( false );
     searchtable.columns( [10] ).visible( false );
     searchtable.columns( [11] ).visible( false );
     searchtable.columns( [12] ).visible( false );
     $('#trucker_search_loads').on('submit', function (e) {
          e.preventDefault();
          var from_date=$("#trucker_from_date").val();
          var to_date=$("#trucker_to_date").val();
          var commondata="";
          if($("#price").val()!=''){
            commondata += searchtable.columns( [9] ).visible( true );
          }if($("#weight").val()!=''){
             commondata += searchtable.columns( [10] ).visible( true );
          }if($("#length").val()!=''){
             commondata += searchtable.columns( [11] ).visible( true );
          }if($("#height").val()!=''){
             commondata += searchtable.columns( [12] ).visible( true );
          }if($("#multiple-checkboxes").val()!=''){
             commondata += searchtable.columns( [8] ).visible( true );
          }
          $(".trucker_datecheck").hide();  
          $("#trucker_from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
          $("#trucker_to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");     
          if(from_date!='' && to_date!=''){
               if(from_date > to_date){
                  $(".trucker_datecheck").show();
                  $("#trucker_from_date").css("border","1px solid red");
                  $("#trucker_to_date").css("border","1px solid red");
                  return false;
             }else{
                $("#trucker_from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
                $("#trucker_to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");   
                $(".trucker_datecheck").hide();            
                searchtable.ajax.url(LoadBoard.API+"broker/trucker-reports").load();

              }  
          }else{
            $("#trucker_from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
            $("#trucker_to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");   
            $(".trucker_datecheck").hide();            
            searchtable.ajax.url(LoadBoard.API+"broker/trucker-reports").load();
          }
                  
          
      });
     
    //Clear Search
    $("#clear_search").on('click',function(e){
     $('#search_loads')[0].reset();

      $("#autocomplete_search_orgin").val("");
      $("#autocomplete_search_destin").val("");
      $("#load_status").val("")
      $("#multiple-checkboxes").val("");
      $(".datecheck").hide();  
      $("#from_date").val("");
      $("#to_date").val("");

      $("#price").val("");
      $("#weight").val("");
      $("#length").val("");
      $("#height").val("");

      $("#from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
      $("#to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");  
      searchtable.ajax.reload();
      searchtable.columns( [8] ).visible( false );
      searchtable.columns( [9] ).visible( false );
      searchtable.columns( [10] ).visible( false );
      searchtable.columns( [11] ).visible( false );
      searchtable.columns( [12] ).visible( false ); 
      //console.log("TEST")
      $(".multiselect-selected-text").html("");
      $(".multiselect-selected-text").html("None selected");

      

    });

    $("#trucker_clear_search").on('click',function(e){
      $('#trucker_search_loads')[0].reset();
      // $(".select2").val("");
      $(".select2").val("").trigger("change")
      $("#trucker_load_status").val("")
      $(".trucker_datecheck").hide();  
      $("#trucker_from_date").val("");
      $("#trucker_to_date").val("");

      $("#trucker_from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
      $("#trucker_to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");  
      searchtable.ajax.reload();
      searchtable.columns( [8] ).visible( false );
      searchtable.columns( [9] ).visible( false );
      searchtable.columns( [10] ).visible( false );
      searchtable.columns( [11] ).visible( false );
      searchtable.columns( [12] ).visible( false ); 

      $(".multiselect-selected-text").html("");
      $(".multiselect-selected-text").html("None selected");
      $(".select2-selection__rendered").html("");
      $(".select2-selection__rendered").html("Search by Load-Id").css("border","0px solid rgba(0, 40, 100, 0.20 )");
      //$(".select2-selection__rendered").empty();
    });



    //Get Month Name
    function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
    }

$("#tabsid").val("loads-reports");
$(document).on("click","#nav-home-tab",function(){
$('#trucker_clear_search').trigger('click');
 searchtable.ajax.url(LoadBoard.API+"broker/loads-reports").load();
  $("#tabsid").val("loads-reports");
  $(".dytitle ").html("Loads List");
});

$(document).on("click","#nav-profile-tab",function(){
 $('#clear_search').trigger('click');
   searchtable.ajax.url(LoadBoard.API+"broker/trucker-reports").load();
   $("#tabsid").val("trucker-reports");
  $(".dytitle ").html("Trucker Loads");

  });







// Export Excel Load Report starts here
$(".export_csv").on('click',function(){
  var export_page = $("input[name='export_page']:checked").val();
  var user_id = LoadBoard.userid;
  var token = LoadBoard.token;

  var tabsid = $("#tabsid").val();

  if($("#loadid").val()!=""){
    var loadid = $("#loadid").val();
  }
  if($("#autocomplete_search_orgin").val()!=""){
    var autocomplete_search_orgin = $("#autocomplete_search_orgin").val();
  }
  if($("#autocomplete_search_destin").val()!=""){
    var autocomplete_search_destin = $("#autocomplete_search_destin").val();
  }
  if($("#price").val()!=""){
    var price = $("#price").val();
  }
  if($("#weight").val()!=""){
    var weight = $("#weight").val();
  }
  if($("#length").val()!=""){
    var length1 = $("#length").val();
  }
  if($("#height").val()!=""){
    var height = $("#height").val();
  }

  if($("#datetype").val()!=""){
    var datetype = $("#datetype").val();
  }
  if($("#from_date").val()!=""){
    var from_date = $("#from_date").val();
  }
  if($("#to_date").val()!=""){
    var to_date = $("#to_date").val();
  }

  if($("#trucker_datetype").val()!=""){
    var trucker_datetype = $("#trucker_datetype").val();
  }
  if($("#trucker_from_date").val()!=""){
    var trucker_from_date = $("#trucker_from_date").val();
  }
  if($("#trucker_to_date").val()!=""){
    var trucker_to_date = $("#trucker_to_date").val();
  }
  if($("#trucker_name").val()!=""){
    var trucker_name = $("#trucker_name").val();
  }
  if($("#business_name").val()!=""){
    var business_name = $("#business_name").val();
  }
  if($("#usdot").val()!=""){
    var usdot = $("#usdot").val();
  }
  if($("#trucker_load_status").val()!=""){
    var trucker_load_status = $("#trucker_load_status").val();
  }
  if($(".select2").val()!=""){
      var trucker_load_id = $(".select2").val();
  }
  //alert(trucker_load_id);

  if($("#multiple-checkboxes").val()!=""){
    var equipment = $("#multiple-checkboxes").val();
  }
  if($("#load_status").val()!=""){
    var load_status = $("#load_status").val();
  }
  var total_count = $("#total_count").val();
  //alert(export_page);
  if(export_page=="1"){
    var pageid = $("li.active > .page-link").attr("data-dt-idx");
    //alert(pageid);
    var draw = pageid;
    for(var i=1; i<=total_count; i++){
      if(draw==i && i==1){
        var start = 0;
      }
      else if(draw==i && i>1){
        var start = ((i-1) * 10);
      }
    }
      var length = '10';
      if(tabsid=="loads-reports"){
        var href=LoadBoard.API+"broker/download-excel-current-loads-report?token="+token+"&user_id="+user_id+"&start="+start+"&length="+length+"&loadid="+loadid+"&origin="+autocomplete_search_orgin+"&destination="+autocomplete_search_destin+"&weight="+weight+"&height="+height+"&length1="+length1+"&price="+price+"&equipment="+equipment+"&load_status="+load_status+"&datetype="+datetype+"&from_date="+from_date+"&to_date="+to_date;;
        window.location.href=href;
      } else if(tabsid=="trucker-reports"){
        var href=LoadBoard.API+"broker/download-excel-current-truckerloads-reports?token="+token+"&length=all&user_id="+user_id+"&loadid="+loadid+"&trucker_datetype="+trucker_datetype+"&trucker_from_date="+trucker_from_date+"&trucker_to_date="+trucker_to_date+"&trucker_name="+trucker_name+"&business_name="+business_name+"&usdot="+usdot+"&trucker_load_status="+trucker_load_status+"&trucker_load_id="+trucker_load_id;
        window.location.href=href;
      }
    }
    else if(export_page=="2"){
      if(tabsid=="loads-reports"){
        var href=LoadBoard.API+"broker/download-excel-all-loads-reports?token="+token+"&length=all&user_id="+user_id+"&loadid="+loadid+"&origin="+autocomplete_search_orgin+"&destination="+autocomplete_search_destin+"&weight="+weight+"&height="+height+"&length1="+length1+"&price="+price+"&equipment="+equipment+"&load_status="+load_status+"&datetype="+datetype+"&from_date="+from_date+"&to_date="+to_date;
        window.location.href=href;
      } else if(tabsid=="trucker-reports"){
        var href=LoadBoard.API+"broker/download-excel-all-truckerloads-reports?token="+token+"&length=all&user_id="+user_id+"&loadid="+loadid+"&trucker_datetype="+trucker_datetype+"&trucker_from_date="+trucker_from_date+"&trucker_to_date="+trucker_to_date+"&trucker_name="+trucker_name+"&business_name="+business_name+"&usdot="+usdot+"&trucker_load_status="+trucker_load_status+"&trucker_load_id="+trucker_load_id;
        window.location.href=href;
      }
    } 
});
// Export Excel Load Report ends here


});
  
function equipment(){
  $.ajax({
    type:'POST',
    url:LoadBoard.API+'trucker/equipment-list',
    async:false,
    dataType: 'json',
    headers: {
       Authorization: "Bearer "+LoadBoard.token
    },
    data: JSON.stringify({ 
    "operation":"equipment", 
    "user_id":LoadBoard.userid            
    }),
    contentType: "application/json",
    //data:{operation:"equipment" },
    success:function(result){
      var selectoption='<option value="">Please select equipment</option>';
      for(i=0;i<result.data.length;i++){
          selectoption ='<option value="'+result.data[i]["id"]+'">'+result.data[i]["truck_name"]+'</option>';
           $("#multiple-checkboxes").append(selectoption);
      } 
     
    }
  });
}


