<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Broker List");
?>
<style type="text/css">
  .control-label{
    min-width: 108px;
  }
</style>
    <div class="page-wrapper">
            <div class="container-fluid pt-30">
                      <!-- Title -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Broker Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Broker Management</span></a></li>
            <li class="active"><span>Broker List</span></li>
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
                    <form class="form-inline" id="broker_search" data-toggle="validator" role="form">
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15"  for="email_inline">Name:</label>
                              <input type="text" class="form-control" id="name">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="pwd_inline">Business Name:</label>
                          <input type="text" class="form-control" id="business_name">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="pwd_inline">Email:</label>
                          <input type="email" class="form-control" id="email" data-error="Email address is invalid">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="pwd_inline">Phone:</label>
                               <input type="text" class="form-control" id="phone">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="email_inline">Country:</label>
                              <select class="selectpicker" id="country"  data-style="form-control btn-default btn-outline">
                                  </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="email_inline">State:</label>
                                <select class="selectpicker" id="state"   data-style="form-control btn-default btn-outline">
                                  </select>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label class="control-label mr-15" for="pwd_inline">City:</label>
                             <select class="selectpicker" id="city"  data-style="form-control btn-default btn-outline">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div align="center">
                          <br/>
                          <button type="submit" class="btn btn-success btn-anim"><i class="ti-search"></i><span class="btn-text">Search</span></button>
                          <button id="clear_search" type="reset" class="btn btn-default btn-anim"><i class="ti-eraser"></i><span class="btn-text">Clear</span></button>
                        </div>
                    </form>  
                    <!--
                      <form class="form-inline" id="broker_search" data-toggle="validator" role="form">
                    <div class="form-wrap">
                         <div class="form-group mr-15">
                          <label class="control-label mr-15"  for="email_inline">Name:</label>
                          <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group mr-15">
                          <label class="control-label mr-15" for="pwd_inline">Business Name:</label>
                          <input type="text" class="form-control" id="business_name">
                        </div>
                           <div class="form-group mr-15">
                          <label class="control-label mr-15" for="pwd_inline">Email:</label>
                          <input type="email" class="form-control" id="email" data-error="Email address is invalid">
                        </div>
                          <div class="form-group mr-15">
                          <label class="control-label mr-15" for="pwd_inline">Phone:</label>
                          <input type="text" class="form-control" id="phone">
                        </div>
                    </div>
                    <div class="form-wrap" style="margin-top: 20px;">
                          <div class="form-group mr-15">
                          <label class="control-label mr-15" for="email_inline">Country:</label>
                          <select class="selectpicker" id="country"  data-style="form-control btn-default btn-outline">
                              </select>

                        </div>
                         <div class="form-group mr-15">
                          <label class="control-label mr-15" for="email_inline">State:</label>
                            <select class="selectpicker" id="state"   data-style="form-control btn-default btn-outline">
                              </select>


                        </div>
                        <div class="form-group mr-15">
                          <label class="control-label mr-15" for="pwd_inline">City:</label>
                             <select class="selectpicker" id="city"  data-style="form-control btn-default btn-outline">
                              </select>
                        </div>
                          <label class="control-label mr-15" for="pwd_inline"></label>
                                                      <button id="clear_search" type="reset" class="btn btn-default btn-anim"><i class="ti-eraser"></i><span class="btn-text">Clear</span></button>

                        <button type="submit" class="btn btn-success btn-anim"><i class="ti-search"></i><span class="btn-text">Search</span></button>
                    </div>
                  </form>
                  -->



                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
            <!--   <div class="panel-heading">
                <div class="pull-left">
                  <h6 class="panel-title txt-dark">Broker Management</h6>
                </div>
                <div class="clearfix"></div>
              </div> -->
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Business Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                            <th>Last Login</th>
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
   



  <script type="text/javascript">
      $(document).ready(function(){




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
        var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
            "ajax": {
             url: LoadBoard.API+'admin/broker-list?id='+ids,
            "data": function(data){
              data.name = $("#name").val();
              data.business_name = $("#business_name").val();
              data.email = $("#email").val();
              data.phone = $("#phone").val();
              data.country = $("#country").val();
              data.state = $("#state").val();
              data.city = $("#city").val();
           },
          },
            "dom": 'Bfrtip',
             "type": "POST",
              "processing": false,
              "serverSide": true,
               "columns": [
                {"data": "name"},
                  {"data": "business_name"},
                  {"data": "email"},
                  {"data": "phone"},
                  {"data": "created_date"},
                  {"data": "last_login"},
                  {"data": "status" }
            ],
            buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             columnDefs: [{
                // puts a button in the last column
                targets: 6,
                width: "20%",
                bSortable:false,
                   render: function (a, b, data, d) {
                    var viewurl=LoadBoard.APP+"admin/broker-dashboard?id="+data.id;
                    var pro_url=LoadBoard.APP+"admin/broker-profile?id="+data.broker_id;
                    if (data.status==1) {
                      if(data.edit_per == 1){
                        var active='<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success status_changed">Active</a> ';
                      }else{
                          var active='';
                      }                  
                      return ' <a target="_blank" href="'+pro_url+'"><i class="fa fa-user"></i></a> | <a target="_blank" href="'+viewurl+'" class="label label-primary "> View</a> | '+active+'';
                    } else {
                       if(data.edit_per == 1){
                        var inactive=' | <a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success status_changed">Active</a> ';
                      }else{
                          var inactive='';
                      }
                      return '<a target="_blank" href="'+pro_url+'><i class="fa fa-user"></i></a>  <a target="_blank" href="'+viewurl+'"  class="label label-primary"> View</a> '+inactive+'';
                    }
                }
            }, 
            {
              targets: 0,
                render: function (a, b, data, d) {
                  return data.name;
                }
            },
            {
              targets: 1,
                render: function (a, b, data, d) {
                  return data.business_name;
                }
            },
            {
              targets: 2,
               width: "20%",
                render: function (a, b, data, d) {
                  return data.email;
                }
            },
            {
              targets: 3,
                render: function (a, b, data, d) {
                  return formatPhoneNumber(data.phone);
                }
              },
              {
              targets: 4,
                render: function (a, b, data, d) {
                  return data.created_date;
                }
             },
              {
              targets: 5,
                render: function (a, b, data, d) {
                  return data.last_login;
                }
             }

            ],
        }); 


    $(document).on('click','.status_changed',function(e){
          var id=$(this).attr("data-id");
          var status=$(this).attr("data-status");
      swal({   
            title: "Are you sure?",   
            text: "You are about to change the status of the Broker?",   
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
            data: "id="+window.atob(id)+"&action=broker_status&status="+window.atob(status),
            success: function (res) {
               swal({   
                  title: "Updated!",   
                  type: "success", 
                  text: "Broker status updated successfully",
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

     $('#broker_search').on('submit', function (e) {
          e.preventDefault();
          table.ajax.reload();
       });

     $("#clear_search").on('click',function(e){
          $("#broker_search")[0].reset();
          table.ajax.reload();
          $("#country").selectpicker("refresh");
          $("#state").selectpicker("refresh");
          $("#city").selectpicker("refresh");
          $('#country').selectpicker('deselectAll');
          $('#state').selectpicker('deselectAll');
          $('#city').selectpicker('deselectAll');
    });

     $(document).on('click','.cancel',function(e){
        setTimeout(function(){ $("body").removeClass("stop-scrolling"); }, 500);
     });


      });

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
                var option="<option value=''>Please select country</option>";                        
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
               var option="<option value=''>Please select state</option>"; 
            for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==state){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
               
              }
               $("#state").append(option).selectpicker('refresh'); 
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
                var option="<option value=''>Please select city</option>";                        
                for (var i =0; i<result.data.length; i++) {
                 if(result.data[i]['id']==city){
                    var selected = "selected=selected";
                 } else {
                    var selected = "";
                 }
                 option+="<option "+selected+" value="+result.data[i]['id']+">"+result.data[i]['name']+"</option>";
                }
               $("#city").html(option).selectpicker('refresh'); 
            }
          }
        }
    }); 
  }




  </script>
