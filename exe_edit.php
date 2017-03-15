<?php

header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$id=$_SESSION['USERID'];
if(isset($_SESSION['USERID'])){
    $money=mysql_real_escape_string($_POST['howMethod-sell-control-input']);
    $bookname=mysql_real_escape_string($_POST['title']);
    $exeway=mysql_real_escape_string($_POST['howMethod-control-checkbox']);
    $connection=mysql_real_escape_string($_POST['connection']);
    $exebody=mysql_real_escape_string($_POST['content']);
    $key="pid, bookname, exeway, connection, exebody, time, money";
    $value="$id, '$bookname', '$exeway', '$connection', '$exebody', NOW(), '$money'";
    $book->insert("bookstall", "$key", "$value");
    $exeid=$book->insert_id();
    $fileType=array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif');//允许上传的文件类型                
    $num=count($_FILES['files']['name']);   //计算上传文件的个数
    for($i=0;$i<$num;$i++){
         if($_FILES['files']['name'][$i]!=''&&is_uploaded_file($_FILES['files']['tmp_name'][$i])){
             if(in_array($_FILES['files']['type'][$i],$fileType)){//判断文件是否是允许的类型
                if($_FILES["files"]["size"][$i] < 2048000){
                    $str=time();
                                                                      
                    $name=md5($str);
                    $_FILES['files']['name'][$i]=$name;
                    $fname='image/'.$_FILES['files']['name'][$i];
                    
                    move_uploaded_file($_FILES['files']['tmp_name'][$i],
                        $fname);
                    $key="exeid, imgurl";
                    $imgvalue="$exeid  , '$fname'";
                    $book->insert("exeimage","$key", "$imgvalue");

                    echo '<br/>文件上传成功！';
                }
                else{
                    echo '<br>文件不允许超过2M';
                }
             }
             else{
                 echo '<br/>不允许上传该文件类型'; 
             }
         }
         else{
             echo '<br/>没有上传文件';
         }
    }
    Header("Location: ../shutan.html");
}


?>

