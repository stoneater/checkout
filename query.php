<?php
include_once 'config.php';

$sqlQuery = "select * from computer left join (select * from reserved where day like '$day')as res on computer.asset = res.asset where";
if (isset($blocksRequested[0])) $sqlQuery= $sqlQuery."(block1 < 1 and block1 not like 'charging' or block1 is null) and";
if (isset($blocksRequested[1])) $sqlQuery= $sqlQuery."(block2 < 1 and block2 not like 'charging' or block2 is null) and";
if (isset($blocksRequested[2])) $sqlQuery= $sqlQuery."(block3 < 1 and block3 not like 'charging' or block3 is null) and";
if (isset($blocksRequested[3])) $sqlQuery= $sqlQuery."(block4 < 1 and block3 not like 'charging' or block4 is null) and";
$sqlQuery= $sqlQuery." type = $type";
$sqlQuery=$sqlQuery." limit ".$computersRequested;

if ($debug) echo 'Query from sqlQuery is: '.$sqlQuery.'<br>';
$result = mysqli_query($mysqli, $sqlQuery);
$numQuery = mysqli_num_rows($result);
?>
