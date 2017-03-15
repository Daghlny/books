<?php
require ("mysql.php");
require ("email.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "214","books");
$verify = stripslashes(trim($_GET['verify'])); 
$nowtime = time();
$sql="select id,token_exptime from login  where status='0' and token=$verify";
//echo $sql;
$query = mysql_query($sql); 
$row = mysql_fetch_array($query); 
if($row){ 
    if($nowtime>$row['token_exptime']){ //24hour 
        $msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.';
    }
    else{
        $SQL="update login set status=1 where id=" . $row['id'];
        //echo $SQL;
        $link=mysql_query($SQL);
        if(mysql_affected_rows()!=1) 
            die(0); 
        $msg = '激活成功！'; 
    } 
}
else{ 
        $msg = 'error.';     
} 
echo $msg; 
?>
