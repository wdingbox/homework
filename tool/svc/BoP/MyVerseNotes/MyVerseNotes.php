<?php
include("../AAA.php");

class MyVerseNotes extends  AAA
{
	
public function readNote($verseID){
	if(strlen($verseID)===0) return "(empty filename)";
	$filename=$this->AccountFolder . $verseID ;
	if(file_exists($filename)){
		return readfrfile($filename);		
	}
	return "(empty)";
}
public function writeNote($verseID, $txt){
	$filename=$this->AccountFolder . $verseID ;
	return  savetofile($filename, $txt);
	//return file_put_contents($filename, $txt);
}

}//class

$vmn = new MyVerseNotes();
$vmn->SetDataFolder("../../../usrdata/BoP/",["vnotes"]);
?>
