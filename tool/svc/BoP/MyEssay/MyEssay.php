<?php
include("../AAA.php");

class MyEssay extends  AAA
{
	
public function readNote($verseID){
	if(""===$verseID) $verseID=$this->fileToday();
	$filename=$this->AccountFolder . $verseID ;
	if(file_exists($filename)){
		return readfrfile($filename);		
	}
	return "Err:$verseID.";
}
public function writeOnDate($file, $txt){
	if(""===$file){
		return $this->writeDiary($txt);
	}
	$filename=$this->AccountFolder . $file ;
	return  savetofile($filename, $txt);
	//return file_put_contents($filename, $txt);
}
public function writeDiary($txt){
	$file = $this->fileToday();
	return  $this->writeOnDate($file, $txt);
	//return file_put_contents($filename, $txt);
}
public function fileToday(){
	$date = new DateTime();
	//echo $date->format('Y-m-d');

	$file = $date->format('Y-m-d');
    return $file;
}


public function readNotesAll(){
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$outext="";
	$k=0;
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$pathfile = $this->AccountFolder . $file;
		$outext .= "<hr/>$k. <a style='background-color:grey;' onclick=read_diary_fr_txt('$file');>$file</a><br>";
		$outext .= $this->readNote($file);
		$k++;
	}
		
	return $outext;
}


}//class

if(isset($_REQUEST['inc_mode'])){
	exit(0);
}
$vmn = new MyEssay();
$vmn->SetDataFolder("../../../usrdata/BoP/",array("diary") );
?>