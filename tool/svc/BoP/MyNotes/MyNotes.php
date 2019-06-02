<?php
include("../AAA.php");

class MyNotes extends  AAA
{
public $SizeInfo=[];
public function readNote($verseID){
	if(strlen($verseID)===0) return "(empty filename)";
	$this->autoSetAccountPath($verseID);
	$filename=$this->AccountFolder . $verseID ;
	if(file_exists($filename)){
		return readfrfile($filename);		
	}
	return "";//$verseID not exist yet.";
}
public function writeNote($verseID, $txt){
	$this->autoSetAccountPath($verseID);
	$filename=$this->AccountFolder . $verseID ;
	return  savetofile($filename, $txt);
	//return file_put_contents($filename, $txt);
}



public function readNotesAll_search($search){
	if( strlen($search) === 0 ) return;
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$outext="";
	$k=0;
	
	$replace="<font color='red'>$search</font>";
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$pathfile = $this->AccountFolder . $file;
		
		$contents = $this->readNote($file);
	
		if(false === stripos($contents, $search) ){
			continue;
		}
		$contents = str_ireplace($search, $replace, $contents);
		
		$this->SizeInfo[$file]=strlen($contents);
		
		$outext .= "<div class='itm' onclick='_clic(this);'><a class='idx' onclick='_clic(this);'>$k.</a><a class='fname' fname='$file' onclick='read_fname(this);'>$file</a>";
		$outext .= "<a class='txt' onclick='_clic(this);'>". $contents . "</a></div>";
		$k++;
	}
		
	return $outext;
}
public function readNotesAll(){
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$outext="";
	$k=0;
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$pathfile = $this->AccountFolder . $file;
		
		$contents = $this->readNote($file);
		$this->SizeInfo[$file]=strlen($contents);
		
		$outext .= "<div class='itm' onclick='_clic(this);'><a class='idx' onclick='_clic(this);'>$k.</a><a class='fname' fname='$file' onclick='read_fname(this);'>$file</a>";
		$outext .= "<a class='txt' onclick='_clic(this);'>". $contents . "</a></div>";
		$k++;
	}
		
	return $outext;
}
public function output_NotesInfo(){
	$filename=$this->output_NotesInfo_filename();
	$txt= $this->output_NotesInfo_text();
	return  savetofile($filename, $txt);
}
public function output_NotesInfo_filename(){
	$this->autoSetAccountPath("_BkCkVs");
	$path=rtrim($this->AccountFolder, "/");
	$filename=$path  . "_SizeInfo.js";
	return  $filename;
}
public function output_NotesInfo_text(){
	$jsnData= json_encode($this->SizeInfo);
	$txt= "var MyNotes_SizeInfo=" . $jsnData . ";";
	return   $txt;
}

public function readNotesAll____Bak(){
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$outext="";
	$k=0;
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$pathfile = $this->AccountFolder . $file;
		$outext .= "<div class='itm' onclick='_clic(this);'><a class='idx' onclick='_clic(this);'>$k.</a><a class='fname' fname='$file' onclick='read_fname(this);'>$file</a>";
		$outext .= "<a class='txt' onclick='_clic(this);'>". $this->readNote($file) . "</a></div>";
		$k++;
	}
		
	return $outext;
}
public function autoSetAccountPath($fname){
	if(substr($fname,0,1)==="_"){
		$this->SetAccountPath("vnotes/");
	}
	else{
		$this->SetAccountPath("diary/");
	}
}

}//class
//
//if(isset($_REQUEST['inc_mode'])){
//	exit(0);
//}
$vmn = new MyNotes();
$vmn->SetAccountRoot("../../../usrdata/BoP/" ); 
$vmn->SetAccountPath("vnotes/" );//vnotes, diary
?>