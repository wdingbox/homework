
    //<![CDATA[  //On click Dir to submit to post myself.
    function DoSubmit(sPath){
         if(sPath && sPath.length>0){
            $("#input1").val( sPath );
         }
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
   
   	function OnSubmitSaveFile(){
                  ajx_SaveFile(document.m_filename);
                  //alert(document.m_filename);
      }
      function ajx_SaveFile(sfilename){
               $("#SaveAs").html("SaveAs.");
               
               if ( !CKEDITOR.instances.editor ){;                  
                  return alert("editor no ready");
               }
               $("#SaveAs").html("SaveAs..");
               if (IsHtmlWritable(sfilename)==false) return;

               $("#SaveAs").html("SaveAs...");
               //if(false==confirm("Are you sure to write current edit content into file?\n"+sfilename) ) return;
               $.post("WorkSaveFile.php", {   
                                  filename : sfilename,  
                                  filedata : CKEDITOR.instances.editor.getData()   
                                  },
                                  function(data, status){
                                    $("#SaveStatus").html("Saved: " + status+","+data);
                                 },
                                 "datastring"
                                 );// post 
      }////ajx_SaveFile/////////////////////////////
       function promptNewFile(oldfname){
         if(!oldfname || oldfname.length==0){
            //alert("Please click " + $("#getcwd").attr("title"));
            oldfname=$("#getcwd").attr("title")+"zzzNew.htm";
            //return "";
         }
         var pathname = oldfname.substring(0, oldfname.lastIndexOf('/'));
         var basename = oldfname.substring(oldfname.lastIndexOf('/')+1);
         var newstr = prompt(pathname, basename);
         if (!newstr || newstr.length ==0 ){
            ////alert(basename);
            return "";
         }
         var newfile=pathname+"/"+newstr;
         var i=0;
         //alert(  $(".file").length   );//nuber of files.
         if( $(".file[title*='"+newfile+"']").length ) {
            var ret = confirm("File Already Exist Among ("  + $(".file").length + ") Files:\n\n"+newfile +"\n\nAre you sure to overwrite?");
            if ( false==ret ){
               return "";
            }
         }
         return newfile;
      }///promptNewFile///
      
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
              case 'zip': 
                  alert("Unable to view in html.");
                  return false;
              default: 
                  return confirm("Unable to edit with html. Are you sure to read file? \n"+file); 
          } 
          return false;
      }; 
      function IsHtmlWritable(file) { 
         if(!file || file.length==0){
             alert("no file name. please use [SaveAs]");
            return false;
         }
          var extension = file.substring( (file.lastIndexOf('.') +1) ).toLowerCase(); 
          //file.split('.').pop().toLowerCase();//
          switch(extension) { 
              case 'htm': 
              case 'html': 
              //case 'txt': 
              //case 'php': 
              return true; 
              default: 
                  return confirm('HtmEditor may change your codes.\nAre you sure to force to write: \n'+file); 
          } 
          return false;
      }; 
 
  
    //<![CDATA[  //On click file to ajx load file to veiw.
    $(document).ready(function(){

   
   $("form").submit(function(event){
      //alert(123);
    });
    
    $("#fm2").submit(function(){
         alert(12345);
   });


       $(".file").click(function () {  // load file into editor        
         //alert( $(this).html() ); 
         var fname = $(this).attr("title");
         if( IsHtmlReadable(fname)==false ) return;
         document.m_filename = fname;//store for save file.

         $(".file").css({"border-width": "1px", "background-color": "#dddddd"});
         $(this).css({"border-width": "2px", "background-color": "#aaffaa"});

         $.post("WorkLoadFile.php", {   
									 filename:fname                          
									 },
									 function(data, status){
                              //alert("["+data+"]");
                              //removeEditor();
                              if(data.length<=5){
                                 alert(fname + " \n\nis empty file or not exist.");
                              }
                              CKEDITOR.instances.editor.setData(data);
                              $("#SaveStatus").html("[load]"+status);
									},
									"datastring"
									);/////post 
         //alert("-");
       });///.file").click/////////////////
    


      $("#SaveAs").click(function (e) {  //ajx saveAs file.
         var newfile = promptNewFile(document.m_filename);
         if( newfile.length==0) return alert("no file is saved!");
         document.m_filename =newfile;
         //alert(document.m_filename);
         ajx_SaveFile(document.m_filename);
      });//#SaveAs////////////////////////////
      

      
      
      $("a").click(function () {  

      });
      $("image").click(function () {  


  
      });
     

    



});/////////////////document-ready//////////////
	//]]>

   
   

