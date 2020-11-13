<?php
include "connection.php";

if(!isset($_GET['q'])){ 
  // Fetch records
  $provider_query = "SELECT * FROM tbl_providers WHERE provider_status = 'Active' ORDER BY provider_full_name ASC";
}else{
  // Fetch records
  $provider_query = "SELECT * FROM tbl_providers WHERE provider_status = 'Active' AND provider_full_name LIKE '%".$_GET['q']."%' ORDER BY provider_full_name ASC";
}

$provider_records = mysqli_query($conn, $provider_query);
$data = array();

while ($row = mysqli_fetch_assoc($provider_records)){
  $data[] = array(
    "id"         =>  $row['provider_id'],
    "text"       =>  $row['provider_full_name']
  );
}

echo json_encode($data); 

?>
