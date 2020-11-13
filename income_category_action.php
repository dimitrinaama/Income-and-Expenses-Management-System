<?php

//income_category_action.php

include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all income categories
  if($_POST["action"] == "income_category_fetch"){

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
      $search_query = " and (income_category_id LIKE '%".$search_value."%'
                            OR income_category_name LIKE '%".$search_value."%'
                            OR income_category_status LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_income_category = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_income_categories");
    $records = mysqli_fetch_assoc($sql_income_category);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_income_category = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_income_categories WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_income_category);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $income_category_query = "SELECT * FROM tbl_income_categories WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $income_category_records = mysqli_query($conn, $income_category_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($income_category_records)){

      $status = '';
      if ($row["income_category_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["income_category_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "income_category_id"               =>  $row['income_category_id'],
        "income_category_name"             =>  $row['income_category_name'],
        "income_category_status"           =>  $status,
        "action"                            =>  '<button type="button" class="btn btn-secondary view_income_category btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['income_category_id'].'"><i class="fas fa-eye"></i></button>
                                                 <button type="button" class="btn btn-success update_income_category btn-sm" id="'.$row['income_category_id'].'"><i class="fas fa-edit"></i></button>'
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

  // Add income category
  if($_POST["action"] == "add_income_category"){

    // Check if income category already exists.
    $sql = "SELECT * FROM tbl_income_categories WHERE income_category_name = '".$_POST["income_category"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "INSERT INTO tbl_income_categories (income_category_created_by,
                                    income_category_name,
                                    income_category_status,
                                    income_category_created_at)
                            VALUES('".$_SESSION["user_id"]."',
                                  '".$_POST["income_category"]."',
                                  '".$_POST["status"]."',
                                  NOW())";

      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' New income category has been successfully added.'
        );
      }  
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT inc.income_category_id,
              inc.income_category_name,
              inc.income_category_status,
              user_1.user_full_name,
              inc.income_category_created_at,
              inc.income_category_updated_at,
              user_2.user_full_name
            FROM tbl_income_categories AS inc
            INNER JOIN tbl_users AS user_1
            ON inc.income_category_created_by = user_1.user_id 
            LEFT JOIN tbl_users AS user_2
            ON inc.income_category_last_update_by = user_2.user_id
            WHERE inc.income_category_id = '".$_POST["income_category_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "income_category_id"		                => $row[0],
          "income_category_name"		              => $row[1],
          "income_category_status"		            => $row[2],
          "income_category_created_by"            => $row[3],
          "income_category_created_at"            => $row[4],
          "income_category_updated_at"            => $row[5],
          "income_category_last_update_by"        => $row[6]
    );

    echo json_encode($output);

  }

  // Update income category
  if($_POST["action"] == "update_income_category"){

    // Check if income category already exists.
    $sql = "SELECT * FROM tbl_income_categories WHERE income_category_name = '".$_POST["income_category"]."' AND income_category_id != '".$_POST["income_category_id"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "UPDATE tbl_income_categories SET income_category_last_update_by = '".$_SESSION["user_id"]."',
                                                income_category_name = '".$_POST["income_category"]."',
                                                income_category_status = '".$_POST["status"]."',
                                                income_category_updated_at = NOW()
                                              WHERE income_category_id = '".$_POST["income_category_id"]."'";
      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' Income category information has been successfully updated.'
        );
      }
    }
    echo json_encode($output);
  }
}
?>