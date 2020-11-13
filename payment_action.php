<?php
//payment_action.php
include "connection.php";
session_start();

$output = '';
if(isset($_POST["action"])){

  // Fetch all payment methods
  if($_POST["action"] == "payment_fetch"){

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
      $search_query = " and (payment_id LIKE '%".$search_value."%'
                            OR payment_name LIKE '%".$search_value."%'
                            OR payment_status LIKE '%".$search_value."%' ) ";
    }

    // Total number of records without filtering
    $sql_payment = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_payments");
    $records = mysqli_fetch_assoc($sql_payment);
    $total_records = $records['allcount'];

    // Total number of records with filtering
    $sql_payment = mysqli_query($conn,"SELECT count(*) AS allcount FROM tbl_payments WHERE 1 ".$search_query);
    $records = mysqli_fetch_assoc($sql_payment);
    $total_record_with_filter = $records['allcount'];

    // Fetch records
    $payment_query = "SELECT * FROM tbl_payments WHERE 1 ".$search_query." ORDER BY ".$column_name." ".$column_sort_order." LIMIT ".$row.",".$row_per_page;

    $payment_records = mysqli_query($conn, $payment_query);
    $data = array();

    while ($row = mysqli_fetch_assoc($payment_records)){

      $status = '';
      if ($row["payment_status"] == "Active"){
        $status = '<label class="badge badge-success">Active</label>';
      } else if ($row["payment_status"] == "Inactive"){
        $status = '<label class="badge badge-danger">Inactive</label>';
      }

      $data[] = array(
        "payment_id"               =>  $row['payment_id'],
        "payment_name"             =>  $row['payment_name'],
        "payment_status"           =>  $status,
        "action"                   =>  '<button type="button" class="btn btn-secondary view_payment btn-sm" data-toggle="modal" data-target="#readModal" id="'.$row['payment_id'].'"><i class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-success update_payment btn-sm" id="'.$row['payment_id'].'"><i class="fas fa-edit"></i></button>'
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

  // Add payment method
  if($_POST["action"] == "add_payment"){

    // Check if payment method already exists.
    $sql = "SELECT * FROM tbl_payments WHERE payment_name = '".$_POST["payment_name"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "INSERT INTO tbl_payments (payment_created_by,
                                    payment_name,
                                    payment_status,
                                    payment_created_at)
                            VALUES('".$_SESSION["user_id"]."',
                                  '".$_POST["payment_name"]."',
                                  '".$_POST["status"]."',
                                  NOW())";

      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' New payment method has been successfully added.'
        );
      }  
    }

    echo json_encode($output);

  }

  // Single fetch
  if($_POST["action"] == "single_fetch"){

    $sql = "SELECT paym.payment_id,
              paym.payment_name,
              paym.payment_status,
              user_1.user_full_name,
              paym.payment_created_at,
              paym.payment_updated_at,
              user_2.user_full_name
            FROM tbl_payments AS paym
            INNER JOIN tbl_users AS user_1
            ON paym.payment_created_by = user_1.user_id 
            LEFT JOIN tbl_users AS user_2
            ON paym.payment_last_update_by = user_2.user_id
            WHERE paym.payment_id = '".$_POST["payment_id"]."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);

    $output = array(
          "payment_id"		                => $row[0],
          "payment_name"		              => $row[1],
          "payment_status"		            => $row[2],
          "payment_created_by"            => $row[3],
          "payment_created_at"            => $row[4],
          "payment_updated_at"            => $row[5],
          "payment_last_update_by"        => $row[6]
    );

    echo json_encode($output);

  }

  // Update payment method
  if($_POST["action"] == "update_payment"){

    // Check if payment method already exists.
    $sql = "SELECT * FROM tbl_payments WHERE payment_name = '".$_POST["payment_name"]."' AND payment_id != '".$_POST["payment_id"]."'";
    $result = mysqli_query($conn, $sql);
    $check_rows = mysqli_num_rows($result);

    if($check_rows > 0) {
      $output = array(
        'status'          =>	'error',
      );
    } else {
      $sql = "UPDATE tbl_payments SET payment_last_update_by = '".$_SESSION["user_id"]."',
                                                payment_name = '".$_POST["payment_name"]."',
                                                payment_status = '".$_POST["status"]."',
                                                payment_updated_at = NOW()
                                              WHERE payment_id = '".$_POST["payment_id"]."'";
      if(mysqli_query($conn, $sql)){
        $output = array(
          'status'          => 'success',
          'message'         => ' Payment information has been successfully updated.'
        );
      }
    }
    echo json_encode($output);
  }
}
?>