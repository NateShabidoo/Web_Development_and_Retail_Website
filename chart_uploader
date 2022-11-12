<?php

session_start();
require 'database/config.php';
ob_start();

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
while ($row = mysqli_fetch_array($query)) {  
		$user_ID= $row['user_ID']; 
		$saved_chartsid = $user_ID;

}

/* get the name of the uploaded file */
$filename = $_POST['chart_png'];

echo('<xmp>');
print_r($_POST);
echo('</xmp>');

/* choose where to save the uploaded file */
//$chartname = uniqid(true).".png";
$chartpath = "saved_charts/".uniqid(true).".png";

$location = $chartpath;
//$location = "saved_charts/".uniqid(true).".png";

if($username!=NULL) {

$query2 = "INSERT into add_chart (chart_id, saved_charts_id, usersid) values ('$chartpath', '$saved_chartsid', '$user_ID')";
		$query_run = mysqli_query($conn,$query2);
}
				
$ifp = fopen($location, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $filename );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 
        	
?>
