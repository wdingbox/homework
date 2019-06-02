var qTipTag="a";
var qTipX=-30;
var qTipY=25;
tooltip={name:"qTip",offsetX:qTipX,offsetY:qTipY,tip:null,tipData:null};
tooltip.init=function(){
var _1="http://www.w3.org/1999/xhtml";
if(!document.getElementById){
return;
}
this.tip=document.getElementById(this.name);
if(!this.tip){
this.tip=document.createElementNS?document.createElementNS(_1,"div"):document.createElement("div");
this.tip.setAttribute("id",this.name);
this.tipData=document.createElementNS?document.createElementNS(_1,"div"):document.createElement("div");
this.tipData.setAttribute("id",this.name+"Data");
this.tip.appendChild(this.tipData);
document.getElementsByTagName("body").item(0).appendChild(this.tip);
}
var a,_3;
var _4=document.getElementsByTagName(qTipTag);
for(var i=0;i<_4.length;i++){
a=_4[i];
_3=a.getAttribute("title");
if(_3){
a.setAttribute("qTipTitle",_3);
a.removeAttribute("title");
a.onmouseover=function(_6){
tooltip.show(_6,this.getAttribute("qTipTitle"));
};
a.onmouseout=function(){
tooltip.hide();
};
a.onmousemove=function(_7){
tooltip.move(_7);
};
}
}
};
tooltip.moveVP=function(x,y){
var _a=0,_b=0;
if(self.pageYOffset){
_a=self.pageXOffset;
_b=self.pageYOffset;
}else{
if(document.documentElement&&document.documentElement.scrollTop){
_a=document.documentElement.scrollLeft;
_b=document.documentElement.scrollTop;
}else{
if(document.body){
_a=document.body.scrollLeft;
_b=document.body.scrollTop;
}
}
}
var _c=1024,_d=768;
if(self.innerHeight){
if(document.body.clientWidth){
_c=document.body.clientWidth;
_d=document.body.clientHeight;
}else{
_c=self.innerWidth;
_d=self.innerHeight;
}
}else{
if(document.documentElement&&document.documentElement.clientHeight){
_c=document.documentElement.clientWidth;
_d=document.documentElement.clientHeight;
}else{
if(document.body){
_c=document.body.clientWidth;
_d=document.body.clientHeight;
}
}
}
var wx=190;
var _f=(x-this.offsetX)-_a;
var wrx=(_c+_a)-(x+this.offsetX);
if(wx<=wrx){
sx=x+this.offsetX;
}else{
if(wrx>=_f){
if(wx>wrx){
wx=wrx;
}
sx=x+this.offsetX;
}else{
if(wx>_f){
wx=_f;
}
sx=x-wx-this.offsetX;
}
}
this.tip.style.left=sx+"px";
this.tip.style.height="auto";
this.tip.style.width=wx+"px";
var hy=this.tip.offsetHeight;
var hty=(y-this.offsetY)-_b;
var hby=(_d+_b)-(y+this.offsetY);
if(hy<=hby){
sy=y+this.offsetY;
}else{
if(hby>=hty){
if(hy>hby){
hy=hby;
}
sy=y+this.offsetY;
}else{
if(hy>hty){
hy=hty;
}
sy=y-hy-this.offsetY;
}
}
this.tip.style.top=sy+"px";
this.tip.style.height=hy+"px";
};
tooltip.move=function(evt){
var _15=0,pos=0;
if(!evt){
var evt=window.event;
}
if(evt.pageX&&evt.pageY){
_15=evt.pageX;
posy=evt.pageY;
}else{
if(evt.clientX&&evt.clientY){
_15=evt.clientX+document.body.scrollLeft+document.documentElement.scrollLeft;
posy=evt.clientY+document.body.scrollTop+document.documentElement.scrollTop;
}
}
this.moveVP(_15,posy);
};
tooltip.show=function(evt,_18){
if(!this.tipData){
return;
}
this.tip.style.display="block";
this.tipData.innerHTML=_18;
if(!evt){
var evt=window.event;
}
this.move(evt);
};
tooltip.hide=function(){
if(!this.tip){
return;
}
this.tip.style.display="none";
this.tipData.innerHTML="";
};
window.onload=function(){
tooltip.init();
};

