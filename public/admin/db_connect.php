<?php 

/* db_connect
**
** MySQL database login script
** to include in all db-enabled php files
**
** Derek Wurtenberg
** 
*/

$link = mysql_connect('localhost', 'stl_backend', 'm+,!(pu24ID7[)'); //Connects to the database at "localhost"
if(!$link) {
    //halt execution if cannot connect
    die("Cannot connect to the database! ".mysql_error());
}
mysql_select_db('southerntierlift', $link); 

?>
