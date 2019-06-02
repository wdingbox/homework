<?php
@session_start();
include_once("Defs.php");
include_once("Uti.php");
include_once("Mbx.php");



// Web Secured Session Service (WSSS)
class Wsss {
	public static function Destroy(){
		@session_start();
		$ssnf = session_save_path()."_".session_id();
		if ( isset($_SESSION) ){

			if ( isset($_SESSION[Defs::SSN_LOGIN_SID] ) ) {
				$w3s = new W3s( "AAA.Service.DestroySession" );
				$w3s->addItem( "sid", $_SESSION[Defs::SSN_LOGIN_SID] );
				$w3s->exe();
			}
			if ( isset($_REQUEST["aaasid"] ) ) {
				$w3s = new W3s( "AAA.Service.DestroySession" );
				$w3s->addItem( "sid", $_REQUEST["aaasid"]  );
				$w3s->exe();
			}

			//unset($_SESSION);  //no
			syslog(LOG_EMERG, basename(__FILE__).":".__FUNCTION__."@".__LINE__."...");
			session_unset();
			session_destroy();
		}
		system("rm -f ".$ssnf);
	}
	public static function IsLoggedin(){
		@session_start();
		$sid= $_SESSION[Defs::SSN_LOGIN_SID];
		if ( !isset($sid) || strlen($sid)===0 ){
			return false;
		}
		return true;
	}

	public static function Check(){
		@session_start();
		$_SESSION["dbg001"]="";

		if ( !isset($_SESSION["EnableWSSS"])  || "EnableWSSS" != $_SESSION["EnableWSSS"] ){
			$_SESSION["dbg001"].="DisaableWSSS:". $_SESSION["EnableWSSS"];
			return;
		}

		if ( !isset($_SESSION[Defs::SSN_LOGIN_SID]) ){
			die("security check failed code 1:  trying to access without login.");
		}
		if ( !isset($_REQUEST['aaasid']) ){
			die("security check failed code 2:  trying to access without key.");
		}

		openlog("php", LOG_PID | LOG_PERROR, LOG_SYSLOG);
		 
		if($_REQUEST['aaasid'] != $_SESSION[Defs::SSN_LOGIN_SID] ){
			$res = "security check failed code 3: ". $_REQUEST['aaasid']." ~ ". $_SESSION[Defs::SSN_LOGIN_SID];
			syslog(LOG_EMERG, $res);
			die($res);
		}

		if( Uti::GetClientIp() != $_SESSION[Defs::SSN_LOGIN_CLIENTIP]  ){
			$res =  "security check failed code 4: ".Uti::GetClientIp(). " ~ " . $_SESSION[Defs::SSN_LOGIN_CLIENTIP];
			syslog(LOG_EMERG, $res );
			die($res);
		}

		//TODO check browser type.
		 
		if ( isset($_SESSION[Defs::SSN_LOGIN_SID] ) ) {
			$w3s = new W3s( 'AAA.Service.UpdateSessionTimeout' );
			$w3s->addItem( "sid", $_SESSION[Defs::SSN_LOGIN_SID] );
			$ret = $w3s->exe();

			$xml = new SimpleXMLElement($ret);
			$xret = $xml->xpath("//td[@id='result']");
			$result = "";
			while(list( , $node) = each($xret)) {
				$result =  trim((string) $node );
			}
			if( $result != "success" ){
				$res =  "security check failed code 5: UpdateSessionTimeout:".$result;
				syslog(LOG_EMERG, $res );
				die($res);
			}
		}
		$_SESSION["dbg001"].=".End.";




	}

	public static function Watermark(){
		@session_start();
		 
		$aaasid =  $_REQUEST['aaasid'] ;
		if(!isset($aaasid)) $aaasid='0';
		echo "var aaasid='$aaasid';\n";
		//$_SESSION[Defs::SSN_LOGIN_SID] = $aaasid; //allow to accumulate fr different pages

		$username = $_SESSION[Defs::SSN_LOGIN_NAME];
		if(!isset($username)) $username='-';
		echo "var username='$username';\n";

		$role = $_SESSION[Defs::SSN_LOGIN_ROLE];
		if(!isset($role)) $role='-';
		echo "var userrole='$role';\n\n";

	}
	public static function Watermark_aaasid(){
		@session_start();
		$aaasid = $_SESSION['aaasid'];
		if(!isset($aaasid)) $aaasid='0';
		echo $aaasid;
	}
	public static function Watermark_username(){
		@session_start();
		$username = $_SESSION[Defs::SSN_LOGIN_NAME];
		if(!isset($username)) $username='-';
		echo $username;
	}
	public static function Watermark_role(){
		@session_start();
		$role = $_SESSION[Defs::SSN_LOGIN_ROLE];
		if("aaa.role.appliance.admin" === $role) $role="Administrator";
		else if("aaa.role.power.user" === $role) $role="Operator";
		else if("aaa.role.user" === $role) $role="Guest";
		else{
			$role="Unknown";
		}
		echo $role;
	}
















	public static function REQUEST_2_SESSION(){

		//for bug report
		$_SESSION["UMG_LAST_REQUEST_URI"]= $_SERVER['REQUEST_URI'];
		$_SESSION["UMG_LAST_SCRIPT_FILENAME"]= $_SERVER['SCRIPT_FILENAME'];
		$_SESSION["UMG_LAST_SCRIPT_NAME"]= $_SERVER['SCRIPT_NAME'];
		$_SESSION["UMG_LAST_PHP_SELF"]= $_SERVER['PHP_SELF'];
		 
		 
		$tname=$_REQUEST["tname"];
		self::WSSS_LAST_MB_Set( "tname",  $tname);
		self::WSSS_LAST_MB_Set( "alias",  $tname);
		self::WSSS_LAST_MB_Set( "Alias",  $tname);
		self::WSSS_LAST_MB_Set( "target_name",  $tname);
		 
		 
		//for SpViewer
		$tid=$_REQUEST["tid"];
		self::WSSS_LAST_MB_Set(  "tid",  $tid);
		self::WSSS_LAST_MB_Set(  "SpId", $tid);
		self::WSSS_LAST_MB_Set(  "spId", $tid);
		self::WSSS_LAST_MB_Set(  "SpID", $tid);
		self::WSSS_LAST_MB_Set(  "spID", $tid);
		self::WSSS_LAST_MB_Set(  "target_id", $tid);
		self::WSSS_LAST_MB_Set(  "targetID", $tid);
		 
		self::WSSS_LAST_MB_Set(  "pdu_id", $tid);
		self::WSSS_LAST_MB_Set("drip_id", $tid);

		 
		$kvm_eid=$_REQUEST["kvm_eid"]; //for kvm only, also named uuid, internalId
		self::WSSS_LAST_MB_Set("kvm_eid",    $kvm_eid);
		self::WSSS_LAST_MB_Set("uuid",       $kvm_eid);
		self::WSSS_LAST_MB_Set("internalId", $kvm_eid);
		self::WSSS_LAST_MB_Set("targetUUID", $kvm_eid);

		 
		$tport=$_REQUEST["tport"];
		self::WSSS_LAST_MB_Set( "portNum",  $tport);
		self::WSSS_LAST_MB_Set( "port",  $tport);

		 
		 
		$client_ip=$_SERVER["REMOTE_ADDR"];
		self::WSSS_LAST_MB_Set("client_ip", $client_ip);
		self::WSSS_LAST_MB_Set("browserAddress", $client_ip);
		 
		$server_ip=$_SERVER["SERVER_ADDR"];
		self::WSSS_LAST_MB_Set("server_ip", $server_ip);
		 
	}



	public static function WSSS_LAST_MB_Set($key, $val){
		if(!isset($key)||strlen($key)===0) {
			return;
		}
		if(!isset($val)||strlen($val)===0) {
			return;
		}
		$_SESSION[Defs::WSSS_LAST_MB_RET_  . $key]=$val;
	}
	public static function WSSS_LAST_MB_Get($key){
		return $_SESSION[Defs::WSSS_LAST_MB_RET_  . $key];
	}
	///////////////////////////////////////////////////








	public static function tid(){
		return self::WSSS_LAST_MB_Get("tid");
	}
	public static function tport(){
		return self::WSSS_LAST_MB_Get("port");
	}
	public static function tname(){
		return self::WSSS_LAST_MB_Get("tname");
	}
	public static function kvm_eid(){
		return self::WSSS_LAST_MB_Get("kvm_eid");
	}











	public static function GetMbApiTbl($MbTopic){
		$sxe = self::MbTopic2XmlElement($MbTopic);
		self::FillinBySession( $sxe );
		$xmls = $sxe->asXML();
		return $xmls;
	}
	public static function require_MbApiTbl($MbTopic){
		$str = self::GetMbApiTbl($MbTopic);
		echo $str;
	}

	public static function GetApiTblFilename($MbApi){
		$MbApiTblFile = "mb/ApiTbl/$MbApi.php";
		$MbTblFilename = Uti::FindRequiredFile($MbApiTblFile);
		return $MbTblFilename;
	}
	//convert mbApiTble into xml elememt. It can:
	// - generate a xml input string
	//-  show up for simple dlg, toXML();
	public static function MbTopic2XmlElement($MbApi){
		$MbApiTblFile = self::GetApiTblFilename($MbApi);

		ob_start();
		require ($MbApiTblFile);
		$xmlstr = ob_get_contents();
		ob_end_clean();

		$sxe = new SimpleXMLElement($xmlstr);
		return $sxe;
	}
	//convert mb Api Table (mb/ApiTbl/*.php) into string xml  (SXI) for MB input.
	public static function MbTopic2MbXmlCmdRequest($MbTopic){

		$xml = self::MbTopic2XmlElement($MbTopic);
		self::FillinBySession( $xml );
		$sMbTitleName = $xml["MbTitleName"];

		$w3s = new W3s($sMbTitleName);


		$result = $xml->xpath("//*[@class='CmdProperties']");

		$sval=$sMbTitleName;
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			$id = $node["id"];
			$MbList=$node["MbList"];
			$MbOptional=$node["MbOptional"];

			$val = (string)$node["value"];
			$result2 = $node->xpath("./option[@selected='1']");
			while(list( , $opt) = each($result2)) {
				$val=$opt["value"];
			}
			 
			if(strlen($val)===0){
				if($MbOptional==="yes"){
					continue;
				}
			}
			$ids = $id;
			if(strlen($MbList)>0){
				$ids .=".0";
			}
			$w3s->addItem($ids, $val);
		}
		$xsi = $w3s->getXmlCmdRequest();
		return $xsi;
	}

	public static function ExeMbTopic($MbTopic){
		$xmlis = self::MbTopic2MbXmlCmdRequest($MbTopic);
		$ret = self::ExeMbXmlCmdRequest($xmlis);
		return $ret;
	}

	public static function DuplicateTD($ret, $itemId, $newItemId){
		$sxe = simplexml_load_string($ret);
		$result=$sxe->xpath("//td[@id='$itemId']");
		while(list(,$node)=each($result)){
			$val = (string) $node;
			$parents=$node->xpath("..");
			 
			while(list(,$parent)=each($parents)){
				$newChild = $parent->addChild("td", $val);
				$newChild["id"]= $newItemId;
				$newChild["title"]="duplicated new id ". $newItemId;
			}
		}
		$ret2=$sxe->asXML();
		return $ret2;
	}











	//execute javascript string xml.
	public static function RET_MB_RESPONSE_2_SESSION($MbResp){
		$sxe = simplexml_load_string($MbResp);
		$result = $sxe->xpath("//td[@id]");
		while(list( , $node) = each($result)) {
			$val =  trim((string) $node );
			$key = $node["id"];
			Wsss::WSSS_LAST_MB_Set($key, $val);
			 
		}
		return ;
	}




	//execute javascript string xml.
	public static function ExeMbXmlCmdRequest($jsxmls){
		if( !isset($jsxmls) ) {
			die("no mb xml cmd request.");
		}
		if( strlen($jsxmls) < 7 ) {
			die($jsxmls . " mb xml cmd request is not valid.");
		}
		 
		 
		$in=$jsxmls ;// $_REQUEST["JSXMLS"];
		$ret = Mbx::resp( $in );   //raw output = response + original-request
		 

		$_SESSION["WSSS_XML_INPUT_raw_jsxmls"] = htmlspecialchars($jsxmls);
		$_SESSION[Defs::WSSS_XML_OUTPUT] = $ret;

		$pos1 = strpos( $ret,  Defs::RESPONSE_SEPERATOR_BR );
		if( FALSE  === $pos1 ) {
			return ("ret strpos is false : " . $ret);
		};
		$ret = substr($ret, 0, $pos1);

		self::RET_MB_RESPONSE_2_SESSION($ret);
		return $ret;
	}
	public static function ExeMbREQUEST(){
		$jsxmls = $_REQUEST["JSXMLS"];
		$ret = Wsss::ExeMbXmlCmdRequest($jsxmls);
		return $ret;
	}

	public static function MbEcho(){
		$ret = Wsss::ExeMbREQUEST();
		echo $ret;
	}




	public static function FillinBySession(& $sxe){
		//$sxe->addChild('title', 'PHP2: More Parser Stories');

		$result = $sxe->xpath("//*[@class='CmdProperties']");
		while(list( , $node) = each($result)) {
			//echo '<br>: ',$node,"\n";
			$id = $node["id"];
			$LastSessnVal = Wsss::WSSS_LAST_MB_Get($id);
			 
			if(false===isset($LastSessnVal)){
				continue;
			}
			 
			$tag=$node->getName();
			$tag=strtolower($tag);
			if($tag==="select"){
				//$node->addChild('option', 'PHP2: More Parser Stories');
				$result2 = $node->xpath("./option");
				while(list( , $opt) = each($result2)) {
					$val=$opt["value"];
					if($LastSessnVal === $val){
						$opt["selected"]="1";
					}
				}
			}
			else if($tag==="input"){
				$node["value"]= $LastSessnVal;
			}
		}
	}




}///////////




























// Web secure session service for xml MB.
class W3s {
	public $title="";
	public $Props=array();

	public function W3s($Title){
		$this->title = $Title;
		$this->Props=array();
	}

	public function request2Title(){
		if( !isset($_REQUEST[Defs::_MB_TITLE])){
			die("\ndie@" . __FILE__ . "@" . __LINE__ .": Title is not set.");
		}
		$this->title = $_REQUEST[Defs::_MB_TITLE];
	}

	public function addItem_($id, $val){
		assert( strlen($id) > 0 ) ;
		$this->jxlis .= "<li id='$id'>$val</li>";
	}
	public function addItem($id, $val){
		$this->setItem($id,$val);
	}
	public function setItem($id, $val){
		assert( strlen($id) > 0 ) ;
		$key=(string)$id;
		assert( strlen($key) > 0 ) ;
		$this->Props[$key]= (string)$val;
	}

	public function getXmlCmdRequest(){
		$title = $this->title;
		$jxlis = "";
		foreach($this->Props as $key => $val){
			$jxlis .= "<li id='$key'>$val</li>";
		}
		$in = "<div class='request' id='$title'><ul>$jxlis</ul></div>";
		return $in;
	}



	public function exe(){
		$in = $this->getXmlCmdRequest();
		$ret = Wsss::ExeMbXmlCmdRequest($in);
		return $ret;
	}

	public function raw_output(){
		return $_SESSION[Defs::WSSS_XML_OUTPUT];
	}







}///////////



// for cli or online test.
if( isset( $_GET["test"] ) || isset($argv[1]) ){  // test: php ./file.php argv1
	echo basename(__FILE__,".php")  . " test start...\n";
	if( isset($argv[2])){
		$_POST[Defs::WSSS_XML_INPUT]="<div class='request' id='UI.GetUserList'></div>";
		$_POST[Defs::WSSS_XML_INPUT]="<div class='request' id='sm.get.masqmail.settings'></div>";
		$_SESSION[Defs::WSSS_TITLE]="UI.GetUser";
		$_SESSION[Defs::WSSS_JXMLI] .= "<li id='username'>admin</li><li id='password'>admin</li>";
	}
	Wsss::SetTitle("UI.GetUserList");
	$ret = Wsss::exe();
	print $ret;

	print "\n";

	Wsss::SetTitle("UI.GetUser");
	Wsss::AddItem("username", "admin");
	$ret = Wsss::exe();
	print $ret;

	//Wsss::SetTitle("UI.GetUserList");
	$ret = Wsss::exe();
	print $ret;

	print "\n";
	echo "\r\n+++print_r _SESSION, make sure WSSS_XML_xxx is removed.\r\n";
	print_r($_SESSION);
}



class RestCurl
{
	public function send2co($param){

		// create a new cURL resource
		// for https refer:
		// http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set URL and other appropriate options
		$url="http://10.207.27.32/umg/toolkit/ui_analyzer/co/?umguri=$param";
		echo $url."<br>\n";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_AUTOREFERER,true);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);

		$crtfile=getcwd()."/10.207.16.69.crt";
		curl_setopt($ch, CURLOPT_CAINFO, getcwd()."/10.207.16.69.crt");

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		// grab URL and pass it to the browser
		$dat = curl_exec($ch);

		echo "<hr/>\n";
		echo curl_getinfo($ch);
		echo "<hr/>\n";
		echo curl_error($ch);
		echo "<hr/>\n";
		$str = htmlspecialchars($dat);
		echo $str;
		// close cURL resource, and free up system resources
		curl_close($ch);

	}
}
?>
