<?php
include('./db_connect.php');
require('./header.php');
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#skuSearch').keyup( function() {
			var sku = $('#skuSearch').val();
			$.ajax({
			  type: "POST",
			  url: "ajax.php",
			  data: "mode=ajax&id="+sku,
			  cache: false,
			  success: function(html){
				$("#replaceMe").html(html);
			  }
			});
		});
	});
</script>
<div id="content">
	<?php if(!$_GET['sku']) { ?>
		<h3>Please Filter your selection by Part Number</h3>
		<form>
			<input type="text" name="skuSearch" id="skuSearch" />
		</form>
		<p id="replaceMe">
			Southern Tier Lift offers thousands of parts to consumer's and 
			Small Business Owners alike. We boast some of the largest parts 
			selections and lowest prices in the area.

			If you need a part for your forklift search our online inventory database
			or give us a call at: (607) 692-4260.
		</p>
	<?php } else {
		$sku = mysql_real_escape_string($_GET['sku']);
		
		$sql = "SELECT sku,quantity,price,picture,manufacturer,description FROM `inventory` WHERE `sku`='".$sku."';";
		$query = mysql_fetch_array(mysql_query($sql));
		//ITEM LEVEL PAGE WITH DETAILED INFORMATION AND PICTURE. N-Y-I ?>
			<div id="content">
				<div id="equip">
					<div id="title">
						<?php echo $query["manufacturer"]." - ".$query["sku"];?>
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
						<?php if($query["description"]) {
						    echo "<span class=\"title\">Description: </span>";
						    echo $query["description"];
						  }
						?>
						<p>
							<span class="title">Quantity: </span>
							<?php echo $query["quantity"];?>
						</p>
					</div>

				</div>
				<div id="searchAgain">
				    <form>
                        <input type="text" name="skuSearch" id="skuSearch" />
                    </form>
				    <div id="replaceMe">
				        Not the SKU you were looking for? Feel free to search again or give us a call at (607) 692 - 4260.
				    </div>
				</div>
			</div>
		<?php
		
		}
	?>
</div>
<?php require('./footer.php'); ?>
