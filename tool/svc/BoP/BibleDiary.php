<?php
include("AAA.php");

class BibleDiary extends  AAA
{
	
public function readNote($verseID){
	if(""===$verseID) $verseID=$this->fileToday();
	$filename=$this->AccountFolder . $verseID ;
	if(file_exists($filename)){
		return readfrfile($filename);		
	}
	return "(empty)";
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


public function Gen_SortedFilesOption(){
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$opns="<option value=''></option>\n";
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$sel="";
		if($file===$this->fileToday()){
			$sel="selected=1";
		}
		$opns.="<option value='$file' $sel>$file</option>\n";
	}
		
	return "$opns";
}


}//class

if(isset($_REQUEST['inc_mode'])){
	exit(0);
}
$vmn = new BibleDiary();
$vmn->SetDataFolder("../../usrdata/BoP/",["diary"]);
?>