 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Bulk Upload");

$shipper_user_id= isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
$data_count = $Global->db->prepare("SELECT COUNT(*) FROM temp_loads WHERE status=0 AND reload_status = 1 AND user_id = ".$shipper_user_id."");
$data_count->execute();
$bulk_data_count = $data_count->fetchColumn(); 

 ?>
<div class="py-3 my-md-5 " >
   <div class="container animated fadeIn">
      <div class="text-center ">
         <h1 class="display-4 my-2 text-primary" >Add Multiple Loads <span class="tool toottip" style="font-weight: normal;" data-tip="Upload multiple loads using excel template" tabindex="1"><i class="fa fa-question-circle-o"></i></span></h1>
         <p>Post loads from CSV Template</p>
      </div>
      <div class="alert alert-info border text-center my-6  p-6 animated bounceInDown" role="alert">
         <div class="avatar avatar-xxl bg-white animated bounce delay-1s">
            <i class="fe fe-cloud text-success " data-toggle="tooltip" ></i>
         </div>
         <form enctype="multipart/form-data" id="myform"> 
             <div class="clear my-4 animated fadeIn delay-1s text-center">
                    <div class="file btn btn-lg btn-primary" role="button" aria-pressed="true"><i class="fe fe-upload-cloud  mr-2"></i> 
                      Upload your CSV  <input type="file" accept=".csv,.xls,.xlsx"  onchange="imageuplaod()" name="inputfile" id="inputfile">
                   </div>
             </div>
       </form>
       <h3 class="my-4" >Download and use the <a href="<?php echo SITEURL; ?>sample-excel/LoadBoard_BulkUpload_Template.xlsx" class="btn btn-link border text-dark my-2 " download><i class="fe fe-download-cloud mr-2"></i>Bulk Upload CSV Template</a> to create your loads list in the specified format.</h3>
         <p id="upload-format">Upload the created CSV file for posting multiple loads simultaneously.</p>
         <p id="upload-format-error" class="error"  style="display: none;"></p>
        
      </div>
   </div>
</div>
<?php $Global->Footer(); ?>
<script type="text/javascript">
  $(document).ready(function(){
     var data_count =<?php echo $bulk_data_count;?>;
    if(data_count != 0){
          swal.fire({
            title: "Confirmation!",
            text: "Do you want to continue this page?",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn-md',
            cancelButtonClass: 'btn-md',
            allowOutsideClick:false,
        }).then(result => {
            if(result.value){
               window.location.href=LoadBoard.APP+'shipper/view-bulk';
            }else{
              return false;
            }
        });
          $("body").removeClass("swal2-height-auto");

    }

     var res_data="";
      // $('.inputfile').change(function(){
                                    
      //  });
  });

  function imageuplaod(){
          var file_data = $('#inputfile').prop('files')[0];   
          var form_data = new FormData();                  
          form_data.append('file', file_data);
          $.ajax({
              type: "POST",
              url: LoadBoard.API+'shipper/bulk_api',
              data: form_data,
              contentType: false,
              cache: false,
              processData:false,
              dataType:"json",
              beforeSend:function(){
                $(".preloader").show();
              },
              success: function(result){
               
                 if(result.status==1){
                  $(".preloader").hide();
                  toastr.success(result.msg);
                     window.location.href=LoadBoard.APP+"shipper/view-bulk";
                  }else if(result.status==0){
                    $(".preloader").hide();
                    if(result.msg =='Invalid File Format Upload'){
                      //  $("#upload-format").css("border","1px solid red");
                        $("#upload-format-error").html(result.msg).show();
                    }else if(result.msg =='Invalid file Upload'){
                        $("#upload-format-error").html(result.msg).show();
                    }
                   // toastr.error(result.msg);                
                 }
              }
          }); 
     }

/*  function view_bulkdata(data){
         var Url;
         $.ajax({
            type: 'post',
             dataType:"html",
            url: LoadBoard.APP+"broker/view-bulk-loads",
            data:{data:data},
            success: function (data) {
             
          }
         });        
      }*/
</script>