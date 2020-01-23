<?php 
require_once("../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$org = isset($_REQUEST['org']) ? $_REQUEST['org']: '';
$des = isset($_REQUEST['des']) ? $_REQUEST['des']: '';
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCZ6GJJEYGAwZHI52rud9kmsWN8t6CdvtE&z=9"  ></script>
<script type="text/javascript">
  var org="<?php echo $org; ?>";
  var des="<?php echo $des; ?>";
  var orgval=window.atob(org);
  var desval=window.atob(des);
  var directionDisplay;
  var directionsService = new google.maps.DirectionsService();
  var map;
  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var myOptions = {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      zoom: 13,
      zoomControl: true,
      scaleControl: true,
      controlSize: 25,
      fullscreenControl: true,
    }

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    directionsDisplay.setMap(map);
    var org_1=orgval.split(",");
    var des_1=desval.split(",");

    var start = org_1[0]+","+org_1[1];
    var end = des_1[0]+","+des_1[1];
   
    var request = {
      origin:orgval, 
      destination:desval,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
        var myRoute = response.routes[0];
        var txtDir = '';
        for (var i=0; i<myRoute.legs[0].steps.length; i++) {
          txtDir += myRoute.legs[0].steps[i].instructions+"<br />";
        }
      }
    });
  }


</script>
</head>
<body onload="initialize()">
<div id="map_canvas" style="width:100%;height:100%;"></div>
</body>
</html>