<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$id=$_SESSION['USERID'];
if(isset($_SESSION['USERID'])){
    $actname=mysql_real_escape_string($_POST['actName']);
    $startime=mysql_real_escape_string($_POST['startTime']);
    $endtime=mysql_real_escape_string($_POST['endTime']);
    $address=mysql_real_escape_string($_POST['location']);
    $class=mysql_real_escape_string($_POST['actType']);
    $orgnize=mysql_real_escape_string($_POST['organiger']);
    $postperson=mysql_real_escape_string($_POST['certifyPer']);
    $actbody=mysql_real_escape_string($_POST['actInfo']);
    $key="actname, startime, endtime, address, class, orgnize, postperson, actbody";
    $value="'$actname', '$startime', '$endtime', '$address', '$class' , '$orgnize', '$postperson', '$actbody'";
    $book->insert("activity", "$key", "$value");
    $actid=$book->insert_id();
    $fileType=array('image/jpg','image/jpeg','image/png','image/pjpeg','image/gif');//允许上传的文件类型                
    $num=count($_FILES['files']['name']);   //计算上传文件的个数
    for($i=0;$i<$num;$i++){
        if($_FILES['files']['name'][$i]
           !=''&&is_uploaded_file($_FILES['files']['tmp_name'][$i])){
                                      
                if(in_array($_FILES['files']['type'][$i],$fileType)){//判断文件是否是允许的类型
                    
                    if($_FILES["files"]["size"][$i]                    <2048000){                                                                     
                        $str=time();                     
                        $name=md5($str);                        
                        $_FILES['files']['name'][$i]=$name;

                        $fname='image/'.$_FILES['files']['name'][$i];
                        
                        move_uploaded_file($_FILES['files']['tmp_name'][$i],
                            $fname);
                        
                        $key="actid, imgurl";
                        
                        $imgvalue="$actid  , '$fname'";
                        
                        $book->insert("actimage","$key", "$imgvalue");

                        
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
    header("Location:  ../shuhui.html");

}
?>

