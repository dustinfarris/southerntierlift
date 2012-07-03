<?php
print ("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");

$sku_keyword = "Forklift Parts,";
if($_SERVER['SCRIPT_NAME'] == "/parts.php") {

	if($_GET['sku']) {
		$sku = $_GET['sku'];
		$sku_keyword = $_GET['sku'].",".$sku_keyword;
		$title = $sku." | Southern Tier Lift - Internet Parts Database";
		$description = $sku_keyword." Serving Central New York and Northeast Pennsylvania with superior service and excellent prices.";
		} else {
	$title = "Southern Tier Lift - Search our Internet Parts Database";
	$description = "Southern Tier Lift Parts Database. Enter a SKU to check our availibility on a part";
	}
} else {
	$title = "Southern Tier Lift - Serving Central New York and Northeast Pennsylvania";
	$description = "Southern Tier Lift offers forklift parts, forklifts, preventative maintenance as well as fleet consultation services to Central New York and Northeast Pennsylvania";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title;?></title>
		<link href="./STL_styles.css" type="text/css" rel="stylesheet" />
		<meta type="keywords" content="<?php echo $sku_keyword?>Southern Tier Lift,forklift,parts" />
		<meta type="description" content="<?php echo $description;?>" />
		<script src="./jquery.js" type="text/javascript"></script>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-19439495-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<img src="./images/header_logo.jpg" alt="Company Logo" width="860" height="94" style="float: left"/>
				<div id="menu">
					<ul id="nav">
						<li><a href="./index.php" alt="Home">Home</a></li>
						<li><a href="./service.php" alt="Service">Service</a></li>
						<li><a href="./training.php" alt="Training">Training</a></li>
						<li><a href="./parts.php" alt="Parts">New/Used Parts</a></li>
						<li><a href="./tirepressing.php" alt="Mobile Tire Pressing">Mobile Tire Pressing</a></li>
						<li id="last"><a href="./trucks.php" alt="Used Equipment">Used Equipment</a></li>
					</ul>
					<img src="./images/header_menu_right.jpg" alt="Menu Slice" width="97" height="17" style="float: left;" />
				</div>
			</div>

			
