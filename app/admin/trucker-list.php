<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();

$Global->admin_header("SimpleTLB - Trucker List");
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
            <h5 class="txt-dark">Trucker Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Trucker Management</span></a></li>
            <li class="active"><span>Trucker List</span></li>
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
                     <form class="form-inline" id="trucker_search" data-toggle="validator" role="form">
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
                                <label class="control-label mr-15" for="email_inline">USDOT:</label>
                                <input type="text" class="form-control" id="dot">
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
                      <form class="form-inline" id="trucker_search" data-toggle="validator" role="form">
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
                          <label class="control-label mr-15" for="email_inline">USDOT:</label>
                          <input type="text" class="form-control" id="dot">
                         

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
              <div class="panel-heading">
                <!-- <div class="pull-left">
                  <h6 class="panel-title txt-dark">Trucker Management</h6>
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
        var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/trucker-list?id='+ids,
            "data": function(data){
              data.name = $("#name").val();
              data.business_name = $("#business_name").val();
              data.email = $("#email").val();
              data.phone = $("#phone").val();
              data.dot = $("#dot").val();
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
             columnDefs: [
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
              },
              {
                // puts a button in the last column 
                targets: 6,
               width: "20%",
                bSortable:false,
                   render: function (a, b, data, d) {
                    var pro_url=LoadBoard.APP+"admin/trucker-profile?id="+data.id;
                    var viewurl=LoadBoard.APP+"admin/trucker-dashboard?id="+data.id;

                    if (data.status==1) {
                       if(data.edit_per == 1){
                        var active='<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success status_changed">Active</a>'
                      }else{
                          var active='';
                      }      
                      return '<a target="_blank" href="'+pro_url+'"><i class="fa fa-user"></i></a> | <a target="_blank" href="'+viewurl+'" class="label label-primary "> View</a> | '+active+'';
                    } else {
                       if(data.edit_per == 1){
                        var inactive='  <a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" class="label label-danger status_changed">In Active</a>'
                      }else{
                          var inactive='';
                      }
                      return '<a target="_blank" href="'+pro_url+'"><i class="fa fa-user"></i></a> <a target="_blank" href="'+viewurl+'" class="label label-primary"> View</a> &nbsp;&nbsp;'+inactive+'';
                    }
                }
            },
            {
              targets: 2,
             
                render: function (a, b, data, d) {
                  return data.email;
                }
              } 

            ],
        }); 

 $('#trucker_search').on('submit', function (e) {
          e.preventDefault();
          table.ajax.reload();
       });

     $("#clear_search").on('click',function(e){
          $("#trucker_search")[0].reset();
          table.ajax.reload();
         
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
            url: LoadBoard.API+'admin/trucker-request',
            type: "POST",
            dataType: "json",
            data: "id="+window.atob(id)+"&action=trucker_status&status="+window.atob(status),
            success: function (res) {
               swal({   
                  title: "Updated!",   
                  type: "success", 
                  text: "Trucker status updated successfully",
                  confirmButtonColor: "#71aa68",   
                },function(confirm){
                  table.ajax.reload();
             });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error", "Trucker status not updated", "error");   

            }
        }); 
        });
    return false;
    });

     $(document).on('click','.cancel',function(e){
        setTimeout(function(){ $("body").removeClass("stop-scrolling"); }, 500);
     });


      });

  </script>
