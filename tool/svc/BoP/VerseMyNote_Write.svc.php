<?php
include ("./VerseMyNote.php");


//print_r($_REQUEST);


if(isset($_REQUEST['BCVid']) && isset($_REQUEST['txt'])){
	$csid=$_REQUEST['BCVid'];
	$txt=$_REQUEST['txt'];
	echo $vmn->writeNote($csid, $txt);
	//echo "test=.$csid";
}
else{
	echo "input errors --";
	print_r($_REQUEST);
}




?>
