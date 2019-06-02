<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sample &mdash; CKEditor</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="sample.css" />
</head>
<body>
	<h1 class="samples">
		CKEditor &mdash; Posted Data
	</h1>

<?php


if ( isset( $_POST ) )
	$postArray = &$_POST ;			// 4.1.0 or later, use $_POST
else
	$postArray = &$HTTP_POST_VARS ;	// prior to 4.1.0, use HTTP_POST_VARS

print_r($postArray);   
$today = date("Ymd_His"); 
echo $today;

$fname=$postArray["fname"];
$fnew=$fname . $today . ".htm";
rename($fname,$fnew);
echo $fnew;
file_put_contents($fname,$postArray["editor1"]);

foreach ( $postArray as $sForm => $value )
{
	if ( get_magic_quotes_gpc() )
		$postedValue = htmlspecialchars( stripslashes( $value ) ) ;
	else
		$postedValue = htmlspecialchars( $value ) ;

   echo ("<br>\n"); 
   echo htmlspecialchars($sForm); 
   echo ("::\n"); 
	echo $postedValue;
   

   file_put_contents($postArray['fname'],  $value);
}
?>


</body>
</html>
