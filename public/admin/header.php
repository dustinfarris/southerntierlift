<?php
session_start();
// echo $_SESSION['djf'];
// if (!isset($_SESSION['djf']))  {
	// $_SESSION['djf'] = "asdofuhasodifhu"; 
	// if ($_SESSION['verified'] == FALSE)  {
		// header("Location: http://www.southerntierlift.com/admin/index.php");
	// }
// }
// unset($_SESSION['djf']);
include('./db_connect.php');

if(!$_SESSION['verified']) {
	if($_SERVER['SCRIPT_NAME'] != "/admin/index.php") {
		header("Location: http://www.southerntierlift.com/admin/index.php");
	}
}


if ((is_numeric($_REQUEST["c"]))&& ($_REQUEST["c"]!= 0)) {
	$_SESSION["c"] = $_REQUEST["c"];
	$c = $_REQUEST["c"];
} elseif ($_SESSION["c"]) {
	$c = $_SESSION["c"];
} else {
	$c = 1;
}

if ((is_numeric($_REQUEST["w"]))&& ($_REQUEST["w"]!= 0)) {
	$_SESSION["w"] = $_REQUEST["w"];
	$w = $_REQUEST["w"];
} elseif ($_SESSION["w"]) {
	$w = $_SESSION["w"];
} else {
	$w = 1;
}


if ((is_numeric($_REQUEST["o"]))&& ($_REQUEST["o"]!= 0)) {
	$_SESSION["o"] = $_REQUEST["o"];
	$o = $_REQUEST["o"];
} elseif ($_SESSION["o"]) {
	$o = $_SESSION["o"];
} elseif ($default_module) {
	$o = $default_module;
} else {
	$o = mysql_result(mysql_query("SELECT module_id from `modules` where active = 1 order by sequence limit 1"),0,0);
}



print ("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Southern Tier Lift - Serving Central New York and Northeast Pennsylvania</title>
		<link href="../STL_styles.css" type="text/css" rel="stylesheet" />
		<link href="./STL_admin.css" type="text/css" rel="stylesheet" />
		<script src="../jquery.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<img src="../images/header_logo.jpg" alt="Company Logo" width="860" height="94" style="float: left"/>
				<div id="menu">
					<ul id="nav">
						<li><a href="./portal.php" alt="Home">Portal</a></li>
						<li><a href="./calendar/index.php?<?echo "o=1&c=".$c."&m=".date(m)."&a=".date(d)."&y=".date(Y)."&w=".$w;?>" alt="Service">Calendar</a></li>
						<li ><a href="./trucks.php" alt="Equipment">Used Trucks</a></li>
						<li><a href="./inventory.php" alt="Parts">Inventory</a></li>
						<li><a href="./workorder.php" alt="Mobile Tire Pressing">Work Orders</a></li>
						<li id="last"><a href="./logout.php" alt="Logout">Logout</a></li>
					</ul>
					<img src="../images/header_menu_right.jpg" alt="Menu Slice" width="97" height="16" style="float: left;" />
				</div>
			</div>
			
