<?php
include("AAA.php");

class HistoryKeyFreq extends  AAA
{
	
public       $filename  = "HistoryKeyFreq.json";
public       $KeyFreqArr= array();
public       $pathfilename  = "";

public function SetDataFolder($path, $SubdirArr){
	parent::SetDataFolder($path, $SubdirArr);
	$this->pathfilename = $this->AccountFolder  . $this->filename;
}

public function loadArr(){
	$fname = $this->pathfilename;
	if(file_exists($fname)){
		$jsn = readfrfile($fname);
		$this->KeyFreqArr= json_decode($jsn,TRUE);//to arry();
		
		$this->KeyFreqArr['result']= "load count=".count($this->KeyFreqArr);
		return "load ok";
	}
	$this->KeyFreqArr['result']= "not exist";
	return "not exist";
}
public function getJson(){
	if(file_exists($this->pathfilename)){
		$jsn = readfrfile($this->pathfilename);
		return $jsn;
	}
	return json_encode("fileNotExisterr");
}
public function pushKey($key){
	if (array_key_exists($key,$this->KeyFreqArr))
	{	    
		$iFreq = intval ( $this->KeyFreqArr[$key] ) ;
		$this->KeyFreqArr[$key] = 1+$iFreq;
		echo " Key exists! $iFreq";
	}
	else
	{
		$arr = array('fruit' => 'apple', 'veggie' => 'carrot');

		$arr=$this->KeyFreqArr;
	    //echo " Key does not exist!";
	    $this->KeyFreqArr[$key] = 1;
	}   
}
public function storeKey($key){
	$jsn = json_encode($this->KeyFreqArr);
	return savetofile($this->pathfilename, $jsn);	   
}

public function Clear(){
	$fname = $this->pathfilename;
	if(strlen($fname)==0){
		return "invalid user";
	}
	return savetofile($fname, "");	
}
public function show(){
	print_r($this->KeyFreqArr);
	print($this->pathfilename);	   
}
}//class

$historykey=new HistoryKeyFreq();
$historykey->SetDataFolder("../../usrdata/BoP/",[]);
?>