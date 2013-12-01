<?php	// Script 13.10 - delete_quote.php
/* This script deletes a quote. */

// Define a page title and include the header:
define('TITLE', 'Delete a Quote');
include('templates/header.html');

print '<h2>Delete a Quotation</h2>';

// Restrict access to administrators only:
if (!is_administrator()) {
	
	print '<h2>Access Denied</h2>
	<p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
	
} // end of if statement to check if user has access

// Need the database connection:
include('includes/mysql_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0 ) ) {	
	
	// Display the quote in a form:
	
	// Define the query:
	$query = "SELECT quote, source, favorite FROM quotes WHERE quote_id={$_GET['id']}";
	if ($r = mysql_query($query,$dbc)) {	// Run the query
		
		$row = mysql_fetch_array($r);	// Retrieve the information
		
		// Make the form
		print '<form action="delete_quote.php" method="post">
			   <p>Are you sure you want to delete this quote?</p>
			   <div><blockquote>' . $row['quote'] . '</blockquote>- ' . $row['source'];
		
		// Is this a favorite?
		if ($row['favorite'] == 1) {
			
			print ' <strong>Favorite!</strong>';
			
		} // end of if statement to check if this is a favorite quote of the user
		
		print '</div><br /><input type="hidden" name="id" value="' . $_GET['id'] . '" />
		<p><input type="submit" name="submit" value="Delete this Quote!" /></p>
		</form>';
		
	} else {	// Couldn't get the information.
		
		print '<p class="error">Could not retrieve the quote because:<br />' . mysql_error($dbc) .
		'.</p><p>The query being run was: ' . $query . '</p>';
		
	} // end of if/else statement to run the query and build the form
	
} elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0) ) {	// Handle the form
	
	// Define the query:
	$query = "DELETE FROM quotes WHERE quote_id={$_POST['id']} LIMIT 1";
	$r = mysql_query($query, $dbc);	// Execute the query
	
	// Report on the result
	if (mysql_affected_rows($dbc) == 1) {
		
		print '<p>The quote entry has been deleted.</p>';
		
	} else {
		
		print '<p class="error">Could not delete the blog entry because:<br />' . mysql_error($dbc) .
		'.</p><p>The query being run was: ' . $query . '</p>';
		
	} // end of if/else statement to validate query ran successfully
	
} else {	// No ID received
	
	print '<p class="error">This page has been access in error.</p>';
	
} // end of main if statement

mysql_close($dbc);		// Close the connection

include('templates/footer.html');

?>
