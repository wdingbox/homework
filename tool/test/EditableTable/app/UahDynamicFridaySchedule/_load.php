<?php
$data=array();

$numOfWeeks=$_REQUEST['numOfWeeks'];
for($i=0;$i<=$numOfWeeks;$i++){
    for($k=1;$k<=4;$k++){
        $fid="$i"."_$k";
        $fname="$fid.txt";
        //echo $fname. " ";
        $ret='';
        if( file_exists($fname) ){
            //echo "file_exists ";
            $ret=file_get_contents($fname);
        }
        else{
            $ret=file_put_contents($fname,"-");
        }
        $data[$fid]=$ret;
        //echo $ret. "ok";
    }
    //echo "<br/>";
}
echo json_encode($data);

?>