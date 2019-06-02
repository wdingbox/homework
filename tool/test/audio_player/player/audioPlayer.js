       
        
var gvObj=null;

function momnent_millisecond_to_hhmmss(vtime){
        var tms2=parseFloat(vtime)*1000.0;
                    function paddingInt(val){
                        val=""+val;
                        while(val.length<2) val="0"+val;
                        return val;
                    }
                    function paddingFloat(val){
                        val=""+val;
                        while(val.indexOf(".")<2) val="0"+val;
                        return val;
                    }     
                    var hhmmss2=moment.duration(tms2,0);
                    var ms=(""+(hhmmss2._data.milliseconds)*1000.0).substr(0,3);
                    var ss=hhmmss2._data.seconds;
                    var mm=hhmmss2._data.minutes;
                    var hh=hhmmss2._data.hours; 
                    return paddingInt(hh)+":"+paddingInt(mm)+":"+paddingInt(ss)+"."+ms;                    
}; 
 
function GetAudioSrc(pAudio)  {

}
function show_current_time()  {
			    var curTime = gvObj.currentTime;
                console.log(curTime);
                var hhmmss2=moment.duration(curTime,0); 
                var hhmmss=momnent_millisecond_to_hhmmss(curTime);
                
                $("#currTime").text(curTime+"="+hhmmss);
 
}



function gen_audio_sel(){
  var optns="<option></option>";
  for (var path in audioResources) {
		console.log("path:"+path);
		optns +="<optgroup  label='"+path+"'>";
		for (var filename in audioResources[path]){
			var key=path+filename;
			optns+="<option value='"+key+"' path='"+path+"' filename='"+filename+"'>"+filename+"</option>";
			console.log(key);
		}
		optns +="</optgroup>";
  };
  $("#myAudioFileNameSelect").html(optns);
};


function gen_file_info_table(pathfilename){
	var ilast=1+pathfilename.lastIndexOf("/");
	var path=pathfilename.substr(0,ilast);
	var file=pathfilename.substr(ilast);
	console.log(file);
	var trs="<tr><td>start</td><td>desc</td></tr>";
	var obj=audioResources[path][file];
	console.log(obj);
	for (var key in obj) {
		trs+="<tr><td onclick='hhmmss2input(this)'>"+key+"</td><td>"+obj[key]+"</td></tr>";
		console.log(key);
	};
	$("#tabinfor").html(trs);
}


function hhmmss2input(_THIS){
	var hhmmss=$(_THIS).text();
	$("#start_hhmmss").val(hhmmss);
}


    
$(function () {
    gvObj = document.getElementById('myAudio');     
	gen_audio_sel();
     
    $("#Back0").click(function(){
        gvObj.pause();
		gvObj.src=$("").val();
        gvObj.currentTime -= 5.0;
        $("#currTime").text(gvObj.currentTime);
        if(gvObj.currentTime<0) gvObj.currentTime=0;
        gvObj.play();
     });
	 
	 
	 
	 
	 $("#myAudioFileNameSelect").change(function(){
		var filename=$(this).val();
		gvObj.src=filename;
		gvObj.play();
		$("#speed").text(gvObj.playbackRate);
		gen_file_info_table(filename);
	 });
	 
	 $("#play").click(function(){
        
        gvObj.currentTime=parseFloat($("#start_float").val());
        gvObj.play();
     });
    $("#stop").click(function(){
            gvObj.pause();
			show_current_time();
			
			$("#start_float").val(gvObj.currentTime);
     });
	 $("#currTime").click(function(){            
            var ct=$(this).text();
			var arr=ct.split("=");
			$("#start_float").val(arr[0]);
			$("#start_hhmmss").val(arr[1]);
     });

     


        


    $("#speedup").click(function(){
        gvObj.playbackRate+=0.25;
        $("#speedrate").text(gvObj.playbackRate);
		$("#speed").text(gvObj.playbackRate);
     });
    $("#speeddn").click(function(){
        gvObj.playbackRate-=0.25;
        $("#speedrate").text(gvObj.playbackRate);
		$("#speed").text(gvObj.playbackRate);
     });
     
     


	$("#hhmmssToDecimal").click(function(){
		var hhmmss=$("#start_hhmmss").val();
		console.log(hhmmss);
		var v=moment.duration(hhmmss).asSeconds();
		console.log(v);
		$("#start_float").val(v);
	
	});
	
	
	$("#minus_seconds").click(function(){
		var time=$("#start_float").val();
		var itime=parseFloat(time)-1.0;
		$("#start_float").val(itime);
	});
	
	
	$("#playback1s").click(function(){
		gvObj.pause();
        gvObj.currentTime -= 5.0;
        if(gvObj.currentTime<0) gvObj.currentTime=0;
        gvObj.play();
		
		show_current_time();
	});
	
	
	$("#playforward1s").click(function(){
		gvObj.pause();
        gvObj.currentTime += 1.0;
        if(gvObj.currentTime<0) gvObj.currentTime=0;
        gvObj.play();
		
		show_current_time();
	});
	
	
});////////////////////////////////
     
    
 
