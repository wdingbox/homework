<?php
include("../AAA.php");

class VerseIdParser{
	public $BookName;
	public $Chapter;
	public $Verse;
	
	public function VerseIdParser($verseID){
		//Format: _BooChapter_Verse 
		$pos=strpos ($verseID,"_", 3);
		if(!$pos) return;
		$len=$pos-4;
		$this->BookName=substr($verseID,1,3);//len=3
		$this->Chapter =substr($verseID,4,$len);//pos
		$this->Verse   =substr($verseID,1+$pos);//remained		
	}
	public function getLineHeader(){
		$hdr = $this->BookName." ".$this->Chapter.":".$this->Verse ." ";
		//echo $hdr;
		return $hdr;
	}
	
}//class VerseIdParser{

class BibleLoader{
	public $BibleFile="./Bibles/CUVs.txt";
	public $linesArr=[];
public function BibleLoader($BibleVer){
	$this->BibleFile="./Bibles/$BibleVer.txt";
	$this->linesArr=file($this->BibleFile);
}		
	
public function get_verse($verseID){
	$bcv = new VerseIdParser($verseID);
	$hdr=$bcv->getLineHeader();
	foreach($this->linesArr as $i=>$line){
		if(0===strpos($line,$hdr,0)){
			return $line;
		}
	}
	return "not_found";
}		
}// class BibleLoader{



class BVCLoader extends  AAA
{
	
public function SearchVerse($BookVersion, $verseID){
	switch($BookVersion){
		case "CUVs":
		case "NIV":
		case "KJV":
		case "BBE":
		case "CUVpy":
			$bv = new BibleLoader($BookVersion);
			return $bv->get_verse($verseID);
		break;
		default:
			return "Bad BookVer: $BookVersion";
		break;
	}
}

}//class BVCLoader extends  AAA







if( isset($_REQUEST['test']) ){
	$bl = new BVCLoader();
	echo $bl->SearchVerse("CUVs","_Gen1_1");
	exit(0);
}
if(isset($_REQUEST['BookverID']) && isset($_REQUEST['BCVid'])){
	//print_r($_REQUEST);
	$bl = new BVCLoader();
	echo $bl->SearchVerse($_REQUEST['BookverID'], $_REQUEST['BCVid']);
}
else{
	echo "err input, ?BookverID=CUVs&BCVid=_Gen1_1";
	print_r($_REQUEST);
}




?>