<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['id'];
$body=$_POST['comment'];
$pid=$_SESSION['USERID'];
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$presult=$book->select("login", "id=$pid");
$prow=mysql_fetch_assoc($presult);
$author=$prow['username'];
$key="entryid, body, author";
$value="$id, '$body', '$author'";
$book->insert("comment", "$key", "$value");
?>


