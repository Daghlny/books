<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['id'];
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$result=$book->select("entry", "id=$id");
$row=mysql_fetch_assoc($result);
$pid=$row['pid'];
$presult=$book->select("login", "id=$pid");
$actid=$row['id'];
$imgresult=$book->select("actimage", "actid=$actid");
$i=0;
while($imgrow=mysql_fetch_assoc($imgresult)){
        $i++;
        $img[$i]=$imgrow['imgurl'];
}

$prow=mysql_fetch_assoc($presult);
$arr['list'][]=array(
    'imgcount'=>$i,
    'id'=>$row['id'],
    'subject'=>$row['subject'],
    'class'=>$row['class'],
    'body'=>$row['body'],
    'time'=>$row['time'],    
    'img'=>$img,                                                                                                  
    'username'=>$prow['username'],
);
echo json_encode($arr);
?>

