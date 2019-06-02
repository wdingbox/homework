

var gCatsBooksDate={
"儒家":
{
"論語":"-480--350",
"孟子":"-340--250",
"禮記":"-475--221",
"荀子":"-475--221",
"孝經":"-475--221",
"說苑":"-206-+009 [西漢 (公元前206年 - 9年)] 劉向著",
"春秋繁露":"-206-+009 [西漢 (公元前206年 - 9年)] 董仲舒著",
"韓詩外傳":"-180--120 [西漢] 公元前180年-公元前120年",
"大戴禮記":"+100-+200 [東漢] 100年-200年",
"白虎通德論":"+079-+092 [東漢] 79年-92年 班固著",
"新書":"-206-+009 [西漢 (公元前206年 - 9年)] 賈誼著",
"新序":"-206-+009 [西漢 (公元前206年 - 9年)] 劉向著",
"揚子法言":"-033-+018 [西漢 - 新] 公元前33年-18年 揚雄著",
"中論":"+025-+220 [東漢 (25年 - 220年)] 徐幹著",
"孔子家語":"-206-_220 [漢 (公元前206年 - 220年)]",
"潛夫論":"+102-+167 [東漢] 102年-167年 王符著",
"論衡":"+080 [東漢] 80年 王充著",
"太玄經":"-033-+018 [東漢] 公元前33年-18年 揚雄著",
"風俗通義":"+190-+200 [東漢] 190年-200年",
"孔叢子":"+025-+265 [東漢 - 三國 (25年 - 265年)]",
"申鑒":"+196-+220 [東漢] 196年-220年",
"忠經":"",
"素書":"",
"新語":"",
"獨斷":"+167-+258 [東漢 - 三國] 167年-258年",
"蔡中郎集":"+152-+192 [東漢] 152年-192年",
},
"墨家":{
},
"道家":{},
"法家":{},
"名家":{},
"兵家":{},
"算書":{},
"雜家":{},
"史書":{},
"經典文獻":{},
"字書":{},
"醫學":{},
"出土文獻":{},
};////////gBooksCatDate///////
var gCatalogPreQin=Object.keys(gCatsBooksDate);
///////////////////////////////////////////////

function GetDateOfBook(bookname){
	var ret="";
	$.each(Object.keys(gCatsBooksDate),function(i,cat){
		$.each(gCatsBooksDate[cat],function(book, date){
			if(book==bookname){
				ret=date;
				return true;
			}
		});
	});
	return ret;
}




function ctxt_stats_uti(_ctxt_stats_dat){
	this. m_ctxt_stats_dat=_ctxt_stats_dat;
	this. m_booksLen={};
	this. m_keyTotFrq={};
	this. init();
	this. matrix_all();
};
ctxt_stats_uti.prototype.init=function(){
	function get_books(_this, txt){
		var lines = txt.split("\n");
		var totFrq=0;
		for(var i=0; i<lines.length; i++){
			var sline=lines[i].trim();
			if(sline.length<1)continue;
			var scol=sline.split("	");//tab
			var book=""+scol[0].replace(/\"/g,"");
			var textLength=scol[2];
			var frq=parseInt(scol[1]);
			totFrq+=frq;
			book=book.trim();
			if(book.length<=0)continue;

			_this.m_booksLen[book]=[];
			_this.m_booksLen[book].push(GetDateOfBook(book)); //date
			_this.m_booksLen[book].push(textLength);
		};
		return (totFrq/2).toFixed(0); //in the list already contains tot.
	};

	var _THIS=this;
	$.each(this.m_ctxt_stats_dat,function(key,intxt){
		var totFrq=get_books(_THIS, intxt);
		_THIS.m_keyTotFrq[key]=totFrq;
	});		
};
ctxt_stats_uti.prototype.matrix_push=function(txt){
	function get_bookFrq(txt){
		var bookFrq={};
		var lines = txt.split("\n");
		for(var i=0; i<lines.length; i++){
			var sline=lines[i].trim();
			if(sline.length<1)continue;
			var scol=sline.split("	");//tab
			if(scol.length<3)continue;
			var book=scol[0].replace(/\"/g, "");
			bookFrq[book]=scol[1];
		};
		return bookFrq;
	};
	var _booksLen=this.m_booksLen;
	$.each(_booksLen,function(book,ar){
			var bookFrq=get_bookFrq(txt);
			var frq=bookFrq[book];
			if(frq){
				_booksLen[book].push(frq);
			}
			else{
				_booksLen[book].push("0");
			}
	});
};
ctxt_stats_uti.prototype.matrix_all=function(){
	var _this=this;
	$.each(this.m_ctxt_stats_dat,function(key,intxt){
		_this.matrix_push(intxt);
	});	
};

ctxt_stats_uti.prototype.show_table_matrix=function(elid){
	function getds(ar){
		var tds="";
		$.each(ar,function(i,v){
			tds+="<td>"+v+"</td>";
		});
		return tds;
	}

	var _THIS=this;

	var keys=Object.keys(this.m_ctxt_stats_dat);
	var htds="<td>#</td><td>Book</td><td>Date</td><td>Len</td>";
	var tFrq="<td></td><td>TotFrq</td><td>-</td><td>-</td>";
	$.each(keys,function(i,k){
		htds+="<td>"+k+"</td>";
		tFrq+="<td class='fixedcol2'>"+k+"<br>"+_THIS.m_keyTotFrq[k]+"</td>";
	});



	var st="<table border='1'>";
	st+="<thead>"+htds+"</thead>";
	st+="<div class='fixedcol' click='alert'>"+tFrq+"</div>";

	st+="<tbody id='MatrixBody'>";
	$.each(this.m_booksLen,function(book,ar){
		st+="<tr>";

		var catlog='';
		if(gCatalogPreQin.indexOf(book)>=0) catlog='catlog';
		st+="<td></td><td class='"+catlog+"'>"+book+"</td>";
		st+=getds(ar);
		st+="</tr>";
	});	
	st+="</tbody></table>";
	$("#"+elid).html(st);
};

ctxt_stats_uti.prototype.show_totFrq_table=function(elid){

	var keys=Object.keys(this.m_ctxt_stats_dat);
	var htds="<td>#</td><td>Key</td><td>TotFrq</td>";

	var st="<table border='1'>";
	st+="<thead><tr>"+htds+"</tr></thead>";

	st+="<tbody>";
	$.each(this.m_keyTotFrq,function(key,totFrq){
		st+="<tr>";
		st+="<td></td><td>"+key+"</td>";
		st+="<td>"+totFrq+"</td>";
		st+="</tr>";
	});	
	st+="</tbody></table>";
	$("#"+elid).html(st);
};









