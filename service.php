<?php
require_once 'config.php';
require_once 'dbopen.php';
?>

<form action="serviceToggle.php" method="post">
<label for="out">I want to take items out of service</label><input type='checkbox' id='out' name='out' value='1'><hr>

<?php 

//create list of new computers

$query = "select asset,type from computer where asset < 299";

if($debug) echo "Query is: ".$query."<br>";

$result= mysqli_query($mysqli, $query);

if(mysqli_num_rows($result) > 0) {
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
			switch ($row[1]){
			case 2:
			case 5:
				$color="#ff0000";
				break;
			case 1:
			case 4:
				$color="#000000";
		}
		if ($row[0] < 10){
			$outputNew = $outputNew."<label for='".$row[0]."' style='color:".$color."'>00".$row[0]."<input type='checkbox' id='".$row[0]."' name='toggle[]' value='".$row[0]."'> </label>";
		} elseif ($row[0] < 100) {
			$outputNew = $outputNew."<label for='".$row[0]."' style='color:".$color."'>0".$row[0]."<input type='checkbox' id='".$row[0]."' name='toggle[]' value='".$row[0]."'> </label>";
		} else {
			$outputNew = $outputNew."<label for='".$row[0]."' style='color:".$color."'>".$row[0]."<input type='checkbox' id='".$row[0]."' name='toggle[]' value='".$row[0]."'> </label>";
		}
	}
}

// create list of older computers

$query = "select asset,type from computer where asset > 299";

if($debug) echo "Query is: ".$query."<br>";

$result= mysqli_query($mysqli, $query);

if(mysqli_num_rows($result) > 0) {
	while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
		switch ($row[1]){
			case 2:
			case 5:
				$color="#ff0000";
				break;
			case 1:
			case 4:
				$color="#000000";
		}
		$outputOld = $outputOld."<label for='".$row[0]."' style='color:".$color."'>".$row[0]."<input type='checkbox' id='".$row[0]."' name='toggle[]' value='".$row[0]."'> </label>";
	}
}
echo $outputNew."<hr>".$outputOld;
?>
<hr>
	<input type="submit" value="Toggle Computer Status">
</form>
<?php
require_once 'dbclose.php';
require_once 'end.php';
