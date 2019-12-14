
// Good
function addMovie(movieID) 
{
	window.location.replace("./index.php?action=add&movie_id=" + movieID);
	return true;
	
}

// Good
function confirmCancel(form) 
{
	 if (form === document.getElementById("search") ){
		window.location.replace("./index.php");
	 } 
	 else{
		window.location.replace("./logon.php");
	 }
		return true;
}

// Good
function changeMovieDisplay()
 {
	var value = Number(document.getElementById("select_order").value);
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function()
	 {
		document.getElementById("shopping_cart").innerHTML = this.responseText;	
	};

	xhttp.open("GET", "./index.php?action=update&order=" + value, true);
	xhttp.send();
}

// Good
function confirmCheckout() 
{

	var verificationCheckout = "Press Checkout if you wish to check out the movies?";

	if(confirm(verificationCheckout)) 
	{
		window.location.replace("./index.php?action=checkout");	
		return true;
	}
	else
		return false;
}

// Good
function confirmLogout() {
	var verification = "Press ok if you want to log off?";

	if (confirm(verification)) {
		window.location.replace("./logon.php?action=logoff");
		return true;
	}
	else
		return false;
}


// Good
function confirmRemove(title, movieID) {
	var verificationRemove = "Press ok if want to remove " + title + "?";
	if (confirm(verificationRemove)) {
		window.location.replace("./index.php?action=remove&movie_id=" + movieID);
		return true;	
	}
	else
		return false;
}


// Good
function displayMovieInformation(movie_id) 
{
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		document.getElementById("modalWindowContent").innerHTML = this.responseText;
		showModalWindow();
	};
	xhttp.open("GET", "./movieinfo.php?movie_id=" + movie_id, true);
	xhttp.send();
}

// Good
function forgotPassword()
 {
	window.location.replace("./logon.php?action=forgot");
	return true;
}

// Good
function showModalWindow() 
{
	var modal = document.getElementById('modalWindow');
	var span = document.getElementsByClassName("close")[0];

	span.onclick = function() 
	{
		modal.style.display = "none";
	}

	window.onclick = function(event) 
	{
		if (event.target == modal)
		 {
			modal.style.display = "none";
		}
	}
	modal.style.display = "block";
}

// Good
function validateCreateAccountForm() 
{
	var email = document.getElementById("emailAddress").value;
	var cemail = document.getElementById("cemailAddress").value;
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var cpassword = document.getElementById("cpassword").value;
	var space = /.*\s+.*/
	

	if (space.test(email)) {
		alert("Email cannot have spaces");
		return false;
	}

	if (space.test(password)) {
		alert("Password cannot have spaces");
		return false;
	}
	if (space.test(username)) {
		alert("Username cannot have spaces");
		return false;
	}

	if (email !== cemail) 
	{
		alert("Email does not match");
		return false;
	}
	
	if (password !== cpassword)
	 {
		alert("Password does not match");
		return false;
	}
	return true;
}

// Good
function validateResetPasswordForm()
 {
	var password = document.getElementById("password").value;
	var cpassword = document.getElementById("cpassword").value;
	var space = /.*\s+.*/
	
	if (space.test(password)) 
	{
		alert("Passwords cannot have spaces");
		return false;
	}


	if (password !== cpassword) 
	{
		alert("Password does not match");
		return false;
	}
}
