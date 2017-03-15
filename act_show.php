
<?php
header("Content-type: text/html; charset=UTF-8"); 
require ("mysql.php");
session_start();
$id=$_POST['li_boxid']-1;
$book=new db_mysql;
$book->connect("localhost", "root", "","books");
$result=$book->select("activity", "1=1 limit $id,5");
$i=0;
while($row=mysql_fetch_assoc($result)){
    $i++;
    $body=mb_substr($row['actbody'], 0 , 154,  "utf-8");
     //$pid=$row['pid'];
     //$presult=$book->select("login", "id=$pid");
     //$prow=mysql_fetch_assoc($presult);
     $actid=$row['id'];
     $imgresult=$book->select("actimage", "actid=$actid limit 1");
     $imgrow=mysql_fetch_assoc($imgresult);
        $arr['list'][]=array(
            'id'=>$row['id'],
            'actname'=>$row['actname'],
            'startime'=>$row['startime'],
            'endtime'=>$row['endtime'],
            'address'=>$row['address'],
            'body'=>$body,    
            'imgurl'=>$imgrow['imgurl'],            
            'class'=>$row['class'],
            'orgnize'=>$row['orgnize'],
            'postperson'=>$row['postperson'],
        );
     $arr['count']=$i;
}

echo json_encode($arr);
?>


                                                                            
                                                                            
