 <?php 
require_once("../elements/Global.php");
$Global=new LoadBoard();
$Global->BeforeloginCheck();
$email=isset($_REQUEST['e']) ? trim($_REQUEST['e']) : '';

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
            <title>SimpleTLB - Reset Password</title>
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
                <img src="<?php echo SITEURL; ?>app/assets/brand/logo.png" class=" " alt="">
               </div>
                <div class="login">
                  <div class="front signin_form"> 
                   <form class="card" id="password_reset" method="post">
                      <div class="card-body p-6">
                        <div class="card-title text-center">Reset Password</div>
                          <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" id="password" aria-describedby="emailHelp" placeholder="Enter Password">
                          </div>
                          <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                          </div>
                          <div class="form-footer">
                              <button type="submit" class="btn btn-primary btn-block">Save Password</button>
                          </div>
                      </div>
                   </form>
                  <div class="text-center text-black-50">
                      Already have an Account?  <a href="<?php echo SITEURL; ?>" >Sign in</a>.
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
        var emailtop="<?php echo $email; ?>";
        $("#password_reset").validate({
                rules: {
                  password: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                  },
                  confirm_password: {
                    required: true,
                    minlength: 8,
                    maxlength: 15,
                    equalTo: "#password"
                  }
                  
                },
                messages: {
                  password: {
                    required:  "Please enter the password",
                    minlength: "Password must be at least 8 characters",
                    maxlength: "Password cannot be greater than 15 characters",
                  },
                  confirm_password: {
                   required:  "Please enter the confirm password",
                   minlength: "Confirm password must be at least 8 characters",
                   maxlength: "Confirm password cannot be greater than 15 characters",
                   equalTo:   "Password and confirm password mismatch"
                  }
                },
                submitHandler: function() {
                    var data=$('#password_reset').serialize();
                    passwordcheck(data,emailtop); 
                }
           });
       });
          function passwordcheck(data="",emailtop=""){
             $.ajax({
                    type: 'post',
                    url:LoadBoard.API+'reset-password',
                    data: JSON.stringify({ 
                      "password": $("#password").val() ,
                      "confirm_password": $("#confirm_password").val() ,
                      "email":emailtop
                     // "app_type":"ios"
                    }),
                    contentType: "application/json",
                    dataType: "json",
                   // data: data+"&email="+emailtop,
                    success: function (result) {
                      if(result.status==1){
                          toastr.success(result.msg);
                          $('#password_reset')[0].reset();                   
                      }else if(result.status==0){
                        toastr.error(result.msg);
                        return false;
                      }
                    }
                 });
               }
      </script>
    </body>
</html>
