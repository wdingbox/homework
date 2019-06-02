<?php
include_once("svrBase.php"); 

echo "<br/>Start Work.<hr>";
$modi=new Modifyer();
$modi->LoadData();
$modi->CheckDupFileNames();

if( isset($_REQUEST["bModiContents"]) && "true"===$_REQUEST["bModiContents"]){
    $modi->ModifyFileContents();
}    

if( isset($_REQUEST["bRename"]) && "true"===$_REQUEST["bRename"]){
    $modi->ModifyFileNames();
}
echo "<hr/>End Work!";
exit();

return;



?>

