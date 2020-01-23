<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();

$Global->admin_header("SimpleTLB - Load List");

?>
<style type="text/css">
  .control-label{
    min-width: 108px;
  }
  #pickup_date,#delivery_date{
    width: 158px;
  }
</style>
    <div class="page-wrapper">
            <div class="container-fluid pt-30">
                      <!-- Title -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Loads Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Loads Management</span></a></li>
            <li class="active"><span>Loads List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
        <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default card-view">
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Search</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body">
                      <form class="form-inline" id="loads_search" data-toggle="validator" role="form">
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15"  for="email_inline">Origin:</label>
                            <input type="text" class="form-control" id="autocomplete_search_orgin" placeholder="">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15"  for="email_inline">Destination:</label>
                            <input type="text" class="form-control" id="autocomplete_search_destin" placeholder="">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15"  for="email_inline">Pickup Date:</label>
                            <div class="input-group date">
                                <input type="text" class="form-control"  id="pickup_date">
                                <span class="input-group-addon">
                                  <span class="fa fa-calendar"></span>
                                </span>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15"  for="email_inline">Delivery Date:</label>
                            <div class="input-group date" >
                                <input type="text" class="form-control" id="delivery_date">
                                <span class="input-group-addon">
                                  <span class="fa fa-calendar"></span>
                                </span>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15"  for="email_inline">LoadId:</label>
                            <input type="text" class="form-control" id="loadid">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="email_inline">Equipment:</label>
                          <select class="selectpicker" id="equipment" title="Select equipment" multiple data-style="form-control btn-default btn-outline">
                            <?php 
                            $check=$Global->db->prepare("SELECT id,truck_name FROM truck_type WHERE status=:status");
                            $check->execute(array("status"=>1));
                            $rowchk=$check->fetchAll(PDO::FETCH_ASSOC);
                            if(!empty($rowchk)){
                              foreach ($rowchk as $key => $value) {
                                  echo '<option value="'.$value['id'].'">'.$value['truck_name'].'</option>';
                              }
                            }
                            ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="pwd_inline">Price:</label>
                            <input type="text" class="form-control" id="price">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="email_inline">Status:</label>
                         <select class="selectpicker" id="load_status" title="Select Status" multiple data-style="form-control btn-default btn-outline">
                           <option value="0">Open</option>
                           <option value="1">Awaiting approval</option>
                           <option value="2">Load approved for pickup</option>
                           <option value="3">Load Picked by trucker</option>
                           <option value="4">Delivered</option>
                           <option value="5">Re-Opened</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="pwd_inline">Weight:</label>
                             <input type="text" class="form-control" id="weight">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="pwd_inline">Length:</label>
                            <input type="text" class="form-control" id="length">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label class="control-label mr-15" for="pwd_inline">Height:</label>
                            <input type="text" class="form-control" id="height">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                          </div>
                        </div>
                      </div>
                      <div align="center">
                          <br/>
                          <button type="submit" class="btn btn-success btn-anim"><i class="ti-search"></i><span class="btn-text">Search</span></button>
                          <button id="clear_search" type="reset" class="btn btn-default btn-anim"><i class="ti-eraser"></i><span class="btn-text">Clear</span></button>
                      </div>
                      </form>
                      


                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-heading">
                <!-- <div class="pull-left">
                  <h6 class="panel-title txt-dark">Broker Management</h6>
                </div> -->
                <div class="clearfix"></div>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                          <tr>
                            <th>Load-Id</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Pickup Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
          </div>
        </div>
     </div>
     <?php  
    $Global->admin_footer();
    ?>
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&libraries=places"></script>

<script type="text/javascript">
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
 $(document).ready(function(){
 $('#pickup_date').datetimepicker({
                 format: 'MM/DD/YYYY'
                 
           });
$('#delivery_date').datetimepicker({
                 format: 'MM/DD/YYYY'
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

        var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/loads-list?id='+ids,
            "data": function(data){
              data.origin = $("#autocomplete_search_orgin").val();
              data.destination = $("#autocomplete_search_destin").val();
              data.pickup_date = $("#pickup_date").val();
              data.delivery_date = $("#delivery_date").val();
              data.loadid = $("#loadid").val();
              data.equipment  = $("#equipment").val();
              data.price = $("#price").val();
              data.weight = $("#weight").val();
              data.loadlength = $("#length").val();
              data.height = $("#height").val();
              data.loadstatus  = $("#load_status").val();

           },
          },
            "dom": 'Bfrtip',
             "type": "POST",
              "processing": false,
              "serverSide": true,
               "columns": [
                {"data": "load_id"},
                  {"data": "origin"},
                  {"data": "destination"},
                  {"data": "pickup_date"},
                  {"data": "delivery_date"},
                  {"data": "status" },
                  {"data": "status" }
            ],
             buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             columnDefs: [{
                // puts a button in the last column
                targets: 5,
                bSortable:false,
                   render: function (a, b, data, d) {
                    var content="";
                    var label="";

                           
                      if(data.status==0){
                        content='Open';
                        label='label-success';
                      }else if(data.status==1){
                        content='Awaiting Approval';
                        label='label-info';
                      }else if(data.status==2){
                        content='Load approved for pickup';
                        label='label-primary';
                      }else if(data.status==3){
                        content='Load Picked by trucker';
                        label='label-warning';
                      }else if(data.status==4){
                        content='Delivered';
                        label='label-success';
                      }else if(data.status==5){
                        content='Re-Opened';
                        label='label-danger';
                      }


                      return '<span class="label '+label+' ">'+ content+'</span>';
                   }
            },
            {
                
                targets: 6,
                bSortable:false,
                   render: function (a, b, data, d) {
                  
                      if(data.status==0){
                        if(data.enable==1){
                            if(data.edit_per == 1){
                                return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.enable)+'" href="#" class="label label-danger status_changed">Disable </a>';
                                  }else{
                                  return '-';
                                  }      
                            }else{
                              if(data.edit_per == 1){
                                return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.enable)+'" href="#" class="label label-success status_changed">Enable</a>';
                                  }else{
                                  return '-';
                                  }  
                               
                            }
                       
                      }else{
                        return '-';
                      }


                      
                   }
            },
            {
              targets:0,
              width: "15%",
              render: function (a, b, data, d) {
                return data.load_id;
              }
            },
            {
              targets:0,
              width: "20%",
              render: function (a, b, data, d) {
                return data.origin;
              }
            },
            {
              targets:0,
              width: "20%",
              render: function (a, b, data, d) {
                return data.destination;
              }
            },
            {
              targets:0,
              width: "15%",
              render: function (a, b, data, d) {
                return data.pickup_date;
              }
            },
            {
              targets:0,
              width: "15%",
              render: function (a, b, data, d) {
                return data.delivery_date;
              }
            },
            ],
        }); 

  $('#loads_search').on('submit', function (e) {
      e.preventDefault();
      table.ajax.reload();
   });

   $("#clear_search").on('click',function(e){
          $("#loads_search")[0].reset();
          table.ajax.reload();
          $("#equipment ").selectpicker("refresh");
          $("#load_status").selectpicker("refresh");
          $("#equipment").selectpicker('deselectAll');
          $("#load_status").selectpicker('deselectAll');
          
    });
   $(document).on('click','.cancel',function(e){
        setTimeout(function(){ $("body").removeClass("stop-scrolling"); }, 500);
     });

   $(document).on('click','.status_changed',function(e){
          var id=$(this).attr("data-id");
          var status=$(this).attr("data-status");
      swal({   
            title: "Are you sure?",   
            text: "You are about to change the status of the Load?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#e6b034",   
            confirmButtonText: "Yes",   
            closeOnConfirm: false 
        }, function(confirm){  
          $.ajax({
            url: LoadBoard.API+'admin/broker-request',
            type: "POST",
            dataType: "json",
            data: "id="+window.atob(id)+"&action=load_status&status="+window.atob(status),
            success: function (res) {
               swal({   
                  title: "Updated!",   
                  type: "success", 
                  text: "Load status updated successfully",
                  confirmButtonColor: "#71aa68",   
                },function(confirm){
                  table.ajax.reload();
             });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error", "Broker status not updated", "error");   

            }
        }); 
        });
    return false;
    });


      });


  </script>
  