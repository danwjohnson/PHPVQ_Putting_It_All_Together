<?php	// Script 13.6 - logout.php
/* This is the logout page.  It destroys the cookie. */

// Destroy the cookie, but only if it already exists:
if (isset($_COOKIE['Dan'])) {
	
	setcookie('Dan', FALSE, time()-300);
	
}

// Define a page titele and include the header
define('TITLE', 'Logout');
include('templates/header.html');

// Print a message:
print '<p>You are now logged out.</p>';

// Include the footer:
include('templates/footer.html');

?>
