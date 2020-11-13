<?php
include "connection.php";

if(!isset($_GET['q'])){ 
  // Fetch records
  $income_category_query = "SELECT * FROM tbl_income_categories WHERE income_category_status = 'Active' ORDER BY income_category_name ASC";
}else{
  // Fetch records
  $income_category_query = "SELECT * FROM tbl_income_categories WHERE income_category_status = 'Active' AND income_category_name LIKE '%".$_GET['q']."%' ORDER BY income_category_name ASC";
}

$income_records = mysqli_query($conn, $income_category_query);
$data = array();

while ($row = mysqli_fetch_assoc($income_records)){
  $data[] = array(
    "id"         =>  $row['income_category_id'],
    "text"       =>  $row['income_category_name']
  );
}

echo json_encode($data); 

?>