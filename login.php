<?php	// Script 13.5 - login.php
/* This page lets people log into the site. */

// Set two variables with default values:
$loggedin = false;
$error = false;

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	// Handle the form:
	if (!empty($_POST['email'])  && !empty($_POST['password'])) {
		
		if ( (strtolower($_POST['email']) == 'dan@example.com') &&
				($_POST['password'] == 'testpass')) {	// Correct
			
			// Create the cookie:
			setcookie('Dan', 'Johnson', time()+3600);
			
			// Indicate they are logged in:
			$loggedin = true;
			
		} else {	// Incorrect
			
			$error = 'The submitted email address and password do not match those on file!';
			
		} // end of if/else to check userid/password
		
	} else {	// Forgot a field
		
		$error = 'Please make sure you enter both an email address and a password!';
		
	} // end of if that handles the form
	
} // end of if that handles the form

// Set the page title and include the header file:
define('TITLE', 'Login');
include('templates/header.html');

// Print an error if one exists:
if ($error) {
	
	print '<p class="error">' . $error . '</p>';
	
} // end of if to check if there is an error

// Indicate the user is logged in, or show the form:
if ($loggedin) {
	
	print '<p>You are now logged in!</p>';
	
} else {
	
	print '<h2>Login  Form</h2>
	<form action="login.php" method="post">
	<p><label>Email Address <input type="text" name="email" /></label></p>
	<p><label>Password <input type="password" name="password" /></label></p>
	<p><input type="submit" name="submit" value="Log In!" /></p>
	</form>';
	
}	// End of if/else to check if user is logged in and display the form if they aren't

include('templates/footer.html');	// Need the footer

?>