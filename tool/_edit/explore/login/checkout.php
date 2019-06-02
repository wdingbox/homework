<?php
@session_start();

unset($_SESSION["LOGIN_USER"]);
unset($_SESSION);
echo "logout.<br>";
print_r($_SESSION);
echo "<br>";
echo $_SERVER["REMOTE_ADDR"] . "<br/>";
echo $_SERVER["HTTP_HOST"] . "<br/>";
echo $_SERVER["HTTP_USER_AGENT"] . "<br/>";
exit (1);




?>
