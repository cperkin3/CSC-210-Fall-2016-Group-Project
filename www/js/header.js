

/* Function to show correct header bar depending on if user is logged in */
function showHeader() {
	var divIn = document.getElementById('logged-in');
	var divOut = document.getElementById('logged-out');
	$(divIn).hide();
	$(divOut).hide();
	var loggedIn = false;
					
	var cookieName = "logged_in=";
	var stringVal = "";
	var x = document.cookie.split(';');
	for (var i = 0; i < x.length; i++) {
		var elem = x[i];
		while (elem.charAt(0)==' ') {
			elem = elem.substring(1);
		}
		if (elem.indexOf(cookieName) == 0) {
			stringVal = elem.substring(elem.indexOf('=')+1);
			$(divIn).show();
			loggedIn = true;
		}
	}
	if (!loggedIn) {
		$(divOut).show();
	}
					
	var nameTag = document.getElementById('welcome-name');
	nameTag.innerHTML = "Welcome, " + stringVal;
}
