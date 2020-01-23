 <?php 
require_once("./elements/Global.php");

$Global=new LoadBoard();
$Global->BeforeloginCheck();
 ?>
 <!DOCTYPE html>
            <html lang="en" dir="ltr">
            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <meta http-equiv="Content-Language" content="en" />
            <meta name="msapplication-TileColor" content="#2d89ef">
            <meta name="theme-color" content="#4188c9">
            <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="mobile-web-app-capable" content="yes">
            <meta name="HandheldFriendly" content="True">
            <meta name="MobileOptimized" content="320">
            <meta name="description" content="">
            <meta name="keywords" content="">
            <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
            <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
            <!-- Generated: -->
            <title>SimpleTLB - Sign Up </title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
             <script type="text/javascript">
             function Global() {
                this.self = new function() {
                    this.domain = "<?php echo SITEURL; ?>";
                    this.page = window.location.href.split(/[?#]/)[0];
                    this.pagename = window.location.pathname.split("/").pop();
                    this.params = [];
                    this.paramname = [];
                    if (window.location.href.indexOf("?") >= 0) {
                        var paramlist = window.location.href.split("?").pop().split("&");
                        for (var i = 0; i < paramlist.length; i++) {
                            var parameter = paramlist[i].split("=");
                            this.paramname[i] = parameter[0];
                            this.params[i] = new Array(parameter[0], paramlist[i].slice(paramlist[i].indexOf("=") + 1));
                        }
                    }
                };
                this.user = new function() {
                    this.userid = "<?php echo isset($_SESSION['id']) ? $_SESSION['id']:''; ?>";
                    this.email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email']:''; ?>";
                    //this.token = "<?php //echo isset($_SESSION['token']) ? $_SESSION['token']:''; ?>";
                };
                this.basepath = this.self.domain;
                this.APP = this.self.domain + "app/";
                this.API = this.self.domain + "api/";
                this.thispage = window.location.pathname.split("/").pop();
            } 
            var LoadBoard = new Global();
            var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

            for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
            }
            };
           
        </script>
            <script src="<?php echo SITEURL; ?>app/assets/js/jquery-1.11.1.min.js"></script>
            <link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/toastr.min.css">
            <script src="<?php echo SITEURL; ?>app/assets/js/toastr.min.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/form_custom.css">
            <script src="<?php echo SITEURL; ?>app/assets/js/jquery.min_form.js"></script>
            <script src="<?php echo SITEURL; ?>app/assets/js/require.min.js"></script>
            <script>
            requirejs.config({
                 baseUrl: '.'
            });
            </script>
            <link href="<?php echo SITEURL; ?>app/assets/css/dashboard.css" rel="stylesheet" />
            <link href="<?php echo SITEURL; ?>app/assets/css/animate.css" rel="stylesheet" />

            <script src="<?php echo SITEURL; ?>app/assets/js/dashboard.js"></script>
            <script src="<?php echo SITEURL; ?>app/assets/plugins/input-mask/plugin.js"></script>
           </head>
  <body class="">
    <div class="page">
      <div class="page-single-flip">
        <div class="container">
          <div class="row">
            <div class="col col-create mx-auto">
              <div class="text-center ">
                <img src="<?php echo SITEURL; ?>app/img/logo.png" class=" " alt="">
              
            <h1 class="page-title mt-4 ">Create Your Account</h1>
              </div>
                
             <div class="" id="flipcard">
             
              <div class="front user_choice createfilp">                 
            <div class="row row-cards row-deck mt-5 text-center">
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="card">       
                 <div class="card-status bg-blue"></div>        
                 <a href="#" class="mt-5 "><img class="  w-75" src="<?php echo SITEURL; ?>app/assets/images/trucker.png" alt="Trucker"></a>
                  <div class="card-body text-center">
                    <div class="card-category text-muted">as</div>
                    <div class="display-4 my-4">Trucker</div>                  
                    <div class="text-center mt-6">
                      <a href="#" class="btn  btn-primary btn-block trucker_link common_link" data-id="trucker">Sign Up</a>                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                <div class="card-status bg-green"></div>
                 <a href="#" class="mt-5 "><img class=" w-75" src="<?php echo SITEURL; ?>app/assets/images/broker.png" alt="Broker"></a>
                  <div class="card-body text-center">
                    <div class="card-category text-muted">as</div>
                    <div class="display-4 my-4">Broker</div>                  
                    <div class="text-center mt-6">
                    <a href="#" class="btn  btn-primary btn-block broker_link common_link" data-id="broker">Sign Up</a> 
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                <div class="card">
                <div class="card-status bg-orange"></div>
                 <a href="#" class="mt-5 "><img class=" w-75" src="<?php echo SITEURL; ?>app/assets/images/shipper.png" alt="Shipper"></a>
                  <div class="card-body text-center">
                    <div class="card-category text-muted">as</div>
                    <div class="display-4 my-4">Shipper</div>                  
                    <div class="text-center mt-6">
                      <a href="#" class="btn btn-primary btn-block shipper_link common_link" data-id="shipper">Sign Up</a>                      
                    </div>
                  </div>
                </div>
              </div>             
            </div>
             <div class="text-center text-black-50">
                Already have an Account?  <a href="<?php echo SITEURL; ?>app/signin" >Sign in</a>.
             </div>   
            </div>             
          
              
            <div class="back shipperform_link" style="opacity: 0;"> 
             <form class="card" id="signup" action="" method="post" autocomplete="off">
                <div class="card-body p-6">
                <div class="text-center">
                <a href="#" class=" "><img class="w-50 img-change" src="" alt=""></a>
                  </div>
                  <div class="card-title text-center text text-blue text-change">Shipper Sign Up</div>
               <!-- <div class="alert alert-danger" role="alert">
                          This is a danger alert—check it out!
                </div>-->
                  <div class="row">
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label name-change">Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name" id="name"  >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6 business_div">
                      <div class="form-group">
                        <label class="form-label">Business Name</label>
                        <input type="text" class="form-control" placeholder="Business Name" name="business_name" id="business_name"  >
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label email-change">Email (User ID)</label>
                        <input type="text" class="form-control" placeholder="Email" name="email" id="email">
                        <label id="email-error" class="error" for="email" style="display: none;"></label>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label">Password</label>                        
                        <input type="password" class="form-control" value="" placeholder="Password" name="password" id="password">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label">Confirm Password</label>                        
                        <input type="password" class="form-control" value="" placeholder="Confirm Password" name="confirm_pass" id="confirm_pass">
                      </div>
                    </div>
                    <input type="hidden" value="web" id="app_type" name="app_type">
                    <input type="hidden" value="" id="usertype" name="usertype" data-id="">
                    <input type="hidden" value="" id="ip_address" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">

                  
                  <div class="col-md-12  text-center">
                    <button type="submit"  class="btn btn-primary bottom-text" >Sign Up as Shipper</button>
                  </div>
                  </div>
                </div>
              </form>
                <div class="text-center text-black-50">
                <a href="#" class="backflip-btn" >Send Me Back</a> to the User choice screen.
              </div>
            </div>
            </div>
      </div>
          </div>
        </div>
      </div>
    </div>
   
    
     <script type="text/javascript">
      $(document).ready(function() {
              $(".preloader").hide();

              jQuery.validator.addMethod("name_valid", function (input) {
                 var filter = /[\'^£$%&*0-9()}{@.#~?><>,|=_+¬-]/;
                  if (filter.test(input)) {
                      return false;
                  } else {
                      return true;
                  }
              });
              jQuery.validator.addMethod("busi_namevalid", function (inputtxt) {
                 var filter = /[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/;
                  if (filter.test(inputtxt)) {
                      return false;
                  } else {
                      return true;
                  }
              });
               jQuery.validator.addMethod("email_valid", function (email) {
                  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(email)) {
                      return false;
                    }else{
                      return true;
                     }
                });
            $("#signup").validate({
                rules: {
                  name: {
                    required:true,
                    name_valid:true,
                  },
                  business_name:{
                    required:true,
                    busi_namevalid:true,
                  },
                  email: {
                    required: true,
                    email: true,
                    email_valid: true,
                   },
                  password: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                  },
                  confirm_pass: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                    equalTo: "#password"
                  }
                  
                },
                messages: {
                  name: {
                    required: "Please enter the name",
                    name_valid:"Please enter the valid name",
                  },
                  business_name: {
                    required: "Please enter the business name",
                    busi_namevalid:"Please enter the valid business name",
                   },
                   email: {
                    required: "Please enter the Email",
                    email:    "Please enter the valid Email",
                    email_valid: "Please enter the valid Email",
                   },
                  password: {
                    required:  "Please enter the password",
                    minlength: "Password must be at least 8 characters",
                    maxlength: "Password cannot be greater than 15 characters",
                  },
                  confirm_pass: {
                   required:  "Please enter the confirm password",
                   minlength: "Confirm password must be at least 8 characters",
                   maxlength: "Confirm password cannot be greater than 15 characters",
                   equalTo:   "Password and confirm password mismatch"
                  }
                },
                submitHandler: function() {
                    var usertype=$("#usertype").val();
                    var msgname='name';
                    var data=$('#signup').serialize();
                    signup(data,usertype);
                }
           });

         

          /*$('#name').keypress(function(e){
           var txt = String.fromCharCode(e.which);
            if(!txt.match(/[A-Za-z]/))
            {
            return false;
             }
          });

          $('#business_name').keypress(function(e){
           var txt = String.fromCharCode(e.which);
            if(!txt.match(/[A-Za-z]/))
            {
            return false;
             }
          });*/

          
 $(".backflip-btn").click(function() {
  $(".createfilp").css("display","block");
  $(".shipperform_link").css("display","none");
  $(".createfilp").addClass("flipInY");
  $(".createfilp").addClass("animated slowly");
  $(".createfilp").css('opacity',1);
});

 $(".common_link").click(function() {
 
  $(".createfilp").css("display","none");
  $(".shipperform_link").css("display","block");
  $(".shipperform_link").addClass("flipInY");
  $(".shipperform_link").addClass("animated slowly");

  var signup=$(this).attr("data-id");

  //$(".business_div").hide();
  if(signup=='trucker'){
      $("label.error").hide();
    $("#name").val("");
    $("#email").val("");
    $("#password").val("");
    $("#confirm_pass").val("");
    $("#business_name").val("");

    $(".business_div").show();
    $(".text-change").html("Trucker Sign Up");    
    var trucker_img=LoadBoard.APP+"assets/images/trucker.png"
    $(".img-change").attr("src",trucker_img);
    $(".img-change").attr("alt","Trucker");
    $(".bottom-text").html("Sign Up as Trucker");
    $(".name-change").html("Full Name");
    $(".email-change").html("Email (User ID)");
    $("#usertype").val(signup);

  }else if(signup=='broker'){
    $("label.error").hide();
      $("#name").val("");
    $("#email").val("");
    $("#password").val("");
    $("#confirm_pass").val("");
    $("#business_name").val("");

    $(".business_div").show();
    $(".text-change").html("Broker Sign Up");    
    var broker_img=LoadBoard.APP+"assets/images/broker.png"
    $(".img-change").attr("src",broker_img);
    $(".img-change").attr("alt","Broker");
    $(".bottom-text").html("Sign Up as Broker");
    //$(".name-change").html("Legal Business Name");
    $(".email-change").html("Email (User ID)");
    $("#usertype").val(signup);
  }else if(signup =='shipper'){
    $("label.error").hide();
      $("#name").val("");
    $("#email").val("");
    $("#password").val("");
    $("#confirm_pass").val("");
    $("#business_name").val("");
    
    $(".business_div").show();
    $(".text-change").html("Shipper Sign Up");    
    var shipper_img=LoadBoard.APP+"assets/images/shipper.png"
    $(".img-change").attr("src",shipper_img);
    $(".img-change").attr("alt","Shipper");
    $(".bottom-text").html("Sign Up as Shipper");
    $("#usertype").val(signup);
    $(".name-change").html("Name");
    $(".email-change").html("Email (User ID)");

  }
  $(".user_choice").css('opacity', '0');
  $(".shipperform_link").css('opacity', '100');
  //$("#flipcard").flip(true);  
  return false;
});

      });

    




      function signup(data="",usertype=""){
        $(".preloader").show();
        var Url;
        if(usertype=='broker')
          Url=LoadBoard.API+'broker/signup';
        else if(usertype=='trucker')  
          Url=LoadBoard.API+'trucker/signup'
        else if(usertype=='shipper')
          Url=LoadBoard.API+'shipper/signup'
         $.ajax({
            type: 'post',
            url: Url,
            dataType: "json",
            //data: data,
            data: JSON.stringify({ 
                "name": $("#name").val(), 
                "business_name": $("#business_name").val(),
                "email": $("#email").val(),
                "password":$("#password").val(),
                "confirm_pass":$("#confirm_pass").val(),
                "app_type":$("#app_type").val(),
                "usertype" :$("#usertype").val()
            }),

            contentType: "application/json",
            success: function (result) {
             // return false;
              if(result.status==1){
                $(".preloader").hide();
                   toastr.success(result.msg); 
                   $('#signup')[0].reset(); 
                   window.location.href=LoadBoard.APP+"success?t="+result.user_type;
              }else if(result.status==0){
              
                $(".preloader").hide();
                if(result.msg.email == 'Email Id already exists'){
                          $("#email").css("border","1px solid red");
                          $("#email-error").html(result.msg.email).show();
                }
                  // toastr.error(result.msg);                    
                   return false;
              }
            }
         });        
      }


     </script>


  </body>
  

  
</html>
  
<div class=" preloader">  
  <div class="container-loader">
    <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
      <circle cx="170" cy="170" r="160" stroke="#f8fcff"/>
      <circle cx="170" cy="170" r="135" stroke="#88c4ff"/>
      <circle cx="170" cy="170" r="110" stroke="#f8fcff"/>
      <circle cx="170" cy="170" r="85" stroke="#88c4ff"/>
    </svg>  
  </div>
</div>
