<?php
include_once("svrBase.php");



$modi=new Modifyer();
$modi->create();
$modi->LoadData();
$modi->showTable();
exit();

return;













$dir=$_REQUEST["dir"];
$filesFilter=$_REQUEST["filesFilter"];
$cfgPublish="";
echo( $myRequest->filtered."<br/>");
echo( $myRequest->modified."<br/>");
echo( $myRequest->wkFolder."<br/><hr/>");



$files=[];
//SearchPathFilesFilters::getFiles($files, $cfgPublish, $dir, $filesFilter);
$pf=new PathFiles($dir, $filesFilter,true);
$files=$pf->files;

//echo "<br/>\r\n";
$contents="";
$show="";
echo "<table border='1'>";
$i=0;
foreach($files as $id=> $file){
    echo "<tr><td>$i</td><td class='pfname'>$file</td></tr>";
    $i++;
    $contents .= "$file\n";
}
echo "</table>";
$size=file_put_contents($myRequest->filtered,$contents);
//echo "<hr/>size=$size\n\n";
$ret["show"]=$show;
$ret["size"]=$size;
$ret["_REQUEST"]=$_REQUEST;
//echo json_encode($ret);

?>

