<?php
include("AAA.php");

class VerseMyNote extends  AAA
{
	
public function readNote($verseID){
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

$vmn = new VerseMyNote();
$vmn->SetDataFolder("../../usrdata/BoP/",["vnotes"]);
?>
