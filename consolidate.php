<?php

ini_set('error_reporting', E_ALL);


runconsolidate();


function runconsolidate() {
    $stack = array();
    $row = 1;
    if (($handle = fopen("inventory.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
            $data = explode(";",$data[0]);
            //find_match($data);
            if($data[6] == "") {
                array_push($stack,$data);
            } else {
                $alt_sku = $data[6];
                
            
            }
        }
        
        print_r($stack);
    fclose($handle);
    }
}

function find_match($data) {
    $data = explode(";", $data);
    

}
?>
