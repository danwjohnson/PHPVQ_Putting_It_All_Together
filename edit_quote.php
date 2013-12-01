<?php	// Script 13.9 - edit_quote.php
/* This script edits a quote. */

// Define a page title and include the header:
define('TITLE', 'Edit a Quote');
include('templates/header.html');

print '<h2>Edit a Quotation</h2>';

// Restrict access to administrators only:
if (!is_administrator()) {
	
	print '<h2>Access Denied!</h2>
	<p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
	
} // end of if statement to check if user has access to the page.

// Need the database connection
include('includes/mysql_connect.php');

// Display the entry in a form
if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0 ) ) {
	
	// Define the query
	$query = "SELECT quote, source, favorite FROM quotes WHERE quote_id={$_GET['id']}";
	
	if ($r = mysql_query($query, $dbc)) {	// Run the query
		
		$row = mysql_fetch_array($r);	// Retrieve the information
		
		// Make the form:
		print '<form action="edit_quote.php" method="post">
			<p><label>Quote <textarea name="quote" rows="5" cols="30">' . htmlentities($row['quote']) . '</textarea></label></p>
			<p><label>Source <input type="text" name="source" value="' .htmlentities($row['source']) .'" /></label></p>
			<p><label>Is this a favorter? <input type="checkbox" name="favorite" value="yes"';
		
		// Check the box if it is a favorite:
		if ($row['favorite'] == 1) {
			
			print ' checked="checked"';
			
		} // end of if to check if the quote is a favorite
		
		// Complete the form:
		print ' /></label></p>
			<input type="hidden" name="id" value="' . $_GET['id'] . '" />
			<p><input type="submit" name="submit" value="Update This Quote!" /></p></form>';
		
	} else {	// Couldn't get the information
		
		print '<p class="error">Could not retrieve the quotation because:<br />' . mysql_error($dbc) .
			'.</p><p>The query being run was: ' . $query . '</p>';
		
	} // end of if statement to check if the query was run and if it was successful
	
} elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0 ) ) {	// Handle the form
	
	// Validate and secure the form data
	$problem = FALSE;
	if ( !empty($_POST['quote']) && !empty($_POST['source']) ) {
		
		// Prepare the values for storing:
		$quote = mysql_real_escape_string(trim(strip_tags($_POST['quote'])), $dbc);
		$source = mysql_real_escape_string(trim(strip_tags($_POST['source'])), $dbc);
		
		// Create the "favorite" value:
		if (isset($_POST['favorite'])) {
			
			$favorite = 1;
			
		} else {
			
			$favorite = 0;
			
		} // end if if statement to set the favorite variable
		
	} else {
		
		print '<p class="error">Please submit both a quotation and a source.</p>';
		$problem = TRUE;
		
	}	// end of if/else statement to validate and secure the form
	
	if (!$problem) {
		
		// Define the query
		$query = "UPDATE quotes SET quote='$quote', source='$source', favorite=$favorite
				  WHERE quote_id={$_POST['id']}";
		if ($r = mysql_query($query, $dbc)) {
			
			print '<p>The quotation has been updated.</p>';
			
		} else {
			
			print '<p class="error">Could not update the quotation because:<br />' .
					mysql_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
			
		} // end of if/else statement to define and run the update query
		
	} // No problem!
	
} else {	// No ID set
	
	print '<p class="error">This page has been accessed in error.</p>';
	
} // end of main if statement

mysql_close($dbc);	// Close the connection

include('templates/footer.html');	// Include the footer

?>