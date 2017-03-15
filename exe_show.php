<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$book=new db_mysql;

$book->connect("localhost", "root", "","books");
$id=$_POST['id']-1;
//$id=0;
$sortid=$_POST['sort'];
//$sortid=1;

$school=$_POST['school'];


$userid=$_SESSION['USERID'];
//$userid=41;

$myresult=$book->select("login", "id=$userid");
$myrow=mysql_fetch_assoc($myresult);
$myschool=$myrow['school'];

if($sortid==1){
    $result=$book->select("bookstall", "1=1 limit $id, 12");
}
else{
    $result=$book->select("bookstall", "class=$sortid limit $id, 12");
}
$i=0;
$arr="";
if($school!=""){
    while($row=mysql_fetch_assoc($result)){
        $pid=$row['pid'];
        $presult=$book->select("login", "id=$pid");
        $prow=mysql_fetch_assoc($presult);
        if($prow['school']=="$school"){
                $i++;
                $body=mb_substr($row['exebody'], 0 , 99,  "utf-8");
                $exeid=$row['id'];
                $imgresult=$book->select("exeimage", "exeid=$exeid limit 1");
                $imgrow=mysql_fetch_assoc($imgresult);
                $arr['list'][]=array(
                    'id'=>$row['id'], 
                    'bookname'=>$row['bookname'],            
                    'exeway'=>$row['exeway'],
                    'exebody'=>$body, 
                    'connection'=>$row['connection'], 
                    'imgurl'=>$imgrow['imgurl'],    
                    'time'=>$row['time'],
                    'username'=>$prow['username'],
                );
                $arr['count']=$i;
            }
    }
}
else{
    if($myschool!=""){
         while($row=mysql_fetch_assoc($result)){
             $pid=$row['pid'];
             $presult=$book->select("login", "id=$pid");
             $prow=mysql_fetch_assoc($presult);
             $school=$prow['school'];
            if($prow['school']=="$myschool"){
                 $i++;
                 $body=mb_substr($row['exebody'], 0 , 99,  "utf-8");
                 $exeid=$row['id'];
                 $imgresult=$book->select("exeimage", "exeid=$exeid limit 1");                      
                 $imgrow=mysql_fetch_assoc($imgresult);
                 $arr['list'][]=array(
                    'id'=>$row['id'],  
                    'bookname'=>$row['bookname'],            
                    'exeway'=>$row['exeway'],
                    'exebody'=>$body, 
                    'connection'=>$row['connection'],        
                    'imgurl'=>$imgrow['imgurl'],    
                                                                  
                    'time'=>$row['time'],
                    'username'=>$prow['username'],
                );
                 $arr['count']=$i;
            }
        }
    }
    else{
        while($row=mysql_fetch_assoc($result)){
             $pid=$row['pid'];
             $presult=$book->select("login", "id=$pid");
             $prow=mysql_fetch_assoc($presult);
             $school=$prow['school'];

             $i++;
             $body=mb_substr($row['exebody'], 0 , 99,  "utf-8");
             $exeid=$row['id'];
             $imgresult=$book->select("exeimage", "exeid=$exeid limit 1");                      
             $imgrow=mysql_fetch_assoc($imgresult);
             $arr['list'][]=array(
                'id'=>$row['id'],  
                'bookname'=>$row['bookname'],            
                'exeway'=>$row['exeway'],
                'exebody'=>$body, 
                'connection'=>$row['connection'],        
                'imgurl'=>$imgrow['imgurl'],    
                                                              
                'time'=>$row['time'],
                'username'=>$prow['username'],
            );
             $arr['count']=$i;
        }
    }
} 
echo json_encode($arr);
?>
