<?php 

include("./loginMgr.php");
//print_r($_REQUEST);
$logmgr=new loginMgr();
$logmgr->DataFolder="../../usrdata/login/";
$logmgr->svc();

?>