<?php
error_reporting(E_ALL);


include('./header.php');
include('./db_connect.php');

$companyArray = array();


if($_POST) {
    print_r($_POST);
    parse_post($_POST);
}

function parse_post($input) {
    
    
    
    foreach($input["truck_id"] as $id => $truck) {
    $truck_sql = '';
        if ($truck == 0) {
            
            $truck_sql .= "INSERT INTO client_trucks (company_id,make,model,serial,last_service,int_interval) VALUES ('".$_GET["c"]."','".$input["make"][$id]."','".$input["model"][$id]."','".$input["serial"][$id]. "','".$input["last_service"][$id]."','".$input["int_interval"][$id]."'); ";
        
        } else {
        $truck_sql .= "UPDATE client_trucks SET make='".$input["make"][$id]."', model='".$input["model"][$id]."', serial='".$input["serial"][$id]. "', last_service='".$input["last_service"][$id]."', int_interval='".$input["int_interval"][$id]."' WHERE truck_id = ".$input["truck_id"][$id].";";

    } mysql_query($truck_sql);  }
    
    $sql = "UPDATE links SET company = '".$input["company_name"]."',
                               address1 = '".$input["address1"]."',
                               address2 = '".$input["address2"]."',
                               city = '".$input["city"]."',
                               state = '".$input["state"]."',
                               zip = '".$input["zip"]."',
                               phone = '".$input["phone"]."',
                               fax = '".$input["fax"]."',
                               email = '".$input["email"]."',
                               url = '".$input["url"]."',
                               contact = '".$input["contact"]."',
                               description = '".$input["description"]."'
                          WHERE link_id ='".$_GET["c"]."';";
    //echo $truck_sql."\n\n";
    //echo $sql."\n\n";      
    //mysql_query("UPDATE client_trucks SET make='Clark', model='GPX230-0450-9250', serial='GPX230-0450-9250', last_service='2010-10-13 00:00:00' WHERE truck_id = 43;");
                                          
    mysql_query($sql) or die(mysql_error()); 
}

function get_company($id) {
    global $companyArray;
    
    if(isset($id)) {
    
        $company_sql = "SELECT * FROM links,client_trucks WHERE links.link_id = '".$id."' AND client_trucks.company_id = '".$id."';"; 
        $companyArray = array("company_info" => array("company_name" => "","address1" => "","address2" => "","city" => "","state" => "","zip" => "",
                                "phone" => "","fax" => "","email" => "","url" => "","contact" => ""),"truck_info" => array());
        
        $result = mysql_query($company_sql);
        
        
        while ($row = mysql_fetch_assoc($result)) {
            $counter++;
            foreach ($row as $index => $value) {
                switch ($index) {
                    case "company_id":
                        $companyArray["company_info"]["company_id"] = $value;break;
                    case "company":
                        $companyArray["company_info"]["company_name"] = $value;break;
                    case "address1":
                        $companyArray["company_info"]["address1"] = $value;break;
                    case "address2":
                        $companyArray["company_info"]["address2"] = $value;break;
                    case "city":
                        $companyArray["company_info"]["city"] = $value;break;
                    case "state":
                        $companyArray["company_info"]["state"] = $value;break;
                    case "zip":
                        $companyArray["company_info"]["zip"] = $value;break;
                    case "phone":
                        $companyArray["company_info"]["phone"] = $value;break;
                    case "fax":
                        $companyArray["company_info"]["fax"] = $value;break;
                    case "email":
                        $companyArray["company_info"]["email"] = $value;break;
                    case "url":
                        $companyArray["company_info"]["url"] = $value;break;
                    case "contact":
                        $companyArray["company_info"]["contact"] = $value;break;
                    case "description":
                        $companyArray["company_info"]["description"] = $value;break;
                    case "truck_id":
                        $companyArray["truck_info"][$counter]["truck_id"] = $value;break;
                    case "make":
                        $companyArray["truck_info"][$counter]["make"] = $value;break;
                    case "model":
                        $companyArray["truck_info"][$counter]["model"] = $value;break;
                    case "serial":
                        $companyArray["truck_info"][$counter]["serial"] = $value;break;
                    case "int_interval":
                        $companyArray["truck_info"][$counter]["int_interval"] = $value;break;
                    case "last_service":
                        $companyArray["truck_info"][$counter]["last_service"] = $value;break;
                    default:
                        break;
                }
           }  
        }

    } else { return "This is not a valid company.";}
}



//populate page information
//*************************
if($_GET["c"]) {
    get_company($_GET["c"]); 

//*************************
?>
<div id="content">
    <div id="contentBannerLink"><h4><a href="./company.php">Return to Company List</a></h4></div>
        <form id="company_info_form" name="company_info_form" action="<? echo $_SERVER['PHP_SELF']."?c=".$_GET["c"];?>" method="post">
            <div id="company_info">
                 <fieldset>
                    <legend>Company Information</legend>
                    <?php
                        foreach($companyArray["company_info"] as $index => $value) {
                            echo "<label for=\"".$index."\">".$index."</label>\r";
                            echo "<input type=\"text\" name=\"".$index."\" value=\"".$value."\"><br />\r";
                        }
                    ?>
               </fieldset>
            </div>
            <div id="truck_info">
                <fieldset>
                    <legend>Registered Trucks</legend>
                    <?php
                        foreach($companyArray["truck_info"] as $index => $index_value) {
                            ?>
                            <fieldset>
                            <legend>Truck number <?php echo $index ?></legend>
                            <?php                  
                            foreach($index_value as $marker => $value) {
                                if($marker == "truck_id") {
                                    echo "<input type=\"hidden\" value=\"".$value."\" name=\"".$marker."[]\" />";
                                    } else {
                                         echo "<label for=\"".$marker."\">".$marker."</label>\r";
                                         echo "<input type=\"text\" name=\"".$marker."[]\" value=\"".$value."\"><br />\r";
                                         }
                                
                            }
                            echo "</fieldset>\n";
                        }
                    ?>
                <span id="btnAddTruck" class="button">Add Truck<p>
                </fieldset>
            </div>
            <div id="subimt" style="clear: left;">
                <input type="submit" name="submit" value="Save Changes" />
            </div>
            <!--<input type="hidden" name="string" value="<?php echo $_GET["c"]."-".$companyArray["company_info"]["company_id"]; ?>" /> -->
        </form>
        <script type="text/javascript" src="../jquery-ui.js"></script>
        <script type="text/javascript">
            $(document).ready ( function() {
                $('#btnAddTruck').click( function () {
                    var html = '<fieldset><legend>New Truck</legend><input type="hidden" name="truck_id[]" value="0" /><label for="make">make</label><input type="text" name="make[]" /><br /><label for="model">model</label><input type="text" name="model[]" /><br /><label for="serial">serial</label><input type="text" name="serial[]" /><br /><label for="last_service">last_service</label><input type="text" name="last_service[]" /><br /><label for="int_interval">int_interval</label><input type="text" name="int_interval[]" /></fieldset>';
                    $('#truck_info fieldset:last').after(html);
                    });
            });
        </script>
    
</div>

<?php 
    } else {
    echo "<div id=\"content\">";
    echo "<ul id=\"companyList\">";

    $sql = "SELECT link_id,company,city,state FROM links where 1 ORDER BY company ASC;";
    $sql = mysql_query($sql);

    while($row = mysql_fetch_assoc($sql)) {
        echo "<li><a href=\"./company.php?c=".$row["link_id"]."\" >".$row["company"]."</a>::".$row["city"].",".$row["state"]."</li>\n";
    }

    echo "</ul>";
    echo "</div>";
    
    }


include('../footer.php'); ?>
