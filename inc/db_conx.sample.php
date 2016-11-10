<?php
$mysqli_host = "localhost";
$mysqli_user = "root";
$mysqli_pass = "";
$mysqli_db_name = "tacef";

$db_conx = @mysqli_connect($mysqli_host,$mysqli_user,$mysqli_pass,$mysqli_db_name);
// evaluate the connection
 if (mysqli_connect_errno()) {
	 echo mysqli_connect_error();
	 exit();
	 }
?>