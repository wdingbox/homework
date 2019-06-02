<?php
// header("Cache-Control: no-cache");
// header("Expires: -1");
// header("X-UA-Compatible: IE=EmulateIE7");

//require_once("/var/www/lighttpd/local/app/uti/WebSvcApi.php");

@session_start();

class Ureaddir {
    public $url;

    public $parm;

    public function dbg(){
        print("<br/>parm");
        print_r( $this->parm );
         print("<br/>_SESSION");
        print_r( $_SESSION );
         print("<br/>_GET");
        print_r( $_GET );
    }
    public function Ureaddir($pagefile){

        $url0 = "http" . ( (!empty($_SERVER['HTTPS'])) ? "s" : "" ) . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $urls = split($url0,"?");
        $url = $urls[0];
        $url = rtrim($url,"?");

        $this->url = $url;//.$pagefile;

        $this->parm["url0"]= $url0;
        $this->parm["url"]= $url;
        $this->parm["cwd"] = getcwd();
        $this->parm["node"] = "";
        $this->parm["pathfile"]="";
    }
    public function html(){
        //print_r($_GET);
        //print("<br>");

        $path = $this->html_getPath();

        //print_r($_SESSION);
        //print("<br>");

        echo $this->a_explodePath($path);
        echo "<br>";
        echo $this->a_readdirPath($path);




        echo "<br>".$this->parm["pathfile"]." : ".MyFile :: a_props($this->parm["pathfile"]);


        //$this->dbg();
    }
    public function html_getPath(){
        $this->parm["pathfile"]="";
        $path="";
        if( isset(  $_GET["path"] ) ){
            $path = $_GET["path"];
            $_SESSION["path"] = $_GET["path"];
        }
        else if( isset(  $_GET["node"] ) ){
            $path = $_SESSION["path"] . "/" . $_GET["node"];
            $path = str_replace("/./","/",$path);
            if( !is_dir($path) ){
                $this->parm["pathfile"] = $path;
                $path = $_SESSION["path"];
            }
            $_SESSION["path"] = $path;
            $this->parm["node"] = $_GET["node"];

        }
        else{
            $path = getcwd();
            $_SESSION["path"] = $path;
            unset($_GET);
        }    
        return $path;
    }
    public function a_readdirPath($dirname){
        $htm="";
        $dirs = $this->readdir2arr($dirname);
        //sort($dirs);
        $htm.="<a>( ".count($dirs[0])." )| </a>";
        foreach ($dirs[0] as $file)
        {
                $htm .= "<a class='dir' href='".$this->url."?node=" . $file."'>".$file."</a> | ";
        }
        $htm.="<br/><a>( ".count($dirs[1])." )</a>|";
        foreach ($dirs[1] as $file)
        {
            if(($file != ".") and ($file != ".."))
            {
                $htm .= "<a class='file' href='".$this->url."?node=" . $file."'>".$file."</a> | ";
            }
        }
        return $htm;
    }
   
    public function readdir2arr($dirname){
        $dirname = rtrim($dirname,"/");
        if(!isset($dirname)) return null;
        if( !is_dir ($dirname) ) return null;

        $arrDir = array();
        $arrFile= array();
        $dir = opendir($dirname);
        while(false != ($file = readdir($dir)))
        {
            if(($file != ".") and ($file != ".."))
            {
                if( is_dir ( $dirname."/".$file ) ) {
                    $arrDir[] = $file;
                }
                else{
                    $arrFile[] = $file;
                }             
            }
        }
        closedir($dir);

        sort($arrDir);
        sort($arrFile);

        $arr = array();
        $arr[0]=$arrDir;
        $arr[1]=$arrFile;
        return $arr;
    }

     public function a_explodePath($dirname){
        if(!is_dir($dirname)) return "";
        //$cwd = $dirname;//getcwd();
        $nodes = explode ("/", $dirname);
        $htm="<a href='".$this->url."?path=/.'>$</a>";
        $path="";
        foreach($nodes as $nod){
            $nod = trim($nod);
            if(strlen($nod)==0 || $nod=="."|| $nod== ".." )continue;
            $path .="/".$nod;
            $htm .=" / <a href='".$this->url."?path=".$path."'>".$nod."</a>";
        }
        return $htm;
    }

public function LoadFile(){
    if( is_dir( $this->parm["pathfile"] )){
        return "";
    }
    if( strlen($this->parm["node"]) > 0){

        echo self :: Load($this->parm["pathfile"]);
    
    
        //echo self :: Load($this->parm["node"]);
    
        //echo "=======<br>";

        //include($this->parm["node"]);
    }

}


static public   function Load($file) 
{ 
    if(strlen($file)==0) return;

   $value = ""; 

   $arr = array();
   $text= array();
  
    $fp = fopen( $file, "r" ); 
    if( $fp ) 
    { 
       while( ! feof( $fp ) ) 
       { 
          $line = fgets( $fp ); 
          //$text[] = $line;
          echo $line ;//"\r";


          if( $line && !preg_match( "/^#/", $line ) ) 
          { 
             if( preg_match( "/^(\w+)\s*=\s*\"?([^\"]*)\"?;/", $line , $pieces ) ) 
             { 
               $arr[$pieces[1]] = $pieces[2];
         
             } 
          } 
       } 
       fclose( $fp ); 
    } 
    else{
        echo "failed to open";
    }
   
    return $line;
}
}//class 






////////////////////////////////////////////////////////////
//
//
//
//
//


class MyFile 
{
   public $fname;

   public $fpropsOrig; //file properties.



    public $ret;


    function MyFile($file){
        $file = trim ($file);
        $this->fexist = file_exists($file);
        $this->fname  = $file;
        if($this->fexist){
            $this->fpropsOrig = self :: getProps($file);

            chown ($file, "root");
            chgrp ($file, "root");
            chmod ($file, 0777);

            chown ($file, "root");
            chgrp ($file, "root");
            chmod ($file, 0777);
        }

        system ("sudo chmod 777 ".$file, $ret);

    }
    static public function getProps($file){
        $props = array();
        $props["size"]  = filesize($file);
        $props["permsfile"] =  fileperms($file) ;
        //$props["permsdecot"] = "0". decoct( fileperms($file) );
        $props["getmodstr"] = self :: getmodstr($file);
        $props["owner"] = fileowner($file);
        $props["group"] = filegroup($file);


        //$props["permsfile_0x"] = sprintf("%x", fileperms($file) );
        $props["permsfileOCT"] = substr(sprintf('%o', fileperms('/etc/passwd')), -4);

        $sta = stat($file);
        foreach ($sta as $key => $val ){
            if( is_string($key)) continue;
            unset($sta[$key]);
        }
        $props = array_merge($props,$sta);




        $props["atime"] = strftime("%Y-%m-%d %H:%M:%S", $props["atime"]);
        $props["mtime"] = strftime("%Y-%m-%d %H:%M:%S", $props["mtime"]);
        $props["ctime"] = strftime("%Y-%m-%d %H:%M:%S", $props["ctime"]);
        //$props["sta"] = $sta;
        return $props;
    }
    static public function a_props($node){

        if(strlen($node)==0) return "";

        if( is_dir($node)) return "";
        $ps = self :: getProps($node);
        $a="";
        foreach ($ps as $key => $val){
            $a .="<a> ".$key."=".$val." </a>";
        }
        return $a;
    }

    function Setback(){
        if( file_exists($this->fname) ){
            chown ($file, $this->fowner);
            chgrp ($file, $this->fgroup);
            chmod ($file, $this->fperms);
        }
    }
    function write($text){
        $filename = $this->fname;
        $text = $this->D2A($text);
        if( file_exists($this->fname) ){
            $newfile = $filename.".".time();
            copy($filename,$newfile);
        }

        $filename = $this->fname;

        $f = fopen($filename,"w");
        if($f){
            fwrite($f, $text);//, strlen($_REQUEST["text"]));
            fclose($f);
            $this->ret = $filename."\n \nsave OK.";
        }
        else{
            $this->ret =  "FAILED to open write \n\n".$filename . ".\n\n".$this->ret(); 
        }
        //Setback();
    }

    function D2A($str){
        $str = str_replace(chr(13),chr(10),$str);
        return $str;
    }

    function ret(){
        ob_start();
        print("orig props:\n");
        print_r($this->fpropsOrig);
        print("new props:\n");
        print_r(self :: getProps($this->fname) );
        $content = ob_get_contents ();
        ob_end_clean ();
        return $content;
    }


    /* Makes is so Directories are not browseable to the public, 
removing only the Public = Read permission, while leaving 
the other chmod permissions for the file in tact. 

If you have exectue already on, and read off, public viewers will only 
be able to view files through links, but not browse 
around to see what's inside of directories and see what 
you've got laying around. */ 
//------------------------------------------------------- 
// Get file mode 
// Get file permissions supported by chmod 
static public function getmod($filename) { 
   $val = 0; 
   $perms = fileperms($filename); 
   // Owner; User 
   $val += (($perms & 0x0100) ? 0x0100 : 0x0000); //Read 
   $val += (($perms & 0x0080) ? 0x0080 : 0x0000); //Write 
   $val += (($perms & 0x0040) ? 0x0040 : 0x0000); //Execute 
  
   // Group 
   $val += (($perms & 0x0020) ? 0x0020 : 0x0000); //Read 
   $val += (($perms & 0x0010) ? 0x0010 : 0x0000); //Write 
   $val += (($perms & 0x0008) ? 0x0008 : 0x0000); //Execute 
  
   // Global; World 
   $val += (($perms & 0x0004) ? 0x0004 : 0x0000); //Read 
   $val += (($perms & 0x0002) ? 0x0002 : 0x0000); //Write 
   $val += (($perms & 0x0001) ? 0x0001 : 0x0000); //Execute 

   // Misc 
   $val += (($perms & 0x40000) ? 0x40000 : 0x0000); //temporary file (01000000) 
   $val += (($perms & 0x80000) ? 0x80000 : 0x0000); //compressed file (02000000) 
   $val += (($perms & 0x100000) ? 0x100000 : 0x0000); //sparse file (04000000) 
   $val += (($perms & 0x0800) ? 0x0800 : 0x0000); //Hidden file (setuid bit) (04000) 
   $val += (($perms & 0x0400) ? 0x0400 : 0x0000); //System file (setgid bit) (02000) 
   $val += (($perms & 0x0200) ? 0x0200 : 0x0000); //Archive bit (sticky bit) (01000) 

   return $val; 
} 
static public function getmodstr($filename) { 
   $val = ""; 
   $perms = fileperms($filename); 
   // Owner; User 
   $val .= (($perms & 0x0100) ? "r" : "-"); //Read 
   $val .= (($perms & 0x0080) ? "w" : "-"); //Write 
   $val .= (($perms & 0x0040) ? "x" : "-"); //Execute 
  
   // Group 
   $val .= (($perms & 0x0020) ? "r" : "-"); //Read 
   $val .= (($perms & 0x0010) ? "w" : "-"); //Write 
   $val .= (($perms & 0x0008) ? "x" : "-"); //Execute 
  
   // Global; World 
   $val .= (($perms & 0x0004) ? "r" : "-"); //Read 
   $val .= (($perms & 0x0002) ? "w" : "-"); //Write 
   $val .= (($perms & 0x0001) ? "x" : "-"); //Execute 

   return $val; 

   // Misc 
   $val += (($perms & 0x40000) ? 0x40000 : 0x0000); //temporary file (01000000) 
   $val += (($perms & 0x80000) ? 0x80000 : 0x0000); //compressed file (02000000) 
   $val += (($perms & 0x100000) ? 0x100000 : 0x0000); //sparse file (04000000) 
   $val += (($perms & 0x0800) ? 0x0800 : 0x0000); //Hidden file (setuid bit) (04000) 
   $val += (($perms & 0x0400) ? 0x0400 : 0x0000); //System file (setgid bit) (02000) 
   $val += (($perms & 0x0200) ? 0x0200 : 0x0000); //Archive bit (sticky bit) (01000) 

   return $val; 
} 
}//class MyFile
?>
