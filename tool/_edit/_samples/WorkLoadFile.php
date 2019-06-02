
 <?php

if ( isset( $_POST ) ) {
   $file="file not exist.";
   if (file_exists($_POST["filename"])==true){
      $file = file_get_contents($_POST["filename"], FILE_USE_INCLUDE_PATH);
   }
   else if (file_exists($_GET["filename"])==true){
	  $file = file_get_contents($_GET["filename"], FILE_USE_INCLUDE_PATH);
   }

   echo $file;
}
else{
   print_r( $_POST );
}
?>



