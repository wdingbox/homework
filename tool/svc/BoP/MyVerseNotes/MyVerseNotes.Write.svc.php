<?php
include ("./MyVerseNotes.php");


//print_r($_REQUEST);


if(isset($_REQUEST['BCVid']) && isset($_REQUEST['txt'])){
	$csid=$_REQUEST['BCVid'];
	$txt=$_REQUEST['txt'];
	
	$retArr=array();
	$retArr["size"]= $vmn->writeNote($csid, $txt);
	$retArr["result"]="ok";
	echo json_encode($retArr);
}
else{
	echo "input errors --";
	print_r($_REQUEST);
}




?>
