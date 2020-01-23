 <?php 
  require_once("../elements/Global.php");
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
            <title>SimpleTLB - Sign In </title>
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
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <img src="<?php echo SITEURL; ?>app/img/logo.png" class=" " alt="">
               </div>
                <div class="login" id="flipcard">
              <div class="front signin_form"> 
              <form class="card" id="signin" method="post">
                <div class="card-body p-6">
                  <div class="card-title text-center">Sign In</div>
              
                  <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input type="text" class="form-control" name="email"  id="email" aria-describedby="emailHelp" placeholder="Enter email" >
                    <label id="email-error" class="error" for="email" style="display: none;" ></label>
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Password
                    
                    </label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <label id="password-error" class="error" for="password" style="display: none;" ></label>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember_me" id="remember_me"  class="custom-control-input"/>
                      <span class="custom-control-label">Remember me</span>
                    </label>
                 </div>
                  <div class="form-footer">
                      <div id="msg"></div>
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                  </div>
                   <div class="text-center text-black-50 " style="margin-top: 10px;">
                      <a href="#" id="flip-btn"  class=" small-9 signup_link">Forgot password</a>
                  </div>
                </div>
              </form>
                 <div class="text-center text-black-50">
                  Don't have account yet? <a href="<?php echo SITEURL; ?>">Sign up</a>
                </div>

              </div>
                    

                    <div class="back forgot_form" style="opacity: 0;"> 
                       <form class="card" id="forgot_form" method="post">
                          <div class="card-body p-6">
                            <div class="card-title text-center">Forgot password</div>
<!--                             <p class="text-black-50">Enter your Email you used to register in this website.</p>
 -->                            <div class="form-group">
                              <label class="form-label" for="exampleInputEmail1">Email address</label>
                              <input type="text" class="form-control" name="forgot_email" id="forgot_email" aria-describedby="emailHelp" placeholder="Enter Registered Email">
                              <label id="forgot_email-error" class="error" for="forgot_email" style="display: none;"></label>
                            </div>
                            <div class="form-footer">

                              <button type="submit"  class="btn btn-primary btn-block">Reset Password</button>
                            </div>
                          </div>
                       </form>
                      <div class="text-center text-black-50">
                      Forget it, <a href="#" class="unflip-btn" id="unflip-btn">send me back</a> to the sign in screen.
                     </div>
                  </div>  



               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
     <script src="<?php echo SITEURL; ?>app/assets/js/jquery.flip.js"></script>
     <script type="text/javascript">
          $(document).ready(function() {
           $(".preloader").hide();
            $("#flip-btn").click(function(){
                $(".forgot_form").css("display","block");
                $(".signin_form").css("display","none");
                $(".forgot_form").addClass("flipInY");
                $(".forgot_form").addClass("animated");

            });
            $("#unflip-btn").click(function(){
                $(".signin_form").css("display","block");
                $(".forgot_form").css("display","none");
                $(".signin_form").addClass("flipInY");
                $(".signin_form").addClass("animated");
            });
           // unflip-btn
            jQuery.validator.addMethod("email_valid", function (email) {
                  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(email)) {
                      return false;
                    }else{
                      return true;
                     }
                });
             $("#signin").validate({
                rules: {
                  email: {
                    required: true,
                    email: true,
                    email_valid:true,
                   },
                  password: {
                    required: true
                  } 
                },
                messages: {
                  email:{
                    required: "Please enter the Email",
                    email: "Please enter a valid Email",
                    email_valid:"Please enter a valid Email",
                  },
                  password: {
                    required: "Please enter the password",
                  }
                },
                submitHandler: function() {
                    var data=$('#signin').serialize();
                    logincheck(data); 
                }
             });

             //Forgot Password
            $("#forgot_form").validate({
                rules: {
                forgot_email: {
                    required: true,
                    email: true,
                    email_valid:true,

                   }
                },
                messages: {
                  forgot_email: {
                    required: "Please enter the Email",
                    email: "Please enter a valid Email",
                    email_valid:"Please enter a valid Email",
                   }
                },
                submitHandler: function() {
                  var data=$('#forgot_form').serialize();
                   forgotlogincheck(data);
                }
             });


            
                if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#remember_me').attr('checked', 'checked');
                    $('#email').val(localStorage.email);
                    $('#password').val(localStorage.password);
                } else {
                    $('#remember_me').removeAttr('checked');
                    $('#email').val('');
                    $('#password').val('');
                }
 
                $('#remember_me').click(function() {
                    if ($('#remember_me').is(':checked')) {
                        localStorage.email = $('#email').val();
                        localStorage.password = $('#password').val();
                        localStorage.chkbx = $('#remember_me').val();
                    } else {
                        localStorage.email = '';
                        localStorage.password = '';
                        localStorage.chkbx = '';
                    }
                });


            });
          function logincheck(data=""){
           // $(".preloader").show();
             $.ajax({
                    type: 'post',
                    url:LoadBoard.API+'signin',
                    dataType: "json",
                   // data: data,
                    data: JSON.stringify({ 
                      "email": $("#email").val(), 
                      "password": $("#password").val(),
                      "app_type": "web"
                    }),
                    contentType: "application/json",
                    success: function (result) {
                      if(result.status==1){
                         // toastr.success("Login successfully");
                          if(result.user_type=="broker"){
                           /// $(".preloader").hide();
                            window.location.href=LoadBoard.APP+"broker/profile";
                          }else if(result.user_type=="trucker"){
                          //  $(".preloader").hide();
                            window.location.href=LoadBoard.APP+"trucker/profile";
                          }else if(result.user_type=="shipper"){
                           // $(".preloader").hide();
                            window.location.href=LoadBoard.APP+"shipper/profile";
                          }
                      }else if(result.status==0){
                        if(result.msg.password == 'Password does not match'){
                            $("#password").css("border","1px solid red");
                            $('#password-error').html(result.msg.password).show();

                          $("#email").css("border","1px solid rgba(0, 40, 100, 0.20 )");
                          $("#email-error").html(result.msg.password).hide();

                          }else if(result.msg.email == 'User not found'){
                          $("#email").css("border","1px solid red");
                          $("#email-error").html(result.msg.email).show();

                          $("#password").css("border","1px solid rgba(0, 40, 100, 0.20 )");
                          $('#password-error').html(result.msg).hide();

                        } 
                        return false;
                      }
                    }
                 });
              }
      //email validatation
          function IsEmail(email) {
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
              return false;
            }else{
              return true;
            }
         }

 

          function forgotlogincheck(data=""){
            $(".preloader").show();
             $.ajax({
                    type: 'post',
                    url:LoadBoard.API+'forgot-password',
                    dataType: "json",
                    data: JSON.stringify({ 
                      "forgot_email": $("#forgot_email").val() ,
                      "app_type":"web"
                    }),
                    contentType: "application/json",

                    //dataType: "json",
                   // data: data,
                    success: function (result) {
                      if(result.status==1){
                         $(".preloader").hide();
                          toastr.success(result.msg);
                        $('#forgot_form')[0].reset();                   
                      }else if(result.status==0){
                         $(".preloader").hide();
                          if(result.msg.forgot_email=='There is no registered User with the Email Address '+$("#forgot_email").val()){
                             $("#forgot_email").css("border","1px solid red");
                             $("#forgot_email-error").html(result.msg.forgot_email).show();
                          }
                          //toastr.error(result.msg);
                        return false;
                      }
                    }
                 });
               }
      </script>
    </body>
</html>

  <div class="preloader"  >  
<div class="container-loader">
                <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
                                <circle cx="170" cy="170" r="160" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="135" stroke="#88c4ff"/>
                                <circle cx="170" cy="170" r="110" stroke="#f8fcff"/>
                                <circle cx="170" cy="170" r="85" stroke="#88c4ff"/>
                </svg>  
</div>
  </div>