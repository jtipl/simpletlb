<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Role List");
?>
<style type="text/css">
  .control-label{
    min-width: 108px;
  }
  input[type=checkbox]{cursor: pointer;}
</style>
    <div class="page-wrapper">
            <div class="container-fluid pt-30">
                      <!-- Title -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Role Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Role Management</span></a></li>
            <li><span>Role List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default card-view">
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Role And Features Mapping</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <form class="form-inline" id="role_list" data-toggle="validator" role="form">
                    <div class="form-wrap">
                     <div class="form-group mr-15">
                      <label class="control-label mr-15"   for="email_inline">Role Name:</label>
                      <input type="text" class="form-control" id="role_name" name="role_name" data-error="Please enter the Feature Name" required>
                    </div>
                   
                    <!-- <label class="control-label mr-15" for="pwd_inline"></label>
                    <button type="button" class="btn btn-success btn-anim add_User">Check All</button> -->
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                        <table id="datable_1" class="table  display table-hover mb-30" data-page-size="10">
                              <thead>
                                <tr>
                                  <th>Features</th>
                                  <th>Privileges</th>
                                </tr>
                                 <tr><td></td><td><div class="checkbox checkbox-success">&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="selectAll_read" type="checkbox">Read<br/>Check All</label></div><div class="checkbox checkbox-success">&nbsp;&nbsp;&nbsp;&nbsp;<label><input id="selectAll_edit" type="checkbox">Edit<br>Check All</label></div><div class="checkbox checkbox-success"><label><input id="selectAll_create"  type="checkbox">Create<br>Check All</label></div></td></tr>
                              </thead>
                              <tbody id="datable_data">
                              </tbody>
                            </table>
                    </div>
                  </div>
                </div>
              </div>
                        <label class="control-label mr-15" for="pwd_inline"></label>
                        <button type="submit" class="btn btn-success btn-anim add_User">Add Role</button>
                        <button id="clear_search" type="reset" class="btn btn-default btn-anim">Clear</button>
                    </div>
                  </form>
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

      $("#selectAll_read").click(function(){
        //alert("hii");
        $(".read_all").prop('checked', $(this).prop('checked'));
      });
      $("#selectAll_create").click(function(){
        //alert("hii");
        $(".create_all").prop('checked', $(this).prop('checked'));
      });
    $("#selectAll_edit").click(function(){
      //alert("hii");
        $(".edit_all").prop('checked', $(this).prop('checked'));
      });

     var arr = new Array();
     var newarr=new Array();
    var arrayen = [];
      var contact={};
      $(document).ready(function(){
            $.ajax({
            type: "POST", 
            url: LoadBoard.API+'admin/get_role_list',
            async:false,
            dataType: 'json',
            data:{action:"get_feature"},
            success: function (response) {
                //trHTML='<tr><td></td><td><label><div class="checkbox checkbox-success"><input id="selectAll_read" type="checkbox">Read All</div></label>&nbsp;<label><div class="checkbox checkbox-success"><input id="selectAll_edit" type="checkbox">Edit All</div></label><label><div class="checkbox checkbox-success"><input id="selectAll_create"  type="checkbox">Create All</div></td></label></tr>';
                $.each(response, function (i, item) {
                  var report_enable ='';
                  if (item.is_report == 1) {
                    report_enable ='disabled';
                  }

                 
                    trHTML = '<tr><td>' + item.feature_name +'</td><td><div class="checkbox checkbox-success"><input id="checkbox'+item.id+'" type="checkbox" class="read_all changeall"  name="role_map[]" value="'+item.id+'/read" id="'+item.id+'" data-id="'+item.feature_name+'"><label for="checkbox'+item.id+'">Read</label></div> &nbsp;&nbsp;<div class="checkbox checkbox-success ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="checkbox'+item.id+'" class="edit_all changeall" type="checkbox" name="role_map[]" value="'+item.id+'/edit"><label for="'+item.id+'">Edit</label></div>&nbsp;&nbsp;<div class="checkbox checkbox-success ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="checkbox'+item.id+'" class="create_all changeall" type="checkbox"  name="role_map[]" value="'+item.id+'/create" '+report_enable+'><label for="checkbox2">Create</label></div></td></tr>';
                    $('#datable_data').append(trHTML);
                });
                
            }
        }); 
      });


  $("#role_list").submit(function(e){
        e.preventDefault();
     var feature =$('#role_name').val();
      var read = $("#id").attr("read");
      var create = $("#id").attr("create");

      var edit = $("#id").attr("edit");

      console.log(read);
        $.ajax({
            type: "POST", 
            url: LoadBoard.API+'admin/role-data',
            type: "POST", 
            dataType: 'json',
             data: $('#role_list').serialize(),
     //       data:{data:feature},
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
                   $("#role_name").val('');
                   location.reload();  

               }
                  
  
            }
        }); 
      });


    </script>
