<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("LoadBoard - Trucks List");
?>
<style>
.status_changed,.edit{cursor: pointer;}
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Trucks Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Truck List</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <td>
                    <input type="text" placeholder="Truck Name" id="equipment" class="form-control" value="" />
                  </td>
                  <td>
                    <input type="submit" value="Add" class="btn btn-success add_equipment" />
                  </td>
                </tr>
              </table>  
              
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Truck Name</th>
                  <th>Created Date</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
               
              </table>
              <?php require_once "export_page.php"; ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
       <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    </section>
    <!-- /.content -->
   </div>


<?php $Global->admin_footer(); 

$sel = $Global->db->prepare("SELECT count(*) as allcount FROM truck_type");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$total_count = $records['allcount'];
?>
<script type="text/javascript">
  $(document).ready(function() {

    // Equipment alphabets starts here
    $("#equipment,#edit_equipment_name").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });
    // Equipment alphabets ends here


    $(".export_csv").click(function(){
       var export_page = $("input[name='export_page']:checked").val();
        var total_count = '<?php echo $total_count; ?>';
       if(export_page==2){
        var href=LoadBoard.API+"admin/equipment-download-excel-all?operation=equipment_all_excel&length=all";
        window.location.href=href;
       } else if(export_page==1){
        var pageid = $("li.active > .page-link").attr("data-dt-idx");
        //alert(pageid);
        var draw = pageid;
        for(var i=1; i<=total_count; i++){
          if(draw==i && i==1){
            var start = 0;
          }
          else if(draw==i && i>1){
            var start = ((i-1) * 10);
          }
        }

        var length = '10';
        var href=LoadBoard.API+"admin/equipment-download-excel-current?operation=equipment_current_excel&start="+start+"&length="+length;
        window.location.href=href;
       }
    });


    var table = $('#datatable').DataTable( {
        "ajax": LoadBoard.API+"admin/trucks-list",
        "type": "POST",
        "processing": true,
        "serverSide": true,
        "columns": [
            { "data": "truck_name" },
            { "data": "created_date" },
            { "data": "status" }          
        ],
          columnDefs: [{
          // puts a button in the last column
              targets: [2], render: function (a, b, data, d) {
                  if (data.status==1) {
                    return ' <span id="'+data.id+'<>'+data.status+'<>'+data.truck_name+'" class="label label-primary edit edit_equipment">Edit</span> <span id="'+data.id+'<>'+data.status+'" class="label label-success status_changed">Active</span>';
                  } else {
                    return ' <span id="'+data.id+'<>'+data.status+'<>'+data.truck_name+'" class="label label-primary edit edit_equipment">Edit</span> <span id="'+data.id+'<>'+data.status+'" class="label label-danger status_changed">Inactive</span>';
                  }
              }
          }]
     } );


    $(document).on("click", ".status_changed",function () {
        var attr = $(this).attr("id").split("<>");
        var id =attr[0];
        var status =attr[1];
        
        $.ajax({
          type: 'post',
          url: LoadBoard.API+'admin/ajax_request?action=update_status',
          dataType: "json",
          data: "id="+id+"&status="+status,
          success:function(result){
             table.ajax.reload();
          }
        });
    });

    $(document).on("click", ".add_equipment",function () {
        var equipment = $("#equipment").val();
        if(equipment!=""){
            $.ajax({
              type: 'post',
              url: LoadBoard.API+'admin/ajax_request?action=add_equipment',
              dataType: "json",
              data: "equipment="+equipment+"&status=1",
              success:function(result){
                 table.ajax.reload();
              }
            });
      } else {
        $("#equipment").css('border','1px solid red');
      }
    });
    
    $(document).on("click", ".edit_equipment",function () {
        $("#edit_equipment_modal").modal('show');
        var attr = $(this).attr("id").split("<>");
        $("#edit_equipment_name").val(attr[2]);
        $("#updatestatus").val(attr[1]);
        $("#uniqueid").val(attr[0]);
    });

     $(document).on("click", ".update_equipment",function () {
        var uniqueid = $("#uniqueid").val();
        var updatestatus = $("#updatestatus").val();
        var edit_equipment_name = $("#edit_equipment_name").val();
        if(edit_equipment_name!=""){
          $.ajax({
              type: 'post',
              url: LoadBoard.API+'admin/ajax_request?action=update_equipment',
              dataType: "json",
              data: "equipment="+edit_equipment_name+"&status="+updatestatus+"&id="+uniqueid,
              success:function(result){
                $("#edit_equipment_modal").modal("hide");
                 table.ajax.reload();
              }
            });
        } else {
          $("#edit_equipment_name").css('border','1px solid red');
        }
    });

} );
</script>

<div class="modal fade " id="edit_equipment_modal"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header ">
        <h5 class="modal-title h2" id="mySmallModalLabel">Update Equipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
        <table class="table table-bordered">
          <input type="hidden" id="uniqueid" value="" />
          <input type="hidden" id="updatestatus" value="" />
          <tr>
            <td>
              <input type="text" placeholder="Truck Name" id="edit_equipment_name" class="form-control" value="" />
            </td>
            <td>
              <input type="submit" value="Update" class="btn btn-success update_equipment" />
            </td>
          </tr>
        </table>  
    </div>
    <div class="modal-footer">
        <input type="hidden" id="data-profile" data-profile="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>