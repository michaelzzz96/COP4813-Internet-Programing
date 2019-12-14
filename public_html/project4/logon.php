<?php
	
	
	processPageRequest(); // Call the processPageRequest() function
	
	// Create authenticateUser function (Done)
	function authenticateUser($username, $password) // Test whether the user entered valid login credentials 
	 {
		
		// Read the data from the file from the credentials database file
		$DBfile = file_get_contents("data/credentials.db");
		// Parse the file into an array containing the 4 values 
		$splitString = ","; 
		// Split the string into different strings. 
		$SplitData= explode($splitString , $DBfile);
  
		// Compare the username and password values obtained from the from the data files stored in username and password variables 
		if ($SplitData[0] === $username && $SplitData[1] === $password) // If strings match 
		 {	
			
			// Create a Session
			session_start();	
			

			$_SESSION['display_name'] = $SplitData[2];
			$_SESSION['email'] = $SplitData[3];
			
			// Redirect the browser to the Index Page (It Work!!!)
			header('Location: ./index.php'); 
			
			return;

		} 
		else 
		{
			
			$display = "Enter the Correct Username and Password!";
			$messageColor = "color:#FF0000;";
			$message = "<p style= $messageColor'>$display</p>";
			displayLoginForm($message);
			return;
		} 
	
	}
  

	// Done
	function displayLoginForm($message = "") 
	{	
		echo $message; // Display an error message
		//Using require_once state to include the logon_form.html template file via 
		require_once("./templates/logon_form.html"); // via call logon_form.html from the templates folder
	}
  
  

	// Process page request. Works
	function processPageRequest() 
	{
		
		session_destroy();

		if ( isset($_POST["username"]) && !empty($_POST["username"])
		&& isset($_POST["password"]) && !empty($_POST["password"]) )
		
		{
			authenticateuser($_POST['username'], $_POST['password']);
		}
		
		else 
			displayLoginForm();
	} 
	
	?>

