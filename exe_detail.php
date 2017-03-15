<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['id'];
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$result=$book->select("bookstall", "id=$id");
$row=mysql_fetch_assoc($result);
$pid=$row['pid'];
$presult=$book->select("login", "id=$pid");
$exeid=$row['id'];
$imgresult=$book->select("exeimage", "exeid=$exeid");
$i=0;
while($imgrow=mysql_fetch_assoc($imgresult)){
    $i++;
    $img[$i]=$imgrow['imgurl'];
}

$prow=mysql_fetch_assoc($presult);
$arr['list'][]=array(
    'imgcount'=>$i,
    'id'=>$row['id'],
    'bookname'=>$row['bookname'],
    'exebody'=>$row['exebody'],
    'exeway'=>$row['exeway'],
    'connection'=>$row['connection'],
    'money'=>$row['money'],
    'time'=>$row['time'],    
    'img'=>$img,                                                                                                  
    'username'=>$prow['username'],
);
echo json_encode($arr);
?>

