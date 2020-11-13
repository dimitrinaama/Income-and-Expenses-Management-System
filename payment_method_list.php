<?php
include "connection.php";

if(!isset($_GET['q'])){ 
  // Fetch records
  $payment_method_query = "SELECT * FROM tbl_payments WHERE payment_status = 'Active' ORDER BY payment_name ASC";
}else{
  // Fetch records
  $payment_method_query = "SELECT * FROM tbl_payments WHERE payment_status = 'Active' AND payment_name LIKE '%".$_GET['q']."%' ORDER BY payment_name ASC";
}

$payment_method_records = mysqli_query($conn, $payment_method_query);
$data = array();

while ($row = mysqli_fetch_assoc($payment_method_records)){
  $data[] = array(
    "id"         =>  $row['payment_id'],
    "text"       =>  $row['payment_name']
  );
}

echo json_encode($data); 

?>
