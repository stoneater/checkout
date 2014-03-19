<?php
include ('mpdf/mpdf.php');
$mpdf=new mPDF('','Letter', 0, '', 12, 12, 12, 12, 1, 1, '');
ob_start();
require_once 'config.php';
require_once 'dbopen.php';

$debug = true;
$day="2014-03-27";

if ($_POST['day']) $day = date('Y-m-d', strtotime($_POST['day']));

// get requestNumbers of all requests on that day
$query = "select requestNumber,location from reservation inner join
	(SELECT distinct block1 as blocks FROM reserved where day like '".$day."'
    union SELECT distinct block2 FROM reserved where day like '".$day."'
    union SELECT distinct block3 FROM reserved where day like '".$day."'
    union SELECT distinct block4 FROM reserved where day like '".$day."')
	as blocks 
	on blocks.blocks = reservation.requestNumber";

if($debug) echo "Query is: ".$query."<br>";
$result= mysqli_query($mysqli, $query);

if(mysqli_num_rows($result) > 0) {
	echo "<h1>The computers on ".$day." are as follows:</h1>";
	echo "<table><thead><tr><td>requestNumber</td>&nbsp;&nbsp;<td></td><td>location</td></tr></thead>";
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
		$lookupArray[$row[0]] = $row[1];
	}
	
} else {
	echo "No computers are checked out on ".$day."<br>";
}
echo "</table>";
echo "The lookup for number 147 is ".$lookupArray["147"]."<br>";

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
