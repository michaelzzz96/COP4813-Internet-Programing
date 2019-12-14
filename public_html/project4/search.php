<?php 
session_start(); // Connect to the existing session
processPageRequest(); // Call the processPageRequest() function

// Use a require_once statement 
function displaySearchForm() {
	require_once('templates/search_form.html');
}

// Call the OMBD API 
function displaySearchResults($searchString) {

	$results = file_get_contents('http://www.omdbapi.com/?apikey=b689c394&s='.urlencode($searchString).'&type=movie&r=json');
	$array = json_decode($results, true)["Search"];
	// Use a require once
	require_once('templates/results_form.html');
}

// Call that function
function processPageRequest() {
	
	if (isset($_POST["searchString"]) && !empty($_POST["searchString"])) {
        displaySearchResults($_POST["searchString"]);
    } else {
        displaySearchForm();
    }
}
?>