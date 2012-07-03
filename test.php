<?php
error_reporting(E_ALL);

$array = array("testme" => "ok", "noarray", "noawway2", "testme2" => "ok");

print_r($array);

foreach ($array as $key => $index) {

    if(is_array($key)) {
        echo "yes";
         } else { 
         echo "no ";
         }

}

?>
