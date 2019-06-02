
var RemoteCell=function(jsnpar){
    var datadir=jsnpar.dataDir;
    this.m_dataDir=datadir;
    
    //svr file and app htm file must reach same data.
    
    var svrpathfile='';
    if( undefined != jsnpar.svrDir ){
        svrpathfile = jsnpar.svrDir;
    }
    else{
        svrpathfile = "../svr/";
    }
    if( undefined != jsnpar.svrFile ){
        svrpathfile += jsnpar.svrfile;
    }
    else{
        svrpathfile += "file_put_contents.php";
    }
    this.m_svr=svrpathfile;
    
    console.log("datadir="+datadir+",svr="+this.m_svr);
    
};
RemoteCell.prototype.getDataPathfilename=function(id){
    return this.m_dataDir+id+".txt";
};
RemoteCell.prototype.get=function(id,callback){
    var url=this.getDataPathfilename(id);
    return $.ajax({
        type: "GET",
        dataType:"text",
        url: url,
        async: false,
        success:function(data){
            if(callback) callback(data);
        }
    }).responseText;
};
RemoteCell.prototype.set=function(id,val,callback){
    var url=this.m_svr;//"../svr/file_put_contents.php";
    var data=$.param({file:this.getDataPathfilename(id),contents:val});
    console.log(url+",data:"+data);
    return $.ajax({
        type: "GET",
        data:data,
        url: url,
        async: true,
        success:function(data){
            //$("#"+id).text(data);
            if(callback) callback(data);
        },
        error:function(xhr, ajaxOptions, thrownError){
            alert(xhr.status);
            alert(thrownError);
        }
    }).responseText;
};













var RemoteCellEditSystem={
init:function (parobj){
    RemoteCellEditSystem.parobj=parobj;
    $.ajaxSetup({ cache: false });//for all ajx.
    window.onbeforeunload = function()
    {
        var id=RemoteCellEditSystem.id;
        if(id != null) {
            
           var focused = $(':focus');
           if(focused.length>0){               
               var curr=focused.text();
               var prev=focused.attr("prev");
               console.log("beforeunload leave curr="+curr+",prev="+prev);
               if(curr!=prev){  
                    focused.blur();
                    return 'saving data... id='+id+",curr="+curr+",prev="+prev; //cancel prompt
               }
           }
        }
    }
    
 
    
    $("div[contenteditable]").focus(function(){
        var id=$(this).attr("id");
        var remt=RemoteCellEditSystem.parobj.remoteCell.get(id);
        var cur=$(this).text();
        remt=$.trim(remt);
        console.log("focus id="+id+",cur="+cur+",remt="+remt);
        if(remt!=cur){
            $(this).addClass("conflict").removeAttr("contenteditable");
            alert("Confliction Occured.\n\nPlease refresh this page to unlock.");
            return;
        } 
        $(this).attr("prev",cur);
        RemoteCellEditSystem.id=id;
        //RemoteCellEditSystem.CheckEditUndo(this);
    }).keyup(function(){
        console.log("keyup");
        RemoteCellEditSystem.keyup_store2Remote(this);
        //RemoteCellEditSystem.CheckEditUndo(this);
    }).on("input",function(e){ 
        setTimeout(function(){
            var id = $(':focus').attr("id");
            //$("#"+id).blur(); 
            console.log("id="+id);
        },100);
        RemoteCellEditSystem.keyup_store2Remote(this);
        console.log("input event.type="+e.type);
    }).on("paste  cut delete  copy undo change ",function(e){ 
        setTimeout(function(){
            var id = $(':focus').attr("id");
            $("#"+id).blur(); 
            console.log("id="+id);
        },100);
        console.log("cut delete paste copy, type="+e.type);
    }).on("dragenter dragover drag drop",function(e){
        var cur=$(this).text();
        
        //$(this).attr("prev",cur);
        //$(this).blur();
        console.log("drop cur="+cur);
    }).on("moveout",function(e){
        console.log("moveleave");
    }).on("blur",function(){
        console.log("blur");
        RemoteCellEditSystem.id=null;
        RemoteCellEditSystem.keyup_store2Remote(this);
        //RemoteCellEditSystem.CheckEditUndo(null);
    });
    
    this.EditUndoBtn=$("#"+this.parobj.EditUndoBtnId);
    this.EditUndoBtn.click(function(){
        var id=$(this).attr("EditID");
        var t=$("#"+id).attr("value");
        if(!confirm("Restore your edit to original loaded:\r\n"+t+"\r\n\r\nSure?")){
            return;
        };
        RemoteCellEditSystem.parobj.remoteCell.set(id,t);
        $("#"+id).text(t).css("background-color","");
        $(this).attr("disabled","true");
    });    
},
keyup_store2Remote:function(_this){
    if(!_this || $(_this).length==0) {
        return;
    }
    if( undefined===$(_this).attr("contenteditable") ){
        return;
    }
        
        var id=$(_this).attr("id");
        var cur=$(_this).text();
        cur=$.trim(cur);
        var prev=$(_this).attr('prev');
        var orig=$(_this).attr('value');
        console.log("id="+id+":orig="+orig+",prev="+prev+",cur="+cur);

        if(prev != cur ){
            RemoteCellEditSystem.parobj.remoteCell.set(id,cur); 
            $(_this).attr('prev',cur);
        }
        
        if(orig!=cur){
            $(_this).addClass("dirt");
        }else{
            $(_this).removeClass("dirt");
        }

},

CheckEditUndo:function(_this){
    return;
    if(null===_this){
        this.EditUndoBtn.attr("disabled",1);
        return;
    }
    var id=$(_this).attr("id");
    this.EditUndoBtn.attr("EditID",id);
    var initval=$("#"+id).attr("value");
    var cur=$("#"+id).text();
    console.log(initval+" ? "+ cur);
    if( $.trim(initval) == $.trim(cur) ){
        this.EditUndoBtn.attr("disabled",1);
    }
    else{
        this.EditUndoBtn.removeAttr("disabled");
    }    
},
onbeforeunload_save_focused:function(){
    var val = $(':focus').blur().text();
    if(undefined===this.id){
        return;
    }
    RemoteCellEditSystem.parobj.remoteCell.set(this.id,val);
}
};








