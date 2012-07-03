<?php 

include("./db_connect.php");
$type = mysql_real_escape_string($_GET['mode']);

if($type != "ajax"){
	include("./header.php");
	$companyID = mysql_real_escape_string($_GET['id']);}



function select_place($field) {
	$q = "SELECT link_id, state, city, company, trucks from links where link_id > 1 order by company,state,city";
	$query = mysql_query($q);
	if (!$query) echo "Database Error : ".$q;
	else {
		while ($row=mysql_fetch_row($query)) {
			echo "<option value=\"".$row[0]."\">";
			if ($row[3]) echo $row[3]." : ";
			if ($row[2]) echo $row[2]." : ";
			if ($row[3]) echo $row[1]."</option>\n";
		}
	}
}

switch($type) {

	default:
	
	 //******* Default behavior is insert *******//
	  ?>
		<script type="text/javascript">
			function addPart(sku) {
				
				if(sku.length == 0) {
					alert('Select a Sku First!');
					return(false);
				} else {
					//gets here
					sku = "<input type='text' name='partsUsed[]' value='" + sku + "' />";
					$(sku).appendTo($('#partsUsed'));
					$("#partQuery").val("")
				}
			}
		
			function lookup(partQuery) {
				if(partQuery.length == 0) {
					// Hide the suggestion box.
					$('#suggestions').hide();
				} else {
					$.post("workorder.php?mode=ajax&sku="+partQuery, function(data){
						if(data.length >0) {
							$('#suggestions').show();
							$('#suggestions').html(data);
						}
					});
				}
			}
			
			function fill(thisValue) {
				$('#partQuery').val(thisValue);
				setTimeout("$('#suggestions').hide();", 200);
				$("#addPart").show();
			}
		
			$(document).ready(function() {
				$('#company').change( function() {
					var companyID = $('#company').val();
					$.ajax({
					  type: "GET",
					  url: "workorder.php",
					  data: "mode=ajax&id="+companyID,
					  cache: false,
					  success: function(html){
						$("#truckInfo").html(html);
					  }
					});					
				});
				$("#partQuery").keyup( function() {
					if($(this).val() == 0) {
						$("#addPart").hide();
					} else {
						$("#addPart").show();
					}
				});
				$("#workorderID").submit( function() {
					addPart($("#partQuery").val());
					return false;
				});
			});
		</script>
		<div id="content">
			<form method="post" id="workorderID" action="./workorder.php">
				<div id="companyInfo">
					<select name="company" id="company" size="1" tabindex="1">
						<?php select_place();?>
					</select>
				</div>
				<div id="truckInfo">
					<label for="truck">Select Truck</label>
				</div>
				<div id="workorderComments">
					<textarea id="workorderComments" name="workorderComments" cols="75" rows="15" tabindex="3"></textarea>
				</div>
				<div id="partsUsed">
					<input type="text" name="partQuery" id="partQuery" tabindex="4" onkeyup="lookup(this.value);" onblur="fill();"/>
					<div class="suggestionsBox" id="suggestions" style="display: none;">
						&nbsp;
					</div>
					<input type="submit" name="addPart" id="addPart" value="Add Part" style="display: none;"/>
				</div>
	<?php
	break;
	case "ajax":
		//*****************************************************
		//*******************JSON FORMAT***********************
		// {{"make": "cat", "model": "FCG25N", "serial": "asfa"},{"make": "hyster", "model": "test1", "serial": "test2"} }
	
		if($_GET['id']) {$companyID = mysql_real_escape_string($_GET['id']);}
		if($_GET['sku']) {$sku = mysql_real_escape_string($_GET['sku']);}
		if($companyID) {
			$sql = "SELECT trucks FROM `links` WHERE link_id = ".$companyID." AND trucks IS NOT NULL;";
			$result = mysql_query($sql);
			$numRows = mysql_num_rows($result);
			$result = mysql_fetch_row($result);

			if($numRows > 0) {
				$jsonArray = json_decode($result[0],true);

				$html .= "<select name=\"companyTrucks\" id=\"companyTrucks\" tabindex=\"2\">";
				foreach($jsonArray as $step => $truck) {						
						$html .= "<option value=\"".$step."\">".$truck['make'].":".$truck['model']." - ".$truck['serial']."</option>";
				}
				$html .= "</select>";
				echo $html;
			} else {
				echo "Company has no trucks.";
			}
		}
		if($sku) {
			//query matches $sku-> for example 'ab' matches 'abc' but not 'cab'
			$sql = "SELECT sku,manufacturer FROM `inventory` WHERE `sku` LIKE '".$sku."%' LIMIT 10;";
			$result = mysql_query($sql);
			$numRows = mysql_num_rows($result);
					
			if($numRows > 0) {
				$html .= "<ul>";
				while($row = mysql_fetch_array($result)) {
					$html .= "<li onClick=\"fill('$row[0]');\">".$row[0].": ".$row[1]."</li>";
				}
				$html .= "</ul>";
				echo $html;
			} else {
				echo "No parts found.";
			}
		}
	break;
}