<?php
$outputType = "html";
$query="";

include ('mpdf/mpdf.php');
$mpdf=new mPDF('','Letter', 0, '', 12, 12, 12, 12, 1, 1, '');
ob_start();
require_once 'config.php';
require_once 'dbopen.php';

if($_GET['reservation']) $reservation = $_GET['reservation'];
if($_GET['limit']) $limit = $_GET['limit'];

if ($debug) echo "$reservation <br> is $reservation and limit is $limit<br>";
// Cycle through the blocks removing all reservations

for ($counter = 1; $counter <=4; $counter++){
		$query .= "update reserved set block".$counter." = null where block".$counter." ='".$reservation."';";
	}

if($debug) echo "Query is: $query<br>";
$result= mysqli_multi_query($mysqli, $query);

echo  mysqli_affected_rows($mysqli)." rows were updated<br>";

mysqli_free_result;

$query = "delete from reservation where requestNumber = ".$reservation." limit ".$limit;
if ($debug) echo "$request total delete is <br>$query";

$result = mysqli_query($mysqli, $query);


echo  "And in the request, ".mysqli_affected_rows($mysqli)." rows were updated";

mysqli_free_result;

require_once 'dbclose.php';
require_once 'end.php';
$html=ob_get_contents();
ob_end_clean();

if ($outputType == "pdf") {
	$mpdf->WriteHTML($html);
	$mpdf->Output();
} else {
	echo $html;
}

exit;
?>