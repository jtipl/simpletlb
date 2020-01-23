<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Feature List");

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
            <h5 class="txt-dark">Feature Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Feature Management</span></a></li>
            <li><span>Feature List</span></li>
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
                    <h6 class="panel-title txt-dark">Add Feature</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <form class="form-inline" id="feature_data" data-toggle="validator" role="form">
                    <div class="form-wrap">
                         <div class="form-group mr-15">
                          <label class="control-label mr-15" for="features_name">Feature Name:</label>
                          <input type="text" class="form-control" name="feature_name" id="feature_name" data-error="Please enter the Feature Name" required>
                        </div>
                        <div class="checkbox checkbox-success">
                            <input id="checkbox3" name="report_enable" value="1" type="checkbox">
                            <label for="checkbox3">
                              Is this Report or Not? 
                            </label>
                          </div>
                        <label class="control-label mr-15" for="pwd_inline"></label>
                        <button type="submit" class="btn btn-success btn-anim add_User">Add Feature</button>
                        <button id="clear_search" type="reset" class="btn btn-default btn-anim">Clear</button>
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
                <!--  <div class="pull-left">
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
                            <th>Features Name</th>
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
          

    $("#feature_data").submit(function(e){
        e.preventDefault();
      var feature =$('#feature_name').val();
        $.ajax({
            type: "POST", 
            url: LoadBoard.API+'admin/feature-data',
            type: "POST", 
            dataType: 'json',
             data: $('#feature_data').serialize(),
            //data:{data:feature},
            success: function (result) {
               if(result.status==1){                  
                  $.toast().reset('all');
                  $("body").removeAttr('class');
                  $.toast({
                    heading: 'Successfully',
                    text: result.msg,
                    position: 'top-center',
                    loaderBg:'#fec107',
                    icon: 'success',
                    hideAfter: 1000, 
                    stack: 6
                  });
                   $("#feature_name").val('');
                   location.reload();  

               }
                  
  
            }
        }); 
      });
      var  ids=getUrlParameter('id');
      var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/feature-list?id='+ids,
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
                {"data": "feature_name"},
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
                        return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success status_changed">Active</a>';
                      }else{
                        return '-';
                      }
                    } else {
                       if(data.edit_per == 1){
                       return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" class="label label-danger status_changed">In Active</a>';
                      }else{
                        return '-';
                      }
                    }
                }
            }],
        }); 

   

          $(document).on('click','.status_changed',function(e){
                var id=$(this).attr("data-id");
                var status=$(this).attr("data-status");
            swal({   
                  title: "Are you sure?",   
                  text: "Do you want to change the Feature's status?",   
                  type: "warning",   
                  showCancelButton: true,   
                  confirmButtonColor: "#e6b034",   
                  confirmButtonText: "Yes",   
                  closeOnConfirm: false 
              }, function(confirm){  
                $.ajax({
                  url: LoadBoard.API+'admin/feature-request',
                  type: "POST",
                  dataType: "json",
                  data: "id="+window.atob(id)+"&action=feature_status&status="+window.atob(status),
                  success: function (res) {
                     swal({   
                        title: "Updated!",   
                        type: "success", 
                        text: "Feature's status updated successfully",
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