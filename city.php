<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$city=$_POST['city'];
$result=$book->select("city", "city='$city'");
$i=0;
while($row=mysql_fetch_assoc($result)){
    $i++;
    $school=$row['school'];
    $arr['list'][]=array(
        'school'=>$school,
    );
    $arr['count']=$i;
}
echo json_encode($arr);
?>
                
                                                                   
