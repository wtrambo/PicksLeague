var xmlHttp;

function logout() {

	xmlHttp = GetHttpXmlObject();

	if (xmlHttp == null) {
		alert("Browser does not support HTTP request");
		return;
	}

	var url = "logout.php";

	xmlHttp.onreadystatechange = logoutStateChanged;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function logoutStateChanged() {
	if ((xmlHttp.readyState == 4) || (xmlHttp.readyState == "complete")) {

		document.getElementById("welcome").style.visibility = "collapse";
		document.getElementById("welcome").innerHTML = "";

		document.getElementById("loginBox").style.visibility = "visible";
		document.getElementById("password").value = "";


	}
}
