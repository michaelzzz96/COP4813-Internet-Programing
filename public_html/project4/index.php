<?php
session_start(); // Connect to the existing session
require_once '/home/common/mail.php'; // Add email functionality to program
processPageRequest(); // Call the processPageRequest() function

// Add the specified movie to the shopping cart
function addMovieToCart($movieID)
 {
    // Call the readMovieData() function
    $movieArray = readMovieData();  // Store the readMovieData function in a varaible (The function returuns an array of MovieID values)
    $movieArray[] = $movieID;// Store that variable as a array and Add the MovieID value to the array
    // Call the writeMovieData() function
    writeMovieData($movieArray); // Pass the array of MovieID values
    // Call the displayCart() function 
    displayCart(); 
}

// Checkout function
function checkout($name, $address) {    

    $array = readMovieData();
    require_once('templates/cart_form.html');
    

    $message = "";
	$message .= "<b>This is a receipt for the ". count($listMovie) . " movies you purchased.</b><br><br><table><tr><th><b>Poster</b></th><th><b>Title(year)</b></th></tr><br>";
    foreach($listMovie as $movie) 
    {
	    $movie = file_get_contents('http://www.omdbapi.com?apikey=b689c394&i=' . $movie . '&type=movie&r=json');
        $array = json_decode($movie, true);
        
        
        $message .= "<tr><td><img src=" .   $array['Poster'] . " height='100'></td><br>";
	    $message .= "<td><a href='https://www.imdb.com/title/" . $array["imdbID"] . "/'" . "target='_blank'>" . $array['Title'] . " " . "(" . $array['Year'] . ")" . "</a></td><br>"."<br></tr>" . "</table><br>";
	}



    //Messages Variables
    $subject = "Your Receipt from myMovies!";

    // Call the sendMail function to send an email to the user's email address
    $result = sendMail(294077619, $address, $name, $subject, $message);
   
   
    //Test value
    var_dump ($name);
    var_dump ($address);
    var_dump ($message);
    var_dump ($subject);

    // Reference Information page 13 (Warning Messages!!!)
    $messgaeCode0 = "The email message was sent succesfully";
	$messageColor = "color:#FF0000;";
	$message = "<p style= $messageColor'>$messgaeCode0</p>";

    $messageCode_1_59 = "The email message was sent succesfully";
	$messageColor = "color:#FF0000;";
	$message = "<p style= $messageColor'>$messageCode_1_59</p>";

    $messageCodeNeg1 = "The email message was sent succesfully";
	$messageColor = "color:#FF0000;";
	$message = "<p style= $messageColor'>$messageCodeNeg1</p>";

    $messageCodeNeg2 = "The email message was sent succesfully";
	$messageColor = "color:#FF0000;";
	$message = "<p style= $messageColor'>$messageCodeNeg2</p>";
  
    $messageCodeNeg3 = "The email message was sent succesfully";
	$messageColor = "color:#FF0000;";
	$message = "<p style= $messageColor'>$messageCodeNeg3</p>";


    // Test if they are right. 
    require_once('templates/cart_form.html');   
    if ($result == true) 
    {
		
		if ($result == 0){
            echo $messgaeCode0;
			
		}
        if ($result > 0 && $result < 60){
            echo $result.$messageCode_1_59;
			
		}
        if ($result == -1){
            echo $messageCodeNeg1;
			
		}
		if ($result == -2){
            echo  $messageCodeNeg2;
			
		}
        if ($result == -3){
            echo $messageCodeNeg3;
			
		}
	}
	
}

// Good
function displayCart() {    
    $movieArray = readMovieData(); // Call the readMovieData() function 
    // Use a require_once statement to the cart_form.html template file 
    require_once('templates/cart_form.html'); 
    
}

// Test whether the $_GET['action'] value was passed to the page
function processPageRequest()
{

    if (isset($_GET['action']) && !empty($_GET['action']))
     {
        // If $_GET['action'] does exist 
        if ( $_GET['action'] === 'add') // If $_GET['action']  is add, call the  addMovieToCart($_GET['movie_id']
        {
          addMovieToCart($_GET['movie_id']); // Pass the  addMovieToCart($_GET['movie_id']) to the function
          
        } 
        
        if ( $_GET['action'] === 'checkout')  // If $_GET['action']  is checkout, call the  checkout($name, $address)
        
        {

            // problem 
          checkout($_SESSION['display_name'], $_SESSION['email']); // pass the display name and email address values stored in session
        
        } 
        
         if ( $_GET['action'] === 'remove') // If  $_GET['action']  is remove, call the  removeMovieFromCart($movieID)

        {
            removeMovieFromCart($_GET['movie_id']); // pass the $_GET['action']  value to the function
           
        }
    } else 
        {
        // If $_GET['action'] doesn't exist, call the displayCart() function 
        displayCart();
        
        }
}

// Read from array
function readMovieData() {

	$Readarray = array_map('str_getcsv', file('data/cart.db'));

	if ($Readarray != null){
		$value = $Readarray[0];
	} else{
		$value = [];
	}

    return $value;
}

// Remove the specified movie to the shopping cart. 
function removeMovieFromCart($movieID) 
{
    // Call the readMovieData() 
    $moviesRead = readMovieData();
    
    $index=0;

    // Search the array the movieID
    while($i<count($moviesRead)) 
    {
        // If found
        if ($moviesRead[$index] === $movieID)
            unset($moviesRead[$index]); // Remove the value with the movieID from the array
    }
    $index++; // Keep searching

    // Call the writeMovieData function 
    writeMovieData($moviesRead);
    // Call the displayCart() function 
    displayCart();
}

// Write the array value to the cart
function writeMovieData($array) { 
    $splitString = ",";   
    $implode = implode($splitString, $array);
    file_put_contents("./data/cart.db", $implode);
}


?>
