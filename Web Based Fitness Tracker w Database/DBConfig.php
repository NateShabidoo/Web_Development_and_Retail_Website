//This is the config file used to connect user to the database on host site (local host here)
<?php
/*For My LocalPC*/
// this is using Xampp to run the database, a similar file also works on www.justnormalworkingstudents.com for software engineering team project
$con = mysqli_connect("localhost","root","") OR die("cannot connect3");
mysqli_select_db($con, 'fitness_tracker');
?>
