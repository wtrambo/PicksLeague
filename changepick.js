var xmlHttp, cell, pick, showdate, style, x, y, newClass;

if (document.cookie.indexOf("showdate=yes") > -1) {
	showdate = 1;
}
else {
	showdate = 0;
}

style = "";
x = document.cookie.indexOf("style=");
if (x > -1) {
	y = document.cookie.indexOf(";", x);

	if (y > -1) {
		style = document.cookie.substring(x + 6, y);
	}
	else {
		style = document.cookie.substring(x + 6);
	}
}

function changepick(cellId, homeTeam, awayTeam, week, season, topRow) {
	var currentPick;

	xmlHttp = cell = pick = null;

	cell = cellId;
	currentPick = document.getElementById(cellId).innerHTML;

	document.getElementById(cellId).innerHTML = "...";

	if (currentPick == homeTeam) {
		pick = awayTeam;
	}
	else {
		pick = homeTeam;
	}

	if (showdate) {
		newClass = "pickbig ";
	}
	else {
		newClass = "picklittle ";
	}

	if (document.getElementById(cellId).className.search('self') != -1) {
		newClass += 'self ';
	}

	if (topRow) {
		//newClass += "top ";
	}

	newClass += "changed";

	xmlHttp = GetHttpXmlObject();

	if (xmlHttp == null) {
		alert("Browser does not support HTTP request");
		return;
	}

	var url = "makepick.php";
	url += "?season=" + season;
	url += "&week=" + week;
	url += "&homeTeam=" + homeTeam;
	url += "&awayTeam=" + awayTeam;
	url += "&pick=" + pick;

	xmlHttp.onreadystatechange = changePickStateChanged;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function GetHttpXmlObject() {
	var objXMLHttp = null;

	if (window.XMLHttpRequest) {
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	return objXMLHttp;
}

function changePickStateChanged() {
	if ((xmlHttp.readyState == 4) || (xmlHttp.readyState == "complete")) {
		if (xmlHttp.responseText === "success") {
			document.getElementById(cell).className = newClass;
			document.getElementById(cell).innerHTML = pick;
			//bg(cell, 230, 230, 230);
		}
		else {
			alert("A problem was encountered and your pick was not updated.\n\n" + xmlHttp.responseText);
		}
	}
}

function bg(e, r, g, b) {
	if (r == 230) {
		document.getElementById(e).style.color = "#cc7722";
		document.getElementById(e).style.backgroundImage = "none";
	}

	if (r < 250) r += 2;
	if (g > 197) g -= 4;
	if (b > 71)  b -= 6;

	document.getElementById(e).style.backgroundColor = "rgb(" +  r + ", " + g + ", " + b + ")";

	if ((r >= 250) && (g <= 197) && (b <= 71)) {
		document.getElementById(e).style.color = "#cc7722";

		if ((style == "standard") || (style == "")) {
			document.getElementById(e).style.backgroundImage = "url('images/changed.png')";
		}

		document.getElementById(e).style.backgroundColor = "rgb(250, 197, 71)";
		document.getElementById(e).className = newClass;
		return;
	}

	setTimeout("bg('" + e + "', " + r + ", " + g + ", " + b + ")", 20);
}
