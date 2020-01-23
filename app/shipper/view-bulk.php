<?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Bulk Upload");
$shipper_user_id= isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
$error_count = $Global->db->prepare( "SELECT COUNT(*)  FROM temp_loads WHERE data_validate_status = 0 AND status=0 AND reload_status = 1 AND user_id = ".$shipper_user_id."");
$error_count->execute();
$error_tol_count = $error_count->fetchColumn(); 

$valid_count = $Global->db->prepare( "SELECT COUNT(*)  FROM temp_loads WHERE data_validate_status = 1 AND status=0 AND reload_status = 1 AND user_id = ".$shipper_user_id."");
$valid_count->execute();
$valid_tol_count = $valid_count->fetchColumn(); 

$error_data = $Global->db->prepare("SELECT shipper.phone,users.name ,users.email,users.business_name,tem.id, tem.user_id, tem.origin, tem.destination, tem.origin_address, tem.origin_city, tem.origin_state, tem.origin_country, tem.origin_zipcode, tem.destination_address, tem.destination_city, tem.destination_state, tem.destination_country, tem.destination_zipcode, to_char(tem.pickup_date,'MM-DD-YYYY') as pickup_date,  to_char(tem.delivery_date,'MM-DD-YYYY') as delivery_date, tem.pickup_time, tem.delivery_time, tem.truck_load_type, tem.weight, tem.length,height, tem.truck_name, tem.price, tem.created_date, tem.created_by, tem.app_type, tem.updated_date, tem.updated_by, tem.data_validate_reason, tem.data_validate_status, tem.reload_status, tem.status, tem.origin_bulk, tem.destination_bulk FROM temp_loads as tem INNER JOIN users ON users.id = tem.user_id INNER JOIN shipper ON shipper.user_id =users.id  WHERE users.user_type='shipper' AND tem.data_validate_status = 0 AND tem.status=0 AND tem.reload_status = 1 AND tem.user_id = ".$shipper_user_id."");
$error_data->execute();
$error_bulk_data = $error_data->fetchAll(PDO::FETCH_ASSOC);
$error_datas = json_encode($error_bulk_data) ;

$contact_inf = $Global->db->prepare("SELECT shipper.phone,users.name ,users.email,users.business_name FROM  users INNER JOIN shipper ON shipper.user_id =users.id  WHERE users.user_type='shipper' AND users.id = ".$shipper_user_id."");
$contact_inf->execute();
$shipper_contact = $contact_inf->fetch(PDO::FETCH_ASSOC);

//$br = json_encode($shipper_contact) ;

//print_r($error_datas);exit;
$valid_data = $Global->db->prepare( "SELECT shipper.phone,users.name ,users.email,users.business_name,tem.id, tem.user_id, tem.origin, tem.destination, tem.origin_address, tem.origin_city, tem.origin_state, tem.origin_country, tem.origin_zipcode, tem.destination_address, tem.destination_city, tem.destination_state, tem.destination_country, tem.destination_zipcode, to_char(tem.pickup_date,'MM-DD-YYYY') as pickup_date,  to_char(tem.delivery_date,'MM-DD-YYYY') as delivery_date, tem.pickup_time, tem.delivery_time, tem.truck_load_type, tem.weight, tem.length,height, tem.truck_name, tem.price, tem.created_date, tem.created_by, tem.app_type, tem.updated_date, tem.updated_by, tem.data_validate_reason, tem.data_validate_status, tem.reload_status, tem.status, tem.origin_bulk, tem.destination_bulk FROM temp_loads as tem INNER JOIN users ON users.id = tem.user_id INNER JOIN shipper ON shipper.user_id =users.id  WHERE users.user_type='shipper' AND tem.data_validate_status = 1 AND tem.status=0 AND tem.reload_status = 1 AND tem.user_id = ".$shipper_user_id."");
$valid_data->execute();
$valid_bulk_results = $valid_data->fetchAll(PDO::FETCH_ASSOC);
$valid_datas = json_encode($valid_bulk_results);

$conditions =array("reload_status" => 2);
$Global->DeleteData("temp_loads",$conditions);
?>
<style type="text/css">
  #HandsontableCopyPaste{
    dispaly:none !important;
  }
  #hot-display-license-info{
    display: none !important;
  }
  .ht_clone_left{
    overflow-y: hidden !important;
    width: auto !important;
  }
  .wtHolder[style] {
  max-height:450px !important; 
  clear:both !important; overflow:auto;  
  scrollbar-width: thin;   
  background:#fff;
   }
  .bulk-up2 { margin-top:10px}
  .count-ok, .count-err  { margin-top:20px; font-size:1.2rem; font-weight:500; }
  .count-ok:before, .count-err:before {font-family: 'FontAwesome' !important; font-size:1.5rem;  padding-right:5px;}
  .count-ok:before {content: "\f00c"; }
  .count-ok {color:#396708}
  .count-ok span, .count-err span  { font-size:1.3rem;  }
  .count-err:before {content: "\f071" ;  }
  .count-err { color:#d72800;}
  .page-count, .success-count  { padding-top:10px; }
   .handsontableInputHolder {
    position: absolute;
}

.handsontableInput {
    border: none;
    outline-width: 0;
    margin: 0;
    padding: 1px 5px 0;
    font-family: inherit;
    line-height: 21px;
    font-size: inherit;
    box-shadow: inset 0 0 0 2px #5292f7;
    resize: none;
    display: block;
    color: #000;
    border-radius: 0;
    background-color: #fff;
}
.loader-line {
  position: absolute;
  top: 50%;
  left: 48%;
}

.loader-li.active{
  display: block !important;
}

.line {
  animation: expand 1s ease-in-out infinite;
  border-radius: 10px;
  display: inline-block;
  transform-origin: center center;
  margin: 0 3px;
  width: 2px;
  height: 25px;
}

.line:nth-child(1) {
  background: #27ae60;
}

.line:nth-child(2) {
  animation-delay: 180ms;  
  background: #f1c40f;
}

.line:nth-child(3) {
  animation-delay: 360ms;
  background: #e67e22;
}

.line:nth-child(4) {
  animation-delay: 540ms;
  background: #2980b9;
}

@keyframes expand {
  0% {
    transform: scale(1);
  }
  25% {
    transform: scale(2);
  }
}
.loader-li {
    background: #00000057;
    z-index: 99999;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    position: absolute;
    overflow: hidden !important;
    display: none;
}
.dgrid-title{
  padding: 0rem 0rem 1rem !important;
}

.padding-div{
    padding: 20px !important;
    background: #fff;
}
.page-count, .success-count{
  justify-content: flex-end;
}
.page-count a , .success-count a{
    color: #ced4da;
    border: 1px solid #dee2e6;
}
.wtBorder.area, .wtBorder.current{
  background-color: transparent !important;
}
.error{
  color:#d72800;
}
</style>
<div class="loader-li">
   <div class="loader-line">
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
      <div class="line"></div>
   </div>
</div>
<div class="my-3 my-md-5">
   <div class="container">
      <div class="page-header">
         <h1 class="page-title">
            <i class="fe fe-upload-cloud  mr-2"></i> Bulk Upload  <a href="#" class="help "><i class="fa fa-question-circle" data-toggle="tooltip" title="help" data-original-title="help"></i></a> 
         </h1>
      </div>
      <div class="alert alert-primary">
         <bold>Note:</bold>
         If you accidentally close the page meanwhile changing the error data it will continue from what are the changes you made until you have click the save button.
      </div>
      <div class="">
         <div class="count-err" style="display:<?php echo ($error_tol_count==0)?  'none' :  'block';?>"><label>Error Count : <span><?php echo $error_tol_count;?> </span></label></div>
         <div class="table-responsive" style="">
            <div class="card padding-div" id="error-t" style="display:<?php echo ($error_tol_count==0)?  'none' :  'block';?>">
               <h3 class="dgrid-title"> Error Data </h3>
               <div id="example"></div>
               <div class="page-count"></div>
            </div>
            <div class="count-ok" style="display:<?php echo ($valid_tol_count==0)?  'none' :  'block';?>"><label>Success Count : <span><?php echo $valid_tol_count;?> </span></label></div>
            <div class="card padding-div" id="success-t" style="display:<?php echo ($valid_tol_count==0)?  'none' :  'block';?>">
               <h3 class="dgrid-title"> Success Data </h3>
               <div id='example1'></div>
               <div class="success-count"> </div>
            </div>
          <div class="my-3 my-md-5">
   <div class="container">
      <div class="page-header">
         <h1 class="page-title"> Load Contact Information</h1>
      </div>
      <div class="col-sm-12 col-md-12">
                           <div class="form-group"><a href="JavaScript:void(0);" id="getdetail"><u>Get Contact Detail from My Profile</u></a></div>
                        </div>
      <div class="row   row-deck">
         <div class="col-md-12 col-sm-12">
            <div class="col-sm-4 col-md-4">
               <div class="form-group">
                  <label class="form-label">Name</label>
                  <input type="text" id="shipper_name" name="shipper_name" class="form-control" placeholder="">
                  <label id="shipper_name-error" class="shipper_name" for="shipper_name" style="display:none;"></label>
               </div>
            </div>
            <div class="col-sm-4 col-md-4">
               <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="text" id="shipper_email" name="shipper_email" class="form-control" placeholder="">
                  <label id="shipper_name-error" class="shipper_email" for="shipper_email" style="display:none;"></label>
               </div>
            </div>
            <div class="col-sm-4 col-md-4">
               <div class="form-group">
                  <label class="form-label">Phone</label>
                  <input type="text" id="shipper_phone" name="shipper_phone" class="form-control" placeholder="">
                  <label id="shipper_name-error" class="shipper_phone" for="shipper_phone" style="display:none;"></label>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-12 col-md-12 error"></div>
   </div>
</div>
            <div class=" my-md-5 text-center ">     
               <button type="button" name="save" class="btn btn-primary disbulk " ><i class="fe fe-save mr-2"></i> Save your loads</button>   
               <button type="button" id="re_home" name="" class="btn btn-primary" ><i class="fe fe-alert-circle mr-2"></i> I will save later</button>   
               <button type="button" id="new_load" name="" class="btn btn-primary" ><i class="fe fe-x-circle mr-2"></i> Cancel</button>  
            </div>
         </div>
      </div>
   </div>
</div>
<button type="button" class="btn btn-primary hidden bulk_confirm">Yes</button>
<?php $Global->Footer(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/handsontable.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/font.css">
<!-- <link rel="stylesheet" type="text/css" href="https://handsontable.com/docs/7.1.0/components/handsontable/dist/handsontable.full.min.css
">
-->
<script type="text/javascript">
  $(document).ready(function(){
   /* var name=<?php echo($shipper_contact['name']);?>;
    var phone=<?php echo($shipper_contact['phone']);?>;
    var email=<?php echo($shipper_contact['email']);?>;
    $("#shipper_name").val(jsUcfirst(name));
    $("#shipper_email").val(email);
    $("#shipper_phone").val(formatPhoneNumber(phone));*/

/*     $.ajax({
      type: 'post',
      url: LoadBoard.API+'shipper/get-profile',
      dataType: "json",
     // data:{user_id:LoadBoard.userid,token:LoadBoard.token},
      headers: {
                 Authorization: "Bearer "+LoadBoard.token
                },
        data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
            }),
      async:false,
      success: function (result) { 
          if(result.status==1){
              $("#shipper_name").val(jsUcfirst(result.data.name));
              $("#business_name").val(result.data.business_name);
              $("#shipper_email").val(result.data.email);
              $("#shipper_phone").val(formatPhoneNumber(result.data.phone));
          }else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   

          }
         
        

      }
  }); */ 
  $('#getdetail').click(function(){
    $.ajax({
      type: 'post',
      url: LoadBoard.API+'shipper/get-profile',
      dataType: "json",
     // data:{user_id:LoadBoard.userid,token:LoadBoard.token},
      headers: {
                 Authorization: "Bearer "+LoadBoard.token
                },
        data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
            }),
        contentType: "application/json",
      async:false,
      success: function (result) { 
          if(result.status==1){
              $("#shipper_name").val(jsUcfirst(result.data.name));
              $("#business_name").val(result.data.business_name);
              $("#shipper_email").val(result.data.email);
              $("#shipper_phone").val(formatPhoneNumber(result.data.phone));
          }else if(result.status==2){
              window.location.href = LoadBoard.APP+'logout';                   

          }
         
        

      }
  });

  });

  });
var error_table =<?php echo $error_tol_count;?>;
var origin_bulk=[];
var designation_bulk=[];
var valid_table =<?php echo $valid_tol_count;?>; 
var $container = $("#example");
var $parent = $container.parent();
var autosaveNotification;
var ob=[];
var ob1=[];
//$('.disbulk').attr("disabled",true);
let state_valid=function(value, callback) {
var s=value;
if(value == '' || value==null){
     callback(false) ;
}else if(value != ''){
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'shipper/bulk-location-list',
         data:{operation:"state_list_valid",data:value},
         success:function(html){
            html=JSON.parse(html);
            if(html.status == 1){ 
               callback(true) ;
            }else{
               callback(false) ;
            }
         }
     }); 
 }
};
let city_valid=function(value, callback) {
if(value == '' || value==null){
     callback(false) ;
}else if(value != ''){
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'shipper/bulk-location-list',
         data:{operation:"city_list_valid",data:value},
         success:function(html){
            html=JSON.parse(html);
            if(html.status == 1){
               callback(true) ;
            }else{
               callback(false) ;
            }
         }
     }); 
 }
};
let address_valid=function function_name(value, callback) {
   if(value == ''){
       callback(false);
     }else {
         callback(true);
       }
      };
let time_valid =function function_name(value, callback) {
   //if(value == ''){
       callback(true);
        //} 

      };
let truckload_valid=function(value, callback) {
     if(value == ''){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
     }else {
         callback(true);
       }
      };
   let  wgt_valid=function(value, callback) {
     if(value == '' || value==null || value == 0){
       callback(false);
     }else if (value.toString().length > 6){
       callback(false);
     }else if (!(/^\d*$/.test(value))) {
       callback(false);
     }
     else {
       callback(true);
     }
  };
   let  len_valid=function(value, callback) {
     if(value == '' || value==null || value == 0){
       callback(false);
     }else if (value.toString().length > 3){
       callback(false);
     }else if (!(/^\d*$/.test(value))) {
         callback(false);
      }else {
         callback(true);
      }
      };
   let  heig_valid=function(value, callback) {
     if(value == '' || value==null || value==0){
       callback(false);
     }else if (value.toString().length > 3){
       callback(false);
     }else if (!(/^\d*$/.test(value))) {
         callback(false);
       }else {
         callback(true);
       }
      };
   let  eqmt_valid= function(value, callback) {
     if(value == '' || value==null){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
      }else {
         callback(true);
      }
    };
    let  price_valid =  function(value, callback) {
     if(value == '' || value==null || value==0){
       callback(false);
      }else if (value.toString().length > 6){
       callback(false);
     }else if (!(/^\d*$/.test(value))) {
         callback(false);
       }else {
         callback(true);
       }
  };
  let  name_valid =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/.test(value))) {
  callback(true);
  }else {
  callback(true);
  }
  };

  /*let  busi_name_valid =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/.test(value))) {
  callback(true);
  }else {
  callback(true);
  }
  };*/
  let  email_valid =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value))) {
  callback(false);
  }else {
  callback(true);
  }
  };
let pickupdatef_valid=function(value, callback){
  var escaped = Handsontable.helper.stringify(value);
  var indate=this.instance.getDataAtRowProp(this.row, 'delivery_date');
  var checkdatevalid=isValidDate(value);
    if(checkdatevalid==false){ 
      callback(false);
    } else if(escaped!=null && escaped!=''){
      var date = new Date();
      date.setHours(0,0,0,0);
      var date1 = new Date(escaped);
      comingdate = date1.getTime();
      currentdate=date.getTime();
      if(comingdate>=currentdate || currentdate==comingdate){
         callback(true);
      }else{
        callback(false);
      }
   }else{
      callback(false);
    }
};

let deliverydatef_valid=function(value, callback){
    var escaped = Handsontable.helper.stringify(value);
    var indate=this.instance.getDataAtRowProp(this.row, 'pickup_date');
    var checkdatevalid=isValidDate(value);
   if(checkdatevalid==false){
      callback(false);
   }else if(indate!='' && escaped!='' &&  escaped!=null && indate!=null){
      var date1 = new Date(indate);
      var date2 = new Date(escaped);
      var date3 = new Date();
      date3.setHours(0,0,0,0);
      c1 =date1.getTime();
      c2=date2.getTime();
      c3=date3.getTime();
        if(c2<c1 || c2<c3){
            callback(false);
        }else if(c2 == c1){
            callback(true);
        }else{
            callback(true);
        }
  }else{
    callback(false);
  }
}
if(error_table>0){
ob=<?php echo $error_datas;?>;
 for(var i=0;i<ob.length;i++){
        safeHtmlRenderer(ob[i]['origin_bulk'],ob[i]['id'],'origin');
        safeHtmlRenderer(ob[i]['destination_bulk'],ob[i]['id'],'destination');
   }
handsontable = new Handsontable(document.getElementById('example'), {
  colWidths: 150,
  rowHeaders: true,
  colHeaders: true,
  fixedColumnsLeft: 5,
  contextMenu: true,
  width: '100%',
  height: 'auto',
  rowHeights: 23,
  manualColumnFreeze: true,
  columns: [{
         data: 'id',
         type:'text'
       },
       {
         data: 'origin_address',
         type: 'text',
         validator: address_valid,
       },
        {
         data: 'origin_bulk',
       ///  renderer: safeHtmlRenderer,
         type: 'text',   
         editor: false,
       },
        {
         data: 'destination_address',
         type: 'text',
         validator: address_valid,
       },
         {
         data: 'destination_bulk',
        // renderer: DessafeHtmlRenderer,
         type: 'text', 
         editor: false,

       },
       {
         data: 'origin_city',
         type:"text",
         validator:city_valid, 
          
       },
       {
         data: 'origin_state',
         type: 'text',
         validator: state_valid
       },
       {
         data: 'destination_city',
         type: 'text',
         validator:city_valid,
       },
       {
         data: 'destination_state',
         type: 'text',
         validator: state_valid
       },
       {
         data: 'pickup_date',
         type: 'text',
         validator:pickupdatef_valid
       },
       {
         data: 'pickup_time', 
         type: 'time',
         timeFormat: 'h:mm a',
         correctFormat: true,
         allowEmpty:true,
          editor: false
       },
       {
         data: 'delivery_date',
         type: 'text',
         validator:deliverydatef_valid,
       },
       {
         data: 'delivery_time', 
         type: 'time',
         timeFormat: 'h:mm a',
         correctFormat: true,
         allowEmpty:true,
         editor: false


        // validator: time_valid,
        
       },
       {
         data: 'truck_load_type',
         type: 'text',
         validator: truckload_valid,

       },
       {
         data: 'weight',
         validator: wgt_valid,
       },
       {
         data: 'length',
         validator: len_valid,
       },
        {
         data: 'height',
         validator: heig_valid,
       }, 
       {
         data: 'truck_name',
         type: 'text',
         validator: eqmt_valid,
       },
       {
         data: 'price', 
         type: 'numeric',   
         numericFormat: {pattern: '$ 0,0.00'},
         validator: price_valid ,
       },
        /*{
         data: 'name',
         type: 'text',
         editor: true,
         validator: name_valid,
         },*/
        /*{
         data: 'business_name',
         type: 'text',
         editor: true,
         validator: busi_name_valid,
       },*/ 
      /* {
         data: 'email',
         type: 'text',
         editor: true,
         validator:email_valid,
       }, 
       {
         data: 'phone',
         type: 'text',
         editor: true,
      
       },*/
   ],
startRows: 8,
startCols: 6,
copyPaste: false,

// rowHeaders: true,
colHeaders: [
           'ID',
           'FROM ADDRESS',
           'FROM LATLAN',
           'TO ADDRESS',
           'TO LATLAN',
           'FROM CITY',
           'FROM STATE',
           'TO CITY',
           'TO STATE',
           'PICKUP DATE',
           'PICKUP TIME',
           'DELIVERY DATE',
           'DELIVERY TIME',
           'TRUCKLOAD TYPE',
           'WEIGHT',
           'LENGTH',
           'HEIGHT',
           'EQUIPMENT',
           'PRICE',
          /* 'NAME',
           'EMAIL',
           'PHONE'*/
          ],
  hiddenColumns: {
    columns: [0,2,4],
    indicators: false
  },
minSpareRows: 0,
contextMenu: true,
onBeforeChange: function (data) {
     for (var i = data.length; i >= 0; i--) {
    

     }
},
afterChange: function (change, source) {
   if (source === 'loadData') {
     return; 
   }
   let r=change[0][0];
   let c=change[0][1];
   let v=change[0][3];
    // if(c=='pickup_date'){  
    //    handsontable.setDataAtCell(r,9,pickupdatef(v));
    // }
    // if(c=='delivery_date'){  
    //    handsontable.setDataAtCell(r,11,pickupdatef(v));
    // }

    handsontable.validateRows([r], (valid) => {
      if (valid) {
        let id=handsontable.getDataAtCell(r,'id');
        tableData=handsontable.getSourceDataAtRow(r);
        tableData['origin_bulk']= origin_bulk[id];
        tableData['destination_bulk']=designation_bulk[id];
        ob1.push(tableData);
        ob.splice(r, 1); 
        error_table--;
        if(valid_table==0){
          valid_table++;
          validDataTable();
          showData(handsontable1,ob1,1);
          $(".preloader").show();
          setTimeout(function(){
              $(".preloader").hide();
              $('#success-t').trigger('click');
          },1000);
       
        }else{
          handsontable1.loadData(ob1);
        }
        if(ob.length==0){
          $('#error-t').hide();
          $('.count-err').hide();
          handsontable.destroy();
        }else{
          showData(handsontable,ob,1);
          $('#error-t').show();
        }

        $('.count-ok').html('<label>Success Count : <span>'+ob1.length+'</span></label>')
        $('.count-ok').show();
        $('#success-t').show();
        $('.count-err').html('<label>Error Count : <span>'+ob.length+'</span></label>');
        updateTableStatus(id);  
      }
    });
},
  

afterValidate: function (isValid, value,row,prop, source) {
   col=handsontable.propToCol(prop);
   if(source=='undefined' || source==undefined){
      return;
   }else if(source=='validateCells' && isValid == true && value != ''){
      handsontable.setCellMeta(row,col,'editor',false);
   }else if (isValid == true && value != '') {
     let id=handsontable.getDataAtCell(row,'id');
     let datt={
        id:id,
        field:prop,
        value:value
     };
     $.ajax({
        url: LoadBoard.API+'shipper/bulk-view-change',
        type:'post',
        data:datt,
        success:function(res){
            return false;
        }
     });
    }
  },
  afterRenderer:function(td, row, col, prop, value, cellProperties){
   //handsontable.setDataAtCell(row,col,value);
  }
});
    var len=Math.ceil(ob.length/10);
    if(len > 1){
      for(i=1;i<=len;i++){
        if(i==1){
          $('.page-count').append('<a href="javascript:;" class="page-l active" data-id="'+i+'">'+i+'</a>');
        }else{
          $('.page-count').append('<a href="javascript:;" class="page-l" data-id="'+i+'">'+i+'</a>');
      }
      }
      if(len>0){
        $('.page-count').prepend('<a href="javascript:;" class="prev" data-id="1">Pervious</a>');
        $('.page-count').append('<a href="javascript:;" class="next" data-id="1">Next</a>');
      }
    }
    showData(handsontable,ob,1);
}

/*-----------------------------------------------------*/

var $container1 = $("#example1");
var $parent1 = $container1.parent();
var autosaveNotification;

let state_valid1 =function(value, callback) {
var s=value;
if(value == '' || value==null){
     callback(false) ;
}else if(value != ''){
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'shipper/bulk-location-list',
         data:{operation:"state_list_valid",data:value},
         success:function(html){
            html=JSON.parse(html);
           if(html.status == 1){
               callback(true) ;
            }else{
               callback(false) ;
            }
         }
     }); 
 }
};
let city_valid1 =function(value, callback) {

if(value == '' || value==null){
     callback(false) ;
}else if(value != ''){
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'shipper/bulk-location-list',
         data:{operation:"city_list_valid",data:value},
         success:function(html){

            var html=JSON.parse(html);
            if(html.status == 1){
               callback(true) ;
            }else{
               callback(false) ;
            }
         }
     }); 
 }
};
let address_valid1 =function function_name(value, callback) {
   if(value == ''){
       callback(false);
     }else {
         callback(true);
       }
      };
   let time_valid1  =function function_name(value, callback) {
   if(value != ''){
       callback(true);
        }
      };
   

let truckload_valid1 =function(value, callback) {
     if(value == ''){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
   let  wgt_valid1 =function(value, callback) {
     if(value == '' || value=='null'){
       callback(false);
     }else if(value.length >6){
       callback(false);
     }else if (/^[-+]?[0][0-6]+$/.test(value)){
       callback(false);
     }else if (/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }
     else {
         callback(true);
       }
      };
   let  len_valid1 =function(value, callback) {
     if(value == '' || value=='null'){
       callback(false);
     }else if(value.length >3){
       callback(false);
     }else if (/^[-+]?[0][0-2]+$/.test(value)){
       callback(false);
     }else if (/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
    }else {
         callback(true);
    }
  };
    let  heig_valid1=function(value, callback) {
     if(value == '' || value=='null'){
       callback(false);
     } if(value == 0){
       callback(false);
     }else if(value.length >2){
       callback(false);
     }else if (/^[-+]?[0][0-2]+$/.test(value)){
       callback(false);
     }else if (/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
   let  eqmt_valid1= function(value, callback) {
     if(value == '' || value=='null'){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
    let  price_valid1  =  function(value, callback) {
     if(value == '' || value=='null'){
       callback(false);
     }else if(value.length >6){
       callback(false);
     }else if (/^[-+]?[0][0-6]+$/.test(value)){
       callback(false);
     }else if (/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
      let  name_valid1 =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/.test(value))) {
  callback(true);
  }else {
  callback(true);
  }
  };

 /* let  busi_name_valid1 =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/.test(value))) {
  callback(true);
  }else {
  callback(true);
  }
  };*/
  let  email_valid1 =  function(value, callback) {
  if(value == '' || value==null || value==0){
  callback(false);
  }else if (!(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value))) {
  callback(false);
  }else {
  callback(true);
  }
  };
if(valid_table>0){
  ob1=<?php echo $valid_datas;?>;
  validDataTable();
   showData(handsontable1,ob1,1);
   for(var i=0;i<ob1.length;i++){
        ArrayHtmlRenderer(ob1[i]['origin_bulk'],i,'origin');
       ArrayHtmlRenderer(ob1[i]['destination_bulk'],i,'destination');
   }
}

function validDataTable(){
handsontable1=new Handsontable(document.getElementById('example1'),{
rowHeaders: true,
colHeaders: true,
colWidths: 150,
fixedColumnsLeft: 5,
contextMenu: true,
width: '100%',
height: 'auto',
manualColumnFreeze: true,
rowHeaderWidth:'auto',
columns: [{
         data: 'id',
         type: 'text',
       },
       {
         data: 'origin_address',
         type: 'text',
        // validator: address_valid1,
         editor: false,
       },
        {
         data: 'origin_bulk',
         //renderer: ExsafeHtmlRenderer,
         type: 'text',
         editor: false,

       },

       {
         data: 'destination_address',
         editor: false,
         type: 'text',
       ///  validator: address_valid1,
       },
       {
         data: 'destination_bulk',
        // renderer: ExDessafeHtmlRenderer,
         type: 'text',  
         editor: false,

       },
       {
         data: 'origin_city',
         type:"text",
        // validator:city_valid1,
         editor: false, 
          
       },
       {
         data: 'origin_state',
         type: 'text',
         //validator: state_valid1,
         editor: false,
       },
       {
         data: 'destination_city',
         type: 'text',
       //  validator:city_valid1,
         editor: false,
       },
       {
         data: 'destination_state',
         type: 'text',
        // validator: state_valid1,
         editor: false,
       },
       {
         data: 'pickup_date',
         type: 'text',
         editor: false
        // dateFormat: 'MM/DD/YYYY',
        // correctFormat: true

       },
       {
         data: 'pickup_time', 
         type: 'time',
         timeFormat: 'h:mm a',
         correctFormat: true,
         allowEmpty:true,

       //  validator: time_valid,
        editor: false
         
       },
       {
         data: 'delivery_date',
         type: 'text',
         editor: false
         //dateFormat: 'MM/DD/YYYY',
         //correctFormat: true
       // editor: false,
       },
       {
         data: 'delivery_time', 
         type: 'time',
         timeFormat: 'h:mm a',
         correctFormat: true,
         //validator: time_valid,
         editor: false,
         allowEmpty:true

        
       },
       {
         data: 'truck_load_type',
         type: 'text',
       //  validator: truckload_valid1,
         editor: false,

       },
       {
         data: 'weight',
       //  validator: wgt_valid1,
         editor: false,
       },
       {
         data: 'length',
       //  validator: len_valid1,
         editor: false,
       },
       {
         data: 'height',
      //   validator: heig_valid1,
         editor: false,
       },
       {
         data: 'truck_name',
         type: 'text',
        // validator: eqmt_valid1,
         editor: false,
       },
       {
         data: 'price', 
         type: 'numeric',   
         numericFormat: {pattern: '$ 0,0.00'},
       //  validator: price_valid1 ,
         editor: false,
       },
      /* {
         data: 'name',
         type: 'text',
         editor: false,
         validator:name_valid1,
         },
        {
         data: 'business_name',
         type: 'text',
         editor: false,
         validator:busi_name_valid1,
       }, 
       {
         data: 'email',
         type: 'text',
         editor: false,
         validator:email_valid1,
       }, 
       {
         data: 'phone',
         type: 'numeric',
         editor: false,
      
       },*/


   ],
startRows: 8,
startCols: 6,
copyPaste: false,

// rowHeaders: true,
colHeaders: [
          'ID',
           'FROM ADDRESS',
           'FROM LATLAN',
           'TO ADDRESS',
           'TO LATLAN',
           'FROM CITY',
           'FROM STATE',
           'TO CITY',
           'TO STATE',
           'PICKUP DATE',
           'PICKUP TIME',
           'DELIVERY DATE',
           'DELIVERY TIME',
           'TRUCKLOAD TYPE',
           'WEIGHT',
           'LENGTH',
           'HEIGHT',
           'EQUIPMENT',
           'PRICE',
          /* 'NAME',
          // 'BUSINESS NAME',
           'EMAIL',
           'PHONE'*/
          ],
   hiddenColumns: {
     columns: [0,2,4],
    indicators: false
  },
minSpareRows: 0,
contextMenu: true,
onBeforeChange: function (data) {
     for (var i = data.length; i >= 0; i--) {
    //   console.log(data[i]);
      // console.log('poop');

     }
},
afterChange: function (change, source) {
   if (source === 'loadData') {
     return; 
   }
   if($parent1.find('input[name=autosave]').is(':checked')) {
     clearTimeout(autosaveNotification);
     $.ajax({
     //  url: "json/save.json",
       dataType: "json",
       type: "POST",
       data: change, //contains changed cells' data
       complete: function (data) {
         $console.text('Autosaved (' + change.length + ' cell' + (change.length > 1 ? 's' : '') + ')');
         autosaveNotification = setTimeout(function () {
           $console.text('Changes will be autosaved');
         }, 1000);
       }
     });
   }
},
afterValidate: function (isValid, value,row,prop, source) {
   col=handsontable1.propToCol(prop);
   if (isValid == true && value != '') {
     handsontable1.setCellMeta(row,col,'editor',false);
    }
}
});
    var len1=Math.ceil(ob1.length/10);
    if(len1 > 1){
      for(i=1;i<=len1;i++){
        if(i==1){
          $('.success-count').append('<a href="javascript:;" class="page-r active" data-id="'+i+'">'+i+'</a>');
        }else{
          $('.success-count').append('<a href="javascript:;" class="page-r" data-id="'+i+'">'+i+'</a>');
        }
      }
      if(len1>0){
        $('.success-count').prepend('<a href="javascript:;" class="prev1" data-id="1">Pervious</a>');
        $('.success-count').append('<a href="javascript:;" class="next1" data-id="1">Next</a>');
      }
    }
}
$('button[name=save]').click(function (e) {
  let tableData=[];
  if(error_table>0){
        tableData=handsontable.getData();
    }
  var totRow=tableData.length;
  valid=1;
  if(totRow > 0){
    for(var i=0; i<totRow; i++)
   {
    handsontable.validateRows([i], (valid) => {
      if (!valid) {
        valid=0;
        ob[i]=tableData[i];
        toastr.remove();
        toastr.options = { 
                            "progressBar": true,
                            "positionClass": "toast-top-full-width",
                            "timeOut": "2000",
                            "extendedTimeOut": "1000",
                          }
        toastr.error('Please provide valid data');
      //  $('.disbulk').attr("disabled", true); 
        return false;
      }
        let id=tableData[i][0];
        let list=ob.filter(function (i,n){
           if(n.id===id){
              tableData[i]['origin_bulk']=origin_bulk[id];
              tableData[i]['designation_bulk']=designation_bulk[id];
              ob[i]=tableData[i];
           }
           return 1;
        });
         if(valid==1 && (i+1)==totRow){
            swal.fire({
              title: "Confirmation!",
              text: "Confirm Add Load",
              type: 'info',
              showCancelButton: true,
              confirmButtonText: 'Yes',
              cancelButtonText: 'No',
              confirmButtonClass: 'btn-md',
              cancelButtonClass: 'btn-md',
              allowOutsideClick:false,
            }).then(result => {
              if(result.value){
                 bulk_confirm();
              }else{
                return false;
              }
          });
        }
    });
  }} else{
      swal.fire({
        title: "Confirmation!",
        text: "Confirm Add Load",
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn-md',
        cancelButtonClass: 'btn-md',
        allowOutsideClick:false,
      }).then(result => {
        if(result.value){
           bulk_confirm();
        }else{
          return false;
        }
    });
  }
});


function bulk_confirm(){
    $('.error').html();
    if($('#shipper_name').val()=='' || $('#shipper_email').val() =='' || $('#shipper_phone').val()==''){
       $('.error').html('Please Enter the contact Details.')
       return false; 
    }

   if(error_table>0 && valid_table>0){
          var data= $.merge( ob, ob1);
      }else if(error_table>0){
        tableData=handsontable.getData();
         var data= ob;
      }else if(valid_table>0){
        var data= ob1;
      }
      $('.disbulk').attr("disabled", true); 
   //   console.log(data);
      $.ajax({
         url: LoadBoard.API+"shipper/bulk-view-data",
         type: 'POST',
        // async:false,
         data: {"data": data,"shipper_name":$("#shipper_name").val(),"shipper_email":$("#shipper_email").val(),"shipper_phone":$("#shipper_phone").val()}, //returns all cells' data
         dataType: 'json',
         beforeSend:function(){
           $(".preloader").show();
         },
         success: function (result) {
            $(".preloader").hide();
            $('.disbulk').attr("disabled", false);
            if(result.status==1){ 
              toastr.success(result.msg);
              window.location.href=LoadBoard.APP+"shipper/loads";
            }else if(result.status==0){
                toastr.error(result.msg);                
                return false;
            }
         }
     }); 
}

$parent1.find('input[name=autosave]').click(function () {
if ($(this).is(':checked')) {
   $console.text('Changes will be autosaved');
  }
else {
   $console.text('Changes will not be autosaved');
}
});

$(document).on('click','.page-l',function(){
    $('.page-l').removeClass('active');
    var p=$(this).data('id');
    $('.prev').data('id',p);
    $('.next').data('id',p);
    $(this).addClass('active');
    showData(handsontable,ob,p);
});

$(document).on('click','.page-r',function(){
    $('.page-r').removeClass('active');
    var p=$(this).data('id');
    $('.prev1').data('id',p);
    $('.next1').data('id',p);
    $(this).addClass('active');
    showData(handsontable1,ob1,p);
});

$(document).on('click','.prev',function(){
    var p=$(this).data('id');
    v=parseInt(p)-1;
    if(p>1){
      showData(handsontable,ob,v); 
      $('.page-l').removeClass('active');
      $('.page-l[data-id="'+v+'"]').addClass('active');
      $('.prev').data('id',v);
      $('.next').data('id',v);
    }
});

$(document).on('click','.next',function(){
    var p=$(this).data('id');
    v=parseInt(p)+1;
    if(p<len){
      showData(handsontable,ob,v); 
      $('.page-l').removeClass('active');
      $('.page-l[data-id="'+v+'"]').addClass('active');
      $('.prev').data('id',v);
      $('.next').data('id',v);
    }
});

$(document).on('click','.prev1',function(){
    var p=$(this).data('id');
    v=parseInt(p)-1;
    if(p>1){
      showData(handsontable1,ob1,v); 
      $('.page-r').removeClass('active');
      $('.page-r[data-id="'+v+'"]').addClass('active');
      $('.prev1').data('id',v);
      $('.next1').data('id',v);
    }
});

$(document).on('click','.next1',function(){
    var p=$(this).data('id');
    v=parseInt(p)+1;
    if(p<len1){
      showData(handsontable1,ob1,v); 
      $('.page-r').removeClass('active');
      $('.page-r[data-id="'+v+'"]').addClass('active');
      $('.prev1').data('id',v);
      $('.next1').data('id',v);
    }
});




function showData(element,data,page){
   let e=page*10;
   let l=e-10;
   let arr=data.slice(l,e);
   element.loadData(arr);
   element.validateCells(function(valid) {});
}
/*$('.loader-li').addClass('active');
$('.my-md-5').hide();
setTimeout(function () {
$('.loader-li').removeClass('active');
$('.my-md-5').show();
},2000)*/

// function ExsafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {

//   var escaped = Handsontable.helper.stringify(value);
//   var quote_str =  "'" + escaped + "'";
//    var id= instance.getDataAtCell(row,0);
//   if(escaped!=''){
//     var geocoder = new google.maps.Geocoder();
//     geocoder.geocode( { 'address': escaped}, function(results, status) {
//     if (status == google.maps.GeocoderStatus.OK) {
//         var latitude = results[0].geometry.location.lat();
//         var longitude = results[0].geometry.location.lng();
//        var lm = latitude+","+longitude;
//         td.innerHTML=lm;
//         origin_bulk[id]=lm;
//         return td;
//        } 
//     }); 
//  }
// }

function ArrayHtmlRenderer(value,index,type) {
    var geocoder = new google.maps.Geocoder();
    var lm='';
    geocoder.geocode( { 'address': value}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        lm = latitude+","+longitude;
        if(type=='origin'){
          ob1[index]['origin_bulk']=lm;
        }if(type=='destination'){
           ob1[index]['destination_bulk']=lm;
        }
       }
    });
}

function safeHtmlRenderer(value,id,type) {
    var geocoder = new google.maps.Geocoder();
    var lm='';
    geocoder.geocode( { 'address': value}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        lm = latitude+","+longitude;
        if(type=='origin'){
          origin_bulk[id]=lm;
        }if(type=='destination'){
           designation_bulk[id]=lm;
        }
       }
    });
}

// function DessafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {
//   var escaped = Handsontable.helper.stringify(value);
//   var quote_str =  "'" + escaped + "'";
//   var id= instance.getDataAtCell(row,0);
//   if(escaped!=''){
//     var geocoder = new google.maps.Geocoder();
//     geocoder.geocode( { 'address': escaped}, function(results, status) {
//     if (status == google.maps.GeocoderStatus.OK) {
//         var latitude = results[0].geometry.location.lat();
//         var longitude = results[0].geometry.location.lng();
//         var lm = latitude+","+longitude;
//         td.innerHTML=lm;
//         designation_bulk[id]=lm;
//         return td;
//        } 
//     }); 
//  }
// }

// function ExDessafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {
//   var escaped = Handsontable.helper.stringify(value);
//   var quote_str =  "'" + escaped + "'";
//    var id= instance.getDataAtCell(row,0);
//   if(escaped!=''){
//     var geocoder = new google.maps.Geocoder();
//     geocoder.geocode( { 'address': escaped}, function(results, status) {
//     if (status == google.maps.GeocoderStatus.OK) {
//         var latitude = results[0].geometry.location.lat();
//         var longitude = results[0].geometry.location.lng();
//         var lm = latitude+","+longitude;
//         td.innerHTML=lm;
//         designation_bulk[id]=lm;
//         return td;
//        } 
//     }); 
//  }
// }

function pickupdatef(value) {
    var d = new Date(value);
    var mm=d.getMonth()+1;
    var m=(mm < 10) ? '0'+mm : mm;
    var y=(d.getDate()> 10) ? d.getDate() : '0'+d.getDate();
    var dt=m+"-"+y+"-"+d.getFullYear();
     return dt;
}

function isValidDate(date)
{
    var matches = /^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/.exec(date);
    if (matches == null) return false;
    var d = matches[2];
    var m = matches[1] - 1;
    var y = matches[3];

    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
}

function updateTableStatus(id){
   let datt={
      id:id,
      field:'data_validate_status',
      value:'1'
   };
   if(id!='' && id!=null && id!='undefined' && id!=0){
      $.ajax({
        url: LoadBoard.API+'shipper/bulk-view-change',
        type:'post',
        data:datt,
        success:function(res){
          console.log(datt);
        //  console.log(res);
        }
     });
  }
}
$('#re_home').on('click',function(){
    swal.fire({
        title: "Confirmation!",
        text: "Are you sure to fix it later",
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn-md',
        cancelButtonClass: 'btn-md',
        allowOutsideClick:false,
      }).then(result => {
        if(result.value){
           window.location.href='/loadboard/app/shipper/dashboard'
        }else{
          return false;
        }
    });
});

$('#new_load').on('click',function(){
    swal.fire({
        title: "Confirmation!",
        text: "Do you want to Upload another file?",
        type: 'info',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn-md',
        cancelButtonClass: 'btn-md',
        allowOutsideClick:false,
      }).then(result => {
        if(result.value){
           $.ajax({
            url: LoadBoard.API+'shipper/bulk-view-change',
            type:'post',
            data:{action:'delete'},
            success:function(res){
                 window.location.href='/loadboard/app/shipper/bulk-upload';
            }
          });
        }else{
          return false;
        }
    });
});
function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>



<!-- <script>
$(document).ready(function(){
  $('.btn').popover({title: "<h1><strong>HTML</strong> inside <code>the</code> <em>popover</em></h1>", content: "Blabla <br> <h2>Cool stuff!</h2>", html: true, placement: "right"}); 
});
</script> -->

