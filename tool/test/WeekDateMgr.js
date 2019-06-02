


//
//iDayOfWeek:,0(Sun),1(Mon),2(Tue),3(Wed),4(Thu),5(Fri),6(Sat)
var WeekDateMgr=function(year, iDayOfWeek, iWeekOfYear ){
	this.set(year, iDayOfWeek, iWeekOfYear);
    this.m_iDayOfWeek=iDayOfWeek;
    this.iYear=year;
    this.m_iWeekOfYear=iWeekOfYear;
}
WeekDateMgr.prototype.set=function(year, iDayOfWeek , iWeekOfYear){
    var dd=new Date(year,0,1);
    var offset_iDayOfWeek = dd.getDay();
    console.log("offset_iDayOfWeek="+offset_iDayOfWeek+","+dd.toJSON());
    
    var idaysOfWeek=iDayOfWeek-offset_iDayOfWeek;
    if(idaysOfWeek<0) idaysOfWeek+=7;
    var idays=1+(iWeekOfYear*7)+idaysOfWeek;
	this.myDate = new Date(year, 0, idays,0,0,0,0);
}
WeekDateMgr.prototype.getArr_YYYY_MM_DD=function(){
    var iDayOfWeek=this.m_iDayOfWeek;
    var year      =this.iYear;
    var arr=[];
    for(var i=0;i<52;i++){
        this.set(year, iDayOfWeek , i);
        var str=this.getDateFormat_YYYY_MM_DD();
        console.log("WeekOfYear="+i+", iDayOfWeek="+iDayOfWeek+" :"+str);
        arr.push(str);
    }
    return arr;
}
WeekDateMgr.prototype.getDateFormat_YYYY_MM_DD=function(){
    var mm = 1+this.myDate.getMonth();
	var s=this.iYear+"-"+ mm + "-" + this.myDate.getDate();
	
	s=this.myDate.toJSON().substr(0,10)+" "+this.Week();
	return s;
}
WeekDateMgr.prototype.FindComingWeekDate=function(){
    var curr=new Date();
    var scur=curr.toJSON();
    scur=scur.replace(/-/g,"");
    var icur=parseInt(scur);
    
	var arr = this.getArr_YYYY_MM_DD();
    var stat='next';
    var TheCommingDate='';
    
	for(var i=0;i<arr.length;i++){
        var v=arr[i];
        var ss=v.replace(/-/g,'');
        var iss=parseInt(ss);
        if(iss>=icur){
            TheCommingDate=v;
            if(iss==icur)stat='now';
            break;
        }
    };
	return {status:stat,date:TheCommingDate};
}
WeekDateMgr.prototype.getMMDD=function(){
	var s=this.myDate.getMonth() + "/" + this.myDate.getDate();
	
	s=this.myDate.toJSON().substr(5,5);
	return s;
}
WeekDateMgr.prototype.getDateFormatI=function(){
	var s=this.iYear+"-"+this.myDate.getMonth() + "-" + this.myDate.getDate();
	
	s=this.myDate.toJSON().substr(5,5)+"\n"+this.Week();
	return s;
}

WeekDateMgr.prototype.Week=function(){
	var iDay = this.myDate.getDay();
	var Week=["Su", "Mo","Tu","We","Th","Fr","Sa", ];
	
	//var Week=[ "Th","Fr",  "Sa", "Su", "Mo","Tu","We",];
	return Week[iDay];
}

