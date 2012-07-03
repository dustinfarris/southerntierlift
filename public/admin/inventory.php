<?php

include("./db_connect.php");
include("./header.php");


/*****************************
Inventory page handles all 3 types of requests from the portal;
Query: More or less pulls up detailed information about the product on a singular page
Search: Searches the DB using %LIKE% query for most results at the moment displaying them as a table
Insert: Uses an Insert query that if a duplicate entry is found in `sku` an increment($_GET['quantity'])
		gets added to existing quantity.
******************************/

//MODE = NULL (Default Action)
switch($_GET['mode']) {
	case "search":
		if(!$_GET['sku']) {
		// MODE = SEARCH; SKU = Null (Default Action)?>
			<div id="content">
			<h3>Search for a Product by SKU Number</h3>
				<form action="./inventory.php" method="get" name="search">
					<input type="text" name="sku" size="30" />
					<input type="hidden" value="search" name="mode" />
					<input type="submit" value="submit" />
				</form>
			</div>
		<?php
		} else {
			$search_id = mysql_real_escape_string($_GET['sku']);
			$sql = "SELECT sku,manufacturer,quantity,alt_sku FROM `inventory` WHERE sku LIKE '%".$search_id."%' OR alt_sku LIKE '%".$search_id."%';";
			$result = mysql_query($sql);
			$numRows = mysql_num_rows($result);
			
			switch ($numRows) {
				case ($numRows > 1):
					while($row = mysql_fetch_array($result)) {
						if ($numRows % 2) {
							$counter = " numRows=\"".$numRows."\" class=\"even\"";}
						$row_array .= "<tr".$counter.">
										<td>
										 <a href=\"./inventory.php?sku=".$row[sku]."&mode=query\">".$row[sku]."</a>
										</td>
										<td>".$row[manufacturer]."</td>
										<td>".$row[quantity]."</td>
										<td>".$row[alt_sku]."</td>
									  </tr>";
						$numRows = $numRows - 1;
						$counter = 0;
					}
				break;
				case ($numRows == 1):
					if($row = mysql_fetch_array($result)) {
						$row_array .= "<tr>
										<td>
										 <a href=\"./inventory.php?sku=".$row[sku]."&mode=query\">".$row[sku]."</a>
										</td>
										<td>".$row[manufacturer]."</td>
										<td>".$row[quantity]."</td>
										<td>".$row[alt_sku]."</td>
									   </tr>";
					}
				break;
				default:
					$row_array = "No Parts Were Found!";
				break;
			}
		// MODE = SEARCH **********WRITE*********** ?>
			<div id="content">
				<table class="parts">
					<tr class="header">
						<td>SKU</td>
						<td>Manufacturer</td>
						<td>Quantity</td>
						<td>Alternate Sku</td>
					</tr>
					<?php echo $row_array;?>
				</table>
			</div>
		<?php
		}
	break;
	case "insert":
		if(!$_GET['sku']) {
		?>
			<div id="content">
				<h3>Insert a new product</h3>
				<form action="./inventory.php" method="get" name="insert">
					<input type="hidden" name="mode" value="insert" />
					<span>Sku Number</span><input type="text" name="sku" size="20" tabindex="1"/><br />
					<span>Manufacturer</span><input type="text" name="manufacturer" size="20" tabindex="2"/><br />
                    <span>Description</span><input type="text" name="description" size="20" tabindex="3"/><br />
					<span>Price</span><input type="text" name="price" size="6" tabindex="4"/><br />
					<span>Quantity</span><input type="text" name="quantity" size="3" tabindex="5"/><br />
					<span>Alt Sku's (Separated by comma's please)</span><input type="text" name="alt_sku" size="40" tabindex="6"/><br />
					<input type="submit" value="insert_submit" name="Submit" tabindex="7"/>
				</form>
			</div>
			<div id="return">
				<a href="./inventory.php?mode=search">Search the Database</a>
			<div>
		<?php
		} else {
			$insert_id = mysql_real_escape_string($_GET['sku']);
			$insert_manufacturer = mysql_real_escape_string($_GET['manufacturer']);
			$insert_description = mysql_real_escape_string($_GET['description']);
			$insert_price = mysql_real_escape_string($_GET['price']);
			$insert_altSku = mysql_real_escape_string($_GET['alt_sku']);
			if($_GET['quantity']) {$quantity = mysql_real_escape_string($_GET['quantity']);} else {$quantity = 0;}
			$sql = "INSERT INTO `inventory` (sku,manufacturer,alt_sku,quantity,description,price)
						VALUES ('".$insert_id."','".$insert_manufacturer."','".$insert_altSku."','".$quantity."','".$insert_description."','".$insert_price."') 
						    ON DUPLICATE KEY UPDATE quantity = (quantity + ".$quantity.");";
			echo $sql;				
			$result = mysql_query($sql) or die(mysql_error());
			//MODE = INSERT ***********WRITE*********** ?>
			<div id="content">
				<p>Product <?php echo $insert_id?> has been added to the database resulting in the following information: <br /><br /><br /></p>
				<?php
					$sql = "Select sku,manufacturer,quantity,alt_sku FROM `inventory` WHERE `sku`='".$insert_id."';";
					$result = mysql_query($sql);
					$row = mysql_fetch_array($result);
				?>
				<table class="parts">
					<tr class="header">
						<td>Sku</td>
						<td>Manufacturer</td>
						<td>Quantity</td>
						<td>Alt_Sku</td>
					</tr>
					<tr>
						<td><?php echo $row[sku]?></td>
						<td><?php echo $row[manufacturer]?></td>
						<td><?php echo $row[quantity]?></td>
						<td><?php echo $row[alt_sku]?></td>
					</tr>
				</table>
			</div>
		<?php
		}
	break;
	case "query":
		if(!$_GET['sku']) {
		// HERE IS THE CODE FOR THE BASE ITEM LEVEL PAGE SEARCH ENGINE (REDIRECT FROM MODE=SEARCH/SKU=NULL) ?>
			<div id="content">
			<h3>Search for a Product by SKU Number</h3>
				<form action="./inventory.php" method="get" name="query">
					<input type="text" name="sku" size="30" />
					<input type="hidden" value="search" name="mode" />
					<input type="submit" value="submit" />
				</form>
			</div>
			<div id="return">
				<a href="./inventory.php?mode=insert">Insert a New Product</a>
			</div>
		<?php
		} else {
		$sku = mysql_real_escape_string($_GET['sku']);
		
		$sql = "SELECT sku,quantity,price,picture,manufacturer FROM `inventory` WHERE `sku`='".$sku."';";
		$query = mysql_fetch_array(mysql_query($sql));
		//ITEM LEVEL PAGE WITH DETAILED INFORMATION AND PICTURE. N-Y-I ?>
			<div id="content">
				<div id="equip">
					<div id="title">
						<?php echo $query["manufacturer"]." ".$query["sku"];?>
					</div>
					<?php if($query["picture"] != "") { 
						echo "<img src=\"./inventory/".$query["picture"]."\" />";
					} ?>
					<div id="equipinfo">
						<p>
							<span class="title">Manufacturer: </span>
							<?php echo $query["manufacturer"];?>
						</p>
						<p>
							<span class="title">SKU: </span>
							<?php echo $query["sku"];?>
						</p>
						<p>
							<span class="title">Quantity: </span>
							<?php echo $query["quantity"];?>
						</p>
						<p>
							<span class="title">Price: </span>
							<?php echo $query["price"];?>
						</p>
					</div>
				</div>
			</div>
		<?php
		}
	break;
	default:
		?>
			<div id="content">
				<a href="./inventory.php?mode=search" style="margin: 0 218px;">Search SKU List</a>
				<a href="./inventory.php?mode=insert">Insert SKU</a>
			</div>
		<?php
}


include("../footer.php"); 
?>
