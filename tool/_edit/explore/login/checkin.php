<?php
@session_start();
unset($_SESSION["LOGIN_USER"]);
$login_ok=false;
if( "       " === $_REQUEST["username"] && "       " === $_REQUEST["password"] ){
	$login_ok=true;
}
if( "wding" === $_REQUEST["username"] && "admin" === $_REQUEST["password"] ){
	$login_ok=true;
}
if($login_ok){
	$_SESSION["LOGIN_USER"]="OK";
	header("Location: ../index.php?dir=".$_SESSION["dir"]);
	exit(0);
}

echo "failed to login.<br>";
print_r($_REQUEST);
echo "<br>";
echo $_SERVER["REMOTE_ADDR"] . "<br/>";
echo $_SERVER["HTTP_HOST"] . "<br/>";
echo $_SERVER["HTTP_USER_AGENT"] . "<br/>";
exit (1);




?>
<!DOCTYPE html>

<html>

<head>
<title>login</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="sample.css" />
<script type="text/javascript" src="../../adapters/jquery.js">    </script>

<style type="text/css">
html,body {
	height: 100%;
	width: 100%;
	margin: 0px;
	padding: 0px 0px 0px 3px; //
	overflow: hidden;
}

span.op {
	position: absolute;
	top: 0px;
	right: 0%;
	margin-left: -250px;
}

a.path { //
	background-color: #dddd00;
	margin: 0px;
	padding: 0px 10px 0px 10px;
}

a.create_Dir { //
	background-color: #aaaaaa;
	margin: 0px;
	padding: 0px 10px 0px 10px;
}

a.create_File {
	margin: 0px;
	padding: 0px 10px 0px 10px;
}
</style>




<script type="text/javascript"> 

    $(document).ready(function(){               

    $("#file").click(function(){        
	});/////$("#file").click(function(){   
	
    $("#refresh").click(function(){   
        var fname = $(this).attr("fname");
        //alert(fname);
        window.open("./au2refresh.htm?fname="+fname, "_blank");
    });////




    $("#createDir").click(function(){   
    	var cwd=$("#getcwd").html();  
    	var ret=prompt("Create Dir in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create dir: \n\n"+cwd) ){
        	window.location.href="WorkCreateDir.php?dir="+cwd;
    	}
        
    });////
    $("#CreateFile").click(function(){   
    	var cwd=$("#getcwd").html();  
    	var ret=prompt("Create Dir in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create File: \n\n"+cwd, "ff") ){
        	window.location.href="WorkCreateFile.php?dir="+cwd;
    	}        
    });////


    $("#gosearch").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./search/index.php?dir="+dir, "_blank");
        
    });////

    $("#gosearch_html").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./search_html/index.php?dir="+dir, "_blank");
        
    });////
	
	$("#upload_file").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./upload/index.php?dir="+dir, "_blank");
        
    });////

    $("#goBackupDir").click(function(){  
    	var dir=$("#getcwd").html();  
		dir = $.trim(dir);		
		dir = dir.substring(0, dir.length - 1);
		var arr = dir.split("/");
		if(arr.length==0) return alert("err");
		var node=arr[arr.length-1];

    	var node2 = node + "_bak";
    	var ret=prompt("Backup Suffix:" , "_bk");
    	if (null==ret || node2.length==0) return alert("empty");
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        var dir2 = dir + ret;  
        ret = prompt(dir +"\nBackup as: \n", dir2) ;
    	if(null==ret || ret.length==0) return alert("empty");
        var url = "WorkBackupDir.php?dir="+dir+"&dir2="+ret;
        alert(url);
        window.open(url,"","width=700,height=600,scrollbars=yes, resizable=yes,");      
    });////

    
    
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body>

	<form action="login_check.php" method="post">
		<a>username</a><input id='username' name='username' value='username'></input><br />
		<a>password</a><input id='password' name='password' value='password'></input><br />
		<button type='submit'>submit</button>
	</form>


</body>

</html>
