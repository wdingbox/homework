<?php
//include_once("../../_uti/Uti.php");

define("MY_DEFINED_HOST_NAME", "plastron777.dyndns-free.com");

define("DEF_cfg", ".cfg");
define("DEF_publish", ".publish");
//define("DEF_children", "_children");
define("DEF_files", ".files");
define("DEF_all", ".all");

class SearchUti{

	public static function file_exists_in_include_paths($filename, $includePaths, &$MapResults){
		$arr = explode(":",$includePaths);
		foreach($arr as $i=>$inlcude_dir){
			self::file_exists_in_dir($filename,$inlcude_dir,$MapResults);
		}
	}

	public static function file_exists_in_dir($filename, $dirname, &$MapResults){
		$dirname = rtrim($dirname,"/");
		if ($handle = opendir($dirname)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."===$entry || ".."===$entry) continue;
				$dirname2="$dirname/$entry";
				if( is_dir($dirname2) ){
					//echo " $dirname2<br>";
					$fullpathfilename = $dirname2 ."/". $filename;
					if( file_exists($fullpathfilename) ){
						$MapResults[] = $fullpathfilename;
					}
					self::file_exists_in_dir($filename, $dirname2, $MapResults);
				}
				else{
				}
			}

			closedir($handle);
		}
	}
	public static function get_relative_path_file($hostfullpathfile, $linkfullpathfile){
		echo "<br><br>host:$hostfullpathfile<br>link:$linkfullpathfile<br>";
		$hostnodesArr= explode("/", $hostfullpathfile);
		$linknodesArr= explode("/", $linkfullpathfile);
			
		$count=0;
		for($i=0; $i<1000; $i += 1){
			$hostnode = $hostnodesArr[$i];
			$linknode = $linknodesArr[$i];
			//echo "<br>$hostnode-----$linknode";
			if( $hostnode === $linknode ){
				unset($hostnodesArr[$i]);
				unset($linknodesArr[$i]);
				$count+=1;
				//echo "<br>$linknode";
				continue;
			}
			//echo "<br>$hostnode---====--$linknode";
			break;
		}
		if(0===$count) return "";
			
		$linkstring = "";
		for($i=0; $i<count($hostnodesArr)-1; $i += 1){
			$linkstring .="../";
		}
		$linkstring .= implode("/", $linknodesArr);
		return  $linkstring;
	}


	// ../../a/b.htm?x=y  ==>  /a.b.htm
	public static function CleanRelativePathFile( $relativeFilename , & $upNodNum){
		//echo "$relativeFilename<br>";
		$pos = strpos($relativeFilename, "?");
		if($pos>0){
			$relativeFilename = substr($relativeFilename, 0, $pos);
		}

		//echo "$relativeFilename<br>";
		$relativeNodesArr = explode("/", $relativeFilename);

		$upNodNum=0;
		$tailpathfile="";
		foreach($relativeNodesArr as $node){
			//echo "[$node]<br>";
			if($node===".") continue;
			if($node==="..") {
				$upNodNum+=1;
				continue;
			}
			$tailpathfile .= "/$node";
			//echo "$tailpathfile<br>";
		}

		return $tailpathfile;
	}
	public static function log_fullpathfiles($dir, & $count){
		//echo "  $dir<br>";
		if ($handle = opendir($dir)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."===$entry || ".."===$entry) continue;

				$fullpath="$dir/$entry";
				if( is_dir($fullpath) ){
					//echo " is dir<br>";
					self::log_fullpathfiles($fullpath,$count);
				}
				else{
					echo "$dir/$entry<br/>\n";
					$count+=1;
				}
			}

			closedir($handle);
		}
	}

	public static function GetFullPathFrRelative($baseDir, $relativeFilename,& $pExistingRelativePathFile,  & $pExistingFullpathFile ){
		//echo "$relativeFilename<br>";
		$upNodNum=0;

		$tailpathfile=self::CleanRelativePathFile($relativeFilename, $upNodNum);


		$nodeArr = explode("/", $baseDir);
		$LeftNodesCount = count($nodeArr) - $upNodNum;

		$LeftPath="";
		$LeftPathVar="";
		$pExistingFullpathFile="";
		$pExistingRelativePathFile="";
		foreach($nodeArr as $i=>$node){
			if(0===strlen($node) ) continue;
			$LeftPathVar .= "/$node";
			$wholepathfile = $LeftPathVar . $tailpathfile;
			if( file_exists($wholepathfile ) ){
				$pExistingFullpathFile=$wholepathfile;
			}
			else{
				if(strlen($pExistingFullpathFile)>0){
					$pExistingRelativePathFile .= "../";
				}
			}

			if($i < $LeftNodesCount) {
				$LeftPath .= "/$node";
			}
			//echo "<br/>$LeftPath";
		}


		if( strlen($pExistingFullpathFile)>0 ){
			if( strlen($pExistingRelativePathFile)>0){
				$pExistingRelativePathFile .= trim($tailpathfile, "/");
			}
			else{
				$pExistingRelativePathFile = "./". trim($tailpathfile, "/");
			}
		}

		$realfullpathfile = $LeftPath . $tailpathfile;
		if( file_exists($realfullpathfile)){
			if($realfullpathfile === $pExistingFullpathFile){
			}
			else{
				echo "<font color='red'>ALERT: Find two existing files !!!</font><br/>";
				echo "???===>>> <font color='red'>$realfullpathfile</font><br/>";
				echo "???===>>> <font color='red'>$pExistingFullpathFile</font><br/>";
			}
		}

		return $realfullpathfile;
	}
	public static function GetFullPathFrRelative222($baseDir, $relativeFilename,& $pExistingRelativePathFile,  & $pExistingFullpathFile ){
		//echo "$relativeFilename<br>";
		$pos = strpos($relativeFilename, "?");
		if($pos>0){
			$relativeFilename = substr($relativeFilename, 0, $pos);
		}

		//echo "$relativeFilename<br>";
		$relativeNodesArr = explode("/", $relativeFilename);

		$upNodNum=0;
		$tailpathfile="";
		foreach($relativeNodesArr as $node){
			//echo "[$node]<br>";
			if($node===".") continue;
			if($node==="..") {
				$upNodNum+=1;
				continue;
			}
			$tailpathfile .= "/$node";
			//echo "$tailpathfile<br>";
		}

		$nodeArr = explode("/", $baseDir);
		$LeftNodesCount = count($nodeArr) - $upNodNum;

		$LeftPath="";
		$LeftPathVar="";
		$pExistingFullpathFile="";
		$pExistingRelativePathFile="";
		foreach($nodeArr as $i=>$node){
			if(0===strlen($node) ) continue;
			$LeftPathVar .= "/$node";
			$wholepathfile = $LeftPathVar . $tailpathfile;
			if( file_exists($wholepathfile ) ){
				$pExistingFullpathFile=$wholepathfile;
			}
			else{
				if(strlen($pExistingFullpathFile)>0){
					$pExistingRelativePathFile .= "../";
				}
			}

			if($i < $LeftNodesCount) {
				$LeftPath .= "/$node";
			}
			//echo "<br/>$LeftPath";
		}


		if( strlen($pExistingFullpathFile)>0 ){
			if( strlen($pExistingRelativePathFile)>0){
				$pExistingRelativePathFile .= trim($tailpathfile, "/");
			}
			else{
				$pExistingRelativePathFile = "./". trim($tailpathfile, "/");
			}
		}

		$realfullpathfile = $LeftPath . $tailpathfile;
		if( file_exists($realfullpathfile)){
			if($realfullpathfile === $pExistingFullpathFile){
			}
			else{
				echo "<font color='red'>ALERT: Find two existing files !!!</font><br/>";
				echo "???===>>> <font color='red'>$realfullpathfile</font><br/>";
				echo "???===>>> <font color='red'>$pExistingFullpathFile</font><br/>";
			}
		}

		return $realfullpathfile;
	}
	public static function get_full_path_file($baseDir, $relativeFilename){
		$pos = strpos($relativeFilename, "?");
		$relativeFilename = substr($relativeFilename, 0, $pos);
		echo "$relativeFilename<br>";
		$relativeNodesArr = explode("/", $relativeFilename);
		$upNodNum=0;
		$tailpathfile="";
		foreach($relativeNodesArr as $node){
			echo "[$node]";
			if($node===".") continue;
			if($node==="..") {
				$upNodNum+=1;
				continue;
			}
			$tailpathfile .= "/$node";
		}

		$nodeArr = explode("/", $baseDir);
		$LeftNodesCount = count($nodeArr) - $upNodNum;

		$LeftPath="";
		foreach($nodeArr as $i=>$node){
			if($i==$LeftNodesCount) break;
			if(0===strlen($node) ) continue;
			$LeftPath .= "/$node";
			echo "<br/>$LeftPath";
		}

		$realfullpathfile = $LeftPath . $tailpathfile;
		return $realfullpathfile;
	}
	public static function URLIsValid($URL)
	{
		$exists = true;
		$file_headers = @get_headers($URL);
		//echo "<br>$URL<br>";
		//print_r( $file_headers);

		if(false === $file_headers){
			return false;
		}
		$InvalidHeaders = array('404', '403', '500');
		foreach($InvalidHeaders as $HeaderVal)
		{
			if(strstr($file_headers[0], $HeaderVal))
			{
				$exists = false;
				break;
			}
		}

		return $exists;
	}

	public static function Is_My_Url_Valid($URL)
	{
		$exists = true;
		$parsedUrl = parse_url($URL);
		$host = $parsedUrl["host"];

		//print_r( $parsedUrl );
		$docroot = $_SERVER["DOCUMENT_ROOT"];
		if($host===MY_DEFINED_HOST_NAME){
			$path = $parsedUrl["path"];
			$fullpathfile="$docroot/$path";
			if( file_exists ($fullpathfile) ){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			//return self::URLIsValid($URL);
		}
		return -1;
	}


	function getHttpResponseCode_using_curl($url, $followredirects = true){
		// returns int responsecode, or false (if url does not exist or connection timeout occurs)
		// NOTE: could potentially take up to 0-30 seconds , blocking further code execution (more or less depending on connection, target site, and local timeout settings))
		// if $followredirects == false: return the FIRST known httpcode (ignore redirects)
		// if $followredirects == true : return the LAST  known httpcode (when redirected)
		if(! $url || ! is_string($url)){
			return false;
		}
		$ch = curl_init($url);
		if($ch === false){
			return false;
		}
		@curl_setopt($ch, CURLOPT_HEADER         ,true);    // we want headers
		@curl_setopt($ch, CURLOPT_NOBODY         ,true);    // dont need body
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER ,true);    // catch output (do NOT print!)
		if($followredirects){
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,true);
			@curl_setopt($ch, CURLOPT_MAXREDIRS      ,10);  // fairly random number, but could prevent unwanted endless redirects with followlocation=true
		}else{
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,false);
		}
		//      @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5);   // fairly random number (seconds)... but could prevent waiting forever to get a result
		//      @curl_setopt($ch, CURLOPT_TIMEOUT        ,6);   // fairly random number (seconds)... but could prevent waiting forever to get a result
		//      @curl_setopt($ch, CURLOPT_USERAGENT      ,"Mozilla/5.0 (Windows NT 6.0) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1");   // pretend we're a regular browser
		@curl_exec($ch);
		if(@curl_errno($ch)){   // should be 0
			@curl_close($ch);
			return false;
		}
		$code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); // note: php.net documentation shows this returns a string, but really it returns an int
		@curl_close($ch);
		return $code;
	}

	public static function FullPathFile2MyUrl($fullpathfilename){
		$i = strlen( $_SERVER["DOCUMENT_ROOT"] );
		$path = substr( $fullpathfilename, $i );
		$url = "http://". MY_DEFINED_HOST_NAME . $path;
		return $url;
	}
	static function GetAllLinesWithKeyString($filename, $keyStr, &$count){
		$linesArry=Array();
		if( !file_exists($filename)) return $linesArry;
		$lines = file($filename);
		foreach ($lines as $idx => $line)
		{
			$ret = substr_count($line,$keyStr);
			//echo "-$pos-" . $line . "<br/>";
			if( $ret <= 0 ){
				continue;
			}
			$count += $ret;
			$linesArry[$idx] = $line;
		}
		return $linesArry;
	}
}//Uti



class Search_cfg_publish{
	public $files = Array();

	public function __construct($dir){
		$this->getfullpathfiles_cfg_published($dir);
	}
	public function getfullpathfiles($dir){
		//echo "  $dir<br>";
		if ($handle = opendir($dir)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."=== substr($entry, 0, 1)) continue;

				$fullpath="$dir/$entry";
				if( is_dir($fullpath) ){
					//echo " is dir<br>";
					self::getfullpathfiles($fullpath);
				}
				else{
					//echo "$dir/$entry<br/>\n";
					if( isset($this->files[$entry]) ){
						$this->files[$entry] .= ";$fullpath";
					}
					else{
						$this->files[$entry]=$fullpath;
					}
				}
			}
			closedir($handle);
		}
	}
	public function getfullpathfiles_cfg_published($dir){
		//echo ($dir);
		$publish = "$dir/".DEF_cfg."/".DEF_publish;
		$publish_all = "$dir/".DEF_cfg."/".DEF_publish."/".DEF_all;
		$publish_files = "$dir/".DEF_cfg."/".DEF_publish."/".DEF_files;

		if( false === file_exists($publish)){
			return;
		}
		if( true === file_exists($publish_all)){
			$this->getfullpathfiles($dir);
			return;
		}
		$bfiles = file_exists( $publish_files );
		//echo "  $dir<br>";
		if ($handle = opendir($dir)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."=== substr($entry,0, 1)) continue;

				$fullpath="$dir/$entry";
				if( is_dir($fullpath) ){
					//echo " is dir<br>";
					if( file_exists("$fullpath/".DEF_cfg."/".DEF_publish) ){
						self::getfullpathfiles_cfg_published($fullpath);
					}
				}
				else{
					//echo "$dir/$entry<br/>\n";
					if($bfiles){
						if( isset($this->files[$entry]) ){
							$this->files[$entry] .= ";$fullpath";
						}
						else{
							$this->files[$entry]=$fullpath;
						}
					}
				}
			}
			closedir($handle);
		}
	}
	public function show(){
		natsort($this->files);
		foreach($this->files as $i=>$file){
			echo "[$i] $file<br>";
		}
	}
}


class Search_Path_Files{
	public $files = Array();

	public function __construct( $dir ){
		$this->getfullpathfiles($dir);
		//echo count($this->files);
		natsort( $this->files );//natural sort
	}
	public function getfullpathfiles($dir){
		//echo "  $dir<br>";
		$this->files[]=$dir;
		if ($handle = opendir($dir)) {

			/* This is the correct way to loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if("."=== substr($entry, 0, 1)) continue;

				$fullpath="$dir/$entry";
				if( is_dir($fullpath) ){
					//echo " is dir<br>";
					self::getfullpathfiles($fullpath);
				}
				else{
					//echo "$dir/$entry<br/>\n";
					$this->files[]=$fullpath;
				}
			}
			closedir($handle);
		}
	}
	public function GetAllFilesInDirs_ByFilters( $file_filters){
		$file_filters=trim($file_filters," ;");
		$filtersArr = explode(";", $file_filters);
		if(strlen($file_filters)===0 || count($filtersArr)===0) {
			return $this->files;
		}
		$filesArry=Array();


		foreach ($this->files as $filename)
		{
			if( is_file($filename) ){
				foreach($filtersArr as $i=>$filter){
					$pos = strrpos($filename, $filter);
					if($pos === false ) continue;
					$filesArry[] = $filename;
				}
			}
		}
		//natsort( $filesArry );//natural sort
		return $filesArry;
	}
}

class PathFiles_filters{

	public $filesFiltersArr=Array();
	public function __construct($file_filters){
		$file_filters=trim($file_filters," ;");
		if( strlen($file_filters)>0){
			$this->filesFiltersArr = explode(";", $file_filters);
		}
	}
	protected function isFileredFile($filename){
		if( count($this->filesFiltersArr)===0 ){
			return true;
		}

		//if( is_file($filename) ){
		foreach($this->filesFiltersArr as $i=>$filter){
			$rpos = strrpos($filename, $filter);
			if( false === $rpos  ) {
				continue;
			}
			return true;
		}
		//}
		return false;
	}
	public function doFilter(&$files){
		$retArr=Array();
		foreach ( $files as $i => $file ) {
			if( false === $this->isFileredFile($file) ) {
				unset($files[$i]);
			}
		}
	}
}


class SearchPathFilesFilters{
	static public function getFiles(& $files, $cfgPublish, $dir, $filesFilter){
		$files=Array();
		if( "true"===$cfgPublish || "on" === $cfgPublish ){
			$spf = new Search_cfg_publish($dir);
			$files = $spf->files;
		}
		else{
			$spf = new Search_Path_Files($dir);
			$files = $spf->files;
		}
		$total=count( $files );

		$sf = new PathFiles_filters($filesFilter);
		$sf->doFilter( $files );
		echo "Total filtered files:" . count($files) . " / $total<hr/>";
	}
}

class FileFitler{
	public $files;
	public function __construct($file_filters){

	}

	public function run($files){
		$this->files = $files;
		$indx=0;
		foreach ( $files as $i => $file ) {
			$indx+=1;
			$this->show($i, $file);
		}//for
	}
	protected function show($indx, $file){
		$fsize = filesize($file);

		$color="#00ffff";
		if( is_dir($file) ){
			$color="#ffff00";
		}
		echo "[$indx] <span style='background-color:$color;'>$file</span> - - - $fsize(B) <br/>";
	}
}


class SearchStr extends FileFitler
{
	public $searchstr;
	public function __construct($file_filters, $searchstr){
		parent::__construct($file_filters);
		$this->searchstr = $searchstr;
	}
	protected function show($indx, $file){//overide
		$searchstr=$this->searchstr;
		if(strlen($searchstr)===0){
			return;
		}
		$tot_found_lines_for_searchstr=0;
		$tot_files_count_for_searchstr_found=0;
		$tot_search_found=0;

		$fsize = filesize($file);

		$count=0;
		$lines = SearchUti::GetAllLinesWithKeyString($file, $searchstr, $count);
		if(count($lines)>0){
			$tot_files_count_for_searchstr_found +=1;
			$tot_search_found += $count;
			$tot_found_lines_for_searchstr += count($lines);

			echo "[$indx]. <span style='background-color:#aaaaff;'>$file</span> - - - $fsize (B) ... $count (Found)<br/>";

			$this->show_work($indx, $file, $count, $lines);
		}
	}
	protected function show_work($indx, $file, $count, $lines){
		$searchstr = $this->searchstr;
		foreach($lines as $lineIdx => $line){
			$txt = htmlspecialchars($line);
			$foundstr = "<span style='background-color:#ff0000;'>$searchstr</span>";
			$txt = str_replace($searchstr,$foundstr, $txt);
			echo "<span style='background-color:#8899ff;'>__$lineIdx: </span>$txt<br>";
		}
	}
}
class ReplaceStr extends SearchStr
{
	public $replacestr;
	public $tot_search_replaced=0;
	public function __construct($file_filters, $searchstr, $replacestr){
		parent::__construct($file_filters, $searchstr);
		$this->replacestr = $replacestr;
	}
	protected function show_work($indx, $file, $count, $lines){
		$fcontent  = file_get_contents($file);
		$fcontent2 = str_replace($this->searchstr, $this->replacestr, $fcontent, $occur);
		if($occur === $count){
			$ret = file_put_contents($file, $fcontent2);
			$dbgstr="\nReplace:" . $this->searchstr . "\n To:" . $this->replacestr. "\n count="  . $occur . "\n in:" . $file ;
			file_put_contents("./log.txt", $dbgstr,  FILE_APPEND);
			if($ret===false){
				echo "<span style='background-color:#ff0000;'>Err: $file Failed to save.</span><br/>";
			}
			else{
				echo "$indx. <span style='background-color:#00ff00;'>$file</span> - - - $ret (B) ... $count (Replaced)<br/>";
				$this->tot_search_replaced += $count;
			}
		}
		else{
			echo "<span style='background-color:#ff0000;'>...ERROR: $occur differ from searched $count </span> <br>";
		}
	}
}






class SearchFileSys extends FileFitler
{
	public $searchstr;
	public $replacestr;
	public $AutoRenameAll;
	public function __construct($file_filters, $searchstr, $replacestr){
		parent::__construct($file_filters);
		$this->searchstr = $searchstr;
		$this->replacestr=$replacestr;
	}
	protected function show($indx, $file){//overide
		$searchstr=$this->searchstr;

		if(strlen($searchstr)>0){
			$count=0;
			$bname= basename($file);
			$pname= pathinfo($file,PATHINFO_DIRNAME);
			if( ".."==$bname){
				$bname= basename($pname);
				$pname= pathinfo($pname,PATHINFO_DIRNAME);
			}
			//echo "$pname   - - -> $bname <br/>";
			else if("."==$bname){
				return;
			}

			$bname = trim($bname,"/");
			$replacestr = trim($this->replacestr,"/");

			//echo "$pname ---- $bname <br/>";
			$replace = "<span style='background-color:#ff0000;' >$searchstr</span>";
			$count=0;
			$clrbname = str_replace($searchstr, $replace, $bname, $count);
			$newbname = str_replace($searchstr, $replacestr, $bname, $count);
			if( $count === 0){
				return;
			}


			$file = "$pname/$bname";
			$showtxt = "$pname/$clrbname";

			$ftype = "is_file";
			if( is_dir($file) )$ftype="is_dir";
			if( is_file($file) )$ftype="is_file";
			echo "<a id='file0'><span style='background-color:#aaffaa;'>$showtxt</span></a> - - - $ftype<br/>";



			if( strlen($replacestr)>0 ){
				$showtxt = "$pname/<span style='background-color:#ffaaaa;'>$newbname</span>";
				$file2 = "$pname/$newbname";
				echo "<a id='file2'><span style='background-color:#aaffaa;'>$showtxt</span></a>";
				echo " <a href='_rename.php?file0=$file&file2=$file2'> - - - [rename]</a><br/>";
			}

			if( "true"===$this->AutoRenameAll ){
				$ret = rename ($file, $file2);
				if(true === $ret){
					echo "<span style='background-color:#00ff00;'>OK Success.</span><br/><br>";
				}
				else{
					echo "<span style='background-color:#ff0000;'>...rename ERROR : $file2 </span> <br>";
				}
			}

		}
		else{
			$fsize = filesize($file);
			echo "[$indx] <span style='background-color:#00ff00;'>$file</span> - - - $fsize(B) <br/>";
		}
	}

}






class HtmFileLinkChecker{
	public $pattern_href="/\s+[hH][rR][eE][fF]\s*=\s*[\"\']([^\"\']*)[\"\']/";
	public $pattern_src="/\s+[sS][rR][cC]\s*=\s*[\"\']([^\"\']*)[\"\']/";
	//1 or more space
	//case insensitive href
	//1 or more space
	//=
	//1 or more space
	//single or double quote
	//any string without signl or double qute
	//single or double quote.


	public $bChangeFile = false;
	public $bVerifyUrl = false;

	public function Check_Link_Pattern($dirname, $pattern, $subject)
	{
		//echo "$pattern <br>";
		preg_match_all($pattern, $subject, $matches);

		$correctionArr = Array();

		foreach($matches[1] as $i=>$url )
		{
			$fullfound = $matches[0][$i];
			$prot = substr($url,0, 1);
			if("#"===$prot) {
				continue;
			}
			$parsedurl = parse_url( $url );

			//print_r( $parsedurl );

			$Err=" Err: ";
			$existingrelativefiledound="";
			if( !isset($parsedurl['scheme']) ){// href="../../"
				//echo "$url (before)<br/>";
				$parsedpath = $parsedurl['path'];
				$url2 = SearchUti::GetFullPathFrRelative($dirname, $parsedpath, $pExistingRelativePathFile, $ExistFullPahtFile);
				$color="red";

				if( file_exists($url2) ) {
					$color="green";
					$Err="";
				}
				else{
					if( strlen($pExistingRelativePathFile) >0 ){
						$correctedfound = str_replace($parsedpath, $pExistingRelativePathFile, $fullfound);
						$correctionArr[$fullfound]=$correctedfound;
						$existingrelativefiledound .="<br>==>$correctedfound";
					}
					if( strlen($ExistFullPahtFile) >0 ){
						$existingrelativefiledound .="<br>---->$ExistFullPahtFile";
					}
				}
				echo "$Err<a class='relativePath2absPath' title='$url2'><font color='$color'>$fullfound</font> </a> $existingrelativefiledound<br/>";
				continue;
			}
			else{
				$color="#ff0000";
				$ret=SearchUti::Is_My_Url_Valid($url);
				if( "true" == $this->bVerifyUrl){
					//$ret= SearchUti::URLIsValid($url) ;
					//$ret = SearchUti::getHttpResponseCode_using_curl($url);
					echo "========================";
				}
				else{
					echo "====+++===+++===+++===";
				}

				if( true === $ret ) {
					$color="green";
					$Err="";
				}
				else if(-1===$ret){
					$color="#0000ff";
					$Err="";
				}
				$src2href = str_replace("src=", "href=", $fullfound);
				echo "$Err<a $src2href><font color='$color'>$fullfound</font></a><br/>";
			}
		}
		return $correctionArr;
	}
	public function Check($filename, $fullPathUniqueFilesDict){
		$fullpathfile2url = SearchUti::FullPathFile2MyUrl($filename);
		echo "<hr/><a class='fullpathfile2url' title='$fullpathfile2url'>[~]</a> <a class='editfilename' title='editfilename'>$filename</a><br>";


		$subject=file_get_contents($filename);

		$DIRNAME = pathinfo($filename, PATHINFO_DIRNAME );
		//echo ("$DIRNAME - - - dir name<br>");
		$pattern = $this->pattern_href;
		$retArr1 = $this->Check_Link_Pattern($DIRNAME, $pattern, $subject);

		$pattern = $this->pattern_src;
		$retArr2 = $this->Check_Link_Pattern($DIRNAME, $pattern, $subject);

		foreach($retArr1 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}
		foreach($retArr2 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}

		$count_replacement=count($retArr1) + count($retArr2);
		//echo "+++++++++ck bChangeFile=$this->bChangeFile++++++++++++++++";
			
		if( $count_replacement > 0 ){
			$ret = false;//
			if( "true"  === $this->bChangeFile ) {
				//$ret = file_put_contents($filename, $subject);
				echo "-----------true------------";
			}
			else{
				echo "[need change]";
			}
			echo "- - - > saved: $ret ";
			if(false===$ret){
				echo "<font color='red'>Failed to save file!</font><br>";
			}
		}
		return;
	}
	public function Check___($filename, $fullPathUniqueFilesDict){
		$fullpathfile2url = SearchUti::FullPathFile2MyUrl($filename);
		echo "<hr/><a class='fullpathfile2url' title='$fullpathfile2url'>[~]</a> <a class='editfilename' title='editfilename'>$filename</a><br>";


		$subject=file_get_contents($filename);

		$DIRNAME = pathinfo($filename, PATHINFO_DIRNAME );
		//echo ("$DIRNAME - - - dir name<br>");
		$pattern = $this->pattern_href;
		$retArr1 = $this->Check_Link_Pattern($DIRNAME, $pattern, $subject);

		$pattern = $this->pattern_src;
		$retArr2 = $this->Check_Link_Pattern($DIRNAME, $pattern, $subject);

		foreach($retArr1 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}
		foreach($retArr2 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}

		$count_replacement=count($retArr1) + count($retArr2);
		//echo "+++++++++ck bChangeFile=$this->bChangeFile++++++++++++++++";
			
		if( $count_replacement > 0 ){
			$ret = false;//
			if( "true"  === $this->bChangeFile ) {
				//$ret = file_put_contents($filename, $subject);
				echo "-----------true------------";
			}
			else{
				echo "[need change]";
			}
			echo "- - - > saved: $ret ";
			if(false===$ret){
				echo "<font color='red'>Failed to save file!</font><br>";
			}
		}
		return;
	}
	public function Check_test(){

		echo "$this->pattern <br>";

		$subject =" href='./a.php'";
		$html = '<a Href="http://www.mydomain.com/page.html">URL1</a><br>';
		$html.= '<a href="http://www.mydomain222222222.com/page.html">URL2</a><br>';;
		$html.= "<a href='http://www.google.com'>URL3</a><br>";
		//$html = "<a href='http://www.mydomain.com/page.html'>URL</a>";
		$subject=$html;

		echo "$subject <br>";
		$this->Check_Link_Pattern($this->pattern, $subject);
		return;


		preg_match_all($this->pattern, $subject, $matches);



		echo "<br>";
		print_r($matches);

		echo "<hr>";

		echo ($matches[0][0]);
		echo "<br>";
		echo ($matches[0][1]);
		echo "<br>";
		echo ($matches[0][2]);

		echo "<hr>";
		echo ($matches[1][0]);
		echo "<br>";
		echo ($matches[1][1]);
		echo "<br>";
		echo ($matches[1][2]);

		echo "<hr>";
		echo count($matches[1]);

		echo "<hr>";





		foreach($matches[1] as $url)
		{
			if(true === $this->URLIsValid($url) ){
				echo "<br/>$url (ok)<hr>";
			}
			else{
				echo "<br/>$url (not exist)<hr>";
			}
		}

	}
}


class SingleHtmFile_href_src{
	public $hostfilename;
	public $content;
	public $include_paths;

	public $url_files=array();

	public function init($hostfilename,$includepaths){
		echo "<hr/><font color='grey'>$hostfilename</font><br/>";
		$this->hostfilename=$hostfilename;
		$this->content=file_get_contents($hostfilename);
		$this->include_paths=$includepaths;

		//$filedirname = pathinfo($hostfilename, PATHINFO_DIRNAME );
		//echo ("$DIRNAME - - - dir name<br>");

		$pattern="/\s+[hH][rR][eE][fF]\s*=\s*[\"\']([^\"\']*)[\"\']/";
		preg_match_all($pattern, $this->content, $matches);
		$this->parse_links($matches);

		$pattern="/\s+[sS][rR][cC]\s*=\s*[\"\']([^\"\']*)[\"\']/";
		preg_match_all($pattern, $this->content, $matches);
		$this->parse_links($matches);
	}
	public function parse_links($matches){
		foreach($matches[1] as $i=>$url )
		{
			$fullfound = $matches[0][$i];
			$prot = substr($url,0, 1);
			if("#"===$prot) {
				continue;
			}
			$parsedurl = parse_url( $url );

			//print_r( $parsedurl );

			$Err=" Err: ";
			$existingrelativefiledound="";
			if( !isset($parsedurl['scheme']) ){// href="../../"
				//echo "$url (before)<br/>";
				$parsedpath = $parsedurl['path'];
				$basename = basename($parsedpath);
				if(!isset($this->url_files[$basename])){
					$this->url_files[$basename]=array();
					$this->url_files[$basename][0]=$fullfound;
					$this->url_files[$basename][1]=$url;
					echo "$fullfound<br/>";
					$existfile = $this->Get_exists_in_include_paths($basename);
					if(""===$existfile){
					}
					else{
						$fullfound2=str_replace_first($url, $existfile, $fullfound);
						$this->url_files[$basename][2]=$fullfound2;
						$this->url_files[$basename][3]=$existfile;
					}
				}
				if ( isset ($this->url_files[$basename][2]) ){
					$this->content = str_replace_first($this->url_files[$basename][2], $fullfound, $this->content);					
				}
			}
			else{
				$color="#ff0000";
				$ret=SearchUti::Is_My_Url_Valid($url);
				if( "true" == $this->bVerifyUrl){
					//$ret= SearchUti::URLIsValid($url) ;
					//$ret = SearchUti::getHttpResponseCode_using_curl($url);
					echo "========================";
				}
				else{
					echo "====+++===+++===+++===";
				}

				if( true === $ret ) {
					$color="green";
					$Err="";
				}
				else if(-1===$ret){
					$color="#0000ff";
					$Err="";
				}
				$src2href = str_replace("src=", "href=", $fullfound);
				echo "$Err<a $src2href><font color='$color'>$fullfound</font></a><br/>";
			}
		}
	}
	public function Get_exists_in_include_paths($basename){
		$retArr=array();
		SearchUti::file_exists_in_include_paths($basename,$this->include_paths, $retArr);
		if(1===count($retArr)){	
			$relative = SearchUti::get_relative_path_file($this->hostfilename, $retArr[0]);
			echo "$relative<br/>";
			return $relative;			
		}
		else{
			foreach($retArr as $i=>$file){
				echo "<font color='yellow'> $i => $file </font><br/>";
			}
		}
		return "";
	}
}


class SearchHtm_src_href extends FileFitler
{
	public $bVerifyUrl=false;
	public $bChangeFile=false;
	public $hrs_ext=".htm;.html";
	public $hrs_ext_arr="";
	public $hrs_file="";
	public $tot_files=0;
	
	public $m_SingleHtmFile_href_src;

	public $includepaths;

	public function __construct($file_filters,$checkbox_change_file,$checkbox_verify_url){
		parent::__construct($file_filters);
		$this->bChangeFile = $checkbox_change_file;
		$this->bVerifyUrl  = $checkbox_verify_url;

		$this->hrs_ext = str_replace(".","", $this->hrs_ext);
		//echo "===". $this->hrs_ext;
		$this->hrs_ext_arr = explode(";", $this->hrs_ext);
		
		$this->m_SingleHtmFile_href_src = new  SingleHtmFile_href_src();
		//print_r($this->hrs_ext_arr);
	}
	public $count_replacement=0;
	protected function show($indx, $file){//overide
		if( is_dir($file) ) return;
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		//echo $ext."<br>";
		if( !in_array($ext, $this->hrs_ext_arr) ){
			return;
		}
		if( strlen($this->hrs_file)>0 && strpos($file,$this->hrs_file) === false ){
			return;
		}

		$this->LinkCheck($file);
		$this->tot_files+=1;
	}
	protected function LinkCheck($hostfilename){
		$this->m_SingleHtmFile_href_src->init($hostfilename, $this->includepaths);
		return;
		
		
		$fullpathfile2url = SearchUti::FullPathFile2MyUrl($filename);
		echo "<hr/><a class='fullpathfile2url' title='$fullpathfile2url'>[~]</a> <a class='editfilename' title='editfilename'>$filename</a><br>";


		$subject=file_get_contents($filename);

		$filedirname = pathinfo($filename, PATHINFO_DIRNAME );
		//echo ("$DIRNAME - - - dir name<br>");

		$pattern="/\s+[hH][rR][eE][fF]\s*=\s*[\"\']([^\"\']*)[\"\']/";
			
		$retArr1 = $this->Check_Link_Pattern($filedirname, $pattern, $subject);

		$pattern="/\s+[sS][rR][cC]\s*=\s*[\"\']([^\"\']*)[\"\']/";
		$retArr2 = $this->Check_Link_Pattern($filedirname, $pattern, $subject);

		foreach($retArr1 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}
		foreach($retArr2 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}

		$count_replacement=count($retArr1) + count($retArr2);
		//echo "+++++++++ck bChangeFile=$this->bChangeFile++++++++++++++++";
			
		if( $count_replacement > 0 ){
			$ret = false;//
			if( "true"  === $this->bChangeFile ) {
				$ret = file_put_contents($filename, $subject);
				if(false===$ret){
					echo "<font color='red'>$filename Failed to save file!</font><br>";
				}
				else{
					echo "<font color='green'>$count_replacement changed in $filename!</font><br>";
				}
			}
			else{
				echo "$count_replacement changed needed. But save is not checked.<br>";
			}
		}
		return;
	}
	public function Check_Link_Pattern($dirname, $pattern, $subject)
	{
		//echo "$pattern <br>";
		preg_match_all($pattern, $subject, $matches);

		$correctionArr = Array();

		foreach($matches[1] as $i=>$url )
		{
			$fullfound = $matches[0][$i];
			$prot = substr($url,0, 1);
			if("#"===$prot) {
				continue;
			}
			$parsedurl = parse_url( $url );

			//print_r( $parsedurl );

			$Err=" Err: ";
			$existingrelativefiledound="";
			if( !isset($parsedurl['scheme']) ){// href="../../"
				//echo "$url (before)<br/>";
				$parsedpath = $parsedurl['path'];
				$ret="";
				$url2 = $this->GetNewRelativePath($dirname, $parsedpath, $pExistingRelativePathFile, $ExistFullPahtFile, $ret);
				if( "" === $url2 ){
					echo "Err: <a class='' title=''><font color='red'>$fullfound</font> </a> <== Not Exist At All.<br/>";
					continue;
				}
				$color="blue";

				if( $url2 === $parsedpath ) {
					$color="green";
					$Err="";
				}
				else{
					//echo $url2."<br/>";
					//echo $fullfound."<br/>";
					if( strlen($pExistingRelativePathFile) >0 ){
						$correctedfound = str_replace($parsedpath, $pExistingRelativePathFile, $fullfound);
						$correctionArr[$fullfound]=$correctedfound;
						$existingrelativefiledound .="<br>==>$correctedfound";
					}
					if( strlen($ExistFullPahtFile) >0 ){
						$existingrelativefiledound .="<br>---->$ExistFullPahtFile";
					}
				}
				echo "$Err<a class='relativePath2absPath' title='$url2'><font color='$color'>$fullfound</font> </a> $existingrelativefiledound<br/>";
				continue;
			}
			else{
				$color="#ff0000";
				$ret=SearchUti::Is_My_Url_Valid($url);
				if( "true" == $this->bVerifyUrl){
					//$ret= SearchUti::URLIsValid($url) ;
					//$ret = SearchUti::getHttpResponseCode_using_curl($url);
					echo "========================";
				}
				else{
					echo "====+++===+++===+++===";
				}

				if( true === $ret ) {
					$color="green";
					$Err="";
				}
				else if(-1===$ret){
					$color="#0000ff";
					$Err="";
				}
				$src2href = str_replace("src=", "href=", $fullfound);
				echo "$Err<a $src2href><font color='$color'>$fullfound</font></a><br/>";
			}
		}
		return $correctionArr;
	}

	public function GetNewRelativePath($DocDir, $parsedpath, & $pExistingRelativePathFile,  & $pExistingFullpathFile , &$Results){
		//echo "$parsedpath<br>";
		$pExistingRelativePathFile = "";
		$upNodNum=0;
		$parsedpath_base = basename($parsedpath);
		//echo "-----$parsedpath_base<br>";
		if( !isset ($this->files[$parsedpath_base]) ){
			$Results = "err  <font color='red'>$parsedpath_base</font> $DocDir, $parsedpath,<=== not exist at all: $parsedpath<br/>";
			return "";
		}

		$fullpathfilenameOflink = $this->files[$parsedpath_base];
		//echo "<font color='green'>$baseDir*** $relativeFilename +++ $parsedpath_base === $fullpathfilenameOflink ***</font><br>";

		$arrDocPaths  = explode("/", $DocDir);
		$arrLinkPaths = explode("/", $fullpathfilenameOflink);

		//echo "------------$fullpathfilenameOflink";
		//print_r($arrLinkPaths);

		$i=-1;
		$relativeLeft  = "";
		$relativeRight = "";
		while(1){
			$i += 1;
			if( isset($arrDocPaths [$i]) && isset($arrLinkPaths [$i]) ){
				//echo $arrDocPaths [$i] . " ==>  " .$arrLinkPaths [$i] ."<br>";
				if(  $arrDocPaths [$i] === $arrLinkPaths [$i]){
					continue;
				}
				else{
					$relativeLeft .= "../";
					$relativeRight .= $arrLinkPaths [$i] . "/";
				}
				continue;
			}
			if( isset($arrDocPaths [$i]) ){
				$relativeLeft .= "../";
				continue;
			}
			if( isset($arrLinkPaths [$i]) ){
				$relativeRight .= $arrLinkPaths [$i] . "/";
				continue;
			}
			break;
		}
		if(strlen($relativeLeft)===0 )$relativeLeft="./";
		$relativeRight = trim( $relativeRight, "/" );
		$pExistingRelativePathFile = $relativeLeft . $relativeRight;
		$pExistingFullpathFile     = $fullpathfilenameOflink;
		return $pExistingRelativePathFile;
	}
}



class SearchHtm_src_hrefxxxxxxxxx extends FileFitler
{
	public $bVerifyUrl=false;
	public $bChangeFile=false;
	public $hrs_ext=".htm;.html";
	public $hrs_ext_arr="";
	public $hrs_file="";
	public $tot_files=0;
	public function __construct($file_filters,$checkbox_change_file,$checkbox_verify_url){
		parent::__construct($file_filters);
		$this->bChangeFile = $checkbox_change_file;
		$this->bVerifyUrl  = $checkbox_verify_url;

		$this->hrs_ext = str_replace(".","", $this->hrs_ext);
		//echo "===". $this->hrs_ext;
		$this->hrs_ext_arr = explode(";", $this->hrs_ext);
		//print_r($this->hrs_ext_arr);
	}
	public $count_replacement=0;
	protected function show($indx, $file){//overide
		if( is_dir($file) ) return;
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		//echo $ext."<br>";
		if( !in_array($ext, $this->hrs_ext_arr) ){
			return;
		}
		if( strlen($this->hrs_file)>0 && strpos($file,$this->hrs_file) === false ){
			return;
		}

		$this->LinkCheck($file);
		$this->tot_files+=1;
	}
	protected function LinkCheck($filename){
		$fullpathfile2url = SearchUti::FullPathFile2MyUrl($filename);
		echo "<hr/><a class='fullpathfile2url' title='$fullpathfile2url'>[~]</a> <a class='editfilename' title='editfilename'>$filename</a><br>";


		$subject=file_get_contents($filename);

		$filedirname = pathinfo($filename, PATHINFO_DIRNAME );
		//echo ("$DIRNAME - - - dir name<br>");

		$pattern="/\s+[hH][rR][eE][fF]\s*=\s*[\"\']([^\"\']*)[\"\']/";
			
		$retArr1 = $this->Check_Link_Pattern($filedirname, $pattern, $subject);

		$pattern="/\s+[sS][rR][cC]\s*=\s*[\"\']([^\"\']*)[\"\']/";
		$retArr2 = $this->Check_Link_Pattern($filedirname, $pattern, $subject);

		foreach($retArr1 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}
		foreach($retArr2 as $search=>$replace){
			$subject = str_replace($search, $replace, $subject);
		}

		$count_replacement=count($retArr1) + count($retArr2);
		//echo "+++++++++ck bChangeFile=$this->bChangeFile++++++++++++++++";
			
		if( $count_replacement > 0 ){
			$ret = false;//
			if( "true"  === $this->bChangeFile ) {
				$ret = file_put_contents($filename, $subject);
				if(false===$ret){
					echo "<font color='red'>$filename Failed to save file!</font><br>";
				}
				else{
					echo "<font color='green'>$count_replacement changed in $filename!</font><br>";
				}
			}
			else{
				echo "$count_replacement changed needed. But save is not checked.<br>";
			}
		}
		return;
	}
	public function Check_Link_Pattern($dirname, $pattern, $subject)
	{
		//echo "$pattern <br>";
		preg_match_all($pattern, $subject, $matches);

		$correctionArr = Array();

		foreach($matches[1] as $i=>$url )
		{
			$fullfound = $matches[0][$i];
			$prot = substr($url,0, 1);
			if("#"===$prot) {
				continue;
			}
			$parsedurl = parse_url( $url );

			//print_r( $parsedurl );

			$Err=" Err: ";
			$existingrelativefiledound="";
			if( !isset($parsedurl['scheme']) ){// href="../../"
				//echo "$url (before)<br/>";
				$parsedpath = $parsedurl['path'];
				$ret="";
				$url2 = $this->GetNewRelativePath($dirname, $parsedpath, $pExistingRelativePathFile, $ExistFullPahtFile, $ret);
				if( "" === $url2 ){
					echo "Err: <a class='' title=''><font color='red'>$fullfound</font> </a> <== Not Exist At All.<br/>";
					continue;
				}
				$color="blue";

				if( $url2 === $parsedpath ) {
					$color="green";
					$Err="";
				}
				else{
					//echo $url2."<br/>";
					//echo $fullfound."<br/>";
					if( strlen($pExistingRelativePathFile) >0 ){
						$correctedfound = str_replace($parsedpath, $pExistingRelativePathFile, $fullfound);
						$correctionArr[$fullfound]=$correctedfound;
						$existingrelativefiledound .="<br>==>$correctedfound";
					}
					if( strlen($ExistFullPahtFile) >0 ){
						$existingrelativefiledound .="<br>---->$ExistFullPahtFile";
					}
				}
				echo "$Err<a class='relativePath2absPath' title='$url2'><font color='$color'>$fullfound</font> </a> $existingrelativefiledound<br/>";
				continue;
			}
			else{
				$color="#ff0000";
				$ret=SearchUti::Is_My_Url_Valid($url);
				if( "true" == $this->bVerifyUrl){
					//$ret= SearchUti::URLIsValid($url) ;
					//$ret = SearchUti::getHttpResponseCode_using_curl($url);
					echo "========================";
				}
				else{
					echo "====+++===+++===+++===";
				}

				if( true === $ret ) {
					$color="green";
					$Err="";
				}
				else if(-1===$ret){
					$color="#0000ff";
					$Err="";
				}
				$src2href = str_replace("src=", "href=", $fullfound);
				echo "$Err<a $src2href><font color='$color'>$fullfound</font></a><br/>";
			}
		}
		return $correctionArr;
	}

	public function GetNewRelativePath($DocDir, $parsedpath, & $pExistingRelativePathFile,  & $pExistingFullpathFile , &$Results){
		//echo "$parsedpath<br>";
		$pExistingRelativePathFile = "";
		$upNodNum=0;
		$parsedpath_base = basename($parsedpath);
		//echo "-----$parsedpath_base<br>";
		if( !isset ($this->files[$parsedpath_base]) ){
			$Results = "err  <font color='red'>$parsedpath_base</font> $DocDir, $parsedpath,<=== not exist at all: $parsedpath<br/>";
			return "";
		}

		$fullpathfilenameOflink = $this->files[$parsedpath_base];
		//echo "<font color='green'>$baseDir*** $relativeFilename +++ $parsedpath_base === $fullpathfilenameOflink ***</font><br>";

		$arrDocPaths  = explode("/", $DocDir);
		$arrLinkPaths = explode("/", $fullpathfilenameOflink);

		//echo "------------$fullpathfilenameOflink";
		//print_r($arrLinkPaths);

		$i=-1;
		$relativeLeft  = "";
		$relativeRight = "";
		while(1){
			$i += 1;
			if( isset($arrDocPaths [$i]) && isset($arrLinkPaths [$i]) ){
				//echo $arrDocPaths [$i] . " ==>  " .$arrLinkPaths [$i] ."<br>";
				if(  $arrDocPaths [$i] === $arrLinkPaths [$i]){
					continue;
				}
				else{
					$relativeLeft .= "../";
					$relativeRight .= $arrLinkPaths [$i] . "/";
				}
				continue;
			}
			if( isset($arrDocPaths [$i]) ){
				$relativeLeft .= "../";
				continue;
			}
			if( isset($arrLinkPaths [$i]) ){
				$relativeRight .= $arrLinkPaths [$i] . "/";
				continue;
			}
			break;
		}
		if(strlen($relativeLeft)===0 )$relativeLeft="./";
		$relativeRight = trim( $relativeRight, "/" );
		$pExistingRelativePathFile = $relativeLeft . $relativeRight;
		$pExistingFullpathFile     = $fullpathfilenameOflink;
		return $pExistingRelativePathFile;
	}
}


?>

