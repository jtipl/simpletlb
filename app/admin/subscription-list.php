<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("LoadBoard - Dashboard");

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
  .help-block{
    color: #ff354d;
  }
</style>
    <div class="page-wrapper">
            <div class="container-fluid pt-30">
                      <!-- Title -->
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Subscription Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Subscription Management</span></a></li>
            <li class="active"><span>Subscription List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
        <?php if($create_per == 1){?>
 
         <div class="row">
            <div class="col-md-12">
              <div class="panel panel-default card-view">
                <div class="panel-heading">
                  <div class="pull-left">
                    <h6 class="panel-title txt-dark">Add Subscription Plan</h6>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                  <div class="panel-body">
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-wrap">
                          <form data-toggle="validator" class="registerForm" role="form">
                            <div class="form-group">
                              <label for="inputName" class=" mb-10">Subscription</label>
                              <input type="text" class="form-control subscription_input" id="name" name="subscription" placeholder="Subscription" >
                            </div>
                            <div class="form-group">
                              <label for="inputName" class="mb-10">Price</label>
                              <input type="text" onkeypress="return isNumberKey(event)" name="price"  class="form-control price_input" id="price" placeholder="Price " >
                            </div>
                            <div class="form-group">
                              <label for="inputName" class="mb-10">Days</label>
                              <input type="text" onkeypress="return isNumberKey(event)" name="days"  class="form-control days_input" id="days" placeholder="Days " >
                            </div>
                            <div class="form-group mb-0">
                              <button type="submit" class="btn btn-success btn-anim addsubscription"><i class="icon-rocket"></i><span class="btn-text">Add Subscription Plan</span></button>
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
                            <th>Subscription</th>
                            <th>Price</th>
                            <th>Days</th>
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
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
      $(document).ready(function(){
        var  ids=getUrlParameter('id');
        $(document).on("click", ".addsubscription",function () {
              var name = $("#name").val();
              var days = $("#days").val();
              var price = $("#price").val();
              if(name!="" && days!="" && price!=""  ){
                swal({   
                    title: "Are you sure?",   
                    text: "You want to add the subscription?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#e6b034",   
                    confirmButtonText: "Yes",   
                    closeOnConfirm: false 
                }, function(confirm){ 
                  $.ajax({
                    type: 'post',
                    url: LoadBoard.API+'admin/subscription/add',
                    contentType: "application/json",
                    headers: {
                      Authorization: "Bearer "+LoadBoard.admintoken
                    },
                    dataType: "json",
                   // data: "equipment="+equipment+"&status=1",
                    data: JSON.stringify({ 
                      "name": name, 
                      "days": days,
                      "price": price
                    }),
                    success:function(result){
                      if(result.status == 1){
                        swal({   
                          title: "Updated!",   
                          type: "success", 
                          text: "Subscription added successfully",
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
                  text: "You are about to change the status of the Subscription?",   
                  type: "warning",   
                  showCancelButton: true,   
                  confirmButtonColor: "#e6b034",   
                  confirmButtonText: "Yes",   
                  closeOnConfirm: false 
              }, function(confirm){  
                $.ajax({
                  url: LoadBoard.API+'admin/subscription',
                  type: "POST",
                  dataType: "json",
                  contentType: "application/json",
                    headers: {
                      Authorization: "Bearer "+LoadBoard.admintoken
                   },
                    data: JSON.stringify({ 
                      "id": window.atob(id), 
                      "status": window.atob(status),
                      "userid":LoadBoard.userid,
                      "operation":"change_status"
                    }),
                 // data: "id="+window.atob(id)+"&action=equipment_status&status="+window.atob(status),
                  success: function (res) {
                     swal({   
                        title: "Updated!",   
                        type: "success", 
                        text: "Subscription status updated successfully",
                        confirmButtonColor: "#71aa68",   
                      },function(confirm){
                        table.ajax.reload();
                   });
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    swal("Error", "Subscription status not updated", "error");   
                  }
                }); 
              });
          return false;
          });


        $(document).on("click",".edit_changed",function(){
            $("#myModal").modal("show");
        
            var id =window.atob($(this).attr("data-id"));
            var name =window.atob($(this).attr("data-name"));
            var days =window.atob($(this).attr("data-day"));
            var price =window.atob($(this).attr("data-price"));
          
            $("#edit_id").val(id);
            $("#edit_subscription").val(name);
            $("#edit_days").val(days);
            $("#edit_price").val(price);
          
        });

       
        var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/subscription',
            type:"post",
            headers: {
             Authorization: "Bearer "+LoadBoard.admintoken
            },
            contentType: "application/json",
            "dataFilter": function(data) {
                var data = JSON.parse(data);
                if(data.status==2){
                     window.location.href = LoadBoard.APP + "admin/logout";
                }else{
                  return JSON.stringify(data);  
                }
              
            },
            "data": function(data){
              data.user_id =LoadBoard.userid,
              data.user_type =LoadBoard.user_type,
              data.operation ='listing',
              data.id =ids
              return   JSON.stringify(data);
           },
          },
            "dom": 'Bfrtip',
             "type": "POST",
              "processing": false,
              "serverSide": true,
               "columns": [
                {"data": "name"},
                {"data": "price"},
                {"data": "days"},
                {"data": "created_date"},
                {"data": "id"}
            ],
             buttons: [
               'copy', 'csv', 'excel', 'pdf', 'print'
            ],
             columnDefs: [
              {
        targets: 1,
        render: function (data,type,row) {
          return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
      },
                       

             {
               
                targets: 4,
                bSortable:false,
                  render: function (a, b, data, d) {

                    //var pro_url=LoadBoard.APP+"admin/trucker-profile?id="+data.id;
                    //var viewurl=LoadBoard.APP+"admin/trucker-dashboard?id="+data.id;
                    if(data.status==1) {
                       if(data.edit_per == 1){
                        return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="javascript:void(0)" class="label label-primary edit_changed"  data-name="'+window.btoa(data.name)+'" data-day="'+window.btoa(data.days)+'"  data-price="'+window.btoa(data.price)+'" >Edit</a>&nbsp;|&nbsp;<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="javascript:void(0)" class="label label-success status_changed">Active</a>';
                      }else{
                          return "-";
                      }     
                    } else {
                       if(data.edit_per == 1){
                        return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="javascript:void(0)" class="label label-primary edit_changed"  data-name="'+window.btoa(data.name)+'" data-day="'+window.btoa(data.days)+'" data-price="'+window.btoa(data.price)+'"  >Edit</a>&nbsp;|&nbsp;<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" data-name="'+window.btoa(data.name)+'" data-day="'+window.btoa(data.days)+'"  class="label label-danger status_changed">In Active</a>';
                      }else{
                          return "-";
                      }
                      
                    }
                }
            }],
        }); 
    
 $('.registerForm').bootstrapValidator({
          message: 'This value is not valid',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
              subscription: {
                  //message: 'The username is not valid',
                  validators: {
                      notEmpty: {
                          message: 'Please enter the subscription name'
                      },
                    }
              },
              days: {
                  validators: {
                      notEmpty: {
                          message: 'Please enter the days'
                      },
                     
                  }
              },
              price: {
                  validators: {
                      notEmpty: {
                          message: 'Please enter the price'
                      },
                     
                  }
              }
             
          }
      })
      .on('success.form.bv', function(e) {
            e.preventDefault();
              var editval=$("#edit_id").val();
              var subscription="";
              var subscription_days="";
              var text="";
              var newtext="";
          
             if(editval!=''){
                subscription = $("#edit_subscription").val();
                subscription_days = $("#edit_days").val();
                subscription_price = $("#edit_price").val();
                text='update';
                newtext="updated";
              }else{
                subscription = $("#name").val();
                subscription_days = $("#days").val();
                subscription_price = $("#price").val();

                text='add';
                newtext="added";

              }
              if(subscription!="" && subscription_days!=""  ){
                swal({   
                    title: "Are you sure?",   
                    text: "You want to "+text+" the subscription?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#e6b034",   
                    confirmButtonText: "Yes",   
                    closeOnConfirm: false 
                }, function(confirm){ 
                  $.ajax({
                    type: 'post',
                    url: LoadBoard.API+'admin/subscription',
                    contentType: "application/json",
                    headers: {
                      Authorization: "Bearer "+LoadBoard.admintoken
                    },
                    dataType: "json",
                   // data: "equipment="+equipment+"&status=1",
                    data: JSON.stringify({ 
                      "name": subscription, 
                      "days": subscription_days,
                      "userid":LoadBoard.userid,
                      "operation":text,
                      "price":subscription_price,
                      "id":editval
                    }),
                    success:function(result){
                      if(result.status == 1){
                        swal({   
                          title: "Updated!",   
                          type: "success", 
                          text: "Subscription "+newtext+" successfully",
                          confirmButtonColor: "#71aa68",   
                        },function(confirm){

                          if(editval!=""){
                            $("#myModal").modal("hide");
                          }
                          $(".registerForm").get(0).reset()
                          table.ajax.reload();
                          

                     });                       
                      }else if(result.status == 0){
                         
                        swal({   
                          title: "Error!",   
                          type: "error", 
                          text: result.msg,
                          confirmButtonColor: "#F27474",   
                        },function(confirm){
                              $(".registerForm").get(0).reset();
                              return false;

                         });  
                         


                      }
                    }
                  });
                });
            }



          });

 $(document).on('click','.cancel',function(e){
        setTimeout(function(){ $("body").removeClass("stop-scrolling"); }, 500);
     });


 $(document).on('click','.subclose',function(e){
       // $(".registerForm").get(0).reset();
         $('.registerForm').bootstrapValidator('resetForm', true);
     });

 
      });

  </script>


  <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                             <form data-toggle="validator" class="registerForm" role="form">

                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close subclose" data-dismiss="modal" aria-hidden="true">×</button>
                              <h5 class="modal-title" id="myModalLabel">Edit Subscription Plan</h5>
                            </div>
                            <div class="modal-body">
                              <!-- Row -->
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="">
                                    <div class="panel-wrapper collapse in">
                                      <div class="panel-body pa-0">
                                        <div class="col-sm-12 col-xs-12">
                                          <div class="form-wrap">
                                            
                                              <div class="form-body overflow-hide">
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputuname_1">Subscription</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="icon-user"></i></div>
                                                    <input type="text" class="form-control subscription_input" id="edit_subscription" placeholder="Subscription" name="subscription">
                                                  </div>
                                                </div>
                                                <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputuname_1">Price</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input type="text" class="form-control days_input" id="edit_price" placeholder="Price" onkeypress="return isNumberKey(event)" name="days">
                                                  </div>
                                                </div>


                                                 <div class="form-group">
                                                  <label class="control-label mb-10" for="exampleInputuname_1">Days</label>
                                                  <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                    <input type="text" class="form-control days_input" id="edit_days" placeholder="Days" onkeypress="return isNumberKey(event)" name="days">
                                                      <input type="hidden" class="form-control" id="edit_id" >
                                                  </div>
                                                </div>
                                             
                                              </div>
                                           <!--    <div class="form-actions mt-10">      
                                                <button type="submit" class="btn btn-success mr-10 mb-30">Update Subscription</button>
                                              </div>    -->     
                                          
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                                 <button type="submit" class="btn btn-success waves-effect">Update Subscription Plan</button>
                              <button type="button" class="btn btn-default waves-effect subclose" data-dismiss="modal">Cancel</button>
                            </div>
                          </div>
                            </form>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>