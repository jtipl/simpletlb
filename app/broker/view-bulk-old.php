<?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - Bulk Upload");
$broker_user_id= isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
$error_count = $Global->db->prepare( "SELECT COUNT(*)  FROM temp_loads WHERE data_validate_status = 0 AND status=0 AND reload_status = 1 AND user_id = ".$broker_user_id."");
$error_count->execute();
$error_tol_count = $error_count->fetchColumn(); 

$valid_count = $Global->db->prepare( "SELECT COUNT(*)  FROM temp_loads WHERE data_validate_status = 1 AND status=0 AND reload_status = 1 AND user_id = ".$broker_user_id."");
$valid_count->execute();
$valid_tol_count = $valid_count->fetchColumn(); 

$error_data = $Global->db->prepare("SELECT id, user_id, origin, destination, origin_address, origin_city, origin_state, origin_country, origin_zipcode, destination_address, destination_city, destination_state, destination_country, destination_zipcode, to_char(pickup_date,'MM-DD-YYYY') as pickup_date,  to_char(delivery_date,'MM-DD-YYYY') as delivery_date, pickup_time, delivery_time, truck_load_type, weight, length, truck_name, price, created_date, created_by, app_type, updated_date, updated_by, data_validate_reason, data_validate_status, reload_status, status, origin_bulk, destination_bulk FROM temp_loads WHERE data_validate_status = 0 AND status=0 AND reload_status = 1 AND user_id = ".$broker_user_id."");
$error_data->execute();
$error_bulk_data = $error_data->fetchAll(PDO::FETCH_ASSOC);
$error_datas = '[{"id":1123,"user_id":13,"origin":"VictoriaA, Texas, USA","destination":"Boston, Massachusetts, USA","origin_address":"Victoria, TX, USA","origin_city":"VictoriaA","origin_state":"Texas","origin_country":"USA","origin_zipcode":0,"destination_address":"Boston, MA, USA","destination_city":"Boston","destination_state":"Massachusetts","destination_country":"USA","destination_zipcode":0,"pickup_date":"06-27-2019","delivery_date":"06-29-2019","pickup_time":"","delivery_time":"","truck_load_type":"FTL","weight":500,"length":200,"truck_name":"Flatbed","price":"1500","created_date":"2019-07-19 15:47:11.936048","created_by":13,"app_type":"web","updated_date":null,"updated_by":0,"data_validate_reason":"[{\"status\":0,\"msg\":\"Invalid address please provide valid origin city\"}]","data_validate_status":0,"reload_status":1,"status":0,"origin_bulk":"Victoria, TX, USA","destination_bulk":"Boston, MA, USA"},{"id":1124,"user_id":13,"origin":"Issaquah, Washington, USA","destination":"Atlanta, GeorgiaE, USA","origin_address":"Issaquah, WA, USA","origin_city":"Issaquah","origin_state":"Washington","origin_country":"USA","origin_zipcode":0,"destination_address":"Vijay Drive, Atlanta, GA, USA","destination_city":"Atlanta","destination_state":"GeorgiaE","destination_country":"USA","destination_zipcode":0,"pickup_date":"07-26-2019","delivery_date":"06-28-2019","pickup_time":"","delivery_time":"","truck_load_type":"FTL","weight":700,"length":300,"truck_name":"Reefer","price":"5000","created_date":"2019-07-19 15:47:12.052057","created_by":13,"app_type":"web","updated_date":null,"updated_by":0,"data_validate_reason":"[{\"status\":0,\"msg\":\"Invalid address please provide valid destination state\"}]","data_validate_status":0,"reload_status":1,"status":0,"origin_bulk":"Issaquah, WA, USA","destination_bulk":"Vijay Drive, Atlanta, GA, USA"}]' ;
/**/

$valid_data = $Global->db->prepare( "SELECT id, user_id, origin, destination, origin_address, origin_city, origin_state, origin_country, origin_zipcode, destination_address, destination_city, destination_state, destination_country, destination_zipcode, to_char(pickup_date,'MM-DD-YYYY') as pickup_date,  to_char(delivery_date,'MM-DD-YYYY') as delivery_date, pickup_time, delivery_time, truck_load_type, weight, length, truck_name, price, created_date, created_by, app_type, updated_date, updated_by, data_validate_reason, data_validate_status, reload_status, status, origin_bulk, destination_bulk  FROM temp_loads WHERE data_validate_status = 1 AND status=0 AND reload_status = 1 AND user_id = ".$broker_user_id."");
$valid_data->execute();
$valid_bulk_results = $valid_data->fetchAll(PDO::FETCH_ASSOC);
$valid_datas = '[{"id":1122,"user_id":13,"origin":"Reno, Nevada, USA","destination":"Aspen, Colorado, USA","origin_address":"Reno, NV, USA","origin_city":"Reno","origin_state":"Nevada","origin_country":"USA","origin_zipcode":0,"destination_address":"Aspen, CO, USA","destination_city":"Aspen","destination_state":"Colorado","destination_country":"USA","destination_zipcode":0,"pickup_date":"06-26-2019","delivery_date":"06-29-2019","pickup_time":"","delivery_time":"","truck_load_type":"FTL","weight":650,"length":100,"truck_name":"Reefer","price":"1000","created_date":"2019-07-19 15:47:11.816832","created_by":13,"app_type":"web","updated_date":null,"updated_by":0,"data_validate_reason":"[{\"status\":1,\"msg\":\"Successfully\"}]","data_validate_status":1,"reload_status":1,"status":0,"origin_bulk":"Reno, NV, USA","destination_bulk":"Aspen, CO, USA"}]';

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
  .wtHolder[style] {max-height:450px !important; clear:both !important; overflow:auto;  scrollbar-width: thin; background:#e2e2e2; }
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

    <div class="">
        <div class="count-err "><label>Error Count : <span><?php echo $error_tol_count;?> </span></label></div>
        <div class="table-responsive" style="">
           <div id="example"></div>      
           <div class="page-count"></div>
           <div class="count-ok "> <label>Success Count : <span><?php echo $valid_tol_count;?> </span></label></div>
          <div id='example1' ></div>        
          <div class="success-count"> </div>
          <div class=" my-md-5 text-center ">     
              <button type="button" name="save" class="btn btn-primary disbulk " ><i class="fe fe-save mr-2"></i> Save your CSV</button>    
          </div>
        </div>


    </div>
  </div>
</div>

<?php $Global->Footer(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/handsontable.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/font.css">
<!-- <link rel="stylesheet" type="text/css" href="https://handsontable.com/docs/7.1.0/components/handsontable/dist/handsontable.full.min.css
">
-->
<script type="text/javascript">
var error_table =<?php echo $error_tol_count;?>;
var valid_table =<?php echo $valid_tol_count;?>; 
var $container = $("#example");
var $parent = $container.parent();
var autosaveNotification;

let state_valid=function(value, callback) {
var s=value;
if(value == '' || value==null){
     callback(false) ;
}else if(value != ''){
      $.ajax({
         type:'POST',
         url:LoadBoard.API+'broker/location-list',
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
         url:LoadBoard.API+'broker/location-list',
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
     var myval=0;
     if(value==null || value=='null')
       myval=0;
     else
       myval=value;

     if(myval == ''){
       callback(false);
     }else if(myval.length >6){
       callback(false);
     }else if (/^[-+]?[0][0-6]+$/.test(myval)){
       callback(false);
     }else if (/[\'^£$%&*A-Za-z()}{@#~?><>|=_+¬-]/.test(myval)) { 
         callback(false);
       }
     else {
         callback(true);
       }
      };
   let  len_valid=function(value, callback) {
     if(value == ''){
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
   let  eqmt_valid= function(value, callback) {
     if(value == ''){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
    let  price_valid =  function(value, callback) {
     if(value == ''){
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

if(error_table>0){
var ob=<?php echo $error_datas;?>;
handsontable = new Handsontable(document.getElementById('example'), {
  colWidths: 100,
  rowHeaders: true,
  colHeaders: true,
  fixedColumnsLeft: 5,
  contextMenu: true,
  width: '100%',
  height: 480,
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
         renderer: safeHtmlRenderer,
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
         renderer: DessafeHtmlRenderer,
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
         renderer:pickupdatef,
         type: 'text',
         //dateFormat: 'MM/DD/YYYY',
         //correctFormat: true
       },
       {
         data: 'pickup_time', 
         type: 'time',
         timeFormat: 'h:mm a',
         correctFormat: true,
         allowEmpty:true,
        editor: false

        // validator: time_valid,
         
       },
       {
         data: 'delivery_date',
         type: 'text',
         renderer:deliverydatef,
       // dateFormat: 'MM/DD/YYYY',
        // correctFormat: true

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
         data: 'truck_name',
         type: 'text',
         validator: eqmt_valid,
       },
       {
         data: 'price', 
         type: 'numeric',   
         numericFormat: {pattern: '$ 0,0.00'},
         validator: price_valid ,
       }
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
           'EQUIPMENT',
           'PRICE'
          ],
  hiddenColumns: {
    columns: [0],
    indicators: true
  },
minSpareRows: 0,
contextMenu: true,
onBeforeChange: function (data) {
     for (var i = data.length; i >= 0; i--) {
       console.log(data[i]);
       console.log('poop');

     }
},
afterChange: function (change, source) {
   if (source === 'loadData') {
     return; 
   }
   if($parent.find('input[name=autosave]').is(':checked')) {
     clearTimeout(autosaveNotification);
     $.ajax({
       url: "json/save.json",
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
   col=handsontable.propToCol(prop);
   if (isValid == true && value != '') {
     handsontable.setCellMeta(row,col,'editor',false);
    }
}
});
    var len=Math.ceil(ob.length/10);
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
         url:LoadBoard.API+'broker/location-list',
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
         url:LoadBoard.API+'broker/location-list',
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
     if(value == ''){
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
     if(value == ''){
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
   let  eqmt_valid1= function(value, callback) {
     if(value == ''){
       callback(false);
     }else if (/[\'^£$%&*0-9()}{@#~?><>|=_+¬-]/.test(value)) { 
         callback(false);
       }else {
         callback(true);
       }
      };
    let  price_valid1  =  function(value, callback) {
     if(value == ''){
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
if(valid_table>0){
var ob1=<?php echo $valid_datas;?>;
handsontable1=new Handsontable(document.getElementById('example1'),{
rowHeaders: true,
colHeaders: true,
colWidths: 100,
fixedColumnsLeft: 5,
contextMenu: true,
manualColumnFreeze: true,
columns: [{
         data: 'id',
         type: 'text',
       },
       {
         data: 'origin_address',
         type: 'text',
         validator: address_valid1,
         editor: false,
       },
        {
         data: 'origin_bulk',
         renderer: ExsafeHtmlRenderer,
         type: 'text',
         editor: false,

       },

       {
         data: 'destination_address',
         editor: false,
         type: 'text',
         validator: address_valid1,
       },
       {
         data: 'destination_bulk',
         renderer: ExDessafeHtmlRenderer,
          type: 'text',  
         editor: false,

       },
       {
         data: 'origin_city',
         type:"text",
         validator:city_valid1,
         editor: false, 
          
       },
       {
         data: 'origin_state',
         type: 'text',
         validator: state_valid1,
         editor: false,
       },
       {
         data: 'destination_city',
         type: 'text',
         validator:city_valid1,
         editor: false,
       },
       {
         data: 'destination_state',
         type: 'text',
         validator: state_valid1,
         editor: false,
       },
       {
         data: 'pickup_date',
         type: 'text'
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
         type: 'text'
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
         validator: truckload_valid1,
         editor: false,

       },
       {
         data: 'weight',
         validator: wgt_valid1,
         editor: false,
       },
       {
         data: 'length',
         validator: len_valid1,
         editor: false,
       },
       {
         data: 'truck_name',
         type: 'text',
         validator: eqmt_valid1,
         editor: false,
       },
       {
         data: 'price', 
         type: 'numeric',   
         numericFormat: {pattern: '$ 0,0.00'},
         validator: price_valid1 ,
         editor: false,
       }

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
           'EQUIPMENT',
           'PRICE',
          ],
   hiddenColumns: {
    columns: [0],
    indicators: false
  },
minSpareRows: 0,
contextMenu: true,
onBeforeChange: function (data) {
     for (var i = data.length; i >= 0; i--) {
       console.log(data[i]);
       console.log('poop');

     }
},
afterChange: function (change, source) {
   if (source === 'loadData') {
     return; 
   }
   if($parent1.find('input[name=autosave]').is(':checked')) {
     clearTimeout(autosaveNotification);
     $.ajax({
       url: "json/save.json",
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

    showData(handsontable1,ob1,1);
}


$parent.find('button[name=save]').click(function (e) {
  let tableData=[];
  let tableData1=[];
  if(error_table>0){
        tableData=handsontable.getData();
    }
var totRow=tableData.length;
valid=1;
for(var i=0; i <totRow; ++i)
  {
    var rowData = tableData[i];
    var totColumns=rowData.length;
    for(var j=0; j < totColumns;++j){
       var cellProperties = handsontable.getCellMeta(i, j);
       if(cellProperties.valid==false ){
           if(j==0){
              let id=tableData[i][j];
              let list=ob.filter(function (i,n){
                 if(n.id===id){
                    ob[i]=tableData[i];
                 }
                 return 1;
              });
           }
           valid=0;
           handsontable.selectCell(i, j);
           //alert('Please Invalid Data');
             toastr.error('Please provide valid data');   
           return false;
        }
    }
  }

  if(valid==1){
      if(error_table>0 && valid_table>0){
         
          var data= $.merge( ob, ob1);
          console.log(data);
      }else if(error_table>0){
        tableData=handsontable.getData();
         var data= ob;
      }else if(valid_table>0){
        var data= ob1;
      }
      $('.disbulk').attr("disabled", true); 

      $.ajax({
         url: LoadBoard.API+"broker/bulk-view-data",
         type: 'POST',
         data: {"data": data}, //returns all cells' data
         dataType: 'json',
         success: function (result) {
            if(result.status==1){
                  $('.disbulk').attr("disabled", false); 
               toastr.success(result.msg);
            window.location.href=LoadBoard.APP+"broker/loads";
            }else if(result.status==0){
                toastr.error(result.msg);                
            return false;
            }
         }
     }); 
  }
});




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
   element.validateCells();
}
/*$('.loader-li').addClass('active');
$('.my-md-5').hide();
setTimeout(function () {
$('.loader-li').removeClass('active');
$('.my-md-5').show();
},2000)*/

function ExsafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {

  var escaped = Handsontable.helper.stringify(value);
  //console.log(escaped+"ease-in-out")
  var quote_str =  "'" + escaped + "'";
  if(escaped!=''){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': escaped}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        td.innerHTML = latitude+","+longitude;
        handsontable1.setDataAtCell(row,col,td.innerHTML);
        return td;
       } 
    }); 
 }
}

function safeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {
   
  var escaped = Handsontable.helper.stringify(value);
//  console.log(escaped+"ease-in-out")
  var quote_str =  "'" + escaped + "'";
  if(escaped!=''){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': escaped}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        td.innerHTML = latitude+","+longitude;
        handsontable.setDataAtCell(row,col,td.innerHTML);
        return td;
       } 
    }); 
 }
}

function DessafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {
  var escaped = Handsontable.helper.stringify(value);
// console.log(escaped+"ease-in-out")
  var quote_str =  "'" + escaped + "'";
  if(escaped!=''){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': escaped}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        td.innerHTML = latitude+","+longitude;
        handsontable.setDataAtCell(row,col,td.innerHTML);

        return td;
       } 
    }); 
 }
}
function ExDessafeHtmlRenderer(instance, td, row, col, prop, value, cellProperties) {

  var escaped = Handsontable.helper.stringify(value);
// console.log(escaped+"ease-in-out")
  var quote_str =  "'" + escaped + "'";
  if(escaped!=''){
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': escaped}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var latitude = results[0].geometry.location.lat();
        var longitude = results[0].geometry.location.lng();
        td.innerHTML = latitude+","+longitude;
        handsontable1.setDataAtCell(row,col,td.innerHTML);
        return td;
       } 
    }); 
 }
}

function pickupdatefun(instance, td, row, col, prop, value, cellProperties) {
   var escaped = Handsontable.helper.stringify(value);
   if(escaped!=''){
    var res = escaped.split("-");
    var dt=res[1]+"-"+res[2]+"-"+res[0];
     td.innerHTML = dt;
     handsontable.setDataAtCell(row,col,td.innerHTML);
     return td;
   }

}

function pickupdatef(instance, td, row, col, prop, value, cellProperties) {
  cellProperties.valid = false;
  td.className = 'htInvalid'; 
  var escaped = Handsontable.helper.stringify(value);
    if(escaped!=null && escaped!=''){
        date1 = new Date();
        date2 = new Date(value);
        var t1 = date1.getTime();
        var t2 =date2.getTime();
        month=date2.getMonth()+1;
        day=date2.getDate();
        day1=date1.getDate();
        month=(month < 10) ? '0'+month : month;
        day=(day < 10) ? '0'+day : day;
        var ndate=month+'/'+day+'/'+date2.getFullYear();
        td.innerHTML=ndate;
        if(t2 > t1 && day>=day1){
            cellProperties.valid = true;
            td.className = ''; 
           // insatance.setDataAtCell(row,col,td.innerHTML);
        }
    }else{
      cellProperties.valid = false;
      td.className = 'htInvalid';
      td.innerHTML='';
     // instance.setDataAtCell(row,col,td.innerHTML);
    }
    return td;
}

function deliverydatef(instance, td, row, col, prop, value, cellProperties){
    cellProperties.valid = true;
    td.className = ''; 
    var escaped = Handsontable.helper.stringify(value);
    var indate=instance.getDataAtCell(row,col-2)
    if(indate!='' && escaped!='' &&  escaped!=null && indate!=null){
        date1 = new Date(indate);
        date2 = new Date(value);
        date3 =new Date();
        var t1 = date1.getTime();
        var t2 =date2.getTime();
        var t3 =date3.getTime();

        month=date2.getMonth()+1;
        day=date2.getDate();
        month=(month < 10) ? '0'+month : month;
        day=(day < 10) ? '0'+day : day;
        var ndate=month+'/'+day+'/'+date2.getFullYear();
        td.innerHTML=ndate;
        if(t2 < t1 || t2 <= t3 ){
            cellProperties.valid = false;
            td.className = 'htInvalid'; 
        }
    }else{
      cellProperties.valid = false;
      td.className = 'htInvalid';
      td.innerHTML='';
    }
}
</script>



<!-- <script>
$(document).ready(function(){
  $('.btn').popover({title: "<h1><strong>HTML</strong> inside <code>the</code> <em>popover</em></h1>", content: "Blabla <br> <h2>Cool stuff!</h2>", html: true, placement: "right"}); 
});
</script> -->

