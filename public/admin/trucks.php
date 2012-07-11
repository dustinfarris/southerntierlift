<?php 
require('./db_connect.php');
require('./header.php');

 define ("MAX_SIZE","400");
 ini_set("gd.jpeg_ignore_warning", 1);
 
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

if($_POST) {

	if(isset($_POST['submit'])) {
		$make = strtoupper(mysql_real_escape_string($_POST['make']));
		$model = strtoupper(mysql_real_escape_string($_POST['model']));
		$year = mysql_real_escape_string($_POST['year']);
		$capacity = mysql_real_escape_string($_POST['capacity']). "Lbs";
		$trans = mysql_real_escape_string($_POST['trans']);
		$power = mysql_real_escape_string($_POST['power']);
		$forks = mysql_real_escape_string($_POST['forks']). "\"";
		$mast = mysql_real_escape_string($_POST['mast']);
		$tires = mysql_real_escape_string($_POST['tires']);
		$price = "$".mysql_real_escape_string($_POST['price']);
		$comment = mysql_real_escape_string($_POST['comment']);
		$picture = "../images/trucks/".$model.date("Ymd-gis").".jpg";

		if($_FILES) {
			$image = $_FILES['picture']['name'];
			$uploadedfile = $_FILES['picture']['tmp_name'];
			
			if ($image) {
				$filename = stripslashes($_FILES['picture']['name']);
			
				$extension = getExtension($filename);
				$extension = strtolower($extension);
				
				
				 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
					$change='<div class="msgdiv">Unknown Image extension </div> ';
					$errors=1;
					} else {
					$size=filesize($_FILES['picture']['tmp_name']);


						if ($size > MAX_SIZE*1024){
							$change='<div class="msgdiv">You have exceeded the size limit!</div> ';
							$errors=1;}

						if($extension == "jpg" || $extension == "jpeg" ){
						$uploadedfile = $_FILES['picture']['tmp_name'];
						$src = imagecreatefromjpeg($uploadedfile);}
						
						else if($extension=="png"){
						$uploadedfile = $_FILES['picture']['tmp_name'];
						$src = imagecreatefrompng($uploadedfile);
						} else {
						$src = imagecreatefromgif($uploadedfile);}

						echo $scr;

						list($width,$height) = getimagesize($uploadedfile);


						$newwidth=500;
						$newheight=($height/$width)*$newwidth;
						$tmp=imagecreatetruecolor($newwidth,$newheight);


						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

						imagejpeg($tmp,$picture,100);


						imagedestroy($src);
						imagedestroy($tmp);
					}
			}
		}

		$sql = "INSERT INTO `truck_sales` (make, model, year, capacity, trans, power, forks, mast, tires, price, comment, picture) VALUES ('".$make."', '".$model."', '".$year."', '".$capacity."', '".$trans."', '".$power."', '".$forks."', '".$mast."', '".$tires."', '".$price."', '".$comment."', '".$picture."');";
		echo $sql."\n";
		$result = mysql_query($sql) or die(mysql_error());
		echo "<span class=\"newItem\">Item number: ".$model." has been inserted into the database. It should now appear in the inventory list below.</span>";
	}

	if(isset($_POST['delete'])){
		 foreach($_POST['index'] as $id){
		 $query = "SELECT picture FROM `truck_sales` WHERE auto=".$id;
		 $result = mysql_query($query)or die(mysql_error()); 
		 $result = mysql_fetch_row($result);
		 $pathToFile = $result[0];
		 $filename = substr($pathToFile, 20, strlen($pathToFile));
		 echo $filename;
		 chdir('../images/trucks');
		 echo getcwd();
		 
		 @unlink($filename);
		 chdir('.../');
		 echo getcwd();
		 
		 $query2 = "DELETE FROM truck_sales WHERE auto=".$id;
		 $query2 = mysql_query($query2) or die(mysql_error());
		 }
	}
}
?>

<div id="content">
		<div id="insertForm">
			<form action="./trucks.php" method="post" enctype="multipart/form-data">
				<span class="item">Make</span>:<input type="text" name="make" id="make" maxlength="30" /><br />
				<span class="item">Model</span>:<input type="text" name="model" id="model" maxlength="30" /><br />
				<span class="item">Year</span>:<input type="text" name="year" id="year" maxlength="30" /><br />
				<span class="item">Capacity</span>:<input type="text" name="capacity" id="capacity" maxlength="30" /><br />
				<span class="item">Trans</span>:<input type="text" name="trans" id="trans" maxlength="30" /><br />
				<span class="item">Power</span>:<input type="text" name="power" id="power" maxlength="30" /><br />
				<span class="item">Forks</span>:<input type="text" name="forks" id="forks" maxlength="30" /><br />
				<span class="item">Mast</span>:<input type="text" name="mast" id="mast" maxlength="30" /><br />
				<span class="item">Tires</span>:<input type="text" name="tires" id="tires" maxlength="30" /><br />
				<span class="item">Price</span>:<input type="text" name="price" id="price" maxlength="30" /><br />
				<span class="item">Picture</span>:<input type="file" name="picture" id="picture" /><br />
				<span class="item">Comments</span>:<textarea name="comment" id="comment" rows="6" cols="32" wrap="physical"></textarea><br />
				<input type="submit" name="submit" value="Insert" />
			</form>
		</div>
		
		<div id="currentItems">
			<form action="./trucks.php" method="post">
				<table class="parts">
					<tr class="header">
						<td>Delete</td>
						<td>Make</td>
						<td>Model</td>
						<td>Year</td>
						<td>Capacity</td>
						<td>Trans</td>
						<td>Power</td>
						<td>Forks</td>
						<td>Mast</td>
						<td>Tires</td>
					</tr>
					<?php
					$sql = "SELECT * FROM `truck_sales` WHERE 1;";
					$result = mysql_query($sql);
					$numRows = mysql_num_rows($result);

					switch ($numRows) {
						case ($numRows > 1):
							while($row = mysql_fetch_array($result)) {
								if ($numRows % 2) {
									$counter = " class=\"even\"";}
								echo "<tr".$counter."><td><input type=\"checkbox\" name=\"index[".$row[auto]."]\" value=\"".$row[auto]."\" /></td><td>".$row[make]."</td><td>".$row[model]."</td><td>".$row[year]."</td><td>".$row[capacity]."</td><td>".$row[trans]."</td><td>".$row[power]."</td><td>".$row[forks]."</td><td>".$row[mast]."</td><td>".$row[tires]."</td></tr>";
								$numRows = $numRows - 1;
								$counter = 0;
							}
						break;
						case ($numRows == 1):
							if($row = mysql_fetch_array($result)) {
								echo "<tr><td><input type=\"checkbox\" name=\"index[".$row[auto]."]\" value=\"".$row[auto]."\" /></td><td>".$row[make]."</td><td>".$row[model]."</td><td>".$row[year]."</td><td>".$row[capacity]."</td><td>".$row[trans]."</td><td>".$row[power]."</td><td>".$row[forks]."</td><td>".$row[mast]."</td><td>".$row[tires]."</td></tr>";
							}
						break;
						default:
							echo "Currently there is no equipment to display.";
						break;
					}
					?>
				<input type="submit" name="delete" value="Delete" />
				</table>
			</form>
		</div>
	</div>
<?php require('../footer.php'); ?>
