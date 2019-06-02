
 <?php

if ( isset( $_POST ) ) {
   $today = date("Ymd_His"); 
   //echo $today;

   $fname=$_POST["filename"];
   
   if( file_get_contents($_POST["filename"], FILE_USE_INCLUDE_PATH) == $_POST["filedata"] ){
      echo $fname . " ( &lt;title file_creation_timestamp='$today' &gt;... for rrfid )";
      die(0);
   }
   $bakfile = str_replace("/", "~", $fname);
   //$bakfile= "//mnt/hgfs/_w/tmp/htmeditmp/" . basename($fname) . "." . $today;
   $bakfile= "//mnt/hgfs/_w/tmp/htmeditmp/" . basename($bakfile) . "." . $today;
   if( rename($fname, $bakfile) == false ) {
      //print_r( $_POST );
      //echo "failed: " . $fname . "=>" . $bakfile;
      //exit(0);
   }

   $ret = file_put_contents($fname, $_POST["filedata"]);
   echo ",bak=".$bakfile." ($ret)";
}
else{
   print_r( $_POST );
}
?>



