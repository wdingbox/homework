<?php
//include_once("../../_uti/Uti.php");

set_time_limit(180000);//seconds

define("LIST_FILES_FILTESTR", "-listFiltersString.txt");

define("LIST_FILES_FILTERED", "-listFilesFiltered.txt");
define("LIST_FILES_MODIFIED", "-listFilesModified.txt");
define("LIST_FILES_WKFOLDER", "-listFilesWkFolder.txt");






class SearchUti{
public static function removeArr($srcArr, $arr){
    $ret=array();
    for($i=0;$i<count($srcArr); $i++) {
        $line=$srcArr[$i];
        $line=trim($line);
        $line=rtrim($line, "/");
        if(in_array($line, $arr)){
            continue;
        };
        $ret[]=$line;
    }    
    return $ret;
}
public static function removeEmptyElement(& $arr ){
    for($i=0;$i<count($arr); $i++) {
        $line=$arr[$i];
        $line=trim($line);
        $line=rtrim($line, "/");
        if(strlen($line)==0){
            unset($arr[$i]);
        }else{
            $arr[$i]=$line;
        }
    }
}
public static function permissionCheck(& $arr ){
    $ret =0;
    for($i=0;$i<count($arr); $i++) {
        $file=$arr[$i];
        $file=trim($file);
        if(strlen($file)==0){
            continue;
        }
        if(!is_writable($file)){
            //if (!chmod($file, 0777)) {
            // echo "Cannot change the mode of file ($file)<br>";
            //}
            //$writbale=fileperms ("$file.xxx");
            //echo "fileperms : $writbale ($file)<br>";
        }; 
        $writbale=is_writable($file);
        if(!$writbale){
            //$ret -=1;
            //echo "<br/>Cannot write,$writbale ($file)<br>";
        }
    }
    return $ret;
}
public static function duplicateCheck(& $arr , & $Dups){
    $bnamesTmpArr=[];
    for($i=0;$i<count($arr); $i++) {
        $line=$arr[$i];
        $line=trim($line);
        if(strlen($line)==0){
            unset($arr[$i]);
            continue;
        }
        $bname=basename($line);
        if(in_array($bname, $bnamesTmpArr)){
            $Dups[]=$bname;
            continue;
        }
        $bnamesTmpArr[]=$bname;
    }
}

    static function UrlOfPathfilename($filename){
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        //$arr=explode("?",$actual_link);
        //$actual_link=$arr[0];
        $ruiArr=explode("/wroot/", $actual_link);
        $uri0=$ruiArr[0];
        $fileArr=explode("/wroot/", $filename);
        if(count($fileArr)<2){
            return "$filename is not url...";
        }
        $uri1=$fileArr[1];
        $actual_link = "$uri0/wroot/". $uri1; 
        return    $actual_link;         
    }
}//Uti

class DuplicatedBaseNameCheck{
    public $tmpArr=[];
    public $dupArr=[];
    public $filesFilterStr="htm;html;";
public function findDups(& $arr ){
    for($i=0;$i<count($arr); $i++) {
        $bname=$arr[$i];
        if(in_array($bname, $this->tmpArr)){
            $this->dupArr[]=$bname;
            //echo "<br/>[$bname]-------------------";
            continue;
        }
        $this->tmpArr[]=$bname;
        //echo "<br/>add:[$bname]-------------------";
    }
}    
public function run(& $arr ){
    for($i=0;$i<count($arr); $i++) {
        $file=$arr[$i];
        $file=trim($file);
        if(strlen($file)===0){
            continue;
        }
        //echo "<br/>[$i]$file";
        if( is_dir($file)){
            //echo "<br/>is_dir-------------------$file";
            $pf=new PathFiles($file, $this->filesFilterStr,true);
            $this->run($pf->files);
            continue;
        }
        $bname=basename($file);
        if(in_array($bname, $this->tmpArr)){
            $this->dupArr[]=$file;
            //echo "<br/>[$bname]-------------------$file";
            continue;
        }
        $this->tmpArr[]=$bname;
    }
}
public function showDups(){
    $size=count($this->dupArr);
    for($i=0;$i<$size; $i++) {
        echo "<br/>$i : ".$this->dupArr[$i]; 
    }
    echo "<hr/>";
    return $size;
}

}


class SingleHtmlContentsLinkModifyer
{
    public $filename;
    public $searchStr="";
    public $replaceStr="";
    public $bPreview=true;
    
    public $occur=0;
    
    public $msg="";
    
    public $nErr=0;

    public $fcontentOrig="";
    public $fcontentNew="";
    public $fcontentPreview="";
    
	public function __construct($filebasenameOld,$filebasenameNew,$bPreview){
        //$filebasenameOld=str_replace(".",".",$filebasenameOld);
        //$filebasenameNew=str_replace(".",".",$filebasenameNew);
        
        $this->searchStr  = $filebasenameOld;
        $this->replaceStr = $filebasenameNew;
        $this->bPreview   = $bPreview;
        
        $this->pregSearch = "/(.{7}[\"\'\/])".$filebasenameOld."([\"\'\?\#].{0,20})/i";// href='./aaa.htm?a=a' 
        //$this->pregReplac = "$1".$filebasenameNew."$2";//must use callback, $1 mixed up when replacestring start with number. eg. 3.htm, it will be $13.htm.
        
        $replaceStrPrev = "<font size='3' color='#ff00ff' title='orig: $filebasenameOld'>$filebasenameNew</font>";
        $this->pregSearchPreview  = "/([\"\'\/]|&#34;|&quot;)".$filebasenameOld."([\"\'\?\#\&]|&#34;|&quot;)/";
        $this->pregReplacePreview = "$1".$replaceStrPrev."$2";//this is ok.

        //preg: .{0,50}  any chars with max len of 50.
        $this->pregMatch = "/.{0,120}([\"\'\/]|&#34;|&quot;)".$filebasenameOld."([\"\'\?\#\&]|&#34;|&quot;).{0,120}/";
              
       
	}
	public function runModify($htmfile){
        $this->fcontentOrig="";
        $this->fcontentNew="";
        $this->fcontentPreview="";
        $this->msg="";
        
		$this->fcontentOrig  = file_get_contents($htmfile);
       
        $this->fcontentPreview ="<ol title='".$this->searchStr."  &nbsp;&nbsp;(orig)'>";
        $this->fcontentNew = preg_replace_callback($this->pregSearch, function ($matches) {
            //print_r($matches);
            //echo "<br/>";
            $replc=$matches[1].$this->replaceStr.$matches[2];
            
            //$str2=str_replace($this->searchStr,$this->replaceStr,$matches[0]);            
            $strEncoded=htmlspecialchars($replc);//to show replaced raw string.
            $replc2="<font color='#ff0000'>".$this->replaceStr."</font><strike>".$this->searchStr."</strike>";
            $replc3=str_replace($this->replaceStr,$replc2,$strEncoded);
            $this->fcontentPreview .="<li title='$replc :=: ".$this->searchStr."'>";
            $this->fcontentPreview .="... ".$replc3." ...";//
            $this->fcontentPreview .="</li>";
            
            return ($replc);
        }, $this->fcontentOrig, -1, $occur);
        $this->fcontentPreview .="</ol>";
        
        $this->occur=$occur;
		if($occur>0){ 
            
            if(!$this->bPreview){               
                $ret = file_put_contents($htmfile, $this->fcontentNew);
                if($ret===false){
                    $this->nErr=+1;
			    	die("<br/><font color='red'>Fatal Err: Failed to modify. Please check permission: </font>$htmfile ");
			    }
			    else{
			    	$this->msgOK("ok save replace counts:$occur - $ret (B)");
			    }
            }
            else{
                $this->msgErr("preview contents changes results will be here.");
            }
		}
		else{
			$this->msgInfo("No found");
		}
        return $this->nErr;
	}  
    public function msgOK($msg){
        $this->msg.= "<span style='background-color:#00ff00;'>$msg</span><br/>";
    }
    public function msgErr($msg){
        $this->msg.= "<span style='background-color:#ff0000;'>$msg</span><br/>";
    }
    public function msgInfo($msg){
        $this->msg.= "<span style='background-color:#ff00ff;'>$msg</span><br/>";
    }

    public function previewPrint(){
        echo "<a class='Precaution' onclick='togle(this)'>==".$this->occur." in Preview(toggle).</a><div class='fcontents'>";
        echo $this->fcontentPreview;
        echo "</div><br/>";
        echo $this->msg;
    }
}

class MultiHtmlContentsLinkModifyer 
{
	public 	$tot_found_lines_for_searchstr=0;
	public 	$tot_files_count_for_searchstr_found=0;
	public 	$tot_change_occur=0;
    
    public 	$indx=0;
    public $oFileContentsChanger;
    public $msg="";

	public function __construct($searchstr, $replacestr, $bPreview){
        $this->oFileContentsChanger=new SingleHtmlContentsLinkModifyer($searchstr, $replacestr,$bPreview);
	}
    public function modify(&$files){
        if(count($files)==0){
            $this->msg .= "no files<br/>";
        }
        $this->indx=0;
		foreach ( $files as $i => $file ) {
            //echo "$file<br/>";
            $nErr=$this->oFileContentsChanger->runModify($file);
            $count=$this->oFileContentsChanger->occur;
            if($count>0){
                $this->indx++;
                $this->tot_change_occur +=$count;
                $this->show($file,$count);
            }		
        }//for
        //echo "<hr/>";
	}

    public function show($file,$count){
            $indx=$this->indx;
		    $fsize = filesize($file);
            $actual_link=SearchUti::UrlOfPathfilename($file);
            $showfile= "[$indx]. <span><a href='$actual_link'>$file</a></span> - - - $fsize (B) ...";       
            echo "$showfile. replaceOccur:$count.";
            $this->oFileContentsChanger->previewPrint();	
    }
}






class PathFiles{
	public $files = Array();
    public $folders = Array();
    public $filtersArr=null;
    public $basefilesArr = Array();
    
    public $bRecursive=false;

	public function __construct( $dir, $filters,  $bRecursive){
        $this->genFilters($filters);
        $this->bRecursive=$bRecursive;
        
		$this->getfullpathfiles($dir);
		//echo count($this->files);
		natsort( $this->files );//natural sort
	}
	public function getfullpathfiles($dir){
		//echo "  $dir<br>";
        $dir=trim($dir);
        $dir=rtrim($dir,"/");
		$this->folders[]=$dir;
		if ($handle = opendir($dir)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."=== substr($entry, 0, 1)) continue;

				$fullpath="$dir/$entry";
				if( is_dir($fullpath) ){
					//echo " is dir<br>";
                    if(true===$this->bRecursive){
                        self::getfullpathfiles($fullpath);
                    }
				}
				else{
					//echo "$dir/$entry<br/>\n"; 
                    if(null===$this->filtersArr){
                        $this->files[]=$fullpath;                       
                    }
                    else{
                        $ext = pathinfo($fullpath, PATHINFO_EXTENSION);
                        if(in_array ($ext,$this->filtersArr)){
                            $this->files[]=$fullpath;
                            $this->basefilesArr[]=$entry;
                        }
                    }
				}
			}
			closedir($handle);
		}
	}
    public function genFilters( $file_filters){
		$this->filtersArr=null;
        if(strlen($file_filters)===0 ) {
            return ;
		}
        
		$file_filters=trim($file_filters," ;");
        $file_filters = str_replace(".", "", $file_filters);
        $file_filters = str_replace(" ", "", $file_filters);
		$filtersArr = explode(";", $file_filters);
		if(count($filtersArr)>0) {
			$this->filtersArr=$filtersArr;
		}
	}
}



class Modifyer{
    public $dir;
    public $original; //original files names
    public $modified; //to be modified files names.
    public $wkFolder; //affected dir
    
    public $bPreview=true;

public function __construct(){
    $this->init();
}
    
public function init (){
        if( isset($_REQUEST["bPreview"]) ){
            if("false"==$_REQUEST["bPreview"]){
                $this->bPreview=false;
                echo "<font color='red'>start real changes!</font><br/>";
            }
        }               
        
        if(!isset($_REQUEST["dir"])){
            die("dir is not set");
        }
        $dir=$_REQUEST["dir"];
        $this->dir=$dir;
        
        
        $dir=trim($dir," ");
        $dir=trim($dir,"\/");
        $dir2 = preg_replace("/[\/\:]/", ".", $dir, -1, $occur);
        $dir2 = str_replace(":", "_", $dir2);//on window
        $dir2 = str_replace("\\", "_", $dir2);//on window
        
        $this->original="./tmp/~".$dir2.LIST_FILES_FILTERED;
        $this->modified="./tmp/~".$dir2.LIST_FILES_MODIFIED;
        $this->wkFolder="./tmp/~".$dir2.LIST_FILES_WKFOLDER;
        $this->filtersn="./tmp/~".$dir2.LIST_FILES_FILTESTR;
        
        if(!isset($_REQUEST["filesFilter"])){
            die("filesFilter is not set");
        }
        $this->filesFilter=$_REQUEST["filesFilter"];

}    
public function create(){

    //SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);
    $pf=new PathFiles($this->dir, $this->filesFilter,false);
    $files=$pf->files;
    
    //echo "<br/>\r\n";
    $contents="";
    $wkfolder="";
    $show="";
    //echo "<table border='1'>";
    $i=0;
    foreach($files as $id=> $file){
        //echo "<tr><td>$i</td><td class='pfname'>$file</td></tr>";
        $file=trim($file);
        if(strlen($file)==0) continue;
        $i++;
        $contents .= "$file\n";
        $wkfolder .= $this->dir."\n";
    }
    //echo "</table>";
    $size=file_put_contents($this->original,$contents); 
    $size=file_put_contents($this->modified,$contents);
    $size=file_put_contents($this->wkFolder,$wkfolder);
    
    $size=file_put_contents($this->filtersn,$this->filesFilter);
} 

public function LoadData(){
    
    //// Load files
    
    $this->listFilesFiltered = file ($this->original);
    $this->listFilesModified = file ($this->modified);
    $this->listFilesWkFolder = file ($this->wkFolder);
    
    $this->filesFilter = file_get_contents ($this->filtersn);
    
    SearchUti::removeEmptyElement($this->listFilesWkFolder);
    SearchUti::removeEmptyElement($this->listFilesModified);
    SearchUti::removeEmptyElement($this->listFilesFiltered);
    
    $size0=count($this->listFilesFiltered);
    $size1=count($this->listFilesModified);
    $size2=count($this->listFilesWkFolder);
    
    echo "$size0 = $size1 = $size2";
    if( $size0 != $size1 || $size0 != $size2 || $size1 != $size2 ){
        die( "  sizes differs <br>\n\n" );
    }

}  
public function showTable(){
    
    //// gen table    
    $toTexarea="<a class='editbtn' onclick='clkTH_Edit(this)'>Edit</a>";
    $toSaveDat="<a class='savebtn' onclick='clkTH_Save(this)'>Save</a>";
    
    echo "<a> Filters: ".$this->filesFilter . "</a>";
    echo "<br/><table border='1'>";
    echo "<tr><th class='hh'>#</th>";
    echo "<th class='hh' url='svrSaveAlteredFile.php'>Rename [$toTexarea] [$toSaveDat]</th>";
    echo "<th class='hh' url='svrSaveAffectedDir.php'>Affected Dir [$toTexarea] [$toSaveDat]</th>";
    echo "<th class='hh'>initial basenames in workdir</th></tr>";
    $size0=count($this->listFilesFiltered);
    for($i=0;$i<$size0;$i++){
        $a=$this->listFilesFiltered[$i];
        $b=$this->listFilesModified[$i];
        $c=$this->listFilesWkFolder[$i];
        
        $inpc="<a class='modify'>$c</a>"; 
        
        $abase=basename($a);
        $bbase=basename($b);
        
        $stya="";
        $styb="";//class='modify'";
        $styc="";
        $rwfntcolr="";
        $diff="";
        if($a!=$b){
            $diff="style='background-color:#ff0000' title='different names btw to be Renamed and the initial'";
        }
        
        if(!file_exists ($a)){
            $stya="style='background-color:#ffff00' title='not exist'";
        }
        if(!file_exists ($b)){
            $styb ="style='background-color:#ffff00' title='not exist'";
        }
        if(!file_exists ($c)){
            $styc ="style='background-color:#ff0000' title='not exist'";
        }
        
        echo "<tr class='mody_tr'>";
        echo "<td $diff>$i</td><td><a $styb >$b</a></td><td $styc>$inpc</td><td $stya>$abase</td>";
        echo "</tr>";
    }
    echo "</table>";
}
public function dieErr($mg){
    die("<font color='red'>dieErr: $mg</font>");
}
public function CheckDupFileNames(){
    $filerstr="(<font color='red'>No filters strings for affected dir</font>)";
    if(strlen($this->filesFilter)>0){
        $filerstr=$this->filesFilter;
    }
    echo( "<br/>Start check dup file names. filters:$filerstr<br><br/>" );
    $size0=count($this->listFilesFiltered);
    $originalnames=[];
    $modifiednames=[];
    $OnlyModifiedArr=[];
    for($i=0;$i<$size0;$i++){
        $a=$this->listFilesFiltered[$i];
        $b=$this->listFilesModified[$i];
     
        $searchstr =basename($a);
        $replacestr=basename($b);        
        $originalnames[] =$searchstr ;
        $modifiednames[] =$replacestr;
        if($searchstr===$replacestr) continue;
        $OnlyModifiedArr[]=$replacestr;
    }
    $dup=new DuplicatedBaseNameCheck();
    $dup->findDups($modifiednames);
    $dup->showDups();
    
    $moduniq1=array_unique($modifiednames);
    if(count($moduniq1)!=$size0){
        $this->dieErr("found duplicated in modified names");
    }
    

    $DupChecker=new DuplicatedBaseNameCheck();
    $DupChecker->findDups($originalnames);//shuld not have any dup.
    $DupChecker->findDups($OnlyModifiedArr);//modifed should not same to original.
    $ret=$DupChecker->showDups();
    if( $ret>0 ){
        $this->dieErr("modified names are not allowed to be same as current existing names. It cause overwirting");
    }
    
    //the filename that will be modified should be differ to all other files.
    for($i=0;$i<$size0;$i++){
        $a=$this->listFilesFiltered[$i];
        $b=$this->listFilesModified[$i];
        $c=$this->listFilesWkFolder[$i];
    
        $searchstr =basename($a);
        $replacestr=basename($b);
        if($searchstr===$replacestr) continue;
        
        $folder=pathinfo ($a,PATHINFO_DIRNAME);
        if($folder===$c){
            //continue;
        }
        
        //echo "==================". $this->filesFilter;
     

       $pf=new PathFiles($c, $this->filesFilter,true);
       $affectedFilesArr=SearchUti::removeArr($pf->files, $this->listFilesFiltered);//remove files in  current folder.
       
       //echo "fff=".count($affectedFilesArr);
       $basenamesArr=array();
       for($k=0;$k<count($affectedFilesArr); $k++){
           $fname=$affectedFilesArr[$k];
           $basenamesArr[]=basename($fname);
       }
       $basenamesArr=array_unique($basenamesArr);
       $DupChecker=new DuplicatedBaseNameCheck();
       $DupChecker->tmpArr=$basenamesArr;
       
       $arr=array($searchstr);
       $DupChecker->findDups($arr);
       $ret=$DupChecker->showDups();
       if( $ret>0 ){
           $this->dieErr("the affectedfolders constains the same file name as yours to be modified: $searchstr ");
       }
    }
}
public function ModifyFileContents(){
    echo "<hr/>Start to influence folders...<br/><br/>";
    $size0=count($this->listFilesFiltered);
    $idx=0;
    for($i=0;$i<$size0;$i++){
        $a=$this->listFilesFiltered[$i];
        $b=$this->listFilesModified[$i];
        $c=$this->listFilesWkFolder[$i];
        //echo "$a<br/>$b<br/><br/>";
        //echo "<hr/>";
        $searchstr =basename($a);
        $replacestr=basename($b);
        if($searchstr===$replacestr) continue;
        
     
        //$bPreview=true;
        $pf=new PathFiles($c, $this->filesFilter,true);
        $op = new MultiHtmlContentsLinkModifyer($searchstr,$replacestr,$this->bPreview);
        $op->modify($pf->files);
        //echo "<hr/>";
        if( $op->tot_change_occur > 0 ){        
            $idx++;
            echo "<br/>fr:$searchstr<br/>to:$replacestr<br/>$c:";
            echo "<br/>#$idx Results: AffectedDir tot_change_occur=".$op->tot_change_occur;
            echo "<hr/>";
        }
     
    }
    echo "<br/><hr><hr><hr><hr><hr><hr></br/>";
}
public function ModifyFileNames(){
    echo "<hr/><br/><br/>Start to rename...<br/>";
    $size0=count($this->listFilesFiltered);
    for($i=0;$i<$size0;$i++){
        $a=$this->listFilesFiltered[$i];
        $b=$this->listFilesModified[$i];
        $c=$this->listFilesWkFolder[$i];
        
        $searchstr=basename($a);
        $replacestr=basename($b);
        
        $stls="";
        if($a!=$b){
            $ret=false;//rename($a,$b);
            if(file_exists($b)){
                echo "<font color='yellow'>file_exists:$b</font><br/>";
                continue;
            }
            echo "<br/>$a<br/>$b<br/>";
            if(false===$this->bPreview){
                $ret=rename($a,$b);
                if(!$ret){
                    echo "<font color='red'>rename failed.</font><br/>";
                }
                else{
                    echo "<span style='background-color:#00ff00;'>rename ok.</span><br/>";
                }
            }
            else{
                echo "<span style='background-color:#ff0000;'>preview rename: not actually changed.</span><br/>";
            }

        }
    }
}
}//class
    
?>

