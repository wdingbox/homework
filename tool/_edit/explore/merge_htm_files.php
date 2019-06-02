<?php
// Set no caching. Need php.ini: output_buttering=4096.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title>Work</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <link type="text/css" rel="stylesheet" href="sample.css" /> 

    <script type="text/javascript" src="../adapters/jquery.js">    </script>    



    <script type="text/javascript"> 

    $(document).ready(function(){               

    $("#file").click(function(){        
	});/////$("#file").click(function(){   
	
    $("#refresh").click(function(){   
        var fname = $(this).attr("fname");
        //alert(fname);
        window.open("./au2refresh.htm?fname="+fname, "_blank");
    });////




    $("#createDir").click(function(){   
    	var cwd=$("#getcwd").html();  
    	var ret=prompt("Create Dir in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create dir: \n\n"+cwd) ){
        	window.location.href="WorkCreateDir.php?dir="+cwd;
    	}
        
    });////
    $("#CreateFile").click(function(){   
    	var cwd=$("#getcwd").html();  
    	var ret=prompt("Create Dir in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create File: \n\n"+cwd) ){
        	window.location.href="WorkCreateFile.php?dir="+cwd;
    	}
        
    });////

    
    
    });///////////////////////////////$(document).ready(function(){    

    </script>

</head>

<body>



<?php




$REFRESHER = $_SERVER["REQUEST_URI"];
$REFRESHER = str_replace("index.php", "autorefresh.htm", $REFRESHER);


$THISFILE = basename(__FILE__);



$dir = getcwd();

if( isset($_GET) && strlen($_GET["dir"])>0 && file_exists($_GET["dir"])){

    $dir = $_GET["dir"];

}



$txtPath="";

$txtFile="";

chdir( $dir ); //must change to dir to scan.


echo "<a id='getcwd'>" . $dir . "/</a>     ";
echo "  <a class='create' id='createDir' >[CreateDir]</a>   ||   <a class='createFile' id='CreateFile'>*CreateFile</a><br/>\n";
echo "[  <a class='path' href='$THISFILE?dir=". dirname($dir) . "'> .    .</a>  ]\n";


$idx=0;

foreach ( scandir( $dir, $SCANDIR_SORT_DESCENDING) as $i => $entry ) {        

    $fullpath = realpath( $entry );

    $locFile = str_replace( "/www/99k.org/p/l/a/plastron777/htdocs", "", $fullpath );  //
    $locFile = str_replace( "/usr/share/apache2/htdocs", "", $locFile );  //for umg box

    if ( $entry == "."  || $entry == "..") {continue;}

    if ( is_dir($entry) ){

        $txtPath .= "<br>[ <a class='path' href='$THISFILE?dir=$fullpath'>$entry</a>  ]\n";     

    }

    else{

        $idx+=1;        

        //$txtFile .= "<br><a class='view' href='$locFile'>$idx</a>. <a class='file' href='Work.htm?filename=$fullpath'>$entry</a>\n";      
        $tx  = file_get_contents($fullpath);
        $tx  = trim($tx);
        $tx  = substr($tx,0, 1000);
        $tx  = htmlentities($tx, ENT_QUOTES);
        
        
        $txtFile .= "<br><a id='refresh' fname='$locFile'>*</a><a>  </a>";
        $txtFile .= "<a href='Work.htm?filename=$fullpath'> $idx </a>";
        $txtFile .= "<a id='del'> . </a><a class='view' href='$locFile' title='$tx'>$entry</a> \n"; 


        
        //$txtFile .= $ts;

    }    

}

echo $txtPath . $txtFile ;

?>



</body>

</html>






























































































