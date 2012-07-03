<?php
include('./db_connect.php');

if($_POST['mode'] == 'ajax') {
	if($_POST['id'] != "") {
		$sku = mysql_real_escape_string($_POST['id']);
		$sql = "SELECT sku,manufacturer FROM `inventory` WHERE `sku` LIKE '%".$sku."%' LIMIT 10;";
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
				
		if($numRows > 0) {
			$html = "<table><td>SKU</td><td>Manufacturer</td>\n";
			while($row = mysql_fetch_array($result)) {
				$html .= "<tr><td><a href=\"parts.php?sku=".$row[0]."\">".$row[0]."</a></td><td>".$row[1]."</td></tr>\n";
			}
			$html .= "</table>\n";
			echo $html;
		} else {
			echo "No parts found.";
		}

	} else {echo "Error: Missing Sku";}
	
} else {echo "Use the GET protocal to interface with this script";}

?>