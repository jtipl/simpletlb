<?php 
ob_start();  
require_once("E:/xampp/htdocs/loadboard/config/inc.php");

//JWT Init
require_once(DIRECTORY."app/jwt/src/BeforeValidException.php");
require_once(DIRECTORY."app/jwt/src/ExpiredException.php");
require_once(DIRECTORY."app/jwt/src/SignatureInvalidException.php");
require_once(DIRECTORY."app/jwt/src/JWT.php");
require_once(DIRECTORY."config/email-config/PHPMailerAutoload.php");
use \Firebase\JWT\JWT;

if (session_status() == PHP_SESSION_NONE)  session_start();        
class LoadBoard{   
	const CRYPT = "AES-128-ECB";
	const KEY = 'LoadBoard'; 
	const DOMAIN = SITEURL;
	const PORTAL = self::DOMAIN."app/";
	const RELATIVE = "app/";
	const API = self::DOMAIN."api/";
	const ASSETS = self::DOMAIN."app/assets/";
	const ROOT = DIRECTORY;
	const BASE = self::ROOT."app/";
	const HEADER = self::BASE."includes/admin/header.php";
	const FOOTER = self::BASE."includes/admin/footer.php";

	const MENU = self::BASE."includes/admin/leftside-menu.php";
	const RIGHTMENU = self::BASE."includes/admin/rightside-menu.php";
	const LOAD_HEADER= self::BASE."includes/header.php"; 
	const LOAD_FOOTER= self::BASE."includes/footer.php";
	const LOAD_MENU= self::BASE."includes/broker-menu.php";
	const LOAD_TRUCKER_MENU= self::BASE."includes/trucker-menu.php";
	const LOAD_SHIPPER_MENU= self::BASE."includes/shipper-menu.php";
	const LOAD_MODAL= self::BASE."includes/map-modal.php";
	const LOAD_CANCEL_MODAL= self::BASE."includes/map-cancel-modal.php";
	const TRUCKER_MODAL_POPUP = self::BASE."includes/trucker-modal-popup.php";
	const BROKER_MODAL_POPUP = self::BASE."includes/broker-modal-popup.php";

	const CIPHER = MCRYPT_RIJNDAEL_128; 
    const MODE   = MCRYPT_MODE_CBC;

	static $Module = array(
		'header'=>self::HEADER,
		'rightmenu'=>self::RIGHTMENU,
		'menu'=>self::MENU,
		'footer'=>self::FOOTER,
		'load_header'=>self::LOAD_HEADER,
		'load_footer'=>self::LOAD_FOOTER,
		'load_broker_menu'=>self::LOAD_MENU,
		'load_trucker_menu'=>self::LOAD_TRUCKER_MENU,
		'load_shipper_menu'=>self::LOAD_SHIPPER_MENU,
		'load_modal'=>self::LOAD_MODAL,
		'load_cancel_modal'=>self::LOAD_CANCEL_MODAL,
		'trucker_modal_popup'=>self::TRUCKER_MODAL_POPUP,
		'broker_modal_popup'=>self::BROKER_MODAL_POPUP
	);


	public $ses=false,$minify=false;

	private $dbHost     = HOST;
	private $dbUsername = USERNAME;
	private $dbPassword = PASSWORD;
	private $dbName     = DATABASE;
	private $port       = PORT;
	//private $key;

	public function __construct(){
		

		if(!isset($this->db)){
			// Connect to the database
			try{
				$this->conn = new PDO("pgsql:host=".$this->dbHost.";port=".$this->port.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
				$this->conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db =$this->conn;
			}catch(PDOException $e){
				die("Failed to connect with PGSQL: " . $e->getMessage());
			}
		}
		//Protect php files from direct access
		if(!defined('APP')){
		  //header("Location:".SITEURL."app/logout");	
		  die();
		} 

		
	}

	/*
	 * Insert data into the database
	 * @param string name of the table
	 * @param array the data for inserting into the table
	 */
	public function InsertData($table,$data){
		if(!empty($data) && is_array($data)){
			$columns = '';
			$values  = '';
			$i = 0;
			$columnString = implode(',', array_keys($data));
			$valueString = ":".implode(',:', array_keys($data));
			$sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
			//echo $sql;exit;
			$query = $this->db->prepare($sql);
			foreach($data as $key=>$val){
			   // print_r($val);

				 $query->bindValue(':'.$key, $val);
			}//exit;
			$insert = $query->execute();
			return $insert?$this->db->lastInsertId():false;
		}else{
			return false;
		}
	}

	 /*
	 * Update data into the database
	 * @param string name of the table
	 * @param array the data for updating into the table
	 * @param array where condition on updating data
	 */
	public function UpdateData($table,$data,$conditions){
		if(!empty($data) && is_array($data)){
			$colvalSet = '';
			$whereSql = '';
			$i = 0;
		   
			foreach($data as $key=>$val){
				$pre = ($i > 0)?', ':'';
				$colvalSet .= $pre.$key."='".$val."'";
				$i++;
			}
			if(!empty($conditions)&& is_array($conditions)){
				$whereSql .= ' WHERE ';
				$i = 0;
				foreach($conditions as $key => $value){
					$pre = ($i > 0)?' AND ':'';
					$whereSql .= $pre.$key." = '".$value."'";
					$i++;
				}
			}
			$sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
			//echo $sql;exit;
			$query = $this->db->prepare($sql);
			$update = $query->execute();
			return $update?$query->rowCount():false;
		}else{
			return false;
		}
	}

	
	/*
	 * Delete data from the database
	 * @param string name of the table
	 * @param array where condition on deleting data
	 */
	public function DeleteData($table,$conditions){
		$whereSql = '';
		if(!empty($conditions)&& is_array($conditions)){
			$whereSql .= ' WHERE ';
			$i = 0;
			foreach($conditions as $key => $value){
				$pre = ($i > 0)?' AND ':'';
				$whereSql .= $pre.$key." = '".$value."'";
				$i++;
			}
		}
		$sql = "DELETE FROM ".$table.$whereSql;
		$delete = $this->db->exec($sql);
		return $delete?$delete:false;
	}   

	 /*
	 * Returns rows from the database based on the conditions
	 * @param string name of the table
	 * @param array select, where, order_by, limit and return_type conditions
	 */
	public function GetRows($table,$conditions = array()){
		$sql = 'SELECT ';
		$sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
		$sql .= ' FROM '.$table;
		if(array_key_exists("where",$conditions)){
			$sql .= ' WHERE ';
			$i = 0;
			foreach($conditions['where'] as $key => $value){
				$pre = ($i > 0)?' AND ':'';
				$sql .= $pre.$key." = '".$value."'";
				$i++;
			}
		}
		
		if(array_key_exists("order_by",$conditions)){
			$sql .= ' ORDER BY '.$conditions['order_by']; 
		}
		
		if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
			$sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
		}elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
			$sql .= ' LIMIT '.$conditions['limit']; 
		}
		
		$query = $this->db->prepare($sql);
		$query->execute();
		
		if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
			switch($conditions['return_type']){
				case 'count':
					$data = $query->rowCount();
					break;
				case 'single':
					$data = $query->fetch(PDO::FETCH_ASSOC);
					break;
				default:
					$data = '';
			}
		}else{
			if($query->rowCount() > 0){
				$data = $query->fetchAll();
			}
		}
		return !empty($data)?$data:false;
	}

	//Trim variables
	public function trim($string=""){
			$rtrim=rtrim($string);
			$ltrim=ltrim($string);
			return $ltrim;
	}

	//Validate Email Id
	public function EmailValidation($email=""){
		if (!stristr($email,"@") OR !stristr($email,".")) {
			return false;
		} else {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
			return true;
		 else 
			return false;
		}
	}

	//Check Email Id Exists
	public function EmailCheck($email=""){
		$check=$this->db->prepare("SELECT id FROM users WHERE email=:email");
		$check->execute(array("email"=>$email));
		$rowchk=$check->fetch(PDO::FETCH_ASSOC);
		if(!empty($rowchk))
			return false;
		else
			return true;
	}

	//Password Hashing
	public function PasswordHash($password=""){
	  $hash= password_hash($password,PASSWORD_BCRYPT,array(
			'cost' => 12,
		 ));
	  return $hash;
	}

	//Email Random Code
	public function EmailCode(){
		$code=md5(uniqid(rand(), true));
		return $code;
	}

	//Check AppType
	public function AppCheck(){
		$apptype = array("web", "ios", "android");
		if (in_array("web", $apptype) || in_array("ios", $apptype) || in_array("android", $apptype) )
			 return true;
		else  
			return false;
	}

	//Generate JWT Token
	public function GenerateToken($data=array()){
		$issuedAt   = time();
		$notBefore  = $issuedAt + 5;  //Adding 10 seconds
		$expire     = $notBefore + 7200; // Adding 60 seconds
		$tokenId    = base64_encode(openssl_random_pseudo_bytes(32));
		$token = array(
			"iss" => SITEURL,
			"iat" => $issuedAt,
			//"nbf" => $notBefore,
			//'exp'  => $expire,  
			'jti'  => $tokenId,    
		"data" => $data
		);
		 $jwt = JWT::encode($token, JWTKEY);
		 return $jwt;
	}

	//Check Valid JWT Token
	public function CheckValidToken($token=""){
		if($token){
			  try {
				 $decoded = JWT::decode($token, JWTKEY, array('HS256'));
				   $aVars=array(
						"msg" => "Access granted.",
						"data" => $decoded->data,
						"status" => 1
					);
			   }catch (Exception $e){
				$aVars=array(
					"msg" => "Access denied.",
					"status" => 0,
					"error" => $e->getMessage()
				);
			}
		}else{
			$aVars=array("status"=>0,"msg"=>"Token Invalid");
		}

		return $aVars;
	}

	public function module($module){
		if(isset(self::$Module[$module])) include_once(self::$Module[$module]); else die("Module is Not Exists");
	}
	//Admin Header
	public function admin_header($title="",$metakey="",$metadesc=""){ ?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title><?php echo $title; ?></title>
		<meta name="description" content="<?php echo $metadesc; ?>" />
		<meta name="keywords" content="<?php echo $metakey; ?>" />
		<meta name="author" content="loadboard"/>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/morris.js/morris.css" rel="stylesheet" type="text/css"/>
		<link href="dist/css/style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo SITEURL; ?>app/admin/dist/css/jquery.multiselect.css" rel="stylesheet"/>


		</head>
		<body>
		<div class="preloader-it">
		<div class="la-anim-1"></div>
		</div>
		<div class="wrapper theme-1-active navbar-top-skyblue ">
			<!-- icon-only-nav -->
		<?php 
		$this->module('header');  
		$this->module('menu');  
		$this->module('rightmenu');  
		?>
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
					this.userid = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id']:''; ?>";
					this.email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email']:''; ?>";
					this.user_type = "<?php echo isset($_SESSION['user_type']) ? $_SESSION['user_type']:''; ?>";
					this.admintoken = "<?php echo isset($_SESSION['admintoken']) ? $_SESSION['admintoken']:''; ?>";
				};
				this.basepath = this.self.domain;
				this.APP = this.self.domain + "app/";
				this.API = this.self.domain + "api/";
				
				this.admintoken=this.user.admintoken;
				this.userid=this.user.userid;
				this.user_type=this.user.user_type;

				this.thispage = window.location.pathname.split("/").pop();
			} 
			var LoadBoard = new Global();
			Array.prototype.forEach||(Array.prototype.forEach=function(r){var t,n;if(null==this)throw new TypeError("this is null or not defined");var o=Object(this),e=o.length>>>0;if("function"!=typeof r)throw new TypeError(r+" is not a function");for(arguments.length>1&&(t=arguments[1]),n=0;e>n;){var i;n in o&&(i=o[n],r.call(t,i,n,o)),n++}});
			window.MODULE="loadboard";
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
		function formatPhoneNumber(phoneNumberString) {
			var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
			var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/)
			if (match) {
			return '(' + match[1] + ') ' + match[2] + ' - ' + match[3]
			}
			return null
		}



		</script>
	<?php }



	//Admin Footer
	public function admin_footer(){ ?>
		<?php  
			$this->module('footer'); 
		 ?>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
		<script src="dist/js/jquery.slimscroll.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
		<script src="dist/js/dropdown-bootstrap-extended.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/switchery/dist/switchery.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/echarts/dist/echarts-en.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/echarts-liquidfill.min.js"></script>
		<script src="dist/js/vectormap-data.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/peity/jquery.peity.min.js"></script>
		<script src="dist/js/peity-data.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/raphael/raphael.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/morris.js/morris.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/sweetalert/dist/sweetalert.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap-validator/dist/validator.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/moment/min/moment-with-locales.min.js"></script>
		<script type="text/javascript" src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="dist/js/init.js"></script>
		<script src="dist/js/dashboard-data.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/jszip/dist/jszip.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/pdfmake/build/pdfmake.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/pdfmake/build/vfs_fonts.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/admin/dist/js/jquery.multiselect.js"></script>
		<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
		<!-- <link rel="stylesheet" type="text/css" href="http://jvectormap.com/css/jquery-jvectormap-2.0.3.css">
		<script type="text/javascript" src="http://jvectormap.com/js/jquery-jvectormap-2.0.3.min.js"></script>
		<script type="text/javascript" src="http://jvectormap.com/js/jquery-jvectormap-us-aea.js"></script> -->
		<!-- <script src="<?php //echo SITEURL; ?>app/admin/dist/map/js/jquery.vmap.js"></script>
		<script src="<?php //echo SITEURL; ?>app/admin/dist/map/js/jquery.vmap.usa.js"></script> -->
		</body>
		</html>
	<?php }
		
	   //LoadBoard Header
	   public function Header($title="",$metakey="",$metadesc=""){ ?>
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
			<meta name="description" content="<?php echo $metadesc; ?>">
			<meta name="keywords" content="<?php echo $metakey; ?>">
			<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
			<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
			<!-- Generated: -->
			<title><?php echo $title; ?> </title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
			 <link href="<?php echo SITEURL; ?>app/assets/css/sweetalert2.css" rel="stylesheet" />
			<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

			<link href="<?php echo SITEURL; ?>app/assets/css/load.css" rel="stylesheet" />

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
					this.userid = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id']:''; ?>";
					this.email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email']:''; ?>";
					this.token = "<?php echo isset($_SESSION['token']) ? $_SESSION['token']:''; ?>";
					this.user_type = "<?php echo isset($_SESSION['user_type']) ? $_SESSION['user_type']:''; ?>";
				};
				this.basepath = this.self.domain;
				this.APP = this.self.domain + "app/";
				this.API = this.self.domain + "api/";
				this.token=this.user.token;
				this.userid=this.user.userid;
				this.user_type=this.user.user_type;
				this.thispage = window.location.pathname.split("/").pop();
			} 
			var LoadBoard = new Global();
			var LoadBoard_URL = LoadBoard.APP;
			//alert(LoadBoard_URL);
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

		   <link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/select2.min.css">
		   <link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/croppie.css">
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

		 <script src="<?php echo SITEURL; ?>app/assets/js/jquery.min_form.js"></script>
		 <script src="<?php echo SITEURL; ?>app/assets/js/croppie.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/sweetalert2.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/handsontable.full.min.js"></script>
		 <script src=" https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/d3.min.js"></script>
		<script src="<?php echo SITEURL; ?>app/assets/js/d3pie.js"></script> 
		<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-datepicker.css">
		<?php if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/trucker-profile")!=false){ ?>
		<link href="<?php echo SITEURL; ?>app/assets/css/animate.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
		<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
		<?php } ?>
		<?php if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/search-loads")!=false){ ?>
			 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/search-loads.js"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
		<?php } ?>
		<?php if(strpos($_SERVER['REQUEST_URI'], "/app/broker/loads-reports")!=false){ ?>
			 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/loads-reports.js"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-multiselect.css">

		<?php } ?>
		<?php if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/loads-reports")!=false){ ?>
			 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/shipper-loads-reports.js"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-multiselect.css">

		<?php } ?>
		<?php if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads-reports")!=false){ ?>
			 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/trucker-loads-reports.js"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-multiselect.css">

		 <?php } ?>
		 <?php if(strpos($_SERVER['REQUEST_URI'], "/app/broker/add-load")!=false){ ?>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-datepicker.css">
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/add-load.js"></script>
		 <?php } ?>
		 <?php if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/add-load")!=false){ ?>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places"></script>
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/bootstrap-datepicker.min.js"></script>
			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/bootstrap-datepicker.css">
			<script type="text/javascript" src="<?php echo SITEURL; ?>app/assets/js/shipper-add-load.js"></script>
		 <?php } ?>
		 <?php if(strpos($_SERVER['REQUEST_URI'], "/app/broker/view-bulk")!=false){ ?>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places&sensor=true"></script>
		 <?php } ?>
		 <?php if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/view-bulk")!=false){ ?>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLEAPI; ?>&amp;libraries=places&sensor=true"></script>
		 <?php } ?>

		  <link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/form_custom.css">
			<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/toastr.min.css">
			<script src="<?php echo SITEURL; ?>app/assets/js/toastr.min.js"></script>
			<script src="<?php echo SITEURL; ?>app/assets/js/require.min.js"></script>
<!--             <script src="<?php echo SITEURL; ?>app/assets/js/jquery-1.11.1.min.js"></script>
 -->            <script>
			requirejs.config({
				 baseUrl: '.'
			});
			</script>
			<link href="<?php echo SITEURL; ?>app/assets/css/dashboard.css" rel="stylesheet" />
			<script src="<?php echo SITEURL; ?>app/assets/js/dashboard.js"></script>
			<script src="<?php echo SITEURL; ?>app/assets/plugins/input-mask/plugin.js"></script>
			<script type="text/javascript">
				$( document ).ready(function() {
				   /* $('.my-md-5').attr('id', 'container-top');
					var el = document.getElementById("container-top");
					var height = el.offsetHeight;
					var newHeight = height + 100;
					el.style.height = newHeight + 'px';*/
				});               
			</script>
		   </head>
			<body class="">
			<div class="page">
			<div class="page-main">
			<?php 
				$this->module('load_header'); 
				$this->module('load_modal'); 
				if($_SESSION['user_type']=='broker'){
					$this->module('trucker_modal_popup');
				}else if($_SESSION['user_type']=='trucker'){
					$this->module('load_cancel_modal'); 
					$this->module('broker_modal_popup');
				}else if($_SESSION['user_type']=='shipper'){
					$this->module('trucker_modal_popup');
				}
					


				
				$this->FirstTimeProfileCheck();
				$verifychk=$this->VerifiedCheck();
				if($verifychk==true){
					if($_SESSION['user_type']=='broker')
						 $this->module('load_broker_menu'); 
					 elseif($_SESSION['user_type']=='trucker')
						 $this->module('load_trucker_menu'); 
					 elseif($_SESSION['user_type']=='shipper')
						 $this->module('load_shipper_menu'); 
				}
			//Check Page level
			 if($_SESSION['user_type']=="trucker"){
				  if(strpos($_SERVER['REQUEST_URI'], "/app/broker/view-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/add-load")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/bulk-upload")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/in-progress")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/broker/past-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/dashboard")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/broker-profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/past-loads")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/broker/expired-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/broker/loads-reports")!=false ||  strpos($_SERVER['REQUEST_URI'], "/app/broker/trucker-list")!=false    ){
						 header("Location:".SITEURL."404");
						 exit;
					}
			  }elseif($_SESSION['user_type']=="broker"){
				  if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/search-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/myloads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/upcoming-trips")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/awaiting-approval")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/in-progress")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/past-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/dashboard")!=false   || strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads-reports")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/trucker-profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/broker-list")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/trucker/view-list")!=false  ){
						 header("Location:".SITEURL."404");
						 exit;
					}
			  }elseif($_SESSION['user_type']=="shipper"){

				  if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/search-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/myloads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/upcoming-trips")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/awaiting-approval")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/in-progress")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/past-loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/dashboard")!=false   || strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads-reports")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/trucker/loads")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/trucker-profile")!=false || strpos($_SERVER['REQUEST_URI'], "/app/trucker/broker-list")!=false  || strpos($_SERVER['REQUEST_URI'], "/app/trucker/view-list")!=false  ){
						 header("Location:".SITEURL."404");
						 exit;
					}
			  
			  }else{
				  header("Location:".SITEURL."app/logout");
				  exit();
			  } 

			


	   }

		//LoadBoard Verified Check
		public function VerifiedCheck(){
				$checkheader=$this->db->prepare("SELECT verified_status FROM users WHERE id=:id AND status=1 AND verified_status=2");
				$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
				$checkheader->execute(array("id"=>$user_id));
				$rowchk=$checkheader->fetch(PDO::FETCH_ASSOC);
				if(!empty($rowchk)){
					return true;
				}else{
					return false;
			}

		}

		//LoadBoard Verified Fisttime Check
		public function FirstTimeProfileCheck(){
				$checkheader=$this->db->prepare("SELECT verified_status FROM users WHERE id=:id AND status=1 AND verified_status=2");
				$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
				$checkheader->execute(array("id"=>$user_id));
				$rowchk=$checkheader->fetch(PDO::FETCH_ASSOC);

				if(!empty($rowchk)){
					if($_SESSION['user_type']=='broker'){
						if(strpos($_SERVER['REQUEST_URI'], "/app/broker/profile")!=false){
							header("Location:".SITEURL."app/broker/add-load");
							exit();
						}
					}elseif($_SESSION['user_type']=='shipper'){
						if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/profile")!=false){
							header("Location:".SITEURL."app/shipper/add-load");
							exit();
						}
					}elseif($_SESSION['user_type']=='trucker'){
						if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/profile")!=false){
							header("Location:".SITEURL."app/trucker/search-loads");
							exit();
						}
					}
				}else{
					if($_SESSION['user_type']=='broker'){
						if(strpos($_SERVER['REQUEST_URI'], "/app/broker/profile")==false){
							header("Location:".SITEURL."app/broker/profile");
							exit();
						}
				 }elseif($_SESSION['user_type']=='shipper'){
						if(strpos($_SERVER['REQUEST_URI'], "/app/shipper/profile")==false){
							header("Location:".SITEURL."app/shipper/profile");
							exit();
						}
				 }elseif($_SESSION['user_type']=='trucker'){
				 	if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/profile")==false){
							header("Location:".SITEURL."app/trucker/profile");
							exit();
						}
				 } 
			}

		}

	   //LoadBoard Footer
	   public function Footer(){
			$this->module('load_footer'); ?>
			 <link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>app/assets/css/animate.css">
			 <script type="text/javascript">
				function distancecal(lat1, lon1, lat2, lon2, unit) {
					if ((lat1 == lat2) && (lon1 == lon2)) {
						return 0;
					}
					else {
						var radlat1 = Math.PI * lat1/180;
						var radlat2 = Math.PI * lat2/180;
						var theta = lon1-lon2;
						var radtheta = Math.PI * theta/180;
						var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
						if (dist > 1) {
						dist = 1;
						}
						dist = Math.acos(dist);
						dist = dist * 180/Math.PI;
						dist = dist * 60 * 1.1515;
						if (unit=="K") { dist = dist * 1.609344 }
						if (unit=="N") { dist = dist * 0.8684 }
						return Math.round(dist);
						}
					}
			 </script>
			 <?php 
	   }

	   //Before Login Check
	   public function BeforeloginCheck(){
			$email=isset($_SESSION['email']) ? $_SESSION['email'] : '';
			$token=isset($_SESSION['token']) ? $_SESSION['token'] : '';
			$checkvalid=$this->CheckValidToken($token);
			$check=$this->db->prepare("SELECT email,user_type FROM users WHERE email=:email AND status=1");
			$check->execute(array("email"=>$email));
			$rowchk=$check->fetch(PDO::FETCH_ASSOC);
			$loggedin=isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : '';

			if($loggedin == 1 && isset($loggedin)  && $checkvalid['status']==1 ){
				if($_SESSION['user_type']=='broker'){ 
					header("Location:".SITEURL."app/broker/add-load");
					exit();
				}elseif($_SESSION['user_type']=='trucker'){ 
					header("Location:".SITEURL."app/trucker/search-loads");
					exit();
				}elseif($_SESSION['user_type']=='shipper'){ 
					header("Location:".SITEURL."app/shipper/add-load");
					exit();
				}
			}
	   }

	   //After Login Check
	   public function AfterloginCheck(){
			if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1){
				 
				 if((time() - $_SESSION['timestamp']) > 900){
					header("Location:".SITEURL."app/logout");
					exit();
				 }else{
 					$_SESSION['timestamp'] = time();
 				 }
			}else{
				 header("Location:".SITEURL."app/logout");
				  exit();
			}			

	   }


	   //Before Admin Login Check
	   public function BeforeAdminloginCheck(){
			$email=isset($_SESSION['email']) ? $_SESSION['email'] : '';
			$token=isset($_SESSION['admintoken']) ? $_SESSION['admintoken'] : '';
			$checkvalid=$this->CheckValidToken($token);
			$check=$this->db->prepare("SELECT email,user_type FROM admin_users WHERE email=:email AND status=1");
			$check->execute(array("email"=>$email));
			$rowchk=$check->fetch(PDO::FETCH_ASSOC);
			$admin_loggedin=isset($_SESSION['admin_loggedin']) ? $_SESSION['admin_loggedin'] : '';

			if($admin_loggedin == 1 && isset($admin_loggedin)  && $checkvalid['status']==1 ){
				header("Location:".SITEURL."app/admin/dashboard");
				exit();
			}
	   }

		//After Admin Login Check
	   public function AfterAdminloginCheck(){
			if(!isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin']==0){
				  header("Location:".SITEURL."app/admin/logout");
				  exit();
			}
	   }
	   //Login Check
	   public function LoginCheck(){

			$email=isset($_SESSION['email']) ? $_SESSION['email'] : '';
			$token=isset($_SESSION['token']) ? $_SESSION['token'] : '';
			$checkvalid=$this->CheckValidToken($token);
			$check=$this->db->prepare("SELECT email,user_type FROM users WHERE email=:email AND status=1");
			$check->execute(array("email"=>$email));
			$rowchk=$check->fetch(PDO::FETCH_ASSOC);
			$loggedin=isset($_SESSION['loggedin']) ? $_SESSION['loggedin'] : '';

			if($loggedin == 1 && isset($loggedin)  && $checkvalid['status']==1 ){
				if($_SESSION['user_type']=='broker'){  ?>
					<script type="text/javascript">
						var site="<?php echo SITEURL; ?>";
						window.open=site+"app/broker/add-load";
					</script>
					<?php 
				 }else{ ?>
					 <script type="text/javascript">
						var site="<?php echo SITEURL; ?>";
						window.open=site+"app/logout";
					</script>
					<?php 
				 }
			 }else{ 
				  ?>
					 <script type="text/javascript">
						var site="<?php echo SITEURL; ?>";
						window.open=site+"app/logout";
					</script>
					<?php 
			  }

	   }

	   // Equipment truck type starts here
		public function equipment_type(){
			$equip_type_qry = $this->db->prepare("SELECT * FROM truck_type WHERE status = '1'");
			$equip_type_qry->execute();
			$fetch= array();
			while($equip_type_row = $equip_type_qry->fetch(PDO::FETCH_ASSOC)){
				$fetch[]=$equip_type_row;
			}
			return $fetch;
		}


		//Send Email
		public function SendEmail($from_email="",$to_email="",$subject="",$content=""){
			$mail = new PHPMailer;
			$mail->isSMTP();                            
			$mail->charSet = "UTF-8"; 
			$mail->Host = 'smtp.gmail.com';             
			$mail->SMTPAuth = true;                    
			$mail->Username = 'loadboard.j@gmail.com';          
			$mail->Password = 'test@12345'; 
			$mail->SMTPSecure = 'tls';                  
			$mail->Port = 587; 
		   // $mail->SMTPDebug = 2;                      
			$mail->setFrom($from_email, 'LoadBoard');
			//$mail->addReplyTo('sendhil.8012@gmail.com', '');
			$mail->addAddress($to_email); 
			//$mail->addCC('Senthilkumar.Rengaraj@jeevantechnologies.com');
			//$mail->addBCC('senthilrengaraj.90@gmail.com');
			$mail->isHTML(true);  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $content;
			//$mail->SMTPDebug = 2;
			if(!$mail->send()) {
				 return $mail->ErrorInfo;
			}else{
				return '';
			}

		}

				//Send Email
		public function AdminSendEmail($from_email="",$to_email="",$subject="",$content=""){
			$mail = new PHPMailer;
			$mail->isSMTP();                            
			$mail->charSet = "UTF-8"; 
			$mail->Host = 'smtp.gmail.com';             
			$mail->SMTPAuth = true;                    
			$mail->Username = 'loadboard.j@gmail.com';          
			$mail->Password = 'test@12345'; 
			$mail->SMTPSecure = 'tls';                  
			$mail->Port = 587; 
		   // $mail->SMTPDebug = 2;                      
			$mail->setFrom($from_email, 'LoadBoard');
			//$mail->addReplyTo('sendhil.8012@gmail.com', '');
			$mail->addAddress($to_email); 
			//$mail->addCC('Senthilkumar.Rengaraj@jeevantechnologies.com');
			//$mail->addBCC('senthilrengaraj.90@gmail.com');
			$mail->isHTML(true);  // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $content;
			//$mail->SMTPDebug = 2;
			if(!$mail->send()) {
				 return $mail->ErrorInfo;
			}else{
				return 1;
			}

		}

		 //Get Broker Id
		public function broker_check($user_id){
				$view_loads_qry =$this->db->prepare("SELECT id,user_id FROM broker where user_id = ".$user_id);
				$view_loads_qry->execute();
				$row = $view_loads_qry->fetch(PDO::FETCH_ASSOC);
				$broker_id = $row["id"];
				return $broker_id;
		}
		//Get Shipper Id
		public function shipper_check($user_id){
				$view_loads_qry =$this->db->prepare("SELECT id,user_id FROM shipper where user_id = ".$user_id);
				$view_loads_qry->execute();
				$row = $view_loads_qry->fetch(PDO::FETCH_ASSOC);
				$shipper_id = $row["id"];
				return $shipper_id;
		}

		 //do not special character
		public function CharacterCheck($string=""){
		 if (preg_match('/[\'^£$%&*0-9()}{@#~?><>,|=_+¬-]/', $string))
				return false;
			else
				return true;
		}

		// Only Alphanumerice
		public function alphaNumeric($string=""){
			if (preg_match('/^[a-zA-Z0-9 ]/',$string)){
			   return true;
			} else {
			    return false;
			}
		}


		//Mobile Types
		public function CheckApptype($str=""){
				$app_types = array("web","android","ios"); 
				if (in_array($str, $app_types)) 
					return true;
				else
				   return false;
		}

		//  US Phone number validations
		public function PhoneNoCheck($phone=""){
			
		// if (preg_match("/^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/",$phone))
		 if (preg_match("/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/",$phone))
			return true;
		else
		   return false;
		}

		public function Lenthfeetset($string=""){
		 if (preg_match('/^[0-9]{2}$/', $string))
				return true;
			else
				return false;
		}

		//Zipcode Validation
		 public function ZipcodeCheck($zipcode=""){
			if (preg_match('/^[0-9]{5}(-[0-9]{4})?$/',$zipcode))
			return true;
		 else
			return false;
		  }

		// Get Trucker Details using User id
		public function TruckerDetails($user_id=""){
			$trucker_det = $this->db->prepare("SELECT * FROM trucker WHERE status = :status AND user_id =:user_id ");
			$trucker_det->execute(array("status"=>1,"user_id"=>$user_id));
			$row = $trucker_det->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}

		 // Get Shipper Details using User id
		public function ShipperDetails($user_id=""){
			$shipper_det = $this->db->prepare("SELECT * FROM shipper WHERE status = :status AND user_id =:user_id ");
			$shipper_det->execute(array("status"=>1,"user_id"=>$user_id));
			$row = $shipper_det->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}
		public function ShipperUserDetails($user_id=""){
			$shipper_userdet = $this->db->prepare("SELECT * FROM users WHERE status = :status AND id =:id ");
			$shipper_userdet->execute(array("status"=>1,"id"=>$user_id));
			$row = $shipper_userdet->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}

		 // Get Broker Details using User id
		public function BrokerDetails($user_id=""){
			$broker_det = $this->db->prepare("SELECT * FROM broker WHERE status = :status AND user_id =:user_id ");
			$broker_det->execute(array("status"=>1,"user_id"=>$user_id));
			$row = $broker_det->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}

		 // Get Broker User Details using  UserId
		public function BrokerUserDetails($user_id=""){
			$broker_userdet = $this->db->prepare("SELECT * FROM users WHERE status = :status AND id =:id ");
			$broker_userdet->execute(array("status"=>1,"id"=>$user_id));
			$row = $broker_userdet->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}

		 // Get Broker User Details using  UserId
		public function UserDetails($user_id=""){
			$broker_userdet = $this->db->prepare("SELECT * FROM users WHERE status = :status AND id =:id ");
			$broker_userdet->execute(array("status"=>1,"id"=>$user_id));
			$row = $broker_userdet->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}

		  // Get Broker User Details using  UserId
		public function TruckerUserDetails($user_id=""){
			$trudets = $this->db->prepare("SELECT * FROM users WHERE status = :status AND id =:id ");
			$trudets->execute(array("status"=>1,"id"=>$user_id));
			$row = $trudets->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}
		 // Get Shipper User Details using  UserId
		/*public function ShipperUserDetails($user_id=""){
			$broker_userdet = $this->db->prepare("SELECT * FROM users WHERE status = :status AND id =:id ");
			$broker_userdet->execute(array("status"=>1,"id"=>$user_id));
			$row = $broker_userdet->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}*/


		// Get State Name
		public function GetStateName($code=""){
			$code_state = $this->db->prepare("SELECT state FROM zipcode WHERE abbreviation = :abbreviation ");
			$code_state->execute(array("abbreviation"=>$code));
			$row = $code_state->fetch(PDO::FETCH_ASSOC);
			if(!empty($row))
				return $row['state'];            
			else
				return '';
		}

		 // Get Load details 
		public function GetLoad($id=""){
			$loads = $this->db->prepare("SELECT * FROM loads WHERE id = :id ");
			$loads->execute(array("id"=>$id));
			$row = $loads->fetch(PDO::FETCH_ASSOC);
			return $row;            
		}


		//Zipcode Validation
		 public function ZipValidatation($state_name="",$city_name="",$zipcode=""){
			$data=array(
				"st_name" => $state_name,
				"ct_name" => $city_name
			);
			$zip_stmt =$this->db->prepare("SELECT zip_code FROM public.zipcode where state= :st_name and city= :ct_name");
			$zip_stmt->execute($data);
			$zip_results = $zip_stmt->fetchAll();
			if(!empty($zip_results)){
				$zip=[];
				foreach ($zip_results as $key => $values){
					$zip[]=$values['zip_code'];
				}
				if(in_array($zipcode, $zip)){
					return true;
				}else{
					return false;  
				}
			}else{
				return false;  
			}
		}


		//Get Distance Value KM
		public function GetDistance($origin="",$destination=""){
			$from = urlencode($origin);
			$to = urlencode($destination);
			$data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false&key=".GOOGLEAPI);
			$data = json_decode($data,true);

			if($data['status']=='OK'){
			  if($data['rows'][0]['elements'][0]['status']=='ZERO_RESULTS'){
				$value=0;
			  }else{
				 $value=$data['rows'][0]['elements'][0]['distance']['text'];  
			  }
			}
			return $value;            

		}

	   //Encode the data 
	   public function encode($string){
		if($string!="")
			return base64_encode(openssl_encrypt($string, self::CRYPT, self::KEY));
		else 
			return '';
		}
	
	   //Decode the data 
	   public function decode($string){
		if($string!="")
			return openssl_decrypt(base64_decode($string), self::CRYPT, self::KEY);
		else 
			return '';
		}


		public function timeAgo($date) {
		   $timestamp = strtotime($date);   
		   
		   $strTime = array("second", "minute", "hour", "day", "month", "year");
		   $length = array("60","60","24","30","12","10");

		   $currentTime = time(); 
		   if($currentTime >= $timestamp) {
				$diff     = time()- $timestamp;
				for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
				$diff = $diff / $length[$i];
				}

				$diff = round($diff);
				return $diff . " " . $strTime[$i] . "(s) ago ";
		   }
		}

	  
		public function state_checking($data){
			$state_stmt = $this->db->prepare( "SELECT * FROM states WHERE country_id = :cid and name ILIKE :name");
			$state_stmt->execute(array(":cid"=>'231',":name"=>$data));
			$state_results = $state_stmt->rowCount();
			$state_count = $state_stmt->rowCount();
				if($state_count == '' && $state_count == 0 && $state_count == null && $state_count == '0'){
				  return false;
				}else{
				  return true;
				}
		}

	   public function city_checking($data){
		$city_stmt = $this->db->prepare( "SELECT  * FROM cities WHERE name ILIKE :name AND state_id = ANY(ARRAY[3919, 3920, 3921, 3922, 3923, 3924, 3925, 3926, 3927, 3928, 3929, 3930, 3931, 3932, 3933, 3934, 3935, 3936, 3937, 3938, 3939, 3940, 3941, 3942, 3943, 3944, 3945, 3946, 3947, 3948, 3949, 3950, 3951, 3952, 3953, 3954, 3955, 3956, 3957, 3958, 3959, 3960, 3961, 3962, 3963, 3964, 3965, 3966, 3967, 3968, 3969, 3970, 3971, 3972, 3973, 3974, 3975, 3976, 3977, 3978])");
		$city_stmt->execute(array(":name"=>$data));
		$city_count = $city_stmt->rowCount();
			if($city_count == '' && $city_count == 0 && $city_count == null && $city_count == '0'){
				return false;
			}else{
				 return true;
			}
		}
		

		public function getAuthorizationHeader(){
	        $headers = null;
	        if (isset($_SERVER['Authorization'])) {
	            $headers = trim($_SERVER["Authorization"]);
	        }
	        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	        }elseif (function_exists('apache_request_headers')) {
	            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            //print_r($requestHeaders);
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	            }
	        }
	        return $headers;
	    }
		/**
		 * get access token from header
		 * */
		public function getBearerToken() {
		    $headers = $this->getAuthorizationHeader();
		    // HEADER: Get the access token from the header
		    if (!empty($headers)) {
		        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
		            return $matches[1];
		        }
		    }
		    return null;
		}

		public function encrypt($plaintext="",$key="") {
	        $ivSize = mcrypt_get_iv_size(self::CIPHER, self::MODE);
	        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM);
	        $ciphertext = mcrypt_encrypt(self::CIPHER, $key, $plaintext, self::MODE, $iv);
	        return base64_encode($iv.$ciphertext);
   		}

   		 public function decrypt($ciphertext="",$key="") {
	        $ciphertext = base64_decode($ciphertext);
	        $ivSize = mcrypt_get_iv_size(self::CIPHER, self::MODE);
	        if (strlen($ciphertext) < $ivSize) {
	            throw new Exception('Missing initialization vector');
	        }

	        $iv = substr($ciphertext, 0, $ivSize);
	        $ciphertext = substr($ciphertext, $ivSize);
	        $plaintext = mcrypt_decrypt(self::CIPHER, $key, $ciphertext, self::MODE, $iv);
	        return rtrim($plaintext, "\0");
    	}

    	public function Getkey() {
			$key = hash_hmac('sha256',$_SESSION['user_id'], 'LB!@##@!');
			if (strlen($key) > 24) {
				$key = substr($key, 0, 24);
			}
			return $key;
   		}




}


?>