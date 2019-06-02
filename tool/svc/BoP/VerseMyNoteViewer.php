<?php
include("AAA.php");

class VerseMyNoteBatchEditor extends AAA 
{
	
public function rrr($verseID){
	$filename=$this->AccountFolder . $verseID ;
	if(file_exists($filename)){
		return readfrfile($filename);		
	}
	return "(empty)";
}
public function www($verseID, $txt){
	$filename=$this->AccountFolder . $verseID ;
	return  savetofile($filename, $txt);
	//return file_put_contents($filename, $txt);
}
public function genTableOfNotes(){
	$this->genSortedFiles();
	$trs="";
	$i=0;
	foreach($this->SortedFiles as $mt=>$file){
		if( "."===$file || ".."===$file )continue;
		$pathfile=$this->AccountFolder.$file;
		$txt=readfrfile($pathfile);
		$mts="<select class='tms'><option value='0' selected>$mt</option>";
		$mts.="<option value='1'>Save</option>";
		$mts.="<select>";
		
		$trs.="<tr>";
		$trs.="<td class='tidx'>$i</td>";
		
		$trs.="<td id='$file'>$mts<button class='bcv'>$file</button><br/><a class='verse'>...</a>";
		$trs.="<br/><div class='vnote'  contenteditable='true'>$txt</div></td>";
		$trs.="</tr>";
		$i++;
	}
	$tr="<tr><td class='tidx'>#</td><td>Notes</td></tr>";
	echo "<table border='1'>$tr $trs.</table>";
}
public $SortedFiles=[];
public function genSortedFiles(){
	$filesArr = scandir($this->AccountFolder);
	$trs="";
	$i=0;
	$this->SortedFiles=[];
	foreach($filesArr as $i=>$file){
		if( "."===$file || ".."===$file )continue;
		$pathfile=$this->AccountFolder.$file;
		$mt=date ("Y-m-d H:i:s.", filemtime($pathfile));
		$this->SortedFiles[$mt]=$file;
	}
		
	krsort ($this->SortedFiles);//key sort reverse order

}

}//class

//$vb = new VerseMyNoteBatchEditor();
//$vb->SetDataFolder("../../usrdata/BoP/",["vnotes"]);
//$vb->getTableOfNotes();
?>
