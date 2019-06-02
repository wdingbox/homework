<?php
@session_start();


class UmgLocale{
	function list_system_locales(){
		ob_start();
		system('locale -a');
		$str = ob_get_contents();
		ob_end_clean();
	
        //echo "System Supported Locales:<br>";
		$arr = explode("\n", trim($str));
		foreach( $arr as $dat){
			//echo $dat."<br>";
		}
		//echo "<br>";
		return $arr;
	}
	
	function get_broswer_lang(){
		$lan= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$lan = str_replace(";", ",", $lan);
		$lan = str_replace("-", "_", $lan);
		$arr = explode(",", trim($lan));
        //echo ("browser selected locale:<br>");
		//print_r($arr);
		return $arr;
	}
	function GetLang(){
		$syslocales = $this->list_system_locales();
		$broswerLan = $this->get_broswer_lang();
		foreach( $broswerLan as $brlan ){
			if( in_array($brlan, $syslocales) ){
				return $brlan;
			}
		}	
		return "en_US";	
	}
    
    function GetLangCodeFor_alert_history_locale(){
		$brlan = $this->GetLang();
		$arrMap=array("de_DE"=>"de", "en_US"=>"en", "en_GB"=>"en_gb", "es_ES"=>"es", "fr_FR"=>"fr", "ja_JP"=>"ja", "zh_CN"=>"zh"); 
        $lancode = $arrMap[$brlan];
        if( false==isset($lancode) ){
            $lancode="en";
        }
		return  $lancode;	
	}
	

	function test(){
		$lang = $this->GetLang();
		echo "<br><br><br>$lang<br>";
		// Set language to German
		putenv('LC_ALL=$lang');
		$ret=setlocale(LC_ALL, $lang);
		echo "setlocale=$ret<br>";
	
		// Specify location of translation tables
		$ret = bindtextdomain("messages", "locale");
    	echo "bindtextdomain=$ret<br>";
	    // Choose domain
		$ret = textdomain("wget");
		echo "textdomain=$ret<br>";
		// Translation is looking for in ./locale/de_DE/LC_MESSAGES/myPHPApp.mo now
		echo "<br>English Key Word:[unspecified] is translated as:<br>";
    // Print a test message
		echo gettext("unspecified");
		echo "<br>";
    // Or use the alias _() for gettext()
		echo _("unspecified");
        
        
        $test="failed: timed out.\n";
        echo "<br><br><br>English Text2:[$test]<br>";
        echo gettext($test);
        echo "<br>";
        echo _($test);
	
	}	
}

?>
