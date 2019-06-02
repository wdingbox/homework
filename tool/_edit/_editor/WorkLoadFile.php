
 <?php

if ( isset( $_POST ) ) {
   if (file_exists($_POST["filename"])==false){
      echo($_POST["filename"]. " not exist");
      die();
   }
   $file = file_get_contents($_POST["filename"], FILE_USE_INCLUDE_PATH);
   echo $file;
}
else{
   print_r( $_POST );
}
?>



