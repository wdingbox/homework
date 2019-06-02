<?php
@session_start();





class Search_FullPathFiles{
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





class Uti{
	static function VirtualFunct($dir, $funcName, $params){
		$filename=$dir. "_override_$funcName.js.php";
		if( 1===@include($filename) ){
		}
		else{
			echo "$funcName($params);";
		}
	}


	static function include_if_found($filename){
		$pathfile = self::FindExists($filename);
		if(strlen($pathfile)>0){
			@include($pathfile);//no warning if not exist.
		}
	}
	static function FindExists($file){
		$pathfile = $file;
		for( $i=0; $i<32; $i += 1 ){
			if( file_exists($pathfile) ) {
				return $pathfile;
			}
			$pathfile = "../$pathfile";
		}
		return "";
	}
	static function FindRequiredFile($file){
		$pathfile = $file;
		for( $i=0; $i<32; $i += 1 ){
			if( file_exists($pathfile) ) {
				return $pathfile;
			}
			$pathfile = "../$pathfile";
		}
		die( "$file : <font color='red'>could not be up found</font>" );
	}



	static function require_once_found($filename){
		$pathfile = self::GetFindRequiredFile($filename);
		if(strlen($pathfile)>0){
			require_once($pathfile);
		}
		else{
			die("$filename: could not be found but is required.");
		}
	}

	static function GetFileType($filename){

		return "";
	}

	static function GetAllLinesWithKeyString2($filename, $keyStr, &$count){
		$linesArry=Array();
		if( !file_exists($filename)) return $linesArry;
		$lines = file($filename);
		$replace = "<font color='red'>$keyStr</font>";
		$totFound=0;
		foreach ($lines as $idx => $line)
		{
			$pos = strpos($line,$keyStr);
			//echo "-$pos-" . $line . "<br/>";
			if( $pos === false ){
				continue;
			}
			//echo "+++ line=" . htmlspecialchars($line) . ", pos=$pos<br/>";
			//$fileLine = $idx . $filename ;
			//$line = str_replace($keyStr, $replace, $line);
			$linesArry[$idx] = $line;
		}
		return $linesArry;
	}
	static function GetAllFilesInDir($dirname){
		$filesArry=Array();
		if( !file_exists($dirname)) return $filesArry;
		$path = realpath($dirname);

		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
		{
			if( is_file($filename) ){
				$filesArry[] = $filename;
			}
		}
		natsort( $filesArry );
		return $filesArry;
	}
	static function GetAllFilesAndDirsInDir($dirname){
		$filesArry=Array();
		if( !file_exists($dirname)) return $filesArry;
		$path = realpath($dirname);

		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
		{
			$filesArry[] = $filename;
		}
		natsort( $filesArry );
		return $filesArry;
	}
	static function GetAllFilesInDir_ByFilters($dir, $filesFilter){
		$uti = new Search_FullPathFiles($dir);
		$files=$uti->GetAllFilesInDirs_ByFilters($filesFilter);		
		return $files;
	}
	static function GetAllFilesInDir_ByFilters____old($dirname, $file_filters){
		$file_filters=trim($file_filters," ;");
		$filtersArr = explode(";", $file_filters);
		if(strlen($file_filters)===0 || count($filtersArr)===0) {
			return self::GetAllFilesAndDirsInDir($dirname);
		}
		$filesArry=Array();
		if( !file_exists($dirname)) return $filesArry;
		$path = realpath($dirname);

		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
		{
			if( is_file($filename) ){
				foreach($filtersArr as $i=>$filter){
					$pos = strpos($filename, $filter);
					if($pos === false ) continue;
					$filesArry[] = $filename;
				}
			}
		}
		natsort( $filesArry );//natural sort
		return $filesArry;
	}

	static function EchoRequireFileV($file){
		echo self::RequireFileV($file);
	}
	static function EchoRequireFileVNoMobile($file){
		$agent=$_SERVER["HTTP_USER_AGENT"];
		if( isset($agent) && strpos($agent, "") >= 0 ){

		}
		echo self::RequireFileV($file);
	}
	static function RequireFileV($file){
		$pathfile = $file;
		for( $i=0; $i<32; $i += 1 ){
			if( file_exists($pathfile) ) {
				return "\"" . $pathfile. "?t=". microtime(1). "\"";
			}
			$pathfile = "../$pathfile";
		}
		die( "$file : <font color='red'>could not be found<font>" );
	}











	static public function VertTbl($retXml){
		$xml = simplexml_load_string($retXml);
		$idxTbl=-1;
		for($idxTbl=0;$i<count($xml->table); $idxTbl+=1){
			$str =  (string) $xml->table[$idxTbl]['datatype'];
			if ( "list" === $str ) {
				break;
			}
		}
		if($idxTbl<0) return "";

		$csz = (string) $xml->table[$idxTbl]['colsize'];

		$colsize = Uti::GetValOf($retXml,"colsize");

		$result = $xml->table[$idxTbl]->xpath("./tr/th");

		$vertbl="<table class='CmdRespTable' >";
		$res="";
		$trs="";
		while(list( , $th) = each($result)) {
			//echo '<br>: ',$node,"\n";
			$col = (string) $th['col'];
			$td = $xml->table[$idxTbl]->xpath("./tr/td[@col='$col']");
			$i=intval($col);
			$td = $xml->table[$idxTbl]->tr[1]->td[$i];
			$tdid = $td['id'];
			$td = (string)$td;
			$dat = htmlspecialchars((string)$td);
			$vitemName=(string)$th;
			if($vitemName==="result"){
				$res = "<tr ><th align='left'>".  $vitemName . "</th><td class='result'>". (string)$dat . "</td></tr>";
				continue;
			}
			$trs .= "<tr ><th align='left'>".  $vitemName . "</th><td>". (string)$dat . "</td></tr>";
		}
		if( count($trs)===0 ) {
			$trs=$res;
		}
		$vertbl.=$trs."</table>";
		return $vertbl;
	}



	public static function GetValOf($xmlstr, $key, $offset=0){
		if($offset>=strlen($xmlstr) ){
			return "";
		}
		$xmlstr = str_replace("\\'", "'", $xmlstr);
		$xmlstr = str_replace("\\\"", "\"", $xmlstr);

		$xml = new SimpleXMLElement($xmlstr);
		$result = $xml->xpath("//*[@id='".$key."']");

		$sval="";
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			$sval .= (string)$node;
		}
		$sval = trim($sval);
		return trim($sval);
	}

	public static function XmlAttrValChange($xmlstr, $attrName, $attrValOld, $attrValNew){
		$sxe = new SimpleXMLElement( $xmlstr );
		$result = $sxe->xpath("//*[@" . $attrName . "='" . $attrValOld . "']"); //get all nod with attr is valold.
		while( list(,$node) = each($result) ) {
			$node[$attrName]=$attrValNew;
		}
		$xstr = $sxe->asXML();
		return $xstr;
	}

	public static function FillinFileTable($filename, $xmlstr){
		$xmlstrTable = file_get_contents($filename);
		$xml = Uti::FillinXmlStrTable($xmlstrTable,$xmlstr );
		return (string)$xml->asXML();
	}
	public static function FillinXmlStrTable($xmlstrTable, $xmlstrData){
		$xml = simplexml_load_string($xmlstrTable);
		$result = $xml->xpath("*");
		while(list( , $node) = each($result)) {
			//echo $node->asXML() . "\n";
			foreach($node->td[1] as $child){
				$tag = $child->getName();
				$id = (string)$child[0]['id'];
				$id = (string)trim($id);
				$getVal = Uti::GetValOf($xmlstrData, $id);
				if($tag==="a"){
					$child->addAttribute("value",$getVal);
					$child->a[0]=$getVal;
				}
				if($tag==="input"){
					$child->addAttribute("value",$getVal);
				}
				else if($tag==="select"){
					foreach( $child->children() as $optn){
						$optval = (string)$optn[0]['value'];
						if($getVal === $optval){
							$optn->addAttribute("selected","true");
						}
					}
				}
			}
		}
		return $xml;
	}

	//$samp="<div class='response' id='AAA.Service.CreateSession'><ul><li id='result'>success</li><li id='sid'>ea0ba63f-ff27-46f5-8469-632dad6913ee</li></ul></div><Br/><bR/>  <div class='request' id='AAA.Service.CreateSession'><ul><li id='username'>admin</li><li id='password'>admin</li></ul></div>";
	public static function GetValOf_old($xml, $key, $offset=0){
		if($offset>=strlen($xml) ){
			return "";
		}
		syslog(LOG_DEBUG, basename(__FILE__)."@".__LINE__.":GetValOf...");
		$xml = str_replace("\\'", "'", $xml);
		$xml = str_replace("\\\"", "\"", $xml);
		$mykey  = "='" . $key . "'>";
		$delta = strlen($mykey);
		$pos1 = strpos($xml, $mykey, $offset);
		if( FALSE  === $pos1 ) {
			syslog(LOG_DEBUG, "failed to find key:". $mykey .",".$xml);
			return  "";
		}
		syslog(LOG_DEBUG, "???????". $mykey .",".$xml);
		syslog(LOG_DEBUG, basename(__FILE__)."@".__LINE__.":pos1=".(string)$pos1);
		$pos2 = strpos($xml, "</", $pos1+$delta);
		syslog(LOG_DEBUG, basename(__FILE__)."@".__LINE__.":pos2=".(string)$pos2);
		$len = $pos2-($pos1+ $delta  );
		syslog(LOG_DEBUG, basename(__FILE__)."@".__LINE__.":len=".(string)$len . ",delta=".$delta);
		//string substr ( string $string , int $start [, int $length ] )
		$sval = substr($xml, $pos1+$delta, $len);
		syslog(LOG_DEBUG, "???????". "sval=".$sval);
		//system("echo  'cli:: $key=$sval' >> /diag/all.log");
		system("echo  'cli:: $key=$sval' >> /tmp/all.log");
		$_SESSION["GetValOf_posEnd"]=$pos2;
		return $sval;
	}

	public static function GetValArry($xmlstr,$key){

		$xmlstr = str_replace("\\'", "'", $xmlstr);
		$xmlstr = str_replace("\\\"", "\"", $xmlstr);

		$xml = new SimpleXMLElement($xmlstr);
		$result = $xml->xpath("//*[@id='".$key."']");

		$arr=Array();
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			array_push ($arr, $node);
		}
		return $arr;
	}
	public static function GetValArryFrXml($xmlstr,$xpathStr){

		$xmlstr = str_replace("\\'", "'", $xmlstr);
		$xmlstr = str_replace("\\\"", "\"", $xmlstr);

		$xml = new SimpleXMLElement($xmlstr);
		$result = $xml->xpath($xpathStr);

		$arr=Array();
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			array_push ($arr, (string)$node);
		}
		return $arr;
	}
	public static function GetJsOptionsStringForSelect_FrXml($xmlstr,$xpathStr){

		$xmlstr = str_replace("\\'", "'", $xmlstr);
		$xmlstr = str_replace("\\\"", "\"", $xmlstr);

		$xml = new SimpleXMLElement($xmlstr);
		$result = $xml->xpath($xpathStr);

		$jsAr="[";
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			$val = (string)$node;
			$jsAr .= "'$val|$val',";
		}
		$jsAr .= "];\n";
		return $jsAr;
	}

	public static function GetValArry_old($xml,$key){
		$arr = Array();
		$pos=0;
		while( $pos <= strlen($xml) ){
			$val = Uti::GetValOf($xml,$key,$pos);
			if(strlen($val)==0) break;
			$pos=$_SESSION["GetValOf_posEnd"]+1;
			array_push ($arr, $val);
			//print "\n:".$pos;
		}
		return $arr;
	}
	public static function GetSid($xmlstr){
		return Uti::GetValOf($xmlstr, "sid");
	}


	public static function GetClientIp(){
		///find client ip
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$_SESSION[Defs::SSN_LOGIN_CLIENTIP]=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$_SESSION[Defs::SSN_LOGIN_CLIENTIP]=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$_SESSION[Defs::SSN_LOGIN_CLIENTIP]=$_SERVER['REMOTE_ADDR'];
		}
		return $_SESSION[Defs::SSN_LOGIN_CLIENTIP];
	}
	public static function GenUmgModel(){
		$ws = new W3s("UI.GetApplianceSettings");
		$ret3 = $ws->exe();
		$model = Uti::GetValOf($ret3, "model");
		$version = Uti::GetValOf($ret3, "version");
		switch($model){
			case "premium":
				$model="UMG 6000";
				break;
			case "deluxe":
				$model="UMG 4000";
				break;
			case "lite":
				$model="UMG 2000";
				break;
			case "mustang":
				break;
			default:
				$model="Unknown";
				break;
		}

		$_SESSION[Defs::UMG_MODEL]   	= $model;
		$_SESSION[Defs::UMG_VERSION]   	= $version;
	}



	public static function test(){
		$samp="<div class='response' id='AAA.Service.CreateSession'><ul><li id='result'>success</li><li id='sid'>ea0ba63f-ff27-46f5-8469-632dad6913ee</li></ul></div><Br/><bR/>  <div class='request' id='AAA.Service.CreateSession'><ul><li id='username'>admin</li><li id='password'>admin</li></ul></div>";

		echo ("\n sid:");
		echo Uti::GetSid($samp);
		echo ("\n sid:");
		echo Uti::GetValOf($samp, "sid");
		echo ("\n result:");
		echo Uti::GetValOf($samp, "result");
		echo ("\n");

		echo ("\n");


	}




	public static function Strip($value)
	{
		if(get_magic_quotes_gpc() != 0)
		{
			if(is_array($value))
			if ( self::array_is_associative($value) )
			{
				foreach( $value as $k=>$v)
				$tmp_val[$k] = stripslashes($v);
				$value = $tmp_val;
			}
			else
			for($j = 0; $j < sizeof($value); $j++)
			$value[$j] = stripslashes($value[$j]);
			else
			$value = stripslashes($value);
		}
		return $value;
	}
	public static function array_is_associative ($array)
	{
		if ( is_array($array) && ! empty($array) )
		{
			for ( $iterator = count($array) - 1; $iterator; $iterator-- )
			{
				if ( ! array_key_exists($iterator, $array) ) {
					return true;
				}
			}
			return ! array_key_exists(0, $array);
		}
		return false;
	}




}//////////////////class Uti{//////////////////////////////



//Uti::GetClientIp();







// for cli or online test.
if( isset( $_GET["tx"] ) || isset($argv[1]) ){  // test: php ./file.php argv1
	////////////////
	$html = "<b id='key'>bold text</b><a href=howdy.html id='key'>click me</a>";

	preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $html, $matches, PREG_SET_ORDER);

	print $html . "\n";
	foreach ($matches as $val) {
		echo "matched: " . $val[0] . "\n";
		echo "part 1: " . $val[1] . "\n";
		echo "part 2: " . $val[2] . "\n";
		echo "part 3: " . $val[3] . "\n";
		echo "part 4: " . $val[4] . "\n\n";
	}

	//$arr= Uti::GetValArry($html, "key");
	//print_r($arr);


}

class UtiGrid{

	// ret: returned xml frm wsss as table.
	// <table>
	//   <tr idx='k'><td id='key'>.</td><td>.</td></tr>
	//   <tr idx='k'><td id='key'>.</td><td>.</td></tr>
	// </table>
	//
	// output:
	// array:
	//  <row id='key'><cell>s1</cell><cell>x</cell></row>
	//  <row id='key'><cell>s2</cell><cell>y</cell></row>
	// sort array:
	//   [s1,s2...]
	public static function xml2GridCells($ret, $key, $arr_col, $sort_col){
		$xml = new SimpleXMLElement($ret);

		$result = $xml->xpath("//tr[@idx]");

		$arr1 = Array();
		$arr2 = Array();
		while(list( , $node) = each($result)) {

			$result2 = $node->xpath("td[@id='" . $key . "']");
			$primaryKey="";
			while(list( , $node2) = each($result2)) {
				//echo 'b/c: ',$node2,"\n";
				$primaryKey =  trim((string) $node2 );
			}
			$row = "<row id='". $primaryKey . "'>";

			foreach ($arr_col as $col){
				$result2 = $node->xpath("td[@id='" . $col . "']");
				$val="";
				while(list( , $node2) = each($result2)) {
					//echo 'b/c: ',$node2,"\n";
					$val =  trim((string) $node2 );
				}
				//$val2 = "<a id='$primaryKey' class='$col' onclick=\"occ('". $primaryKey."','$val');\">$val</a>";
				$val2 = "<a id='$primaryKey' class='$col' onclick=\"occ('$primaryKey','$val');\">$val</a>";
				$celldata = htmlspecialchars(  $val2  ) ;
				$row .= "<cell>". $celldata . "</cell>";
				if( $sort_col == $col ){
					$arr1[] = $val; //for sorting.
				}
			}
			$row .= "</row>";
			$arr2[] = $row;
		}

		$retArr=Array($arr1, $arr2);

		return $retArr;
	}

	//with conditional getting.
	public static function mbTbl2gridRows($mTblXml, $xpathStr, $key, $arr_col, $sort_col){
		$xml = new SimpleXMLElement($mTblXml);

		//sample: $result = $xml->xpath("//tr[@idx]");
		//sample: $result = $xml->xpath("//tr[contains(td[@id='if_type'], '0')]");
		$result = $xml->xpath($xpathStr);


		$arr1 = Array();
		$arr2 = Array();
		$rows="";
		while(list( , $node) = each($result)) {

			//generate a row with id is primary.
			$result2 = $node->xpath("td[@id='$key']");
			$primaryKey="";
			while(list( , $node2) = each($result2)) {
				//echo 'b/c: ',$node2,"\n";
				$primaryKey =  trim((string) $node2 );
			}
			$row = "<row id='$primaryKey'>";

			//generate cells of the row.
			if(count($arr_col)>0 ){
				foreach ($arr_col as $col){
					$result2 = $node->xpath("td[@id='$col']");
					$val="";
					while(list( , $node2) = each($result2)) {
						//echo 'b/c: ',$node2,"\n";
						$val =  trim((string) $node2 );
					}
					//$val2 = "<a id='$primaryKey' class='$col' onclick=\"occ('". $primaryKey."','$val');\">$val</a>";
					$val2 = "<a id='$primaryKey' class='$col' onclick=\"occ('$primaryKey','$val');\">$val</a>";
					$celldata = htmlspecialchars(  $val2  ) ;
					$row .= "<cell>". $celldata . "</cell>";
					if( $sort_col === $col ){
						$arr1[] = $val; //for sorting.
					}
				}
			}

			$row .= "</row>";
			$arr2[] = $row;
			$rows .= $row;
		}

		$retArr=Array($arr1, $arr2);

		$xml = new SimpleXMLElement($rows);

		return $retArr;
	}





	// ret: returned xml frm wsss.
	public static function printGridCells($arr2sort, $sort_direction){
		$arr1 = $arr2sort[0];
		$arr2 = $arr2sort[1];

		$sort=SORT_ASC;
		if("desc"==$sort_direction){
			$sort=SORT_DESC;
		}
		else if("asc"==$sort_direction){
			$sort=SORT_ASC;
		}

		array_multisort($arr1, $sort, $arr2, $sort);

		foreach($arr2 as $row ){
			echo $row;
		}
	}

	// ret: returned xml frm wsss.
	public static function getPageOfGridCells($arr2sort, $sort_direction, $rowsPerPage, $page){
		$arr1 = $arr2sort[0];
		$arr2 = $arr2sort[1];

		$sort=SORT_ASC;
		if("desc"==$sort_direction){
			$sort=SORT_DESC;
		}
		else if("asc"==$sort_direction){
			$sort=SORT_ASC;
		}

		array_multisort($arr1, $sort, $arr2, $sort);

		$idxStart=$rowsPerPage*($page-1);

		$ret="";
		for($i=$idxStart; $i<$idxStart+$rowsPerPage; $i+=1){
			$ret .= $arr2[$i];
		}
		return $ret;
	}




	//$ret with table datetype='matrix'.
	public static function appendCol ($ret, $selected_td_id, $newcolname, $defaultVal ){

		//$xml = new SimpleXMLElement($ret);
		$xml = simplexml_load_string($ret);

		$newtab="<table border='1' datatype='matrix'>";
		$result = $xml->xpath("//table[@datatype='matrix']/tr");
		while(list( , $tr) = each($result)) {
			$result2 = $tr->xpath("td[@id='$selected_td_id']");
			if(count($result2)==0){
				//$newtag = "th id='$newcolname'";
				$newNode = $tr->addChild( "th", $newcolname );
				$newNode->addAttribute("id", $newcolname);
				$xstr = $tr->asXML();
				//$xstr = str_replace("</".$newtag.">", "</th>", $xstr);
				$newtab .= $xstr;
				continue;
			}

			while(list( , $td) = each($result2)) {
				$tid = (string) $td;
				//$newtag = "td class='$newcolname' id='$tid'";
				$newNode = $tr->addChild("td", $defaultVal);
				$newNode->addAttribute("id", $tid);
				$newNode->addAttribute("class", $newcolname);
				$xstr = $tr->asXML();
				//$xstr = str_replace("</".$newtag.">", "</td>", $xstr);
				$newtab .= $xstr;
			}

		}
		$newtab .= "</table>";
		return $newtab;
	}
	//$ret with table datetype='matrix'.
	public static function appendCol_2 ($ret, $newcolname, $defaultVal ){

		//$xml = new SimpleXMLElement($ret);
		$xml = simplexml_load_string($ret);

		$newtab="<table border='1' datatype='matrix'>";
		$result = $xml->xpath("//table[@datatype='matrix']/tr");
		while(list( , $tr) = each($result)) {
			$result2 = $tr->xpath("td[@id='targetId']");
			if(count($result2)==0){
				//$newtag = "th id='$newcolname'";
				$newNode = $tr->addChild( "th", $newcolname );
				$newNode->addAttribute("id", $newcolname);
				$xstr = $tr->asXML();
				//$xstr = str_replace("</".$newtag.">", "</th>", $xstr);
				$newtab .= $xstr;
				continue;
			}

			while(list( , $td) = each($result2)) {
				$tid = (string) $td;
				//$newtag = "td class='$newcolname' id='$tid'";
				$newNode = $tr->addChild("td", $defaultVal);
				$newNode->addAttribute("id", $tid);
				$newNode->addAttribute("class", $newcolname);
				$xstr = $tr->asXML();
				//$xstr = str_replace("</".$newtag.">", "</td>", $xstr);
				$newtab .= $xstr;
			}

		}
		$newtab .= "</table>";
		return $newtab;
	}
	//$ret with table datetype='matrix'.
	public static function appendCol_old ($ret, $newcolname, $defaultVal ){

		//$xml = new SimpleXMLElement($ret);
		$xml = simplexml_load_string($ret);

		$newtab="<table border='1' datatype='matrix'>";
		$result = $xml->xpath("//table[@datatype='matrix']/tr");
		while(list( , $tr) = each($result)) {
			$result2 = $tr->xpath("td[@id='targetId']");
			if(count($result2)==0){
				$newtag = "th id='$newcolname'";
				$tr->addChild( $newtag, $newcolname );
				$xstr = $tr->asXML();
				$xstr = str_replace("</".$newtag.">", "</th>", $xstr);
				$newtab .= $xstr;
				continue;
			}

			while(list( , $td) = each($result2)) {
				$tid = (string) $td;
				$newtag = "td class='$newcolname' id='$tid'";
				$tr->addChild($newtag, $defaultVal);
				$xstr = $tr->asXML();
				$xstr = str_replace("</".$newtag.">", "</td>", $xstr);
				$newtab .= $xstr;
			}

		}
		$newtab .= "</table>";
		return $newtab;
	}


	//$pageIdx: 1 based index.
	public static function EchoGridXml($pageIdx, $rowsPerPage, $TotRows, $rowStr){

		$total_pages=0;

		if( $TotRows >0 ) {
			$total_pages = ceil($TotRows/$rowsPerPage);
		}

		if ($pageIdx > $total_pages) $pageIdx=$total_pages;

		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		}
		else {
			header("Content-type: text/xml;charset=utf-8");
		}

		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>".$pageIdx."</page>";
		echo "<total>".$total_pages."</total>";
		echo "<records>".$TotRows."</records>";
		echo "<userdata name='tamount'>".'0'."</userdata>";
		echo "<userdata name='ttax'>".'0'."</userdata>";
		echo "<userdata name='ttotal'>".'0'."</userdata>";
		// be sure to put text data in CDATA
		//while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		//echo "<row id='". "0"."'>";
		//echo "<cell>". "[id]"."</cell>";
		//echo "<cell>". "[invdate]"."</cell>";
		//echo "<cell><![CDATA[". "[name]"."]]></cell>";
		//echo "</row>";
		//}

		echo $rowStr;


		echo "</rows>";
	}
}


class umg_ls_files_{
	public $m_rows = Array();
	public $m_sort = Array();

	public function ls( $dir , $sidx ) {
		date_default_timezone_set('America/New_York');

		foreach ( scandir( $dir, $SCANDIR_SORT_DESCENDING) as $i => $entry ) {
			$pathfile = $dir . $entry;
			if ( $entry == "."  || $entry == "..") {
				continue;
			}
			if ( is_dir($entry) ){
				$this->ls( $pathfile. "/" );
			}
			else{
				$this->gen_a_row($pathfile, $sidx);
			}
		}
	}
	private function gen_a_row($pathfile, $sidx){
		$srow="<row>";
			
		$ext = pathinfo($pathfile, PATHINFO_EXTENSION);
		$txt = $pathfile;
		if( 'p' == $ext[0] || 'h' == $ext[0]  ){
			$txt = "<a href='$pathfile'>$pathfile</a>";
		}
		$txt = htmlspecialchars($txt);
			
		$fsize = sprintf("%d", filesize($pathfile) );
			
		$mtime = " ". date ("Y-m-d H:i:s  ", filemtime($pathfile));
			
		$srow .= "<cell>$mtime</cell> <cell>$fsize</cell><cell>$txt</cell><cell></cell><cell></cell><cell></cell><cell></cell>";

		$srow .="</row>";

		$this->m_rows[] = $srow;

		switch($sidx){
			case 0:
				$this->m_sort[]=$mtime;
				break;
			case 1:
				$this->m_sort[]=$fsize;
				break;
			case 2:
				$this->m_sort[]=$pathfile;
				break;
			default:
				$this->m_sort[]=$pathfile;
				break;
		}
	}

	function print_rows(){
		foreach( $this->m_rows as $row){
			echo $row;
		}
	}
}




class MbTbl2Grid{

	public function MbTbl2Grid( $mTblXml ){
		$this->m_TblXml=$mTblXml;
	}

	public $m_xpath;// sample: //tr[@idx],   //tr[contains(td[@id='if_type'], '0')]
	public $m_primaryKey;
	public $m_colAry=Array(); //tbl id in ary for grid col.





	////////////////////////////////////////////////////////////////
	public $m_col2sort; //id for sorted col. from grid request.
	public $m_pageStart=1;//1 based index. from grid request.
	public $m_rowsPerPage=10;//from grid request.
	public $m_sortDir; //asc or desc. from grid request.

	/////////////////////////////////
	public $m_searchField;//
	public $m_searchOper;
	public $m_searchString; //



	public $m_map_val2Gui;

	private $m_gridColTxtAry2sort=Array();
	private $m_gridRowsAry=Array();



	public function set_Key_Val2TxtDictionary($key, $MapVal2Txt){
		if( !isset($key) || strlen($key)===0 || !isset($MapVal2Txt) ) {
			return;
		}
		$this->m_map_val2Gui[$key]=$MapVal2Txt;
	}

	protected function readRequest(){
		$page = $_REQUEST['page']; // get the requested page
		$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
		$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
		$sord = $_REQUEST['sord']; // get the direction
		if(!$sidx) $sidx ="";

		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows']: false;
		if($totalrows) {
			$limit = $totalrows;
		}
		if(null==$limit || 0==$limit) $limit=1;

		$this->m_pageStart 		= $page;
		$this->m_rowsPerPage 	= $limit;
		$this->m_sortDir 		= $sord;
		$this->m_col2sort 		= $sidx;


		//////////////////////////////////////////////////////
		$searchOn = Uti::Strip($_REQUEST['_search']);
		$searchFiled=$_REQUEST["searchField"];
		$searchOper=$_REQUEST["searchOper"];
		$searchString=$_REQUEST["searchString"];

		$this->m_searchField=$searchFiled;
		$this->m_searchOper=$searchOper;
		$this->m_searchString=$searchString;
	}
	public function echoGrid(){
		$this->readRequest();
		$this->mbTbl2gridRows($this->m_TblXml,$this->m_xpath,$this->m_primaryKey,$this->m_colAry,$this->m_col2sort);
		$this->printPage();
	}
	//with conditional getting.
	protected function mbTbl2gridRows_bak_ok($mTblXml, $xpathStr, $key, $arr_col, $sort_col){
		$xml = new SimpleXMLElement($mTblXml);

		if( false === $xml){
			$this->printErrors();
			return;
		}
		//sample: $result = $xml->xpath("//tr[@idx]");
		//sample: $result = $xml->xpath("//tr[contains(td[@id='if_type'], '0')]");
		$result = $xml->xpath($xpathStr);


		while(list( , $node) = each($result)) {

			//generate a row with id is primary.
			$result2 = $node->xpath("td[@id='$key']");
			$primaryKeysVal="";
			while(list( , $node2) = each($result2)) {
				//echo 'b/c: ',$node2,"\n";
				$primaryKeysVal =  trim((string) $node2 );
			}
			$row = "<row id='$primaryKeysVal'>";

			//generate cells of the row.
			if(count($arr_col)>0 ){
				foreach ($arr_col as $col){
					$result2 = $node->xpath("td[@id='$col']");
					$val="";
					while(list( , $node2) = each($result2)) {
						//echo 'b/c: ',$node2,"\n";
						$val =  trim((string) $node2 );
					}
					//$val2 = "<a id='$primaryKeysVal' class='$col' onclick=\"occ('". $primaryKeysVal."','$val');\">$val</a>";
					$guiTxt = $this->getGuiTxtOf($col, $val);
					$val2 = "<a id='$primaryKeysVal' class='$col' onclick=\"occ('$primaryKeysVal','$val');\" title='$val' value='$val'>$guiTxt</a>";
					$celldata = htmlspecialchars(  $val2  ) ;
					$row .= "<cell>". $celldata . "</cell>";
					if( $sort_col === $col ){
						$this->m_gridColTxtAry2sort[] = $val;

					}
				}
			}

			$row .= "</row>";

			$this->m_gridRowsAry[] = $row;
		}
		return;
	}

	//with conditional getting.
	protected function mbTbl2gridRows($mTblXml, $xpathStr, $key, $arr_col, $sort_col){
		$xml = new SimpleXMLElement($mTblXml);

		if( false === $xml){
			$this->printErrors();
			return;
		}
		//sample: $result = $xml->xpath("//tr[@idx]");
		//sample: $result = $xml->xpath("//tr[contains(td[@id='if_type'], '0')]");
		$result = $xml->xpath($xpathStr);


		while(list( , $node) = each($result)) {

			//generate a row with id is primary.
			$result2 = $node->xpath("td[@id='$key']");
			$primaryKeysVal="";
			while(list( , $node2) = each($result2)) {
				//echo 'b/c: ',$node2,"\n";
				$primaryKeysVal =  trim((string) $node2 );
			}
			$row=$this->getRow($node, $primaryKeysVal, $arr_col, $sort_col);
			if(strlen($row)>0){
				$this->m_gridRowsAry[] = $row;
			}
		}
		return;
	}
	private function getRow($node, $primaryKeysVal, $arr_col, $sort_col){
		$row = "<row id='$primaryKeysVal'>";

		$sort_val="";
		//generate cells of the row.
		if(count($arr_col)>0 ){
			foreach ($arr_col as $col){
				$result2 = $node->xpath("td[@id='$col']");
				$val="";
				while(list( , $node2) = each($result2)) {
					//echo 'b/c: ',$node2,"\n";
					$val =  trim((string) $node2 );
				}
				//$val2 = "<a id='$primaryKeysVal' class='$col' onclick=\"occ('". $primaryKeysVal."','$val');\">$val</a>";
				$guiTxt = $this->getGuiTxtOf($col, $val);
				$bIgnore = $this->IsOutOfSearchRange($col, $guiTxt);
				if(true===$bIgnore) return "";

				$val2 = "<a id='$primaryKeysVal' class='$col' onclick=\"occ('$primaryKeysVal','$val');\" title='$val' value='$val'>$guiTxt</a>";
				$celldata = htmlspecialchars(  $val2  ) ;


				$row .= "<cell>". $celldata . "</cell>";
				if( $sort_col === $col ){
					$sort_val = $val;
				}
			}
		}
		$this->m_gridColTxtAry2sort[] = $sort_val;
		$row .= "</row>";

		return $row;
	}
	private function IsOutOfSearchRange($col, $val){
		if( !isset($this->m_searchField) || !isset($this->m_searchOper)===0 || !isset($this->m_searchString) ) {
			return false;
		}
		if( $col != $this->m_searchField ) return false;
		if( strlen($this->m_searchString)===0 ) return false;
		if( strlen($val)===0 ) return false;

		$pos=strpos($val, $this->m_searchString);
		if($this->m_searchOper==="contain"){
			if($pos===false){
				return true;
			}
			return false;
		}
		else if($this->m_searchOper==="not_contain"){
			if($pos===false){
				return false;
			}
			return true;
		}
		return false;
	}


	private function getGuiTxtOf($key, $internalVal){
		$ret = null;
		if( isset($this->m_map_val2Gui) && array_key_exists($key, $this->m_map_val2Gui ) ){
			$ret = $this->m_map_val2Gui [$key][$internalVal];
		}

		if( isset($ret)) {
			return $ret;
		}

		return $internalVal;
	}

	static public function printErrors(){
		$sample="<row id='41'><cell>11</cell><cell>22</cell><cell>33</cell><cell>44</cell><cell>55</cell><cell>66</cell><cell>77</cell><cell>88</cell><cell>99</cell><cell>aa</cell></row>";

		$sam2="<row id='41'><cell>&lt;a id='41' class='fpolicy_dir' onclick=&quot;occ('41','input');&quot; title='input' value='input'&gt;input&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_order' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_if' onclick=&quot;occ('41','eth0');&quot; title='eth0' value='eth0'&gt;eth0&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_src' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_dst' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_svc' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_action' onclick=&quot;occ('41','log');&quot; title='log' value='log'&gt;log&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_conn_state' onclick=&quot;occ('41','new_est_rel');&quot; title='new_est_rel' value='new_est_rel'&gt;new_est_rel&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_state' onclick=&quot;occ('41','disable');&quot; title='disable' value='disable'&gt;disable&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_id' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell></row>";

		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}
		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>1</page>";
		echo "<total>1</total>";
		echo "<records>1</records>";
		echo "<userdata name='tamount'>1</userdata>";
		echo "<userdata name='ttax'>1</userdata>";
		echo "<userdata name='ttotal'>1</userdata>";

		// be sure to put text data in CDATA
		echo "<row id='". "0"."'>";
		echo "<cell>MB Return XML Error</cell>";
		//echo "<cell><![CDATA[". "[name]"."]]></cell>";
		//echo "<cell>". "[amount]"."</cell>";
		//echo "<cell>". "[tax]"."</cell>";
		//echo "<cell>". "[total]"."</cell>";
		//echo "<cell><![CDATA[". "[note]"."]]></cell>";
		echo "</row>";
			
		echo "</rows>";
	}
	static public function printSample(){
		$sample="<row id='41'><cell>11</cell><cell>22</cell><cell>33</cell><cell>44</cell><cell>55</cell><cell>66</cell><cell>77</cell><cell>88</cell><cell>99</cell><cell>aa</cell></row>";

		$sam2="<row id='41'><cell>&lt;a id='41' class='fpolicy_dir' onclick=&quot;occ('41','input');&quot; title='input' value='input'&gt;input&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_order' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_if' onclick=&quot;occ('41','eth0');&quot; title='eth0' value='eth0'&gt;eth0&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_src' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_dst' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_svc' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_action' onclick=&quot;occ('41','log');&quot; title='log' value='log'&gt;log&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_conn_state' onclick=&quot;occ('41','new_est_rel');&quot; title='new_est_rel' value='new_est_rel'&gt;new_est_rel&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_state' onclick=&quot;occ('41','disable');&quot; title='disable' value='disable'&gt;disable&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_id' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell></row>";

		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}
		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>1</page>";
		echo "<total>1</total>";
		echo "<records>1</records>";
		echo "<userdata name='tamount'>1</userdata>";
		echo "<userdata name='ttax'>1</userdata>";
		echo "<userdata name='ttotal'>1</userdata>";

		// be sure to put text data in CDATA
		echo "<row id='". "0"."'>";
		echo "<cell>sample</cell>";
		echo "<cell>test</cell>";
		//echo "<cell><![CDATA[". "[name]"."]]></cell>";
		//echo "<cell>". "[amount]"."</cell>";
		//echo "<cell>". "[tax]"."</cell>";
		//echo "<cell>". "[total]"."</cell>";
		//echo "<cell><![CDATA[". "[note]"."]]></cell>";
		echo "</row>";

		echo $sam2;
			
		echo "</rows>";
	}
	protected function printPage(){
		$total_pages = 0;
		$count = count($this->m_gridRowsAry);  //$row['count'];
		if( $count >0 ) {
			$total_pages = ceil($count/$this->m_rowsPerPage);
		}
		$page = $this->m_pageStart;
		if ($page > $total_pages) $page=$total_pages;


		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8");
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}
		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		echo "<rows>";
		echo "<page>".$page."</page>";
		echo "<total>".$total_pages."</total>";
		echo "<records>".$count."</records>";
		echo "<userdata name='tamount'>".'0'."</userdata>";
		echo "<userdata name='ttax'>".'0'."</userdata>";
		echo "<userdata name='ttotal'>".'0'."</userdata>";
		// be sure to put text data in CDATA
		//while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		//echo "<row id='". "0"."'>";
		//echo "<cell>". "[id]"."</cell>";
		//echo "<cell>". "[invdate]"."</cell>";
		//echo "<cell><![CDATA[". "[name]"."]]></cell>";
		//echo "<cell>". "[amount]"."</cell>";
		//echo "<cell>". "[tax]"."</cell>";
		//echo "<cell>". "[total]"."</cell>";
		//echo "<cell><![CDATA[". "[note]"."]]></cell>";
		//echo "</row>";
		//}

		//echo UtiGrid::getPageOfGridCells($cells, $sord, $limit, $page);
		$this->printPage_rows();
		//$sam2="<row id='41'><cell>&lt;a id='41' class='fpolicy_dir' onclick=&quot;occ('41','input');&quot; title='input' value='input'&gt;input&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_order' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_if' onclick=&quot;occ('41','eth0');&quot; title='eth0' value='eth0'&gt;eth0&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_src' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_dst' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_svc' onclick=&quot;occ('41','any');&quot; title='any' value='any'&gt;any&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_action' onclick=&quot;occ('41','log');&quot; title='log' value='log'&gt;log&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_conn_state' onclick=&quot;occ('41','new_est_rel');&quot; title='new_est_rel' value='new_est_rel'&gt;new_est_rel&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_state' onclick=&quot;occ('41','disable');&quot; title='disable' value='disable'&gt;disable&lt;/a&gt;</cell><cell>&lt;a id='41' class='fpolicy_id' onclick=&quot;occ('41','41');&quot; title='41' value='41'&gt;41&lt;/a&gt;</cell></row>";
		//echo $sam2;
		echo "</rows>";
	}


	protected function printPage_rows(){
		$sort=SORT_ASC;
		if("desc"==$this->m_sortDir){
			$sort=SORT_DESC;
		}
		else if("asc"==$this->m_sortDir){
			$sort=SORT_ASC;
		}

		array_multisort($this->m_gridColTxtAry2sort, $sort, $this->m_gridRowsAry, $sort);

		$idxStart=$this->m_rowsPerPage*($this->m_pageStart-1);

		$ret="";
		for($i=$idxStart; $i<$idxStart+$this->m_rowsPerPage; $i+=1){
			$ret .= $this->m_gridRowsAry[$i];
		}


		echo $ret;
	}



}



class Ui_Visit{

	public static function path2Id($pathfile){
		$pathfile = str_replace("/", "$", $pathfile);
		$pathfile = str_replace(" ", "%20", $pathfile);
		return $pathfile;
	}
	public static function path2visitfile($pathfile){
		$id = Ui_Visit::path2Id($pathfile);
		$root = $_SERVER["DOCUMENT_ROOT"];
		$pathfile="$root/_tmp/ui_visit/$id.dat";
		return $pathfile;
	}
	public static function add(){
		$path=getcwd();
		$filename = Ui_Visit::path2visitfile($path);
		if(file_exists($filename)){
			$count=file_get_contents($filename);
		}
		else{
			$count=0;
		}

		$count += 1;
		file_put_contents($filename,$count);

	}
	public static function get_count($path){
		$filename = Ui_Visit::path2visitfile($path);
		if(file_exists($filename)){
			$count=file_get_contents($filename);
		}
		else{
			$count="";
		}
		$count = intval($count/2);
		if($count===0){
			return "";
		}
		return $count;
	}
}



class UmgCurl{


	public $url;
	public $ret;
	public function UmgCurl($url){
		$this->url=$url;

	}
	public function addUrlParam($key,$val){
		$amp="&";
		if( strpos($this->url,"?") === false){
			$amp="?";
		}
		$this->url .= $amp . $key . "=" . $val;
	}
	public function run(){
		// create a new cURL resource
		// for https refer:
		// http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set URL and other appropriate options
		$url="http://10.207.27.32/umg/toolkit/ui_analyzer/report_form/_server.php?q=save&tblstr=<a>df</a>&ui_path=/usr/shared";
		$url=$this->url;
		//echo $url."<br>\n";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);


		////////////////////////////////////////////////////////
		//for ssl refer http://curl.haxx.se/docs/sslcerts.html
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_AUTOREFERER,true);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);

		$crtfile=getcwd()."/10.207.16.69.crt";
		curl_setopt($ch, CURLOPT_CAINFO, getcwd()."/10.207.16.69.crt");
		//
		////////////////////////////////////////////////////////




		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		// grab URL and pass it to the browser
		$this->ret = curl_exec($ch);

		//echo "<hr/>\n";
		$this->info = curl_getinfo($ch);
		//echo "<hr/>\n";
		$this->error = curl_error($ch);
		//echo "<hr/>\n";
		//$str = htmlspecialchars($dat);
		//echo $str;
		// close cURL resource, and free up system resources
		curl_close($ch);
	}
	public function show_result(){
		echo "<br/>url: " . $this->url . "<br/>\n";
		echo "<br/>info: " . $this->info . "<br/>\n";
		echo "<br/>error: " . $this->error . "<br/>\n";

		echo "<br/>dat: ";
		$dat = htmlspecialchars($this->ret);
		echo $dat;

	}


	public function runPost($fields, $fields_string){
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		$url=$this->url;
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	}
}




//uti for simplexml
class UtiSxe{

	public static function copyXML($destSxe, $newSxe)
	{
		if (null!=$newSxe) {
			$newtagname = $newSxe->getName();
			$oldtagname = $destSxe->getName();
			if($newtagname!==$oldtagname){
				return 0;
			}
			foreach ($destSxe->xpath('*') as $child)
			{
				$oldtagname = $child->getName();
				unset($child[0]);//remove all children.
			}
			foreach ($destSxe->xpath('*') as $child)
			{
				$oldtagname = $child->getName();
				unset($child[0]);//confirm no children.
			}
			foreach ($newSxe->xpath('*') as $child)
			{
				$oldtagname = $child->getName();
				self::appendXML($destSxe, $child); //append new children.
			}
			return 1;
		}
		return 0;
	}
	public static function appendXML($sxe, $append)
	{
		if (null!=$append) {
			$tagname = $append->getName();
			$str=(string) $append;
			if (strlen(trim((string) $str))==0) {
				$xml = $sxe->addChild($tagname);
				foreach($append->children() as $child) {
					self::appendXML($xml,$child);
				}
			} else {
				$xml = $sxe->addChild($tagname, $str);
			}


			foreach($append->attributes() as $n => $v) {
				$xml->addAttribute($n, $v);
			}
		}
	}

	public static function NeatFormat($xmlstr){
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($xmlstr);

		$neatXmlDomStr = $dom->saveXML();//neat xml format
		return $neatXmlDomStr;
	}
}



?>
