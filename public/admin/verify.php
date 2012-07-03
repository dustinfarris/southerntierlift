<?php 


	include('../db_connect.php');

	
	$sql = "";
	$result = "";
	$row = "";
	
	
/*	
	if($_POST) {
		$pFName = mysql_real_escape_string($_POST["pFName"]);
		$pLName = mysql_real_escape_string($_POST["pLName"]);
		$pZipcode = mysql_real_escape_string($_POST["pZipcode"]);
		$pBDateDay = mysql_real_escape_string($_POST['pBDateDay']);
		$pBDateMonth = mysql_real_escape_string($_POST['pBDateMonth']);
		$pBDateYear = mysql_real_escape_string($_POST['pBDateYear']);
		if($pFName == "" || $pLName == "" || $pZipcode == "" || $pBDateDay == "" || $pBDateMonth == "" || $pBDateYear == "") {
			print "Incorrect Credentials";
			die();
			}
		$sql = "SELECT * FROM `newUsers` WHERE `pFName`='".$pFName."' AND `pLName`='".$pLName."' AND `pZipcode`='".$pZipcode."' AND `pBDateDay`='".$pBDateDay."' AND `pBDateMonth`='".$pBDateMonth."' AND `pBDateYear`='".$pBDateYear."';"; //Connect to Users Tbl
		if($result = mysql_query($sql)) {
			if($result = mysql_num_rows($result) < 1) {
				return header( 'Location: http://www.phaze-hosting.com/mockup/index.php' );}
			$row = mysql_fetch_object(mysql_query($sql));
			if($pFName === $row->pFName && $pLName === $row->pLName	&& $pZipcode === $row->pZipcode && $pBDateDay === $row->pBDateDay && $pBDateMonth === $row->pBDateMonth && $pBDateYear === $row->pBDateYear) {
				session_start();
				$_SESSION['myID'] = $row->SSN;
				//$_SESSION['myPerm'] = $row->myPerm;
				$_SESSION['verified'] = "TRUE";
				return header('Location: http://www.phaze-hosting.com/mockup/index.php');}
		}
	}
*/
	if($_POST) {
		$user = mysql_real_escape_string($_POST['email']);
		$pass = md5(mysql_real_escape_string($_POST['password']));
		if($user == "" || $pass == "") {
			print "Incorrect Credentials";
			die();
			}
		$sql = "SELECT user_id, view, post, add_categories, add_groups, add_users, email, password FROM `users` WHERE `email`='".$user."' AND `password`='".$pass."' limit 1;";
		if($result = mysql_query($sql)) {
			if($result = mysql_num_rows($result) < 1) {
				return header( 'Location: http://www.southerntierlift.com/admin/index.php' );}
			$row = mysql_fetch_object(mysql_query($sql));
			if($user === $row->email && $pass === $row->password) {
				session_start();
				$_SESSION['myID'] = $row->email;
				$_SESSION['verified'] = "TRUE";
				$_SESSION['user_id'] = $row->user_id;
				$_SESSION['email'] = $row->email;
				if ($row->add_groups) $supergroup = true;
				if ($row->add_categories) $supercategory = true;
				if ($row->post) $superpost = true;
				if ($row->view) $superview = true;
				if ($row->add_groups) $supergroup = true;
				if ($row->post) $superpost = true;
				if ($row->view) $superview = true;
				if ($row->add_categories) $supercategory = true;
				if ($row->post) $superpost = true;
				if ($row->view) $superview = true;
				if ($row->post) $superpost = true;
				if ($row->view) $superview = true;
				if ($row->view) $superview = true;
				return header('Location: http://www.southerntierlift.com/admin/portal.php');
			}
		}
	}
	
function passSalter($string) {
	$string = $string . "b102974";
	return $string;
	}
?>


