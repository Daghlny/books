<?php
require ("mysql.php");
session_start();
$book=new db_mysql;
$book->connect("localhost", "root", "214","books");
$id=$_GET['id'];
echo $id;
if(isset($_POST['submit'])){
    $id=$_GET['id'];
    echo $id;
    $password=md5(trim($_POST['password']));
    $value="password='$password'";
    $condition="id=$id";
    $book->update("login", "$value", "$condition");

}


?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/home/qmk/下载/bootstrap/css/bootstrap.css">
</head>
<form class="form-horizontal" role="form" action="find.php?id=<?php  echo $id ?>" method="post">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail3" name="password" placeholder="username">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
       
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-default" name="submit" value="提交">
     
    </div>
  </div>
</form>
