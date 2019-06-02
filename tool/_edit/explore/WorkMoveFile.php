<?php
// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

date_default_timezone_set('America/New_York');
$today = date("Ymd_His");


$fname=$_REQUEST["fname"];
$newfname=$_REQUEST["newfname"];

echo "Move file:<br/>";
echo "Fr: $fname:<br>";
echo "To: $fname:<br>";

$ret = rename($fname, $newfname);

echo $ret;
if($ret ){
	echo "<br/>OK";
}


?>

