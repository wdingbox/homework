var DaoDeJing_ChineseWangBi_Frq_CharGrpLen=[];

//<--script language='javascript' src=''></script-->
function Load_DaoDeJing_ChineseWangBi_Frq_CharGrpLen(){
	function get_scrp(srcf){
		return "<"+"script language='javascript' src='./js/"+srcf+"'><"+"/"+"script"+">\n";
	}
	var nam="DaoDeJing_ChineseWangBi_Frq_CharGrpLen";
	var ignor=[13,14,15,16];
	for(var i=1;i<=17;i++){
		if(ignor.indexOf(i)>=0) continue;
		var si=""+i;
		while(si.length<2){si="0"+si};
		var fnam=nam+si+".js";
		var jss=get_scrp(fnam);
		console.log(jss);
		$("head").append(jss);
	}
};
//autoload_CharGrpLenJs();

