<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<title>SaveFile</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

	<link type="text/css" rel="stylesheet" href="sample.css" />

</head>

<body>
	<h1 class="samples">
		Create Dir
	</h1> 


<?php

$dir="";
if ( isset( $_GET ) ){

	$dir = $_GET["dir"] ;			// 4.1.0 or later, use $_POST
}
echo $dir . "<br>" ;

if(strlen($dir)==0) {
	echo "no dir name" ;
	exit(0);
}
if(file_exists($dir)) {
	echo "dir exists" ;
	exit(0);
}

////////////////////////////////////////////////
DEFINE ('ROOT_DIR','/www/99k.org/p/l/a/plastron777/htdocs/');
DEFINE ('FTP_HOST','plastron777.99k.org'); 
DEFINE ('FTP_USER','platron777_99k'); 
DEFINE ('FTP_PASS','5rdxwerty');
 
/**
  * Returns the created directory or false.
  *
  * @param Directory to create (String)
  * @return Created directory or false;
  */
 
function wei_ftp_mkDir ($path) {   
		echo "path=".$path ;
         $path = explode("/",$path);
         $conn_id = ftp_connect(FTP_HOST);
         if(!$conn_id) {
			 echo "err ftp_connect:" . FTP_HOST ;
             return false;
         }
         if (ftp_login($conn_id, FTP_USER, FTP_PASS)) {
             
            foreach ($path as $dir2) {
                 if(!$dir2) {
                     continue;
                 }
                 $currPath.="/".trim($dir2);
                 if(!@ftp_chdir($conn_id,$currPath)) {
                     if(!@ftp_mkdir($conn_id,$currPath)) {
                         @ftp_close($conn_id);
						 echo "err currPath:" . currPath ;
                         return false;
                     }
                     @ftp_chmod($conn_id,0777,$currPath);
                 }
             }
         }
         @ftp_close($conn_id); 
		 echo "ok"  ;
         return true;     
}///

$ftp_dir = substr($dir, strlen(ROOT_DIR));
echo $ftp_dir ;
if( wei_ftp_mkDir( $ftp_dir ) ) {
	echo "ftp create dir ok" ;
}
else {
	echo "failed to ftp create";
}

?>





</body>

</html>

