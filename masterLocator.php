<?php
include ('mpdf/mpdf.php');
$mpdf=new mPDF('','Letter', 0, '', 12, 12, 12, 12, 1, 1, '');
ob_start();
require_once 'config.php';
require_once 'dbopen.php';


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

// get reservation data for that day
$result= mysqli_query($mysqli, $query);

$query2 = "select computer.asset,block1,block2,block3,block4 from computer left join (select asset, block1, block2, block3, block4 from reserved where day like '".$day."') as res on computer.asset = res.asset";
if($debug) echo "Query2 is: ".$query2."<br>";

$result2= mysqli_query($mysqli, $query2);

if(mysqli_num_rows($result) > 0) {
	// load $lookupArray with $day's computer requests linked to the room number
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)){
		$lookupArray[$row[0]] = $row[1];
	}
	
} else {
	echo "No computers are checked out on ".$day."<br>";
	die;
}

if($debug){
	foreach ($lookupArray as $key => $value) {
	echo "The room for number ".$key." is ".$value." yipee!<br>";
	}
}
if(mysqli_num_rows($result2) > 0) {
	echo "<h1>The newer computers on ".$day." are assigned as follows:</h1>";
	echo "<table><tr><td>Asset<br>Number</td><td>Block1<br>Room</td><td>Block2<br>Room</td><td>Block3<br>Room</td><td>Block4<br>Room</td></tr>";
	while ($asset= mysqli_fetch_array($result2,MYSQLI_NUM)) {
		if ($asset[0]==300) echo "</table><pagebreak><h1>The older computers on ".$day." are assigned as follows:</h1><table><thead><tr><td>Asset Number</td><td>Block1</td><td>Block2</td><td>Block3</td><td>Block4</td></tr></thead>";
		echo "<tr><td>".$asset[0]."</td><td>".$lookupArray[$asset[1]]."</td><td>".$lookupArray[$asset[2]]."</td><td>".$lookupArray[$asset[3]]."</td><td>".$lookupArray[$asset[4]]."</td></tr>";
	}
} else {
	echo "No computers are checked out on ".$day." during the requested block<br>";
}
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
