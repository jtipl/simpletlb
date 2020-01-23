<?php
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->BeforeAdminloginCheck();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>SimpleTLB - Admin Login</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="loadboard"/>
<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<!-- Custom CSS -->
<link href="dist/css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper  pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<!--
					<a href="index-2.html">
						<img class="brand-img mr-10" src="<?php echo SITEURL; ?>app/assets/brand/logo.png" alt="brand"/>
						<span class="brand-text"></span>
					</a>
					-->
				</div>
				<!-- <div class="form-group mb-0 pull-right">
					<span class="inline-block pr-10 txt-light-grey">Don't have an account?</span>
					<a class="inline-block btn btn-warning  btn-rounded " href="signup.html">Sign Up</a>
				</div> -->
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page">
				<div class="container-fluid">
					<!-- Row -->
					<div class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
											<h3 class="text-center txt-dark mb-10">SimpleTLB</h3>
											<!-- <h6 class="text-center nonecase-font txt-grey">Enter your details below</h6> -->
										</div>	
										<div class="form-wrap">
											<form action="post" id="admin_login">
												<div class="form-group">
													<label class="control-label mb-10" for="exampleInputEmail_2">User Name</label>
													<input type="text" class="form-control"  id="exampleInputEmail_2"  name="email" placeholder="Enter Username">
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>
													<!-- <a class="capitalize-font txt-orange block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a> -->
													<div class="clearfix"></div>
													<input type="password" class="form-control" name="password"  id="exampleInputpwd_2" placeholder="Password">
												</div>
												
												<div class="form-group">
													<!-- <div class="checkbox checkbox-primary pr-10 pull-left">
														<input id="checkbox_2" required="" type="checkbox">
														<label for="checkbox_2"> Keep me logged in</label>
													</div> -->
													<div class="clearfix"></div>
												</div>
												<div class="form-group text-center">
													<button type="submit" class="btn btn-warning  btn-rounded">sign in</button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
			</div>
			<!-- /Main Content -->
		</div>
		<script src="<?php echo SITEURL;?>app/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>

		<script src="<?php echo SITEURL;?>app/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo SITEURL;?>app/admin/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
				<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

				<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

		<script src="dist/js/jquery.slimscroll.js"></script>
		<script src="dist/js/init.js"></script>
<script type="text/javascript">
var API="<?php echo API; ?>";
var SITEURL="<?php echo SITEURL; ?>";
var ADMINURL="<?php echo ADMINURL; ?>";


$(document).ready(function() {
     $('#admin_login').on('submit', function (e) {
         e.preventDefault();
        var email=$("#email").val();
        var password=$("#password").val();
       // var validateemail=ValidateEmail(email);
        if(email==""){
			$.toast({
				text: 'Please enter the Email Id',
				position: 'top-center',
				loaderBg:'#fec107',
				icon: 'error',
				hideAfter: 3500
			});
           return false;
        }/*else if(email!="" && validateemail==false){
          $.toast({
				text: 'Please enter the valid Email Id',
				position: 'top-center',
				loaderBg:'#fec107',
				icon: 'error',
				hideAfter: 3500
			});
           return false;
        }*/else if(password==""){
            $.toast({
				text: 'Please enter the password',
				position: 'top-center',
				loaderBg:'#fec107',
				icon: 'error',
				hideAfter: 3500
			});
           return false;
        }else{
          var data=$('#admin_login').serialize();
          logincheck(data);         
        }
      });
});
//Admin Login Check
  function logincheck(data=""){
     $.ajax({
            type: 'post',
            url: API+'admin/signin',
            dataType: "json",
            data: data,
            success: function (result) {
             // console.log(result)
              if(result.status==1){
                  window.location.href=ADMINURL+"dashboard";
              }else if(result.status==0){
					$.toast({
						text: result.msg,
						position: 'top-center',
						loaderBg:'#fec107',
						icon: 'error',
						hideAfter: 3500
					});
                return false;
              }
            }
         });
  }
 function ValidateEmail(email) {
   if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
  {
    return true;
  }else{
  	return false;
  }
}
</script>
	</body>
</html>
