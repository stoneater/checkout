<script>
function newDoc()
  {
  window.location.assign("service.php")
  }
</script>

<?php
require_once 'config.php';
require_once 'dbopen.php';

if(isset($_POST['toggle'])) $toggle = $_POST['toggle'];
$out = $_POST['out'];

$toggled= implode(",",$toggle);
if($debug) echo "Toggled is ".$toggled."<br> out is".$out;

if($out) { //take computers out of service
	$query1 = "update computer set type = 5 where type = 4 and asset in(".$toggled.");";
	$query2 = "update computer set type = 2 where type = 1 and asset in(".$toggled.")";
} else { //put computers back in to service
	$query1 = "update computer set type = 4 where type = 5 and asset in(".$toggled.");";
	$query2 = "update computer set type = 1 where type = 2 and asset in(".$toggled.")";
}
$query=$query1.$query2;
mysqli_multi_query($mysqli,$query);

if ($debug) echo "query1 is ".$query1."<br> query2 is ".$query2."<br>";

echo "Toggled<br>";

?>
<input type="button" value="Back to the service page" onclick="newDoc()">