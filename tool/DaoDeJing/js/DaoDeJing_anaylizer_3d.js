
// http://blog.thomsonreuters.com/index.php/mobile-patent-suits-graphic-of-the-day/
var links = [
  {source: "道", target: "名", type: "licensing"},
  {source: "道", target: "HTC", type: "licensing"},
  {source: "Samsung", target: "Apple", type: "suit"},
  {source: "Motorola", target: "Apple", type: "suit"},
  {source: "Nokia", target: "Apple", type: "resolved"},
  {source: "HTC", target: "Apple", type: "suit"},
  {source: "Kodak", target: "Apple", type: "suit"},
  {source: "Microsoft", target: "Barnes & Noble", type: "suit"},
  {source: "Microsoft", target: "Foxconn", type: "suit"},
  {source: "Oracle", target: "Google", type: "suit"},
  {source: "Apple", target: "HTC", type: "suit"},
  {source: "Microsoft", target: "Inventec", type: "suit"},
  {source: "Samsung", target: "Kodak", type: "resolved"},
  {source: "LG", target: "Kodak", type: "resolved"},
  {source: "RIM", target: "Kodak", type: "suit"},
  {source: "Sony", target: "LG", type: "suit"},
  {source: "Kodak", target: "LG", type: "resolved"},
  {source: "Apple", target: "Nokia", type: "resolved"},
  {source: "Qualcomm", target: "Nokia", type: "resolved"},
  {source: "Apple", target: "Motorola", type: "suit"},
  {source: "Microsoft", target: "Motorola", type: "suit"},
  {source: "Motorola", target: "Microsoft", type: "suit"},
  {source: "Huawei", target: "ZTE", type: "suit"},
  {source: "Ericsson", target: "ZTE", type: "suit"},
  {source: "Kodak", target: "Samsung", type: "resolved"},
  {source: "Apple", target: "Samsung", type: "suit"},
  {source: "Kodak", target: "RIM", type: "suit"},
  {source: "Nokia", target: "Qualcomm", type: "suit"}
];


function Load_DaoDeJing_anaylizer_3d(){

    var nam="DaoDeJing_anaylizer_3d_";
    var suffix=[
    "KeyRelations",
    "links",
    ];

    function get_scrp(srcf){
        return "<"+"script language='javascript' src='./js/"+srcf+"'><"+"/"+"script"+">\n";
    }
    for(var i=0;i<suffix.length;i++){
        var fnam=nam+suffix[i]+".js";
        var jss=get_scrp(fnam);
        console.log(jss);
        $("head").append(jss);
    }
};
//Load_DaoDeJing_anaylizer_3d();

var mygLink=[];
function ddj_links2_d3link(){
  function strin_pairs_link(kstrin, _plinkage){
    var sp=kstrin.split(",");
    var prev=sp[0].substr(0,sp[0].indexOf(":"));
    if(prev.length===0) return;
    for(var k=1;k<sp.length;k++){
      var tar=sp[k].substr(0,sp[k].indexOf(":"));
      if(tar.length===0)continue;
      _plinkage.push({"source":prev,"target":tar,"type":"suit"});
      prev=tar;
    };
  };
  $.each(ddj_Related,function(chp,obj){
    $.each(obj,function(key,arr){
      $.each(arr,function(i,strin){
        var kstrin=key+":,"+strin;
        strin_pairs_link(kstrin,mygLink);
      });
    });
  });
};
function ddj_links2_d3link_for_compare(_plinkage, man, wdfq){
  $.each(wdfq,function(key,frq){
    _plinkage.push({"source":man,"target":key,"type":"suit"});
  });
};



function ddj_compare_two(Ar1,ar2){
  mygLink=[];
  ddj_links2_d3link_for_compare(mygLink, "hman",ddj_comp_HolyMan);
  ddj_links2_d3link_for_compare(mygLink, "dao",ddj_comp_Dao);
};



$(document).ready(function(){ 
  //ddj_links2_d3link();
  ddj_compare_two();
  $("#tout1").val("var ddj_Related="+JSON.stringify(ddj_Related,null,4));
  $("#tout2").val("var links="+JSON.stringify(mygLink,null,4));

});//










var ddj_comp_HolyMan=
{
    "不": 100,
    "之": 60,
    "以": 56,
    "人": 54,
    "其": 51,
    "為": 47,
    "而": 42,
    "天": 39,
    "無": 36,
    "是": 33,
    "聖": 33,
    "下": 32,
    "善": 28,
    "者": 28,
    "知": 26,
    "故": 25,
    "民": 19,
    "有": 18,
    "則": 18,
    "於": 17,
    "自": 15,
    "能": 13,
    "易": 11,
    "言": 11,
    "難": 10,
    "事": 10,
    "行": 10,
    "欲": 10,
    "多": 10,
    "所": 10,
    "大": 10,
    "或": 10,
    "道": 10,
    "常": 9,
    "德": 9,
    "夫": 8,
    "見": 8,
    "莫": 8,
    "信": 8,
    "病": 8,
    "相": 7,
    "成": 7,
    "物": 7,
    "心": 7,
    "令": 7,
    "復": 7,
    "吾": 7,
    "我": 7,
    "必": 7,
    "生": 6,
    "長": 6,
    "唯": 6,
    "去": 6,
    "爭": 6,
    "百": 6,
    "身": 6,
    "足": 6,
    "失": 6,
    "處": 5,
    "使": 5,
    "貴": 5,
    "得": 5,
    "可": 5,
    "治": 5,
    "此": 5,
    "棄": 5,
    "利": 5,
    "與": 5,
    "謂": 5,
    "歸": 5,
    "然": 5,
    "神": 5,
    "敗": 5,
    "正": 5,
    "國": 5,
    "餘": 5,
    "皆": 4,
    "美": 4,
    "萬": 4,
    "強": 4,
    "敢": 4,
    "地": 4,
    "猶": 4,
    "守": 4,
    "取": 4,
    "樸": 4,
    "少": 4,
    "輕": 4,
    "終": 4,
    "谷": 4,
    "執": 4,
    "傷": 4,
    "厭": 4,
    "勝": 4,
    "已": 3,
    "後": 3,
    "作": 3,
    "功": 3,
    "居": 3,
    "貨": 3,
    "盜": 3,
    "虛": 3,
    "弱": 3,
    "仁": 3,
    "姓": 3,
    "愈": 3,
    "出": 3,
    "久": 3,
    "非": 3,
    "私": 3,
    "五": 3,
    "目": 3,
    "味": 3,
    "絕": 3,
    "抱": 3,
    "全": 3,
    "式": 3,
    "重": 3,
    "君": 3,
    "用": 3,
    "器": 3,
    "甚": 3,
    "彌": 3,
    "亦": 3,
    "奇": 3,
    "滋": 3,
    "孰": 3,
    "怨": 3,
    "未": 3,
    "王": 3,
    "上": 3,
    "害": 3,
    "損": 3,
    "斯": 2,
    "惡": 2,
    "高": 2,
    "音": 2,
    "和": 2,
    "前": 2,
    "隨": 2,
    "焉": 2,
    "恃": 2,
    "弗": 2,
    "賢": 2,
    "亂": 2,
    "腹": 2,
    "也": 2,
    "芻": 2,
    "狗": 2,
    "數": 2,
    "如": 2,
    "先": 2,
    "耳": 2,
    "彼": 2,
    "智": 2,
    "巧": 2,
    "賊": 2,
    "寡": 2,
    "曲": 2,
    "直": 2,
    "明": 2,
    "彰": 2,
    "哉": 2,
    "靜": 2,
    "躁": 2,
    "日": 2,
    "離": 2,
    "雖": 2,
    "榮": 2,
    "何": 2,
    "主": 2,
    "救": 2,
    "師": 2,
    "資": 2,
    "愛": 2,
    "迷": 2,
    "谿": 2,
    "極": 2,
    "散": 2,
    "割": 2,
    "歙": 2,
    "起": 2,
    "云": 2,
    "政": 2,
    "悶": 2,
    "淳": 2,
    "察": 2,
    "缺": 2,
    "禍": 2,
    "兮": 2,
    "福": 2,
    "若": 2,
    "小": 2,
    "鬼": 2,
    "兩": 2,
    "細": 2,
    "安": 2,
    "謀": 2,
    "始": 2,
    "學": 2,
    "威": 2,
    "勇": 2,
    "恢": 2,
    "補": 2,
    "奉": 2,
    "柔": 2,
    "受": 2,
    "契": 2,
    "司": 2,
    "辯": 2,
    "博": 2,
    "既": 2,
    "己": 2,
    "短": 1,
    "較": 1,
    "傾": 1,
    "聲": 1,
    "教": 1,
    "辭": 1,
    "尚": 1,
    "實": 1,
    "志": 1,
    "骨": 1,
    "間": 1,
    "橐": 1,
    "籥": 1,
    "乎": 1,
    "屈": 1,
    "動": 1,
    "窮": 1,
    "中": 1,
    "且": 1,
    "外": 1,
    "存": 1,
    "耶": 1,
    "色": 1,
    "盲": 1,
    "聾": 1,
    "口": 1,
    "爽": 1,
    "馳": 1,
    "騁": 1,
    "田": 1,
    "獵": 1,
    "發": 1,
    "狂": 1,
    "妨": 1,
    "倍": 1,
    "義": 1,
    "孝": 1,
    "慈": 1,
    "三": 1,
    "文": 1,
    "屬": 1,
    "素": 1,
    "枉": 1,
    "窪": 1,
    "盈": 1,
    "弊": 1,
    "新": 1,
    "惑": 1,
    "一": 1,
    "伐": 1,
    "矜": 1,
    "古": 1,
    "豈": 1,
    "誠": 1,
    "根": 1,
    "輜": 1,
    "觀": 1,
    "燕": 1,
    "超": 1,
    "奈": 1,
    "乘": 1,
    "本": 1,
    "轍": 1,
    "迹": 1,
    "瑕": 1,
    "讁": 1,
    "籌": 1,
    "策": 1,
    "閉": 1,
    "關": 1,
    "楗": 1,
    "開": 1,
    "結": 1,
    "繩": 1,
    "約": 1,
    "解": 1,
    "襲": 1,
    "要": 1,
    "妙": 1,
    "雄": 1,
    "雌": 1,
    "嬰": 1,
    "兒": 1,
    "白": 1,
    "黑": 1,
    "忒": 1,
    "辱": 1,
    "乃": 1,
    "官": 1,
    "制": 1,
    "將": 1,
    "歔": 1,
    "吹": 1,
    "羸": 1,
    "挫": 1,
    "隳": 1,
    "奢": 1,
    "泰": 1,
    "戶": 1,
    "闚": 1,
    "牖": 1,
    "遠": 1,
    "名": 1,
    "在": 1,
    "渾": 1,
    "注": 1,
    "孩": 1,
    "兵": 1,
    "忌": 1,
    "諱": 1,
    "貧": 1,
    "家": 1,
    "昏": 1,
    "伎": 1,
    "法": 1,
    "化": 1,
    "好": 1,
    "富": 1,
    "倚": 1,
    "伏": 1,
    "妖": 1,
    "固": 1,
    "方": 1,
    "廉": 1,
    "劌": 1,
    "肆": 1,
    "光": 1,
    "燿": 1,
    "烹": 1,
    "鮮": 1,
    "蒞": 1,
    "交": 1,
    "報": 1,
    "圖": 1,
    "諾": 1,
    "矣": 1,
    "持": 1,
    "兆": 1,
    "脆": 1,
    "泮": 1,
    "微": 1,
    "合": 1,
    "木": 1,
    "毫": 1,
    "末": 1,
    "九": 1,
    "層": 1,
    "臺": 1,
    "累": 1,
    "土": 1,
    "千": 1,
    "里": 1,
    "從": 1,
    "幾": 1,
    "慎": 1,
    "衆": 1,
    "過": 1,
    "輔": 1,
    "江": 1,
    "海": 1,
    "樂": 1,
    "推": 1,
    "宗": 1,
    "希": 1,
    "被": 1,
    "褐": 1,
    "懷": 1,
    "玉": 1,
    "畏": 1,
    "至": 1,
    "狎": 1,
    "殺": 1,
    "活": 1,
    "應": 1,
    "召": 1,
    "來": 1,
    "繟": 1,
    "網": 1,
    "踈": 1,
    "張": 1,
    "弓": 1,
    "抑": 1,
    "舉": 1,
    "水": 1,
    "攻": 1,
    "堅": 1,
    "剛": 1,
    "垢": 1,
    "社": 1,
    "稷": 1,
    "祥": 1,
    "反": 1,
    "左": 1,
    "責": 1,
    "徹": 1,
    "親": 1,
    "積": 1
}

var ddj_comp_Dao=
{
    "之": 133,
    "不": 127,
    "道": 76,
    "而": 68,
    "以": 64,
    "其": 50,
    "有": 46,
    "者": 44,
    "為": 42,
    "天": 41,
    "無": 32,
    "大": 31,
    "德": 31,
    "人": 29,
    "物": 27,
    "故": 27,
    "知": 25,
    "下": 24,
    "名": 23,
    "善": 23,
    "若": 23,
    "於": 23,
    "是": 22,
    "曰": 20,
    "常": 18,
    "兮": 18,
    "可": 17,
    "夫": 17,
    "生": 16,
    "能": 15,
    "自": 15,
    "萬": 14,
    "謂": 14,
    "足": 14,
    "則": 13,
    "唯": 12,
    "將": 12,
    "上": 11,
    "莫": 11,
    "此": 10,
    "得": 10,
    "成": 10,
    "失": 10,
    "亦": 10,
    "地": 9,
    "欲": 9,
    "同": 9,
    "處": 9,
    "或": 8,
    "所": 8,
    "言": 8,
    "事": 8,
    "見": 8,
    "後": 8,
    "國": 8,
    "損": 8,
    "非": 7,
    "玄": 7,
    "居": 7,
    "與": 7,
    "信": 7,
    "長": 7,
    "貴": 7,
    "強": 7,
    "王": 7,
    "然": 7,
    "行": 7,
    "餘": 7,
    "矣": 7,
    "聖": 7,
    "和": 6,
    "吾": 6,
    "先": 6,
    "治": 6,
    "已": 6,
    "三": 6,
    "古": 6,
    "久": 6,
    "乃": 6,
    "慈": 6,
    "中": 6,
    "樂": 6,
    "焉": 6,
    "也": 6,
    "果": 6,
    "出": 5,
    "衆": 5,
    "用": 5,
    "子": 5,
    "象": 5,
    "惡": 5,
    "仁": 5,
    "守": 5,
    "聞": 5,
    "一": 5,
    "復": 5,
    "歸": 5,
    "容": 5,
    "孰": 5,
    "明": 5,
    "甚": 5,
    "敢": 5,
    "器": 5,
    "左": 5,
    "美": 5,
    "禮": 5,
    "始": 4,
    "兩": 4,
    "盈": 4,
    "似": 4,
    "利": 4,
    "保": 4,
    "功": 4,
    "恍": 4,
    "士": 4,
    "猶": 4,
    "樸": 4,
    "靜": 4,
    "作": 4,
    "公": 4,
    "義": 4,
    "智": 4,
    "終": 4,
    "日": 4,
    "遠": 4,
    "法": 4,
    "兵": 4,
    "取": 4,
    "勿": 4,
    "早": 4,
    "右": 4,
    "勝": 4,
    "殺": 4,
    "民": 4,
    "既": 4,
    "且": 4,
    "益": 4,
    "我": 4,
    "至": 4,
    "神": 4,
    "傷": 4,
    "勇": 4,
    "母": 3,
    "觀": 3,
    "妙": 3,
    "爭": 3,
    "動": 3,
    "視": 3,
    "夷": 3,
    "希": 3,
    "混": 3,
    "狀": 3,
    "執": 3,
    "今": 3,
    "深": 3,
    "識": 3,
    "谷": 3,
    "安": 3,
    "極": 3,
    "根": 3,
    "命": 3,
    "凶": 3,
    "殆": 3,
    "精": 3,
    "何": 3,
    "尚": 3,
    "立": 3,
    "反": 3,
    "主": 3,
    "軍": 3,
    "祥": 3,
    "小": 3,
    "止": 3,
    "恃": 3,
    "害": 3,
    "廣": 3,
    "二": 3,
    "教": 3,
    "馬": 3,
    "尊": 3,
    "服": 3,
    "固": 3,
    "積": 3,
    "肖": 3,
    "儉": 3,
    "舍": 3,
    "又": 2,
    "沖": 2,
    "淵": 2,
    "銳": 2,
    "存": 2,
    "水": 2,
    "心": 2,
    "持": 2,
    "如": 2,
    "驕": 2,
    "咎": 2,
    "身": 2,
    "退": 2,
    "聽": 2,
    "搏": 2,
    "微": 2,
    "致": 2,
    "昧": 2,
    "繩": 2,
    "惚": 2,
    "首": 2,
    "川": 2,
    "畏": 2,
    "四": 2,
    "濁": 2,
    "徐": 2,
    "虛": 2,
    "芸": 2,
    "親": 2,
    "亂": 2,
    "忠": 2,
    "臣": 2,
    "從": 2,
    "忽": 2,
    "真": 2,
    "及": 2,
    "去": 2,
    "甫": 2,
    "哉": 2,
    "朝": 2,
    "乎": 2,
    "伐": 2,
    "矜": 2,
    "在": 2,
    "食": 2,
    "逝": 2,
    "好": 2,
    "必": 2,
    "壯": 2,
    "老": 2,
    "君": 2,
    "淡": 2,
    "喪": 2,
    "戰": 2,
    "雖": 2,
    "侯": 2,
    "相": 2,
    "合": 2,
    "養": 2,
    "往": 2,
    "化": 2,
    "應": 2,
    "薄": 2,
    "華": 2,
    "愚": 2,
    "厚": 2,
    "弱": 2,
    "笑": 2,
    "建": 2,
    "進": 2,
    "形": 2,
    "氣": 2,
    "死": 2,
    "彌": 2,
    "畜": 2,
    "使": 2,
    "嗇": 2,
    "重": 2,
    "克": 2,
    "鬼": 2,
    "寶": 2,
    "難": 2,
    "多": 2,
    "�": 2,
    "�": 2,
    "式": 2,
    "恢": 2,
    "補": 2,
    "奉": 2,
    "怨": 2,
    "契": 2,
    "司": 2,
    "辯": 2,
    "博": 2,
    "己": 2,
    "愈": 2,
    "徼": 1,
    "異": 1,
    "門": 1,
    "宗": 1,
    "挫": 1,
    "解": 1,
    "紛": 1,
    "光": 1,
    "塵": 1,
    "湛": 1,
    "誰": 1,
    "帝": 1,
    "幾": 1,
    "正": 1,
    "時": 1,
    "尤": 1,
    "揣": 1,
    "金": 1,
    "玉": 1,
    "滿": 1,
    "堂": 1,
    "富": 1,
    "遺": 1,
    "遂": 1,
    "詰": 1,
    "皦": 1,
    "迎": 1,
    "隨": 1,
    "御": 1,
    "紀": 1,
    "通": 1,
    "豫": 1,
    "冬": 1,
    "涉": 1,
    "鄰": 1,
    "儼": 1,
    "渙": 1,
    "冰": 1,
    "釋": 1,
    "敦": 1,
    "曠": 1,
    "清": 1,
    "蔽": 1,
    "新": 1,
    "篤": 1,
    "並": 1,
    "各": 1,
    "妄": 1,
    "沒": 1,
    "廢": 1,
    "慧": 1,
    "偽": 1,
    "六": 1,
    "孝": 1,
    "家": 1,
    "昏": 1,
    "孔": 1,
    "窈": 1,
    "冥": 1,
    "閱": 1,
    "飄": 1,
    "風": 1,
    "驟": 1,
    "雨": 1,
    "況": 1,
    "企": 1,
    "跨": 1,
    "彰": 1,
    "贅": 1,
    "寂": 1,
    "寥": 1,
    "獨": 1,
    "改": 1,
    "周": 1,
    "字": 1,
    "域": 1,
    "佐": 1,
    "還": 1,
    "師": 1,
    "荊": 1,
    "棘": 1,
    "年": 1,
    "佳": 1,
    "恬": 1,
    "志": 1,
    "吉": 1,
    "偏": 1,
    "哀": 1,
    "悲": 1,
    "泣": 1,
    "賓": 1,
    "降": 1,
    "甘": 1,
    "露": 1,
    "令": 1,
    "均": 1,
    "制": 1,
    "譬": 1,
    "江": 1,
    "海": 1,
    "汎": 1,
    "辭": 1,
    "衣": 1,
    "平": 1,
    "餌": 1,
    "過": 1,
    "客": 1,
    "口": 1,
    "味": 1,
    "鎮": 1,
    "定": 1,
    "攘": 1,
    "臂": 1,
    "扔": 1,
    "前": 1,
    "丈": 1,
    "實": 1,
    "彼": 1,
    "勤": 1,
    "亡": 1,
    "纇": 1,
    "太": 1,
    "白": 1,
    "辱": 1,
    "偷": 1,
    "質": 1,
    "渝": 1,
    "方": 1,
    "隅": 1,
    "晚": 1,
    "音": 1,
    "聲": 1,
    "隱": 1,
    "貸": 1,
    "負": 1,
    "陰": 1,
    "抱": 1,
    "陽": 1,
    "孤": 1,
    "寡": 1,
    "穀": 1,
    "稱": 1,
    "梁": 1,
    "父": 1,
    "卻": 1,
    "走": 1,
    "糞": 1,
    "戎": 1,
    "郊": 1,
    "禍": 1,
    "戶": 1,
    "闚": 1,
    "牖": 1,
    "少": 1,
    "學": 1,
    "勢": 1,
    "育": 1,
    "亭": 1,
    "毒": 1,
    "覆": 1,
    "宰": 1,
    "介": 1,
    "施": 1,
    "徑": 1,
    "除": 1,
    "田": 1,
    "蕪": 1,
    "倉": 1,
    "文": 1,
    "綵": 1,
    "帶": 1,
    "劍": 1,
    "厭": 1,
    "飲": 1,
    "財": 1,
    "貨": 1,
    "盜": 1,
    "夸": 1,
    "含": 1,
    "比": 1,
    "赤": 1,
    "蜂": 1,
    "蠆": 1,
    "虺": 1,
    "蛇": 1,
    "螫": 1,
    "猛": 1,
    "獸": 1,
    "據": 1,
    "攫": 1,
    "鳥": 1,
    "骨": 1,
    "筋": 1,
    "柔": 1,
    "握": 1,
    "未": 1,
    "牝": 1,
    "牡": 1,
    "全": 1,
    "號": 1,
    "嗄": 1,
    "柢": 1,
    "烹": 1,
    "鮮": 1,
    "蒞": 1,
    "交": 1,
    "奧": 1,
    "市": 1,
    "加": 1,
    "棄": 1,
    "置": 1,
    "拱": 1,
    "璧": 1,
    "駟": 1,
    "坐": 1,
    "求": 1,
    "罪": 1,
    "免": 1,
    "耶": 1,
    "賊": 1,
    "福": 1,
    "順": 1,
    "皆": 1,
    "細": 1,
    "救": 1,
    "衛": 1,
    "活": 1,
    "召": 1,
    "來": 1,
    "繟": 1,
    "謀": 1,
    "網": 1,
    "踈": 1,
    "張": 1,
    "弓": 1,
    "高": 1,
    "抑": 1,
    "舉": 1,
    "賢": 1,
    "責": 1,
    "徹": 1
};

var ddj_comp_common_ar=[];
var ddj_comp_common_hman=[];
var ddj_comp_common_dao=[];

var keysHolymanAr=Object.keys(ddj_comp_HolyMan);
for(var i=0;i<keysHolymanAr.length;i++){
  var cha=keysHolymanAr[i];
  if(ddj_comp_Dao[cha]){
    ddj_comp_common_ar.push(cha);
  }else{

  }
}

function gen_link_data(){


};



