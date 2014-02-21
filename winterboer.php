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

	document.getElementById(id).height= (newheight+300) + "px";
	document.getElementById(id).width= (newwidth+300) + "px";
}

</script>
</head>
<body onload="autoResize('one')">

<div id="tabs">
	<ul>
		<li><a href="#tab1">Checkout computers</a></li>
		<li><a href="#tab2">Picklist by room</a></li>
		<li><a href="#tab3">Master locator</a></li>
		<li><a href="#tab4">Service Toggle</a></li>
	</ul>

	<div id="tab1">
		<iframe id="one"  name="one" src="reserve.html" ></iframe>
	</div>
	<div id="tab2">
		<iframe id="two" src="pickSheet.html" onload="autoResize('two')"></iframe>
	</div>
	<div id="tab3">
		<iframe id="three" src="masterLocator.html" onload="autoResize('three')"></iframe>
	</div>
	<div id="tab4">
		<iframe id="four" src="service.php" width="500px" height="700px"></iframe>
	</div>
</div>
</body>
<script>
// Tabs
//$('#tabs').tabs();
$("#tabs").tabs({selected:0});
</script>
<!--[if !(lt IE 8)]><!-->
   <script type="text/javascript">
     (function(){var e=document.createElement("script");e.type="text/javascript";e.async=true;e.src=document.location.protocol+"//d1agz031tafz8n.cloudfront.net/thedaywefightback.js/widget.min.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})()
   </script>
<!--<![endif]-->
</html>
