<script>
function back(){
    window.history.back(-1);
}
</script>

<?php
require_once 'config.php';
require_once 'dbopen.php';

if ($_POST['blocksRequested']) $blocksRequested = $_POST['blocksRequested'];
if ($_POST['computersRequested']) $computersRequested = $_POST['computersRequested'];
if ($_POST['day']) $day = date('Y-m-d', strtotime($_POST['day']));
if ($_POST['name']) $name = $_POST['name'];
if ($_POST['email']) $email = $_POST['email'];
if ($_POST['room']) $room = $_POST['room'];

if ($debug){
	echo "day is $day <br>";
	echo "computersRequested is $computersRequested<br>";
	echo "Date requested is $day<br>";
	echo "name of requestor is $name<br>";
	echo "email is $email<br>";
	echo "room is $room<br>";
	echo "Number of blocks requested: ".array_sum($blocksRequested)."<br> computersRequested: ".$computersRequested."<hr>";
}
include 'query.php';

if ($numQuery == $computersRequested) include_once 'reserve.php';
elseif ($numQuery < $computersRequested) { 
	$type = 1;
	// at some point, include code, or pass to another php to ask if $numQuery of new computers will suffice and a yes/no branching
	if(array_sum($blocksRequested)<= 1){
		include 'query.php';
	}else {
		$a = ($blocksRequested[0] + $blocksRequested[1]);
		$b = ($blocksRequested[1] + $blocksRequested[2]);
		$c = ($blocksRequested[2] + $blocksRequested[3]);
		if($debug) echo "Block 1 is $blocksRequested[0] Block 2 is $blocksRequested[1] Block 3 is $blocksRequested[2] Block 4 is $blocksRequested[3]";
		if(($a == 2)||($b == 2)||($c == 2)) die("We only have ".$numQuery." computers available, please click <a href='javascript:void();' onclick='back()'>here</a> and select fewer computers. Alternatively, if you selected multiple blocks, try selecting only one block, as this may make groups of the older computers available.");
		include 'query.php';
	}
	if($numQuery < $computersRequested) die("We only have ".$numQuery." computers available, please click <a href='javascript:void();' onclick='back()'>here</a> and select fewer computers.  Alternatively, if you selected multiple blocks, try selecting only one block, as this may make groups of the older computers available.");
	include_once 'reserve.php';
}

$insert='replace into reserved values(';
while ($row= mysqli_fetch_array($result,MYSQLI_NUM)) {
	if($debug){
		print_r(array_keys($row));
		echo "asset is $row[0] type is $row[1] day is $row[2] reserved.asset is $row[3] block1 is $row[4] block2 is $row[5] block3 is $row[6] block4 is $row[7] <br>";
	}
	if ($type == 4){
		if(isset($blocksRequested[0])) $row[4]=$reservationID;
		if(isset($blocksRequested[1])) $row[5]=$reservationID;
		if(isset($blocksRequested[2])) $row[6]=$reservationID;
		if(isset($blocksRequested[3])) $row[7]=$reservationID;
	}
	if ($type == 1){
		if(isset($blocksRequested[0])){$row[4]=$reservationID; $row[5] = "charging";}
		if(isset($blocksRequested[1])){$row[5]=$reservationID; $row[4] = "charging"; $row[6] = "charging";}
		if(isset($blocksRequested[2])){$row[6]=$reservationID; $row[5] = "charging"; $row[7] = "charging";}
		if(isset($blocksRequested[3])){$row[7]=$reservationID; $row[6] = "charging";}
	}
	 $insert =$insert."'".$day."',".$row[0].",'".$row[4]."','".$row[5]."','".$row[6]."','".$row[7]."'),(";
}
$insert = rtrim($insert,",(");
if($debug) echo "The insert query is<b> $insert </b><br>";
if (!mysqli_query($mysqli,$insert))
  {
  die('Error: ' . mysqli_error($mysqli));
  }
echo "Your computers have been reserved. Your reservation ID# is <b>".$reservationID."</b><br>If you wish to submit another request click <a href='javascript:void();' onclick='back()'>here</a>";
require_once 'dbclose.php';
require_once 'end.php';
?>
