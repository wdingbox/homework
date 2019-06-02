<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Skins &mdash; CKEditor Sample</title>
		<meta content="text/html; charset=utf-8" http-equiv="content-type" />
		<script type="text/javascript" src="../ckeditor.js"></script><script src="sample.js" type="text/javascript"></script>
		<link href="sample.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../../../../_js/jquery.js">
    </script><script type="text/javascript">
    //<![CDATA[  //On click Dir to submit to post myself.
    function DoSubmit(sPath){
         $("#input1").val( sPath );
         //alert( sPath); 
         $("#fm1").submit();
    }
    $(document).ready(function(){
       $("a.dir").click(function () {           
         DoSubmit( $(this).attr("title") )
         
       });
       $("a.folder").click(function () {           
         DoSubmit( $(this).attr("title") )
       });    
    });///////////////////////////////
    //]]>
    </script><script type="text/javascript">
    //<![CDATA[  //On click file to ajx load file to veiw.
    $(document).ready(function(){
       $(".file").click(function () {          
         //alert( $(this).html() ); 
         var fname = $(this).attr("title");
         if( IsHtmlReadable(fname)==false ) return;
         document.m_filename = fname;//store for save file.

         $(".file").css({"border-width": "0px", "border-style": "solid"});
         $(this).css({"border-width": "2px", "border-style": "solid"});

         $.post("WorkLoadFile.php", {   
									 filename:fname                          
									 },
									 function(data, status){
                              //alert(data);
                              removeEditor();
                              createEditor(data);
                              $("#Save").html("[Save]");
									},
									"datastring"
									);/////post 
         //alert("-");
       });///.file").click/////////////////
    
      $("#Save").click(function (e) {  //ajx save file.
         ajx_SaveFile(document.m_filename);
      });//#Save////////////////////////////
      $("#SaveAs").click(function (e) {  //ajx saveAs file.
         var newfile = newFileDlg(document.m_filename);
         if( newfile.length==0) return;
         document.m_filename =newfile;
         //alert(document.m_filename);
         ajx_SaveFile(document.m_filename);
      });//#Save////////////////////////////
      
      function ajx_SaveFile(sfilename){
               $("#Save").html("Save...");
               if ( !editor ){
                  $("#Save").html("Save not ready");
                  return;
               }
               if (IsHtmlWritable(sfilename)==false) return;
               //return;
               $.post("WorkSaveFile.php", {   
                                  filename : sfilename,  
                                  filedata : editor.getData()   
                                  },
                                  function(data, status){
                                    $("#Save").html("Save: " + status+","+data);
                                 },
                                 "datastring"
                                 );// post 
      }////ajx_SaveFile/////////////////////////////
      
      
      $("a").click(function () {  

      });
      $("image").click(function () {  


  
      });
      function newFileDlg(oldfname){
         var pathname = oldfname.substring(0, oldfname.lastIndexOf('/'));
         var basename = oldfname.substring(oldfname.lastIndexOf('/')+1);
         var newstr = prompt(pathname, basename);
         if (newstr.length ==0 ){
            alert(basename);
         }
         var newfile=pathname+"/"+newstr;
         var i=0;
         //alert(  $(".file").length   );//nuber of files.
         if( $(".file[title*='"+newfile+"']").length ) {
            alert("File Already Exist Among ("  + $(".file").length + ") Files:\n"+newfile);
            return "";
         }
         return newfile;
      }
      
      function IsHtmlReadable(file) { 
          var extension = file.substring( (file.lastIndexOf('.') +1) ).toLowerCase(); 
          //file.split('.').pop().toLowerCase();//
          switch(extension) { 
              case 'htm': 
              case 'html': 
              case 'js':
              case 'css': 
              case 'txt': 
              case 'php': 
              case 'py': 
              return true; 
              default: 
                  alert('Unable to edit: \n'+file); 
          } 
          return false;
      }; 
      function IsHtmlWritable(file) { 
          var extension = file.substring( (file.lastIndexOf('.') +1) ).toLowerCase(); 
          //file.split('.').pop().toLowerCase();//
          switch(extension) { 
              case 'htm': 
              case 'html': 
              case 'txt': 
              case 'php': 
              return true; 
              default: 
                  alert('HTML Editor Unable to write: \n'+file); 
          } 
          return false;
      }; 

    


var editor, html = 'ioioi';

function createEditor(htmldata)
{
	if ( editor )
		return;


	// Create a new editor inside the <div id="editor">, setting its value to html
	//var config = {};
   var config = {
      fullPage : true,
      extraPlugins : 'docprops',
      toolbar : CKEDITOR.config.toolbar_Full
	};
	editor = CKEDITOR.appendTo( 'editor', config, htmldata );

                      
                      
}

function removeEditor()
{
	if ( !editor )
		return;

	// Retrieve the editor contents. In an Ajax application, this data would be
	// sent to the server or used in any other way.
	//document.getElementById( 'editorcontents' ).innerHTML = html = editor.getData();
	//document.getElementById( 'contents' ).style.display = '';

	// Destroy the editor.
	editor.destroy();
	editor = null;
}
});/////////////////document-ready//////////////
	//]]>
	</script>
		<style type="text/css">
}		</style>
	</head>
	<body>
		<form action="" id="fm1" method="post">
			<input id="input1" name="input1" style="display: none;" type="text" value="afs" /><br />
			<a id="SaveAs">SaveAs...</a><a id="Save">Save</a></form>
		<form>
			<div id="editor">
				&nbsp;</div>
		</form>
	</body>
</html>
