<?php
$db = "lis";
$user = "root";
$pass = "";
$hostname = "localhost";
$conn = mysqli_connect($hostname, $user, "$pass", $db)
    or die("Unable to connect to database");
?>