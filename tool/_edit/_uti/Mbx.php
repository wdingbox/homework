<?php
//MB msg exchange



define ("MBX_SOC_PORT", 63927);       //match svr.
define ("MBX_SOC_ADDR", "127.0.0.1"); //match svr.
define ("SOC_BUFFER_MIN", 16);        //match svr.

class Mbx
{
	private static $m_time;
	private static $m_title;
	public static function startTime(){
		global $m_time;
		$m_time=microtime(1);
		return $m_time;
	}
	public static function spanTime(){
		global $m_time;
		$span=microtime(1)-$m_time;
		return $span;
	}
	public static function LOG_filename(){
		return "/usr/share/apache2/htdocs/_tmp/mbx_".session_id().".log";
	}
	
	
	public static function STATS_dir(){
		$dir="/usr/share/apache2/htdocs/_tmp/mbx_stats";
		return $dir;
	}
	public static function STATS_fullpathfile($title){
		$filename=self::STATS_dir() . "/" . $title. ".log";
		return $filename;
	}
	public static function STATS($ret){
		// for statistics
		global $m_title;
		$filename=self::STATS_fullpathfile($m_title);
		file_put_contents($filename, self::spanTime(). " " . $ret . "\r\n",  FILE_APPEND);
	}
	
	public static function LOG($data){
		// for log
		$filename=self::LOG_filename();
		if( file_exists($filename)){
			file_put_contents($filename, $data."\n", FILE_APPEND);
		}
	}
	public static function LOG_fatal($data){
		$filename=self::LOG_filename();
		if( file_exists($filename)){
			self::LOG( "\n\n<hr/><div style='background:red;border:10px solid #00ffff;'>Fatal Error: " . $data . "</div><hr/><br/>\n\n" );
		}
	}
	public static function LOG_test($data){
		$filename=self::LOG_filename();
		if( file_exists($filename)){
			self::LOG( "\n\n<br/><a style='background:grey;border:1px;'>Test: " . $data . "</a><br/>\n\n" );
		}
	}
	public static function getLOG(){
		$filename=self::LOG_filename();
		if( !file_exists($filename)){
			return "no file exist. LOG is disabled.";
		}
        if(filesize($filename)>100100100){//100MB
            self::restartLOG();
        }
		return file_get_contents($filename);
	}
	public static function restartLOG(){
		$filename=self::LOG_filename();
		file_put_contents($filename, "<a title='system in seconds'>[ @".microtime(1)."s ] </a><a>:  enable and restart mb activity log (previous log will be deleted.)</a>\n");
	}
	public static function testLOG(){
		self::LOG_fatal("<div>test ok</div>");
		self::LOG_test("<div>test ok</div>");
	}
	public static function disableLOG(){
		$filename=self::LOG_filename();
		if( file_exists($filename)){
			unlink($filename);
		}
	}

	
	
	


	public static function validateXml($xmlstr){
		libxml_use_internal_errors(true);

		$doc = simplexml_load_string($xmlstr);
		$xml = explode("\n", $xmlstr);//not used

		if (!$doc) {
			$errors = libxml_get_errors();

			foreach ($errors as $error) {
				//$err = display_xml_error($error, $xml);
				//self::LOG_fatal((string)$error);
			}

			libxml_clear_errors();
            $errxml=htmlspecialchars($xmlstr);
			self::LOG_fatal("error xml:<br>$errxml");
			return false;
		}
		else{
			global $m_title;
			$m_title=$doc["id"];
		}
		return true;
	}





	public static function resp($in){

		self::LOG("<hr/><a style='color:blue' title='system time in seconds'>[ @".self::startTime()."s ]</a>\n$in");
		if(false === self::validateXml($in) ){
			return "<a></a>";
		}


		$service_port = MBX_SOC_PORT; //or getservbyname('www', 'tcp');
		$address = MBX_SOC_ADDR;  //"127.0.0.1";  //gethostbyname('www.example.com');

		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
			self::LOG_fatal( "socket_create() failed: reason: " . socket_strerror(socket_last_error()) );
		} else {
			//self::LOG("socket_create OK.\n");
		}

		//self::LOG( "Attempting to connect to '$address' on port '$service_port'...");
		$result = socket_connect($socket, $address, $service_port);
		if ($result === false) {
			self::LOG_fatal( "socket_connect() failed.<br/>Reason: ($result) " . socket_strerror(socket_last_error($socket)) );
		} else {
			//syslog(LOG_DEBUG, "socket_connect OK.\n");
		}


		$out = '';


		// echo "1) read ready signal.";
		$out = socket_read($socket, SOC_BUFFER_MIN);

		// echo "2) send the length of data.";//must be 16 in length.
		$in = str_replace("\\'", "'", $in);
		$nLen 		= strlen($in);
		$sdatlen 	= "".$nLen."                 ".$in;
		if( socket_write( $socket, $sdatlen, SOC_BUFFER_MIN ) !=  SOC_BUFFER_MIN){
			self::LOG_fatal( "socket_write() failed: reason: " . socket_strerror(socket_last_error()) );
		}
		if( socket_write( $socket, $in, $nLen) != $nLen){ //localizationed binary data size.
			self::LOG_fatal( "socket_write() failed: reason: " . socket_strerror(socket_last_error()) );
		}

		// return data from mb.

		// echo "3) read len of data.";
		$out = socket_read($socket, SOC_BUFFER_MIN);
		$nTot = intval($out);

		$nRead=$nTot ;
		$ret= '';
		do{
			//self::LOG_test( "rcv size=".$nRead );

			$out = socket_read($socket, $nRead);
			// echo "4) read  data:$out";
			$ret .= $out;
			$nRead -= strlen($out);
			if(strlen($ret)==0) break;


		}while( $nRead > 0 ) ;

		//to closeout
		socket_close( $socket );

		//syslog(LOG_DEBUG, "socket_close.\n");

		self::STATS($in);
		self::LOG("<br/><font color='green' title='time spent in seconds.'>[ +".self::spanTime()."s ]</font>\n$ret");
		return $ret;
	}

};//class

?>