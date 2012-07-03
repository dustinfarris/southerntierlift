<?php

include('./db_connect.php');
include('./header.php');

 function refresh() {

        $sql = "SELECT * FROM `client_trucks` WHERE 1";//company_id = '".$comapnyID."';";
        
        $result = mysql_query($sql);
        $soon = time() + 1209600;
        
        while($row = mysql_fetch_assoc($result)) {
            $interval = $row["int_interval"];
            
            $date = explode(" ",$row["last_service"]);
            $date = strtotime($date[0]);
            
            //$newdate = strtotime("+".$interval." day", $date);
            $newdate = (86400 * (int)$interval) + $date;
            
            
            $delta = ($soon - $newdate);

            if ($delta < 0 && $row["current"] == 0) {
                //echo "Row ".$row["truck_id"]."Has been updated\n";
                update_current_state($row["truck_id"],"current");
            
            } elseif ($delta > 0 && $row["current"] == 1) {
                //echo "Row ".$row["truck_id"]."Has been updated\n";
                update_current_state($row["truck_id"],"overdue");
            }
        }
} 

//mode = current,overdue
function update_current_state($truck_id,$mode) {

    if($mode == "current") {
        $sql_update = "UPDATE `client_trucks` SET `current` = 1 WHERE truck_id = '".$truck_id."';";
        } elseif ($mode == "overdue") {
        $sql_update = "UPDATE `client_trucks` SET `current` = 0 WHERE truck_id = '".$truck_id."';";
        }
    
    $result = mysql_query($sql_update);
}

function display_overdue() {

    $sql2 = "SELECT client_trucks.make, client_trucks.model, client_trucks.serial,client_trucks.last_service,client_trucks.int_interval,client_trucks.company_id, links.company FROM client_trucks LEFT JOIN links ON links.link_id = client_trucks.company_id WHERE current = 0 ORDER BY company, make,model,serial;";
    //$sql2 = "SELECT * FROM client_trucks WHERE 1;";
    
    $result2 = mysql_query($sql2);
    
    echo "<div id=\"content\"><h3>Last Printed: ".date("M d, y")."</h3><table id=\"overdue\"><tr><td>Company</td><td>Truck</td><td>Last Serviced</td><td style=\"padding-left: 5px;\">Due Next</td></tr>";
    //echo "<div id=\"content\"><table id=\"overdue\"><tr><td>Current</td><td>equation</td><td>result</td><td>should be due</td></tr>";
    while($row = mysql_fetch_assoc($result2)) {
    if ($row["int_interval"] == 0 || $row["last_service"] == "0000-00-00 00:00:00") { } else {
            $interval = $row["int_interval"];
        
        $date = explode(" ",$row["last_service"]);
        $date_save = $date[0];
        $date = strtotime($date[0]);
        
        //$newdate = strtotime("+".$interval." day", $date);
        $newdate = (86400 * (int)$interval) + $date;
        
        echo "<tr><td><a href=\"./company.php?c=".$row["company_id"]."\">".$row["company"]."</a></td><td>".$row["make"]." ".$row["model"]." ".$row["serial"]."</td><td>".$date_save."</td><td style=\"padding-left: 5px\">".date("Y-m-d",$newdate)."</td></tr>";
        }
    }
    echo "</table></div>";

}

refresh();
display_overdue();


include('../footer.php');
?>
