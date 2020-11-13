<?php
//income_action.php
include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all incomes
  if($_POST["action"] == "income_fetch"){

    // Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $row_per_page = $_POST['length'];
    $column_index = $_POST['order'][0]['column'];
    $column_name = $_POST['columns'][$column_index]['data'];
    $column_sort_order = $_POST['order'][0]['dir'];
    $search_value = $_POST['search']['value'];

    // Search
    $search_query = " ";
    if($search_value != ''){
      $search_query = " and (income_id LIKE '%".$search_value."%'
                            OR income_date LIKE '%".$search_value."%'
                            OR income_description LIKE '%".$search_value."%'
                            OR income_amount LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_income = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_income");
    $records = mysqli_fetch_assoc($sql_income);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_income = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_income WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_income);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $income_query="SELECT inco.income_id,
                          inco.income_date,
                          inco.income_description,
                          inco.income_amount,
                          category.income_category_name,
                          cust.customer_full_name,
                          paym.payment_name
                        FROM tbl_income AS inco
                        INNER JOIN tbl_income_categories AS category
                        ON inco.income_category_id = category.income_category_id 
                        INNER JOIN tbl_customers AS cust
                        ON inco.customer_id = cust.customer_id
                        INNER JOIN tbl_payments AS paym
                        ON inco.payment_id = paym.payment_id 
                        WHERE 1 ".$search_query." ORDER BY ".$column_name." 
                        ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $income_records = mysqli_query($conn, $income_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($income_records)){
      $action_button = '';
      if($_SESSION['user_role']=="Admin"){
        $action_button = '<button type="button" class="btn btn-secondary view_income_information btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['income_id'].'"><i class="fas fa-eye"></i></button>
        <button type="button" class="btn btn-success update_income_information btn-sm" id="'.$row['income_id'].'"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger delete_income_information btn-sm" id="'.$row['income_id'].'"><i class="fas fa-trash"></i></button>';
      }else{
        $action_button = '<button type="button" class="btn btn-secondary view_income_information btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['income_id'].'"><i class="fas fa-eye"></i></button>
        <button type="button" class="btn btn-success update_income_information btn-sm" id="'.$row['income_id'].'"><i class="fas fa-edit"></i></button>';
      }

      $data[] = array(
        "income_id"                =>  $row['income_id'],
        "income_date"              =>  $row['income_date'],
        "income_description"       =>  $row['income_description'],
        "income_amount"            =>  '$'.number_format($row['income_amount']),
        "income_category_name"     =>  $row['income_category_name'],
        "customer_full_name"       =>  $row['customer_full_name'],
        "payment_name"             =>  $row['payment_name'],
        "action"                   =>  $action_button
      );
    }

    $response = array(
      "draw"                  => intval($draw),
      "iTotalRecords"         => $total_records,
      "iTotalDisplayRecords"  => $total_record_with_filter,
      "aaData"                => $data
    );

    echo json_encode($response);

  }

  // Add income
  if($_POST["action"] == "add_income"){
    $file_id = '0';

    // Evaluate if the receipt has been uploaded.
    if($_FILES['receipt']['name'] != ''){
      $file_new_name = "receipt_".uniqid('', true).".pdf"; // Generate a new file name.
      $file_path = $_FILES['receipt']['tmp_name']; // Get the current file path.
      $storage_folder = 'files';
      $final_path = $storage_folder.'/'. $file_new_name; // Files folder.
    
      // Upload files to files' folder
      move_uploaded_file($file_path, $final_path);
    
      $file_sql = "INSERT INTO tbl_files(file_name, file_storage_path) VALUES('$file_new_name','$final_path')";  
      $result = mysqli_query($conn, $file_sql);
    
      $file_id = mysqli_insert_id($conn);
    }

    $income_sql = "INSERT INTO tbl_income (income_created_by,
                                  income_date,
                                  income_description,
                                  income_amount,
                                  income_category_id,
                                  customer_id,
                                  payment_id,
                                  file_id,
                                  income_note,
                                  income_created_at)
                          VALUES('".$_SESSION["user_id"]."',
                                '".$_POST["date"]."',
                                '".$_POST["description"]."',
                                '".$_POST["amount"]."',
                                '".$_POST["income_category_id"]."',
                                '".$_POST["customer_id"]."',
                                '".$_POST["payment_id"]."',
                                '$file_id',
                                '".$_POST["note"]."',
                                NOW())";

    if(mysqli_query($conn, $income_sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' New income has been successfully added.'
      );
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT inco.income_id,
              inco.income_category_id,
              inco.customer_id,
              inco.payment_id,
              category.income_category_name,
              custo.customer_full_name,
              paym.payment_name,
              fil.file_storage_path,
              inco.income_date,
              inco.income_description,
              inco.income_amount,
              inco.income_note,
              user_1.user_full_name,
              inco.income_created_at,
              user_2.user_full_name,
              inco.income_updated_at
            FROM tbl_income AS inco
            INNER JOIN tbl_users AS user_1
            ON inco.income_created_by = user_1.user_id
            INNER JOIN tbl_income_categories AS category
            ON inco.income_category_id=category.income_category_id
            INNER JOIN tbl_customers AS custo
            ON inco.customer_id=custo.customer_id
            INNER JOIN tbl_payments AS paym
            ON inco.payment_id=paym.payment_id
            LEFT JOIN tbl_files AS fil
            ON inco.file_id=fil.file_id
            LEFT JOIN tbl_users AS user_2
            ON inco.income_last_update_by = user_2.user_id
            WHERE inco.income_id = '".$_POST["income_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "income_id"		             =>	$row[0],
          "income_category_id"		   =>	$row[1],
          "customer_id"		           =>	$row[2],
          "payment_id"		           =>	$row[3],
          "income_category_name"		 =>	$row[4],
          "customer_full_name"		   => $row[5],
          "payment_name"		         => $row[6],
          "file_storage_path"        => $row[7],
          "income_date"		           => $row[8],
          "income_description"       => $row[9],
          "income_amount"		         => $row[10],
          "income_note"              => $row[11],
          "income_created_by"        => $row[12],
          "income_created_at"        => $row[13],
          "income_last_update_by"    => $row[14],
          "income_updated_at"        => $row[15]
    );

    echo json_encode($output);

  }

  // Update income information
  if($_POST["action"] == "update_income"){

    // Evaluate if the receipt has been uploaded.
    if($_FILES['receipt']['name']){

      $file_new_name = "receipt_".uniqid('', true).".pdf"; // Generate a new file name.
      $file_path = $_FILES['receipt']['tmp_name']; // Get the current file path.
      $storage_folder = 'files';
      $final_path = $storage_folder.'/'. $file_new_name; // Files folder.

      // Upload files to files' folder
      move_uploaded_file($file_path, $final_path);

      $file_sql = "INSERT INTO tbl_files(file_name, file_storage_path) VALUES('$file_new_name','$final_path')";  
      $result = mysqli_query($conn, $file_sql);

      $file_id = mysqli_insert_id($conn);

      $sql = "UPDATE tbl_income SET income_last_update_by = '".$_SESSION["user_id"]."',
                              income_date = '".$_POST["date"]."',
                              income_description = '".$_POST["description"]."',
                              income_amount = '".$_POST["amount"]."',
                              income_category_id = '".$_POST["income_category_id"]."',
                              income_id = '".$_POST["income_id"]."',
                              payment_id = '".$_POST["payment_id"]."',
                              file_id = '$file_id',
                              income_note = '".$_POST["note"]."',
                              income_updated_at = NOW()
                            WHERE income_id = '".$_POST["income_id"]."'";

      $output = array(
        'status'          => 'success',
        'message'         => $file_id
      );

    } else {
      $sql = "UPDATE tbl_income SET income_last_update_by = '".$_SESSION["user_id"]."',
                              income_date = '".$_POST["date"]."',
                              income_description = '".$_POST["description"]."',
                              income_amount = '".$_POST["amount"]."',
                              income_category_id = '".$_POST["income_category_id"]."',
                              income_id = '".$_POST["income_id"]."',
                              payment_id = '".$_POST["payment_id"]."',
                              income_note = '".$_POST["note"]."',
                              income_updated_at = NOW()
                            WHERE income_id = '".$_POST["income_id"]."'";
    }

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' Income information has been successfully updated.'
      );
    }

    echo json_encode($output);

  }

  // Delete income information
  if($_POST["action"] == "delete_income"){
    $sql = "DELETE FROM tbl_income WHERE income_id = '".$_POST["income_id"]."'";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'        => 'success',
        'message'	    	=> ' Income information has been deleted successfully.',
      );
    }

    echo json_encode($output);

  }
}
?>