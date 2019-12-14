<?php
 
require_once '/home/common/mail.php'; // Add email functionality
require_once '/home/common/dbInterface.php'; // Add database functionality
processPageRequest(); // Call the processPageRequest() function


//Test whether the user entered valid login credenitals. Good
function authenticateUser($username, $password) 
{
	// An array validate user information function. ID, Display Name and Email Address
	$array = validateUser($username, $password);
	
	// If the validateUser function returns an array
	if ( !empty($array) ) 
	
	{
		// Create a session
		session_start();
		$_SESSION['userId'] = $array[0]; // Store the user's data: ID, Display Name and Email Address values in the session
		$_SESSION['displayName'] = $array[1]; // Store the user's data: ID, Display Name and Email Address values in the session
		$_SESSION['emailAddress'] = $array[2]; // Store the user's data: ID, Display Name and Email Address values in the session
		// Redirect the browser to the index.php page
		header('Location: ./index.php'); 
		return;
	
	} 
	
	else 
	
	{
		// Messages 
		$display = "Credentials does not exist";
		$messageColor = "color:#FF0000;";
		$message = "<p style= $messageColor'>$display</p>";
		
		// Else if the ValidateUser returns a NULL value, create an approiate error message. 
		displayLoginForm($message); // Pass the error message 
		return;
	}

}

 

//  Store the user's account info in the database. Good 
function createAccount($username, $password, $displayName, $emailAddress)
 {
	// Call the dbInterface.php function addUser(). Store in the cred variable
	$userID = addUser($username, $password, $displayName, $emailAddress);
	
	// If the addUser is greater than 0. 
	if ( $userID > 0 ) 
	{
		// Call the sendValidationEmail()
		sendValidationEmail($userID, $displayName, $emailAddress);
		

		// Messsages
		$display = "An email has been sent to validate your account.";
		$messageColor = "color:#00FF00;";
		$message = "<p style= $messageColor'>$display</p>";
		
		// Pass the message 
		echo $message;
	}

	else 
	{
		// If the addUser returns a value of 0
		$display = "Username already exists";
		$messageColor = "color:#FF0000;";
		$message = "<p style= $messageColor'>$display</p>";

		// Pass the error message. Call the displayLoginForm($message) function. 
		displayLoginForm($message);
	}
}
 
//Call the templates to create account form.  Good 
function displayCreateAccountForm() 
{
	// Use a require_once statement
	require_once('templates/create_form.html');
}
 
//Call the templates to forgot password form.  Good 
function displayForgotPasswordForm() 
{
		// Use a require_once statement
	require_once('templates/forgot_form.html');
}
 
//Call the templates to display login  form.  Good 
function displayLoginForm($message="") 
{	
		// Use a require_once statement
	echo $message;
	require_once('templates/logon_form.html');
}

//Call the templates to display reset password form.  Good 
function displayResetPasswordForm($userId) 
{
		// Use a require_once statement
	require_once('templates/reset_form.html');
}


// processPage Request. Good 
function processPageRequest()
 {
	 // Clear all session variables
	session_destroy();	
    session_unset();
	$_SESSION = [];
 
  
	
	// Test whether any POST data was passed to the page. 

	if ( !empty($_POST) && isset($_POST['action']) ) // If the POST  action variable is set
	{	
			// Call the approiate functions

			if ( $_POST['action'] == 'create' ) // create
			{
				// Pass the approiate values provided in the POST data

				createAccount($_POST['username'], $_POST['password'], $_POST['displayName'], $_POST['emailAddress']); // createAccount()
			}

			else if ( $_POST['action'] == 'forgot' ) // Forgot
			{
				// sendForgotPasswordEmail()
				sendForgotPasswordEmail($_POST['username']);
				$display = "A password reset email has been sent to your mail";
				$messageColor = "color:#FF0000;";
				$message = "<p style= $messageColor'>$display</p>";
				
				echo $message;			
			}
			else if ( $_POST['action'] == 'login' ) // Login 
				authenticateUser($_POST['username'], $_POST['password']);

			else if ( $_POST['action'] == 'reset' ) // Rest
				resetPassword($_POST['userId'], $_POST['password']);
		
	}
	
	else if ( !empty($_GET) )  // Test if the Get[Action] is set
	{

			if ( isset($_GET['action']) )
			{
				// Pass the approiate value 
				validateAccount($_POST['username']);	
			} 

			else if ( isset($_GET['form']) ) 
			{
				if ( $_GET['form'] == 'create' ) 
				{
					// Pass the approiate value 
					displayCreateAccountForm();
					return;
				}

				else if ( $_GET['form'] == 'forgot' ) 
				{
					// Pass the approiate value 
					displayForgotPasswordForm();
					return;
				}
				else if ($_GET['form'] == 'logon')
				{
					// Pass the approiate value 
					displayLoginForm("Email with the recipt has been sent");
				}
				else if ( $_GET['form'] == 'reset' ) 
				{
					// Pass the approiate value 
					displayResetPasswordForm($_POST['userId']);
					return;
				}

				
			}
			else {
				// Call the displayLoginForm function
					displayLoginForm();
			}
	}	
	
	// If neither POST nor GET data was passed to the page
	if ( empty($_POST) ||  empty($_GET) )
	{
		// Call the displayLoginForm function
		displayLoginForm();
	}
} 
 
// Update the user's password in the database. Good
function resetPassword($userId, $password)
 {

	// Call the resetUSerPassword fucntion
	if (resetUserPassword($userId, $password) ) 
	{
		
		displayLoginForm("Password is now updated"); // the password was updated 
	} 
	else 
	{

		displayLoginForm("Something is not right with the password"); // Does not exist or the new password is the same as the old
	}
	
}
 
 // Activivate the new user's account. Need to fix
function sendForgotPasswordEmail($username) 
{
	// GetUserData function 
	$UserData =  getUserData($username);
	// Create an HTML message. Include the user's display name and process. 
	$message .= "<h1>myMovies Xpress!</h1>" ."Hi " . $UserData[1] . "," ."\n\n"."Click the link to reset your password.\n". "\n";
	//http://[server_IP_address]/~[studentID]/project5/logon.php?form=reset&user_id=[User's ID] (Include the hyperlink)
	$message .= "<a href='http://139.62.210.181/~zm42283/project5/logon.php?form=reset&user_id=" . $array[0]. "'>Reset Password</a>";
	// Create a subject 
	$subject = "Password Reset";
	// Call the sendMail function
	sendMail(294077619, $UserData[2], $UserData[1], $subject, $message);


}

// Send a message to the email address stoed in the users account. Need to fix 
function sendValidationEmail($userId, $displayName, $emailAddress) 
{
	// HTML message
	$message .= "<h1>myMovies Xpress!</h1>". "Hi " . $displayName . ",". "\n\n". "Click the link to validate/ ";
	//http://[server_IP_address]/~[studentID]/project5/logon.php?form=reset&user_id=[User's ID]
	$message .= "<a href=http://139.62.210.181/~zm42283/logon.php?action=validate&user_id=42283" . $userId . "'>Validate Email</a>";
	// Create a subject
	$subject = "Account Validation";	
	// Call the sendMail function 
	sendMail(294077619, $emailAddress, $displayName, $subject, $message);
}

// Activate the new user's account. 
function validateAccount($userId) 
{
	// Call the function activateAccount(). 
	$checkValidate = activateAccount($userId);

	if ( $checkValidate ) 
	{ 
		// Messages 
		$display = "Your account is now activated.";
		$messageColor = "color:#FF0000;";
		$message = "<p style= $messageColor'>$display</p>";
		
		
		// call the dispalyLoginForm 
		displayLoginForm($message);
	}

	else 
	{

		// Messages 
		$display = "Your account is not activated. It needs to be validated";
		$messageColor = "color:#FF0000;";
		$message = "<p style= $messageColor'>$display</p>";
	
			// call the dispalyLoginForm 
		displayLoginForm($message);
	}
}



?>
