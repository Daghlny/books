<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['li_boxid']-1;
$sortid=$_POST['sort'];
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
if($sortid!=0){
    $value="class=$sortid order by time DESC limit $id,10";
    $result=$book->select("entry", "$value");
}
else{
    $result=$book->select("entry", "status=0 order by time DESC limit $id,10");
}
$i =0 ;
while($row=mysql_fetch_assoc($result)){
    $i++;
    $body=$row['body'];
    $body=mb_substr($body, 0, 100, "utf-8");  
    //echo $body;
    //echo "<br/>"; 
    $pid=$row['pid'];
    $presult=$book->select("login", "id=$pid");
    $entryid=$row['id'];
    $imgresult=$book->select("image", "entryid=$entryid  limit 1");
    $imgrow=mysql_fetch_assoc($imgresult);
    $prow=mysql_fetch_assoc($presult);
    $arr['list'][]=array(
        'id'=>$row['id'],
        'subject'=>$row['subject'],
        'class'=>$row['class'],
        'body'=>$body,
        'time'=>$row['time'],
        'imgurl'=>$imgrow['imgurl'],
        'username'=>$prow['username'],
    );
    $arr['count']=$i;
}
//print_r($arr);
echo json_encode($arr);
?>

