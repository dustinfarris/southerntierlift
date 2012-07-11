<?php

include('./db_connect.php');
include('./header.php');

?>
<div id="content">
<form action="<?php $PHP_SELF?>" method="post">
   <span>Day:
        <select name="day" id="day" size="1">
            <option value="1">01</option>
            <option value="2">02</option>
            <option value="3">03</option>
            <option value="4">04</option>
            <option value="5">05</option>
            <option value="6">06</option>
            <option value="7">07</option>
            <option value="8">08</option>
            <option value="9">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>
    </span>
    <span>Month:
        <select id="month" name="month" size="1">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
     </span>
     
     <div id="itemDiv">
         <p>Item #<?php $c?>:  
            <input type="text" name="itemSku[]" />
            <input type="text" name="itemLink[]" />
         </p>
         <p id="addItem">Add Another Item</p>
         <input type="submit" value="Submit" />
     </div>
  </form>
</div>
     <script type="text/javascript">
	    $(document).ready( function() {
		    $('#addItem').click( function() {
			    var html = '<p><input type="text" name="itemSku[]" /><input type="text" name="itemLink[]" />';
			    $('div#itemDiv').append(html);
		    });
	    });
    </script>
    
<?php

    if($_POST) {
        if($_POST["day"] && $_POST["month"] && $_POST["itemSku"]) {
            $day = mysql_real_escape_string($_POST["day"]);
            $month = mysql_real_escape_string($_POST["month"]);
            $jsonArray = array();
            
            foreach($_POST["itemSku"] as $index => $sku) {
                if($sku != "") {
                    $jsonArray[$index]["sku"] = $sku;
                    $jsonArray[$index]["link"] = mysql_real_escape_string($_POST["itemLink"][$index]);
                }
             }
            
            $encoded_json = json_encode($jsonArray);
            
            $date = $_POST["month"]." - ".$_POST["day"];
            
            $sql = "INSERT INTO specials (jsonItems,date) VALUES ('".$encoded_json."','".$date."');";
            $sql = mysql_query($sql);
            
        }
    }
    
?>
