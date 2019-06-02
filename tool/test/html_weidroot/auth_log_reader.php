<?php
$command="./auth_log_reader.py";
echo $command."<hr>";
$str= system  ( $command  );
echo $str."<hr>";

$str= exec  ( $command  );
echo $str."<hr>";
?>
<a href='auth_log_reader.htm'>...</a>