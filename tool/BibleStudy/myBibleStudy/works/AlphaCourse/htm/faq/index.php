<html>
<?php

$files = scandir("./");
foreach($files as $k => $file){
    echo "<a target='_blank' href='$file'>$file</a><br/>";
}

?>



</html>