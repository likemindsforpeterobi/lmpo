<?php #  mysqli_connect.php

// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.
// Author: JOShua Ekpe
// September 29, 2018

// Set the database access information as constants:
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'national');
DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '123TopBillionaire#$$');


// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');