<?php
include('./header.php');
include('./db_connect.php');
?>
<div id="content">
	
		<?php
		if($_GET['a']) {
			$auto = mysql_real_escape_string($_GET['a']);
			$sql = "SELECT * FROM `truck_sales` WHERE `auto`='".$auto."';";
			$row = mysql_fetch_array(mysql_query($sql));
			echo "<div id=\"equip\">";
			if($row[model] || $row[make]) { echo "<div id=\"title\">".stripslashes($row[make])." ".stripslashes($row[model])."</div>";}
			if($row[picture]) { echo	"<img src=\"".stripslashes($row[picture])."\" />";}
			//if($row[model]) {   echo	"<div><p><span class=\"title\">Model: </span>".stripslashes($row[model])."</p>";}
			//if($row[make]) {    echo	"<p><span class=\"title\">Make: </span>".stripslashes($row[make])."</p>";}
			if($row[year]) {    echo	"<div id=\"equipinfo\"><p><span class=\"title\">Year: </span>".stripslashes($row[year])."</p>";}
			if($row[capacity]) {echo	"<p><span class=\"title\">Capacity: </span>".stripslashes($row[capacity])."</p>";}
			if($row[trans]) {   echo	"<p><span class=\"title\">Trans: </span>".stripslashes($row[trans])."</p>";}
			if($row[power]) {   echo	"<p><span class=\"title\">Power: </span>".stripslashes($row[power])."</p>";}
			if($row[forks]) {   echo	"<p><span class=\"title\">Forks: </span>".stripslashes($row[forks])."</p>";}
			if($row[mast]) {    echo	"<p><span class=\"title\">Mast: </span>".stripslashes($row[mast])."</p>";}
			if($row[tires]) {   echo	"<p><span class=\"title\">Tires: </span>".stripslashes($row[tires])."</p>";}
			if($row[price]) {   echo	"<p><span class=\"title\">Price: </span>".stripslashes($row[price])."</p>";}
			if($row[comment]) { echo	"<p><span class=\"title\">Comment: </span>".$row[comment]."</p>";}
			echo "</div></div>";
			
		} else {
		?>
		<table class="parts">
			<tr class="header">
				<td>Make</td>
				<td style="display: none;">&nbsp;</td>
				<td>Model</td>
				<td>Year</td>
				<td>Capacity</td>
				<td>Trans</td>
				<td>Power</td>
				<td>Forks</td>
				<td>Mast</td>
				<td>Tires</td>
				<td>Price</td>
			</tr>
		<?php
			$sql = "SELECT * FROM `truck_sales` WHERE 1 ORDER BY make,model";
			$result = mysql_query($sql);
			$numRows = mysql_num_rows($result);
			switch ($numRows) {
				case ($numRows > 1):
					while($row = mysql_fetch_array($result)) {
						if ($numRows % 2) {
							$counter = " class=\"even\"";}
						echo "<tr".$counter.">\n\t<td><a href=\"./trucks.php?a=".$row[auto]."\">".$row[make]."</td><td style=\"display: none;\">".$row[auto]."</td><td>".$row[model]."</td><td>".$row[year]."</td><td>".$row[capacity]."</td><td>".$row[trans]."</td><td>".$row[power]."</td><td>".$row[forks]."</td><td>".$row[mast]."</td><td>".$row[tires]."</td><td>".$row[price]."</td></tr>\n";
						$counter = "";
						$numRows = $numRows - 1;
					}
				break;
				case ($numRows == 1):
					if($result = mysql_fetch_array($result)) {
						echo "<tr><td><a href=\"./trucks.php?a=".$result[auto]."\">".$result[make]."</td><td style=\"display: none;\">".$result[auto]."</td><td>".$result[model]."</td><td>".$result[year]."</td><td>".$result[capacity]."</td><td>".$result[trans]."</td><td>".$result[power]."</td><td>".$result[forks]."</td><td>".$result[mast]."</td><td>".$result[tires]."</td><td>".$result[price]."</td></tr>";
					}
				break;
				default:
					
				break;
			}
		echo "</table>";
		}
		?>

</div>
<?php
include('./footer.php');
?>

