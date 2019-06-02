<?php
@session_start();
if( !isset($_SESSION["LOGIN_USER"]) ){
	header("Location: ./login/");
}

// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");



require_once ("../_uti/Uti.php");
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Explore</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<META name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1, user-scale=0"></META>
<base target="_self" />
<link type="text/css" rel="stylesheet" href="sample.css" />
<link type="text/css" rel="stylesheet" href="index.css" />
<script type="text/javascript" src="../adapters/jquery.js">    </script>
<script type="text/javascript" src="./index.js">    </script>

<style type="text/css">

</style>




<script type="text/javascript"> 

    $(document).ready(function(){               
    
    });///////////////////////////////$(document).ready(function(){    

</script>

</head>

<body>



<?php
class ShowExplorer{

	public $imgArr=Array();

	public function echoDirMenu($dir){
		$arrNodes=explode("/",$dir);
		$nodstr=implode("</a>/<a>", $arrNodes);
		echo "<div class='op'>";
		echo " | <a id='goBackupDir'> BackupDir </a>";
		echo " | <a class='create_Dir' id='createDir' >CreateDir</a>";
		echo " | <a class='create_File' id='CreateFile'>CreateFile</a> ";
		echo " | <a id='upload_file'>Upload</a> ";
		echo " | <a id='gosearch'> Search </a>";
        echo " | <a id='goModifyer'> Modifyer </a>";
		echo "</div><hr/>";
		echo "<a id='getcwd' dir='$dir'> $nodstr/ </a>  &nbsp; &nbsp;  &nbsp; &nbsp; (". count($arrNodes).")";
		echo "\n<hr/>\n";
	}

	public function showExplorePage(){
		$dir = "../../../"; //getcwd();

		if( isset($_GET["dir"]) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){
			$dir = $_GET["dir"];
		}
		$dir=realpath($dir);

		$this->echoDirMenu($dir);

		chdir( $dir ); //must change to dir to scan.

		$THISFILE = basename(__FILE__);
		$folders = "<a class='path' title='goto parent folder' href='$THISFILE?dir=". dirname($dir) . "'> . .</a><br>";
		$files="";

		$idx=0;
		foreach ( scandir( $dir, 0) as $i => $entry ) {

			$fullpath = realpath( $entry );
            $fullpath=str_replace("\\","/",$fullpath);

            $url=$this->path2url($fullpath);


			if ( $entry == "."  || $entry == "..") {
				continue;
			}

			if ( is_dir($entry) ){

				$folders .= "<a class='path' href='$THISFILE?dir=$fullpath'>$entry</a> <br/>\n";

			}
			else{
				$idx+=1;

				$files .= "<a id='refresh' fname='$entry'>*</a>&nbsp;";
				$files .= "<a class='viewfile' target='_blank' href='Work.htm?filename=$fullpath'> $idx </a>";
				$files .= "<a id='del'> . </a>";
				$files .= "<a class='filelink' href2='$url' title='$fullpath'>$entry</a><br> \n";

				$ext = pathinfo($entry, PATHINFO_EXTENSION);
				if( in_array($ext, Array("jpg","jpeg","img","png","gif")) ){
					$this->imgArr[]=$url;
				}
			}
		}

		//echo "<table border='1'><tr><td>$folders</td><td>$files</td></tr>";
		echo "<table border='1' bgcolor='#ffFF0' id='dirlist'><tr><td>$folders</td></tr></table><hr/>";
		echo "<table border='1' bgcolor='#ffFFff' id='filelist'><tr><td>$files</td></tr></table>";
        echo "REQUEST_URI:" . $_SERVER["REQUEST_URI"]."<hr/>";
        print_r($_SERVER);
	}//showExplorePage

    function path2url($file, $Protocol='http://') {
    	$THISFILE = basename(__FILE__);

        $file=str_replace("\\","/",$file);//convert window path into url path

        // [CONTEXT_DOCUMENT_ROOT] => /Library/WebServer/Documents

        $sUrlRelativePath=str_replace($_SERVER['CONTEXT_DOCUMENT_ROOT'], '', $file);
        if ($_SERVER[HTTP_HOST] == "localhost"){//localhost on MacPro
        	//return $sUrlRelativePath;
        	return $_SERVER[CONTEXT_PREFIX] . $sUrlRelativePath;
        }

        //ubuntu server.
        return $Protocol.$_SERVER['HTTP_HOST'].$sUrlRelativePath;
    }

	public function showImgs(){
		if( count($this->imgArr) ===0) return; 
		echo "<div id='imgHoldr'><span id='imgUrl'></span><br/><img id='imger'></img></div>";
		foreach( $this->imgArr as $idx=>$relativeFile){
			echo $idx;
			$basename=basename($relativeFile);
			echo "<img src='$relativeFile' title='$basename' width='30' />";
			
			if($idx>=10){
				echo "<br/><a id='moreImg'>more...</a>";
				break;
			}
			
			//$image = new Imagick($relativeFile);
			// If 0 is provided as a width or height parameter,
			// aspect ratio is maintained
			//$image->thumbnailImage(100, 0);
			//echo $image;
		}
	}
}


//$ret = glob("/usr/shared/apache2/*");
//echo count($ret) . "<br/>";

$se = new ShowExplorer();
$se->showExplorePage();


echo "<hr/>";
$se->showImgs();

echo "<br/><br/><br/>";
?>

<div id="imgHolder">...</div>

</body>

</html>