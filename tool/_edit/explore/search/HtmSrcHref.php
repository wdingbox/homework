<?php 


class HtmFileLinkChecker{
	public $pattern="/\s+[hH][rR][eE][fF]\s*=\s*[\"\']([^\"\']*)[\"\']/";
	//1 or more space
	//case insensitive href
	//1 or more space
	//=
	//1 or more space
	//single or double quote
	//any string without signl or double qute
	//single or double quote.
	
	public function URLIsValid($URL)
	{
		$exists = true;
		$file_headers = get_headers($URL);
		echo "<br>$URL<br>";
		print_r( $file_headers);

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
	public function Check_Link_Pattern($pattern, $subject)
	{
		preg_match_all($pattern, $subject, $matches);

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
	public function Check($filename){

		echo "$this->pattern <br>";

		$subject=file_get_contents($filename);

		echo "$subject <br>";
		$this->Check_Link_Pattern($this->pattern, $subject);
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

$t=new HtmFileLinkChecker();
//$t->Check();


?>