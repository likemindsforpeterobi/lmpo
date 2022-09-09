<?php 
// Include the configuration file:
require ('includes/config.php'); 

// Set the page title and include the HTML header:
$page_title = 'Edit Users &rarr;'.APP_NAME;
$page_name = '<h2 class="btn btn-primary">Edit A User</h2>';
include ('includes/header.php');
//Redirect invalid user
if (!isset($_SESSION['user_id'])) {	
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.	
}

//Redirect invalid admin
if ($_SESSION['user_level'] !=10) {	
	$url = BASE_URL . 'exams/index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.	
}

echo '<h1>Edit a User</h1><hr/>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.php'); 
	exit();
}

require (MYSQL); 

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	// Check for a user level:
	if (empty($_POST['user_level'])) {
		$errors[] = 'You forgot to enter user level.';
	} else {
		$ul = mysqli_real_escape_string($dbc, trim($_POST['user_level']));
	}

	// Check for payment status:
	if (empty($_POST['payment_status'])) {
		$errors[] = 'You forgot to enter user payment.';
	} else { 
		$pa = mysqli_real_escape_string($dbc, trim($_POST['payment_status']));
	}	
	
	if (empty($errors)) { // If everything's OK.
	
		//  Test for unique email address:
		$q = "SELECT user_id FROM users WHERE email='$e' AND user_id != $id";
		$r = @mysqli_query($dbc, $q);
		if (mysqli_num_rows($r) == 0) {

	// Make the query:
	$q = "UPDATE users SET first_name='$fn', last_name='$ln', email='$e', user_level ='$ul', payment_status ='$pa' WHERE user_id=$id LIMIT 1";
	$r = @mysqli_query ($dbc, $q);
	if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
	// Print a message:
		echo '<script> swal("Oops!", "This user has been edited  successfully!", "success"';	
				
			} else { // If it did not run OK.
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			}
				
		} else { // Already registered.
			echo '<p class="error">The email address has already been registered.</p>';
		}
		
	} else { // Report the errors.

		echo '<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
	
	} // End of if (empty($errors)) IF.

} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT first_name, last_name, email, user_level, payment_status FROM users WHERE user_id=$id";		
$r = @mysqli_query ($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	echo '<div class"panel-body">';
	// Create the form:
	echo '<div class"row"><form action="edit_user.php" method="post" class="col-md-6">
<p>First Name: <br/><input type="text" class="form-control" name="first_name"  value="' . $row[0] . '" /></p>
<p>Last Name: <br/><input type="text" class="form-control" name="last_name"   value="' . $row[1] . '" /></p>
<p>Email Address:<br/> <input type="text" class="form-control" name="email"  value="' . $row[2] . '"  /> </p>
<p>User Level:</strong> <br/> <input type="text" class="form-control" name="user_level" size="20" maxlength="60" value="' . $row[3] . '"  /> </p>
<p>payment_status:</strong> <br/> <input type="text" class="form-control" name="payment_status" size="20" maxlength="60" value="' . $row[4] . '"  /> </p>
<p><input type="submit" name="submit" value="Submit" class="btn btn-primary" /></p>
<input type="hidden" name="id" value="' . $id . '" />
</form></div>';
echo '</div>';

} else { // Not a valid user ID.
	echo '<script> swal("Oops!", "This page has access in error!", "error"';
}
mysqli_close($dbc);
?>

<?php
//close databse connection
include ('includes/footer.php'); 
 ?>