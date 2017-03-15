<?php
require ("mysql.php");
require ("email.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "214","books");
$email = stripslashes(trim($_POST['mail']));
$sql = "select id ,password from login  where email='$email'"; 
$query = mysql_query($sql); 
$num = mysql_num_rows($query); 
if($num==0){//该邮箱尚未注册！ 
    echo 'noreg'; 
    exit;  
}
else{
    $row = mysql_fetch_array($query); 
    $getpasstime = time();
    $uid = $row['id']; 
    $token = md5($uid.$row['password']);//组合验证码 
    $url = "http://localhost/book/reset.php?email='" . $email ."'&token=".$token;//构造URL 

    $sendmail = new email;
    $mailbody="请点击下面的链接重置您的密码！<br/><a href=" . $url . ">$url</a>";

    $res=$sendmail->mail("Books", "Books", "$mailbody", "$email");
    if($res==1){//邮件发送成功 
        $msg = '系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！'; 
        //更新数据发送时间
        mysql_query("update login set getpasstime='$getpasstime' where id=$uid");
    }
    else{ 
        $msg = $result;   
    } 
    echo $msg; 
}  


?>

