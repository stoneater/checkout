<!DOCTYPE html>
<html>
<head>
<title>Computer Checkout</title>
<meta charset="UTF-8">
<link rel="icon" type="image/x-icon" href="favicon.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link href="css/south-street/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css" >
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript">

function autoResize(id){
	var newheight;
	var newwidth;

	if(document.getElementById){
		newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
		newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
	}

	document.getElementById(id).height= (newheight);
	document.getElementById(id).width= (newwidth);
}

</script>
</head>
<body onload="autoResize('one')">

<div id="tabs">
	<ul>
		<li><a href="#tab1">Checkout computers</a></li>
		<li><a href="#tab2">Pick list by room</a></li>
		<li><a href="#tab3">Master locator</a></li>
		<li><a href="#tab4">Service Toggle</a></li>
		<li><a href="#tab5">Room Information</a></li>
		<li><a href="#tab6">Delete Request</a><li>
	</ul>

	<div id="tab1">
		<iframe id="one"  name="one" src="reserve.html" width="500" height="700"></iframe>
	</div>
	<div id="tab2">
		<iframe id="two" src="pickSheet.html" width="500" height="700"></iframe>
	</div>
	<div id="tab3">
		<iframe id="three" src="masterLocator.html" width="800" height="1024"></iframe>
	</div>
	<div id="tab4">
		<iframe id="four" src="service.php" width="500" height="700"></iframe>
	</div>
	<div id="tab5">
		<iframe id="five" src="roomLocator.html" width="800" height="1024"></iframe>
	</div>
	<div id="tab6">
		<iframe id="six" src="setupForDelete.php" width="800" height="1024"></iframe>
	</div>
</div>
</body>
<script>
// Tabs
//$('#tabs').tabs();
$("#tabs").tabs({selected:0});
</script>
]</html>