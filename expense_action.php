<?php
//expense_action.php
include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all incomes
  if($_POST["action"] == "expense_fetch"){

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
      $search_query = " and (expense_id LIKE '%".$search_value."%'
                            OR expense_date LIKE '%".$search_value."%'
                            OR expense_description LIKE '%".$search_value."%'
                            OR expense_amount LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_provider = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_expenses");
    $records = mysqli_fetch_assoc($sql_provider);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_provider = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_expenses WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_provider);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $expense_query="SELECT expe.expense_id,
                          expe.expense_date,
                          expe.expense_description,
                          expe.expense_amount,
                          category.expense_category_name,
                          prov.provider_full_name,
                          paym.payment_name
                        FROM tbl_expenses AS expe
                        INNER JOIN tbl_expense_categories AS category
                        ON expe.expense_category_id = category.expense_category_id 
                        INNER JOIN tbl_providers AS prov
                        ON expe.provider_id = prov.provider_id
                        INNER JOIN tbl_payments AS paym
                        ON expe.payment_id = paym.payment_id 
                        WHERE 1 ".$search_query." ORDER BY ".$column_name." 
                        ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $provider_records = mysqli_query($conn, $expense_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($provider_records)){
      $action_button = '';
      if($_SESSION['user_role']=="Admin"){
        $action_button = '<button type="button" class="btn btn-secondary view_expense_information btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['expense_id'].'"><i class="fas fa-eye"></i></button>
        <button type="button" class="btn btn-success update_expense_information btn-sm" id="'.$row['expense_id'].'"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger delete_expense_information btn-sm" id="'.$row['expense_id'].'"><i class="fas fa-trash"></i></button>';
      }else{
        $action_button = '<button type="button" class="btn btn-secondary view_expense_information btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['expense_id'].'"><i class="fas fa-eye"></i></button>
        <button type="button" class="btn btn-success update_expense_information btn-sm" id="'.$row['expense_id'].'"><i class="fas fa-edit"></i></button>';
      }

      $data[] = array(
        "expense_id"               =>  $row['expense_id'],
        "expense_date"             =>  $row['expense_date'],
        "expense_description"      =>  $row['expense_description'],
        "expense_amount"           =>  '$'.number_format($row['expense_amount']),
        "expense_category_name"    =>  $row['expense_category_name'],
        "provider_full_name"       =>  $row['provider_full_name'],
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

  // Add provider
  if($_POST["action"] == "add_expense"){
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

    $expense_sql = "INSERT INTO tbl_expenses (expense_created_by,
                                  expense_date,
                                  expense_description,
                                  expense_amount,
                                  expense_category_id,
                                  provider_id,
                                  payment_id,
                                  file_id,
                                  expense_note,
                                  expense_created_at)
                          VALUES('".$_SESSION["user_id"]."',
                                '".$_POST["date"]."',
                                '".$_POST["description"]."',
                                '".$_POST["amount"]."',
                                '".$_POST["expense_category_id"]."',
                                '".$_POST["provider_id"]."',
                                '".$_POST["payment_id"]."',
                                '$file_id',
                                '".$_POST["note"]."',
                                NOW())";

    if(mysqli_query($conn, $expense_sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' New expense has been successfully added.'
      );
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT exp.expense_id,
              exp.expense_category_id,
              exp.provider_id,
              exp.payment_id,
              categ.expense_category_name,
              prov.provider_full_name,
              paym.payment_name,
              fil.file_storage_path,
              exp.expense_date,
              exp.expense_description,
              exp.expense_amount,
              exp.expense_note,
              user_1.user_full_name,
              exp.expense_created_at,
              user_2.user_full_name,
              exp.expense_updated_at
            FROM tbl_expenses AS exp
            INNER JOIN tbl_users AS user_1
            ON exp.expense_created_by = user_1.user_id
            INNER JOIN tbl_expense_categories AS categ
            ON exp.expense_category_id=categ.expense_category_id
            INNER JOIN tbl_providers AS prov
            ON exp.provider_id=prov.provider_id
            INNER JOIN tbl_payments AS paym
            ON exp.payment_id=paym.payment_id
            LEFT JOIN tbl_files AS fil
            ON exp.file_id=fil.file_id
            LEFT JOIN tbl_users AS user_2
            ON exp.expense_last_update_by = user_2.user_id
            WHERE exp.expense_id = '".$_POST["expense_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "expense_id"		           =>	$row[0],
          "expense_category_id"		   =>	$row[1],
          "provider_id"		           =>	$row[2],
          "payment_id"		           =>	$row[3],
          "expense_category_name"		 =>	$row[4],
          "provider_full_name"		   => $row[5],
          "payment_name"		         => $row[6],
          "file_storage_path"        => $row[7],
          "expense_date"		         => $row[8],
          "expense_description"      => $row[9],
          "expense_amount"		       => $row[10],
          "expense_note"             => $row[11],
          "expense_created_by"       => $row[12],
          "expense_created_at"       => $row[13],
          "expense_last_update_by"   => $row[14],
          "expense_updated_at"       => $row[15]
    );

    echo json_encode($output);

  }

  // Update expense information
  if($_POST["action"] == "update_expense"){

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

      $sql = "UPDATE tbl_expenses SET expense_last_update_by = '".$_SESSION["user_id"]."',
                              expense_date = '".$_POST["date"]."',
                              expense_description = '".$_POST["description"]."',
                              expense_amount = '".$_POST["amount"]."',
                              expense_category_id = '".$_POST["expense_category_id"]."',
                              provider_id = '".$_POST["provider_id"]."',
                              payment_id = '".$_POST["payment_id"]."',
                              file_id = '$file_id',
                              expense_note = '".$_POST["note"]."',
                              expense_updated_at = NOW()
                            WHERE expense_id = '".$_POST["expense_id"]."'";

      $output = array(
        'status'          => 'success',
        'message'         => $file_id
      );

    } else {
      $sql = "UPDATE tbl_expenses SET expense_last_update_by = '".$_SESSION["user_id"]."',
                              expense_date = '".$_POST["date"]."',
                              expense_description = '".$_POST["description"]."',
                              expense_amount = '".$_POST["amount"]."',
                              expense_category_id = '".$_POST["expense_category_id"]."',
                              provider_id = '".$_POST["provider_id"]."',
                              payment_id = '".$_POST["payment_id"]."',
                              expense_note = '".$_POST["note"]."',
                              expense_updated_at = NOW()
                            WHERE expense_id = '".$_POST["expense_id"]."'";
    }

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'          => 'success',
        'message'         => ' Expense information has been successfully updated.'
      );
    }

    echo json_encode($output);

  }

  // Delete expense information
  if($_POST["action"] == "delete_expense"){
    $sql = "DELETE FROM tbl_expenses WHERE expense_id = '".$_POST["expense_id"]."'";

    if(mysqli_query($conn, $sql)){
      $output = array(
        'status'        => 'success',
        'message'	    	=> ' Expense information has been deleted successfully.',
      );
    }

    echo json_encode($output);

  }
}
?>