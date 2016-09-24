var xmlHttp;

function login() {
	var username, password;

	username = document.getElementById("username").value;
	password = document.getElementById("password").value;

	xmlHttp = GetHttpXmlObject();

	if (xmlHttp == null) {
		alert("Browser does not support HTTP request");
		return;
	}

	var url = "login.php";
	url += "?username=" + username;
	url += "&password=" + password;

	xmlHttp.onreadystatechange = loginStateChanged;
	xmlHttp.open("GET", url, true);
	xmlHttp.send(null);

}

function loginStateChanged() {
	if ((xmlHttp.readyState == 4) || (xmlHttp.readyState == "complete")) {

		// successful login
		if (xmlHttp.responseText != "null") {
			document.getElementById("loginBox").style.visibility = "hidden";

			document.getElementById("welcome").innerHTML = "Welcome, " + xmlHttp.responseText + "!" + "<BR><a href=\"javascript:logout()\">Logout</a>";
			document.getElementById("welcome").style.visibility = "visible";
		}
	}
}
