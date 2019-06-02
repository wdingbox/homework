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

$search = $_REQUEST["search"];


$vmn->SetAccountPath($path);
if( !isset($search) ){
	echo $vmn->readNotesAll();
}else{
	echo $vmn->readNotesAll_search($search);
}
echo "<br/><br/><br/><br/><br/><br/><br/>";


echo "<hr/><font color='blue'>output_NotesInfo</font>";
	$filename=$vmn->AccountFolder ."/". $vmn->AccountPathNodeName . ".json";

	$path=rtrim($vmn->AccountFolder, "/");
	$filename=$path  . "_SizeInfo.json";
	
	$jsnData= json_encode($vmn->SizeInfo);
echo "<hr/>$filename<hr/>";
echo "<hr/>$jsnData<hr/>";	
	$filename=$vmn->output_NotesInfo_filename();
	$txt= $vmn->output_NotesInfo_text();
	echo "<hr/>$filename<hr/>";
echo "<hr/>$jsnData<hr/>";	

echo $vmn->output_NotesInfo();


?>