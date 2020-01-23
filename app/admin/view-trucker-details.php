<?php 
require_once("../../elements/Global.php");
$Global = new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("LoadBoard - Trucker List");

  $id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';



?>
<style>
.status_changed,.view_status,.edit{cursor: pointer;}
</style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       View Trucker Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Trucker List</a></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <div class="box">
            <!-- /.box-header -->
              <div class="box-body">
                <a href="trucker-list">
                  Go back
                </a>

            <table class="table table-bordered table-hover workflowtable">
            <tr>
                <th colspan="6"> <h4>Trucker Details </h4> </th>
            </tr>
            <tr>
                <th>Name</th>
                <td id="name"></td>
                <th colspan="2">Driving Licence Number</th>
                <td id="driving_license" colspan="2"></td>
            </tr>
            <tr>
                <th>Business Name</th>
                <td id="business_name"></td>
                <th colspan="2">Licence Issuing State</th>
                <td id="license_issuing" colspan="2"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td id="email"></td>
                <th colspan="2">Licence Expiry Date</th>
                <td id="license_expiry_dt" colspan="2"></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td id="phone"></td>
                <th colspan="2">US DOT</th>
                <td id="us_dot" colspan="2"></td>
            </tr>
            <tr>
                <th>Weight</th>
                <td id="weight"></td>
                <th colspan="2">Length</th>
                <td id="length"></td>
            </tr>
            <tr>
              <th>Equipment</th>
              <td  id="equipmentdisp"></td>
               
              <td colspan="10">
                  <div id="append_equipment"></div>
              </td>
            </tr>
            <tr>
                <th colspan="6"> <h4>Trucker Bank Details </h4> </th>
            </tr>
            <tr>
                <th>Bank Name</th>
                <td id="bank_name"></td>
                <th>Bank Account Number</th>
                <td id="bank_acc_no"></td>
                <th>Bank Routing Number</th>
                <td id="bank_routing_no"></td>
            </tr>
             <tr>
                <th colspan="6"> <h4>Trucker Vehicle Details </h4> </th>
            </tr>
          </table>
          <table id="vehicle-details" class="table card-table table-striped table-vcenter">
              <thead>
                <tr>
                  <!--<th><input type="checkbox" class="checkall" /></th>-->
                  <th>S.NO</th>
                  <th>VIN NO</th>
                  <th>MAKE</th>
                  <th>MODEL</th>
                  <th>TYPE</th>
                  <th>WEIGHT</th>
                  <th>LENGTH</th>
                  <th>HEIGHT</th>
                </tr>
              </thead>
              <tbody id="append_vehicle_row">
              </tbody>
          </table>




              </div>
            </div>
          </div>
        </div>
      </section>
      <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $Global->admin_footer(); ?>
<script type="text/javascript">

function phoneFormat(phone) {
    phone = phone.replace(/[^0-9]/g, '');
    phone = phone.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
    return phone;
}

$(document).ready(function(){
  var str = "<?php echo $id; ?>";
   var id = window.atob(str);
   //alert(id);
    $.ajax({
      type: 'post',
      url: LoadBoard.API+'admin/trucker-get-details?action=get_trucker_details',
      dataType: "json",
      data: "id="+id,
      success:function(result){
          //var phone = result.data.phone.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
          //alert(result.data.name)
          $("#name").html("").append(result.data.name);
          $("#business_name").html("").append(result.data.business_name);
          $("#email").html("").append(result.data.email);

          $("#phone").html("").append(phoneFormat(result.data.phone));
          $("#driving_license").html("").append(result.data.vehicle_licence_no);
          
          $("#license_expiry_dt").html("").append(result.data.vehicle_expiry_date);
          $("#us_dot").html("").append(result.data.vehicle_number);
          $("#weight").html("").append(result.data.vehicle_weight);
          $("#length").html("").append(result.data.vehicle_length);

          $("#bank_name").html("").append(result.data.bank_name);
          $("#bank_acc_no").html("").append(result.data.account_number);
          $("#bank_routing_no").html("").append(result.data.routing_number);

           $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/trucker-get-details?action=get_vehicle_details',
            dataType: "json",
            data: "user_id="+result.data.id,
            success:function(result){
              //alert(result.data.length);
              if(result.data.length==0){
                var htm = '<tr><td class="text-center" colspan="10">No relevant information available</td></tr>';
                 $("#append_vehicle_row").append(htm);
              } else {
                for(i=0;i<result.data.length;i++){
                  //alert(result.data[i]["veh_id_no"])
                  var htm2 = '<tr><td>'+(i+1)+'</td><td>'+result.data[i]["veh_id_no"]+'</td><td>'+result.data[i]["veh_make"]+'</td><td>'+result.data[i]["veh_model"]+'</td><td>'+result.data[i]["veh_type"]+'</td><td>'+result.data[i]["veh_weight"]+'</td><td>'+result.data[i]["veh_length"]+'</td><td>'+result.data[i]["veh_height"]+'</td></tr></table>';
                    $("#append_vehicle_row").append(htm2);
                }
              }
            }
          });

          $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/trucker-get-details?action=get_state_details',
            dataType: "json",
            data: "state_id="+result.data.vehicle_issuing_state,
            success:function(result){
              $("#license_issuing").html("").append(result.data.name);
            }
          });
          //alert(result.data.truck_id);
          var truck_id = result.data.truck_id.split(",");
          $("#equipmentdisp").html("").append(result.data.truck_id);
          $.ajax({
              type:'POST',
              url:LoadBoard.API+'trucker/equipment-list',
              dataType: 'json',
              headers: {
                       Authorization: "Bearer "+LoadBoard.admintoken
                },
              data: JSON.stringify({ 
                "operation":"equipment", 
                "user_id":LoadBoard.userid            
              }),
              contentType: "application/json",

             // data:{operation:"equipment" },
              success:function(result){
                for(i=0;i<result.data.length;i++){
                  //alert(truck_id[i]+' --'+result.data[i]["id"])
                 
                  var  option ='<table"><tr><td>&nbsp;&nbsp;<label>'+result.data[i]["id"]+'</label>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;->&nbsp;&nbsp;<span class="selectgroup-button">'+result.data[i]["truck_name"]+'</span></div></td></tr></table>'; 
                  $("#append_equipment").append(option); 
                  
               }
              }
          });
          table.ajax.reload();
      }
    });


 });
</script>