<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root","","books");
$id=$_SESSION['USERID'];
if(isset($_SESSION['USERID'])){
    $subject=mysql_real_escape_string(trim($_POST['artTitle']));
    $class=mysql_real_escape_string(trim($_POST['chosen_']));
    $body=mysql_real_escape_string(trim($_POST['article']));
    $status=0;
    $key="pid, subject, body, class, time, status";
    $value="$id, '$subject', '$body', '$class', NOW(), '$status'";
    $book->insert("entry", "$key", "$value"); 
    $entryid=$book->insert_id();

                   
    $num=count($_FILES['files']['name']);   //计算上传文件的个数
    for($i=0;$i<$num;$i++){
        if($_FILES['files']['name'][$i]!=''&&is_uploaded_file($_FILES['files']['tmp_name'][$i])){
            if($_FILES["files"]["size"][$i] < 2048000){
                $str=time()+$i;
                $name=md5($str); 
                $_FILES['files']['name'][$i]=$name;
                $fname='image/'.$_FILES['files']['name'][$i];
                move_uploaded_file($_FILES['files']['tmp_name'][$i],$fname);
                $key="entryid, imgurl";
                $imgvalue="$entryid , '$fname'";
                $book->insert("image","$key", "$imgvalue");
                 echo '<br/>文件上传成功！';
                }
            else{echo '<br>文件不允许超过2M';}
        }
        else{echo '<br/>没有上传文件';}
    }
    header("location:  ../shuba.html");
}
?>