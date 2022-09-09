<?php
require("inc/config.php");
require(MYSQL);

$state_code = 3 ;

$male="SELECT first_name, last_name FROM users WHERE gender= '1' AND state_id = $state_code";
$result_male= mysqli_query($dbc, $male) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

if (mysqli_num_rows($result_male) > 0) { // Available. 
$num_males=mysqli_num_rows($result_male);
}
$female="SELECT first_name, last_name FROM users WHERE gender = '2' AND state_id = $state_code";
$result_female= mysqli_query($dbc, $female)or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

if (mysqli_num_rows($result_female) > 0) { // Available. 
$num_females=mysqli_num_rows($result_female);
}

$data = array();
$data['male'] = $num_males ;
$data['female'] = $num_females;

$result_male->close();
$result_female->close();
mysqli_close($dbc);

print json_encode($data);
?>
