<?php



function img2jpg($destfile){
	//ubuntu: apt-get install php5-imagick
	$size0=	filesize($destfile);
	$im = new imagick( $destfile );

	$dest2jpg=$destfile . "2.jpg";
	if( file_exists($dest2jpg) ){
		unlink($destfile);
		echo " <font color='red'>File already exist:</font><br/>$dest2jpg <br>";
		return;	
	}

	// convert to jpg
	//$im->setImageColorspace(255);
	//$im->setCompression(Imagick::COMPRESSION_JPEG);
	//$im->setCompressionQuality(100);
	$im->setImageFormat('jpeg');
	$ret=$im->writeImage($dest2jpg);
	$im->clear();
	$im->destroy();
	echo $ret;
	if($ret || file_exists($dest2jpg) ){
		unlink($destfile);
		echo " converted to jpg:<br>$dest2jpg <br>";
		$size2=	filesize($dest2jpg);
		$sizedlta = $size0 - $size2;
		echo " size change =  $size0 - $size2 =  $sizedlta";
	}
	else{
		echo "<font color='red'>failed to convert to jpg file.</font>";
	}
}





if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
else
{
	echo "Upload: " . $_FILES["file"]["name"] . "<br>";
	echo "Type: " . $_FILES["file"]["type"] . "<br>";
	echo "Size: " . ($_FILES["file"]["size"] / 1000) . " kB<br>";
	echo "Stored in tmp dir: " . $_FILES["file"]["tmp_name"] . "<hr/>";


	$basename= pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
	$extname = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
	$upldname = $basename . "_" . $extname;

	$destfile = $_REQUEST["dest_dir"] . $upldname;
	move_uploaded_file($_FILES["file"]["tmp_name"],  $destfile);
	echo "move_uploaded_file:<br>$destfile<hr/>";

	img2jpg($destfile);



}
?>