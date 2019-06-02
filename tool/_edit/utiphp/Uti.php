<?php
header("Cache-Control: no-cache");
header("Expires: -1");
header("X-UA-Compatible: IE=EmulateIE7");

//require_once("/var/www/lighttpd/local/app/uti/WebSvcApi.php");
//require_once("DbNvr.php");
require_once("Ureaddir.php");

class Uti {
static public function FilesArr($dirname){
    $dirname = rtrim($dirname,"/");
    if(!isset($dirname)) $dirname = ".";
    $dir = opendir($dirname);
    $htm="";
    $farr = array();
    while(false != ($file = readdir($dir)))
    {
        if(($file != ".") and ($file != ".."))
        {
            if( is_dir ($file ) ) continue;
            //$fname = basename($file,".php");
            $farr[] = $file;//full path file name.
        }
    }
    closedir($dir);
    sort($farr);
    return $farr;
}
static public function ListFiles($dirname){
    $dirname = rtrim($dirname,"/");
    $farr = self :: FilesArr( $dirname );
    $htm = "";
    foreach ($farr as $idx => $file ){
        $fname = basename($file,".php");
        $htm .=("<a href='$dirname/".$file."'>".$fname."</a> | ");
    }
    return $htm;
}

static public function str_verti($str){
    $str = trim($str);
    $ret="";
    $Charr = str_split($str,1);
    foreach ($Charr as $cha){
        $cha=strtoupper($cha);
        $ret.= $cha."<br/>";
    }
    return "<center>".$ret."</center>";
}

static public function str_clean($str){
    $str = trim($str);
    $ret="";
    $Charr = str_split($str,1);
    foreach ($Charr as $cha){
        if ( ord($cha) >= 21 && ord($cha) <= 126 ) {
            $ret.= $cha;
        }
    }
    return $ret;
}







//  /setup/audiovideo.html
//operator/image.shtml?nbr=0&basic=yes&id=35


static public function getCamVideoPath($modelid){
    $feature = Uti :: CameraModelFeatures($modelid);

    if( !isset($feature["VideoConfigPath"]) ){
        return "";
    }
    return $feature["VideoConfigPath"];
}
static public function getCamVideoConfigUrl($ip,$modelid){
///////////cgi-bin/videoconfiguration.cgi
    $pth = Uti :: getCamVideoPath($modelid);
    if($pth=="") return "";
    $url = "http://". $ip .$pth ;
    return $url;
}

static public function GetCamVideoParam($ip,$modelid, $username="",$password=""){
    $url = Uti :: getCamVideoConfigUrl($ip,$modelid);
    if($url=="") return "";

    //$text = Uti :: content_curl_password($url,$username,$password);
    if(stripos($url,".cgi")>0){
        $text = Uti :: curl_param_post($url,"LOGIN_ACCOUNT=$username&LOGIN_PASSWORD=$password");
    }
    else if( isset($password) && strlen($password)>0){
        $text = Uti :: content_curl_password($url,$username,$password);
    }
    else{
        $text = Uti :: Curl_Svc($url);
    }
    $text = Uti :: str_clean( $text ) ;
    $text = str_replace("\n"," ", $text) ;
    
    //        <select name="video_size" class=genFont size="1" onchange=ChangeVideoSize()>
    //          <option value="1" >Half
    //          <option value="2" >Half x 2
    //          <option value="3" >Normal
    //          <option value="4" >Normal x 2</option>
    //          <option value="5" selected>Double</option>
    //
    //        </select>
    
    $regex ='#<select[^>]*>(.+?)</select>#is';
    $regex ='#<select[^>]*>(.+?)</select>#is';

    $htm = "";
    if( preg_match_all( $regex, $text , $pieces ) ) 
    {
        //print_r($pieces[0]);
        $match=$pieces[0];
        foreach ($match as  $val){
            $htm.=$val . "\n";

        }
    }
    $regex ='#<input[^>]*>#';
    if( preg_match_all( $regex, $text , $pieces ) ) 
    {
        //print_r($pieces[0]);
        $match=$pieces[0];
        foreach ($match as  $val){
            if(stripos($val,"button")>0) continue;
            $htm.=$val . "\n";
        }
    }
   
    return $htm;
}

static    public function Curl_Svc($sUrl){ 
        if( ""== $sUrl){
        	return;
        }

    	$ch = curl_init(); 
        if(FALSE == $ch){
            return;
        }

        // set url 
        curl_setopt($ch, CURLOPT_URL, $sUrl);//"http://localhost/wren/camera.php?method=getAll"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $contents = curl_exec($ch); 

        // close curl resource to free up system resources  
        curl_close($ch);      

        return $contents;
    } 
static public function content_curl_password($url,$username,$password){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    //print("<br>$url,$username,$password<br>");
    //print_r($info);
    //print_r($output);
    return $output;
}

static public function content_curl_password_post($url,$username,$password){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    //print("<br>$url,$username,$password<br>");
    //print_r($info);
    //print_r($output);
    return $output;
}
static public function curl_cgi($url,$username,$password){
  
    $sapi = php_sapi_name(); 
    echo "SAPI: $sapi <br>"; 
    
    $ch = curl_init($url);//"http://www.unix.org/");
    $filename = "superprivate_$sapi.txt";
    $fp = fopen($filename, "w");
    
    fpassthru ($fp);
    // that line makes cgi act like module
    
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
    $curl_exec = curl_exec($ch);
    curl_close($ch);
    
    fclose($fp);
    echo "curl_exec: $curl_exec"; 
}

static public function curl_param_post($sUrl, $params){

    $ch = curl_init(); 
    if( FALSE == $ch ){
        return "";
    }

    // set url 
    curl_setopt($ch, CURLOPT_URL, $sUrl); 

    //post mode
    curl_setopt($ch, CURLOPT_POST, 1);

    //post params
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    //start exe
    $contents = curl_exec($ch); 

    // close curl resource to free up system resources  
    curl_close($ch);   


    //$this->genStatus($contents);
    return $contents;
}





static public function CameraModelFeatures($modelID){
    $camfeatures = Uti :: CameraModelsFeaturesArry(null);

    if( !isset($camfeatures[$modelID]) ) $modelID = 9999;
    return $camfeatures[$modelID];

//  $arr=array();
//  $arr[0 ]=array("mk"=>"mk" ,"class"=>"className","ptz"=>"ptz","audio"=>"audio","video"=>"video","md"=>"md","reso"=>"reso");
//  
//  $arr[100 ]=array("mk"=>"Vivotek  VS3100P ","class"=>"VS3000        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H263    ","md"=>"1","reso"=>"352x240");
//  $arr[102 ]=array("mk"=>"Vivotek  VS3102  ","class"=>"VS3201        " ,"ptz"=>"1","audio"=>"-    ","video"=>"H263    ","md"=>"1","reso"=>"?");
//  $arr[103 ]=array("mk"=>"Vivotek  FD61x2  ","class"=>"VS6xxx        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H263    ","md"=>"1","reso"=>"352x240");
//  $arr[104 ]=array("mk"=>"Vivotek  VS7100  ","class"=>"VS7100        " ,"ptz"=>"-","audio"=>"MPEG4","video"=>"MPEG4   ","md"=>"1","reso"=>"704x480");
//  $arr[200 ]=array("mk"=>"Axis     216FD   ","class"=>"216FD         " ,"ptz"=>"1","audio"=>"MPEG4","video"=>"MPEG4   ","md"=>"1","reso"=>"640x480");
//  $arr[201 ]=array("mk"=>"Axis     231D+   ","class"=>"231D          " ,"ptz"=>"-","audio"=>"-    ","video"=>"MPEG4   ","md"=>"1","reso"=>"704x480");
//  $arr[202 ]=array("mk"=>"Axis     216MFD  ","class"=>"216FD         " ,"ptz"=>"1","audio"=>"MPEG4","video"=>"MPEG4   ","md"=>"1","reso"=>"1280x1024");
//  $arr[203 ]=array("mk"=>"Axis     P1346   ","class"=>"H264          " ,"ptz"=>"1","audio"=>"MPEG4","video"=>"MPEG4   ","md"=>"1","reso"=>"2048x1536");
//  $arr[204 ]=array("mk"=>"Axis     215PTZ  ","class"=>"215PTZ        " ,"ptz"=>"-","audio"=>"-    ","video"=>"MPEG4   ","md"=>"1","reso"=>"704x480");
//  $arr[300 ]=array("mk"=>"Darwin   DSS     ","class"=>"DarwinServer  " ,"ptz"=>"-","audio"=>"?    ","video"=>"H264    ","md"=>"-","reso"=>"");
//  $arr[400 ]=array("mk"=>"         VRC6016 ","class"=>"VRC6016       " ,"ptz"=>"-","audio"=>"-    ","video"=>"MP4/H264","md"=>"1","reso"=>"");
//  $arr[500 ]=array("mk"=>"Arecont  AC2105  ","class"=>"ac2105        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H264    ","md"=>"-","reso"=>"");
//  $arr[501 ]=array("mk"=>"Arecont  AC5105  ","class"=>"ac5105        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H264    ","md"=>"-","reso"=>"");
//  $arr[502 ]=array("mk"=>"Arecont  AC1355  ","class"=>"ac1355        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H264    ","md"=>"-","reso"=>"");
//  $arr[503 ]=array("mk"=>"Arecont  AC3155  ","class"=>"ac3155        " ,"ptz"=>"-","audio"=>"-    ","video"=>"H264    ","md"=>"-","reso"=>"");
//  $arr[600 ]=array("mk"=>"ACTI     AMU-9111","class"=>"Acti          " ,"ptz"=>"-","audio"=>"L16  ","video"=>"mpeg4   ","md"=>"1","reso"=>"1280x1024");
//  $arr[601 ]=array("mk"=>"ACTI     AMU-9711","class"=>"Acti          " ,"ptz"=>"-","audio"=>"L16  ","video"=>"mpeg4   ","md"=>"1","reso"=>"1280x1024");
//  $arr[700 ]=array("mk"=>"Hunt     LC1xxx  ","class"=>"HuntC1xxx     " ,"ptz"=>"-","audio"=>"?    ","video"=>"H264    ","md"=>"-","reso"=>"1600x1200");
//  return $arr[$modelID];
}
static public function CameraModelFeatures_td($modelID){
    $row = Uti :: CameraModelFeatures($modelID);
    $td="";
    foreach ($row as $key=>$val){
        if( $key == "VideoConfigPath" ) continue;

        if($modelID==0){//title
            $td.="<td>". Uti :: str_verti($val) ."</td>";
        }
        else{
            $td.="<td>". $val ."</td>";
        }
    }
    return $td;
}
static public function CameraModelFeaturesAll_td($modelID){
    $row = Uti :: CameraModelFeatures($modelID);
    $td="";
    foreach ($row as $key=>$val){
        //if( $key == "VideoConfigPath" ) continue;

        if($modelID==0){//title
            $td.="<td>". Uti :: str_verti($val) ."</td>";
        }
        else{
            $td.="<td>". $val ."</td>";
        }
    }
    return $td;
}

///////////////

static public function IpCamInfoArray(&$data){
    $cam = array();
    $cam["name"]="test";
    $cam["description"]="tests";
    $cam["ipAddr"]="192.168.1.74";
    $cam["modelId_wrenmodelUid"]="0_0";
    $cam["modelId"]="100";
    $cam["wrenmodelUid"]="1";
    $cam["macAddr"]="";
    $cam["netmask"]="225.225.225.0";
    $cam["gwAddr"]="0";
    $cam["username"]="";
    $cam["password"]="";
    
    $cam["username"]="root";
    $cam["password"]="admin";
    $cam["sunday"]="111111111111111111111111111111111111111111111111";
    $cam["monday"]   =$cam["sunday"];
    $cam["tuesday"]  =$cam["sunday"];
    $cam["wednesday"]=$cam["sunday"];
    $cam["thursday"] =$cam["sunday"];
    $cam["friday"]   =$cam["sunday"];
    $cam["saturday"] =$cam["sunday"];


            $ipval = explode (".", $data[1]);
            if(count($ipval)<4) return null;
            $cam["name"] = Uti :: str_clean($data[2])." ".$ipval[3];//name
            
            $desc =  trim($data[3]).",".trim($data[4]).",".trim($data[0]).",".trim($data[9])  ;
            $cam["description"] = Uti :: str_clean( $desc );
            $cam["ipAddr"]=trim($data[1]);
            $cam["modelId"]=trim($data[13]);
            $cam["wrenmodelUid"]=trim($data[14]);
            $cam["username"]=trim($data[10]);
            $cam["password"]=trim($data[11]);

            $cam["MaxResolution"]=trim($data[7]);
            $cam["AudioEnabled"]=trim($data[8]);
            $cam["AudioCodec"]=trim($data[9]);
            $cam["PTZ"]=trim($data[12]);
  

            if( !Valid :: IpAddr( $cam["ipAddr"] )){
                return null;
            }
            //print_r($cam);
            //print("<br/>");
            return $cam;
}

//for testing record  CamerasCsv
static public function IpCamListArry($filename){
    if(isset($filename)){
    }
    else{
        $filename="../lui/Camera.List.csv";
    }
    
    static $camArr=array();
    if( count($camArr)>1 ) return $camArr;


    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);

            $cam= Uti :: IpCamInfoArray($data);
            if(null==$cam) continue;

            $camArr[] = $cam;

        }
        fclose($handle);
    }
    else{
        echo "<td><a style='color:red'>err open:$filename </a></td>";
    }

    return $camArr;
}


//for testing record  CamerasCsv
static public function CameraModelsFeaturesArry($filename){
    if(isset($filename)){
    }
    else{
        $filename="../lui/Camera.Models.Features.csv";
    }
  
    
    static $camArr=array();
    if( count($camArr)>1 ) return $camArr;

    $cam= array();
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1024, ",")) !== FALSE) {

            $cam["ModelID"]             = $data[0];
            $cam["ModelName"]           = $data[1];
            $cam["Mfgr"]                = $data[2];
            $cam["Video"]               = $data[3];
            $cam["MaxRes"]              = $data[4];
            $cam["Audio"]               = $data[5];
            $cam["PTZ"]                 = $data[6];
            $cam["MD"]                  = $data[7];
            $cam["ClassName"]           = $data[8];
            $cam["VideoConfigPath"]     = $data[9];

            $mid = intval($data[0]);
            $camArr[$mid] = $cam;
        }
        fclose($handle);
    }
    else{
        echo "<td><a style='color:red'>err open:$filename </a></td>";
    }

    $cam["ModelID"]             = "";
    $cam["ModelName"]           = "";
    $cam["Mfgr"]                = "";
    $cam["Video"]               = "";
    $cam["MaxRes"]              = "";
    $cam["Audio"]               = "";
    $cam["PTZ"]                 = "";
    $cam["MD"]                  = "";
    $cam["ClassName"]           = "";
    $cam["VideoConfigPath"]     = "";

    $camArr[9999] = $cam;

    return $camArr;
}



























}//class Uti
?>
