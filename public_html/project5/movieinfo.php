<?php 

session_start(); // Connect to the existing session
require_once '/home/common/dbInterface.php'; // Add database functionality
processPageRequest(); // Call the processPageRequest() function

function createMessage($movieId) 
{
	$array = getMovieData($movieId);
	
	if ($array != NULL)
	{
	ob_start(); // Create an output buffer
	require_once './templates/movie_info.html';
	$message = ob_get_contents(); // Get the contents of the output buffer
	ob_end_clean(); // Clear the output buffer
	echo $message;
	}
}

function processPageRequest() 
{
	if (!isset ($_SESSION['displayName'] ))
	 {
		header('Location: ./logon.php');
		exit();
	}
	if ( isset($_GET) &&  isset($_GET['movie_id']) )
	 {
		createMessage($_GET['movie_id']);
		
	}
	else 
	 {
		createMessage(0);
	}
}
?>