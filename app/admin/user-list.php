<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - User Management");

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
            <h5 class="txt-dark">User Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>User Management</span></a></li>
            <li><span>User List</span></li>
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
                    <h6 class="panel-title txt-dark">Add User</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-12 col-xs-12">
                        <div class="form-wrap">
                          <form  data-toggle="validator" role="form" id="user_list">
                            <div class="form-body">
                            <!--   <h6 class="txt-dark capitalize-font">Assign Roles for an Admin User</h6> -->
                              <hr class="light-grey-hr"/>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="control-label mr-15"  for="email_inline">Admin User Name:</label>
                                      <input type="text" class="form-control" name="user_name" id="user_name">
                                  </div>
                                </div>
                               </div>
                                <!--/span-->
                                 <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                     <label class="control-label mr-15"  for="password">Password: </label>
                                     <input type="password" class="form-control" name="password" id="password" value="">
                                  </div>
                                </div>
                                <!--/span-->
                              </div>
                             <!--  <h6 class="txt-dark capitalize-font">Assign Roles for an Admin User</h6> -->
                                                            <!-- /Row -->
                              <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <h6 class="txt-dark capitalize-font">Assign Roles for an Admin User</h6>
                                  </div>
                                </div>
                              </div>
                              <!-- /Row -->
                              <!-- /Row -->
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="control-label mb-10">Select a Role:</label>
                                    <select class="form-control" name="role_list" id="role_list">
                                    </select>
                                  </div>
                                </div>
                              
                              </div>
                              <!-- /Row -->
                              </div>
                            </div>
                            <div class="form-actions mt-10">
                              <button type="submit" class="btn btn-success  mr-10"> Save</button>
                              <button type="reset" class="btn btn-default">Clear</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
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
                            <th>User Name</th>
                            <th>Role</th>
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
           $.ajax({
            type: "POST", 
            url: LoadBoard.API+'admin/get_role_list',
            type: "POST", 
            async:false,
            dataType: 'json',
            data:{action:"get_role"},
            success: function (response) {    
              $.each(response, function (key, value) {
                  $("#role_list").append($('<option value="'+value.id+'">'+value.role_name+'</option>'));
              });
            }
        }); 
      });

        $("#user_list").submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST", 
            url: LoadBoard.API+'admin/adminsignup',
            type: "POST", 
            dataType: 'json',
            data: $('#user_list').serialize(),
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
                   $("#user_name").val('');
                   $("#password").val('');
                   location.reload();  

               }else if(result.status==0){
                  $.toast({
                    text: result.msg,
                    position: 'top-center',
                    loaderBg:'#fec107',
                    icon: 'error',
                    hideAfter: 3500
                  });
                        return false;
                      }
                  
  
            }
        }); 
      }); 
   var  ids=getUrlParameter('id');
   var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/user-list?id='+ids,
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
                {"data": "user_name"},
                {"data": "user_type"},

                {"data": "created_date"}
            ],
             buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             columnDefs: [
              
             {
                // puts a button in the last column 
                targets: 3,
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
 
    </script>