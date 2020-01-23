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

 $(".btn-group").addClass("kumar");


   equipment();
 $('#multiple-checkboxes').multiselect({
          includeSelectAllOption: true,
         // noneSelectedText: 'Please Select At Least One'
        });
  $('#load_status').multiselect({
          includeSelectAllOption: true,
          //noneSelectedText: 'Please Select At Least One'
        });
$('th').on("click", function (event) {
        if($(event.target).is("div"))
            event.stopImmediatePropagation();
    });


var seracrtop=getUrlParameter('id');
if(seracrtop!=undefined && seracrtop!='undefined'){
  $("#autocomplete_search_orgin").val(seracrtop .replace(/\+/g, ' '));

}

$("#from_date").prop('disabled', true);
$("#to_date").prop('disabled', true);

$("#datetype").change(function() {
  if($(this).val()=='created_date' || $(this).val()=='pickup_date'  || $(this).val()=='delivery_date'  ){
    $("#from_date").prop('disabled', false);
    $("#to_date").prop('disabled', false);
  }else{
    $("#from_date").prop('disabled', true);
    $("#to_date").prop('disabled', true);
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
    
    //var viewloads_table = $('#viewloads').DataTable();
    
      searchtable=$('#viewloads').DataTable({
          language: { search: "",searchPlaceholder: "Search for...","zeroRecords": "No relevant information available", "sInfo": " _START_ - _END_ of _TOTAL_ ", "infoFiltered": ""},
          dom: 'Bfrtip',
          "ajax": {
            url: LoadBoard.API+"trucker/loads-reports",
            type:"post",
            headers: {
                 Authorization: "Bearer "+LoadBoard.token
               },
            contentType: "application/json",
           "data": function(data){
            /*  data.token = LoadBoard.token;*/
             
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
              data.user_id =LoadBoard.userid
              return   JSON.stringify(data);
            },
   
            "dataFilter": function(data) {
      
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
        targets: 8,
        render: function (data,type,row) {
      return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");


                }
      },
      {
       targets: 5,

       render: function (data,type,row) {
             if(row.load_status==1 && row.cancel_status==0 && row.denied_status==0) {
                return '<span class="status-icon bg-info"></span>Awaiting Approval';
              } else if(row.load_status==2 && row.cancel_status==0 && row.denied_status==0){
                return '<span class="status-icon bg-success"></span>Upcoming';
              }else if(row.load_status==3 && row.cancel_status==0 && row.denied_status==0){
                return '<span class="status-icon bg-info"></span>Picked';
              } else if(row.load_status==4 && row.cancel_status==0 && row.denied_status==0) {
                return '<span class="status-icon bg-success"></span>Delivered';
              } else if(row.load_status==1 && row.cancel_status==1 || row.cancel_status==2  && row.denied_status==0 ) {
                return '<span class="status-icon bg-danger"></span>Cancelled';
              }else if(row.load_status==2 && row.cancel_status==1 || row.cancel_status==2  && row.denied_status==0) {
                return '<span class="status-icon bg-danger"></span>Cancelled';
              } else if(row.load_status==1 && row.cancel_status==0  && row.denied_status==1) {
                return '<span class="status-icon bg-warning"></span>Denied';
              }   else{
                return '';
              }          
          }
      },
     
    ],
  }); 

     //var length1 = searchtable.page.info().recordsTotal;
     //alert(length1)
     searchtable.columns( [8] ).visible( false );
     searchtable.columns( [9] ).visible( false );
     searchtable.columns( [10] ).visible( false );
     searchtable.columns( [11] ).visible( false );
     $('#search_loads').on('submit', function (e) {
          e.preventDefault();
          var from_date=$("#from_date").val();
          var to_date=$("#to_date").val();
          var commondata="";
          if($("#price").val()!=''){
            commondata += searchtable.columns( [8] ).visible( true );
          }if($("#weight").val()!=''){
             commondata += searchtable.columns( [9] ).visible( true );
          }if($("#length").val()!=''){
             commondata += searchtable.columns( [10] ).visible( true );
          }if($("#height").val()!=''){
             commondata += searchtable.columns( [11] ).visible( true );
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
                searchtable.ajax.reload();
              }  
          }else{
            $("#from_date").css("border","  1px solid rgba(0, 40, 100, 0.20 )");
            $("#to_date").css("border"," 1px solid rgba(0, 40, 100, 0.20 )");   
            $(".datecheck").hide();            
            searchtable.ajax.reload();
          }
                  
          
      });
     
    //Clear Search
    $("#clear_search").on('click',function(e){
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
      $(".multiselect-selected-text").html("");
      $(".multiselect-selected-text").html("None selected");
    });


// Export Excel Load Report starts here
/*
//var total_count = delivered_Total_Count;
//if(total_count!=0){
*/

/*
$.ajax({
  type: 'post',
    url: LoadBoard.API+'broker/add-load',
    dataType: "json",
    data: "user_id="+LoadBoard.userid+"&token="+LoadBoard.token,
    success: function (result) {
        if(result.status==1){
          //var total_count=result.total_count;
          var total_count=1000;
        }
    }
})
*/

$(".export_csv").on('click',function(){
  var export_page = $("input[name='export_page']:checked").val();
  var user_id = LoadBoard.userid;
  var token = LoadBoard.token;

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
  if($("#datetype").val()!=""){
    var datetype = $("#datetype").val();
  }
  if($("#from_date").val()!=""){
    var from_date = $("#from_date").val();
  }
  if($("#to_date").val()!=""){
    var to_date = $("#to_date").val();
  }
  if($("#multiple-checkboxes").val()!=""){
    var equipment = $("#multiple-checkboxes").val();
  }
  if($("#load_status").val()!=""){
    var load_status = $("#load_status").val();
  }
  var total_count = $("#total_count").val();
  //alert(total_count);
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
      var href=LoadBoard.API+"trucker/download-excel-current-loads-report?token="+token+"&user_id="+user_id+"&start="+start+"&length="+length+"&loadid="+loadid+"&origin="+autocomplete_search_orgin+"&destination="+autocomplete_search_destin+"&weight="+weight+"&height="+height+"&length1="+length1+"&price="+price+"&equipment="+equipment+"&load_status="+load_status+"&datetype="+datetype+"&from_date="+from_date+"&to_date="+to_date;;
      window.location.href=href;
    }
    else if(export_page=="2"){
      var href=LoadBoard.API+"trucker/download-excel-all-loads-reports?token="+token+"&length=all&user_id="+user_id+"&loadid="+loadid+"&origin="+autocomplete_search_orgin+"&destination="+autocomplete_search_destin+"&weight="+weight+"&height="+height+"&length1="+length1+"&price="+price+"&equipment="+equipment+"&load_status="+load_status+"&datetype="+datetype+"&from_date="+from_date+"&to_date="+to_date;
      window.location.href=href;
    } 
});
// Export Excel Load Report ends here



//Get Month Name
function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
}




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
   // data:{operation:"equipment" },
    success:function(result){
      var selectoption='<option value="">Please select equipment</option>';
      for(i=0;i<result.data.length;i++){
          selectoption ='<option value="'+result.data[i]["id"]+'">'+result.data[i]["truck_name"]+'</option>';
           $("#multiple-checkboxes").append(selectoption);
      } 
     
    }
  });
}


