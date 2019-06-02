<?php
require_once("./HistoryKeyFreq.php");
//return json. The included file must be utf8 without BOM. 
//otherwise returned json could not be reconized by js.


$historykey->LoadArr();

echo json_encode($historykey->KeyFreqArr);
//$historykey->show();

exit();


?>