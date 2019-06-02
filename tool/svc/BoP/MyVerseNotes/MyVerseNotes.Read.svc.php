<?php
include ("./MyVerseNotes.php");


//print_r($_REQUEST);

$BCVid=$_REQUEST['BCVid'];
echo $vmn->readNote($BCVid);
//echo "test=.$csid";




?>
