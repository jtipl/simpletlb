<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Equipment List");

$role_type=isset($_SESSION['user_type']) ? trim($_SESSION['user_type']) : '';
$feature_id_url=isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
$check_role = $Global->db->prepare("SELECT id FROM roles_list WHERE status=1 AND role_name ILIKE :role_name");
$check_role->execute(array("role_name"=>$role_type));
$data_role = $check_role->fetch(PDO::FETCH_ASSOC);
$role_id=$data_role['id'];

$check_feature = $Global->db->prepare("SELECT count(*) FROM mapping_role_feature WHERE status=1 AND role_id =:role_id AND creates=1 AND feature_id=:feature_id");
$check_feature->execute(array("role_id"=>$role_id, "feature_id"=>$feature_id_url));
$get_feature_id = $check_feature->fetch(PDO::FETCH_ASSOC);
$create_check=$get_feature_id['count'];
if($create_check == 1){
$create_per=1;
}else{
$create_per=0;
}

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
            <h5 class="txt-dark">Equipment Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Equipment Management</span></a></li>
            <li class="active"><span>Equipment List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
        <?php if($create_per == 1){?>
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default card-view">
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Add Equipment</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body">
                      <form class="form-inline" id="trucker_search" data-toggle="validator" role="form">
                    <div class="form-wrap">
                         <div class="form-group mr-15">
                          <label class="control-label mr-15"  for="email_inline">Equipment Name:</label>
                          <input type="text" class="form-control" id="equipment">
                        </div>
                    
                        <label class="control-label mr-15" for="pwd_inline"></label>
                        <button id="clear_search" type="reset" class="btn btn-default btn-anim"><i class="ti-eraser"></i><span class="btn-text">Clear</span></button>

                        <button type="button" class="btn btn-success btn-anim add_equipment"><i class="ti-search"></i><span class="btn-text">Add Equipment</span></button>
                    </div>
                  </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }?>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-heading">
                <!-- 
                <div class="pull-left">
                  <h6 class="panel-title txt-dark">Trucker Management</h6>
                </div> 
                -->
                <div class="clearfix"></div>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                          <tr>
                            <th>Equipment Name</th>
                            <th>Created Date</th>
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
        $(document).on("click", ".add_equipment",function () {
              var equipment = $("#equipment").val();
              if(equipment!=""){
                swal({   
                    title: "Are you sure?",   
                    text: "You want to add the equipment?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#e6b034",   
                    confirmButtonText: "Yes",   
                    closeOnConfirm: false 
                }, function(confirm){ 
                  $.ajax({
                    type: 'post',
                    url: LoadBoard.API+'admin/ajax_request?action=add_equipment&id='+ids,
                    dataType: "json",
                    data: "equipment="+equipment+"&status=1",
                    success:function(result){
                      if(result.status == 1){
                        swal({   
                          title: "Updated!",   
                          type: "success", 
                          text: "Equipment added successfully",
                          confirmButtonColor: "#71aa68",   
                        },function(confirm){
                          table.ajax.reload();
                     });                       
                      }else if(result.status == 0){
                          $.toast({
                          heading: 'Error Message',
                          text: result.msg,
                          position: 'top-center',
                          loaderBg:'#fec107',
                          icon: 'error',
                          hideAfter: 1000, 
                          stack: 6
                          });
                      }
                    }
                  });
                });
            } else {
              $("#equipment").css('border','1px solid red');
            }
          });

          $(document).on('click','.status_changed',function(e){
                var id=$(this).attr("data-id");
                var status=$(this).attr("data-status");
            swal({   
                  title: "Are you sure?",   
                  text: "You are about to change the status of the Equipment Type?",   
                  type: "warning",   
                  showCancelButton: true,   
                  confirmButtonColor: "#e6b034",   
                  confirmButtonText: "Yes",   
                  closeOnConfirm: false 
              }, function(confirm){  
                $.ajax({
                  url: LoadBoard.API+'admin/equipment-request',
                  type: "POST",
                  dataType: "json",
                  data: "id="+window.atob(id)+"&action=equipment_status&status="+window.atob(status),
                  success: function (res) {
                     swal({   
                        title: "Updated!",   
                        type: "success", 
                        text: "Equipment status updated successfully",
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


        $(document).on("click",".edit_changed",function(){
            $("#myModal").modal("show");
            var id1=$(this).attr("data-id");
            var id =window.atob(id1)
            //alert(id)
            $("#uniqueid").val(id);
            $.ajax({
                  url: LoadBoard.API+'admin/ajax-request',
                  type: "POST",
                  dataType: "json",
                  data: "id="+id+"&action=get-equipment",
                  success: function (res) {
                    //alert(res.msg);
                    $("#edit_equipment_val").val(res.msg);
                  }
              });
        });

        //edit_equipment
        $(document).on("click",".edit_equipment",function(){
           // $("#myModal").modal("show");
          var edit_equipment_val =$("#edit_equipment_val").val();
          var uniqueid =$("#uniqueid").val();
          //alert(edit_equipment_val);
           $.ajax({
                url: LoadBoard.API+'admin/ajax-request',
                type: "POST",
                dataType: "json",
                data: "id="+uniqueid+"&action=update_equipment&equipment="+edit_equipment_val,
                success: function (res) {
                  //alert(res.msg);
                  swal({   
                      title: "Updated!",   
                      type: "success", 
                      text: res.msg,
                      confirmButtonColor: "#71aa68",   
                    },function(confirm){
                      table.ajax.reload();
                 });
                  $("#myModal").modal("hide");
                }
            });
        });
        var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/equipment-list?id='+ids,
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
                {"data": "truck_name"},
                {"data": "created_date"}
            ],
             buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             columnDefs: [
              
             {
                // puts a button in the last column 
                targets: 2,
                bSortable:false,
                  render: function (a, b, data, d) {
                    //var pro_url=LoadBoard.APP+"admin/trucker-profile?id="+data.id;
                    //var viewurl=LoadBoard.APP+"admin/trucker-dashboard?id="+data.id;
                    if(data.status==1) {
                       if(data.edit_per == 1){
                        return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-primary edit_changed">Edit</a>&nbsp;|&nbsp;<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success status_changed">Active</a>';
                      }else{
                          return "-";
                      }     
                    } else {
                       if(data.edit_per == 1){
                        return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-primary edit_changed">Edit</a>&nbsp;|&nbsp;<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" class="label label-danger status_changed">In Active</a>';
                      }else{
                          return "-";
                      }
                      
                    }
                }
            }],
        }); 

 
      });

  </script>


    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 class="modal-title" id="myModalLabel">Edit Equipment</h5>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div>
              <label>Equipment Name</label>
              <input type="text" name="" class="form-control" id="edit_equipment_val" placeholder="Equipment Name" />
              <input type="hidden" id="uniqueid" value="" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info edit_equipment">Submit</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
                    