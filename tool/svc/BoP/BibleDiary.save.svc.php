<?php
include("BibleDiary.php");



if(isset($_REQUEST['file'])&& isset($_REQUEST['txt'])){
	echo "ok,";	
	$txt = $_REQUEST['txt'];
	$tsize=strlen($txt);
	echo $vmn->writeOnDate($_REQUEST['file'], $_REQUEST['txt']);
	echo "(B) was saved from $tsize(B).\n";
	print_r($_REQUEST);
}
else{
	echo "input failed";
	print_r($_REQUEST);
}


?>