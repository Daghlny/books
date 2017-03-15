<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$id=$_POST['id'];
$id=76;
$result=$book->select("entry","id=$id");
$row=mysql_fetch_assoc($result);
$good=$row['good'];
$book->update("entry", "good=$good+1", "id=$id");
?>

