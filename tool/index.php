<!DOCTYPE html>
<html>
	<head>
		<title></title>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8"></META>
	<META name="viewport" content="width=device-witdh, initial-scale=1, maximum-scale=1, user-scale=0"> 
		<script language="javascript" src="./ham12/jq/jquery.js">
    </script>
<style>	
body {
    background-color:grey  ;
    color: white;
    width:100%;
	font-size: 100%;
}
table{
	width:100%;
	font-size: 200%;
	}
	
	table tr td:first-child { width: 1em; }
</style>
<script language="javascript">

$(document).ready(function(){
  $("table tr td:eq(2)").click(function(){
	//alert();
  });
  
  $("td").click(function(){
	var idx_td=$(this).index();
	var idx_tr=1+$(this).parent().index();
	console.log(idx_td+","+idx_tr);
	if("+"===$(this).text()){
		console.log("+");
		var newTR="<tr><td>"+(idx_tr+1)+"</td><td>new</td></tr>";
		$(newTR).insertBefore( $(this).parent() );
	}
	else if(0===idx_td){
		var url="ad/?id="+idx_tr;
		console.log(url);
		window.open(url,"_blank");
		
	}
  });
  
});
 
</script>


	</head>
<?php
include("./svc/login/loginMgr.php");

//$ad->Folder="ad";
$visit=new visitCount();



?>


<body>
<?php $logmgr->loginStatus(); ?>
<hr/>
<br>
    <center>
    <a href="./ham12/BiblePad-2016.html">BibleOnPad-2016</a><br><br>
	<a href="./ham12/BiblePad.htm">BiblePad(release)</a><br><br>
	<a href="./ham12/BiblePad-2015-meta.htm">BibleOnPad(meta)</a><br><br>
	<hr/>
	<br><br>
	<a href="./ham12/MyNotes.htm">MyNotes</a><br><br>

    <hr/>
 	<a href="./ham12/MyPay.htm">MyPay</a><br><br>
	
	<hr/>
	
    <a href="./ham12/My_toolkits_BibleCompareVersions.htm">My_toolkits_BibleCompareVersions.htm<br/>(Desktop Prefered)</a><br><br>
    <a href="./ham12/My_toolkits_WordsFreq_toolkit.htm">My_toolkits_WordsFreq_toolkit.htm<br/>(Desktop Prefered)</a><br><br>
    
    <a href="./_edit/explore/login/index.php">tool</a><br>

	<hr/>
	<br><br><br>
	<?php echo $visit->iCount;?>
	</center>
	<hr/>
	<table border='1'><caption>ads</caption>
	<?php //$ad->Table_TRs(-1); ?>
	</table>
	<br><br><hr/>
	
	
	
	
	
	
    <a href="hanyin/B_Full_view.htm">B_Full_view Chinese Bible</a><br>
    <a href="hanyin/Bible.htm" target="_blank">Simplified Chinese Bible (Union Version)</a><br>
    <a href="hanyin/CBE3k.htm">3000 Simplified Chinese Bible Explorer</a><br>
    <br>
    <a href="ebible/bbe.txt" target="_blank">English Basic Bible (Basic English Version)</a><br>
    <a href="ebible/kjv.txt" target="_blank">English King James Bible (KJV)</a><br>

    <br/>
	<a href="hanyin/Cta7k.htm">7000 Simplified Chinese Pinyin Input Method</a><br/>
   <a href="hanyin/Cta7k_traditional.htm">7000 Traditional Chinese Pinyin Input Method</a><br/>
    <a onClick="window.open('hanyin/ECI6k.htm','ECI6k','width=1000,height=600')" href="index.htm">6000 Simplified Chinese English Input</a><br/>


    
    <br>
    <a href="http://www.chineseetymology.org/"  target="_blank">www.chineseetymology.org</a><br>
    <a href="http://www.internationalscientific.org/"  target="_blank">www.internationalscientific.org</a><br>
    <a href="http://www.zdic.net/"  target="_blank">www.zdic.net</a><br>
    

    <br>
    <a>Cinese Bible Word Statistic</a><br>
    <a href="hanyin/B_Freq_Stat_All.htm">B_Freq_Stat_All</a><br>
    <a href="hanyin/B_Freq_Stat_NT.htm">B_Freq_Stat_NT</a><br>
    <a href="hanyin/B_Freq_Stat_NT_Gospel.htm">B_Freq_Stat_NT_Gospel</a><br>
    <a href="hanyin/B_Freq_Stat_OT.htm">B_Freq_Stat_OT</a><br>
    <a href="hanyin/B_Freq_Stat_OT_Genisis.htm">B_Freq_Stat_OT_Genisis</a><br>
    <a href="hanyin/B_Freq_Stat_OT_Mose5.htm">B_Freq_Stat_OT_Mose5</a><br>

    <br><br><br>
    <a href="./ham12/BiblePad-2015.htm">BiblePad</a>


	</body>
</html>

