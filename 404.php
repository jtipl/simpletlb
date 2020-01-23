<?php 
require_once("./elements/Global.php");
$Global=new LoadBoard();
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
            <title>LoadBoard - Verification </title>
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
            <script src="<?php echo SITEURL; ?>app/assets/js/require.min.js"></script>
            <script src="<?php echo SITEURL; ?>app/assets/js/jquery-1.11.1.min.js"></script>
            <script>
            requirejs.config({
                 baseUrl: '.'
            });
            </script>
            <link href="<?php echo SITEURL; ?>app/assets/css/dashboard.css" rel="stylesheet" />
            <script src="<?php echo SITEURL; ?>app/assets/js/dashboard.js"></script>
            <script src="<?php echo SITEURL; ?>app/assets/plugins/input-mask/plugin.js"></script>
           </head>

  <body >
    <div class="py-3 ">
        <div class="container animated fadeIn">   
              <div class="text-center ">
                <img src="<?php echo SITEURL; ?>app/assets/brand/logo.png" class=" " alt="">            
              </div>
    
<div class="row justify-content-md-center">
<div class="col-md-8">

<!-- After Signup message   -->

  <div class="alert alert-info text-center my-4  p-6 animated bounceInDown  " role="alert"> 
 <div class="avatar avatar-xxl bg-white animated headShake delay-1s">
  <i class="fe fe-alert-triangle text-info " data-toggle="tooltip" ></i>
 </div>
  <h2 class="display-4 my-4  " >Oops !</h2>               
                <h3>404 - PAGE NOT FOUND</h3>
                <hr class="my-4" >
                <div class="d-flex justify-content-center " >
                <p class="text-dark col-md-10">The page yor are looking for might have been removed had its name changed or is temporarily unavailable.</p>
                 
            </div>
             <a href="<?php echo SITEURL; ?>" style="display:inline-block;width:200px;background-color:#467fcf;border-radius:3px;color:#ffffff;font-size:15px;line-height:45px;text-align:center;text-decoration:none;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;box-sizing:border-box">GO TO HOME</a>
</div>





 </div>
    </div>      
          

        </div>

    </div>
    

            <link href="<?php echo SITEURL; ?>app/assets/css/animate.css" rel="stylesheet" />

  </body>
  <script type="text/javascript">
    
  </script>
</html>
    
