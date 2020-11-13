<?php
include "connection.php";

if(!isset($_GET['q'])){ 
  // Fetch records
  $expense_category_query = "SELECT * FROM tbl_expense_categories WHERE expense_category_status = 'Active' ORDER BY expense_category_name ASC";
}else{
  // Fetch records
  $expense_category_query = "SELECT * FROM tbl_expense_categories WHERE expense_category_status = 'Active' AND expense_category_name LIKE '%".$_GET['q']."%' ORDER BY expense_category_name ASC";
}

$expense_records = mysqli_query($conn, $expense_category_query);
$data = array();

while ($row = mysqli_fetch_assoc($expense_records)){
  $data[] = array(
    "id"         =>  $row['expense_category_id'],
    "text"       =>  $row['expense_category_name']
  );
}

echo json_encode($data); 

?>