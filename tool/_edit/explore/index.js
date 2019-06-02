

$(document).ready(function(){               

    $("#file").click(function(){        
	});/////$("#file").click(function(){   
	
    $("#refresh").click(function(){   
        var fname = $(this).attr("fname");
        //alert(fname);
        window.open("./au2refresh.htm?fname="+fname, "_blank");
    });////




    $("#createDir").click(function(){   
    	var cwd=$("#getcwd").html();  
    	var ret=prompt("Create Diretroy in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create dir: \n\n"+cwd) ){
        	window.location.href="WorkCreateDir.php?dir="+cwd;
    	}
        
    });////
    $("#CreateFile").click(function(){   
    	var cwd=$("#getcwd").html();  
        cwd=$.trim(cwd);
    	var ret=prompt("Create File in \n"+cwd , "");
    	if (null==ret) return;
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        cwd = cwd + ret;  
        if( true==confirm("Are you sure to create File: \n\n"+cwd, "ff") ){
        	window.location.href="WorkCreateFile.php?dir="+cwd;
    	}        
    });////


    $("#gosearch").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./search/index.php?dir="+dir, "_blank");
        
    });////
    $("#goModifyer").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./modifyer/index.php?dir="+dir, "_blank");
        
    });
    

    $("#gosearch_html").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./search_html/index.php?dir="+dir, "_blank");
        
    });////
	
	$("#upload_file").click(function(){  
    	var dir=$("#getcwd").html();  
    	window.open("./upload/index.php?dir="+dir, "_blank");
        
    });////

    $("#goBackupDir").click(function(){  
    	var dir=$("#getcwd").html();  
		dir = $.trim(dir);		
		dir = dir.substring(0, dir.length - 1);
		var arr = dir.split("/");
		if(arr.length==0) return alert("err");
		var node=arr[arr.length-1];

    	var node2 = node + "_bak";
    	var ret=prompt("Backup Suffix:" , "_bk");
    	if (null==ret || node2.length==0) return alert("empty");
        //alert(fname);WorkCreateDirFtp.php?dir=$dir
        var dir2 = dir + ret;  
        ret = prompt(dir +"\nBackup as: \n", dir2) ;
    	if(null==ret || ret.length==0) return alert("empty");
        var url = "WorkBackupDir.php?dir="+dir+"&dir2="+ret;
        alert(url);
        window.open(url,"","width=700,height=600,scrollbars=yes, resizable=yes,");      
    });////

    $("a.filelink").mouseover(function(){  
        var href = $(this).attr("href");
        var width = 10+$("#filelist").width();
        var pos = $("#filelist").position();
        //alert(href);
        $("#imgHoldr").css("position","fixed").css("top",77).css("left",width);
        $("#imger").attr("src",href);
        $("#imgUrl").html(href);
        
        $("a").css("background", "");
        $(this).css("background", "#aaaaff");
    
    });////
    $("a[href2]").click(function(){  
        var href = $(this).attr("href2");
        href=joinPath(href);
		window.open(href);
    });////

    
    
});///////////////////////////////$(document).ready(function(){    

function joinPath(href){
    var curpathname=""+ window.location.pathname;
    console.log(curpathname);
    var winodesArr=curpathname.split("/");
    var arr=href.split("/");
    var myurl=["",""];
    var nod="";
    for(var i=0;i<winodesArr.length;i++){
        nod=winodesArr[i].trim();
        if( nod.length==0)continue;
        var idx=href.indexOf(nod);
        if(idx>=0){
            myurl[1]=href.substr(idx);
            break;
        }
    }
    var curhref=""+ window.location.href;
    var idx2=curhref.indexOf(nod);
    if( idx2>=0){
        myurl[0]=curhref.substr(0,idx2);
    }
    return myurl.join("");
}





