<?php
include("BibleDiary.php");



if(isset($_REQUEST['fname'])){
	echo $vmn->readNote($_REQUEST['fname']);
}


?>