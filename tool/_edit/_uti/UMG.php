<?php
//Set no caching. Must output_buffering=4096 in php.ini
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
 
session_start();
//openlog("php", LOG_PID | LOG_PERROR, LOG_SYSLOG);
//syslog(LOG_EMERG, "openlog('php', LOG_PID | LOG_PERROR, LOG_SYSLOG);\n");//LOG_LOCAL0



include_once ("Wsss.php");
// contains following:
// include_once ("Defs.php");
// include_once ("Uti.php");
// include_once ("Mbx.php");


include_once ("Dbm.php");

include_once ("UmgLocale.php");


//include_once ("Uxpath.php");
//include_once ("Pyx.php");




Wsss::Check();




Wsss::REQUEST_2_SESSION();

//for visit 
$cwd=getcwd();
Ui_Visit::add();
?>