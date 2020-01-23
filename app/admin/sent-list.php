<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("SimpleTLB - Send Mail List");
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
            <h5 class="txt-dark">Email Management</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
         <!--    <li><a href="index-2.html">Dashboard</a></li> -->
            <li><a href="#"><span>Email Management</span></a></li>
            <li class="active"><span>Send Mail List</span></li>
            </ol>
          </div>
          <!-- /Breadcrumb -->
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-heading">
                 <div class="pull-left">
                  <h6 class="panel-title txt-dark">
                    <a href="<?php echo SITEURL; ?>/app/admin/email?id=<?php echo $_REQUEST["id"];?>">
                      <button type="button" class="btn btn-primary">Create mail</button>
                    </a>
                  </h6>
                </div> 
                <div class="clearfix"></div>               
                <div class="clearfix"></div>
              </div>
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_1" class="table table-hover display  pb-30" >
                        <thead>
                          <tr>
                            <th>Send To</th>
                            <th>Subject</th>
                            <th>Send date</th>
                            <th>Send By</th>
                            <th>Delivery status</th>
                            <th>Open status</th>
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

$( document ).ready(function() {

      var  ids=getUrlParameter('id');
        var table = $('#datable_1').DataTable({
          "ajax": {
             url: LoadBoard.API+'admin/sent-mail-list?id='+ids,
            "data": function(data){
           },
          },
            "dom": 'Bfrtip',
             "type": "POST",
              "processing": false,
              "serverSide": true,
               "columns": [
                {"data": "to_address"},
                {"data": "subject"},
                {"data": "created_date"},
                {"data": "user_name" },
                {"data": "delivery_status"},
                {"data": "open_status"},
                {"data": "status"},
            ],
            buttons: [
              
            ],
            columnDefs: [
             {
                targets: 4,
                  bSortable:false,
                    render: function (a, b, data, d) {            
                      if(data.delivery_status==1) {
                          return '<a href="#" class="label label-success status_changed">Delivered</a>'; 
                  
                      } else {
                         return '<a class="label label-danger status_changed">Not Delivered</a>';
                      }
                  }
              },
              {
                targets: 5,
                  bSortable:false,
                    render: function (a, b, data, d) {            
                      if(data.open_status==1) {
                          return '<a href="#" class="label label-success status_changed">Opened</a>'; 
                  
                      } else {
                         return '<a class="label label-danger status_changed">Not Opened</a>';
                     }
               }
            },
             {
                targets: 6,
                bSortable:false,
                  render: function (a, b, data, d) {
                      return '<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-primary edit_changed">Edit</a>&nbsp;|&nbsp;<a data-id="'+window.btoa(data.id)+'" data-status="'+window.btoa(data.status)+'" href="#" class="label label-success view_mail status_changed">View</a>';
                }
             }

          ],

        }); 

          $(document).on("click",".view_mail",function(){
            $("#myViewModal").modal("show");
           // var id1=$(this).attr("data-id");
           // var id =window.atob(id1)
         //   //alert(id)
          //  $("#uniqueid").val(id);
        /*    $.ajax({
                  url: LoadBoard.API+'admin/ajax-request',
                  type: "POST",
                  dataType: "json",
                  data: "id="+id+"&action=get-equipment",
                  success: function (res) {
                    //alert(res.msg);
                    $("#edit_equipment_val").val(res.msg);
                  }
              });*/
        });

  
});

  </script>

                         <!-- Modal -->
                          <div aria-hidden="true" role="dialog" tabindex="-1" id="myEditModal" class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                  <h4 class="modal-title">Compose</h4>
                                </div>
                                <div class="modal-body">
                                  <form role="form" class="form-horizontal">
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">To</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="inputEmail1" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Cc / Bcc</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="cc" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Subject</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Message</label>
                                      <div class="col-lg-10">
                                        <textarea class="textarea_editor form-control" rows="15" placeholder="Enter text ..."></textarea>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                        <div class="fileupload btn btn-info btn-anim mr-10"><i class="zmdi zmdi-attachment"></i><span class="btn-text">attachments</span>
                                          <input type="file" class="upload">
                                        </div>
                                        
                                        <button class="btn btn-success" type="submit">Send</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->
                                                   <!-- Modal -->
                          <div aria-hidden="true" role="dialog" tabindex="-1" id="myViewModal" class="modal fade" style="display: none;">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                  <h4 class="modal-title">Compose</h4>
                                </div>
                                <div class="modal-body">
                                  <form role="form" class="form-horizontal">
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">To</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="inputEmail1" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Cc / Bcc</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="cc" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Subject</label>
                                      <div class="col-lg-10">
                                        <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-lg-2 control-label">Message</label>
                                      <div class="col-lg-10">
                                        <textarea class="textarea_editor form-control" rows="15" placeholder="Enter text ..."></textarea>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                        <div class="fileupload btn btn-info btn-anim mr-10"><i class="zmdi zmdi-attachment"></i><span class="btn-text">attachments</span>
                                          <input type="file" class="upload">
                                        </div>
                                        
                                        <button class="btn btn-success" type="submit">Send</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->