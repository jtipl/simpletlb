<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Role Map List");

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
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Role Management</h5>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#"><span>Role Management</span></a></li>
            <li><span>Roles list List</span></li>
            </ol>
          </div>
        </div>

          <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-heading">
                 <div class="pull-left">
                  <h6 class="panel-title txt-dark">
                    <a href="<?php echo SITEURL; ?>/app/admin/role-list?id=<?php echo $_REQUEST["id"]?>">
                      <button type="button" class="btn btn-primary">Add Role</button>
                    </a>
                  </h6>
                </div> 
                <div class="clearfix"></div>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                          <tr>
                            <th>Role Name</th>
                            <th>Features Name</th>
                            <th>Read</th>
                            <th>Edit</th>
                            <th>Create</th>
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
             url: LoadBoard.API+'admin/role-feature-mapping-list?id='+ids,
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
                {"data": "role_name"},
                {"data": "feature_name"},
                {"data": "read"},
                {"data": "edit"},
                {"data": "create"},
            ],
            buttons: [
              /* 'copy', 'csv', 'excel', 'pdf', 'print'*/
            ],
             columnDefs: [
             {
                targets: 2,
                bSortable:false,
                  render: function (a, b, data, d) {
                    if(data.read==1) {  
                        return '<a href="#" class="label label-success status_changed">Enable</a>'; 
                    } else {
                       return '<a class="label label-danger status_changed">Disable</a>';
                    }
                }
            },
             {
                targets: 3,
                bSortable:false,
                  render: function (a, b, data, d) {
                    if(data.edit==1) {  
                        return '<a href="#" class="label label-success status_changed">Enable</a>'; 
                    } else {
                       return '<a class="label label-danger status_changed">Disable</a>';
                    }
                }
            },
            {
                targets: 4,
                bSortable:false,
                  render: function (a, b, data, d) {
                    if(data.create==1) {  
                        return '<a href="#" class="label label-success status_changed">Enable</a>'; 
                    } else {
                       return '<a class="label label-danger status_changed">Disable</a>';
                    }
                }
            },
            
              
          /*   {
                // puts a button in the last column 
                targets: 5,
                bSortable:false,
                  render: function (a, b, data, d) {
                    console.log(data);
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
            }*/
            ],
        }); 

   


   });
  
        
    </script>
