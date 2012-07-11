<?php 

/* db_connect
**
** MySQL database login script
** to include in all db-enabled php files
**
** Derek Wurtenberg
** 
*/

/* New DB connect info - Dustin ****/

$host = 'localhost';
$user = 'stl_frontend';
$pass = 'xvztktg';

$link = mysql_connect($host, $user, $pass);

/*********/


if(!$link) {
    //halt execution if cannot connect
    die("Cannot connect to the database! ".mysql_error());
}
mysql_select_db('southerntierlift', $link);

?>
