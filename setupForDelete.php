<?php
ob_start();
require_once 'config.php';
require_once 'dbopen.php';

// get requestNumbers of selected blocks
$query = "select requestNumber, teacher_name, location, numberComputers
			from reservation 
			where 
				requestNumber in(select block1 from reserved where day >= now() group by block1) 
				or requestNumber in(select block2 from reserved where day >= now() group by block2) 
				or requestNumber in(select block3 from reserved where day >= now() group by block4) 
				or requestNumber in(select block1 from reserved where day >= now() group by block4)
		";

if($debug) echo "Query is: ".$query."<br>";
$result= mysqli_query($mysqli, $query);

if(mysqli_num_rows($result) > 0) {
	$table = "<h1>The computers requested for the next two weeks are as follows:</h1><div class='clean'>";
	$table .= "<table><thead><tr>";
	$table .= "<td>Reservation<br>Number</td><td>Teacher's<br>Name</td><td>Location</td><td>Number of<br>Computers</td></thead>";
	echo $table;
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
		echo "<tr><td><a href='reallyDelete.php?reservation=$row[0]&limit=$row[3]' onclick='return reallySure()'>$row[0]</a></td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>";
	}
} else {
	echo "<h1>No computers are checked out in location ".$location." for the next two weeks.</h1>";
}
echo "</table></div>";
require_once 'dbclose.php';
require_once 'end.php';
$html=ob_get_contents();
ob_end_clean();
echo $html;
exit;
?>