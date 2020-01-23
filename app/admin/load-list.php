<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->admin_header("LoadBoard - Dashboard");
?>
    <div class="page-wrapper">
            <div class="container-fluid pt-30">
                      <!-- Title -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Load Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Load Management</span></a></li>
            <li class="active"><span>Load List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
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
                              <th>LOAD ID</th>
                              <th>ORIGIN</th>
                              <th>DESTINATION</th>
                              <th>PICKUP DATE</th>
                              <th>DELIVER DATE</th>
                              <th>EQUIPMENT</th>
                              <th>LENGTH</th>
                              <th>PRICE</th>
                              <th>STATUS</th>
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
        var table = $('#datable_1').DataTable({
        "ajax": LoadBoard.API+"admin/load-list",
        "type": "POST",
        "processing": true,
        "serverSide": true,
        "columns": [
            { "data": "load_id" },
            { "data": "origin" },
            { "data": "destination" },  
            { "data": "pickup_date" },       
            { "data": "delivery_date" }, 
            { "data": "truck_id" }, 
            { "data": "length" }, 
            { "data": "price" }, 
            { "data": "status" }, 
        ],
          columnDefs: [{
          // puts a button in the last column
              targets: [8], 
              render: function (a, b, data, d) {
                  if (data.status==0) {
                    return '<span class="label label-danger">Open for Trucker</span>';
                  } else if(data.status==1) {
                    return '<span class="label label-info">Awaiting for your Approval</span>';
                  } else if(data.status==2){
                    return '<span class="label label-warning">Load Approved for Pickup</span>';
                  }else if(data.status==3){
                    return '<span class="label label-success">Load Picked by Trucker</span>';
                  } else if(data.status==4){
                    return '<span class="label label-success">Load Delivered by Trucker</span';
                  }  else if(data.status==5){
                    return '<span class="label label-primary">Re-opened for Trucker</span>';
                  }  else{
                    return '';
                  }      
              }
          },
          {
            targets: 5,
            render: function (a, b, data, d) {
                return data.truck_name;
            }
          },
          ]

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
      });

  </script>
    <!-- <script type="text/javascript" src="http://192.168.1.215:81/loadboard/app/admin/dist/js/DataTable-data.js"></script> -->
    <div class="modal fade " id="confirm_popup"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header ">
          <h5 class="modal-title h2" id="mySmallModalLabel">Confirmation Status</h5>
          
      </div>
      <div class="modal-body text-center">
        <input type="hidden" id="uniqueid" value="" />
        <input type="hidden" id="status" value="" />
        
        <p>Are you sure want to change the Status?</p>
      </div>
      <div class="modal-footer ">
          <button type="button" class="change_status btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary tcancel mr-4  " data-dismiss="modal">Cancel</button>
      </div>
      </div>
  </div>
</div>