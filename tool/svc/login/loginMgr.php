<?php
@session_start();

class visitCount{
	public $iCount;
	public function visitCount(){
		$fname="visitCount.txt";
		if( file_exists($fname) ){
			$iCount = file_get_contents($fname);
		}
		$iCount+=1;
		file_put_contents($fname,$iCount);//visit counter
		$this->iCount=$iCount;
	}		
}




function compress_save( $dstName, $data)
{   
	$f = fopen ( "$dstName", 'w' );
    $ret = fwrite ( $f, gzcompress ( $data, 9 ) );
    fclose ( $f );
	return $ret;
}
function uncompress_read($dstName)
{    
	$f = fopen ( "$dstName", 'r' );
    $compressed=fread ( $f, 9999 );
    fclose ( $f );
  
    $uncompressed = gzuncompress($compressed);
	//echo "<hr/>uncompress_read<hr/>$uncompressed<hr/>";
	return $uncompressed;
    
}

/////////////////////////////////////////////////
function gzcompress2save( $dstName, $data )
{
  $zp = gzopen($dstName, "w9");
  gzwrite($zp, $data);
  gzclose($zp);
}
function gzcompress2read($dstName)
{
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

class loginMgr{
public $DataFolder="./account/";
public function Load_jsonFile2session($jsonFile,$bStore2Sesn){
	$arr=array();
	if(file_exists($jsonFile)){
		//$ret=file_get_contents($jsonFile);
		$ret=readfrfile($jsonFile);
		$arr=json_decode($ret, TRUE);
	}
	
	//stroe into session for persistency.
	if(TRUE===$bStore2Sesn){
		foreach($arr as $key=>$val){
			$val2=$val;
			if( is_array($val) ){
				$val2=json_encode($val);
			}
			$_SESSION["$key"]="$val2";
		}
	}
	//print_r($arr);
	//echo $arr['FolderId'];
	return $arr;
}

public function send_email_for_passwd($result){
			//Linux:
			//For the mail functions to be available, PHP requires an installed and working email system. The program to be used is defined by the configuration settings in the php.ini file.
		    //dpkg --get-selections | grep sendmail
			//sudo apt-get install sendmail
			//sudo sendmailconfig
			//
			//Now make sure that your php.ini has correct sendmail_path. It should read as:
			//sendmail_path = /usr/sbin/sendmail -t

			//sendemailto:
			$to      = $_REQUEST['email'];
			$subject = 'RE:$result';
			$message = 'hello, your password is:'.$_SESSION['passwd'];
			$headers = 'From: wdingsoft@gmail.com' . "\r\n" .
				'Reply-To: wdingsoft@gmail.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			$ret = mail($to, $subject, $message, $headers);
			
			return $ret;
}



public function login_validation_check__________________________________(){	
	$email=$_REQUEST['email'];
	$acctData= $this->DataFolder . $email;
	if(file_exists($acctData)){
		$arr = $this->Load_jsonFile2session($acctData, false);
		if( $arr['passwd']===$_REQUEST['passwd'])
		{
			$_SESSION['email']=$email;
			return "login.ok";//login ok.
		}
		else{
			if( $email === $_REQUEST['email'] ){
				return "errPasswd";//error password
			}
			return "Err";//login totally failed.
		}
	}
	return "Not exist";//no account.
}
public function login_session(){	
	$email=$_REQUEST['email'];
	$acctData= $this->DataFolder . $email;
	$arr=array();
	$arr["result"]="err";
	if(file_exists($acctData)){
		$srets=readfrfile($acctData);
		$retArr=json_decode($srets, TRUE);
		
		//stroe into session for persistency.
		if( $retArr['passwd']===$_REQUEST['passwd'])
		{
			$_SESSION['email']=$email;
			$arr["result"]="ok";
		}
		else{
			$arr["result"]="err passwd";
			
		}
	}
	else{
		$arr["result"]="err email";
	}
	return json_encode($arr);
}


public function input_validation_check(){
	if( !isset($_REQUEST['email']) || !isset($_REQUEST['passwd'])){
		return "error input";
	}
	$email=trim($_REQUEST['email']);
	$passwd=trim($_REQUEST['passwd']);
	if(strlen($email)===0) return "empty input1";
	if(strlen($passwd)===0) return "empty input2";
	return "";
}
public function account_data_create(){	
	$ret=$this->input_validation_check();
	if(""!=$ret) {
		return json_encode($ret);
	}
	$jret = json_encode($_REQUEST);
	$email=$_REQUEST['email'];
	$filename= $this->DataFolder . $email;
	if( file_exists($filename) ){
		return json_encode('AlreadyExist');
	}
	//file_put_contents($filename,$jret);
	$ret = savetofile($filename,$jret);
	return json_encode("created successfully.$ret");		
}

public function svc(){
	$type=$_REQUEST['type'];
	$ret="";
	switch($type){
		case "login":
			$ret = $this->login_session();
		break;
		case "create":
			$ret=$this->account_data_create();
		break;
		case "forget":
			$ret=send_email_for_passwd("forget");
		break;
		default:
			$ret="err";
		break;
	}
	echo $ret;
}


public function loginStatus(){
	$url="./ham12/login.htm";
	$login="Login";
	if(isset($_SESSION['email'])){
		$url='./svc/login/logout.php';
		$login= " Logout: ". $_SESSION['email'];
	}	
	echo "<a href='$url'>$login</a>";
}
}//class//


$logmgr=new loginMgr();
$logmgr->DataFolder="../usrdata/login/";

$vc=new visitCount();

?>
