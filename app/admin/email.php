<?php
   require_once("../../elements/Global.php");
   $Global=new LoadBoard();
   $Global->AfterAdminloginCheck();
   
   $Global->admin_header("LoadBoard - Dashboard");
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
   </div>
   <form data-toggle="validator" role="form" id="contact_frm" class="form-horizontal">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-default card-view">
               <div class="panel-heading">
               <div class="pull-left">
                <div class="form-group" >
                         <a href="JavaScript:void(0);"  id="sent_list" ><u style="margin-left: 29px;font-size: 17px;color: #467fcf;">Back to Mail List</u></a></div>
                     </div>                 
               <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
               <div class="panel-body">
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Type</label>
                        <div class="col-lg-10">
                            <select class="form-control selectpicker col-lg-12" id="contacts_type" data-style="form-control btn-default btn-outline">
                              </select>
                        </div>
                     </div>
                      <div class="form-group">
                       <label class="col-lg-2 control-label">To</label>
                        <div class="col-lg-10 ">
                          <select class="form-control col-lg-12 3col active" id="contacts_list" name="basic[]" multiple="multiple" data-style="form-control btn-default btn-outline">
                            </select>
                         </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
    <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-default card-view">
            <div class="panel-heading">
               <div class="pull-left">
               </div>
               <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
               <div class="panel-body">
                     <div class="form-group">
                        <label class="col-lg-2 control-label">Short Code</label>
                        <div class="col-lg-10">
                           <input type="text" placeholder="" id="short_code" class="form-control" value="[name] [business name] [type] [pickup_date] [delivery_date] [origin_addr] [delivery_addr] [delivery_date]" disabled>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-lg-2 control-label">Subject</label>
                        <div class="col-lg-10">
                           <input type="text" placeholder="" id="subject" class="form-control">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-lg-2 control-label">Message</label>
                        <div class="col-lg-10">
                           <textarea id="emailcontainer" name="emailcontainer"></textarea>
                        </div>
                     </div>
                     <div align="right">
                          <br/>
                          <button  type="button" id="demo" class="btn btn-success btn-anim"><span class="btn-text">Send</span></button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
 </form>
</div>
<?php  
   $Global->admin_footer();
   ?>

<script src="http://192.168.1.215:81/loadboard/app/admin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">

$(document).ready(function(){

 

   $("#demo").click(function () {    
        //e.preventDefault();
          $.ajax({
            type: 'post',
            url: LoadBoard.API+'admin/email-detail',
            dataType: "json",
          //  data: data+"&token="+LoadBoard.token+"&user_id="+LoadBoard.userid,
            headers: {
                 Authorization: "Bearer "+LoadBoard.admintoken
              },
           data: JSON.stringify({ 
              "user_id": LoadBoard.userid, 
              "con_type": $('#contacts_type').val(),
              "contacts_list":$("#contacts_list").val(),
              "subject": $("#subject").val(),
              "email_content":CKEDITOR.instances.emailcontainer.getData() ,
            }),
            contentType: "application/json",
            success: function (result) {
              if(result.status==1){
                  $.toast({
                    text: result.msg,
                    position: 'top-center',
                    loaderBg:'#fec107',
                    icon: 'success',
                    hideAfter: 3500
                  });
                  $('#contacts_type').val("");
                  $("#contacts_list").val("");
                  $("#subject").val("");
                  CKEDITOR.instances['emailcontainer'].setData(' ');
                             
          }
        }
         });  
       
    });

$('#getdetail').click(function(){
  window.location.href=LoadBoard.APP+'admin/contact-list';
});

  $('#sent_list').click(function(){
  window.location.href=LoadBoard.APP+'admin/sent-list';
});

GetContactType();
$('#contacts_type').on('change', function() {
    if(this.value!=''){
      GetContact_list(this.value);
   }
  });


   CKEDITOR.replace( 'emailcontainer' );

   //set value to ck editor
  //var htmls="<p>welcome</p>";
 // CKEDITOR.instances['emailcontainer'].setData(htmls);

  
        $('select[multiple].active.3col').multiselect({
            columns: 1,
            placeholder: 'Select contacts',
            search: true,
            scroll: true,
            searchOptions: {
                'default': 'Search contacts'
            },
            selectAll: true,

        });

      
   });
      
function GetContactType(list=""){
   var contactss= list;
   $.ajax({
          type: 'post',
          url:LoadBoard.API+'admin/email-contact-list',
          dataType: "json",
          headers: {
                 Authorization: "Bearer "+LoadBoard.admintoken
          },
          data: JSON.stringify({
                "user_id":LoadBoard.userid,
                "operation":"contact_type",
                    
            }),
          contentType: "application/json",
    success:function(result){
     if(result.status == 1){
      var contacts_li=$("#contacts_type").val();
        if(result.data.length !=0){
          $("#contacts_type").empty();
          var option="<option value=''>Select Contact type</option>";
          for(var i=0;i<result.data.length;i++){
              if(result.data[i]['user_type']=="broker"){
                  var id = 1;
               }else if(result.data[i]['user_type']=="trucker"){
                  var id = 2;
               }else if(result.data[i]['user_type']=="shipper"){
                  var id = 3;
               }
               if(id ==contactss){
                  var selected = "selected=selected";
               } else {
                  var selected = "";
               }
            option+="<option value="+id+">"+Ucfirst(result.data[i]['user_type'])+"</option>";
          }
             $("#contacts_type").html(option);    
        }
      }
    }
  }); 
} 

function GetContact_list(type="",list=""){
  con_type=list;
  $.ajax({
    type :'post',
    url  :LoadBoard.API+'admin/email-contact-list',
    dataType: "json",
    headers: {
         Authorization: "Bearer "+LoadBoard.admintoken
    },
    data: JSON.stringify({
        "user_id":LoadBoard.userid,
        "operation":"contact_type_list",
        "contact_type":type, 
            
    }),
    contentType: "application/json",
    success:function(result){
        console.log(result);
            if(result.status == 1){
            if(result.data.length!=0){
              $("#contacts_list").empty();
               var option="<option value=''>Select Contact</option>"; 
               var option;
                for (var i =0; i<result.data.length; i++) {
                    option+="<option  value="+result.data[i]['id']+">"+result.data[i]['email']+"</option>";
                    
                  }
                console.log(option)
               $("#contacts_list").append(option); 
               $("#contacts_list").multiselect('reload');


              // $("#contacts_list").multiple('refresh');

            }
          }

    }
  });

}

function Ucfirst(string){
  return string.charAt(0).toUpperCase() + string.slice(1);
} 
</script>