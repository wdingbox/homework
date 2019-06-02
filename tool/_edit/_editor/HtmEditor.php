<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HtmEditor</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<script type="text/javascript" src="../ckeditor.js"></script>
	<script src="sample.js" type="text/javascript"></script>
  
	<link href="sample.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../../../../_js/jquery.js">
    </script>    
    <script src="HtmEditor.js" type="text/javascript" weinote="MustAfterJsqury.js"></script>
    
    
   
<style type="text/css">


</style>   
<script type="text/javascript">
$(document).ready(function(){
       $("#Tools").click(function () {           
         //if (false==confirm("This take long time.\nHtmEditor_UpdateImgsrc.php \n\nSure to continue?" )) return;
         window.open("HtmEditor_Tools.htm","_blank","","")
       });
      
    });///////////////////////////////
</script>

</head>
<body>
	<?php //print_r($_POST); ?> 
	<form id="fm1" action="" method="post">
   <input id="input1" name="input1" value="afs" style="display: none"/>
   <?php system("./DirsFoldersFiles.py '". $_POST['input1']. "'",  $retval); ?> <br>
   <a id="Tools">Tools</a> | <a id="SaveAs"> SaveAs... </a><a id="SaveStatus">SaveStatus</a>
	</form>
   
   
   
   <form id="fm2" action="javascript:OnSubmitSaveFile();" method="post" onsubmit="javascript:alert();">
   
	<textarea id="editor"><p>fff</p>
	</textarea>
   			<script type="text/javascript">
			//<![CDATA[

			CKEDITOR.replace( 'editor',
					{
						fullPage : true,
						extraPlugins : 'docprops',
   
               //extraPlugins : 'docprops',
               extraPlugins : 'devtools',
               toolbar : CKEDITOR.config.toolbar_Full
					});
               
               
               

			//]]>
			</script>
   </form>

</body>
</html>
