<?php
include("HistoryKeyFreq.php");



foreach($_REQUEST as $k=>$val){
	$historykey->pushKey($val);
}
echo "save size:". $historykey->storeKey($val);
$historykey->show();

?>