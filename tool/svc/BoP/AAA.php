<?php
@session_start();

//replace file_put_contents()
function gzcompress2save( $dstName, $data )
{
	return file_put_contents($dstName, $data);
	
  $zp = gzopen("$dstName.zip", "w9");
  $ret = gzwrite($zp, $data);
  gzclose($zp);
  return $ret;
}
//replace file_get_contents()
function gzcompress2read($dstName)
{
	return file_get_contents($dstName);
	
  $zp = gzopen($dstName, "r");
  $data = gzread($zp, 100*filesize($dstName) );
  gzclose($zp);
  return $data;
}


function savetofile($fname,$data){
	return file_put_contents($fname,$data);
}
function readfrfile($fname){
	return file_get_contents($fname);
}
class AAA{
	
public       $DataFolder  = "./data/account/";
public       $AccountFolder  = "";

public function AAA(){
	if( !isset($_SESSION['email'])){
		die ("Invalid/unlogined user.");
	}
}

//old 
public function SetDataFolder($path,$arrSubDirs){
	if( !file_exists($path)){
		echo getcwd ()."<hr/>";
		die("fatal error - initial set data folder:$path not exist.");
	}
	
	$this->DataFolder = $path;
	$email=$_SESSION['email'];
	$path=$this->DataFolder . $email;
	if( !file_exists($path)){
		mkdir ($path, 0777);
	}
	foreach($arrSubDirs as $i=>$subdir){
		$path .= "/$subdir";
		if( !file_exists($path)){
			mkdir ($path, 0777);
		}
	}
	if( !file_exists($path)){
		echo "Could not create account folder:$path";
	}
	$this->AccountFolder=$path . "/" ;
}
public function SetAccountRoot($path){
	if( !file_exists($path)){
		echo getcwd ()."<hr/>";
		die("fatal error - initial set data folder:$path not exist.");
	}
	
	$this->DataFolder = $path;
	$email=$_SESSION['email'];
	$this->DataFolder .= $email;
	if( !file_exists($this->DataFolder)){
		mkdir ($this->DataFolder, 0777);
	}

	if( !file_exists($this->DataFolder)){
		echo "Could not create account folder:$path";
	}
	//$this->AccountFolder=$path . "/" ;
}
public function SetAccountPath($path){
	//$this->AccountPathNodeName=$path;
	$path = trim ($path, "/");
	if( strlen($path)==0){
		echo getcwd ()."<hr/>";
		die("fatal error - initial set data empty.");
	}
	$this->AccountFolder=$this->DataFolder . "/$path/";
	
	if( !file_exists($this->AccountFolder)){
		mkdir ($this->AccountFolder, 0777);
	}

	if( !file_exists($this->AccountFolder)){
		echo "Could not create account folder:$path";
	}
}



public $AccountFolderSortedFiles=array();
public function genAccountFolderSortedFiles(){
	$filesArr = scandir($this->AccountFolder);
	$trs="";
	$i=0;
	$this->AccountFolderSortedFiles=array();
	foreach($filesArr as $i=>$file){
		if( "."===$file || ".."===$file )continue;
		$pathfile=$this->AccountFolder.$file;
		$mt=date ("Y-m-d H:i:s.", filemtime($pathfile));
		$this->AccountFolderSortedFiles[$mt]=$file;
	}
		
	krsort ($this->AccountFolderSortedFiles);//key sort reverse order

}

public function Gen_SortedFilesOption(){
	$this->genAccountFolderSortedFiles();
	//ksort($this->AccountFolderSortedFiles);
	$opns="";//"<option value='' ></option>\n";
	foreach($this->AccountFolderSortedFiles as $i=>$file){
		$sel="";
		//if($file===$this->fileToday()){
		//	$sel="selected=1";
		//}
		$opns.="<option value='$file' name='$file' $sel>$file</option>\n";
	}
		
	return $opns;
}

}//class


?>