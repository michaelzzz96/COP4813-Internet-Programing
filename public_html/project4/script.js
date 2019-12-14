function addMovie(movieID) {
	window.location.replace("./index.php?action=add&movie_id=" + movieID);
	return true;
}

function confirmCheckout() {

	var verificationCheckout = "Press Ok if you wish to check out the movies?";

	if(confirm(verificationCheckout)) {
		window.location.replace("./index.php?action=checkout");	
		return true;
	}
	else
		return false;
}

function confirmLogout() {
	var verification = "Press ok if you want to log off?";

	if (confirm(verification)) {
		window.location.replace("./logon.php?action=logoff");
		return true;
	}
	else
		return false;
}

function confirmRemove(title, movieID) {
	var verificationRemove = "Press ok if want to remove" + title + "?";
	if (confirm(verificationRemove)) {
		window.location.replace("./index.php?action=remove&movie_id=" + movieID);
		return true;	
	}
	else
		return false;
}