<?php
include("MyNotes.php");


$params=array("ReadAll_Dairy"=>"diary/","ReadAll_Vnote"=>"vnotes/");

$path = $_REQUEST["path"];
if( !isset($path) ){
	print_r($_REQUEST);
	echo " no path is set.";
}
$path=$params[$path];
if( !isset($path) ){
	print_r($_REQUEST);
	echo " wrong path is set.";
}
$vmn->SetAccountPath($path);
echo $vmn->readNotesAll();



?>