<?php
include_once("svrBase.php");


$contents=$_REQUEST["contents"];

$modi=new Modifyer();
$fname=$modi->modified;

$size=file_put_contents($fname,$contents);
echo "<hr/>saved $fname<br>size=$size<br>\n\n";



?>

