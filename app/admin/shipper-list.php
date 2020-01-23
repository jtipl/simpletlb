<?php 
require_once("../../elements/Global.php");
$Global = new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("LoadBoard - Shipper List");


?>
<style>
.status_changed,.edit{cursor: pointer;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Shipper Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Shipper List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

           <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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

  <!-- /.content-wrapper -->
<?php
$Global->admin_footer(); 

$sel = $Global->db->prepare("SELECT count(*) as allcount FROM users u JOIN shipper sh ON u.id = sh.user_id AND u.user_type='shipper'");
$sel->execute();
$records =$sel->fetch(PDO::FETCH_ASSOC);
$total_count = $records['allcount'];
?>


<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
 $(".export_csv").click(function(){
       var export_page = $("input[name='export_page']:checked").val();
        var total_count = '<?php echo $total_count; ?>';
       if(export_page==2){
        var href=LoadBoard.API+"admin/shipper-download-excel-all-user?operation=shipper_all_excel&length=all";
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
        var href=LoadBoard.API+"admin/shipper-download-excel-current-user?operation=shipper_current_excel&start="+start+"&length="+length;
        window.location.href=href;
       }
    });



      var table = $('#example').DataTable({
            "ajax": LoadBoard.API+'admin/shipper-list',
            
             "type": "POST",
              "processing": true,
              "serverSide": true,
               "columns": [
                {"data": "name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "status" }
            ],
             columnDefs: [{
                // puts a button in the last column
                targets: [-1], render: function (a, b, data, d) {
                    if (data.status==1) {
                      return '<span id="'+data.id+'<>'+data.status+'" class="label label-success status_changed">Active</span>';
                    } else {
                      return '<span id="'+data.id+'<>'+data.status+'" class="label label-danger status_changed">In Active</span>';
                    }
                }
            }],
            
        });

       table.on("click", "button",
        function () {
            alert(table.rows($(this).closest("tr")).data()[0].name);
        });


       $(document).on("click", ".status_changed",function () {
          var attr = $(this).attr("id").split("<>");
          var id =attr[0];
          var status =attr[1];
          //alert(id);
          $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/ajax_request?action=shipper_status',
            dataType: "json",
            data: "id="+id+"&status="+status,
            success:function(result){
              table.ajax.reload();
            }
          });
      });

  });

/*
function user_list(data=""){

  $("input[type=search]").addClass('global_filter');

   var url = LoadBoard.API+'admin/trucker-list';
     $.ajax({
        type:'post',
        url:url,
        data:data,
        success: function (data) {
          
          //alert(data);

          var json1 = JSON.parse(data);
          //alert(json1);
          $.each(json1, function(idx, obj) {
            if(obj.verified_status==1){
              var status = 'Active';
            }

            if(obj.verified_status==0){
              var status = 'In Active';
            }
            
              $("#append_row").append('<tr><td>'+obj.name+'</td><td>'+obj.email+'</td><td>'+obj.phone+'</td><td><a href="#">'+status+'</a></td></tr>');
            
             var table =  $('#example1').DataTable();
            // var table1 =  $('#example1').DataTable().search();

          });
        }
    });

}
*/
</script>


