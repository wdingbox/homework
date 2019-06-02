
     var v,vid=0;
     
     $(function () {
     $(".timestarts").attr("size",7);
     $(".timestop").attr("size",7);
     
     $(".idx").each(function(i){
        $(this).text((1+i)+".");        
     });
     
     var totalTimeSpan=0;//seconds
     $(".tmspan").each(function(){
        var start=$(this).next().val();
        var stop=$(this).next().next().val();
        start=hhmmss_to_floatSeconds(start);
        stop=hhmmss_to_floatSeconds(stop);
        var dlta=parseInt(stop) - parseInt(start);
        totalTimeSpan+=dlta;
        var hhmmss=momnent_millisecond_to_hhmmss(parseFloat(dlta)*1000.0);
        $(this).text(hhmmss);     
     });
     $("#totTimeSpan").text("TotTime: "+totalTimeSpan +"s = "+(totalTimeSpan/60).toFixed(1)+"min.");
     

     
     $("#videoArea1").hide();
     
     v = [$("#video_0").get(0), $("#video_1").get(0)];
     
        

     v[vid].playbackRate = 1.0;
     $("#speedup").click(function(){
        v[vid].playbackRate+=0.25;
        $("#speedrate").text(v[vid].playbackRate);
     });
     $("#speeddn").click(function(){
        v[vid].playbackRate-=0.25;
        $("#speedrate").text(v[vid].playbackRate);
     });
     
         $('.vArea').click(function(){
                //v.play();
                var curTime = v[vid].currentTime;
                console.log(curTime);
                var hhmmss2=moment.duration(curTime,0); 
                var hhmmss=momnent_millisecond_to_hhmmss(parseFloat(curTime)*1000.0);
                
                $("#currTime").text(curTime+"="+hhmmss);
                
                //$("body").toggleClass("highlight");
                
                
                $(".timestarts , .timestop").each(function(){
                var val=$(this).val();
                val = momnent_millisecond_to_hhmmss(parseFloat(val)*1000);
                //$(this).val(val)         
     });
     
         });

        $('.s').click(function(){
            alert("Clicked: "+$(this).html() +"- has time of -" + $(this).attr('s') );
            v[vid].currentTime = $(this).attr('s'); v[vid].play();
        });
        
        

        
        
        $("#HindiFile").click(function(){   
            if(0===vid){
                vid=1;
            }else{
                vid=0;
            }
            set_video_stream(vid);
            
        });
        
        
        $(".moredesc").each(function(){
            $(this).next().toggle();
        }).click(function(){
            $(this).next().toggle();
        });
        
        
        
        $(".idx").click(function(){
            click_idx_to_start_video(this);
        });
        
        $("#clipNotesToggle").click(function(){
            $(".vArea").each(function(){
               $(this).hide(true);
            });
            $("#myVideoCtrls").hide(true);
            $("#clipsMenu").toggle(function(){
                return true;
            });
            $(this).parent().removeClass("clipNotesScroll");
        });
        
        
        
        $(".desc").toggleClass(" descMore").click(function(){
            $(this).toggleClass(" descMore");
        });
     });////////////////////////////////
     
     function click_idx_to_start_video(_this){
            v[vid].pause();
            var txt="";
            $(_this).parent().find(".desc").each(function(){
                txt=$(this).text();
            });
            console.log(txt);
            if(txt.indexOf("Hindi")>=0){
                vid=1;
            }
            else{
                vid=0;
            }
            set_video_stream(vid);
            v[vid].pause();
            
            $(".idx").css("background-color","#cccccc");
            $(_this).css("background-color","#00cc00").css("border","1px");
            
            clearInterval(intervalID);
            intervalID=-1;
            
            
            var start=$(_this).next().next().val();
            start=hhmmss_to_floatSeconds(start);
            v[vid].currentTime = start; 
            console.log("start:",start);
            v[vid].play();
            var stoptime=($(_this).next().next().next().val());
            auto_stop_at(v[vid], hhmmss_to_floatSeconds(stoptime));     
     }
     
     var intervalID=-1;
     function auto_stop_at(v, tms){
        if(intervalID<0) clearInterval(intervalID);
        
        intervalID = setInterval(function(){
            var vtime=v.currentTime;
            var hhmmss=momnent_millisecond_to_hhmmss(parseFloat(vtime)*1000.0);
            $("#videotime").text(vtime.toFixed(1)+" = "+hhmmss);
            if(vtime>=tms){
                v.pause();
                clearInterval(intervalID);
                intervalID=-1;
                console.log("pause@", v.currentTime);
            }
        },300);
     };
     function set_video_stream(videoID){
            console.log("switch_video_stream videoID:", videoID);
            if(1===videoID){//1:hindi
                $("#HindiFile").text("Hindi");
                $("#videoArea0").hide();
                $("#videoArea1").show();
            }
            else if(0===videoID){//0:chinese
                $("#HindiFile").text("Chinese");
                $("#videoArea0").show();
                $("#videoArea1").hide();
            }
            else{
                alert("err videoID");
            }            
     }
     function momnent_millisecond_to_hhmmss(tms2){
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
     }
     function hhmmss_to_floatSeconds(hhmmss){
            console.log(hhmmss);
            hhmmss=$.trim(hhmmss);
            var arr=hhmmss.split(":");
            if(arr.length<=1) return hhmmss;
            if(arr.length!=3) return alert("Error hhmmss format:"+hhmmss);
            
            var seconds=parseFloat(arr[0])*3600;
            seconds+=parseFloat(arr[1])*60;
            seconds+=parseFloat(arr[2]);            
            return seconds;                    
     }   
     
  
