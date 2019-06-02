<?php
$handle=fopen("/tmp/access.log","r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        echo $buffer . "<br>";
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
else{
    echo "err";
}
?>
