<?php
session_start();
header("Content-type: text/html; charset=utf-8");
require ("mysql.php");
if(empty($_SESSION)){
    echo "<h1>请返回登陆页面进行登陆操作！游客无法查看“个人主页”！</h1></br>
        <a href = 'index.html'>登陆页面</a>";
    return;
}
$id=$_SESSION['USERID'];
$book=new db_mysql;
$book->connect("localhost", "root","","books");
$result=$book->select("login", "id=$id");
$row=mysql_fetch_assoc($result);
$username=$row['username'];
$city=$row['city'];
$sign=$row['sign'];
$school=$row['school'];
$topimage=$row['topimg'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html lang = "en">
<head>
	<title>books个人主页</title>
    <link rel="stylesheet" href="css/navbar.css" type = "text/css" media = "screen" />
    <link rel="stylesheet" href="css/gerenzhuye.css" type = "text/css" media = "screen" />
    <script type="text/javascript" src="scripts/jquery-1.9.0.min.js"></script>
    <script type = "text/javascript">
        var editInfoid = 1;
        $(window).load(function(){
            document.getElementById("infoPanelShowusername").innerHTML = "<?php echo $username; ?>";
            document.getElementById('infoPanelShowcity').innerHTML = "<?php echo $city; ?>";
            document.getElementById('infoPanelShowschool').innerHTML = "<?php echo $school; ?>";
            document.getElementById('infoPanelShowsign').innerHTML = "<?php echo $sign; ?>";
        });
        $(window).ready(function(){
            $("#head")[0].src = "<?php echo $topimage; ?>";
            $("#head").click(function(){/*上传头像*/
                document.getElementById("loadHead").click();
            });
            $("#loadHead").change(function(){
                var data = new FormData();
                data.append("file",document.getElementById('loadHead').files[0]);
                $.ajax({
                    url: "topimage.php",
                    type: "POST",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(responseText){
                        $("#head")[0].src = responseText;
                        alert("上传成功！");
                    }
                })
            })
            $("#login_slidePanel").hide();
            $("#loginImg").mouseover(function(){
                $("#login_slidePanel").slideDown(200);
            });
            $("#login_slidePanel").mouseleave(function(){
                $("#login_slidePanel").slideUp(200);
            });
                $(".infoPanelinput").css("display","none");
                $("#editInfo img").mouseover(function(){
                    if(editInfoid == 1){
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/edit_hover.png"
                    }
                    if(editInfoid == 2){
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/sure_hover.png"
                    }
                });
                $("#editInfo img").mouseleave(function(){
                    if(editInfoid == 1){
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/edit.png"
                    }
                    if(editInfoid == 2){
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/sure.png"
                    }
                })
                $("#editInfoImg").click(function(){
                    if(editInfoid == 1){
                        $(".infoPanelcontrols").css("display","none");
                        $(".infoPanelinput").css("display","block");
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/sure.png"
                        document.getElementById('infoPanelinput-username').value = document.getElementById('infoPanelShowusername').innerHTML;
                        document.getElementById('infoPanelinput-city').value = document.getElementById('infoPanelShowcity').innerHTML;
                        document.getElementById('infoPanelinput-school').value = document.getElementById('infoPanelShowschool').innerHTML;
                        document.getElementById('infoPanelinput-sign').value = document.getElementById('infoPanelShowsign').innerHTML;
                        editInfoid = 2;
                        return;
                    }
                    if(editInfoid == 2){
                        $(".infoPanelcontrols").css("display","inline");
                        $(".infoPanelinput").css("display","none");
                        document.getElementById('editInfoImg').src = "image/gerenxinxi/edit.png";
                        document.getElementById('infoPanelShowusername').innerHTML = document.getElementById('infoPanelinput-username').value;
                        document.getElementById('infoPanelShowcity').innerHTML = document.getElementById('infoPanelinput-city').value;
                        document.getElementById('infoPanelShowschool').innerHTML = document.getElementById('infoPanelinput-school').value;
                        document.getElementById('infoPanelShowsign').innerHTML = document.getElementById('infoPanelinput-sign').value;
                        var data = "username ="+document.getElementById('infoPanelinput-username').value+"&city ="+document.getElementById('infoPanelinput-city').value+"&school ="+document.getElementById('infoPanelinput-school').value+"&sign ="+document.getElementById('infoPanelinput-sign').value;
                        $.ajax({
                            type: "POST",
                            url: "updateperson.php",
                            data: {
                                'username': document.getElementById('infoPanelinput-username').value,
                                'city': document.getElementById('infoPanelinput-city').value,
                                'school': document.getElementById('infoPanelinput-school').value,
                                'sign': document.getElementById('infoPanelinput-sign').value
                            },
                            datatype: 'json',
                            success: function(){
                                alert("更改成功！");
                            }
                        });
                        editInfoid = 1;
                        return;
                    }
                });
        })
    </script>
</head>
<body>
	<div class="navbar">
    	<div id = "logo">
    		<img src="image/shuba/logo.png" alt="" id = "logoimg">
    	</div>
    	<ul class = "navbarItems">
    		<li><a href="shuba.html">书吧</a></li>
    		<li><a href="shutan.html">书摊</a></li>
    		<li><a href="shuhui.html">书会</a></li>
    	</ul>
    	<div id = "loginInfo">
    		<div id="login">
    			<img src="image/shuba/login.png" alt="" id = "loginImg">
                <ul id = "login_slidePanel">
                        <li><a href="gerenzhuye.php">我的主页</a></li>
                        <li><a href="shubabianji.html">发布书吧</a></li>
                        <li><a href="shutanbianji.html">发布书摊</a></li>
                        <li><a href="shuhuibianji.html">发布书会</a></li>
                        <li><a href="logout.php">退出</a></li>
                </ul>
    		</div>
    	</div>
    	<div id = "search">
    		<input type="text" placeholder="书籍" id = "searchBox"/>
    	</div>
    </div>
    <div id="headImgPanel">
    	<div id="headImgPanel-control"><!--头像-->
            <input type="file" id = "loadHead" style = "display: none" name = "file" />
    		<img src="image/gerenxinxi/head.jpg" alt="" title = "更换头像" id = "head">
    	</div>
    	<div id="username-control">
    		<span id = "usernameNow"></span>
    	</div>
    	<div id="headImgBTN-control">
    		<a href="shuba.html"><button id = "myArt" class = "headImgBTN">我的帖子</button></a>
    		<button id = "personInfo" class = "headImgBTN">个人信息</button>
    	</div>
    </div>
    <div id="infoPanel">
    	<div id="editInfo" class = "editInfo">
            <img src="image/gerenxinxi/edit.png" alt="" id = "editInfoImg">
	    </div>
    	<div id="myInfo-control">
	    	<div class="myInfo" id = "username-controls">
	    		<span class="infoPanelLabel">用户名：</span>
                <input type="text" class = "infoPanelcontrols infoPanelinput" id = "infoPanelinput-username">
	    		<span class="infoPanelcontrols" id = "infoPanelShowusername"></span>
	    	</div>
	    	<div class="myInfo" id ="city-controls">
	    		<span class="infoPanelLabel">所在城市：</span>
	    		<span class="infoPanelcontrols" id = "infoPanelShowcity"></span>
                <input type="text" class = "infoPanelcontrols infoPanelinput" id = "infoPanelinput-city">
	    	</div>
	    	<div class="myInfo" id = "school-controls">
	    		<span class="infoPanelLabel">所在学校：</span>
	    		<span class="infoPanelcontrols" id = "infoPanelShowschool"></span>
                <input type="text" class = "infoPanelcontrols infoPanelinput" id = "infoPanelinput-school">
	    	</div>
	    	<div class="myInfo" id = "sign-controls">
	    		<span class="infoPanelLabel">个性签名：</span>
	    		<span class="infoPanelcontrols" id = "infoPanelShowsign"></span>
                <input type="text" class = "infoPanelcontrols infoPanelinput" id = "infoPanelinput-sign">
	    	</div>
	    </div>
    </div>
    <div id = "navbarBottom">
    	<img src="image/shuba/navbarBottom.png" alt="">
    </div>
</body>
