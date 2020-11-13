<?php
include "connection.php";

if(!isset($_GET['q'])){ 
  // Fetch records
  $customer_query = "SELECT * FROM tbl_customers WHERE customer_status = 'Active' ORDER BY customer_full_name ASC";

}else{
  // Fetch records
  $customer_query = "SELECT * FROM tbl_customers WHERE customer_status = 'Active' AND customer_full_name LIKE '%".$_GET['q']."%' ORDER BY customer_full_name ASC";
}

$customer_records = mysqli_query($conn, $customer_query);
$data = array();

while ($row = mysqli_fetch_assoc($customer_records)){
  $data[] = array(
    "id"         =>  $row['customer_id'],
    "text"       =>  $row['customer_full_name']
  );
}

echo json_encode($data); 

?>
