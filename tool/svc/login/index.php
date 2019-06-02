<!DOCTYPE>
<html>
	<head>
		<title>Account</title>
		<script language="javascript" src="../ham12/jq/jquery.js"></script>
		<script language="javascript" src="../ham12/jq/MyCookies.js"></script>
<style>	
body {
    background-color:white  ;
    color: black;
    width:100%;
	font-size: 200%;
}
table{
	width:100%;
	font-size: 200%;
	}
	
	table tr td:first-child { width: 1em; }
	
input, button{
    font-size:60px;
    height:92px;
	width:100%;
}
#forgetPwd{
	font-size:50%;
	background-color:blue  ;
}
#data,#ret{
	color:blue  ;
}

#forgot,#create{
	color:blue;
}

#email,#passwd{background-color:yellow  ;}
</style>
<script language="javascript">
var surl=" "+window.location;//cast it as string.
var g_iCloseOnSuccess=surl.indexOf("CloseOnSuccessLogin");

$(document).ready(function(){

  $("#create").click(function(){
	login("create");
  });
  
  $("#login").click(function(){	  
	  login("login");
  });
  
  $("#forgot").click(function(){
	  login("forgot");
  });
  $("#ViewPass").click(function(){
	  login("forgot");
	  var t=$(this).text();
	  if(t.indexOf("in")>0){
		  $(this).text("Password(visible):");
		  $("#passwd").attr("type","password");
	  }
	  else{
		  $(this).text("Password(invisible):");
		  $("#passwd").attr("type","text");
	  }
  });
  $("#myform").submit(function(){
	  return false;
  });
  
  var email=MyCookies.get("email","wdingsoft@gmail.com");
  
  $("#email").val(email);
  $("#passwd").val(MyCookies.get("passwd","") );
});
function login(type){
	  var inpdata=$("#myform").serialize();
	  inpdata+="&type="+type;
	  console.log(inpdata);
	  
	MyCookies.set("email",$("#email").val(), 77);
	MyCookies.set("passwd",$("#passwd").val(), 77);	  
	$.ajax({
                type: "POST",
                data: inpdata,
                url: "../login/login.svc.php",
                success: function (data) {
					console.log("ret data:"+data);
					//alert("Result:"+data );
					$("#data").text(data);
					$("#htmdat").html(data);
					
					if(data.indexOf("ok")>=0){
						console.log("..");

						if(g_iCloseOnSuccess>=0){
							alert("Login success. Keep going on. :)");
							window.close();
						}else{
							window.location.replace("../");
						}
					}
                },
				complete:function(dat, ret){
					console.log(ret);
					$("#ret").text(" complete:"+ret);
					//alert("check your email:"+$("#email").val() );
				}
            });		
}
</script>


	</head>

<body>
<br>
<br>
	<hr/>
	<center>
	<form id='myform' action="." method="POST">
	<table border='0'><caption>Account</caption>
	<tr><td>Email:<br/><input  type='text' id='email' name='email' ></input></td></tr>
	<tr><td><a id='ViewPass'>Password(invisible):</a><br/><input type='text' id='passwd' name='passwd' ></input></td></tr>
	<tr><td><button id='login'>Login</button><a id='forgot'>forgot</a> | <a id='create'>create</a></td></tr>
	</table>
	</form>
	<a id='data'></a><br/>
	<a id='htmdat'></a><br/>
	<a id='ret'></a>
	</center>
	<br><br><hr/>
	<a>visit:</a><?php include("visitCount.txt");?>
	

	</body>
</html>
<?php
if(!isset($_REQUEST['test'])) exit();


$str="Compress me Then after I changed them back to the original permissions, Then after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, sshThen after I changed them back to the original permissions, ssh' 新闻hao123地图视频贴吧登录设置更多产品把百度设为主页关于百度About Baidu©2015 Baidu使用百度前必读 意见反馈 京ICP证030173号 ";

$compressed = gzcompress($str, 9);
echo $compressed;
$uncompressed = gzuncompress($compressed);
echo "<hr/>";
echo $uncompressed;
echo "<hr/>";


file_put_contents("zt2.bin", $compressed);
file_put_contents("zt3.txt", $str);


function compress_save( $dstName, $data)
{   
	$f = fopen ( "$dstName", 'w' );
    $ret = fwrite ( $f, gzcompress ( $data, 9 ) );
    fclose ( $f );
	return $ret;
}
function uncompress_read($dstName)
{    
	$f = fopen ( "$dstName", 'r' );
    $compressed=fread ( $f, 9999 );
    fclose ( $f );
  
    $uncompressed = gzuncompress($compressed);
	echo "<hr/>uncompress_read<hr/>$uncompressed<hr/>";
	return $uncompressed;
    
}
$zf="zzt.zip";
compress_save($zf,$str);
uncompress_read($zf);

function gzcompress2save($data, $dstName)
{
  $zp = gzopen($dstName, "w9");
  gzwrite($zp, $data);
  gzclose($zp);
}
function gzcompress2read($dstName)
{
  $zp = gzopen($dstName, "r");
  $data = gzread($zp, 100*filesize($dstName) );
  gzclose($zp);
  return $data;
}


//compress("t3.bin","t3.bin.gz");
//uncompress_read("zzzz.gz");


gzcompress2save($str, "zz.gz");
$red = gzcompress2read("zz.gz");
echo "<hr>red:<br/>".$red;


















?>
