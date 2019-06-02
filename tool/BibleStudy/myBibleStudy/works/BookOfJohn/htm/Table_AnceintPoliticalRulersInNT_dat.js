function ModernHistory_gen_trs(){
	var s="";
	$.each(ModernHistory,function(k,arr){
		s+="<tr>";
		s+="<td></td><td>"+k+"</td>";
		s+="<td>"+arr[0]+"</td>";
		s+="<td>"+arr[1]+"</td>";
		s+="</tr>";
	});
	return s;
}

var ModernHistory={
"1456":["First movable metal printed Bible, by Johann Gutenburg"," Vulgate Latin version of St. Jerome from 4th ceuntury. Among original 200 copies, current exists 51 with 21 full text. 42 lines per page; total 1286 pages in two volumes; took 3 years to finish. "],
"1517":["Martin Luther","2nd schism of Catholics, Reformist"],
"1054":["East Orthdox","1st schism of Catholics"],
"1643-1727":["Isaac Newton","Scientist"],
"1564-1642":["Galileo Galilei","Scientist"],
"1571-1630":["Johannes Kepler","Scientist"],
"1596-1650":["René Descartes","Philosophist"],
"1452-1519":["Leonardo da Vinci","Painter"],
"1853-1890":["Vincent van Gogh","Painter"],
"1564-1616":["William Shakespeare","English Writer"],
"1879-1955":["Albert Einstein","Scientist"],
"1770-1827":["Ludwig van Beethoven","composer"],
"1685-1750":["Johann Sebastian Bach","composer"],
"1797-1828":["Franz Schubert","composer"],
"1810-1849":["Frédéric Chopin","composer"],
"1809-1882":["Charles Darwin","Scientist"],
"1822-1884":["Gregor Mendel","Scientist"],
"1856-1939":["Sigmund Freud","psychoanalysis"],

};

