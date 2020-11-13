<?php
$servername="localhost";
$username="root";
$password="";
$dbname="egm_income_and_expenses";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if(!$conn){
  die("Connection failed: ".mysqli_connect_error());
}

// echo "Connected successfully";

function load_payment_method_list($conn){
	$sql = "SELECT * FROM tbl_payments WHERE payment_status = 'Active' ORDER BY payment_name ASC";

  	$result = mysqli_query($conn, $sql);


	while($row = mysqli_fetch_assoc($result))
	{
		$output .= '<option value="'.$row["payment_id"].'">'.$row["payment_name"].'</option>';
	}
	return $output;
}

?>