var xmlHttp, cell, pick;

function changePick(cellId, homeTeam, awayTeam, week, season) {
	var currentPick, insert;

	xmlHttp = cell = pick = null;

	cell = cellId;
	currentPick = document.getElementbyId(cellId).innerHTML;
	insert = 0;

	if (currentPick == "--") {
		insert = 1;
		pick = homeTeam;
	}
	else if (currentPick == homeTeam) {
		pick = awayTeam;
	}
	else {
		pick = homeTeam;
	}

	xmlHttp = GetHttpXmlObject();

	if (xmlHttp == null) {
		alert("Browser does not support HTTP request");
		return;
	}

	var url = "makePick.php";
	url += "?season=" + season;
	url += "&week=" + week;
	url += "&homeTeam=" + homeTeam;
	url += "&awayTeam=" + awayTeam;
	url += "&pick=" + pick;
	url += "&insert=" + insert;
	url += "&username=jsneden";

	xmlHttp.onreadystatechange = stateChanged;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function GetHttpXmlObject() {
	var objXMLHttp = null;

	if (window.XmlHttpRequest) {
		objXMLHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		objXMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	return objXMLHttp;
}

function stateChanged() {
	if ((xmlHttp.readyState == 4) || (xmlHttp.readyState == "complete")) {
		if (xmlHttp.responseText == 0) {
			document.getElementById(cell).innerHTML = pick;
		}
		else {
			alert("A problem was encountered and your pick was not updated. Please try again later.");
		}
	}
}
