<?php 

$reserveQuery = "insert into reservation values('','$name','$email','$room','$computersRequested')";
// if($debug) $reserveQuery = "insert into reservation values('','Test','test@smithville.k12.mo.us','123','$computersRequested')";

$reserve = mysqli_query($mysqli, $reserveQuery);
if($debug) echo "reserveQuery: ".$reserveQuery."<br>";
$reservationID = mysqli_insert_id($mysqli);

if($debug) echo "Reservation ID is ".$reservationID."<br>";

?>
