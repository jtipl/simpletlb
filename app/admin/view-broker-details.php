<?php 
require_once("../../elements/Global.php");
$Global = new LoadBoard();
$Global->AfterAdminloginCheck();
$Global->admin_header("LoadBoard - Trucker List");

$id = isset($_REQUEST['id']) ? $_REQUEST['id']: '';



?>
<style>
.status_changed,.view_status,.edit{cursor: pointer;}
.workflowtable tr td {text-align:left;}
</style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       View Broker Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Broker List</a></li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <div class="box">
            <!-- /.box-header -->
              <div class="box-body">
                <a href="broker-list">
                  Go back
                </a>

            <table class="table table-bordered table-hover workflowtable">
            <tr>
                <th colspan="6"> <h4>Broker Details </h4> </th>
            </tr>
            <tr>
                <th>Name</th>
                <td id="name"></td>
                <th colspan="2">Address</th>
                <td id="address" colspan="2"></td>
            </tr>
            <tr>
                <th>Business Name</th>
                <td id="business_name"></td>
                <th colspan="2">Country</th>
                <td id="country" colspan="2"></td>
            </tr>
            <tr>
                <th>Email</th>
                <td id="email"></td>
                <th colspan="2">State</th>
                <td id="state" colspan="2"></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td id="phone"></td>
                <th colspan="2">City</th>
                <td id="city" colspan="2"></td>
            </tr>
            <tr>
              <th>Zipcode</th>
              <td id="zipcode">

              </td>
            </tr>
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
      url: LoadBoard.API+'admin/broker-get-details?action=get_broker_details',
      dataType: "json",
      data: "id="+id,
      success:function(result){
          //var phone = result.data.phone.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
         // alert(result.data.name)
          $("#name").html("").append(result.data.name);
          $("#business_name").html("").append(result.data.business_name);
          $("#email").html("").append(result.data.email);
          $("#phone").html("").append(phoneFormat(result.data.phone));
          $("#address").html("").append(result.data.address_line1);
          
          $("#license_expiry_dt").html("").append(result.data.vehicle_expiry_date);
          $("#us_dot").html("").append(result.data.vehicle_number);
          $("#weight").html("").append(result.data.vehicle_weight);
          $("#length").html("").append(result.data.vehicle_length);

          $("#bank_name").html("").append(result.data.bank_name);
          $("#bank_acc_no").html("").append(result.data.account_number);
          $("#bank_routing_no").html("").append(result.data.routing_number);

           $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/broker-get-details?action=get_country_details',
            dataType: "json",
            data: "id="+result.data.country,
            success:function(result){
              $("#country").html("").append(result.data.name);
            
            }
          });

          $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/broker-get-details?action=get_state_details',
            dataType: "json",
            data: "state_id="+result.data.state,
            success:function(result){
              $("#state").html("").append(result.data.name);
            }
          });



          $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/broker-get-details?action=get_city_details',
            dataType: "json",
            data: "city_id="+result.data.city,
            success:function(result){
              $("#city").html("").append(result.data.name);
            }
          });

          $("#zipcode").html("").append(result.data.zipcode);
          //alert(result.data.truck_id);
          
          table.ajax.reload();
      }
    });


 });
</script>