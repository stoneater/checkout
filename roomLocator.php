<?php
include ('mpdf/mpdf.php');
$mpdf=new mPDF('','Letter', 0, '', 12, 12, 12, 12, 1, 1, '');
ob_start();
require_once 'config.php';
require_once 'dbopen.php';

if ($_POST['location']) $location = $_POST['location'];

// get requestNumbers of selected blocks
$query = "select teacher_name,location,numberComputers from reservation,reserved where reserved.block1=reservation.requestNumber and location like ".$location." group by requestNumber";

if($debug) echo "Query is: ".$query."<br>";
$result= mysqli_query($mysqli, $query);

if(mysqli_num_rows($result) > 0) {
	echo "<h1>The newer computers in ".$location." are assigned as follows:</h1>";
	echo "<table><thead><tr><td>Asset Number</td><td>Block1</td><td>Block2</td><td>Block3</td><td>Block4</td></tr></thead>";
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
		if ($row[0]==300) echo "</table><pagebreak><h1>The older computers on ".$location." are assigned as follows:</h1><table><thead><tr><td>Asset Number</td><td>Block1</td><td>Block2</td><td>Block3</td><td>Block4</td></tr></thead>";
		echo "<tr><td>".$row[0]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";
	}
} else {
	echo "No computers are checked out on ".$location." during the requested block<br>";
}
echo "</table>";
require_once 'dbclose.php';
require_once 'end.php';
$html=ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>
