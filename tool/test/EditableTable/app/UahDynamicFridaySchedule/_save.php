<?php
$file=$_REQUEST["file"];
$file.=".txt";
$contents=$_REQUEST["contents"];
$ret=file_put_contents ($file,$contents);
echo "SAVE:".$contents . ",$file," . $ret;
?>