if(window.innerWidth <= 600)
	exit();

var count = new Array();
var done = new Array(); done['m'] = 0; done['f'] = 0;
var slide = new Array();

var row = document.createElement("div");
row.setAttribute("class", "row");

var left = document.createElement("div");
left.setAttribute("id", "slidebox_m");
left.setAttribute("class", "transparent left");
row.appendChild(left);

var right = document.createElement("div");
right.setAttribute("id", "slidebox_f");
right.setAttribute("class", "transparent right");
row.appendChild(right);

var table = document.getElementsByClassName("table")[0];
table.insertBefore(row, table.firstChild);

for(g in slideSrc)
{
	count[g] = slideSrc[g].length;
	
	slide[g] = document.createElement("img");
	slide[g].setAttribute("id", "slide_" + g);
	slide[g].src = slideSrc[g][0];
	document.getElementById("slidebox_" + g).appendChild(slide[g]);
}

var time = 10000;
window.setInterval("move('m')", time);
window.setTimeout("move('f')", time/2);
window.setTimeout(function(){ window.setInterval("move('f')", time); }, time/2);

function move(g)
{
	done[g]++;
	if(done[g] == count[g])
		done[g] = 0;
	slide[g].src = slideSrc[g][done[g]];
}