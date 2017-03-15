<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['id'];
//echo $id;
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$result=$book->select("entry", "id=$id");
$row=mysql_fetch_assoc($result);
$pid=$row['pid'];
$presult=$book->select("login", "id=$pid");
$entryid=$row['id'];
$imgresult=$book->select("image", "entryid=$entryid");
$i=0;
$com="";
$img="";
while($imgrow=mysql_fetch_assoc($imgresult)){
    $i++;
    $img[$i]=$imgrow['imgurl'];
}
$comresult=$book->select("comment", "entryid=$entryid");
$commi=0;
while($comrow=mysql_fetch_assoc($comresult)){
        $commi++;
        $com[$commi][0]=$comrow['body'];
        $com[$commi][1]=$comrow['author'];
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
    'likeSUM'=>$row['good'],
    'comment'=>$com, 
    'comcount'=>$commi,                                                                  
    'username'=>$prow['username'],
);
echo json_encode($arr);
?>

