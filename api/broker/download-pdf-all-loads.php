
<?php
require_once("../../elements/Global.php");

require_once "../../config/phpToPDF.php";

$Global=new LoadBoard();

$operation = isset($_REQUEST['operation']) ? $_REQUEST['operation']: '';
$user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id']: '';
$rowperpage = isset($_REQUEST['length']) ? $_REQUEST['length']: '10';
if($rowperpage=="all"){
	$title="All_Loads";
} else {
	$title ="current";
	$rowperpage = "10";
}
$row="0";

$html="


<table class='table table-bordered' style='border-collapse:collapse;' width='100%'>
	<tr>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'></th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'></th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'></th>

		

		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'>ORIGIN </th>
		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'>DESTINATION </th>
	

		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'>PICKUP</th>
		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'>DELIVERY</th>


		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'></th>

		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'></th>		
	</tr>
	<tr>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'>ID</th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'>ORIGIN</th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'>DESTINATION</th>

		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'> CITY </th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'> ZIPCODE</th>

		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'> CITY </th>
		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'> ZIPCODE</th>

		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'> DATE</th>
		<th colspan='2' style='text-align:center;border:1px solid #ddd;font-size:14px;'>TIME</th>

		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'>EQUIPMENT</th>

		<th style='text-align:center;border:1px solid #ddd;font-size:14px;'>PRICE</th>
	</tr>";
$i=1;
if($operation=="pending"){
$sql = "
SELECT l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
		l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
		l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
		truck_load_type , l.weight , l.length , l.price , l.status ,l.truck_id , tt.truck_name
		FROM loads l INNER JOIN  truck_type tt
		ON l.status=0 AND l.user_id=:user_id AND  l.pickup_date >= CURRENT_DATE 
		AND l.truck_id = tt.id
		ORDER by l.id DESC ";
} else if($operation=="delivered"){
$sql = "
		SELECT l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
		l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
		l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
		truck_load_type , l.weight , l.length , l.price , l.status ,l.truck_id , tt.truck_name
		FROM loads l INNER JOIN  truck_type tt
		ON l.status=4 AND l.user_id=:user_id AND l.truck_id = tt.id
		ORDER by l.id DESC ";
}else if($operation=="picked"){
		$sql = "SELECT l.load_id , l.origin , l.destination ,l.origin_address , l.origin_state , l.origin_city ,  
		l.origin_zipcode , l.destination_address , l.destination_state , l.destination_city,
		l.destination_zipcode , l.pickup_date , l.delivery_date , l.pickup_time , l.delivery_time ,
		truck_load_type , l.weight , l.length , l.price , l.status ,l.truck_id , tt.truck_name
		FROM loads l INNER JOIN  truck_type tt
		ON l.status=3 AND l.user_id=:user_id 
		AND l.truck_id = tt.id
		ORDER by l.id DESC LIMIT ".$rowperpage." OFFSET ".$row;
}
//echo $sql;exit;
$query = $Global->db->prepare($sql);
$query->execute(array("user_id"=>$user_id));
$loadfetch_results = $query->fetchAll();
foreach ($loadfetch_results as $key => $values) {
//while($data = $query->fetch(PDO::FETCH_ASSOC)){	

$load_id_exp = explode('-',$values["load_id"]);

$html.="

	<tr>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values["load_id"]."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values["origin"]."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['destination']."</td>
		
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['origin_city']."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['origin_zipcode']."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['destination_city']."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['destination_zipcode']."</td>
		

		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".date("m/d/y",strtotime($values['pickup_date']))."</td>
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['pickup_time']."</td>

		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".date("m/d/y",strtotime($values['delivery_date']))."</td>

		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values['delivery_time']."</td>
		
		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'>".$values["truck_name"]."</td>

		<td style='text-align:center;border:1px solid #ddd;font-size:12px;width:10%'><label> $ </label> ".$values['price']."</td>
		
	</tr>
	";
	$i++;
}
$html.="</table></div>";

	$html.="
</table>
</html>";

//echo $html;

phptopdf_html($html,'', '../../sample-pdf/All_PDF_LOADS_REPORT.pdf');

//echo ("<a href='../../sample-pdf/All_PDF_LOADS_REPORT.pdf'>Download Your PDF</a>");


$filename = "All_PDF_LOADS_REPORT.pdf";

?>
<script type="text/javascript">
	window.location.href="<?php echo SITEURL ?>sample-pdf/All_PDF_LOADS_REPORT.pdf";
</script>