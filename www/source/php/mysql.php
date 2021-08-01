<?php
//Set MYSQL login
$host = "database";
$user = "postpap";
$pass = "baconbacon";
$db = "postpap";
//Create MYSQL Connection
//mysql_connect
mysql_connect($host,$user,$pass) or die("Can't connect to MYSQL: ".mysql_error());
mysql_select_db($db) or die("Can't select MYSQL Database: ".mysql_error());
mysql_query("SET NAMES utf8");
//PDO
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) or die("Can't connect to MYSQL");
?>