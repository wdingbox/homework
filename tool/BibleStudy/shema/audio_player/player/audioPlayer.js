       
        
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
function hhmmss_to_vitme(hhmmss){
	var ar=hhmmss.split(":");
	var vt0=parseFloat(ar[0])*3600;
	var vt1=parseFloat(ar[1])*60;
	var vt=vt0+vt1+parseFloat(ar[2]);
	return vt;
};







function show_current_time()  {
	var curTime = gvObj.currentTime;
    console.log(curTime);
    var hhmmss2=moment.duration(curTime,0); 
    var hhmmss=momnent_millisecond_to_hhmmss(curTime);
    
    $("#currTime").text(curTime+"="+hhmmss);
 	return hhmmss;
};

function gen_audio_sel(){
  var optns="<option></option>";
  for (var path in audioResources) {
		console.log("path:"+path);
		optns +="<optgroup  label='"+path+"'>";
		for (var filename in audioResources[path]){
			var pathfile=path+filename;
			optns+="<option value='"+filename+"' path='"+path+"' pathfile='"+pathfile+"'>"+filename+"</option>";
			console.log(pathfile);
		}
		optns +="</optgroup>";
  };
  $("#myAudioFileNameSelect").html(optns);
};


function gen_file_time_desc_table(obj){
	var trs="<thead><tr><th>start</th><th>desc</th></tr><thead><tbody>";

	//var obj=gvObj.m_srcObj;
	var hhmmssKeysArr=Object.keys(obj);
	hhmmssKeysArr.sort();
	for(var i=0;i<hhmmssKeysArr.length;i++) {
		var key=hhmmssKeysArr[i];
		trs+="<tr><td class='hhmmss' contenteditable>"+key+"</td><td class='desc' contenteditable>"+obj[key]+"</td></tr>";
		console.log(key);
	};
	trs+="</tbody"
	$("#tabinfor").html(trs).find(".desc").bind("click",function(){
		$(this).toggleClass("descHilit");
		$( "#ControlMenu" ).draggable('destroy');//in order that editable.
	});
	$("#tabinfor").find(".hhmmss").bind("click",hhmmss2input);
};
function hhmmss2input(){
	$("*").removeClass("BePlay");
	var hhmmss=$(this).text();
	$("#start_hhmmss").val(hhmmss);
	var vt=hhmmss_to_vitme(hhmmss);
	gvObj.pause();
	if(this.mToPause){
		delete this.mToPause;		
	}
	else{
		$(this).addClass("BePlay");
		this.mToPause=true;
		gvObj.currentTime=vt;
		gvObj.play();
	}
	show_current_time();
	$( "#ControlMenu" ).draggable('destroy');
};

function pin(hhmmss){
	var obj={};
	$("#tabinfor tbody").find("tr").each(function(){
		var time=$(this).find("td:eq(0)").text().trim();
		var desc=$(this).find("td:eq(1)").text().trim();
		if(time.length>0 ){
			obj[time]=desc;
		}
	});
	if(!obj[hhmmss]){
		obj[hhmmss]="<a class='Editable'>pin</a>";
	}
	gen_file_time_desc_table(obj);
	var s="\""+gvObj.m_file+"\":\n"+JSON.stringify(obj,null,2);
	$("#tout").val(s);
};


    
$(function () {
	$("#MenuBar").mousedown(function(){
		$( "#ControlMenu" ).draggable();
	})
	

	gvObj = document.getElementById('myAudio');     
	gvObj.addEventListener("ended",myHandler_ended,false);

	gen_audio_sel();
	 
	 $("#myAudioFileNameSelect").change(function(){
		var filename=$(this).val().trim(); 
		var path=$(this).find("option:contains('"+filename+"')").attr("path");
		var pathfile=$(this).find("option:contains('"+filename+"')").attr("pathfile"); 
		//init my data.
		gvObj.m_pathfile=pathfile;	
		gvObj.m_path=path;	
		gvObj.m_file=filename;	
		gvObj.m_srcObj=audioResources[path][filename];
		//html5 audio function.
		gvObj.src=pathfile;
		//gvObj.play();
		$("#speed").text(gvObj.playbackRate);
		gen_file_time_desc_table(gvObj.m_srcObj);
	 });
	 
	 $("#play").click(function(){
        
        gvObj.currentTime=parseFloat($("#start_float").val());
        gvObj.play();
     });
    $("#pin").click(function(){
            gvObj.pause();
			var hhmmss=show_current_time();
			
			$("#start_float").val(gvObj.currentTime);
			pin(hhmmss);
     });

    $("#pause").click(function(){
    	gvObj.pause();
    });
    
	 $("#currTime").click(function(){            
            var ct=$(this).text();
			var arr=ct.split("=");
			$("#start_float").val(arr[0]);
			$("#start_hhmmss").val(arr[1]);
     });

     


        


    $("#speedup").click(function(){
        gvObj.playbackRate+=0.1;
        $("#speedrate").text(gvObj.playbackRate);
		$("#speed").text(gvObj.playbackRate);
     });
    $("#speeddn").click(function(){
        gvObj.playbackRate-=0.1;
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

	$("#autorepeat").click(function(){
		gvObj.play();
	});


	
	
	
});////////////////////////////////
     
    
 function myHandler_ended(e){
	 //alert("ended");
	 gvObj.currentTime=0;
	 gvObj.play();
 }
