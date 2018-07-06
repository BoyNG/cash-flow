<?php

$mysql_db_hostname = "localhost";
$mysql_db_database = "monetka";
$mysql_db_user = "";
$mysql_db_password = "";

$db = mysqli_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password, $mysql_db_database) or die("Could not connect database");

?>