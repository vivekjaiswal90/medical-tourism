<?php
$con = mysql_connect("database_host","database_user","password");
if(!$con) {
die('could not connect using the user name and password provided.');
}
mysql_select_db("database_name", $con) or die('could not connect to the database');
?>