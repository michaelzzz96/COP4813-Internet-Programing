<?php
session_start(); // Connect to the existing session
require_once '/home/common/mail.php'; // Add email functionality to program
require_once '/home/common/dbInterface.php'; // Add database functionality
processPageRequest(); // Call the processPageRequest() function


// Add the specified movie to the shopping cart
function addMovieToCart($movieID)
 {	
	// Store the Movie Database. Call the dbInterface.php 
	$AddMovie = movieExistsInDB($movieID); 
	
	// If movie does not exist in database, Call the API
	if ( $AddMovie === 0 ) 
	{

		$movie = file_get_contents("http://www.omdbapi.com?apikey=b689c394&i=" . $movieID . "&type=movie&r=json");
		$array = json_decode($movie, true);

		// Call the dbinterface.php function addMovie
		$AddMovie = addMovie($array['imdbID'], $array['Title'], $array['Year'], $array['imdbRating'], $array['Runtime'], $array['Genre'], $array['Actors'], $array['Director'], $array['Writer'], $array['Plot'], $array['Poster']);
	}

	// Call dbinterface.php function addMovieToShoppingCart
	addMovieToShoppingCart($_SESSION['userId'], $AddMovie); // 
	
	// Call the displayCart() function 
	 echo displayCart(); 
}

// Send a receipt to the email address. 
function checkout($display_name, $address) 
{
	
	// HTML message 
	$message = "Hi " . $display_name . ",<br />" . "<br />"." Here " . $display_name . ", this is your movie receipt:<br />".  createMovielist(true); 
	echo $message; 

	
	// Call the sendMail function
	$result = sendMail(294077619, $address, $display_name, "Your Receipt from myMovies!", $message); 		
	
	// From the notes 
	switch ($result) 
	{
		case 0:
			$display = "The email message was sent to " . $address . " check it now";
			$messageColor = "color:#00FF00;";
			$message = "<p style= $messageColor'>$display</p>";
			$_SESSION['msg'] = $message;
			echo $_SESSION['msg'];
			break;
		case ($result > 0 && $result < 60):
			$display = $result . " seconds remain before the next email can be sent";
			$messageColor = "color:#FF0000;";
			$message = "<p style= $messageColor'>$display</p>";
			$_SESSION['msg'] = $message;
			echo $_SESSION['msg'];
			break;
		case -1:
			$display = "An error occured. Email not sent";
			$messageColor = "color:#FF0000;";
			$message = "<p style= $messageColor'>$display</p>";
			$_SESSION['msg'] = $message;
			echo $_SESSION['msg'];
			break;
		case -2:
			$display = "An invalid " . $address . "  was provided (email not sent!)";
			$messageColor = "color:#FF0000;";
			$message = "<p style= $messageColor'>$display</p>";
			$_SESSION['msg'] = $message;
			echo $_SESSION['msg'];
			break;
		case -3:
			$display = "An error occured while accessing the database (email not sent!)";
			$messageColor = "color:#FF0000;";
			$message = "<p style= $messageColor'>$display</p>";
			$_SESSION['msg'] = $message;
			echo $_SESSION['msg'];
			break;
	}
	return $result;	
}

// Retrieve an array of movieID for the movies stored in the shopping cart
function createMovielist($forEmail=false)
 {
	if ( !empty($_SESSION['order']) ) 
	{
		// call getMoviesInCart
		$array = getMoviesInCart($_SESSION['userId'], $_SESSION['order']);
	}
	else if ( empty($_SESSION['order']) )
	 {
		 // call getMovieInCart
		$array = getMoviesIncart($_SESSION['userId']);
	}

	ob_start(); // Create an output buffer
	require_once './templates/movie_list.html';
	$message = ob_get_contents(); // Get contents of the output buffer
	ob_end_clean(); // Clear the output buffer
	
	return $message;
}


function displayCart($forEmail=false) 
{	
	// Call the dbInterface.php function countMoviesInCart 
	$movie_counter = countMoviesInCart($_SESSION['userId']);

	// Call createMovieList
	$array = createMovieList($forEmail);
	
	require_once('./templates/cart_form.html');
	
	// Use the following PHP Statements  to create a string containing an HTML Table


	ob_start(); // Create an output buffer
	require_once('./templates/cart_form.html');
	$message = ob_get_contents(); // Get the contents of the output buffer
	ob_end_clean(); // Clear the output buffer
	
	return $message;
}

// Need to work on....
function processPageRequest()
 {
	 // If display name value is not stored in the session
	if ( !isset($_SESSION['displayName']) )
	{
		// Call the ./logon.php 
		header('Location: ./logon.php'); 	
		die();
	}
	
	elseif ( !empty($_GET) ) 
	{
		// If GETAction is set, call the function 
		if ( isset($_GET['action']) )
		 {
			if ( $_GET['action'] == "add" ) // add 
			{ 
				addMovieToCart($_GET['movie_id']);
				echo displayCart(); 
			}
			elseif ( $_GET['action'] == "checkout" ) // checkout 
			{ 
				$result = checkout($_SESSION['displayName'], $_SESSION['emailAddress']);
				echo displayCart();
			}
			elseif ( $_GET['action'] == "remove" )  // remove 
			{	
				removeMovieFromCart($_GET['movie_id']);
				// call dispalycart()
				echo displayCart(); 
			}
			elseif ( $_GET['action'] == "update" ) // update 
			{ 

				updateMovieListing($_GET['order']); 
			}
		}
	}
	else
	{
	
		// Call the displayCart()
		echo displayCart();
	}
}

// Remove the specified from the shopping cart 
function removeMovieFromCart($movieID) 
{

	// call the function removeMovieFromShoppingCart 
	removeMovieFromShoppingCart($_SESSION['userId'], $movieID);
	// call the displayCart 
	echo displayCart();
}


// Updates the movie listed in the shopping cart in the specified order 
function updateMovieListing($order) 
{
	$_SESSION['order'] = $order;
	// createMovieList String 
	echo createMovieList(false);
		
}


?>