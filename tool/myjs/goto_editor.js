
function goto_editor(eid){
	goto_editor__2018(eid);
}

function goto_editor__2018(eid){
	var edurl="http://localhost/~weiding/weidroot/weidroot_2017-01-06/app/btool/tool/_edit/explore/Work_htm.htm?fname=";
	var myurl=""+document.URL;
	myurl=myurl.replace("http://localhost/~weiding","/Users/weiding/Sites/");
	myurl=myurl.replace("file://", "");
	var myedi= edurl + myurl;
    //alert(myedi);
    $("#"+eid).attr("href", myedi).attr("target","_blank");	
}
$(function(){
	$("body").click(function(){
		//$("#_MenuPanel").slideToggle("slow");
	});

	$("body").on("keydown", function(evt){
		console.log(evt.which);
		if(evt.which===72){// 'h' to toggle hide.
			$("#_MenuPanel").slideToggle("slow");
		};
	});
});/////////