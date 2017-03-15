<?php
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "214","books");
$value="status=0";
$result=$book->select("entry", "$value");



$user=$book->select("login", "1=1");

?>
