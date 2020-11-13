<?php

//expense_category_action.php

include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all expense categories
  if($_POST["action"] == "expense_category_fetch"){

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
      $search_query = " and (expense_category_id LIKE '%".$search_value."%'
                            OR expense_category_name LIKE '%".$search_value."%'
                            OR expense_category_status LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_expense_category = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_expense_categories");
    $records = mysqli_fetch_assoc($sql_expense_category);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_expense_category = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_expense_categories WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_expense_category);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $expense_category_query = "SELECT * FROM tbl_expense_categories WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $expense_category_records = mysqli_query($conn, $expense_category_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($expense_category_records)){

      $status = '';
      if ($row["expense_category_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["expense_category_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "expense_category_id"               =>  $row['expense_category_id'],
        "expense_category_name"             =>  $row['expense_category_name'],
        "expense_category_status"           =>  $status,
        "action"                            =>  '<button type="button" class="btn btn-secondary view_expense_category btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['expense_category_id'].'"><i class="fas fa-eye"></i></button>
                                                 <button type="button" class="btn btn-success update_expense_category btn-sm" id="'.$row['expense_category_id'].'"><i class="fas fa-edit"></i></button>'
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

  // Add expense category
  if($_POST["action"] == "add_expense_category"){

    // Check if expense category already exists.
    $sql = "SELECT * FROM tbl_expense_categories WHERE expense_category_name = '".$_POST["expense_category"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "INSERT INTO tbl_expense_categories (expense_category_created_by,
                                    expense_category_name,
                                    expense_category_status,
                                    expense_category_created_at)
                            VALUES('".$_SESSION["user_id"]."',
                                  '".$_POST["expense_category"]."',
                                  '".$_POST["status"]."',
                                  NOW())";

      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' New expense category has been successfully added.'
        );
      }  
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT cat.expense_category_id,
              cat.expense_category_name,
              cat.expense_category_status,
              user_1.user_full_name,
              cat.expense_category_created_at,
              cat.expense_category_updated_at,
              user_2.user_full_name
            FROM tbl_expense_categories AS cat
            INNER JOIN tbl_users AS user_1
            ON cat.expense_category_created_by = user_1.user_id 
            LEFT JOIN tbl_users AS user_2
            ON cat.expense_category_last_update_by = user_2.user_id
            WHERE cat.expense_category_id = '".$_POST["expense_category_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "expense_category_id"		                => $row[0],
          "expense_category_name"		              => $row[1],
          "expense_category_status"		            => $row[2],
          "expense_category_created_by"           => $row[3],
          "expense_category_created_at"           => $row[4],
          "expense_category_updated_at"           => $row[5],
          "expense_category_last_update_by"       => $row[6]
    );

    echo json_encode($output);

  }

  // Update expense category
  if($_POST["action"] == "update_expense_category"){

    // Check if expense category already exists.
    $sql = "SELECT * FROM tbl_expense_categories WHERE expense_category_name = '".$_POST["expense_category"]."' AND expense_category_id != '".$_POST["expense_category_id"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "UPDATE tbl_expense_categories SET expense_category_last_update_by = '".$_SESSION["user_id"]."',
                                                expense_category_name = '".$_POST["expense_category"]."',
                                                expense_category_status = '".$_POST["status"]."',
                                                expense_category_updated_at = NOW()
                                              WHERE expense_category_id = '".$_POST["expense_category_id"]."'";
      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' Expense category information has been successfully updated.'
        );
      }
    }
    echo json_encode($output);
  }
}
?>