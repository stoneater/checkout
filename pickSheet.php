<?php
include ('mpdf/mpdf.php');
$mpdf=new mPDF('','Letter', 0, '', 12, 12, 12, 12, 1, 1, '');
ob_start();
require_once 'config.php';
require_once 'dbopen.php';

if ($_POST['block']) $block = $_POST['block'];
if ($_POST['day']) $day = date('Y-m-d', strtotime($_POST['day']));

if ($debug){
	echo "day is <b>$day </b><br>";
	echo "Block requested: <b>".$block."</b><br>";
}
$theEnd=0; //set to find last iteration later

// get requestNumbers of selected blocks
$query = "select block".$block." from reserved where day like '".$day."' and block".$block." > 0 group by block".$block;
if($debug) echo "Query is: <b>".$query."</b><br>";
$result= mysqli_query($mysqli, $query);

// take requestNumbers and get the teacher information for each batch of computers
if(mysqli_num_rows($result) > 0) {
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
		foreach( $row as $value) {
			$subQuery = "select teacher_name, teacher_email, location from reservation where requestNumber = ".$value;
			if($debug) echo "subquery is:<b> ".$subQuery. "</b><br>";
			$subResult = mysqli_query($mysqli, $subQuery); 
				while ($innerRow= mysqli_fetch_array($subResult,MYSQLI_NUM)) {
					echo "Teacher's Name: ".$innerRow[0].", Room number: ".$innerRow[2].", On ".date('d-M-Y', strtotime($day))."<br>";
					} 
		}
		$subSubQuery = "Select day, asset, block".$block." from reserved where block".$block." like ".$value;
		if($debug) echo "Query is: ".$subSubQuery."<br>";
		$subSubResult= mysqli_query($mysqli, $subSubQuery);
		$ending = mysqli_num_rows($subSubResult);
		if($ending > 0) {
			$theEnd++;
			echo "<table width='50%'><tr><td>Computer numbers: <ul>";
			while ($innerspace= mysqli_fetch_array($subSubResult,MYSQLI_NUM)) {
				echo "<li>".$innerspace[1];
				if ($innerspace[1] < 10) echo "&nbsp;&nbsp;";
				echo "&nbsp;<svg height='20' width='500'><line x1='0' y1='19' x2='450' y2='19' style='stroke:rgb(0,0,0);stroke-width:2' />Sorry, your browser does not support inline SVG.</svg></li>";
			}
			if ($theEnd != $ending)	{
				echo "</ul></td></tr></table>";
			}else{
				echo "</ul></td></tr></table><pagebreak>";
				$theEnd++;
			}				
		}
	}
} else {
	echo "No computers are checked out on ".$day." during the requested block<br>";
}

require_once 'dbclose.php';
require_once 'end.php';
$html=ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();
//echo $html;
exit;
?>
