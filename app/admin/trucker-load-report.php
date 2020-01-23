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
       Trucker Load Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Trucker Load Report</a></li>
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
              
              
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>LOAD ID</th>
                  <th>ORIGIN</th>
                  <th>DESTINATION</th>
                  <th>WEIGHT</th>
                  <th>LENGTH</th>
                  <th>EQUIPMENT</th>
                  <th>PRICE</th>
                  <th>STATUS</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
               
              </table>
              <?php //require_once "export_page.php"; ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
     <!--  
       <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
     -->
    </section>
    <!-- /.content -->
   </div>

</div>

<?php $Global->admin_footer(); ?>
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


    


    var table = $('#datatable').DataTable({
          "ajax": LoadBoard.API+"admin/trucker-load-report",
          "type": "POST",
          "processing": true,
          "serverSide": true,
          "columns": 
          [
            { "data": "load_id" },
            { "data": "origin" },
            { "data": "destination" },
            { "data": "weight"},
            { "data": "length"},
            { "data": "truck_name"},
            { "data": "price"} 
          ],
          columnDefs: [{
              // puts a button in the last column
              targets: [7], render: function (a, b, data, d) {
              if (data.status==0) {
                return '<span class="status-icon bg-red ">Open for Trucker</span>';
              } else if(data.status==1) {
                return '<span class="status-icon bg-info">Awaiting for your Approval</span>';
              } else if(data.status==2){
                return '<span class="status-icon bg-success">Load Approved for Pickup</span>';
              }else if(data.status==3){
                return '<span class="status-icon bg-info">Load Picked by Trucker</span>';
              } else if(data.status==4){
                return '<span class="status-icon bg-success">Load Delivered by Trucker</span';
              }  else if(data.status==5){
                return '<span class="status-icon bg-success">Re-opened for Trucker</span>';
              }  else{
                return '';
              }      
            }
        }]
    });
});
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