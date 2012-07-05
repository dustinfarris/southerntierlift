<?

/* db_connect
**
** MySQL database login script
** to include in all db-enabled php files
**
** Derek Wurtenberg
** 
*/

//$link = mysql_connect('localhost', 'phazehos_STLift', 'Ho[mMF9~az7$'); //Connects to the database at "localhost"


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
